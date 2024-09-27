<?php

class Tags
{

    /**
     * @var string[]
     */
    private static $video_types = [
        'video',
        'actors',
        'producer',
        'executive_producer',
        'director',
        'crew',
        'genre',
    ];

    /**
     * @throws Exception
     */
    public static function getTags($limit = 'false', $cond = false)
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return [];
        }

        $query = 'SELECT T.name AS tag, TT.name AS tag_type, T.id_tag, 
        IF(COUNT(CT.id_tag) = 0 AND COUNT(PT.id_tag) = 0 AND COUNT(PLT.id_tag) = 0 AND COUNT(UT.id_tag) = 0 AND COUNT(VT.id_tag) = 0, true, false) AS can_delete
        FROM ' . tbl('tags') . ' T 
        INNER JOIN ' . tbl('tags_type') . ' TT ON TT.id_tag_type = T.id_tag_type 
        LEFT JOIN ' . tbl('collection_tags') . ' CT ON CT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('photo_tags') . ' PT ON PT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('playlist_tags') . ' PLT ON PLT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('user_tags') . ' UT ON UT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('video_tags') . ' VT ON VT.id_tag = T.id_tag 
        ' . ($cond ? 'WHERE ' . (is_array($cond) ? implode(' AND ', $cond) : $cond) : '') . '
        GROUP BY T.id_tag
        ';
        if ($limit) {
            $query .= 'LIMIT ' . $limit;
        }

        return Clipbucket_db::getInstance()->_select($query, 0);
    }

    /**
     * @throws Exception
     */
    public static function countTags($cond)
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return 0;
        }

        return Clipbucket_db::getInstance()->count(tbl('tags') . ' T 
        INNER JOIN ' . tbl('tags_type') . ' TT ON TT.id_tag_type = T.id_tag_type 
        LEFT JOIN ' . tbl('collection_tags') . ' CT ON CT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('photo_tags') . ' PT ON PT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('playlist_tags') . ' PLT ON PLT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('user_tags') . ' UT ON UT.id_tag = T.id_tag 
        LEFT JOIN ' . tbl('video_tags') . ' VT ON VT.id_tag = T.id_tag ', 'DISTINCT T.name, TT.name, T.id_tag', (is_array($cond) ? implode(' AND ', $cond) : $cond));
    }

    /**
     * @param $id_tag
     * @return false|void
     * @throws Exception
     */
    public static function deleteTag($id_tag)
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return false;
        }

        $query = 'SELECT 
                    IF(COUNT(CT.id_tag) = 0 AND COUNT(PT.id_tag) = 0 AND COUNT(PLT.id_tag) = 0 AND COUNT(UT.id_tag) = 0 AND COUNT(VT.id_tag) = 0, true, false) AS can_delete
                    FROM ' . tbl('tags') . ' T
                    LEFT JOIN ' . tbl('collection_tags') . ' CT ON CT.id_tag = T.id_tag 
                    LEFT JOIN ' . tbl('photo_tags') . ' PT ON PT.id_tag = T.id_tag 
                    LEFT JOIN ' . tbl('playlist_tags') . ' PLT ON PLT.id_tag = T.id_tag 
                    LEFT JOIN ' . tbl('user_tags') . ' UT ON UT.id_tag = T.id_tag 
                    LEFT JOIN ' . tbl('video_tags') . ' VT ON VT.id_tag = T.id_tag 
                    WHERE T.id_tag = ' . mysql_clean($id_tag);
        $result = Clipbucket_db::getInstance()->_select($query);
        if (!empty($result) && $result[0]['can_delete']) {
            Clipbucket_db::getInstance()->delete(tbl('tags'), ['id_tag'], [$id_tag]);
            e(lang('tag_deleted'), 'm');
        } else {
            e(lang('error'));
        }
    }

    /**
     * @param $name
     * @param $id_tag
     * @return bool
     * @throws Exception
     */
    public static function updateTag($name, $id_tag): bool
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return false;
        }

        if (strlen(trim($name)) <= 2) {
            e(lang('tag_too_short'), 'warning');
            return false;
        }
        try {
            Clipbucket_db::getInstance()->update(tbl('tags'), ['name'], [$name], 'id_tag = ' . mysql_clean($id_tag));
            e(lang('tag_updated'), 'm');
            return true;
        } catch (Exception $e) {
            e(lang('error'));
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function deleteTags(string $object_type, int $object_id, string $tag_type = ''): bool
    {
        switch ($object_type) {
            case 'video':
                $id_field = 'id_video';
                $table_tag = 'video_tags';
                break;
            case 'photo':
                $id_field = 'id_photo';
                $table_tag = 'photo_tags';
                break;
            case 'collection':
                $id_field = 'id_collection';
                $table_tag = 'collection_tags';
                break;
            case 'profile':
                $id_field = 'id_user';
                $table_tag = 'user_tags';
                break;
            case 'playlist':
                $id_field = 'id_playlist';
                $table_tag = 'playlist_tags';
                break;
            default:
                error_log('Undefined object type : '.$object_type);
                return false;
        }

        if( !empty($tag_type) ){
            $sql_id_type = 'SELECT id_tag_type
                   FROM ' . tbl('tags_type') . '
                   WHERE name = \'' . $tag_type . '\'';
            $res = Clipbucket_db::getInstance()->_select($sql_id_type);
            if( empty($res) ){
                e(lang('unknown_tag_type'));
                return false;
            }
            $id_type = $res[0]['id_tag_type'];

            $sql_delete_link = 'DELETE ' . $table_tag . ' FROM ' . cb_sql_table($table_tag) . '
                INNER JOIN ' . cb_sql_table('tags') . ' ON tags.id_tag = ' . $table_tag . '.id_tag
                WHERE ' . $id_field . ' = ' . mysql_clean($object_id) . ' AND tags.id_tag_type = ' . $id_type;
        } else {
            $sql_delete_link = 'DELETE ' . $table_tag . ' FROM ' . cb_sql_table($table_tag) . '
                WHERE ' . $id_field . ' = ' . mysql_clean($object_id);
        }

        if (!Clipbucket_db::getInstance()->execute($sql_delete_link, 'delete')) {
            e(lang('error_delete_linking_tags'));
            return false;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public static function saveTags(string $tags, string $tag_type, int $object_id): bool
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return false;
        }
        if (in_array($tag_type,self::$video_types)) {
            $id_field = 'id_video';
            $table_tag = 'video_tags';
            $object_type = 'video';
        } else {
            $object_type = $tag_type;
            switch ($tag_type) {
                case 'photo':
                    $id_field = 'id_photo';
                    $table_tag = 'photo_tags';
                    break;
                case 'collection':
                    $id_field = 'id_collection';
                    $table_tag = 'collection_tags';
                    break;
                case 'profile':
                    $id_field = 'id_user';
                    $table_tag = 'user_tags';
                    break;
                case 'playlist':
                    $id_field = 'id_playlist';
                    $table_tag = 'playlist_tags';
                    break;
                default:
                    error_log('Undefined tag type : '.$tag_type);
                    return false;
            }
        }

        self::deleteTags($object_type, $object_id, $tag_type);

        if( empty(trim($tags)) ){
            return true;
        }

        //getting type
        $sql_id_type = 'SELECT id_tag_type
                   FROM ' . tbl('tags_type') . '
                   WHERE name = \'' . $tag_type . '\'';
        $res = Clipbucket_db::getInstance()->_select($sql_id_type);
        if( empty($res) ){
            e(lang('unknown_tag_type'));
            return false;
        }
        $id_type = $res[0]['id_tag_type'];

        //insert new tags
        $tag_array = explode(',', mysql_clean($tags));
        while( !empty($tag_array) ) {
            $tmp_tags = array_splice($tag_array, 0, 500);
            $values = ' SELECT \'' . implode('\' UNION SELECT \'', $tmp_tags) . '\'';

            $sql_insert_tag = 'INSERT IGNORE INTO ' . tbl('tags') . ' (id_tag_type, name)
                WITH tags_to_insert AS ( ' . $values . ' )
                SELECT ' . $id_type . ', tags_to_insert.*
                FROM tags_to_insert';

            if (!Clipbucket_db::getInstance()->execute($sql_insert_tag, 'insert')) {
                if( !in_dev() ){
                    e(lang('technical_error'));
                }
                return false;
            }
        }

        //link tags to object
        $tag_array = explode(',', mysql_clean($tags));
        while( !empty($tag_array) ) {
            $tmp_tags = array_splice($tag_array, 0, 500);
            $sql_link_tag = 'INSERT IGNORE INTO ' . tbl($table_tag) . ' (`id_tag`, `' . $id_field . '`)
                SELECT 
                    tags.id_tag
                    ,' . mysql_clean($object_id) . '
                FROM
                    ' . cb_sql_table('tags') . '
                WHERE
                    tags.id_tag_type = ' . mysql_clean($id_type) . '
                    AND tags.name IN(\'' . implode('\',\'', $tmp_tags) . '\')
            ';

            if (!Clipbucket_db::getInstance()->execute($sql_link_tag, 'insert')) {
                if( !in_dev() ){
                    e(lang('technical_error'));
                }
                return false;
            }
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public static function fill_auto_complete_tags($object_type): array
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return [];
        }
        $sql_id_type = 'SELECT id_tag_type
                   FROM ' . tbl('tags_type') . '
                   WHERE name LIKE \'' . $object_type . '\'';
        $res = Clipbucket_db::getInstance()->_select($sql_id_type);
        if (!empty($res)) {
            $id_type = $res[0]['id_tag_type'];
        } else {
            e(lang('unknown_tag_type'));
            return [];
        }
        $query = 'SELECT name FROM ' . tbl('tags') . ' T  WHERE T.id_tag_type = ' . mysql_clean($id_type);
        $result = Clipbucket_db::getInstance()->_select($query, 0);
        return array_map(function ($item) {
            return $item['name'];
        }, $result);
    }

    /**
     * @param array $cond
     * @return array
     * @throws Exception
     */
    public static function getTagTypes($cond=[]): array
    {
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
            e(lang('missing_table'));
            return [];
        }

        return Clipbucket_db::getInstance()->select(tbl('tags_type'), '*', implode(' AND ', $cond), false, false, false, 300);
    }

    /**
     * @throws Exception
     */
    public static function getVideoTypes(): array
    {
        return self::getTagTypes(['name IN (\''.implode('\',\'',self::$video_types).'\')']);
    }
}
