<?php
class User
{
    private static $user;
    private $tablename = '';
    private $tablename_profile = '';
    private $tablename_level = '';
    private $fields = [];
    private $fields_profile = [];
    private $display_block = '';
    private $search_limit = 0;
    private $display_var_name = '';
    private $user_data = [];
    private $user_notification_inbox;
    private $user_notification_contact;

    private $default_homepage_list = [];

    /**
     * @throws Exception
     */
    public function __construct(int $user_id){
        $this->tablename = 'users';
        $this->fields = [
            'userid'
            ,'featured_video'
            ,'username'
            ,'user_session_key'
            ,'user_session_code'
            ,'password'
            ,'email'
            ,'usr_status'
            ,'msg_notify'
            ,'avatar'
            ,'avatar_url'
            ,'dob'
            ,'level'
            ,'avcode'
            ,'doj'
            ,'last_logged'
            ,'num_visits'
            ,'session'
            ,'ip'
            ,'signup_ip'
            ,'time_zone'
            ,'featured'
            ,'featured_date'
            ,'profile_hits'
            ,'total_watched'
            ,'total_videos'
            ,'total_comments'
            ,'total_photos'
            ,'total_collections'
            ,'comments_count'
            ,'last_commented'
            ,'voted'
            ,'ban_status'
            ,'upload'
            ,'subscribers'
            ,'total_subscriptions'
            ,'background'
            ,'background_color'
            ,'background_url'
            ,'background_repeat'
            ,'last_active'
            ,'banned_users'
            ,'welcome_email_sent'
            ,'total_downloads'
            ,'album_privacy'
            ,'likes'
            ,'is_live'
        ];

        if( config('enable_country') == 'yes' ){
            $this->fields[] = 'country';
        }

        if( config('enable_gender') == 'yes' ){
            $this->fields[] = 'sex';
        }

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '313') ){
            $this->fields[] = 'active_theme';
        }

        $this->tablename_profile = 'user_profile';
        $this->fields_profile = [
            'show_my_collections'
            ,'featured_video'
            ,'show_dob'
            ,'time_zone'
            ,'fb_url'
            ,'twitter_url'
            ,'insta_url'
            ,'show_profile'
            ,'allow_comments'
            ,'allow_ratings'
            ,'allow_subscription'
            ,'content_filter'
            ,'icon_id'
            ,'browse_criteria'
            ,'background'
            ,'rating'
            ,'voters'
            ,'rated_by'
            ,'show_my_videos'
            ,'show_my_photos'
            ,'show_my_subscriptions'
            ,'show_my_subscribers'
            ,'show_my_friends'
        ];

        if( config('enable_user_firstname_lastname') == 'yes' ){
            $this->fields_profile[] = 'first_name';
            $this->fields_profile[] = 'last_name';
        }
        if( config('enable_user_relation_status') == 'yes' ){
            $this->fields_profile[] = 'relation_status';
        }
        if( config('enable_user_postcode') == 'yes' ){
            $this->fields_profile[] = 'postal_code';
        }
        if( config('enable_user_hometown') == 'yes' ){
            $this->fields_profile[] = 'hometown';
        }
        if( config('enable_user_city') == 'yes' ){
            $this->fields_profile[] = 'city';
        }
        if( config('enable_user_education') == 'yes' ){
            $this->fields_profile[] = 'education';
        }
        if( config('enable_user_schools') == 'yes' ){
            $this->fields_profile[] = 'schools';
        }
        if( config('enable_user_occupation') == 'yes' ){
            $this->fields_profile[] = 'occupation';
        }
        if( config('enable_user_compagnies') == 'yes' ){
            $this->fields_profile[] = 'companies';
        }
        if( config('enable_user_hobbies') == 'yes' ){
            $this->fields_profile[] = 'hobbies';
        }
        if( config('enable_user_favorite_movies') == 'yes' ){
            $this->fields_profile[] = 'fav_movies';
        }
        if( config('enable_user_favorite_music') == 'yes' ){
            $this->fields_profile[] = 'fav_music';
        }
        if( config('enable_user_favorite_books') == 'yes' ){
            $this->fields_profile[] = 'fav_books';
        }
        if( config('enable_user_website') == 'yes' ){
            $this->fields_profile[] = 'web_url';
        }
        if( config('enable_user_about') == 'yes' ){
            $this->fields_profile[] = 'about_me';
        }
        if( config('enable_user_status') == 'yes' ){
            $this->fields_profile[] = 'online_status';
        }
        if( config('enable_channel_description') == 'yes' ) {
            $this->fields_profile[] = 'profile_desc';
        }

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '136') ){
            $this->fields_profile[] = 'disabled_channel';
        }
        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '37') && config('enable_channel_slogan') == 'yes' ){
            $this->fields_profile[] = 'profile_slogan';
        }

        $this->tablename_level = 'user_levels';
        $this->display_block = '/blocks/user.html';
        $this->display_var_name = 'user';
        $this->search_limit = (int)config('users_items_search_page');

        $this->default_homepage_list = [
            'homepage'
            ,'my_account'
        ];

        if( config('videosSection') == 'yes' ){
            $this->default_homepage_list[] = 'videos';

            if( config('enable_public_video_page') == 'yes'){
                $this->default_homepage_list[] = 'public_videos';
            }
        }

        if( config('photosSection') == 'yes' ){
            $this->default_homepage_list[] = 'photos';
        }

        if( config('collectionsSection') == 'yes' ){
            $this->default_homepage_list[] = 'collections';
        }

        if( config('channelsSection') == 'yes' ){
            $this->default_homepage_list[] = 'channels';
        }

        if( $user_id ){
            $params = [];
            $params['userid'] = $user_id;
            $params['first_only'] = true;
            $this->user_data = $this->getAll($params);
        }
    }

    /**
     * @throws Exception
     */
    public static function getInstance($user_id = null): self
    {
        if( empty($user_id) ){
            $user_id = user_id();
        }
        if( empty(self::$user[$user_id]) ){
            self::$user[$user_id] = new self($user_id);
        }
        return self::$user[$user_id];
    }

    public function getTableName(): string
    {
        return $this->tablename;
    }

    public function getTableNameProfile(): string
    {
        return $this->tablename_profile;
    }

    public function getTableNameLevel(): string
    {
        return $this->tablename_level;
    }

    private function getAllFields(): array
    {
        $fields_user = array_map(function($field) {
            return $this->getTableName() . '.' . $field;
        }, $this->fields);

        $fields_profile = array_map(function($field) {
            return $this->getTableNameProfile() . '.' . $field;
        }, $this->fields_profile);

        return array_merge($fields_user, $fields_profile);
    }

    public function getSearchLimit(): int
    {
        return $this->search_limit;
    }

    public function getDisplayBlock(): string
    {
        return LAYOUT . $this->display_block;
    }

    public function getDisplayVarName(): string
    {
        return $this->display_var_name;
    }

    public function getFilterParams(string $value, array $params): array
    {
        switch ($value) {
            case 'most_recent':
            default:
                $params['order'] = $this->getTableName() . '.doj DESC';
                break;

            case 'most_old':
                $params['order'] = $this->getTableName() . '.doj ASC';
                break;

            case 'most_viewed':
                $params['order'] = $this->getTableName() . '.profile_hits DESC';
                break;

            case 'featured':
                $params['featured'] = true;
                break;

            case 'top_rated':
                $params['order'] = $this->getTableNameProfile() . '.rating DESC';
                break;

            case 'most_items':
                if(config('videosSection') == 'yes' || config('photosSection') == 'yes') {
                    $params['order'] = '(' . $this->getTableName() . '.total_videos + ' . $this->getTableName() . '.total_photos)  DESC';
                }
                break;

            case 'most_commented':
                if( config('enable_comments_channel') == 'yes' ){
                    $params['order'] = $this->getTableName() . '.total_comments DESC';
                }
                break;

            case 'alphabetical':
                $params['order'] = $this->getTableName() . '.username ASC';
                break;

            case 'reverse_alphabetical':
                $params['order'] = $this->getTableName() . '.username DESC';
                break;

            case 'all_time':
            case 'today':
            case 'yesterday':
            case 'this_week':
            case 'last_week':
            case 'this_month':
            case 'last_month':
            case 'this_year':
            case 'last_year':
                $column = $this->getTableName() . '.doj';
                $params['condition'] = Search::date_margin($column, $value);
                $params['group'] = $column;
                break;
        }
        return $params;
    }

    /**
     * @throws Exception
     */
    public function getSortList(): array
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
            return [];
        }
       $sorts = SortType::getSortTypes('channels');

        if(config('videosSection') != 'yes' && config('photosSection') != 'yes') {
            unset($sorts[array_search('sort_most_items', $sorts)]);
        }

        if( config('enable_comments_channel') == 'yes' ){
            unset($sorts[array_search('most_commented', $sorts)]);
        }

        return $sorts;
    }

    /**
     * @throws Exception
     */
    public function getAll(array $params = [])
    {
        $param_userid = $params['userid'] ?? false;
        $param_not_userid = $params['not_userid'] ?? false;
        $param_search = $params['search'] ?? false;
        $param_channel_enable = $params['channel_enable'] ?? false;
        $param_email = $params['email'] ?? false;
        $param_username = $params['username'] ?? false;
        $param_username_strict = $params['username_strict'] ?? false;
        $param_status = $params['status'] ?? false;
        $param_ban_status = $params['ban_status'] ?? false;
        $param_featured = $params['featured'] ?? false;
        $param_level = $params['level'] ?? false;

        $param_condition = $params['condition'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_first_only = $params['first_only'] ?? false;

        $param_category = $params['category'] ?? false;

        $conditions = [];
        if( $param_userid ){
            $conditions[] = 'users.userid = ' . (int)$param_userid;
        }
        if( $param_not_userid !== false ){
            $conditions[] = 'users.userid != ' . (int)$param_not_userid;
        }
        if( $param_condition ){
            $conditions[] = '(' . $param_condition . ')';
        }

        if( $param_category ){
            $conditions[] = 'categories.category_id = ' . mysql_clean($param_category);
        }

        if( $param_email ){
            $conditions[] = 'users.email LIKE \'%' . mysql_clean($param_email) . '%\'';
        }

        if( $param_username ){
            $conditions[] = 'users.username LIKE \'%' . mysql_clean($param_username) . '%\'';
        }
        if( $param_username_strict ){
            $conditions[] = 'users.username LIKE \'' . mysql_clean( $param_username_strict) . '\'';
        }
        if( $param_status ){
            $conditions[] = 'users.usr_status = \'' . mysql_clean($param_status) . '\'';
        }

        if( $param_ban_status ){
            $conditions[] = 'users.ban_status = \'' . mysql_clean($param_ban_status) . '\'';
        }

        if( $param_featured ){
            $conditions[] = 'users.featured = \'' . mysql_clean($param_featured) . '\'';
        }

        if( $param_level ){
            $conditions[] = 'users.level = ' . (int)$param_level;
        }

        if( $param_search ){
            /* Search is done on username, profile tags and profile categories */
            $match_name = 'MATCH(users.username) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE)';
            $like_name = ' LOWER(users.username) LIKE \'%' . mysql_clean($param_search) . '%\'';
            $cond = '( ' . $match_name . ' OR ' . $like_name;
            $order_search = ' ORDER BY MAX(CASE WHEN '.$like_name . ' THEN 100 ELSE ' . $match_name . ' END ) DESC ';
            if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '264') ){
                $match_tag = 'MATCH(tags.name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE)';
                $like_tag = 'LOWER(tags.name) LIKE \'%' . mysql_clean($param_search) . '%\'';
                $cond .= 'OR ' . $match_tag . ' OR ' . $like_tag;
                $order_search .= ', MAX(CASE WHEN '. $like_tag . ' THEN 100 ELSE ' . $match_tag . ' END ) DESC ';
            }
            if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '331') && config('enable_user_category') == 'yes' ){
                $match_categ = 'MATCH(categories.category_name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE)';
                $like_categ = 'LOWER(categories.category_name) LIKE \'%' . mysql_clean($param_search) . '%\'';
                $cond .= 'OR ' . $match_categ . ' OR ' . $like_categ;
                $order_search .= ', MAX(CASE WHEN ' . $like_categ . ' THEN 100 ELSE ' . $match_categ . ' END ) DESC ';
            }
            $cond .= ')';

            $conditions[] = $cond;
        }

        $join = [];
        $group = [];
        if( $param_count ){
            $select = ['COUNT(DISTINCT users.userid) AS count'];
        } else {
            $select = $this->getAllFields();
            $select[] = $this->getTableNameLevel() . '.user_level_name';

            foreach ($this->fields as $field) {
                $group[] = $this->tablename . '.' . $field;
            }

            foreach ($this->fields_profile as $field) {
                $group[] = $this->tablename_profile . '.' . $field;
            }
        }

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '264') ){
            if ($param_search || $param_condition || !$param_count) {
                $join[] = 'LEFT JOIN ' . cb_sql_table('user_tags') . ' ON users.userid = user_tags.id_user';
                $join[] = 'LEFT JOIN ' . cb_sql_table('tags') . ' ON user_tags.id_tag = tags.id_tag';
            }
            if( !$param_count ){
                $select[] = 'GROUP_CONCAT( DISTINCT(tags.name) SEPARATOR \',\') AS tags';
                $group[] = 'users.userid';
                if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '199')) {
                    $group[] = 'user_levels_permissions.id_user_levels_permission ';
                }
            }

        }

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '331') && config('enable_user_category') == 'yes' ){
            if ($param_search || $param_category || $param_condition || !$param_count) {
                $join[] = 'LEFT JOIN ' . cb_sql_table('users_categories') . ' ON users.userid = users_categories.id_user';
                $join[] = 'LEFT JOIN ' . cb_sql_table('categories') . ' ON users_categories.id_category = categories.category_id';
            }
            if (!$param_count) {
                $select[] = 'GROUP_CONCAT( DISTINCT(categories.category_id) SEPARATOR \',\') AS category, GROUP_CONCAT( DISTINCT(categories.category_name) SEPARATOR \', \') AS category_names';
                $select[] = 'CONCAT(\'[\', GROUP_CONCAT(DISTINCT JSON_OBJECT(\'id\', categories.category_id, \'name\', categories.category_name)),\']\') AS category_list';
            }
        }

        if( $param_group && !$param_count ){
            $group[] = $param_group;
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '136')) {
            if ($param_channel_enable) {
                if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '199')) {
                    $conditions[] = '(' . UserLevel::getTableNameLevelPermissionValue() . '.permission_value = \'yes\' AND ' . $this->getTableNameProfile() . '.disabled_channel = \'no\')';
                } else {
                    $conditions[] = '(' . UserLevel::getTableNameLevelPermission() . '.enable_channel_page = \'yes\' AND ' . $this->getTableNameProfile() . '.disabled_channel = \'no\')';
                }
            }
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '199')) {
                $is_channel_enable = '(' . UserLevel::getTableNameLevelPermissionValue() . '.permission_value = \'yes\' AND ' . $this->getTableNameProfile() . '.disabled_channel != \'yes\')';
                $join[] = '  INNER JOIN ' . cb_sql_table(UserLevel::getTableNameLevelPermissionValue()) . ' ON ' . UserLevel::getTableNameLevelPermissionValue() . '.user_level_id = ' . $this->getTableNameLevel() . '.user_level_id ';
                $join[] = '  INNER JOIN ' . cb_sql_table(UserLevel::getTableNameLevelPermission()) . ' ON ' . UserLevel::getTableNameLevelPermissionValue() . '.id_user_levels_permission = ' . UserLevel::getTableNameLevelPermission() . '.id_user_levels_permission  
                AND ' . UserLevel::getTableNameLevelPermission() . '.permission_name = \'enable_channel_page\' ';
            } else {
                $is_channel_enable = '(' .   UserLevel::getTableNameLevelPermission() . '.enable_channel_page = \'yes\' AND ' . $this->getTableNameProfile() . '.disabled_channel != \'yes\')';
            }

            if (!$param_count) {
                $select[] = $is_channel_enable . ' AS is_channel_enable';
                $group[] = $is_channel_enable;
            }
        }

        $having = '';
        if( $param_having ){
            $having = ' HAVING '.$param_having;
        }

        $order = '';
        if (!empty($order_search)) {
            $order = $order_search;
        } elseif ($param_order) {
            $order = ' ORDER BY ' . $param_order;
        }
        $limit = '';
        if( $param_limit ){
            $limit = ' LIMIT '.$param_limit;
        }
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '199')) {
            $join[] = ' INNER JOIN ' . cb_sql_table(UserLevel::getTableNameLevelPermission()) . ' ON ' . UserLevel::getTableNameLevelPermission() . '.user_level_id = ' . $this->getTableNameLevel() . '.user_level_id ';
        }
        $sql ='SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table('users') . '
                LEFT JOIN ' . cb_sql_table($this->getTableNameProfile()) . ' ON users.userid = ' . $this->getTableNameProfile() . '.userid
                INNER JOIN ' . cb_sql_table($this->getTableNameLevel()) . ' ON users.level = ' . $this->getTableNameLevel() . '.user_level_id '

            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(',', $group))
            . $having
            . $order
            . $limit;
        $result = Clipbucket_db::getInstance()->_select($sql);

        if( $param_count ){
            if( empty($result) ){
                return 0;
            }
            return $result[0]['count'];
        }

        if( !$result ){
            return false;
        }

        if( $param_first_only ){
            return $result[0];
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function getOne(array $params = [])
    {
        $params['first_only'] = true;
        return $this->getAll($params);
    }

    /**
     * @throws Exception
     */
    public function getCurrentUserAge()
    {
        if( empty($this->user_data) ){
            return false;
        }

        $current_date = new DateTime();
        $date_of_birth = new DateTime($this->user_data['dob']);
        $diff = $current_date->diff($date_of_birth);
        return $diff->y;
    }

    public function isUserConnected(): bool
    {
        return !empty($this->user_data);
    }

    /**
     * @param string $permission
     * @return bool
     * @throws Exception
     */
    public function hasPermission(string $permission): bool
    {
        return UserLevel::hasPermission($permission,$this->getCurrentUserLevelID());
    }

    /**
     * @param string $permission
     * @param bool $must_be_logged
     * @return bool
     * @throws Exception
     */
    public function hasPermissionOrRedirect(string $permission, bool $must_be_logged = false): bool
    {
        return UserLevel::hasPermissionOrRedirect($permission, $this->getCurrentUserLevelID(), $must_be_logged);
    }

    public function isUserConnectedOrRedirect(): void
    {
        if (!$this->isUserConnected()) {
            self::redirectToLogin();
        }
    }

    public static function redirectToLogin(): void
    {
        redirect_to(cblink(['name' => 'signin']));
    }

    /**
     * @throws Exception
     */
    public function hasAdminAccess(): bool
    {
        return $this->hasPermission('admin_access');
    }

    /**
     * @param string $permission
     * @return void
     * @throws Exception
     */
    public function hasPermissionAjax(string $permission): void
    {
        if (!$this->hasPermission($permission)) {
            e(lang('insufficient_privileges'));
            echo json_encode([
                'template' => false,
                'success' => false,
                'msg'     => getTemplateMsg()
            ]);
            die;
        }
    }

    /**
     * @param $config
     * @return false|mixed
     * @throws Exception
     */
    public function getConfig($config)
    {
        return UserLevel::getPermission($config, $this->getCurrentUserLevelID());
    }

    public function getCurrentUserID()
    {
        return $this->user_data['userid'] ?? false;
    }
    public function getCurrentUserLevelID()
    {
        return $this->user_data['level'] ?? false;
    }

    /**
     * @throws Exception
     */
    public function delBackground($userid): void
    {
        $user = self::getOne(['userid'=>$userid]);
        $user_background = $user['background'];

        if( !empty($user_background) ){
            $file = DirPath::get('backgrounds') . $user_background;
            if( file_exists($file) ){
                unlink($file);
            }
            Clipbucket_db::getInstance()->update(tbl('users'), ['background'], [''], ' userid = ' . mysql_clean($userid));
        }
    }

    public static function getClean(string $content, $no_edit = false): string
    {
        $params = [];
        if( !$no_edit ){
            $params = [
                'censor' => (config('enable_user_profil_censor') == 'yes'),
                'functionList' => 'user_profil',
                'links' => true
            ];
        }

        return CMS::getInstance($content, $params)->getClean();
    }

    public function get(string $value)
    {
        if( !array_key_exists($value, $this->user_data) ){
            DiscordLog::sendDump($this->user_data);
            if( System::isInDev() ){
                $msg = 'User->get() - Unknown value : ' . $value . '```' . debug_backtrace_string() . '```';
                error_log($msg);
                DiscordLog::sendDump($msg);
            }
            return false;
        }
        return $this->user_data[$value];
    }

    /**
     * @throws Exception
     */
    public function getLink(string $type): string
    {
        $seo_enabled = (config('seo') == 'yes');

        switch($type)
        {
            case 'channel':
                $username = display_clean($this->get('username'));
                $base_link = cblink(['name' => 'view_channel']);
                if( $seo_enabled ){
                    return $base_link . $username;
                }
                return $base_link . '?user=' . $username;

            default:
                if( System::isInDev() ){
                    $msg = 'User->getLink() - Unknown type : ' . $type;
                    error_log($msg);
                    DiscordLog::sendDump($msg);
                }
                return '';
        }
    }

    /**
     * @return int
     */
    public function getAvatarUsage():int
    {
        $uid = $this->get('userid');
        $total = 0;
        $path = DirPath::get('avatars') . $uid . '[.-]*';
        $files = glob($path);
        foreach ($files as $file) {
            if (file_exists($file)){
                $total += filesize($file);
            }
        }
        return $total;
    }
    /**
     * @return int
     */
    public function getBackgroundImageUsage():int
    {
        $uid = $this->get('userid');
        $total = 0;
        $path = DirPath::get('backgrounds') . $uid . '[.-]*';
        $files = glob($path);
        foreach ($files as $file) {
            if (file_exists($file)){
                $total += filesize($file);
            }
        }
        return $total;
    }

    /**
     * @param string|int $userid
     * @return bool|mysqli_result
     * @throws Exception
     */
    public static function calcUserStorage($userid)
    {
        $total = 0;
        $photos = \Photo::getInstance()->getAll(['userid' => $userid]);
        foreach ($photos as $photo) {
            $total += \Photo::getInstance()->getUsage($photo['photo_id'], $photo['filename'], $photo['file_directory'], $photo['ext'], $photo['photo_key']);
        }

        $videos = Video::getInstance()->getAll(['userid' => $userid]);
        foreach ($videos as $video) {
            $total += Video::getInstance()->getStorageUsage($video['videoid']);
        }

        $total += self::getInstance($userid)->getBackgroundImageUsage();
        $total += self::getInstance($userid)->getAvatarUsage();

        $sql = 'INSERT INTO ' . tbl('users_storage_histo') . '(id_user, storage_used) VALUES (' . (int)$userid . ', ' . (int)$total . ')';
        return Clipbucket_db::getInstance()->execute($sql);
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getLastStorageUseByUser(): int
    {
        $uid = $this->get('userid');
        $sql = 'SELECT storage_used FROM ' . tbl('users_storage_histo') . ' WHERE id_user = ' . (int)$uid . ' AND datetime = (
                    SELECT MAX(datetime)
                    FROM ' . tbl('users_storage_histo') . '
                    WHERE id_user = ' . (int)$uid . '
                ) ';
        $results = Clipbucket_db::getInstance()->_select($sql);
        if (empty($results)) {
            return 0;
        }
        return $results[0]['storage_used'];
    }

    /**
     * @param int|string $userid
     * @param string $date_start
     * @param string $date_end
     * @return int
     * @throws Exception
     */
    public function getPeriodMaxStorageUseByUser(int $userid, string $date_start, string $date_end): int
    {
        $sql = 'SELECT MAX(storage_used) AS storage_used FROM ' . tbl('users_storage_histo') . ' 
        WHERE id_user = ' . mysql_clean($userid) . ' 
        AND datetime BETWEEN \'' . mysql_clean($date_start) . '\' AND \'' . mysql_clean($date_end) . '\' 
        GROUP BY id_user ';
        $results = Clipbucket_db::getInstance()->_select($sql);
        if (empty($results)) {
            return 0;
        }
        return $results[0]['storage_used'];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getStorageHistoryByUser(): array
    {
        $uid = $this->get('userid');
        $sql = 'select date(datetime) as date_histo, storage_used from ' . tbl('users_storage_histo') . ' where id_user = ' . (int)$uid;
        $results = Clipbucket_db::getInstance()->_select($sql);
        if (empty($results)) {
            return [];
        }
        return $results;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function removeUserFromContact(): void
    {
        $uid = $this->get('userid');
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('contacts') . ' WHERE userid = ' . $uid . ' OR contact_userid = ' . $uid);
    }

    /**
     * @return void
     */
    public function cleanUserFeed(): void
    {
        $uid = $this->get('userid');
        $userfeeds = rglob(DirPath::get('userfeeds') . $uid . DIRECTORY_SEPARATOR . '*.feed');
        foreach ($userfeeds as $userfeed) {
            unlink($userfeed);
        }
        if (is_dir(DirPath::get('userfeeds') . $uid)) {
            rmdir(DirPath::get('userfeeds') . $uid);
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getFavoritesVideos(): array
    {
        $uid = $this->get('userid');
        $sql = ' SELECT id AS videoid FROM ' . tbl('favorites') . ' WHERE userid = ' . (int)$uid . ' AND type=\'v\'';
        $results = Clipbucket_db::getInstance()->_select($sql);
        if ( empty($results)) {
            return [];
        }
        return array_column($results, 'videoid');
    }

    public function getActiveTheme(): string
    {
        if( config('enable_theme_change') != 'yes' || !in_array(config('default_theme'), ['dark', 'light']) || !Session::isCookieConsent('user_theme')) {
            return config('default_theme');
        }

        if ($this->isUserConnected() && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '313')) {
            if( in_array($this->get('active_theme'), ['light','dark','auto']) ){
                if( in_array( $this->get('active_theme'), ['light','dark'] ) ){
                    return $this->get('active_theme');
                }
                if( empty($_COOKIE['user_theme_os']) || !Session::isCookieConsent('user_theme_os') ){
                    return $this->get('active_theme');
                }
                if( !in_array($_COOKIE['user_theme_os'], ['light','dark']) ){
                    return $this->get('active_theme');
                }
                return $_COOKIE['user_theme_os'];
            }
            return config('default_theme');
        }

        if( isset($_COOKIE['user_theme']) && in_array($_COOKIE['user_theme'], ['light','dark','auto']) ){
            if( in_array( $_COOKIE['user_theme'], ['light','dark'] ) ){
                return $_COOKIE['user_theme'];
            }
            if( !in_array($_COOKIE['user_theme_os'], ['light','dark']) ){
                return $_COOKIE['user_theme'];
            }
            return $_COOKIE['user_theme_os'];
        }
        return config('default_theme');
    }

    public function getUserTheme(): string
    {
        if( config('enable_theme_change') != 'yes' || !in_array(config('default_theme'), ['dark', 'light']) || !Session::isCookieConsent('user_theme')) {
            return config('default_theme');
        }

        return $_COOKIE['user_theme'] ?? $this->getActiveTheme();
    }
    /**
     * @throws Exception
     */
    public function getUserLevels(): array
    {
        $sql = ' SELECT user_levels.*, IF(users.userid IS NULL, FALSE, TRUE) AS has_users FROM ' . cb_sql_table('user_levels') . ' 
            LEFT JOIN '.cb_sql_table('users').' ON users.level = user_level_id 
                WHERE user_level_name != \'anonymous\' 
                GROUP BY user_level_id, has_users
                ORDER BY  user_level_id ';
        $results = Clipbucket_db::getInstance()->_select($sql);
        if ( empty($results)) {
            return [];
        }
        return $results;
    }

    /**
     * @param int $user_level_id
     * @param bool $activate
     * @return bool
     * @throws Exception
     */
    public function toggleUserLevelActivation(int $user_level_id, bool $activate): bool
    {
        if(empty($user_level_id)) {
            return false;
        }

        // Prevent disabling inactive user & guest
        if( in_array($user_level_id, [3,4]) ){
            return false;
        }

        $levelDetails = userquery::getInstance()->get_level_details($user_level_id);
        if( empty($levelDetails) ){
            return false;
        }
        $sql = 'UPDATE ' . cb_sql_table('user_levels') . ' SET user_level_active = ' . ($activate ? '\'yes\'' : '\'no\'' ) . ' WHERE user_level_id = ' . mysql_clean($user_level_id) ;
        return (bool)Clipbucket_db::getInstance()->execute($sql);
    }

    /**
     * @return void
     * @throws Exception
     */
    public static function redirectAfterLogin()
    {
        if ($_COOKIE['pageredir']) {
            redirect_to($_COOKIE['pageredir']);
        } else {
            redirect_to(User::getInstance()->getDefaultHomepageFromUserLevel());
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getDefaultHomepageFromUserLevel(): string
    {
        $default_hompepage = UserLevel::getPermission('default_homepage', $this->getCurrentUserLevelID());
        if (empty($default_hompepage)) {
            return '';
        }

        switch ($default_hompepage) {
            case 'homepage':
                $link = '';
                break;
            case 'public_videos':
                $link = 'videos_public.php';
                break;
            case 'my_account':
                $link = 'myaccount.php';
                break;
            default:
                $link = $default_hompepage . '.php';
        }
        return Network::get_server_url() . $link;
    }

    public function getDefaultHomepageList()
    {
        return $this->default_homepage_list;
    }

    /**
     * @throws Exception
     */
    public function setActiveTheme(string $theme, string $os): bool
    {
        if ( !in_array($theme,['light','dark','auto']) || !Session::isCookieConsent('user_theme') ){
            return false;
        }
        if ( $theme == 'auto' && !Session::isCookieConsent('user_theme_os') ){
            return false;
        }

        if ($this->isUserConnected() && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '313')) {
            //set to bd
            Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('users') . ' SET active_theme = \'' . mysql_clean($theme) . '\'');
        }
        Session::setCookie('user_theme', $theme);

        if( Session::isCookieConsent('user_theme_os') ){
            Session::setCookie('user_theme_os', $os);
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function delete(): void
    {
        if( !$this->hasAdminAccess() &&
            (config('enable_user_self_deletion') != 'yes' || $this->get('userid') != user_id()) ){
            e(lang('you_cant_delete_this_user'));
            return;
        }

        $uid = $this->get('userid');

        // Delete reports
        Flag::unFlagByElementId($uid, 'user');
        // Delete categories
        Category::getInstance()->unlinkAll('user', $uid);
        // Delete tags
        Tags::deleteTags('profile', $uid);
        // Delete user feeds
        $this->cleanUserFeed();
        // Delete user contacts
        $this->removeUserFromContact();
        // Delete channel comments
        $params = [
            'type' => 'channel',
            'type_id' => $uid
        ];
        Comments::delete($params);
        // Delete user Comments
        $params = [
            'userid' => $uid
        ];
        Comments::delete($params);
        // Delete user collections
        $collections = Collection::getInstance()->getAll(['userid' => $uid]);
        foreach ($collections as $collection) {
            Collections::getInstance()->delete_collection($collection['collection_id']);
        }
        // Delete user playlists
        $playlists = Playlist::getInstance()->getAll(['userid' => $uid]);
        foreach ($playlists as $playlist) {
            CBvideo::getInstance()->action->delete_playlist($playlist['playlist_id']);;
        }
        // Delete user photos
        $photos = \Photo::getInstance()->getAll(['userid' => $uid]);
        foreach ($photos as $photo) {
            CBPhotos::getInstance()->delete_photo($photo['photo_id']);
        }
        // Delete user videos
        $videos = Video::getInstance()->getAll(['userid' => $uid]);
        foreach ($videos as $video) {
            CBvideo::getInstance()->delete_video($video['videoid']);
        }

        //list of functions to perform while deleting a video
        $del_user_funcs = userquery::getInstance()->delete_user_functions;
        if (is_array($del_user_funcs)) {
            foreach ($del_user_funcs as $func) {
                if (function_exists($func)) {
                    $func($this->user_data);
                }
            }
        }

        //Removing Subscriptions and subscribers
        userquery::getInstance()->remove_user_subscriptions($uid);
        userquery::getInstance()->remove_user_subscribers($uid);
        //Deleting User PMS
        userquery::getInstance()->remove_user_pms($uid);

        $anonymous_id = userquery::getInstance()->get_anonymous_user();
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('flags') . ' SET userid=\'' . $anonymous_id . '\' WHERE userid=' . (int)$uid);

        Clipbucket_db::getInstance()->delete(tbl('video_users'), ['userid'], [(int)$uid]);
        //Finally Removing Database entry of user
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('users_storage_histo') . ' WHERE id_user =' . (int)$uid);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('email_histo') . ' WHERE userid =' . (int)$uid);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('favorites') . ' WHERE userid =' . (int)$uid);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('user_profile') . ' WHERE userid =' . (int)$uid);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('users') . ' WHERE userid =' . (int)$uid);
    }
    
    public function getNotificationInbox()
    {
        if (empty($this->user_notification_inbox)) {
            $this->user_notification_inbox = userquery::getInstance()->get_unread_msgs($this->getCurrentUserID());
        }
        return $this->user_notification_inbox;
    }
    
    public function getNotificationContact()
    {
        if (empty($this->user_notification_contact)) {
            $this->user_notification_contact = userquery::getInstance()->get_pending_contacts($this->getCurrentUserID(), count_only: true);
        }
        return $this->user_notification_contact;
    }

}

class userquery extends CBCategory
{
    private static self $instance;

    /**
     * @throws Exception
     */
    public static function getInstance(): self
    {
        if( empty(self::$instance) ){
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    var $userid = '';
    var $username = '';
    var $email = '';
    var $level = '';
    var $access_type_list = []; //Access list
    var $custom_signup_fields = [];
    var $custom_profile_fields = [];
    var $custom_profile_fields_groups = [];
    var $delete_user_functions = [];
    var $logout_functions = [];
    var $user_account = [];
    var $sessions = '';
    var $is_login = false;

    var $dbtbl = [
        'user_permission_type'  => 'user_permission_types',
        'user_permissions'      => 'user_permissions',
        'user_level_permission' => 'user_levels_permissions',
        'user_profile'          => 'user_profile',
        'users'                 => 'users',
        'action_log'            => 'action_log',
        'subtbl'                => 'subscriptions',
        'contacts'              => 'contacts'
    ];

    var $udetails = [];

    private $basic_fields = [];
    private $extra_fields = [];

    function __construct()
    {
        global $cb_columns;

        $this->cat_tbl = 'users_categories';

        $basic_fields = [
            'userid', 'username', 'email', 'avatar', 'sex', 'avatar_url',
            'dob', 'level', 'usr_status', 'user_session_key', 'featured',
            'ban_status', 'total_photos', 'profile_hits', 'total_videos',
            'subscribers', 'total_subscriptions'
        ];

        $cb_columns->object('users')->register_columns($basic_fields);
    }

    /**
     * @throws Exception
     */
    function init(): void
    {
        $this->sessions = $this->get_sessions();

        if ($this->sessions['smart_sess']) {
            $this->userid = $this->sessions['smart_sess']['session_user'];
            $this->is_login = !empty($this->userid);
        }

        $udetails = '';

        if ($this->userid) {
            $udetails = $this->get_user_details($this->userid );
            $user_profile = $this->get_user_profile($this->userid);
            if ($udetails && $user_profile) {
                $udetails['profile'] = $user_profile;
            }
        }

        if ($udetails) {
            $this->udetails = $udetails;
            $this->username = $udetails['username'];
            $this->level = $this->udetails['level'];
            $this->email = $this->udetails['email'];

            //Calling Logout Functions
            $funcs = $this->init_login_functions ?? false;
            if (is_array($funcs) && count($funcs) > 0) {
                foreach ($funcs as $func) {
                    if (function_exists($func)) {
                        $func();
                    }
                }
            }

            if (Session::getInstance()->get('dummy_username') == '') {
                $this->UpdateLastActive(user_id());
            }
        }

        //Adding Actions such Report, share,fav etc
        $this->action = new cbactions();
        $this->action->type = 'u';
        $this->action->name = 'user';
        $this->action->obj_class = self::class;
        $this->action->check_func = 'user_exists';
        $this->action->type_tbl = $this->dbtbl['users'];
        $this->action->type_id_field = 'userid';

        define('AVATAR_SIZE', config('max_profile_pic_width'));
        define('AVATAR_SMALL_SIZE', 40);
        if (isSectionEnabled('channels')) {
            ClipBucket::getInstance()->search_types['channels'] = 'userquery';
        }
    }

    /**
     * Function used to create user session key
     */
    function create_session_key($session, $pass): string
    {
        $newkey = $session . $pass;
        return md5($newkey);
    }

    /**
     * Function used to create user session code
     * just for session authentication incase user wants to login again
     */
    function create_session_code(): int
    {
        return rand(10000, 99999);
    }

    /**
     * @return array
     */
    function get_basic_fields(): array
    {
        return $this->basic_fields;
    }

    function set_basic_fields($fields = [])
    {
        return $this->basic_fields = $fields;
    }

    function basic_fields_setup()
    {
        # Set basic video fields
        $basic_fields = [
            'userid', 'username', 'email', 'avatar', 'sex', 'avatar_url',
            'dob', 'level', 'usr_status', 'user_session_key', 'total_photos', 'profile_hits', 'total_videos', 'total_subscriptions'
        ];

        return $this->set_basic_fields($basic_fields);
    }

    function get_extra_fields(): array
    {
        return $this->extra_fields;
    }

    function set_extra_fields($fields = [])
    {
        return $this->extra_fields = $fields;
    }

    function get_user_db_fields($extra_fields = [])
    {
        $fields = $this->get_basic_fields();
        $extra = $this->get_extra_fields();

        if (empty($fields)) {
            $fields = $this->basic_fields_setup();
        }

        if (!empty($extra)) {
            $fields = array_merge($fields, $extra);
        }

        if (!empty($extra_fields)) {
            if (is_array($extra_fields)) {
                $fields = array_merge($fields, $extra_fields);
            } else {
                $fields[] = $extra_fields;
            }
        }

        # Do make array unique, otherwise we might get duplicate
        # fields
        return array_unique($fields);
    }

    function add_user_field($field)
    {
        $extra_fields = $this->get_extra_fields();

        if (is_array($field)) {
            $extra_fields = array_merge($extra_fields, $field);
        } else {
            $extra_fields[] = $field;
        }

        return $this->set_extra_fields($extra_fields);
    }

    /**
     * Neat and clean function to login user
     * this function was made for v2.x with User Level System
     * param VARCHAR $username
     * param TEXT $password
     *
     * @param      $username
     * @param      $password
     * @param bool $remember
     *
     * @return bool
     * @throws Exception
     */
    function login_user($username, $password, $remember = false): bool
    {
        //First we will check weather user is already logged in or not
        if (User::getInstance()->isUserConnected()) {
            $msg[] = e(lang('you_already_logged'));
        } else {
            $udetails = $this->authenticate($username, $password);
            if (!$udetails) {
                $msg = e(lang('usr_login_err'));
            } elseif (strtolower($udetails['usr_status']) != 'ok') {
                $msg = e(lang('user_inactive_msg'), 'e', false);
            } elseif ($udetails['ban_status'] == 'yes') {
                $msg = e(lang('usr_ban_err'));
            } else {
                if ($remember) {
                    Session::getInstance()->timeout = 86400 * 7;
                }
                return $this->init_session($udetails);
            }
        }

        //Error Logging
        if (!empty($msg)) {
            //Logging Action
            $log_array['success'] = 'no';
            $log_array['details'] = $msg['val'];
            $log_array['username'] = $username;
            insert_log('Login', $log_array);
        }
        return false;
    }

    /**
     * @param $username
     * @param $password
     * @return array|bool
     * @throws Exception
     */
    function authenticate($username, $password)
    {
        $user = $this->get_user_id($username);
        if (!$user) {
            return false;
        } else {
            $uid = $user['userid'];
            $pass = pass_code($password, $uid);
            $udetails = $this->get_user_with_pass($username, $pass);

            // This code is used to update user password hash, may be deleted someday
            if (!$udetails) // Let's try old password method
            {
                $oldpass = pass_code_unsecure($password);
                $udetails = $this->get_user_with_pass($username, $oldpass);

                // This account still use old password method, let's update it
                if ($udetails) {
                        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.0.0', '1') ){
                            Clipbucket_db::getInstance()->update(tbl('users'), ['password'], [$pass], ' userid=\'' . (int)$uid . '\'');
                    }
                }
            }

        }
        return $udetails ?? false;
    }

    /**
     * @throws Exception
     */
    function init_session($udetails)
    {
        //Starting special sessions for security
        $session_salt = RandomString(5);
                    $_SESSION['sess_salt'] = $session_salt;
        Session::getInstance()->set('PHPSESSID',  Session::getInstance()->id);

        $smart_sess = md5($udetails['user_session_key'] . $session_salt);

        Clipbucket_db::getInstance()->delete(tbl('sessions'), ['session', 'session_string'], [ Session::getInstance()->id, 'guest']);
        Session::getInstance()->add_session($udetails['userid'], 'smart_sess', $smart_sess);

        //Setting Vars
        $this->userid = $udetails['userid'];
        $this->username = $udetails['username'];
        $this->level = $udetails['level'];
        $this->is_login = true;

        //Updating User last login , num of visits and ip
        Clipbucket_db::getInstance()->update(tbl('users'),
            ['num_visits', 'last_logged', 'ip'],
                        ['|f|num_visits+1', now(), Network::get_remote_ip()],
            'userid=\'' . $udetails['userid'] . '\''
        );

        $this->init();

        //Logging Action
        $log_array = [
            'username'  => $udetails['username'],
            'userid'    => $udetails['userid'],
            'useremail' => $udetails['email'],
            'success'   => 'yes',
            'level'     => $udetails['level']
        ];
        insert_log('Login', $log_array);
        return true;
    }

    /**
     * Function used to get user details using username and password
     *
     * @param $username
     * @param $pass
     *
     * @return bool|array
     * @throws Exception
     */
    function get_user_with_pass($username, $pass)
    {
        $results = Clipbucket_db::getInstance()->select(tbl('users'),
            'userid,email,level,usr_status,user_session_key,user_session_code,ban_status',
            "(username='$username' OR userid='$username') AND password='$pass'");
        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * @throws Exception
     */
    function get_user_id($username)
    {
        $results = Clipbucket_db::getInstance()->select(tbl('users'), 'userid', "(username='$username' OR BINARY userid='$username')");
        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * @throws Exception
     */
    function logout(): void
    {
        //Calling Logout Functions
        $funcs = $this->logout_functions;
        if (is_array($funcs) && count($funcs) > 0) {
            foreach ($funcs as $func) {
                if (function_exists($func)) {
                    $func();
                }
            }
        }

        Session::getInstance()->destroy();
    }

    /**
     * Function used to delete user
     *
     * @param $uid
     *
     * @throws Exception
     */
    function delete_user($uid): void
    {
        if( !$this->user_exists($uid) ){
            e(lang('user_doesnt_exist'));
            return;
        }

        if( user_id() == $uid || !User::getInstance()->hasAdminAccess() ){
            e(lang('you_cant_delete_this_user'));
            return;
        }

        $udetails = $this->get_user_details($uid);

        //list of functions to perform while deleting a video
        $del_user_funcs = $this->delete_user_functions;
        if (is_array($del_user_funcs)) {
            foreach ($del_user_funcs as $func) {
                if (function_exists($func)) {
                    $func($udetails);
                }
            }
        }

        //Removing Subscriptions and subscribers
        $this->remove_user_subscriptions($uid);
        $this->remove_user_subscribers($uid);

        //delete reports for this user
        Flag::unFlagByElementId($uid, 'user');

        $anonymous_id = $this->get_anonymous_user();
        //Changing User Videos To Anonymous
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('video') . ' SET userid=\'' . $anonymous_id . '\' WHERE userid=' . (int)$uid);
        //Deleting User Contacts
        User::getInstance($uid)->removeUserFromContact();

        //Deleting User PMS
        $this->remove_user_pms($uid);
        //Changing From Messages to Anonymous
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('messages') . ' SET message_from=\'' . $anonymous_id . '\' WHERE message_from=' . (int)$uid);
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('photos') . ' SET userid=\'' . $anonymous_id . '\' WHERE userid=' . (int)$uid);
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('collections') . ' SET userid=\'' . $anonymous_id . '\' WHERE userid=' . (int)$uid);
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('collection_items') . ' SET userid=\'' . $anonymous_id . '\' WHERE userid=' . (int)$uid);
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('playlists') . ' SET userid=\'' . $anonymous_id . '\' WHERE userid=' . (int)$uid);
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('playlist_items') . ' SET userid=\'' . $anonymous_id . '\' WHERE userid=' . (int)$uid);
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('flags') . ' SET userid=\'' . $anonymous_id . '\' WHERE userid=' . (int)$uid);

        //Removing channel Comments
        $params = [];
        $params['type'] = 'channel';
        $params['type_id'] = $uid;
        Comments::delete($params);

        //Remove tags
        Tags::deleteTags('profile', $uid);
        //Remove categories
        Category::getInstance()->unlinkAll('user', $uid);

        //Finally Removing Database entry of user
        Clipbucket_db::getInstance()->delete(tbl('video_users'), ['userid'], [(int)$uid]);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('users_storage_histo') . ' WHERE id_user =' . (int)$uid);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('email_histo') . ' WHERE userid =' . (int)$uid);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('favorites') . ' WHERE userid =' . (int)$uid);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('user_profile') . ' WHERE userid =' . (int)$uid);
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('users') . ' WHERE userid =' . (int)$uid);

        User::getInstance($uid)->cleanUserFeed();

        if( empty(errorhandler::getInstance()->get_error()) ){
            e(lang('usr_del_msg'), 'm');
        }
    }

    /**
     * Remove all user subscriptions
     *
     * @param $uid
     * @throws Exception
     */
    function remove_user_subscriptions($uid): void
    {
        if (!$this->user_exists($uid)) {
            e(lang('user_doesnt_exist'));
        } elseif (!User::getInstance()->hasAdminAccess()) {
            e(lang('you_dont_hv_perms'));
        } else {
            Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl($this->dbtbl['subtbl']) . ' WHERE userid=\'' . $uid . '\'');
            e(lang('user_subs_hv_been_removed'), 'm');
        }
    }

    /**
     * Remove all user subscribers
     *
     * @param $uid
     * @throws Exception
     */
    function remove_user_subscribers($uid): void
    {
        if (!$this->user_exists($uid)) {
            e(lang('user_doesnt_exist'));
        } elseif (!User::getInstance()->hasAdminAccess()) {
            e(lang('you_dont_hv_perms'));
        } else {
            Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl($this->dbtbl['subtbl']) . ' WHERE subscribed_to=\'' . $uid . '\'');
            e(lang('user_subsers_hv_removed'), 'm');
        }
    }

    /**
     * @throws Exception
     */
    function user_exists($id, $global = false): bool
    {
        if (is_numeric($id)) {
            $field = 'userid';
        } else {
            $field = 'username';
        }
        $result = Clipbucket_db::getInstance()->count(tbl($this->dbtbl['users']), 'userid', $field.'=\'' . $id . '\'', '',60);

        if ($result > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to get user details using userid
     *
     * @param null $id
     * @param bool $checksess
     * @param bool $email
     *
     * @return bool|STRING
     * @throws Exception
     */
    function get_user_details($id = null, $checksess = false, $email = false)
    {
        $is_email = str_contains($id, '@');
        $select_field = (!$is_email && !is_numeric($id)) ? 'username' : (!is_numeric($id) ? 'email' : 'userid');

        if (!$email) {
            $params = ['users' => ['*']];
            if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '331') ){
                $params['users_categories'] = ['id_category'];
            }
            $fields = table_fields($params);
        } else {
            $fields = table_fields(['users' => ['email']]);
        }

        $query = 'SELECT '.$fields.' FROM ' . cb_sql_table('users');
        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '331') ){
            $query .= ' LEFT JOIN ' . cb_sql_table('users_categories') . ' ON users.userid = users_categories.id_user';
        }
        $query .= " WHERE users.$select_field = '$id'";

        $result = select($query, 60);

        if ($result) {
            $details = $result[0];

            if (!$checksess) {
                return apply_filters($details, 'get_user');
            }

            $session = $this->sessions['smart_sess'];
            $smart_sess = md5($details['user_session_key'] . $_SESSION['sess_salt']);

            if ($smart_sess == $session['session_value']) {
                $this->is_login = true;
                return apply_filters($details, 'get_user');
            }
        }

        return false;
    }

    /**
     * @throws Exception
     */
    function activate_user_with_avcode($user, $avcode): void
    {
        $data = $this->get_user_details($user);
        if (!$data || !$user) {
            e(lang("usr_exist_err"));
        } elseif ($data['usr_status'] == 'Ok') {
            e(lang('usr_activation_err'));
        } elseif ($data['ban_status'] == 'yes') {
            e(lang('ban_status'));
        } elseif ($data['avcode'] != $avcode) {
            e(lang('avcode_incorrect'));
        } else {
            $this->action('activate', $data['userid']);
            errorhandler::getInstance()->flush();
            e(lang("usr_activation_msg"), "m");

            if ($data['welcome_email_sent'] == 'no') {
                $this->send_welcome_email($data, true);
            }
        }
    }

    /**
     * Function used to send activation code
     * to user
     *
     * @param : $usenrma,$email or $userid
     *
     * @throws Exception
     */
    function send_activation_code($email): void
    {
        $udetails = $this->get_user_details($email);

        if (!$udetails || !$email) {
            e(lang('usr_exist_err'));
        } elseif ($udetails['usr_status'] == 'Ok') {
            e(lang('usr_activation_err'));
        } elseif ($udetails['ban_status'] == 'yes') {
            e(lang('ban_status'));
        } else {
            $var = ['avcode'   => $udetails['avcode']];
            //Now Finally Sending Email
            EmailTemplate::sendMail('avcode_request', $udetails['userid'],  $var);
            e(lang('usr_activation_em_msg'), 'm');
        }
    }

    /**
     * Function used to send welcome email
     *
     * @param      $user
     * @param bool $update_email_status
     *
     * @throws Exception
     */
    function send_welcome_email($user, $update_email_status = false): void
    {
        if (!is_array($user)) {
            $udetails = $this->get_user_details($user);
        } else {
            $udetails = $user;
        }

        if (!$udetails) {
            e(lang('usr_exist_err'));
        } else {
            //Now Finally Sending Email
            EmailTemplate::sendMail('welcome_message', $udetails['userid']);
            if ($update_email_status) {
                Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['welcome_email_sent'], ['yes'], ' userid=\'' . $udetails['userid'] . '\' ');
            }
        }
    }

    /**
     * @throws Exception
     */
    function change_password($array): void
    {
        $old_pass = $array['old_pass'];
        $new_pass = $array['new_pass'];
        $c_new_pass = $array['c_new_pass'];

        $uid = $array['userid'];

        if (!$this->get_user_with_pass($uid, pass_code($old_pass, $uid))) {
            e(lang('usr_pass_err'));
        } elseif (empty($new_pass)) {
            e(lang('usr_pass_err2'));
        } elseif ($new_pass != $c_new_pass) {
            e(lang('usr_cpass_err1'));
        } else {
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['password'], [pass_code($array['new_pass'], $uid)], ' userid=\'' . $uid . '\'');
            e(lang('usr_pass_email_msg'), 'm');
        }
    }

    /**
     * Function used to add contact
     *
     * @param $uid
     * @param $fid
     *
     * @throws Exception
     */
    function add_contact($uid, $fid): void
    {
        $friend = $this->get_user_details($fid);
        $sender = $this->get_user_details($uid);

        if (!$friend) {
            e(lang('usr_exist_err'));
        } elseif ($this->is_requested_friend($uid, $fid)) {
            e(lang('you_already_sent_frend_request'));
        } elseif ($this->is_requested_friend($uid, $fid, 'in')) {
            $this->confirm_friend($fid, $uid);
            e(lang('friend_added'));
        } elseif ($uid == $fid) {
            e(lang('friend_add_himself_error'));
        } else {
            Clipbucket_db::getInstance()->insert(tbl($this->dbtbl['contacts']), ['userid', 'contact_userid', 'date_added', 'request_type'],
                [$uid, $fid, now(), 'out']);
            $insert_id = Clipbucket_db::getInstance()->insert_id();

            e(lang('friend_request_sent'), 'm');

            //Sending friendship request email
            $tpl = CBEmail::getInstance()->get_template('friend_request');

            $var = [
                '{reciever}'     => $friend['username'],
                '{sender}'       => $sender['username'],
                '{sender_link}'  => $this->profile_link($sender),
                '{request_link}' => '/manage_contacts.php?mode=request&confirm=' . $uid
            ];

            $subj = CBEmail::getInstance()->replace($tpl['email_template_subject'], $var);
            $msg = nl2br(CBEmail::getInstance()->replace($tpl['email_template'], $var));

            //Now Finally Sending Email
            #cbmail(['to'=>$friend['email'],'from'=>WEBSITE_EMAIL,'subject'=>$subj,'content'=>$msg]);
        }

    }

    /**
     * Function used to check weather users are confirmed friends or not
     *
     * @param $uid
     * @param $fid
     *
     * @return bool
     * @throws Exception
     */
    function is_confirmed_friend($uid, $fid): bool
    {
        $count = Clipbucket_db::getInstance()->count(tbl($this->dbtbl['contacts']), 'contact_id',
            " (userid='$uid' AND contact_userid='$fid') OR (userid='$fid' AND contact_userid='$uid') AND confirmed='yes'");
        if ($count[0] > 0) {
            return true;
        }
        return false;
    }

    /**
     * function used to check weather users are friends or not
     *
     * @param $uid
     * @param $fid
     *
     * @return bool
     * @throws Exception
     */
    function is_friend($uid, $fid): bool
    {
        $count = Clipbucket_db::getInstance()->count(tbl($this->dbtbl['contacts']), 'contact_id',
            " (userid='$uid' AND contact_userid='$fid') OR (userid='$fid' AND contact_userid='$uid')");
        if ($count[0] > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to check weather user has already requested friendship or not
     *
     * @param        $uid
     * @param        $fid
     * @param string $type
     * @param null $confirm
     *
     * @return bool
     * @throws Exception
     */
    function is_requested_friend($uid, $fid, $type = 'out', $confirm = null): bool
    {
        $query = '';
        if ($confirm) {
            $query = " AND confirmed='$confirm' ";
        }

        if ($type == 'out') {
            $count = Clipbucket_db::getInstance()->count(tbl($this->dbtbl['contacts']), 'contact_id', " userid='$uid' AND contact_userid='$fid' $query");
        } else {
            $count = Clipbucket_db::getInstance()->count(tbl($this->dbtbl['contacts']), 'contact_id', " userid='$fid' AND contact_userid='$uid' $query");
        }

        if ($count[0] > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to confirm friend
     *
     * @param      $sender_id
     * @param      $receiver_id
     * @param bool $msg
     *
     * @throws Exception
     */
    function confirm_friend($sender_id, $receiver_id, $msg = true): void
    {
        if (!$this->is_requested_friend($receiver_id, $sender_id, 'out', 'no')) {
            if ($msg) {
                e(lang('friend_confirm_error'));
            }
        } else {
            addFeed(['action' => 'add_friend', 'object_id' => $receiver_id, 'object' => 'friend', 'uid' => $sender_id]);
            addFeed(['action' => 'add_friend', 'object_id' => $sender_id, 'object' => 'friend', 'uid' => $receiver_id]);

            Clipbucket_db::getInstance()->insert(tbl($this->dbtbl['contacts']), ['userid', 'contact_userid', 'date_added', 'request_type', 'confirmed'],
                [$sender_id, $receiver_id, now(), 'in', 'yes']);
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['contacts']), ['confirmed'], ['yes'], ' userid=\'' . $receiver_id . '\' AND contact_userid=\'' . $sender_id . '\' ');
            if ($msg) {
                e(lang('friend_confirmed'), 'm');
            }
            //Sending friendship confirmation email

            $friend = $this->get_user_details($receiver_id);
            $sender = $this->get_user_details($sender_id);

            $var = [
                'sender_username' => $sender['username'],
                'profile_link'    => $this->profile_link($sender),
            ];

            EmailTemplate::sendMail('friend_confirmation', $receiver_id, $var);

            $log_array = [
                'success'       => 'yes',
                'action_obj_id' => $friend['userid'],
                'details'       => 'friend with ' . $friend['username']
            ];
            insert_log('add_friend', $log_array);

            $log_array = [
                'success'       => 'yes',
                'username'      => $friend['username'],
                'userid'        => $friend['userid'],
                'userlevel'     => $friend['level'],
                'useremail'     => $friend['email'],
                'action_obj_id' => user_id(),
                'details'       => 'friend with ' . user_id()
            ];
            insert_log('add_friend', $log_array);
        }
    }

    /**
     * Function used to confirm request
     *
     * @param      $rid
     * @param null $uid
     *
     * @throws Exception
     */
    function confirm_request($rid, $uid = null): void
    {
        if (!$uid) {
            $uid = user_id();
        }

        $result = Clipbucket_db::getInstance()->select(tbl($this->dbtbl['contacts']), '*', " userid='$rid' AND contact_userid='$uid' ");

        if (count($result) == 0) {
            e(lang("friend_request_not_found"));
        } elseif ($uid != $result[0]['contact_userid']) {
            e(lang("you_cant_confirm_this_request"));
        } elseif ($result[0]['confirmed'] == 'yes') {
            e(lang("friend_request_already_confirmed"));
        } else {
            $this->confirm_friend($uid, $result[0]['userid']);
        }
    }

    /**
     * Function used to get user contacts
     *
     * @param      $uid
     * @param int $group
     * @param null $confirmed
     * @param bool $count_only
     * @param null $type
     *
     * @return array|bool
     * @throws Exception
     */
    function get_contacts($uid, $group = 0, $confirmed = null, $count_only = false, $type = null)
    {
        $query = '';
        if ($confirmed) {
            $query .= ' AND ' . tbl('contacts') . ".confirmed='$confirmed' ";
        }

        if ($type) {
            $query .= ' AND ' . tbl('contacts') . ".request_type='$type' ";
        }

        if (!$count_only) {
            $result = Clipbucket_db::getInstance()->select(tbl('contacts,users'),
                tbl('contacts.contact_userid,contacts.confirmed,contacts.request_type ,users.*'),
                tbl('contacts.userid') . "='$uid' AND " . tbl('users.userid') . '=' . tbl('contacts.contact_userid') . $query . '
             AND ' . tbl('contacts') . ".contact_group_id='$group' ");

            if (count($result) > 0) {
                return $result;
            }
            return false;
        }

        return Clipbucket_db::getInstance()->count(tbl('contacts'),
            tbl('contacts.contact_userid'),
            tbl('contacts.userid') . "='$uid' 
        $query AND " . tbl('contacts') . ".contact_group_id='$group' ");
    }

    /**
     * Function used to get pending contacts
     *
     * @param      $uid
     * @param int $group
     * @param bool $count_only
     *
     * @return array|bool
     * @throws Exception
     */
    function get_pending_contacts($uid, $group = 0, $count_only = false)
    {
        if (!$count_only) {
            $result = Clipbucket_db::getInstance()->select(tbl('contacts,users'),
                tbl('contacts.userid,contacts.confirmed,contacts.request_type ,users.*'),
                tbl('contacts.contact_userid') . "='$uid' AND " . tbl('users.userid') . '=' . tbl('contacts.userid') . "
            AND " . tbl('contacts.confirmed') . "='no' AND " . tbl('contacts') . ".contact_group_id='$group' ");
            if (count($result) > 0) {
                return $result;
            }
            return false;
        }

        return Clipbucket_db::getInstance()->count(tbl('contacts'),
            tbl('contacts.contact_userid'),
            tbl('contacts.contact_userid') . "='$uid' AND " . tbl('contacts.confirmed') . "='no' AND " . tbl('contacts') . ".contact_group_id='$group' ");
    }

    /**
     * Function used to remove user from contact list
     * @param $friend_id {id of friend that user wants to remove}
     * @param $user_id {id of user who is removing other from friendlist}
     * @throws Exception
     */
    function remove_contact($friend_id, $user_id = null, $delete_request = false): void
    {
        if (!$user_id) {
            $user_id = user_id();
        }

        if (!$delete_request && !$this->is_friend($friend_id, $user_id)) {
            e(lang('user_no_in_contact_list'));
        } else {
            Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl($this->dbtbl['contacts']) . " WHERE 
                        (userid='$user_id' AND contact_userid='$friend_id') OR (userid='$friend_id' AND contact_userid='$user_id')");
            //get sub for friend
            if (!$delete_request) {
                $user_profile = $this->get_user_profile($user_id);
                if ($user_profile['allow_subscription'] == 'no') {
                    $this->unsubscrib_no_friends($user_id);
                }
                $friend_profile = $this->get_user_profile($friend_id);
                if ($friend_profile['allow_subscription'] == 'no') {
                    $this->unsubscrib_no_friends($friend_id);
                }
                e(lang('user_removed_from_contact_list'), 'm');
            } else {
                e(lang('request_has_been_canceled'), 'm');
            }

        }
    }

    /**
     * @throws Exception
     */
    function unsubscrib_no_friends($user_id)
    {

        $sql = 'select * FROM `'.tbl('subscriptions').'`
        WHERE subscribed_to = '.mysql_clean($user_id).' AND userid NOT IN (
            SELECT userid FROM cb_contacts WHERE contact_userid = '.mysql_clean($user_id).'
        );';
        $res = Clipbucket_db::getInstance()->_select($sql);
        foreach ($res as $subscription) {
            Clipbucket_db::getInstance()->delete(tbl('subscriptions'), ['subscription_id'], [$subscription['subscription_id']]);
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['subscribers'],
                [$this->get_user_subscribers($subscription['subscribed_to'], true)], " userid=".$subscription['subscribed_to']);
        }
        Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['total_subscriptions'],
            [$this->get_user_subscriptions($user_id, 'count')], " userid=".$user_id);
    }


    /**
     * Function used to increas user total_watched field
     *
     * @param $userid
     * @throws Exception
     */
    function increment_watched_videos($userid): void
    {
        Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['total_watched'], ['|f|total_watched+1'], ' userid=\'' . $userid . '\'');
    }

    /**
     * Function used to subscribe user
     *
     * @param      $to
     * @param null $user
     * @throws Exception
     */
    function subscribe_user($to, $user = null): void
    {
        if (!$user) {
            $user = user_id();
        }

        $to_user = $this->get_user_details($to);
        $p = userquery::getInstance()->get_user_profile($to_user['userid']);
        if (!$this->user_exists($to)) {
            e(lang('usr_exist_err'));
        } elseif ($to_user['userid'] == $this->get_anonymous_user() || ($p['allow_subscription'] == 'no' && !userquery::getInstance()->is_friend($to_user['userid'], User::getInstance()->getCurrentUserID()))) {
            e(lang('technical_error'));
        } elseif (!$user) {
            e(lang('please_login_subscribe', $to_user['username']));
        } elseif ($this->is_subscribed($to, $user)) {
            e(lang('usr_sub_err', '<strong>' . $to_user['username'] . '</strong>'));
        } elseif ($to_user['userid'] == $user) {
            e(lang('you_cant_sub_yourself'));
        } else {
            Clipbucket_db::getInstance()->insert(tbl($this->dbtbl['subtbl']), ['userid', 'subscribed_to', 'date_added'],
                [$user, $to, NOW()]);
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['subscribers'],
                [$this->get_user_subscribers($to, true)], " userid='$to' ");
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['total_subscriptions'],
                [$this->get_user_subscriptions($user, 'count')], " userid='$user' ");
            //Logging Comment
            $log_array = [
                'success'        => 'yes',
                'details'        => 'subsribed to ' . $to_user['username'],
                'action_obj_id'  => $to_user['userid'],
                'action_done_id' => Clipbucket_db::getInstance()->insert_id()
            ];
            insert_log('subscribe', $log_array);

            e(lang('usr_sub_msg', $to_user['username']), 'm');
        }
    }

    /**
     * Function used to check weather user is already subscribed or not
     *
     * @param      $to
     * @param null $user
     *
     * @return array|bool
     * @throws Exception
     */
    function is_subscribed($to, $user = null)
    {
        if (!$user) {
            $user = user_id();
        }

        if (!$user) {
            return false;
        }

        $result = Clipbucket_db::getInstance()->select(tbl($this->dbtbl['subtbl']), '*', " subscribed_to='$to' AND userid='$user'");
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to remove user subscription
     *
     * @param      $subid
     * @param null $uid
     *
     * @return bool
     * @throws Exception
     */
    function remove_subscription($subid, $uid = null): bool
    {
        if (!$uid) {
            $uid = user_id();
        }

        if ($subid == $this->get_anonymous_user()) {
            e(lang('technical_error'));
            return false;
        }
        if ($this->is_subscribed($subid, $uid)) {
            Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl($this->dbtbl['subtbl']) . " WHERE userid='$uid' AND subscribed_to='$subid'");
            e(lang('class_unsub_msg'), 'm');

            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['subscribers'],
                [$this->get_user_subscribers($subid, true)], " userid='$subid' ");
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['total_subscriptions'],
                [$this->get_user_subscriptions($uid, 'count')], " userid='$uid' ");
            return true;
        }

        e(lang('you_not_subscribed'));
        return false;
    }

    /**
     * @throws Exception
     */
    function unsubscribe_user($subid, $uid = null): bool
    {
        return $this->remove_subscription($subid, $uid);
    }

    /**
     * Function used to get user subscribers
     *
     * @param $id
     * @param bool $count
     *
     * @return array|bool
     * @throws Exception
     */
    function get_user_subscribers($id, $count = false)
    {
        if (!$count) {
            $result = Clipbucket_db::getInstance()->select(tbl('subscriptions'), '*',
                " subscribed_to='$id' ");
            if (count($result) > 0) {
                return $result;
            }
            return false;
        }
        return Clipbucket_db::getInstance()->count(tbl($this->dbtbl['subtbl']), 'subscription_id', " subscribed_to='$id' ");
    }

    /**
     * function used to get user subscribers with details
     *
     * @param      $id
     * @param null $limit
     *
     * @return array|bool
     * @throws Exception
     */
    function get_user_subscribers_detail($id, $limit = null)
    {
        $result = Clipbucket_db::getInstance()->select(tbl('users,' . $this->dbtbl['subtbl']), '*', ' ' . tbl('subscriptions.subscribed_to') . " = '$id' AND " . tbl('subscriptions.userid') . '=' . tbl('users.userid'), $limit);
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to get user subscriptions
     *
     * @param      $id
     * @param null $limit
     *
     * @return array|bool
     * @throws Exception
     */
    function get_user_subscriptions($id, $limit = null)
    {
        if ($limit != 'count') {
            $result = Clipbucket_db::getInstance()->select(tbl('users,' . $this->dbtbl['subtbl']), '*', ' ' . tbl('subscriptions.userid') . " = '$id' AND " . tbl('subscriptions.subscribed_to') . '=' . tbl('users.userid'), $limit);

            if (count($result) > 0) {
                return $result;
            }
            return false;
        }

        return Clipbucket_db::getInstance()->count(tbl($this->dbtbl['subtbl']), 'subscription_id', " userid = '$id'");
    }

    /**
     * Function used to reset user password
     * it has two steps
     * 1 to send confirmation
     * 2 to reset the password
     *
     * @param      $step
     * @param      $input
     * @param null $code
     *
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function reset_password($step, $input, $code = null): bool
    {
        if (User::getInstance()->isUserConnected()) {
            return false;
        }

        switch ($step) {
            case 1:
                $udetails = $this->get_user_details($input);
                if (!$udetails) {
                    e(lang('usr_exist_err'));
                } elseif (!verify_captcha()) {
                    e(lang('recap_verify_failed'));
                } else {
                    //Sending confirmation email
                    $avcode = $udetails['avcode'];
                    if (!$udetails['avcode']) {
                        $avcode = RandomString(10);
                        Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['avcode'], [$avcode], " userid='" . $udetails['userid'] . "'");
                    }

                    $var = [
                        'reset_password_link' => DirPath::getUrl('root') . 'forgot.php?mode=reset_pass&user=' . $udetails['userid'] . '&avcode=' . $avcode,
                    ];
                    //Now Finally Sending Email
                    if (EmailTemplate::sendMail('password_reset_request', $udetails['userid'], $var)) {
                        e(lang('usr_rpass_email_msg'), 'm');
                    }
                    return true;
                }
                break;

            case 2:
                $udetails = $this->get_user_details($input);
                if (!$udetails) {
                    e(lang('usr_exist_err'));
                } elseif ($udetails['avcode'] != $code) {
                    e(lang('recap_verify_failed'));
                } else {
                    $newpass = RandomString(6);
                    $pass = pass_code($newpass, $udetails['userid']);
                    $avcode = RandomString(10);
                    Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['password', 'avcode'], [$pass, $avcode], " userid='" . $udetails['userid'] . "'");
                    //Sending confirmation email
                    $var = [
                        'url'      => DirPath::getUrl('root') . 'login.php',
                        'password' => $newpass
                    ];

                    //Now Finally Sending Email
                    EmailTemplate::sendMail('password_reset_details',  $udetails['email'], $var);
                    e(lang('usr_pass_email_msg'), 'm');
                    return true;
                }
                break;
        }

        return false;
    }

    /**
     * Function used to recover username
     * @throws Exception
     */
    function recover_username($email): void
    {
        $udetails = $this->get_user_details($email);
        if (!$udetails) {
            e(lang('no_user_associated_with_email'));
        } elseif (!verify_captcha()) {
            e(lang('recap_verify_failed'));
        } else {
            //Now Finally Sending Email
            if (EmailTemplate::sendMail('forgot_username_request', $udetails['userid'], [])) {
                e(lang("usr_uname_email_msg"), 'm');
            }
        }
    }

    //FUNCTION USED TO UPDATE LAST ACTIVE FOR OF USER
    // @ Param : username
    /**
     * @throws Exception
     */
    function UpdateLastActive($username): void
    {
        $sql = 'UPDATE ' . tbl('users') . " SET last_active = '" . now() . "' WHERE username='" . $username . "' OR userid='" . $username . "' ";
        Clipbucket_db::getInstance()->execute($sql);
    }

    /**
     * FUNCTION USED TO GE USER THUMBNAIL
     *
     * @param array $udetails
     * @param string $size
     * @param null $uid
     *
     * @return string
     * @throws Exception
     */
    function getUserThumb($udetails, $size = '', $uid = null): string
    {
        if (empty($udetails['userid']) && $uid) {
            $udetails = $this->get_user_details($uid);
        }

        $avatar = $avatar_path = '';
        if (!empty($udetails['avatar'])) {
            $avatar = $udetails['avatar'];
            $avatar_path = DirPath::get('avatars') . $avatar;
        }

        if (!empty($avatar) && file_exists($avatar_path)) {
            return DirPath::getUrl('avatars') . $avatar;
        }

        if (!empty($udetails['avatar_url'])) {
            return display_clean($udetails['avatar_url']);
        }

        $thesize = AVATAR_SIZE;
        $default = $this->get_default_thumb();
        if ($size == 'small') {
            $thesize = AVATAR_SMALL_SIZE;
            $default = $this->get_default_thumb('small');
        }

        if (config('gravatars') == 'yes' && (!empty($udetails['email']) || !empty($udetails['anonym_email']))) {
            $email = $udetails['email'] ? $udetails['email'] : $udetails['anonym_email'];
            $gravatar = new Gravatar($email, $default);
            $gravatar->size = $thesize;
            $gravatar->rating = 'G';
            $gravatar->border = 'FF0000';

            return $gravatar->getSrc();
        }

        return $default;
    }

    /**
     * Function used to get default user thumb
     *
     * @param null $size
     *
     * @return string
     */
    function get_default_thumb($size = null): string
    {
        if ($size == 'small' && file_exists(TEMPLATEDIR . '/images/avatars/no_avatar-small.png')) {
            return TEMPLATEURL . '/images/avatars/no_avatar-small.png';
        }

        if (file_exists(TEMPLATEDIR . '/images/avatars/no_avatar.png') && !$size) {
            return TEMPLATEURL . '/images/avatars/no_avatar.png';
        }

        if ($size == 'small') {
            return DirPath::getUrl('images') . 'avatars/no_avatar-small.png';
        }
        return DirPath::getUrl('images') . 'avatars/no_avatar.png';
    }

    /**
     * Function used to get user Background
     *
     * @param : bg file
     * @param bool $check
     *
     * @return bool|string
     */
    function getUserBg($udetails, $check = false)
    {
        $file = $udetails['background'];
        $bgfile = DirPath::get('backgrounds') . $file;

        if (file_exists($bgfile) && $file) {
            return DirPath::getUrl('backgrounds') . $file;
        }

        if (!empty($udetails['background_url']) && config('background_url') == 'yes') {
            return $udetails['background_url'];
        }

        if (!empty($udetails['background_color']) && config('background_color') == 'yes' && $check) {
            return true;
        }

        return false;
    }

    /**
     * Function used to get user field
     * @ param INT userid
     * @ param FIELD name
     *
     * @param $uid
     * @param $field
     *
     * @return bool|array
     * @throws Exception
     */
    function get_user_field($uid, $field)
    {
        if (is_numeric($uid)) {
            $results = Clipbucket_db::getInstance()->select(tbl('users'), $field, "userid='$uid'");
        } else {
            $results = Clipbucket_db::getInstance()->select(tbl('users'), $field, "username='$uid'");
        }

        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    function get_user_fields($uid, $field)
    {
        return $this->get_user_field($uid, $field);
    }

    /**
     * This function will return
     * user field without array
     */
    function get_user_field_only($uid, $field)
    {
        $fields = $this->get_user_field($uid, $field);
        return $fields[$field];
    }


    /**
     * Function used to get all levels
     *
     * @param string $cond
     * @return array|bool
     * @throws Exception
     */
    function get_levels(string $cond = '')
    {
        if( empty($cond) ){
            $cond = ' user_level_active = \'yes\'';
        }
        $results = Clipbucket_db::getInstance()->select(tbl('user_levels'), '*', $cond, null, ' user_level_id ASC');

        if (count($results) > 0) {
            return $results;
        }
        return false;
    }

    /**
     * Function used to get level details
     *
     * @param : level_id INT
     *
     * @return bool|array
     * @throws Exception
     */
    function get_level_details($lid)
    {
        $results = Clipbucket_db::getInstance()->select(tbl('user_levels'), '*', " user_level_id='$lid' AND user_level_id NOT IN (SELECT user_level_id FROM ".tbl('user_levels')." WHERE user_level_name LIKE 'Anonymous')");
        if (count($results) > 0) {
            return $results[0];
        }

        e(lang('cant_find_level'));
        return false;
    }

    /**
     * Function used to get users of particular level
     *
     * @param : level_id
     * @param bool $count
     * @param string $fields
     *
     * @return array|int
     * @throws Exception
     */
    function get_level_users($id, $count = false, $fields = 'level')
    {
        if ($fields == 'all') {
            $fields = '*';
        }

        $results = Clipbucket_db::getInstance()->select(tbl('users'), $fields, " level='$id'");
        if (count($results) > 0) {
            if ($count) {
                return count($results);
            }
            return $results;
        }

        return 0;
    }

    /**
     * Function used to add user level
     * @throws Exception
     */
    function add_user_level($array)
    {
        if (!is_array($array)) {
            $array = $_POST;
        }
        $level_name = mysql_clean($array['level_name']);
        if (empty($level_name)) {
            e(lang('please_enter_level_name'));
        } else {
            Clipbucket_db::getInstance()->insert(tbl('user_levels'), ['user_level_name'], [$level_name]);
            $iid = Clipbucket_db::getInstance()->insert_id();

            $fields_array[] = 'user_level_id';
            $value_array[] = $iid;
            foreach ($this->get_access_type_list() as $access => $name) {
                $fields_array[] = $access;
                $value_array[] = $array[$access] ?: 'no';
            }
            if (!array_key_exists('enable_channel_page', $fields_array)) {
                $fields_array[] = 'enable_channel_page';
                $value_array[] = 'no';
            }
            Clipbucket_db::getInstance()->insert(tbl('user_levels_permissions'), $fields_array, $value_array);
            $trad_key = string_to_snake_case($array['level_name']);
            Migration::generateTranslation($trad_key, [
                 Language::getInstance()->getLang() => $array['level_name']
            ]);

            return true;
        }
    }

    /**
     * Function usewd to get level permissions
     *
     * @param $id
     *
     * @return bool|array
     * @throws Exception
     */
    function get_level_permissions($id)
    {
        $results = Clipbucket_db::getInstance()->select(tbl('user_levels_permissions'), '*', " user_level_id = '$id'");
        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to get custom permissions
     * @throws Exception
     */
    function get_access_type_list(): array
    {
        if (!$this->access_type_list) {
            $perms = $this->get_permissions();
            foreach ($perms as $perm) {
                $this->add_access_type($perm['permission_code'], $perm['permission_name']);
            }
        }
        return $this->access_type_list;
    }

    /**
     * Function used to add new custom permission
     */
    function add_access_type($access, $name)
    {
        if (!empty($access) && !empty($name)) {
            $this->access_type_list[$access] = $name;
        }
    }



    /**
     * Function used to get number of videos uploaded by user
     *
     * @param      $uid
     * @param null $cond
     * @param bool $count_only
     * @param bool $myacc
     *
     * @return array|bool|int
     * @throws Exception
     */
    function get_user_vids($uid, $cond = null, $count_only = false, $myacc = false)
    {
        if ($cond != null) {
            $cond = " AND $cond ";
        }

        $limit = '';
        $order = '';
        if ($myacc) {
            $limit = ' 0,15 ';
            $order = ' videoid DESC';
        }

        $results = Clipbucket_db::getInstance()->select(tbl('video'), '*', " userid = '$uid' $cond", "$limit", "$order");
        if (count($results) > 0) {
            if ($myacc) {
                return $results;
            }

            if ($count_only) {
                return count($results);
            }
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to get logged in username
     */
    function get_logged_username()
    {
        return $this->get_user_field_only(user_id(), 'username');
    }

    /**
     * FUnction used to get username from userid
     */
    function get_username($uid)
    {
        return $this->get_user_field_only($uid, 'username');
    }

    /**
     * Function used to create profile link
     *
     * @param $udetails
     *
     * @return string
     * @throws Exception
     */
    function profile_link($udetails): string
    {
        if (!is_array($udetails) && is_numeric($udetails)) {
            $udetails = $this->get_user_details($udetails);
        }
        if ($udetails['userid'] == $this->get_anonymous_user()) {
            return '';
        }

        $username = display_clean($udetails['user_username'] ?? $udetails['username']);
        if (config('seo') != 'yes') {
            return cblink(['name' => 'view_channel']) . '?user=' . $username;
        }

        return cblink(['name' => 'view_channel']) . $username;
    }

    /**
     * Function used to get permission types
     * @throws Exception
     */
    function get_level_types(): array
    {
        return Clipbucket_db::getInstance()->select(tbl($this->dbtbl['user_permission_type']), '*');
    }
    /**
     * Function used to get permissions
     *
     * @param null $type
     *
     * @return array|bool
     * @throws Exception
     */
    function get_permissions($type = null)
    {
        $cond = '';
        if ($type) {
            $cond = " permission_type ='$type'";
        }
        $result = Clipbucket_db::getInstance()->select(tbl($this->dbtbl['user_permissions']), '*', $cond);
        if (count($result) > 0) {
            return $result;
        }

        return false;
    }

    /**
     * Function used to get user profile details
     *
     * @param $uid
     *
     * @return bool|array
     * @throws Exception
     */
    function get_user_profile($uid)
    {
        $select = [];
        $join = '';
        $group = [];
        $user_profile_fields = ['userid','show_my_collections','featured_video', 'show_dob', 'time_zone', 'fb_url', 'twitter_url', 'insta_url', 'show_profile', 'allow_comments', 'allow_ratings', 'allow_subscription', 'content_filter', 'icon_id', 'browse_criteria', 'background', 'rating', 'voters', 'rated_by', 'show_my_videos', 'show_my_photos', 'show_my_subscriptions', 'show_my_subscribers', 'show_my_friends'];

        if( config('enable_user_firstname_lastname') == 'yes' ){
            $user_profile_fields[] = 'first_name';
            $user_profile_fields[] = 'last_name';
        }
        if( config('enable_user_relation_status') == 'yes' ){
            $user_profile_fields[] = 'relation_status';
        }
        if( config('enable_user_postcode') == 'yes' ){
            $user_profile_fields[] = 'postal_code';
        }
        if( config('enable_user_hometown') == 'yes' ){
            $user_profile_fields[] = 'hometown';
        }
        if( config('enable_user_city') == 'yes' ){
            $user_profile_fields[] = 'city';
        }
        if( config('enable_user_education') == 'yes' ){
            $user_profile_fields[] = 'education';
        }
        if( config('enable_user_schools') == 'yes' ){
            $user_profile_fields[] = 'schools';
        }
        if( config('enable_user_occupation') == 'yes' ){
            $user_profile_fields[] = 'occupation';
        }
        if( config('enable_user_compagnies') == 'yes' ){
            $user_profile_fields[] = 'companies';
        }
        if( config('enable_user_hobbies') == 'yes' ){
            $user_profile_fields[] = 'hobbies';
        }
        if( config('enable_user_favorite_movies') == 'yes' ){
            $user_profile_fields[] = 'fav_movies';
        }
        if( config('enable_user_favorite_music') == 'yes' ){
            $user_profile_fields[] = 'fav_music';
        }
        if( config('enable_user_favorite_books') == 'yes' ){
            $user_profile_fields[] = 'fav_books';
        }
        if( config('enable_user_website') == 'yes' ){
            $user_profile_fields[] = 'web_url';
        }
        if( config('enable_user_about') == 'yes' ){
            $user_profile_fields[] = 'about_me';
        }
        if( config('enable_user_status') == 'yes' ){
            $user_profile_fields[] = 'online_status';
        }
        if( config('enable_channel_description') == 'yes' ) {
            $user_profile_fields[] = 'profile_desc';
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '136')) {
            $user_profile_fields[] = 'disabled_channel';
        }
        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '37') && config('enable_channel_slogan') == 'yes' ){
            $user_profile_fields[] = 'profile_slogan';
        }

        foreach($user_profile_fields as $field){
            $select[] = 'UP.' . $field;
        }


        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '264') ){
            $group = $select;
            $select[] = 'GROUP_CONCAT( DISTINCT(T.name) SEPARATOR \',\') as profile_tags';
            $join = ' LEFT JOIN ' . tbl('user_tags') . ' UT ON UP.userid = UT.id_user
                    LEFT JOIN ' . tbl('tags') . ' T ON T.id_tag = UT.id_tag';
        }

        $query = 'SELECT ' . implode(', ', $select) . '
                    FROM ' . tbl($this->dbtbl['user_profile']) . ' UP
                   ' . $join . '
                    WHERE UP.userid = ' . mysql_clean($uid) . '
                   ' . (empty($group) ? '' : ' GROUP BY ' . implode(', ', $group));
        $result = Clipbucket_db::getInstance()->_select($query, 60);

        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    /**
     * User Profile Fields
     *
     * @param $default
     *
     * @return array
     * @throws Exception
     */
    function load_profile_fields($default): array
    {
        if (!$default) {
            $default = $_POST;
        }

        $profile_fields = $this->load_personal_details($default);
        $other_details = $this->load_location_fields($default);
        $more_details = $this->load_education_interests($default);
        $channel = $this->load_channel_settings($default);
        $privacy_field = $this->load_privacy_field($default);
        return array_merge($profile_fields, $other_details, $more_details, $channel, $privacy_field);
    }

    /**
     * Function used to update use details
     *
     * @param $array
     * @throws Exception
     */
    function update_user($array): void
    {
        if (is_null($array)) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        $userfields = $this->load_profile_fields($array);
        $custom_signup_fields = $this->load_custom_signup_fields($array);

        //Adding Custom Form Fields
        if (count($this->custom_profile_fields) > 0) {
            $userfields = array_merge($userfields, $this->custom_profile_fields);
        }

        //Adding custom fields from group
        if (count($this->custom_profile_fields_groups) > 0) {
            $custom_fields_from_group_fields = [];
            $custom_fields_from_group = $this->custom_profile_fields_groups;
            foreach ($custom_fields_from_group as $cffg) {
                $custom_fields_from_group_fields = array_merge($custom_fields_from_group_fields, $cffg['fields']);
            }

            $userfields = array_merge($userfields, $custom_fields_from_group_fields);
        }

        validate_cb_form($custom_signup_fields, $array);
        validate_cb_form($userfields, $array);

        foreach ($userfields as $field) {
            $name = formObj::rmBrackets($field['name']);
            if (!isset($array[$name])) {
                continue;
            }
            $val = $array[$name];

            if (!empty($field['db_field'])) {
                $query_field[] = $field['db_field'];
            }

            if ($field['clean_func'] && (function_exists($field['clean_func']) || is_array($field['clean_func']))) {
                $val = apply_func($field['clean_func'], $val);
            }

            if (!empty($field['db_field'])) {
                $query_val[] = $val;
            }
        }

        //updating user detail
        if (User::getInstance()->hasAdminAccess() && isset($array['admin_manager'])) {
            //Checking Username
            if (empty($array['username'])) {
                e(lang('usr_uname_err'));
            } elseif (!username_check($array['username'])) {
                e(lang('usr_uname_err3'));
            } else {
                $username = $array['username'];
            }

            //Checking Email
            if (empty($array['email'])) {
                e(lang('usr_email_err1'));
            } elseif (!is_valid_syntax('email', $array['email'])) {
                e(lang('usr_email_err2'));
            } elseif (email_exists($array['email']) && $array['email'] != $array['demail']) {
                e(lang('usr_email_err3'));
            } else {
                $email = $array['email'];
            }

            $uquery_field[] = 'username';
            $uquery_val[] = $username;

            $uquery_field[] = 'email';
            $uquery_val[] = $email;

            //Changning Password
            if (!empty($array['pass'])) {
                if ($array['pass'] != $array['cpass']) {
                    e(lang('pass_mismatched'));
                } else {
                    $pass = pass_code($array['pass'], $array['userid']);
                }
                $uquery_field[] = 'password';
                $uquery_val[] = $pass;
            }

            if (isset($array['level'])) {
                //Changing User Level
                $uquery_field[] = 'level';
                $uquery_val[] = $array['level'];
            }

            //Checking for user stats
            $uquery_field[] = 'profile_hits';
            $uquery_val[] = $array['profile_hits'];
            $uquery_field[] = 'total_watched';
            $uquery_val[] = $array['total_watched'];
            $uquery_field[] = 'total_videos';
            $uquery_val[] = $array['total_videos'];
            $uquery_field[] = 'total_comments';
            $uquery_val[] = $array['total_comments'];
            $uquery_field[] = 'subscribers';
            $uquery_val[] = $array['subscribers'];
            $uquery_field[] = 'comments_count';
            $uquery_val[] = $array['comments_count'];
            $query_field[] = 'rating';

            $rating = $array['rating'];
            if ($rating < 1 || $rating > 10) {
                $rating = 1;
            }
            $query_val[] = $rating;
            $query_field[] = 'rated_by';
            $query_val[] = $array['rated_by'];

            //Changing Joined Date
            if (isset($array['doj'])) {
                $uquery_field[] = 'doj';
                $uquery_val[] = $array['doj'];
            }
        }

        //Changing Gender
        if ($array['sex']) {
            $uquery_field[] = 'sex';
            $uquery_val[] = $array['sex'];
        }

        //Changing Country
        if ($array['country']) {
            $uquery_field[] = 'country';
            $uquery_val[] = $array['country'];
        }

        //Changing Date of birth
        if (isset($array['dob']) && $array['dob'] != '0000-00-00') {
            if (!verify_age($array['dob'])) {
                e(lang('edition_min_age_request', config('min_age_reg')));
            }
            $uquery_field[] = 'dob';

            // Converting date from custom format to MySQL
            $dob_datetime = DateTime::createFromFormat(config('date_format'), $array['dob']);
            if ($dob_datetime) {
                $uquery_val[] = $dob_datetime->format('Y-m-d');
            } else {
                $uquery_val[] = $array['dob'];
            }
        }

        if( config('enable_user_category') == 'yes' && !empty($array['category']) ){
            //Changing category
            Category::getInstance()->saveLinks('user', $array['userid'], [$array['category']]);
        }

        //Updating User Avatar
        if ($array['avatar_url']) {
            $uquery_field[] = 'avatar_url';
            $uquery_val[] = $array['avatar_url'];
        }

        if ($array['remove_avatar_url'] == 'yes') {
            $uquery_field[] = 'avatar_url';
            $uquery_val[] = '';
        }

        //Deleting User Avatar
        if ($array['delete_avatar'] == 'yes') {
            $udetails = $this->get_user_details($array['userid']);

            $file = DirPath::get('avatars') . $udetails['avatar'];
            if( file_exists($file) && empty($udetails['avatar_url']) ){
                unlink($file);
            }

            $uquery_field[] = 'avatar';
            $uquery_val[] = '';
        } else {
            if (!empty($_FILES['avatar_file']['name'])) {
                $file = Upload::getInstance()->upload_user_file('avatar', $_FILES['avatar_file'], $array['userid']);
                if ($file) {
                    $uquery_field[] = 'avatar';
                    $uquery_val[] = $file;
                }
            }
        }

        //Deleting User Bg
        if ($array['delete_bg'] == 'yes') {
            User::getInstance()->delBackground($array['userid']);
        }

        //Updating User Background
        if ($array['background_url']) {
            $uquery_field[] = 'background_url';
            $uquery_val[] = $array['background_url'];
        }

        if ($array['background_color']) {
            $uquery_field[] = 'background_color';
            $uquery_val[] = $array['background_color'];
        }

        if ($array['background_repeat']) {
            $uquery_field[] = 'background_repeat';
            $uquery_val[] = $array['background_repeat'];
        }

        if (!empty($_FILES['background_file']['name'])) {
            $file = Upload::getInstance()->upload_user_file('background', $_FILES['background_file'], $array['userid']);
            if ($file) {
                $uquery_field[] = 'background';
                $uquery_val[] = $file;
            }
        }

        //Adding Custom Field
        if (is_array($custom_signup_fields)) {
            foreach ($custom_signup_fields as $field) {
                $name = formObj::rmBrackets($field['name']);
                $val = $array[$name];

                if (!empty($field['db_field'])) {
                    $uquery_field[] = $field['db_field'];
                }

                if (is_array($val)) {
                    $new_val = '';
                    foreach ($val as $v) {
                        $new_val .= '#' . $v . '# ';
                    }
                    $val = $new_val;
                }
                if ($field['clean_func'] && (function_exists($field['clean_func']) || is_array($field['clean_func']))) {
                    $val = apply_func($field['clean_func'], $val);
                }

                if (!empty($field['db_field'])) {
                    $uquery_val[] = $val;
                }
            }
        }

        if (!error() && is_array($uquery_field)) {
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), $uquery_field, $uquery_val, " userid='" . mysql_clean($array['userid']) . "'");
            e(lang('usr_upd_succ_msg'), 'm');
        }

        //updating user profile
        if (!error() && !empty($query_field)) {
            $log_array = [
                'success' => 'yes',
                'details' => 'updated profile'
            ];
            //Login Upload
            insert_log('profile_update', $log_array);

            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['user_profile']), $query_field, $query_val, " userid='" . mysql_clean($array['userid']) . "'");

            if ($array['allow_subscription'] == 'no') {
                $this->unsubscrib_no_friends($array['userid']);
            }
            if ($array['profile_tags'] !== null) {
                Tags::saveTags($array['profile_tags'], 'profile', $array['userid']);
            }
            e(lang('usr_pof_upd_msg'), 'm');
        }
    }

    /**
     * Function used to update user avatar and background only
     *
     * @param $array
     * @throws Exception
     */
    function update_user_avatar_bg($array)
    {
        //Deleting User Avatar
        if ($array['delete_avatar'] == 'yes') {
            $udetails = $this->get_user_details(user_id());

            $file = DirPath::get('avatars') . $udetails['avatar'];
            if( file_exists($file) ){
                unlink($file);
            }

            $uquery_field[] = 'avatar';
            $uquery_val[] = '';

            $uquery_field[] = 'avatar_url';
            $uquery_val[] = '';
        } else {
            if (config('picture_url') == 'yes') {
                if( filter_var($array['avatar_url'], FILTER_VALIDATE_URL) || empty($array['avatar_url']) ){
                    //Updating User Avatar
                    $uquery_field[] = 'avatar_url';
                    $uquery_val[] = $array['avatar_url'];
                } else {
                    e(lang('incorrect_url'));
                }
            }

            if( !empty($_FILES['avatar_file']['name']) ){
                $file = Upload::getInstance()->upload_user_file('avatar', $_FILES['avatar_file'], user_id());
                if ($file) {
                    $uquery_field[] = 'avatar';
                    $uquery_val[] = $file;
                }
            }
        }


        /* TODO : Re-implement background edition interface or delete this
        //Deleting User Bg
        if ($array['delete_bg'] == 'yes') {
            User::getInstance()->delBackground($array['userid']);
        }

        if (config('background_url') == 'yes') {
            if( filter_var($array['background_url'], FILTER_VALIDATE_URL) || empty($array['background_url']) ){
                //Updating User Background
                $uquery_field[] = 'background_url';
                $uquery_val[] = $array['background_url'];
            } else {
                e(lang('incorrect_url'));
            }
        }

        $uquery_field[] = 'background_color';
        $uquery_val[] = $array['background_color'];

        if ($array['background_repeat']) {
            $uquery_field[] = 'background_repeat';
            $uquery_val[] = $array['background_repeat'];
        }
        */

        if( !empty($_FILES['background_file']['name']) ){
            $file = Upload::getInstance()->upload_user_file('background', $_FILES['background_file'], user_id());
            if ($file) {
                $uquery_field[] = 'background';
                $uquery_val[] = $file;
            }
        }

        $log_array = [
            'success' => 'yes',
            'details' => 'updated profile'
        ];

        //Login Upload
        insert_log('profile_update', $log_array);

        Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), $uquery_field, $uquery_val, ' userid=\'' . user_id() . '\'');
        e(lang('usr_avatar_bg_update'), 'm');
    }

    /**
     * @throws Exception
     */
    public function updateBackground(array $data = []): array
    {
        if (empty($data)) {
            return [
                'status' => false,
                'msg'    => 'no data was sent'
            ];
        }

        if (!file_exists($data['filepath'])) {
            return [
                'status' => false,
                'msg'    => lang('class_error_occured')
            ];
        }

        $av_details = getimagesize($data['filepath']);
        if ($av_details[0] > config('max_bg_width')) {
            unlink($data['filepath']);
            return [
                'status' => false,
                'msg'    => lang('File width exeeds') . ' ' . config('max_bg_width') . 'px'
            ];
        }

        User::getInstance()->delBackground($data['user_id']);

        $file_name = $data['user_id'] . '.' . $data['extension'];
        $file_path = DirPath::get('backgrounds') . $file_name;

        if (rename($data['filepath'], $file_path)) {
            unlink($data['filepath']);
            $imgObj = new ResizeImage();
            if (!$imgObj->ValidateImage($file_path,  $data['extension'])) {
                @unlink($file_path);
                return [
                    'status' => false,
                    'msg'    => 'Invalid file type'
                ];
            }
            Clipbucket_db::getInstance()->update(tbl('users'), ['background'], [$file_name], ' userid = ' . mysql_clean($data['user_id']));
            return [
                'status' => true,
                'msg'    => 'Succesfully Uploaded'
            ];
        }

        unlink($data['filepath']);
        return [
            'status' => false,
            'msg'    => lang('class_error_occured')
        ];
    }

    /**
     * @throws Exception
     */
    public function getBackground($userId = false)
    {
        if (!$userId) {
            $userId = user_id();
        }

        return userquery::getInstance()->getUserBg(userquery::getInstance()->get_user_details($userId));
    }

    public function getImageExt($imageName = false)
    {
        if ($imageName) {
            $nameParts = explode('.', $imageName);
            return array_pop($nameParts);
        }
    }

    /**
     * Function used to check weather username exists or not
     *
     * @param $i
     * @return bool|int
     * @throws Exception
     */
    function username_exists($i)
    {
        return Clipbucket_db::getInstance()->count(tbl($this->dbtbl['users']), 'username', " username='$i'");
    }

    /**
     * function used to check weather email exists or not
     *
     * @param $i
     *
     * @return bool
     * @throws Exception
     */
    function email_exists($i): bool
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->dbtbl['users']), 'email', " email='$i'");
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    public function check_email_domain($email): bool
    {
        $email_domain_restriction = config('email_domain_restriction');
        if ($email_domain_restriction != '') {
            $list_domains = explode(',', $email_domain_restriction);
            foreach ($list_domains as $domain) {
                if (str_contains($email, '@' . $domain)) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    /**
     * Function used to get user access log
     *
     * @param      $uid
     * @param null $limit
     *
     * @return array|bool
     * @throws Exception
     */
    function get_user_action_log($uid, $limit = null)
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->dbtbl['action_log']), '*', " action_userid='$uid'", $limit, ' date_added DESC');
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Load Custom Profile Field
     *
     * @param      $data
     * @param bool $group_based
     *
     * @return array
     */
    function load_custom_profile_fields($data, $group_based = false): array
    {
        if (!$group_based) {
            $new_array = [];
            $array = $this->custom_profile_fields;
            foreach ($array as $key => $fields) {
                if ($data[$fields['db_field']]) {
                    $value = $data[$fields['db_field']];
                } else {
                    if ($data[$fields['name']]) {
                        $value = $data[$fields['name']];
                    }
                }

                if ($fields['type'] == 'radiobutton' ||
                    $fields['type'] == 'checkbox' ||
                    $fields['type'] == 'dropdown') {
                    $fields['checked'] = $value;
                } else {
                    $fields['value'] = $value;
                }

                $new_array[$key] = $fields;
            }
            return $new_array;
        }

        $groups = $this->custom_profile_fields_groups;

        $new_grp = [];
        if ($groups) {
            foreach ($groups as $grp) {
                $fields = [];
                foreach ($grp['fields'] as $key => $fields) {
                    if ($data[$fields['db_field']]) {
                        $value = $data[$fields['db_field']];
                    } elseif ($data[$fields['name']]) {
                        $value = $data[$fields['name']];
                    }

                    if ($fields['type'] == 'radiobutton' ||
                        $fields['type'] == 'checkbox' ||
                        $fields['type'] == 'dropdown') {
                        $fields['checked'] = $value;
                    } else {
                        $fields['value'] = $value;
                    }
                }
                $grp['fields'][$key] = $fields;
                $new_grp[] = $grp;
            }
        }
        return $new_grp;
    }

    /**
     * Load Custom Signup Field
     *
     * @param      $data
     * @param bool $ck_display_admin
     * @param bool $ck_display_user
     *
     * @return array
     */
    function load_custom_signup_fields($data, $ck_display_admin = false, $ck_display_user = false): array
    {
        $array = $this->custom_signup_fields;
        $new_array = [];
        foreach ($array as $key => $fields) {
            $ok = 'yes';
            if ($ck_display_admin) {
                if ($fields['display_admin'] == 'no_display') {
                    $ok = 'no';
                }
            }

            if ($ck_display_user) {
                if ($fields['display_user'] == 'no_display') {
                    $ok = 'no';
                }
            }

            if ($ok == 'yes') {
                if (!$fields['value']) {
                    $fields['value'] = $data[$fields['db_field']];
                }
                $new_array[$key] = $fields;
            }
        }

        return $new_array;
    }

    /**
     * Get number of all unread messages of a user using his userid
     * @throws Exception
     */
    function get_unread_msgs($userid, $label = false): int
    {
        $userid = '#' . $userid . '#';
        $results = Clipbucket_db::getInstance()->select(tbl('messages'), '*', "message_to='$userid' AND message_status='unread'");
        $count = count($results);

        if ($label) {
            echo '<span class="label label-default">' . $count . '</span></h3>';
        }

        return $count;
    }

    /**
     * My Account links Edited on 12 march 2014 for user account links
     * @throws Exception
     */
    function my_account_links()
    {
        $array[lang('account')] = [
            lang('my_account')        => 'myaccount.php',
            lang('account_settings')  => 'edit_account.php?mode=account',
            lang('user_change_pass')  => 'edit_account.php?mode=change_password',
            lang('user_change_email') => 'edit_account.php?mode=change_email'
        ];

        if( (config('picture_upload') == 'yes' && User::getInstance()->hasPermission('avatar_upload')) || config('picture_url') == 'yes' || !empty(User::getInstance()->get('avatar_url')) || !empty(User::getInstance()->get('avatar'))) {
            $array[lang('account')][lang('change_avatar')] = 'edit_account.php?mode=avatar_bg';
        }

        if( config('channelsSection') == 'yes' && User::getInstance()->hasPermission('view_channel') ){
            $array[lang('account')][lang('com_manage_subs')] = 'edit_account.php?mode=subscriptions';
        }

        $check_before_551_136 = (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '136') && isSectionEnabled('channels') && User::getInstance()->hasPermission('view_channel'));
        $check_after_551_136 = (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '136') && isSectionEnabled('channels') && (User::getInstance()->hasPermission('view_channel') || (User::getInstance()->hasPermission('enable_channel_page') && User::getInstance()->get('disabled_channel') != 'yes')));
        if( $check_before_551_136 || $check_after_551_136 ){
            $counter = User::getInstance()->getNotificationContact();
            $array[lang('account')][lang('contacts_manager'). ($counter > 0 ? '&nbsp;<div class="pull-right"><i class="glyphicon glyphicon-bell"></i>('.$counter.')</div>' : '')] = 'manage_contacts.php';
        }

        if (User::getInstance()->hasPermission('private_msg_access')) {
            $counter_inbox = User::getInstance()->getNotificationInbox();
            $array[lang('messages')] = [
                lang('inbox') . ($counter_inbox > 0 ?
                    '&nbsp;<div class="pull-right"><i class="glyphicon glyphicon-bell"></i>(' . $counter_inbox . ')</div>'
                    : '')                     => 'private_message.php?mode=inbox',
                lang('notifications')     => 'private_message.php?mode=notification',
                lang('sent')              => 'private_message.php?mode=sent',
                lang('title_crt_new_msg') => cblink(['name' => 'compose_new'])
            ];
        }
        if (isSectionEnabled('channels') && User::getInstance()->hasPermission('enable_channel_page')) {
            $array[lang('user_channel_profiles')] = [
                lang('user_profile_settings') => 'edit_account.php?mode=profile',
                lang('block_users')           => 'edit_account.php?mode=block_users'
            ];
        }

        if (isSectionEnabled('videos')) {
            if (User::getInstance()->hasPermission('allow_video_upload')) {
                $array[lang('videos')][lang('manage_x', strtolower(lang('videos')))] = 'manage_videos.php?mode=uploaded';
            }
            if (User::getInstance()->hasPermission('view_video')) {
                $array[lang('videos')][lang('manage_x',strtolower(lang('user_fav_videos')))] = 'manage_videos.php?mode=favorites';
            }

        }

        if( config('videosSection') == 'yes' && config('playlistsSection') == 'yes' && User::getInstance()->hasPermission('allow_create_playlist')){
            $array[lang('playlists')][lang('manage_x', strtolower(lang('playlists')))] = 'manage_playlists.php';
        }

        if (count($this->user_account) > 0) {
            foreach ($this->user_account as $key => $acc) {
                if (array_key_exists($key, $array)) {
                    foreach ($acc as $title => $link)
                        $array[$key][$title] = $link;
                } else {
                    $array[$key] = $acc;
                }
            }
        }
        return $array;
    }


    /**
     * Function used to change email
     *
     * @param $array
     * @throws Exception
     */
    function change_email($array): void
    {
        //function used to change user email
        if (!isValidEmail($array['new_email']) || $array['new_email'] == '') {
            e(lang("usr_email_err2"));
        } elseif ($array['new_email'] != $array['cnew_email']) {
            e(lang('user_email_confirm_email_err'));
        } elseif (!$this->user_exists($array['userid'])) {
            e(lang('usr_exist_err'));
        } elseif ($this->email_exists($array['new_email'])) {
            e(lang('usr_email_err3'));
        } else {
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['email'], [$array['new_email']], " userid='" . $array['userid'] . "'");
            e(lang('email_change_msg'), 'm');
        }
    }

    /**
     * Function used to ban users
     *
     * @param      $users
     * @param null $uid
     *
     * @return void
     * @throws Exception
     */
    function block_users($users, $uid = null): void
    {
        $this->ban_users($users, $uid);
    }

    /**
     * @throws Exception
     */
    function ban_users($users, $uid = null): void
    {
        if (!$uid) {
            $uid = user_id();
        }
        $users_array = explode(',', $users);
        $new_users = [];
        foreach ($users_array as $user) {
            if ($user != user_name() && !is_numeric($user) && $this->user_exists($user)) {
                $new_users[] = $user;
            }
        }
        if (count($new_users) > 0) {
            $new_users = array_unique($new_users);
            $banned_users = implode(',', $new_users);
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['banned_users'], [$banned_users], " userid='$uid'");
            e(lang('user_ban_msg'), 'm');
        } else {
            if (!$users) {
                Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['banned_users'], [$users], " userid='$uid'");
                e(lang('no_user_ban_msg'), 'm');
            }
        }
    }

    /**
     * Function used to ban single user
     *
     * @param $user
     * @throws Exception
     */
    function ban_user($user): void
    {
        $uid = user_id();
        if (!$uid) {
            e(lang('you_not_logged_in'));
            return;
        }

        if ($user != user_name() && !is_numeric($user) && $this->user_exists($user)) {
            $banned_users = $this->udetails['banned_users'];
            if ($banned_users) {
                $banned_users .= ",$user";
            } else {
                $banned_users = "$user";
            }

            if (!$this->is_user_banned($user)) {
                Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['banned_users'], [$banned_users], " userid='$uid'");
                e(lang('user_blocked'), 'm');
            } else {
                e(lang('user_already_blocked'));
            }
        } else {
            e(lang('you_cant_del_user'));
        }
    }

    /**
     * Function used to check weather user is banned or not
     *
     * @param      $ban
     * @param null $user
     * @param null $banned_users
     *
     * @return bool
     * @throws Exception
     */
    function is_user_banned($ban, $user = null, $banned_users = null): bool
    {
        if (!$user) {
            $user = user_id();
        }

        if (!$banned_users) {
            if (is_numeric($user)) {
                $result = Clipbucket_db::getInstance()->select(tbl($this->dbtbl['users']), 'banned_users', " userid='$user' ");
            } else {
                $result = Clipbucket_db::getInstance()->select(tbl($this->dbtbl['users']), 'banned_users', " username='$user' ");
            }
            $banned_users = $result[0]['banned_users'];
        }

        $ban_user = explode(',', $banned_users);
        if (in_array($ban, $ban_user)) {
            return true;
        }
        return false;
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function load_signup_fields($input = null): array
    {
        $default = [];

        if (isset($input)) {
            $default = $input;
        }
        /**
         * this function will create initial array for user fields
         * this will tell
         * array(
         *       title [text that will represents the field]
         *       type [type of field, either radio button, textfield or text area]
         *       name [name of the fields, input NAME attribute]
         *       id [id of the fields, input ID attribute]
         *       value [value of the fields, input VALUE attribute]
         *       size
         *       class
         *       label
         *       extra_params
         *       hint_1 [hint before field]
         *       hint_2 [hint after field]
         *       anchor_before [anchor before field]
         *       anchor_after [anchor after field]
         *      )
         */

        if (empty($default)) {
            $default = $_POST;
        }

        if (empty($default)) {
            $default = $_POST;
        }

        $username = $default['username'] ?? '';
        $email = $default['email'] ?? '';
        $dob = $default['dob'] ?? '';

        if ($dob != '' && $dob != '0000-00-00') {
            $dob_datetime = DateTime::createFromFormat('Y-m-d', $dob);
            if ($dob_datetime) {
                $dob = $dob_datetime->format(config('date_format'));
            }
        }

        $user_signup_fields = [
            'username'  => [
                'title'               => lang('username'),
                'type'                => 'textfield',
                'placehoder'          => lang('username'),
                'name'                => 'username',
                'id'                  => 'username',
                'value'               => $username,
                'hint_2'              => lang('user_allowed_format'),
                'db_field'            => 'username',
                'required'            => 'yes',
                'validate_function'   => 'username_check',
                'function_error_msg'  => lang('user_contains_disallow_err'),
                'db_value_check_func' => 'user_exists',
                'db_value_exists'     => false,
                'db_value_err'        => lang('usr_uname_err2'),
                'min_length'          => config('min_username'),
                'max_length'          => config('max_username')
            ],
            'email'     => [
                'title'               => lang('email'),
                'type'                => 'textfield',
                'placehoder'          => 'Email',
                'name'                => 'email',
                'id'                  => 'email',
                'value'               => $email,
                'db_field'            => 'email',
                'required'            => 'yes',
                'db_value_check_func' => 'email_exists',
                'db_value_exists'     => false,
                'db_value_err'        => lang('usr_email_err3'),
                'validate_function'   => 'isValidEmail',
                'constraint_func'     => 'check_email_domain',
                'constraint_err'      => lang('signup_error_email_unauthorized')
            ],
            'password'  => [
                'title'         => lang('password'),
                'type'          => 'password',
                'placehoder'    => lang('password'),
                'name'          => 'password',
                'id'            => 'password',
                'required'      => 'yes',
                'invalid_err'   => lang('usr_pass_err2'),
                'relative_to'   => 'cpassword',
                'relative_type' => 'exact',
                'relative_err'  => lang('usr_pass_err3'),
            ],
            'cpassword' => [
                'title'       => lang('user_confirm_pass'),
                'type'        => 'password',
                'placehoder'  => lang('user_confirm_pass'),
                'name'        => 'cpassword',
                'id'          => 'cpassword',
                'required'    => 'no',
                'invalid_err' => lang('usr_cpass_err')
            ],
            'dob'       => [
                'title'             => lang('user_date_of_birth'),
                'type'              => 'textfield',
                'name'              => 'dob',
                'readonly'          => 'true',
                'id'                => 'dob',
                'anchor_after'      => 'date_picker',
                'value'             => $dob,
                'validate_function' => 'verify_age',
                'db_field'          => 'dob',
                'required'          => 'yes',
                'placehoder'        => lang('user_date_of_birth'),
                'invalid_err'       => ((!empty(config('min_age_reg')) && (int)config('min_age_reg') != 0) ? lang('register_min_age_request', config('min_age_reg')) : lang('dob_required'))
            ]
        ];

        if( config('enable_country') == 'yes' ){
            $countries = ClipBucket::getInstance()->get_countries();
            $selected_cont = null;
            if (config('pick_geo_country') == 'yes') {
                $user_country = Network::get_ip_infos('country');
                foreach ($countries as $code => $name) {
                    $name = strtolower($name);
                    $user_country = strtolower($user_country);
                    if ($name == $user_country) {
                        $selected_cont = $code;
                        break;
                    }
                }
            } else {
                $selected_cont = config('default_country_iso2');
            }

            if (strlen($selected_cont) != 2) {
                $selected_cont = 'FR';
            }

            $user_signup_fields['country'] = [
                'title'    => lang('country'),
                'type'     => 'dropdown',
                'value'    => $countries,
                'id'       => 'country',
                'name'     => 'country',
                'checked'  => $selected_cont,
                'db_field' => 'country',
                'required' => 'yes'
            ];
        }

        if( config('enable_gender') == 'yes' ) {
            $user_signup_fields['gender'] = [
                'title'    => lang('gender'),
                'type'     => 'radiobutton',
                'name'     => 'gender',
                'class'    => 'radio',
                'id'       => 'gender',
                'value'    => ['Male' => lang('male'), 'Female' => lang('female')],
                'sep'      => '&nbsp;',
                'checked'  => 'Male',
                'db_field' => 'sex',
                'required' => 'yes'
            ];
        }

        if( config('enable_user_category') == 'yes' ) {
            $user_signup_fields['cat'] = [
                'title'            => lang('category'),
                'type'             => 'dropdown',
                'name'             => 'category',
                'id'               => 'category',
                'value'            => ['category', ($default['category'] ?? '')],
                'checked'          => ($default['category'] ?? ''),
                'required'         => 'yes',
                'invalid_err'      => lang('select_category'),
                'display_function' => 'convert_to_categories',
                'category_type'    => 'user'
            ];
        }

        $new_array = [];
        foreach ($user_signup_fields as $id => $fields) {
            $the_array = $fields;
            if (isset($the_array['hint_1'])) {
                $the_array['hint_before'] = $the_array['hint_1'];
            }

            if (isset($the_array['hint_2'])) {
                $the_array['hint_after'] = $the_array['hint_2'];
            }

            $new_array[$id] = $the_array;
        }

        $new_array[] = $this->load_custom_profile_fields($default, false);

        return $new_array;
    }

    /**
     * Function used to validate Signup Form
     *
     * @param null $array
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function validate_form_fields($array = null): void
    {
        $fields = $this->load_signup_fields($array);

        if ($array == null) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        //Merging Array
        $signup_fields = array_merge($fields, $this->custom_signup_fields);

        validate_cb_form($signup_fields, $array);
    }

    /**
     * Function used to validate signup form
     *
     * @param null $array
     * @param bool $send_signup_email
     *
     * @return bool|mixed
     * @throws Exception
     */
    function signup_user($array = null, $send_signup_email = true)
    {
        $isSocial = false;
        if (isset($array['social_account_id'])) {
            $isSocial = true;
        }
        if ($array == null) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }
        $this->validate_form_fields($array);
        //checking terms and policy agreement
        if ($array['agree'] != 'yes' && !User::getInstance()->hasAdminAccess()) {
            e(lang('usr_ament_err'));
        }

        // first checking if captcha plugin is enabled
        // do not trust the form cb_captcha_enabled value
        if (get_captcha() && !User::getInstance()->hasAdminAccess() && !$isSocial) {
            // now checking if the user posted captcha value is not empty and cb_captcha_enabled == yes
            if (!isset($array['cb_captcha_enabled']) || $array['cb_captcha_enabled'] == 'no') {
                e(lang('recap_verify_failed'));
            }
            if (!verify_captcha()) {
                e(lang('recap_verify_failed'));
            }
        }
        if (!error()) {
            $signup_fields = $this->load_signup_fields($array);

            //Adding Custom Signup Fields
            if (count($this->custom_signup_fields) > 0) {
                $signup_fields = array_merge($signup_fields, $this->custom_signup_fields);
            }

            foreach ($signup_fields as $field) {
                $name = formObj::rmBrackets($field['name']);
                $val = $array[$name];

                if ($name == 'dob') {
                    $dob_datetime = DateTime::createFromFormat(config('date_format'), $val);
                    if ($dob_datetime) {
                        $val = $dob_datetime->format('Y-m-d');
                    } else {
                        e(lang('error_format_date'));
                        return false;
                    }
                }


                if (!empty($field['db_field'])) {
                    $query_field[] = $field['db_field'];
                }

                if (!$field['clean_func'] || (!function_exists($field['clean_func']) && !is_array($field['clean_func']))) {
                    $val = mysql_clean($val);
                } else {
                    $val = apply_func($field['clean_func'], mysql_clean('|no_mc|' . $val));
                }

                if (!empty($field['db_field'])) {
                    $query_val[] = $val;
                }
            }

            // Setting Verification type
            if (config('email_verification') == '1') {
                $usr_status = 'ToActivate';
                $welcome_email = 'no';
            } else {
                $usr_status = 'Ok';
                $welcome_email = 'yes';
            }

            if (User::getInstance()->hasAdminAccess()) {
                if ($array['active'] == 'Ok') {
                    $usr_status = 'Ok';
                    $welcome_email = 'yes';
                } else {
                    $usr_status = 'ToActivate';
                    $welcome_email = 'no';
                }

                $query_field[] = 'level';
                $query_val[] = $array['level'];
            }

            $custom_fields_array = Upload::getInstance()->load_custom_form_fields(false, false, false, true);
            foreach ($custom_fields_array as $cfield) {
                $db_field = $cfield['db_field'];
                $query_field[] = $db_field;
                $query_val[] = $array[$db_field];
            }

            $query_field[] = 'usr_status';
            $query_val[] = $usr_status;

            $query_field[] = 'welcome_email_sent';
            $query_val[] = $welcome_email;

            //Creating AV Code
            $avcode = RandomString(10);
            $query_field[] = 'avcode';
            $query_val[] = $avcode;

            //Signup IP
            $signup_ip = Network::get_remote_ip();
            $query_field[] = 'signup_ip';
            $query_val[] = $signup_ip;

            //Date Joined
            $now = NOW();
            $query_field[] = 'doj';
            $query_val[] = $now;

            // Featured video
            $query_field[] = 'featured_video';
            $query_val[] = '';

            /**
             * A VERY IMPORTANT PART OF
             * OUR SIGNUP SYSTEM IS
             * SESSION KEY AND CODE
             * WHEN A USER IS LOGGED IN
             * IT IS ONLY VALIDATED BY
             * ITS SIGNUP KEY AND CODE
             */
            $sess_key = $this->create_session_key($_COOKIE['PHPSESSID'], $array['password']);
            $sess_code = $this->create_session_code();

            $query_field[] = 'user_session_key';
            $query_val[] = $sess_key;

            $query_field[] = 'user_session_code';
            $query_val[] = $sess_code;

            $query = 'INSERT INTO ' . tbl('users') . ' (';
            $total_fields = count($query_field);

            //Adding Fields to query
            $i = 0;
            foreach ($query_field as $qfield) {
                $i++;
                $query .= $qfield;
                if ($i < $total_fields) {
                    $query .= ',';
                }
            }

            $query .= ') VALUES (';

            $i = 0;
            //Adding Fields Values to query
            foreach ($query_val as $qval) {
                $i++;
                $query .= '\'' . $qval . '\'';
                if ($i < $total_fields) {
                    $query .= ',';
                }
            }

            //Finalizing Query
            $query .= ')';
            Clipbucket_db::getInstance()->execute($query);
            $insert_id = Clipbucket_db::getInstance()->insert_id();

            if (empty($insert_id)) {
                e(lang('technical_error'));
                return false;
            }
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['users']), ['password'], [pass_code($array['password'], $insert_id)], ' userid=\'' . $insert_id . '\'');

            if (config('enable_user_category') == 'yes') {
                //Changing category
                Category::getInstance()->saveLinks('user', $insert_id, [$array['category']]);
            }

            $fields_list = [];
            $fields_data = [];

            $fields_list[] = 'userid';
            $fields_data[] = $insert_id;

            // Specify default values for user_profile fields without one
            $fields_list[] = Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '37') ? 'profile_slogan' : 'profile_title';
            $fields_data[] = '';
            $fields_list[] = 'profile_desc';
            $fields_data[] = '';
            $fields_list[] = 'featured_video';
            $fields_data[] = '';
            $fields_list[] = 'about_me';
            $fields_data[] = '';
            $fields_list[] = 'schools';
            $fields_data[] = '';
            $fields_list[] = 'occupation';
            $fields_data[] = '';
            $fields_list[] = 'companies';
            $fields_data[] = '';
            $fields_list[] = 'hobbies';
            $fields_data[] = '';
            $fields_list[] = 'fav_movies';
            $fields_data[] = '';
            $fields_list[] = 'fav_music';
            $fields_data[] = '';
            $fields_list[] = 'fav_books';
            $fields_data[] = '';
            $fields_list[] = 'background';
            $fields_data[] = '';
            $fields_list[] = 'voters';
            $fields_data[] = '';

            Clipbucket_db::getInstance()->insert(tbl(userquery::getInstance()->dbtbl['user_profile']), $fields_list, $fields_data);

            if (!User::getInstance()->hasPermission('admin_access') && config('email_verification') && $send_signup_email) {
                $var = ['avcode' => $avcode];
                EmailTemplate::sendMail('verify_account', $insert_id, $var);
            } elseif (!User::getInstance()->hasPermissionOrRedirect('admin_access', true) && $send_signup_email) {
                $this->send_welcome_email($insert_id);
            }

            $log_array = [
                'username'  => $array['username'],
                'userid'    => $insert_id,
                'userlevel' => $array['level'],
                'useremail' => $array['email'],
                'success'   => 'yes',
                'details'   => sprintf('%s signed up', $array['username'])
            ];

            //Login Signup
            insert_log('signup', $log_array);

            //Adding User has Signup Feed
            addFeed(['action' => 'signup', 'object_id' => $insert_id, 'object' => 'signup', 'uid' => $insert_id]);

            return $insert_id;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    function duplicate_email($name): bool
    {
        if (myquery::getInstance()->check_email($name)) {
            return true;
        }
        return false;
    }

    /**
     * Function used to get users
     *
     * @param null $params
     * @param bool $force_admin
     *
     * @return array|bool|int|void
     * @throws Exception
     */
    function get_users($params = null, $force_admin = false)
    {
        $limit = $params['limit'];
        $order = $params['order'];

        $cond = ' users.userid != ' . userquery::getInstance()->get_anonymous_user();
        if (!User::getInstance()->hasAdminAccess() && !$force_admin) {
             if ($cond != '') {
                    $cond .= ' AND';
                }
            $cond .= " users.usr_status='Ok' AND users.ban_status ='no' ";
        } else {
            if (!empty($params['ban'])) {
                 if ($cond != '') {
                    $cond .= ' AND';
                }
                $cond .= " users.ban_status ='" . $params['ban'] . "'";
            }

            if (!empty($params['status'])) {
                if ($cond != '') {
                    $cond .= ' AND';
                }
                $cond .= " users.usr_status='" . $params['status'] . "'";
            }
        }

        //Setting Category Condition
        if (!empty($params['category']) && !is_array($params['category'])) {
            $is_all = strtolower($params['category']);
        }

        if (isset($params['category']) && $params['category'] != '' && $is_all != lang('all')) {
            if ($cond != '') {
                $cond .= ' AND';
            }

            $cond .= ' (';

            if (!empty($params['category']) && !is_array($params['category'])) {
                $cats = explode(',', $params['category']);
            } else {
                $cats = $params['category'];
            }

            $count = 0;
            foreach ($cats as $cat_params) {
                $count++;
                if ($count > 1) {
                    $cond .= ' OR ';
                }
                $cond .= " users.category LIKE '%$cat_params%' ";
            }

            $cond .= ')';
        }

        //date span
        if (!empty($params['date_span'])) {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= ' ' . Search::date_margin('users.doj', $params['date_span']);
        }

        //FEATURED
        if (!empty($params['featured'])) {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= " users.featured = '" . $params['featured'] . "' ";
        }

        if (!empty($params['search_username'])) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= " users.username LIKE '%" . $params['search_username'] . "%'";
        }

        //Username
        if (isset($params['username']) && $params['username'] != '') {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= " users.username = '" . $params['username'] . "' ";
        }

        //Email
        if (isset($params['email']) && $params['email'] != '') {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= " users.email = '" . $params['email'] . "' ";
        }

        //Exclude Users
        if (!empty($params['exclude'])) {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= " users.userid <> '" . $params['exclude'] . "' ";
        }

        //Getting specific User
        if (isset($params['userid']) && $params['userid'] != '') {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= " users.userid = '" . $params['userid'] . "' ";
        }

        //Sex
        if (!empty($params['gender'])) {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= " users.sex = '" . $params['gender'] . "' ";
        }

        //Level
        if (isset($params['level']) && $params['level'] != '') {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= " users.level = '" . $params['level'] . "' ";
        }

        if (!empty($params['cond'])) {
            if ($cond != '') {
                $cond .= ' AND';
            }
            $cond .= ' ' . $params['cond'] . ' ';
        }

        if (empty($params['count_only'])) {
            $fields = [
                'users'   => get_user_fields(),
                'profile' => ['rating', 'rated_by', 'voters']
            ];

            if( config('enable_user_firstname_lastname') == 'yes' ){
                $fields['profile'][] = 'first_name';
                $fields['profile'][] = 'last_name';
            }
            if( config('enable_user_city') == 'yes' ){
                $fields['profile'][] = 'city';
            }
            if( config('enable_user_hometown') == 'yes' ){
                $fields['profile'][] = 'hometown';
            }
            if( config('enable_channel_description') == 'yes' ){
                $fields['profile'][] = 'profile_desc';
            }
            if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '37') && config('enable_channel_slogan') == 'yes' ){
                $fields['profile'][] = 'profile_slogan';
            }

            $fields['users'][] = 'last_active';
            $fields['users'][] = 'total_collections';
            $query = ' SELECT ' . table_fields($fields) . ' FROM ' . cb_sql_table('users');
            $query .= ' LEFT JOIN ' . cb_sql_table('user_profile', 'profile') . ' ON users.userid = profile.userid ';

            if ($cond) {
                $query .= ' WHERE  ' . $cond;
            }

            if ($order) {
                $query .= ' ORDER BY ' . $order;
            }

            if ($limit) {
                $query .= ' LIMIT ' . $limit;
            }

            $result = select($query);
        } else {
            $result = Clipbucket_db::getInstance()->count(tbl('users') . ' AS users ', 'userid', $cond);
        }

        if (isset($params['assign']) && $params['assign'] != '') {
            assign($params['assign'], $result);
        } else {
            return $result ?? false;
        }
    }

    /**
     * Function used to perform several actions with a video
     * @throws Exception
     */
    function action($case, $uid)
    {
        $udetails = $this->get_user_details(user_id());
        $logged_user_level = $udetails['level'];
        if ($logged_user_level > 1) {
            $data = $this->get_user_details($uid);
            if ($data['level'] == 1) {
                e('You do not have sufficient permissions to edit an Admininstrator');
                return false;
            }
        }

        if (!$this->user_exists($uid)) {
            return false;
        }
        //Lets just check weathter user exists or not
        $tbl = tbl($this->dbtbl['users']);
        switch ($case) {
            //Activating a user
            case 'activate':
            case 'av':
            case 'a':
                $avcode = RandomString(10);
                Clipbucket_db::getInstance()->update($tbl, ['usr_status', 'avcode'], ['Ok', $avcode], " userid='$uid' ");
                e(lang('usr_ac_msg'), 'm');
                break;

            //Deactivating a user
            case 'deactivate':
            case 'dav':
            case 'd':
                $avcode = RandomString(10);
                Clipbucket_db::getInstance()->update($tbl, ['usr_status', 'avcode'], ['ToActivate', $avcode], " userid='$uid' ");
                e(lang('usr_dac_msg'), 'm');
                break;

            //Featuring user
            case 'feature':
            case 'featured':
            case 'f':
                Clipbucket_db::getInstance()->update($tbl, ['featured', 'featured_date'], ['yes', now()], " userid='$uid' ");
                e(lang('user_has_been_set_as_featured'), 'm');
                break;

            //Unfeatured user
            case 'unfeature':
            case 'unfeatured':
            case 'uf':
                Clipbucket_db::getInstance()->update($tbl, ['featured'], ['no'], " userid='$uid' ");
                e(lang('user_has_been_removed_from_featured_users'), 'm');
                break;

            //Ban User
            case 'ban':
            case 'banned':
                Clipbucket_db::getInstance()->update($tbl, ['ban_status'], ['yes'], " userid='$uid' ");
                e(lang('usr_uban_msg'), 'm');
                break;

            //Ban User
            case 'unban':
            case 'unbanned':
                Clipbucket_db::getInstance()->update($tbl, ['ban_status'], ['no'], " userid='$uid' ");
                e(lang('usr_uuban_msg'), 'm');
                break;
        }
    }

    /**
     * Function used to get number of users online
     *
     * @return array
     * @throws Exception
     */
    function get_online_users(): array
    {
        return Clipbucket_db::getInstance()->select(tbl('sessions') . ' LEFT JOIN (' . tbl('users') . ') ON 
         (' . tbl('sessions.session_user=') . tbl('users') . '.userid)',
            tbl('sessions.*,users.username,users.userid,users.email')
            , ' TIMESTAMPDIFF(MINUTE,' . tbl('sessions.last_active') . ",'" . now() . "')  < 10 ", false, ' TIMESTAMPDIFF(MINUTE,' . tbl('sessions.last_active') . ',\'' . now() . '\')');
    }

    /**
     * Function will let admin to login as user
     *
     * @param      $id
     *
     * @return bool
     * @throws Exception
     */
    function login_as_user($id): bool
    {
        $udetails = $this->get_user_details($id);
        if ($udetails) {
            if (!$this->user_exists($udetails['username'])) {
                $msg[] = e(lang('user_doesnt_exist'));
            } elseif (strtolower($udetails['usr_status']) != 'ok') {
                $msg[] = e(lang('user_inactive_msg'), 'e', false);
            } elseif ($udetails['ban_status'] == 'yes') {
                $msg[] = e(lang('usr_ban_err'));
            } else {
                return $this->init_session($udetails);
            }

            //Error Logging
            if (!empty($msg)) {
                //Logging Action
                $log_array['success'] = 'no';
                $log_array['details'] = $msg[0]['val'];
                insert_log('Login as', $log_array);
            }
        }

        e(lang('usr_exist_err'));
        return false;
    }

    /**
     * Function used to get anonymous user
     * @throws Exception
     */
    function get_anonymous_user()
    {
        /*Added to resolve bug 222*/
        $result = Clipbucket_db::getInstance()->select(tbl('users'), 'userid', " username='anonymous' AND email='anonymous@website'", '1');
        if (isset($result[0]['userid'])) {
            return $result[0]['userid'];
        }

        execute_sql_file(\DirPath::get('cb_install') . 'sql' .DIRECTORY_SEPARATOR . 'add_anonymous_user.sql');

        $result = Clipbucket_db::getInstance()->select(tbl('users'), 'userid', " username='anonymous' AND email='anonymous@website'", '1');
        return $result[0]['userid'];
    }

    /**
     * Function used to delete user videos
     *
     * @param $uid
     * @throws Exception
     */
    function delete_user_vids($uid): void
    {
        $vids = get_videos(['user' => $uid]);
        if (is_array($vids)) {
            foreach ($vids as $vid) {
                CBvideo::getInstance()->delete_video($vid['videoid']);
            }
        }
        errorhandler::getInstance()->flush_msg();
        e(lang('user_vids_hv_deleted'), 'm');
    }

    /**
     * Function used to remove user contacts
     *
     * @param $uid
     * @throws Exception
     */
    function remove_contacts($uid): void
    {
        $contacts = $this->get_contacts($uid);
        if (is_array($contacts)) {
            foreach ($contacts as $contact) {
                $this->remove_contact($contact['userid'], $contact['contact_userid']);
            }
        }
        errorhandler::getInstance()->flush_msg();
        e(lang('user_contacts_hv_removed'), 'm');
    }

    /**
     * Function used to remove user private messages
     *
     * @param        $uid
     * @param string $box
     * @throws Exception
     */
    function remove_user_pms($uid, $box = 'both'): void
    {
        global $cbpm;

        if ($box == 'inbox' || $box == 'both') {
            $inboxs = $cbpm->get_user_inbox_messages($uid);
            if (is_array($inboxs)) {
                foreach ($inboxs as $inbox) {
                    $cbpm->delete_msg($inbox['message_id'], $uid);
                }
            }
            errorhandler::getInstance()->flush_msg();
            e(lang('all_user_inbox_deleted'), 'm');
        }

        if ($box == 'sent' || $box == 'both') {
            $outs = $cbpm->get_user_outbox_messages($uid);
            if (is_array($outs)) {
                foreach ($outs as $out) {
                    $cbpm->delete_msg($out['message_id'], $uid,  'out');
                }
            }
            e(lang('all_user_sent_messages_deleted'), 'm');
        }
        //UPDATE
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('messages') . '
                SET message_to = REPLACE(message_to, \'#'.mysql_clean($uid).'#\', \'#'.mysql_clean(userquery::getInstance()->get_anonymous_user()).'#\')
                WHERE message_to LIKE \'%#'.mysql_clean($uid).'#%\'');
    }

    /**
     * FUnction loading personal details
     *
     * @param $default
     *
     * @return array
     * @throws Exception
     */
    function load_personal_details($default): array
    {
        if (!$default) {
            $default = $_POST;
        }

        $return = [
            'show_dob'     => [
                'title'       => lang('show_dob'),
                'type'        => 'radiobutton',
                'name'        => 'show_dob',
                'id'          => 'show_dob',
                'value'       => ['yes' => lang('yes'), 'no'  => lang('no')],
                'checked'     => $default['show_dob'],
                'db_field'    => 'show_dob',
                'syntax_type' => 'name',
                'auto_view'   => 'no',
                'sep'         => '&nbsp;',
                'disabled'    => (strtolower($default['disabled_channel']) == 'yes')
            ],
            'profile_tags' => [
                'title'             => lang('profile_tags'),
                'type'              => 'hidden',
                'name'              => 'profile_tags',
                'id'                => 'profile_tags',
                'value'             => genTags($default['profile_tags']),
                'required'          => 'no',
                'validate_function' => 'genTags',
                'auto_view'         => 'yes',
                'disabled'          => (strtolower($default['disabled_channel']) == 'yes')
            ]
        ];

        if( config('enable_user_firstname_lastname') == 'yes' ){
            $return['first_name'] = [
                'title'       => lang('user_fname'),
                'type'        => 'textfield',
                'name'        => 'first_name',
                'id'          => 'first_name',
                'value'       => $default['first_name'],
                'db_field'    => 'first_name',
                'required'    => 'no',
                'syntax_type' => 'name',
                'auto_view'   => 'yes'
            ];

            $return['last_name'] = [
                'title'       => lang('user_lname'),
                'type'        => 'textfield',
                'name'        => 'last_name',
                'id'          => 'last_name',
                'value'       => $default['last_name'],
                'db_field'    => 'last_name',
                'syntax_type' => 'name',
                'required'    => 'no',
                'auto_view'   => 'yes'
            ];
        }

        if( config('enable_user_relation_status') == 'yes' ){
            $return['relation_status'] = [
                'title'     => lang('user_relat_status'),
                'type'      => 'dropdown',
                'name'      => 'relation_status',
                'id'        => 'last_name',
                'value'     => [
                    lang('usr_arr_no_ans'),
                    lang('usr_arr_single'),
                    lang('usr_arr_married'),
                    lang('usr_arr_comitted'),
                    lang('usr_arr_open_relate')
                ],
                'checked'   => $default['relation_status'],
                'db_field'  => 'relation_status',
                'auto_view' => 'yes'
            ];
        }

        if( config('enable_user_website') == 'yes' ){
            $return['web_url'] = [
                'title'            => lang('website'),
                'type'             => 'textfield',
                'name'             => 'web_url',
                'id'               => 'web_url',
                'value'            => $default['web_url'],
                'db_field'         => 'web_url',
                'auto_view'        => 'yes',
                'display_function' => 'outgoing_link'
            ];
        }

        if( config('enable_user_about') == 'yes' ){
            $return['about_me'] = [
                'title'      => lang('user_about_me'),
                'type'       => 'textarea',
                'name'       => 'about_me',
                'id'         => 'about_me',
                'value'      => $default['about_me'],
                'db_field'   => 'about_me',
                'auto_view'  => 'no'
            ];
        }

        return $return;
    }

    /**
     * function used to load location fields
     *
     * @param $default
     *
     * @return array
     * @throws Exception
     */
    function load_location_fields($default): array
    {
        if (!$default) {
            $default = $_POST;
        }

        $return = [];

        if( config('enable_user_postcode') == 'yes' ){
            $return['postal_code'] = [
                'title'     => lang('postal_code'),
                'type'      => 'textfield',
                'name'      => 'postal_code',
                'id'        => 'postal_code',
                'value'     => $default['postal_code'],
                'db_field'  => 'postal_code',
                'auto_view' => 'yes'
            ];
        }

        if( config('enable_user_hometown') == 'yes' ){
            $return['hometown'] = [
                'title'     => lang('hometown'),
                'type'      => 'textfield',
                'name'      => 'hometown',
                'id'        => 'hometown',
                'value'     => $default['hometown'],
                'db_field'  => 'hometown',
                'auto_view' => 'yes'
            ];
        }

        if( config('enable_user_city') == 'yes' ){
            $return['city'] = [
                'title'     => lang('city'),
                'type'      => 'textfield',
                'name'      => 'city',
                'id'        => 'city',
                'value'     => $default['city'],
                'db_field'  => 'city',
                'auto_view' => 'yes'
            ];
        }

        return $return;
    }

    /**
     * Function used to load experice fields
     *
     * @param $default
     *
     * @return array
     * @throws Exception
     */
    function load_education_interests($default): array
    {
        if (!$default) {
            $default = $_POST;
        }

        $return = [];

        if( config('enable_user_education') == 'yes' ){
            $return['education'] = [
                'title'     => lang('education'),
                'type'      => 'dropdown',
                'name'      => 'education',
                'id'        => 'education',
                'value'     => [
                    lang('usr_arr_no_ans'),
                    lang('usr_arr_elementary'),
                    lang('usr_arr_hi_school'),
                    lang('usr_arr_some_colg'),
                    lang('usr_arr_assoc_deg'),
                    lang('usr_arr_bach_deg'),
                    lang('usr_arr_mast_deg'),
                    lang('usr_arr_phd'),
                    lang('usr_arr_post_doc')
                ],
                'checked'   => $default['education'],
                'db_field'  => 'education',
                'auto_view' => 'yes'
            ];
        }

        if( config('enable_user_schools') == 'yes' ){
            $return['schools'] = [
                'title'      => lang('schools'),
                'type'       => 'textarea',
                'name'       => 'schools',
                'id'         => 'schools',
                'value'      => $default['schools'],
                'db_field'   => 'schools',
                'auto_view'  => 'yes'
            ];
        }

        if( config('enable_user_occupation') == 'yes' ){
            $return['occupation'] = [
                'title'      => lang('occupation'),
                'type'       => 'textarea',
                'name'       => 'occupation',
                'id'         => 'occupation',
                'value'      => $default['occupation'],
                'db_field'   => 'occupation',
                'auto_view'  => 'yes'
            ];
        }

        if( config('enable_user_compagnies') == 'yes' ){
            $return['companies'] = [
                'title'      => lang('companies'),
                'type'       => 'textarea',
                'name'       => 'companies',
                'id'         => 'companies',
                'value'      => $default['companies'],
                'db_field'   => 'companies',
                'auto_view'  => 'yes'
            ];
        }

        if( config('enable_user_hobbies') == 'yes' ){
            $return['hobbies'] = [
                'title'      => lang('hobbies'),
                'type'       => 'textarea',
                'name'       => 'hobbies',
                'id'         => 'hobbies',
                'value'      => $default['hobbies'],
                'db_field'   => 'hobbies',
                'auto_view'  => 'yes'
            ];
        }

        if( config('enable_user_favorite_movies') == 'yes' ){
            $return['fav_movies'] = [
                'title'      => lang('user_fav_movs_shows'),
                'type'       => 'textarea',
                'name'       => 'fav_movies',
                'id'         => 'fav_movies',
                'value'      => $default['fav_movies'],
                'db_field'   => 'fav_movies',
                'auto_view'  => 'yes'
            ];
        }

        if( config('enable_user_favorite_music') == 'yes' ){
            $return['fav_music'] = [
                'title'      => lang('user_fav_music'),
                'type'       => 'textarea',
                'name'       => 'fav_music',
                'id'         => 'fav_music',
                'value'      => $default['fav_music'],
                'db_field'   => 'fav_music',
                'auto_view'  => 'yes'
            ];
        }

        if( config('enable_user_favorite_books') == 'yes' ){
            $return['fav_books'] = [
                'title'      => lang('user_fav_books'),
                'type'       => 'textarea',
                'name'       => 'fav_books',
                'id'         => 'fav_books',
                'value'      => $default['fav_books'],
                'db_field'   => 'fav_books',
                'auto_view'  => 'yes'
            ];
        }

        return $return;
    }


    /**
     * Function used to load privacy fields
     *
     * @param $default
     *
     * @return array
     * @throws Exception
     */
    function load_privacy_field($default): array
    {
        if (!$default) {
            $default = $_POST;
        }

        $return = [];

        $return['show_profile'] = [
            'title'    => lang('show_profile'),
            'type'     => 'dropdown',
            'name'     => 'show_profile',
            'id'       => 'show_profile',
            'value'    => [
                'all'     => lang('all'),
                'members' => lang('members'),
                'friends' => lang('friends')
            ],
            'checked'  => $default['show_profile'],
            'db_field' => 'show_profile',
            'sep'      => '&nbsp;',
            'disabled' => (strtolower($default['disabled_channel']) == 'yes')
        ];

        if (config('enable_comments_channel') == 'yes') {
            $return['allow_comments'] = [
                'title'    => lang('vdo_allow_comm'),
                'type'     => 'radiobutton',
                'name'     => 'allow_comments',
                'id'       => 'allow_comments',
                'value'    => [
                    'yes' => lang('yes'),
                    'no'  => lang('no')
                ],
                'checked'  => strtolower($default['allow_comments']),
                'db_field' => 'allow_comments',
                'sep'      => '&nbsp;',
                'disabled' => (strtolower($default['disabled_channel']) == 'yes')
            ];
        }

        $return['allow_ratings'] = [
            'title'    => lang('allow_ratings'),
            'type'     => 'radiobutton',
            'name'     => 'allow_ratings',
            'id'       => 'allow_ratings',
            'value'    => [
                'yes' => lang('yes'),
                'no'  => lang('no')
            ],
            'checked'  => strtolower($default['allow_ratings']),
            'db_field' => 'allow_ratings',
            'sep'      => '&nbsp;',
            'disabled' => (strtolower($default['disabled_channel']) == 'yes')
        ];

        $return['allow_subscription'] = [
            'title'    => lang('allow_subscription'),
            'type'     => 'radiobutton',
            'name'     => 'allow_subscription',
            'id'       => 'allow_subscription',
            'hint_1'   => lang('allow_subscription_hint'),
            'value'    => [
                'yes' => lang('yes'),
                'no'  => lang('no')
            ],
            'checked'  => strtolower($default['allow_subscription']),
            'db_field' => 'allow_subscription',
            'sep'      => '&nbsp;',
            'disabled' => (strtolower($default['disabled_channel']) == 'yes')
        ];

        if (config('enable_user_status') == 'yes') {
            $return['online_status'] = [
                'title'    => lang('online_status'),
                'type'     => 'dropdown',
                'name'     => 'privacy',
                'id'       => 'privacy',
                'value'    => [
                    'online'  => lang('online'),
                    'offline' => lang('offline'),
                    'custom'  => lang('custom')
                ],
                'checked'  => $default['online_status'],
                'db_field' => 'online_status'
            ];
        }

        return $return;
    }

    /**
     * load_channel_settings
     *
     * @param $default array values for channel settings
     * @return array of channel info fields
     * @throws Exception
     */
    function load_channel_settings($default): array
    {
        if (!$default) {
            $default = $_POST;
        }

        $return = [];

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '136')) {
            $return['disable_channel'] = [
                'title'    => lang('disable_channel'),
                'type'     => 'radiobutton',
                'name'     => 'disabled_channel',
                'id'       => 'disabled_channel',
                'value'    => [
                    'yes' => lang('yes'),
                    'no'  => lang('no')
                ],
                'checked'  => strtolower($default['disabled_channel']),
                'db_field' => 'disabled_channel',
                'sep'      => '&nbsp;'
            ];
        }

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '37') && config('enable_channel_slogan') == 'yes' ) {
            $return['profile_slogan'] = [
                'title'     => lang('channel_slogan'),
                'type'      => 'textfield',
                'name'      => 'profile_slogan',
                'id'        => 'profile_slogan',
                'value'     => $default['profile_slogan'],
                'db_field'  => 'profile_slogan',
                'auto_view' => 'no',
                'disabled'  => (strtolower($default['disabled_channel']) == 'yes')
            ];
        }

        $return['profile_desc'] = [
            'title'     => lang('channel_desc'),
            'type'      => 'textarea',
            'name'      => 'profile_desc',
            'id'        => 'profile_desc',
            'value'     => $default['profile_desc'],
            'db_field'  => 'profile_desc',
            'auto_view' => 'yes',
            'disabled'  => (strtolower($default['disabled_channel']) == 'yes')
        ];

        $return['show_my_friends'] = [
            'title'    => lang('show_my_friends'),
            'type'     => 'radiobutton',
            'name'     => 'show_my_friends',
            'id'       => 'show_my_friends',
            'value'    => [
                'yes' => lang('yes'),
                'no'  => lang('no')
            ],
            'checked'  => strtolower($default['show_my_friends']),
            'db_field' => 'show_my_friends',
            'sep'      => '&nbsp;',
            'disabled' => (strtolower($default['disabled_channel']) == 'yes')
        ];

        if (isSectionEnabled('videos')) {
            $return['show_my_videos'] = [
                'title'    => lang('show_my_videos'),
                'type'     => 'radiobutton',
                'name'     => 'show_my_videos',
                'id'       => 'show_my_videos',
                'value'    => [
                    'yes' => lang('yes'),
                    'no'  => lang('no')
                ],
                'checked'  => strtolower($default['show_my_videos']),
                'db_field' => 'show_my_videos',
                'sep'      => '&nbsp;',
                'disabled' => (strtolower($default['disabled_channel']) == 'yes')
            ];
        }

        if (isSectionEnabled('photos')) {
            $return['show_my_photos'] = [
                'title'    => lang('show_my_photos'),
                'type'     => 'radiobutton',
                'name'     => 'show_my_photos',
                'id'       => 'show_my_photos',
                'value'    => [
                    'yes' => lang('yes'),
                    'no'  => lang('no')
                ],
                'checked'  => strtolower($default['show_my_photos']),
                'db_field' => 'show_my_photos',
                'sep'      => '&nbsp;',
                'disabled' => (strtolower($default['disabled_channel']) == 'yes')
            ];
        }

        $return['show_my_subscriptions'] = [
            'title'    => lang('show_my_subscriptions'),
            'type'     => 'radiobutton',
            'name'     => 'show_my_subscriptions',
            'id'       => 'show_my_subscriptions',
            'value'    => [
                'yes' => lang('yes'),
                'no'  => lang('no')
            ],
            'checked'  => strtolower($default['show_my_subscriptions']),
            'db_field' => 'show_my_subscriptions',
            'sep'      => '&nbsp;',
            'disabled' => (strtolower($default['disabled_channel']) == 'yes')
        ];

        $return['show_my_subscribers'] = [
            'title'    => lang('show_my_subscribers'),
            'type'     => 'radiobutton',
            'name'     => 'show_my_subscribers',
            'id'       => 'show_my_subscribers',
            'value'    => [
                'yes' => lang('yes'),
                'no'  => lang('no')
            ],
            'checked'  => strtolower($default['show_my_subscribers']),
            'db_field' => 'show_my_subscribers',
            'sep'      => '&nbsp;',
            'disabled' => (strtolower($default['disabled_channel']) == 'yes')
        ];

        if (config('collectionsSection') == 'yes' && (config('videosSection') == 'yes' || config('photosSection') == 'yes')) {
            $return['show_my_collections'] = [
                'title'    => lang('show_my_collections'),
                'type'     => 'radiobutton',
                'name'     => 'show_my_collections',
                'id'       => 'show_my_collections',
                'value'    => [
                    'yes' => lang('yes'),
                    'no'  => lang('no')
                ],
                'checked'  => strtolower($default['show_my_collections']),
                'db_field' => 'show_my_collections',
                'sep'      => '&nbsp;',
                'disabled' => (strtolower($default['disabled_channel']) == 'yes')
            ];
        }

        return $return;
    }

    /**
     * load_user_fields
     *
     * @param        $default array values for user profile fields
     * @param string $type
     *
     * @return array of user fields
     *
     * Function used to load Video fields
     * in Clipbucket v2.1 , video fields are loaded in form of groups arrays
     * each group has it name and fields wrapped in array
     * and that array will be part of video fields
     * @throws Exception
     */
    function load_user_fields($default, $type = 'all'): array
    {
        $getChannelSettings = false;
        $getProfileSettings = false;
        $fields = [];

        switch ($type) {
            case 'all':
                $getChannelSettings = true;
                $getProfileSettings = true;
                break;

            case 'channel':
            case 'channels':
                $getChannelSettings = true;
                break;

            case 'profile':
            case 'profile_settings':
                $getProfileSettings = true;
                break;
        }

        if ($getChannelSettings) {
            $channel_settings = [[
                'group_name' => lang('channel_settings'),
                'group_id'   => 'channel_settings',
                'fields'     => array_merge(
                    $this->load_channel_settings($default)
                    ,$this->load_privacy_field($default)
                )
            ]];
        }

        if ($getProfileSettings) {
            $profile_settings = [
                [
                    'group_name' => lang('profile_basic_info'),
                    'group_id'   => 'profile_basic_info',
                    'fields'     => $this->load_personal_details($default),
                ],[
                    'group_name' => lang('profile_education_interests'),
                    'group_id'   => 'profile_education_interests',
                    'fields'     => $this->load_education_interests($default)
                ],[
                    'group_name' => lang('location'),
                    'group_id'   => 'profile_location',
                    'fields'     => $this->load_location_fields($default)
                ]
            ];

            //Adding Custom Fields
            $custom_fields = $this->load_custom_profile_fields($default, false);
            if ($custom_fields) {
                $more_fields_group = [
                    'group_name' => lang('more_fields'),
                    'group_id'   => 'custom_fields',
                    'fields'     => $custom_fields
                ];
            }

            //Loading Custom Profile Forms
            $custom_fields_with_group = $this->load_custom_profile_fields($default, true);

            //Finally putting them together in their main array called $fields
            if ($custom_fields_with_group) {
                $custFieldGroups = $custom_fields_with_group;

                foreach ($custFieldGroups as $gKey => $fieldGroup) {
                    $group_id = $fieldGroup['group_id'];

                    foreach ($profile_settings as $key => $field) {
                        if ($field['group_id'] == $group_id) {
                            $inputFields = $field['fields'];
                            //Setting field values
                            $newFields = $fieldGroup['fields'];
                            $mergeField = array_merge($inputFields, $newFields);

                            //Finally Updating array
                            $newGroupArray = [
                                'group_name' => $field['group_name'],
                                'group_id'   => $field['group_id'],
                                'fields'     => $mergeField
                            ];

                            $fields[$key] = $newGroupArray;
                            $matched = true;
                            break;
                        } else {
                            $matched = false;
                        }
                    }
                    if (!$matched) {
                        $profile_settings[] = $fieldGroup;
                    }
                }
            }

        }

        if ($channel_settings) {
            $fields = array_merge($fields, $channel_settings);
        }
        if ($profile_settings) {
            $fields = array_merge($fields, $profile_settings);
        }
        if ($more_fields_group) {
            $fields[] = $more_fields_group;
        }
        return $fields;
    }

    /**
     * Used to rate photo
     *
     * @param $id
     * @param $rating
     *
     * @return array
     * @throws Exception
     */
    function rate_user($id, $rating): array
    {
        if (!is_numeric($rating) || $rating <= 9) {
            $rating = 0;
        }
        if ($rating >= 10) {
            $rating = 10;
        }

        $c_rating = $this->current_rating($id);
        $voters = $c_rating['voters'];
        $new_rate = $c_rating['rating'];
        $rated_by = $c_rating['rated_by'];

        $voters = json_decode($voters, true);

        if (!empty($voters)) {
            $already_voted = array_key_exists(user_id(), $voters);
        }

        if (!user_id()) {
            e(lang('please_login_to_rate'));
        } elseif (user_id() == $c_rating['userid'] && !config('own_channel_rating')) {
            e(lang('you_cant_rate_own_channel'));
        } elseif (!empty($already_voted)) {
            e(lang('you_have_already_voted_channel'));
        } elseif ($c_rating['allow_ratings'] == 'no' || !config('channel_rating')) {
            e(lang('channel_rating_disabled'));
        } else {
            $voters[user_id()] = [
                'userid'   => user_id(),
                'username' => user_name(),
                'time'     => now(),
                'rating'   => $rating
            ];
            $voters = json_encode($voters);

            $t = $c_rating['rated_by'] * $c_rating['rating'];
            $rated_by = $c_rating['rated_by'] + 1;
            $new_rate = ($t + $rating) / $rated_by;
            Clipbucket_db::getInstance()->update(tbl('user_profile'), ['rating', 'rated_by', 'voters'], ["$new_rate", "$rated_by", "|no_mc|$voters"], ' userid = ' . $id . '');
            $userDetails = [
                'object_id' => $id,
                'type'      => 'user',
                'time'      => now(),
                'rating'    => $rating,
                'userid'    => user_id(),
                'username'  => user_name()
            ];
            /* Updating user details */
            update_user_voted($userDetails);
            e(lang('thnx_for_voting'), 'm');
        }

        return ['rating' => $new_rate, 'rated_by' => $rated_by, 'total' => 10, 'id' => $id, 'type' => 'user', 'disable' => 'disabled'];
    }

    /**
     * Used to get current rating
     *
     * @param $id
     *
     * @return bool|array
     * @throws Exception
     */
    function current_rating($id)
    {
        $result = Clipbucket_db::getInstance()->select(tbl('user_profile'), 'userid,allow_ratings,rating,rated_by,voters', ' userid = ' . mysql_clean($id) );
        if ($result) {
            return $result[0];
        }
        return false;
    }

    /**
     * function used to check weather user is  online or not
     *
     * @param      $last_active
     * @param null $status
     *
     * @return bool
     */
    function isOnline($last_active, $status = null): bool
    {
        $time = strtotime($last_active);
        $timeDiff = time() - $time;
        if ($timeDiff > 60 || $status == 'offline') {
            return false;
        }
        return true;
    }

    /**
     * Function used to get list of subscribed users and then
     * send subscription email
     *
     * @param      $vidDetails
     * @param bool $updateStatus
     *
     * @return bool
     * @throws Exception
     */
    function sendSubscriptionEmail($vidDetails, bool $updateStatus = true): bool
    {
        if (!$vidDetails['videoid']) {
            e(lang('invalid_videoid'));
            return false;
        }

        if (!$vidDetails['userid']) {
            e(lang('invalid_userid'));
            return false;
        }

        //Lets get the list of subscribers
        $subscribers = $this->get_user_subscribers_detail($vidDetails['userid'], false);
        //Now lets get details of our uploader bhai saab
        $uploader = $this->get_user_details($vidDetails['userid']);
        //Loading subscription email template
        if ($subscribers) {
            $var = [
                'sender_username'   => $uploader['username'],
                'video_title'       => $vidDetails['title'],
                'video_description' => $vidDetails['description'],
                'video_link'        => video_link($vidDetails),
                'video_thumb'       => DirPath::getUrl('root') . get_thumb($vidDetails)
            ];
            foreach ($subscribers as $subscriber) {
                EmailTemplate::sendMail('video_subscription', $subscriber['userid'], $var);
            }

            $total_subscribers = count($subscribers);
            $s = '';
            if ($total_subscribers > 1) {
                $s = 's';
            }
            e(lang('subs_email_sent_to_users', [$total_subscribers, $s]), 'm');
        }

        //Updating video subscription email status to sent
        if ($updateStatus) {
            Clipbucket_db::getInstance()->update(tbl('video'), ['subscription_email'], ['sent'], " videoid='" . $vidDetails['videoid'] . "'");
        }

        return true;
    }

    /**
     * function used to get user sessions
     * @throws Exception
     */
    function get_sessions(): array
    {
        $sessions =  Session::getInstance()->get_sessions();
        $new_sessions = [];
        if ($sessions) {
            foreach ($sessions as $session) {
                $new_sessions[$session['session_string']] = $session;
            }
        } else {
            Session::getInstance()->add_session(0, 'guest', 'guest');
        }

        return $new_sessions;
    }

    /**
     * @throws Exception
     */
    function update_user_voted($array, $userid = null)
    {
        if (!$userid) {
            $userid = user_id();
        }

        if (is_array($array)) {
            $voted = '';
            $votedDetails = Clipbucket_db::getInstance()->select(tbl('users'), 'voted', " userid = '$userid'");
            if (!empty($votedDetails)) {
                if (!empty($js)) {
                    $voted = $js->json_decode($votedDetails[0]['voted'], true);
                } else {
                    $voted = json_decode($votedDetails[0]['voted'], true);
                }
            }

            if (!empty($js)) {
                $votedEncode = $js->json_encode($voted);
            } else {
                $votedEncode = json_encode($voted);
            }

            if (!empty($votedEncode)) {
                Clipbucket_db::getInstance()->update(tbl('users'), ['voted'], ["|no_mc|$votedEncode"], " userid='$userid'");
            }
        }
    }

    /**
     * Function used to display user manger link
     *
     * @param $link
     * @param $vid
     *
     * @return string
     */
    function user_manager_link($link, $vid): string
    {
        if (function_exists($link) && !is_array($link)) {
            return $link($vid);
        }

        if (!empty($link['title']) && !empty($link['link'])) {
            return '<a href="' . $link['link'] . '">' . display_clean($link['title']) . '</a>';
        }
    }

    /**
     * Fetches all friend requests sent by given user
     *
     * @param : { integer } { $user } { id of user to fetch requests against }
     *
     * @return array : { array } { $data } { array with all sent requests details }
     * @throws Exception
     * @author : Saqib Razzaq
     * @since : 15th April, 2016, ClipBucket 2.8.1
     */
    function sent_contact_requests($user): array
    {
        return Clipbucket_db::getInstance()->select(tbl('contacts'), '*', "userid = $user AND confirmed = 'no'");
    }

    /**
     * Fetches all friend requests recieved by given user
     *
     * @param : { integer } { $user } { id of user to fetch requests against }
     *
     * @return array : { array } { $data } { array with all recieved requests details }
     * @throws Exception
     * @author : Saqib Razzaq
     * @since : 15th April, 2016, ClipBucket 2.8.1
     */
    function recieved_contact_requests($user): array
    {
        return Clipbucket_db::getInstance()->select(tbl('contacts'), '*', "contact_userid = $user AND confirmed = 'no'");
    }

    /**
     * Fetches all friends of given user
     *
     * @param : { integer } { $user } { id of user to fetch friends against }
     *
     * @return array : { array } { $data } { array with all friends details }
     * @throws Exception
     * @author : Saqib Razzaq
     * @since : 15th April, 2016, ClipBucket 2.8.1
     */
    function added_contacts($user): array
    {
        return Clipbucket_db::getInstance()->select(tbl('contacts'), '*', "(contact_userid = $user OR userid = $user) AND confirmed = 'yes'");
    }

    /**
     * Fetches friendship status of two users
     *
     * @param $logged_in_user
     * @param $channel_user
     *
     * @return string : { string } { s = sent, r = recieved, f = friends }
     * @throws Exception
     */
    function friendship_status($logged_in_user, $channel_user): string
    {
        if (!user_id()) {
            return '';
        }
        $sent = $this->sent_contact_requests($logged_in_user);
        $pending = $this->recieved_contact_requests($logged_in_user);
        $friends = $this->added_contacts($logged_in_user);

        foreach ($sent as $key => $data) {
            if ($data['contact_userid'] == $channel_user) {
                return 's'; // sent
            }
        }

        foreach ($pending as $key => $data) {
            if ($data['userid'] == $channel_user) {
                return 'r'; // received
            }
        }

        foreach ($friends as $key => $data) {
            if ($data['contact_userid'] == $channel_user) {
                return 'f'; // friends
            }
        }
        return '';
    }

}
