<?php

abstract class Objects
{

    private static array $type_array = [];

    protected static function getTableNameObjectType(): string
    {
        //TODO optimiser pour ne pas faire le test à chaque appel
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return 'object_type';
        } else {
            return 'categories_type';
        }
    }

    protected static function getIdFieldObjectType(): string
    {
        //TODO optimiser pour ne pas faire le test à chaque appel
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return 'id_object_type';
        } else {
            return 'id_category_type';
        }
    }

    /**
     * @return int
     * @throws Exception
     */
    public static function getTypeId(): int
    {
        if (empty(self::$type_array[static::TYPE])) {
            $id_field = static::getIdFieldObjectType();
            $sql = 'SELECT ' . $id_field . ' FROM ' . tbl(self::getTableNameObjectType()) . ' WHERE name = "' . static::TYPE . '"';
            $res = Clipbucket_db::getInstance()->_select($sql);
            self::$type_array[static::TYPE] = $res[0][$id_field] ?? 0;
        }
        return self::$type_array[static::TYPE];
    }

    /**
     * @param int $object_id
     * @param int $user_id
     * @return bool
     * @throws Exception
     */
    public static function isFavorite(int $object_id, int $user_id = 0): bool
    {
        if (empty($user_id)) {
            $user_id = User::getInstance()->getCurrentUserID() ?: 0;
        }
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $field = 'id_type';
            $value = static::getTypeId();
        } else {
            $field = 'type';
            $value = '\'' . static::TYPE . '\'';
        }
        return !empty(Clipbucket_db::getInstance()->select(tbl('favorites'), 'favorite_id', ' id = ' . mysql_clean($object_id) . ' AND userid = ' . mysql_clean($user_id) . ' AND ' . $field . ' = ' . $value));
    }

    /**
     * @param int $object_id
     * @param int|null $user_id
     * @return bool
     * @throws Exception
     */
    public function addToFavorites(int $object_id, int $user_id = 0): bool
    {
        if (empty($user_id)) {
            $user_id = User::getInstance()->getCurrentUserID();
        }
        if (empty($user_id)) {
            e(lang('missing_params'));
            return false;
        }
        if (static::isFavorite($object_id, $user_id)) {
            e(lang('already_fav_message', lang(static::TYPE)));
            return false;
        }
        Clipbucket_db::getInstance()->insert(tbl('favorites'), ['id_type', 'id', 'userid', 'date_added'], [static::getTypeId(), $object_id, $user_id, NOW()]);
        addFeed(['action' => 'add_favorite', 'object_id' => $object_id, 'object' => static::TYPE]);

        //Logging Favorite
        insert_log(static::TYPE . '_favorite', [
            'success'        => 'yes',
            'details'        => 'added ' . static::TYPE . ' to favorites',
            'action_obj_id'  => $object_id,
            'action_done_id' => Clipbucket_db::getInstance()->insert_id()
        ]);
        e(lang('add_fav_message', lang(static::TYPE)), 'm');
        return true;
    }

    /**
     * @param int $object_id
     * @param int|null $user_id
     * @return bool
     * @throws Exception
     */
    public function removeFromFavorites(int $object_id, int $user_id = 0): bool
    {
        if (empty($user_id)) {
            $user_id = User::getInstance()->getCurrentUserID();
        }
        if (empty($user_id)) {
            e(lang('missing_params'));
            return false;
        }
        if (!static::isFavorite($object_id, $user_id)) {
            e(lang('unknown_favorite', lang(static::TYPE)));
            return false;
        }
        Clipbucket_db::getInstance()->delete(tbl('favorites'), ['userid', 'id_type', 'id'], [$user_id, static::getTypeId(), $object_id]);
        e(lang('fav_remove_msg', ucfirst(lang(static::TYPE))), 'm');
        return true;
    }

    /**
     * Get Used Favorites
     *
     * @param array $params
     *
     * @return array|int
     * @throws Exception
     */
    public function getAllFavorites(array $params = []): array|int
    {
        $user_id = $params['userid'];
        $limit = $params['limit'];
        $cond = $params['cond'];
        $order = $params['order'];

        if (empty($user_id)) {
            $user_id = User::getInstance()->getCurrentUserID();
        }
        if (!empty($cond)) {
            $cond = ' AND ' . $cond;
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $field = 'id_type';
            $value = static::getTypeId();
        } else {
            $field = 'type';
            $value = '\'' . static::TYPE . '\'';
        }

        $info = static::getObjectTableAndFieldId();
        if (!empty($params['count_only'])) {
            return Clipbucket_db::getInstance()->count(tbl('favorites' . ',' . $info['table_name']), '*', ' ' . tbl('favorites') . '.' . $field . '=' . $value . ' 
                AND ' . tbl('favorites') . '.userid=\'' . $user_id . '\' 
                AND ' . tbl($info['table_name']) . '.' . $info['field_id'] . ' = ' . tbl('favorites') . '.id' . $cond);
        }

        $results = Clipbucket_db::getInstance()->select(tbl('favorites' . ',' . $info['table_name']), '*', ' ' . tbl('favorites') . '.' . $field . '=' . $value . ' 
            AND ' . tbl('favorites') . '.userid=\'' . $user_id . '\' 
            AND ' . tbl($info['table_name']) . '.' . $info['field_id'] . ' = ' . tbl('favorites') . '.id' . $cond, $limit, $order);

        if (count($results) > 0) {
            return $results;
        }
        return [];
    }

    /**
     * @return array|string[]
     * @throws Exception
     */
    public static function getFlagConstraint(): array
    {
        $info = static::getObjectTableAndFieldId();
        return [
            'join'   => ' LEFT JOIN ' . cb_sql_table(Flag::getTableName()) . ' ON ' . Flag::getTableName() . '.id_element = ' . $info['table_name'] . '.' . $info['field_id'] . ' AND ' . Flag::getTableName() . '.id_flag_element_type = ' . static::getTypeId(),
            'select' => ' IF(COUNT(distinct ' . Flag::getTableName() . '.flag_id) > 0, 1, 0) AS is_flagged',
        ];
    }

    protected static function getObjectTableAndFieldId(): array
    {
        //TODO optimiser pour supprimer le switch
        switch (static::TYPE) {
            case 'video':
                $tablename = Video::getInstance()->getTableName();
                $object_id = Video::getInstance()->getFieldId();
                break;
            case 'photo':
                $tablename = Photo::getInstance()->getTableName();
                $object_id = 'photo_id';
                break;
            case 'collection':
                $tablename = Collection::getInstance()->getTableName();
                $object_id = 'collection_id';
                break;
            default:
                return [];
        }
        return ['table_name' => $tablename, 'field_id' => $object_id];
    }
}