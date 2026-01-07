<?php

abstract class Objects
{

    private static array $type_array = [];

    protected static function getTableNameObjectType(): string
    {
        //TODO optimiser pour ne pas faire le test à chaque appel
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
            return 'object_type';
        } else {
            return 'categories_type';
        }
    }

    protected static function getIdFieldObjectType(): string
    {
        //TODO optimiser pour ne pas faire le test à chaque appel
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
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
            $sql = 'SELECT '.$id_field.' FROM ' . tbl(self::getTableNameObjectType()) . ' WHERE name = "' . static::TYPE . '"';
            $res = Clipbucket_db::getInstance()->_select($sql);
            self::$type_array[static::TYPE] = $res[0][$id_field] ?? 0;
        }
        return self::$type_array[static::TYPE];
    }

    /**
     * @param int $video_id
     * @param int $user_id
     * @return bool
     * @throws Exception
     */
    public static function isFavorite(int $object_id, int $user_id = 0): bool
    {
        if (empty($user_id)) {
            $user_id = User::getInstance()->getCurrentUserID() ?: 0;
        }
        return !empty(Clipbucket_db::getInstance()->select(tbl('favorites'), 'favorite_id', ' id = ' . mysql_clean($object_id) . ' AND userid = ' . mysql_clean($user_id) . ' AND type = \'' . static::TYPE . '\''));
    }

    /**
     * @param int $object_id
     * @param int $user_id
     * @return bool
     * @throws Exception
     */
    public function addToFavorites(int $object_id, int $user_id): bool
    {
        if (empty($user_id)) {
            $user_id = User::getInstance()->getCurrentUserID();
        }
        if (empty($user_id)) {
            e(lang('missing_params'));
            return false;
        }
        if (self::isFavorite($object_id, $user_id)) {
            e(lang('already_fav_message', lang(static::TYPE)));
            return false;
        }
        Clipbucket_db::getInstance()->insert(tbl('favorites'), ['type', 'id', 'userid', 'date_added'], [static::TYPE, $object_id, $user_id, NOW()]);
        addFeed(['action' => 'add_favorite', 'object_id' => $object_id, 'object' => static::TYPE]);

        //Logging Favorite
        insert_log(static::TYPE . '_favorite', [
            'success'        => 'yes',
            'details'        => 'added ' . static::TYPE . ' to favorites',
            'action_obj_id'  => $object_id,
            'action_done_id' => Clipbucket_db::getInstance()->insert_id()
        ]);

        e('<div class="alert alert-success">' . lang('add_fav_message', lang(static::TYPE)) . '</div>', 'm');
        return true;
    }

    public function removeFromFavorites(int $object_id, int $user_id): bool
    {

    }

    /**
     * @return array|string[]
     * @throws Exception
     */
    public static function getFlagConstraint(): array
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
        return [
            'join'   => ' LEFT JOIN ' . cb_sql_table(Flag::getTableName()) . ' ON ' . Flag::getTableName() . '.id_element = ' . $tablename . '.' . $object_id . ' AND ' . Flag::getTableName() . '.id_flag_element_type = ' . static::getTypeId(),
            'select' => ' IF(COUNT(distinct ' . Flag::getTableName() . '.flag_id) > 0, 1, 0) AS is_flagged',
        ];
    }
}