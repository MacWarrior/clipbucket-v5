<?php

abstract class Objects
{

    private static array $type_array = [];

    /**
     * @return string[]
     */
    private static function getClassInfo(): array
    {
        switch (static::TYPE) {
            case 'photo':
                $config_own_rate = 'own_photo_rating';
                $config_rating = 'photo_rating';
                $table_vote = 'photo_rates';
                $id_vote = 'id_photo';
                $table = 'photos';
                $id_field = 'photo_id';
                $allow_rating = 'allow_rating';
                break;

            case 'collection':
                $config_own_rate = 'own_collection_rating';
                $config_rating = 'collection_rating';
                $table_vote = 'collection_rates';
                $id_vote = 'id_collection';
                $table = 'collections';
                $id_field = 'collection_id';
                $allow_rating = 'allow_rating';
                break;

            case 'user':
                $config_own_rate = 'own_channel_rating';
                $config_rating = 'channel_rating';
                $table_vote = 'channel_rates';
                $id_vote = 'id_channel';
                $table = 'user_profile';
                $id_field = 'user_profile_id';
                $allow_rating = 'allow_ratings';
                break;

            case 'comment':
                $config_own_rate = 'own_comment_rating';
                $config_rating = 'comment_rating';
                $table_vote = 'comment_rates';
                $id_vote = 'id_comment';
                $table = 'comments';
                $id_field = 'comment_id';
                $allow_rating = '';
                break;

            case 'video':
            default:
                $config_own_rate = 'own_video_rating';
                $config_rating = 'video_rating';
                $table_vote = 'video_rates';
                $id_vote = 'id_video';
                $table = 'video';
                $id_field = 'videoid';
                $allow_rating = 'allow_rating';
                break;
        }
        return [$config_own_rate, $config_rating, $table_vote, $id_vote, $table, $id_field, $allow_rating];
    }

    /**
     * @return string
     */
    protected static function getTableNameObjectType(): string
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '8')) {
            return 'object_type';
        }
        return 'categories_type';
    }

    /**
     * @return string
     */
    protected static function getIdFieldObjectType(): string
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '8')) {
            return 'id_object_type';
        }
        return 'id_category_type';
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
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '8')) {
            $field = 'id_type';
            $value = static::getTypeId();
        } else {
            $field = 'type';
            $value = '\'' . static::TYPE . '\'';
        }
        return !empty(Clipbucket_db::getInstance()->select(tbl('favorites'), 'favorite_id', ' id = ' . (int)$object_id . ' AND userid = ' . (int)$user_id . ' AND ' . $field . ' = ' . $value));
    }

    /**
     * @param int $object_id
     * @param int $user_id
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
     * @param int $object_id
     * @return void
     * @throws Exception
     */
    public function removeFromFavoritesForAllUsers(int $object_id): void
    {
        Clipbucket_db::getInstance()->delete(tbl('favorites'), ['id_type', 'id'], [static::getTypeId(), $object_id]);
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

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '8')) {
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

    /**
     * @return array
     * @throws Exception
     */
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

            case 'user':
                $tablename = User::getInstance()->getTableName();
                $object_id = 'userid';
                break;

            default:
                return [];
        }
        return ['table_name' => $tablename, 'field_id' => $object_id];
    }

    /**
     * @param $object_id
     * @param $rating
     * @return void
     * @throws Exception
     */
    public static function ratingUpdate($object_id, $rating): void
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            throw new Exception(lang('cant_perform_action_until_app_fully_updated'));
        }
        if (!User::getInstance()->isUserConnected()) {
            throw new Exception(lang('please_login_to_rate'));
        }
        $current_rating = static::ratingGet($object_id);
        [$config_own_rate, $config_rating, $table_vote, $id_vote, $table, $id_field, $allow_rating] = self::getClassInfo();

        if ($current_rating[$allow_rating] == 'no' || config($config_rating) != 'yes') {
            switch (static::TYPE) {
                case 'photo':
                    $lang = 'photo_rate_disabled';
                    break;
                case 'collection':
                    $lang = 'collection_rate_disabled';
                    break;
                case 'user':
                    $lang = 'channel_rate_disabled';
                    break;
                case 'video':
                    $lang = 'vid_rate_disabled';
                    break;
                case 'comment':
                    $lang = 'comment_rate_disabled';
                    break;
                default:
                    $lang = '';
            }
            throw new Exception(lang($lang));
        }

        if (User::getInstance()->getCurrentUserID() == $current_rating['object_proprio'] && config($config_own_rate) != 'yes') {
            switch (static::TYPE) {
                case 'photo':
                    $lang = 'you_cant_rate_own_photo';
                    break;
                case 'collection':
                    $lang = 'you_cant_rate_own_collection';
                    break;
                case 'user':
                    $lang = 'you_cant_rate_own_channel';
                    break;
                case 'video':
                    $lang = 'you_cant_rate_own_video';
                    break;
                case 'comment':
                    $lang = 'you_cant_rate_own_comment';
                    break;
                default:
                    $lang = '';
            }
            throw new Exception(lang($lang));
        }

        $old_total = $current_rating['value'] == 0 ? 'total_rate_down' : 'total_rate_up';
        Clipbucket_db::getInstance()->delete(tbl($table_vote), ['id_user', $id_vote], [User::getInstance()->getCurrentUserID(), $object_id]);
        if ($current_rating[$old_total] > 0) {
            self::updateObjectRating($object_id, $old_total, '-');
        }
        if (!isset($current_rating['value']) || $rating != $current_rating['value']) {
            $new_total = $rating == 0 ? 'total_rate_down' : 'total_rate_up';
            if (Clipbucket_db::getInstance()->insert(tbl($table_vote), ['id_user', $id_vote, 'value'], [User::getInstance()->getCurrentUserID(), $object_id, (int)$rating])) {
                self::updateObjectRating($object_id, $new_total, '+');
            }
        }
    }

    /**
     * @param $object_id
     * @param null $userid
     * @return bool|array
     * @throws Exception
     */
    protected static function ratingGet($object_id, $userid = null): bool|array
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return false;
        }
        if (empty($userid)) {
            $userid = User::getInstance()->getCurrentUserID();
        }
        return self::getAllRates(['object_id' => $object_id, 'userid' => $userid, 'first_only' => true]);
    }

    /**
     * @param array $params
     * @return array|false|mixed|void
     * @throws Exception
     */
    public static function getAllRates(array $params = [])
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return;
        }
        $param_object_id = $params['object_id'] ?? false;
        $param_userid = $params['userid'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_first_only = $params['first_only'] ?? false;
        $param_conditions = $params['conditions'] ?? false;

        [$config_own_rate, $config_rating, $table_vote, $id_vote, $table, $id_field, $allow_rating] = self::getClassInfo();
        $conditions = [];
        if ($param_object_id !== false) {
            $conditions[] = $table . '.' . $id_field . ' = ' . (int)$param_object_id;
        }
        if ($param_userid !== false) {
            $conditions[] = $table_vote . '.id_user = ' . (int)$param_userid;
        }

        if (!empty($param_conditions)) {
            $conditions[] = $param_conditions;
        }
        $select = [];
        $select[] = $table_vote . '.*';
        $select[] = $table . '.userid AS object_proprio';
        $select[] = $table . '.total_rate_up';
        $select[] = $table . '.total_rate_down';
        if (!empty($allow_rating)) {
            $select[] = $allow_rating;
        }

        $sql = 'SELECT ' . implode(',', $select) . ' 
        FROM ' . cb_sql_table($table) . '
        LEFT JOIN ' . cb_sql_table($table_vote) . ' ON ' . $table . '.' . $id_field . ' = ' . $table_vote . '.' . $id_vote . '
        WHERE ' . implode(' AND ', $conditions)
        . (!empty($param_limit) ? ' LIMIT ' . $param_limit : '')
        . (!empty($order) ? ' ORDER BY ' . $order : '');
        $rates = Clipbucket_db::getInstance()->_select($sql, $param_limit, $param_order);
        if ($param_first_only) {
            return $rates[0] ?? false;
        }
        return $rates;
    }

    /**
     * @param $userid
     * @param $object_id
     * @return false|mixed|string
     * @throws Exception
     */
    public static function isObjectRated($userid, $object_id): mixed
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return false;
        }
        [$config_own_rate, $config_rating, $table_vote, $id_vote, $table, $id_field] = self::getClassInfo();

        $sql = 'SELECT ' . $table_vote . '.*
        FROM ' . cb_sql_table($table_vote) . ' 
        WHERE ' . $id_vote . ' = ' . (int)$object_id . ' AND id_user = ' . (int)$userid;
        $rating = Clipbucket_db::getInstance()->_select($sql);
        if (count($rating) > 0) {
            return $rating[0]['value'] ? 'liked' : 'disliked';
        }
        return false;
    }

    /**
     * @param $object_id
     * @return void
     * @throws Exception
     */
    public static function deleteObjectRatingByObjectId($object_id): void
    {
        self::deleteObjectRating($object_id);
    }

    /**
     * @param $object_id
     * @param $user_id
     * @return void
     * @throws Exception
     */
    public static function deleteObjectRating($object_id, $user_id = null): void
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return;
        }
        [$config_own_rate, $config_rating, $table_vote, $id_vote, $table, $id_field] = self::getClassInfo();
        $fields = [$id_vote];
        $values = [$object_id];
        if (!empty($user_id)) {
            $fields[] = 'id_user';
            $values[] = $user_id;
        }
        Clipbucket_db::getInstance()->delete(tbl($table_vote), $fields, $values);
    }

    /**
     * @param $object_id
     * @param $total_field
     * @param $plus_or_minus
     * @return void
     * @throws Exception
     */
    public static function updateObjectRating($object_id, $total_field, $plus_or_minus): void
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return;
        }
        if (!in_array($plus_or_minus, ['+', '-'])) {
            throw new Exception(lang('missing_params'));
        }
        [$config_own_rate, $config_rating, $table_vote, $id_vote, $table, $id_field] = self::getClassInfo();
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl($table) . ' SET ' . $total_field . ' = ' . $total_field . ' ' . $plus_or_minus . ' 1 WHERE ' . $id_field . ' = ' . (int)$object_id);
    }

    /**
     * @param $object_id
     * @return void
     * @throws Exception
     */
    public static function resetTotal($object_id): void
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            return;
        }
        [$config_own_rate, $config_rating, $table_vote, $id_vote, $table, $id_field] = self::getClassInfo();
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl($table) . ' 
        SET total_rate_up = (SELECT COUNT(*) FROM ' . tbl($table_vote) . ' WHERE ' . $id_vote . ' = ' . (int)$object_id . ' AND value = 1)
        , total_rate_down = (SELECT COUNT(*) FROM ' . tbl($table_vote) . ' WHERE ' . $id_vote . ' = ' . (int)$object_id . ' AND value = 0)
        WHERE ' . $id_field . ' = ' . (int)$object_id);

    }

}