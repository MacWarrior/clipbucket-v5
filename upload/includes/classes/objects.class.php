<?php

abstract class Objects
{

    private static array $type_array = [];

    protected static function getTableNameObjectType(): string
    {
        //TODO optimiser pour ne pas faire le test à chaque appel
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '8')) {
            return 'object_type';
        } else {
            return 'categories_type';
        }
    }

    protected static function getIdFieldObjectType(): string
    {
        //TODO optimiser pour ne pas faire le test à chaque appel
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '8')) {
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
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '8')) {
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

    public static function ratingUpdate($object_id, $rating)
    {
        if (!User::getInstance()->isUserConnected()) {
            throw new Exception(lang('please_login_to_rate'));
        }
        $current_rating = static::ratingGet($object_id);
        switch (static::TYPE) {
            case 'photo':
                $config_own_rate = 'own_photo_rating';
                $config_rating = 'photo_rating';
                $voters_key = 'voters';
                $table = 'photos';
                $id_field = 'photo_id';
                break;
            case 'collection':
                $config_own_rate = 'own_collection_rating';
                $config_rating = 'collection_rating';
                $voters_key = 'voters';
                $table = 'collections';
                $id_field = 'collection_id';
                break;
            case 'user':
                $config_own_rate = 'own_channel_rating';
                $config_rating = 'channel_rating';
                $voters_key = 'voters';
                $table = 'user_profile';
                $id_field = 'user_profile_id';
                break;
            case 'video':
            default:
                $config_own_rate = 'own_video_rating';
                $config_rating = 'video_rating';
                $voters_key = 'voter_ids';
                $table = 'video';
                $id_field = 'videoid';
                break;
        }
        if (User::getInstance()->getCurrentUserID() == $current_rating['userid'] && !config($config_own_rate)) {
            throw new Exception(lang('you_cant_rate_own_' . static::TYPE));
        }
        if ($current_rating['allow_rating'] =='no' || !config($config_rating)) {
            throw new Exception(lang( static::TYPE . '_rate_disabled' ));
        }
        $Old_histo = explode('|', $current_rating[$voters_key]);
        if (!empty($Old_histo) && is_array($Old_histo) && count($Old_histo) > 1) {
            foreach ($Old_histo as $voter) {
                if ($voter) {
                    $histo[$voter] = [
                        'userid' => $voter,
                        'time'   => now(),
                        'method' => 'old'
                    ];
                }
            }
        }
        $histo = json_decode($current_rating[$voters_key], true);
        $histo_value = false;
        $t = $current_rating['rated_by'] * $current_rating['rating'];
        if (!empty($histo) && in_array(User::getInstance()->getCurrentUserID(), array_keys($histo))) {
            $histo_value = $histo[User::getInstance()->getCurrentUserID()]['rating'];
            unset($histo[User::getInstance()->getCurrentUserID()]);
            $total_voters = empty($histo) ? 0 : count($histo);
            $t -= $histo_value;
            $newrate = $t / ($total_voters ?: 1);
            if ($newrate > 10) {
                $newrate = 10;
            }
        }
        if ($histo_value !== $rating) {
            $histo[User::getInstance()->getCurrentUserID()] = [
                'userid'   => User::getInstance()->getCurrentUserID(),
                'username' => User::getInstance()->get('username'),
                'time'     => now(),
                'rating'   => $rating
            ];
            $total_voters = empty($histo) ? 0 : count($histo);
            $newrate = ($t + $rating) / ($total_voters?:1);
            if ($newrate > 10) {
                $newrate = 10;
            }
        }

        Clipbucket_db::getInstance()->update(
            tbl($table),  ['rating', 'rated_by', $voters_key], [$newrate, $total_voters, '|no_mc|' . (!empty($histo) ? json_encode($histo): '')], ' ' . $id_field . ' = ' . mysql_clean($object_id)
        );

    }

    /**
     * @param $object_id
     * @return bool|array
     * @throws Exception
     */
    protected static function ratingGet($object_id): bool|array
    {
        switch (static::TYPE) {
            case 'video':
                return CBvideo::getInstance()->get_video_rating($object_id);
            case 'photo':
                return CBPhotos::getInstance()->current_rating($object_id);
            case 'collection':
                return Collections::getInstance()->current_rating($object_id);
            case 'user':
                return userquery::getInstance()->current_rating($object_id);
        }
        return false;
    }
}