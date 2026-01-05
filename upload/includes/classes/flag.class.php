<?php

class Flag extends Objects
{
    private static $flag_types = [];
    private static $flag_element_types = [];
    private static $tableName = 'flags';
    private static $tableNameElementType = 'object_type';
    private static $tableNameType = 'flag_type';

    private static $fields = [
        'flag_id',
        'id_flag_element_type',
        'id_element',
        'userid',
        'id_flag_type',
        'date_added'
    ];
    private static $fieldsElementType = [
        'id_flag_element_type',
        'name'
    ];
    private static $fieldsType = [
        'id_flag_type',
        'language_key'
    ];

    /**
     * @return array
     * @throws Exception
     */
    public static function getFlagTypes(): array
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '255')) {
            if (empty(self::$flag_types)) {
                $res = Clipbucket_db::getInstance()->_select('SELECT * FROM ' . tbl(self::$tableNameType));
                self::$flag_types = array_combine(array_column($res, 'id_flag_type'), array_column($res, 'language_key'));
            }
            return self::$flag_types;
        }
        return [];
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getFlagElementTypes(): array
    {
        if (empty(self::$flag_element_types)) {
            $res = Clipbucket_db::getInstance()->_select('SELECT * FROM ' . tbl(self::$tableNameElementType));
            self::$flag_element_types = array_combine(array_column($res, 'id_flag_element_type'), array_column($res, 'name'));
        }
        return self::$flag_element_types;
    }

    /**
     * @param $params
     * @return array|int
     * @throws Exception
     */
    public static function getAll($params)
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '255')) {
            return [];
        }
        $param_element_type = $params['element_type'] ?? false;
        $param_flag_id = $params['flag_id'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_first_only = $params['first_only'] ?? false;
        $param_group_by_type = $params['group_by_type'] ?? false;
        $param_id_flag_type = $params['id_flag_type'] ?? false;
        $param_id_element = $params['id_element'] ?? false;

        $conditions = [];
        $join = [];
        $group_by = [];
        if ($param_flag_id !== false) {
            $conditions[] = ' ' . self::$tableName . '.userid = ' . mysql_clean($param_flag_id);
        }
        if ($param_id_flag_type !== false) {
            $conditions[] = ' ' . self::$tableName . '.id_flag_type = ' . mysql_clean($param_id_flag_type);
        }
        if ($param_id_element !== false) {
            $conditions[] = ' ' . self::$tableName . '.id_element = ' . mysql_clean($param_id_element);
        }

        switch ($param_element_type) {
            case 'video':
                $join[] = ' INNER JOIN ' . tbl(Video::getInstance()->getTableName()) . ' AS ' . $param_element_type . ' ON ' . self::$tableName . '.id_flag_element_type = (SELECT id_flag_element_type FROM ' . tbl(self::$tableNameElementType) . ' WHERE name = \'video\' ) 
                    AND ' . self::$tableName . '.id_element = ' . $param_element_type . '.videoid ';
                $select_element = $param_element_type . '.title ';
                $select_is_active = 'CASE WHEN ' . $param_element_type . '.active = \'yes\' THEN 1 ELSE 0 END';
                break;

            case 'photo':
                $join[] = ' INNER JOIN ' . tbl(Photo::getInstance()->getTableName()) . ' AS ' . $param_element_type . ' ON ' . self::$tableName . '.id_flag_element_type = (SELECT id_flag_element_type FROM ' . tbl(self::$tableNameElementType) . ' WHERE name = \'photo\') 
                    AND ' . self::$tableName . '.id_element = ' . $param_element_type . '.photo_id ';
                $join[] = 'LEFT JOIN  ' . cb_sql_table(Collection::getInstance()->getTableNameItems()) . ' ON  ' . $param_element_type . '.photo_id = ' . Collection::getInstance()->getTableNameItems() . '.object_id AND ' . Collection::getInstance()->getTableNameItems() . '.type = \'photos\'';
                $select_element = $param_element_type . '.photo_title ';
                $select_orphan = ' CASE WHEN ' . Collection::getInstance()->getTableNameItems() . '.ci_id IS NULL THEN 1 ELSE 0 END AS is_photo_orphan';
                $select_is_active = 'CASE WHEN ' . $param_element_type . '.active = \'yes\' THEN 1 ELSE 0 END';
                break;

            case 'user':
                $join[] = ' INNER JOIN ' . tbl(User::getInstance()->getTableName()) . ' AS ' . $param_element_type . ' ON ' . self::$tableName . '.id_flag_element_type = (SELECT id_flag_element_type FROM ' . tbl(self::$tableNameElementType) . ' WHERE name = \'user\') 
                    AND ' . self::$tableName . '.id_element = ' . $param_element_type . '.userid ';
                $select_element = $param_element_type . '.username ';
                $select_is_active = 'CASE WHEN ' . $param_element_type . '.usr_status = \'Ok\' THEN 1 ELSE 0 END';
                break;

            case 'collection':
                $join[] = ' INNER JOIN ' . tbl(Collection::getInstance()->getTableName()) . ' AS ' . $param_element_type . ' ON ' . self::$tableName . '.id_flag_element_type = (SELECT id_flag_element_type FROM ' . tbl(self::$tableNameElementType) . ' WHERE name = \'collection\') 
                    AND ' . self::$tableName . '.id_element = ' . $param_element_type . '.collection_id ';
                $select_element = $param_element_type . '.collection_name ';
                $select_is_active = 'CASE WHEN ' . $param_element_type . '.active = \'yes\' THEN 1 ELSE 0 END';
                break;

            case  'playlist':
                $join[] = ' INNER JOIN ' . tbl(Playlist::getInstance()->getTableName()) . ' AS ' . $param_element_type . ' ON ' . self::$tableName . '.id_flag_element_type = (SELECT id_flag_element_type FROM ' . tbl(self::$tableNameElementType) . ' WHERE name = \'playlist\') 
                    AND ' . self::$tableName . '.id_element = ' . $param_element_type . '.playlist_id ';
                $select_element = $param_element_type . '.playlist_name ';
                $select_is_active = null;
                break;

            default:
                $select_element = '';
                break;
        }
        if ($select_element) {
            $group_by[] = $select_element;
            if (!empty($select_orphan)) {
                $group_by[] = Collection::getInstance()->getTableNameItems() . '.ci_id';
            }
        }

        if ($param_count) {
            $select = ['COUNT(DISTINCT ' . self::$tableName . '.flag_id) AS count'];
        } else {
            if ($param_group_by_type) {
                $group_by[] = ' ' . self::$tableName . '.id_flag_type';
                $group_by[] = ' ' . self::$tableName . '.id_element';
            } else {
                $group_by[] = self::$tableName . '.flag_id';
            }
            if ($param_group_by_type) {
                $select[] = 'count(DISTINCT ' . self::$tableName . '.flag_id) AS nb_flag';
                $select[] = self::$tableName . '.id_element';
                $select[] = self::$tableName . '.id_flag_type';
                $order_search = ' ORDER BY nb_flag desc, MAX(' . self::$tableName . '.date_added) desc ';
            } else {
                $select = self::getAllFields();
                $select[] = User::getInstance()->getTableName() . '_reporter.username';
            }
            $select[] = self::$tableNameType . '.language_key';
            if ($param_element_type !== false) {
                $select[] = $select_element . ' AS element_name';
                if (!empty($select_orphan)) {
                    $select[] = $select_orphan;
                }
                if (!empty($select_is_active)) {
                    $select[] = $select_is_active . ' AS is_active';
                }
            }

        }

        $order = '';
        if (!empty($order_search)) {
            $order = $order_search;
        } elseif ($param_order) {
            $order = ' ORDER BY ' . $param_order;
        }
        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }

        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table(self::$tableName)
            . ' INNER JOIN ' . cb_sql_table(self::$tableNameType) . ' ON ' . self::$tableNameType . '.id_flag_type = ' . self::$tableName . '.id_flag_type '
            . ' LEFT JOIN ' . tbl(User::getInstance()->getTableName()) . ' AS ' . User::getInstance()->getTableName() . '_reporter ON ' . User::getInstance()->getTableName() . '_reporter.userid = ' . self::$tableName . '.userid '
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group_by) ? '' : ' GROUP BY ' . implode(', ', $group_by))
            . $order
            . $limit;
        $result = Clipbucket_db::getInstance()->_select($sql);

        if ($param_count) {
            if (empty($result)) {
                return 0;
            }
            return $result[0]['count'];
        }

        if (!$result) {
            return [];
        }

        if ($param_first_only) {
            return $result[0];
        }
        return $result;
    }

    /**
     * @param int $id_element
     * @param string $element_type
     * @param int $id_flag_type
     * @param null $userid
     * @return bool
     * @throws Exception
     */
    public static function flagItem(int $id_element, string $element_type, int $id_flag_type, $userid=null): bool
    {
        $id_flag_element_type = array_search($element_type, self::getFlagElementTypes());
        if ($id_flag_element_type === false) {
            e(lang('unknown_element_type'));
            return false;
        }

        if (!array_key_exists($id_flag_type, self::getFlagTypes())) {
            e(lang('unknown_flag_type'));
            return false;
        }
        Clipbucket_db::getInstance()->insert(tbl(self::$tableName), [
            'id_flag_element_type',
            'id_element',
            'userid',
            'id_flag_type',
            'date_added'
        ], [
            $id_flag_element_type,
            $id_element,
            $userid ?? User::getInstance()->getCurrentUserID(),
            $id_flag_type,
            '|f|NOW()'
        ]);
        return true;
    }

    /**
     * @return array
     */
    private static function getAllFields(): array
    {
        return array_map(function ($field) {
            return self::$tableName . '.' . $field;
        }, self::$fields);

    }

    /**
     * @param array $params
     * @return array
     * @throws Exception
     */
    public static function getOne(array $params): array
    {
        $params['first_only'] = true;
        return self::getAll($params);
    }


    /**
     * @param int $flag_id
     * @return bool
     * @throws Exception
     */
    public static function unFlag(int $flag_id): bool
    {
        Clipbucket_db::getInstance()->delete(tbl(self::$tableName), ['flag_id'], [$flag_id]);
        e(lang('unflag_successful'), 'm');
        return true;
    }

    /**
     * @param int $id_element
     * @param $type
     * @return bool
     * @throws Exception
     */
    public static function unFlagByElementId(int $id_element, $type): bool
    {
        Clipbucket_db::getInstance()->delete(tbl(self::$tableName), [
            'id_element',
            'id_flag_element_type'
        ], [
            $id_element,
            stripslashes('|no_mc||f|(SELECT id_flag_element_type FROM ' . tbl(self::$tableNameElementType) . ' WHERE name=\'' . $type . '\' )')
        ]);
        return true;
    }

    public static function getPermissionByType($type): string
    {
        switch ($type) {
            case 'video':
            case 'playlist':
                return 'video_moderation';
            case 'photo':
                return 'photos_moderation';
            case 'collection':
                return 'collection_moderation';
            case 'user':
                return 'member_moderation';
        }
        return 'admin_access';
    }

    /**
     * @param $flag
     * @param $type
     * @return string[]
     * @throws Exception
     */
    public static function getLinksForFlag($flag, $type): array
    {
        switch ($type) {
            case 'video':
                return [
                    'fo'    => video_link($flag['id_element']),
                    'bo'    => DirPath::getUrl('admin_area') . 'edit_video.php?video=' . $flag['id_element'],
                    'thumb' => get_thumb($flag['id_element'], false, '168x105')
                ];

            case 'photo':
                return [
                    'fo'    => Photo::getInstance()->getFOLink($flag['id_element']),
                    'bo'    => DirPath::getUrl('admin_area') . 'edit_photo.php?photo=' . $flag['id_element'],
                    'thumb' => get_image_file(['details' => $flag['id_element']])
                ];

            case 'collection':
                return [
                    'fo'    => Collections::getInstance()->collection_links($flag['id_element']),
                    'bo'    => DirPath::getUrl('admin_area') . 'edit_collection.php?collection=' . $flag['id_element'],
                    'thumb' => Collections::getInstance()->get_thumb($flag['id_element'])
                ];

            case 'playlist':
                return ['bo' => DirPath::getUrl('admin_area') . 'edit_playlist.php?playlist=' . $flag['id_element']];

            case 'user':
                return [
                    'fo'    => userquery::getInstance()->profile_link($flag['id_element']),
                    'bo'    => DirPath::getUrl('admin_area') . 'view_user.php?uid=' . $flag['id_element'],
                    'thumb' => userquery::getInstance()->getUserThumb([], '', $flag['id_element'])
                ];
        }

        return [
            'bo' => '',
            'fo' => ''
        ];
    }

    /**
     * @param $flag_id
     * @param $type
     * @return array
     * @throws Exception
     */
    public static function getLinksForFlagById($flag_id, $type): array
    {
        return self::getLinksForFlag(self::getOne(['flag_id' => $flag_id]), $type);
    }

    public static function getTableName(): string
    {
        return self::$tableName;
    }

    public static function getTableNameElementType(): string
    {
        return self::$tableNameElementType;
    }

}