<?php

class Video
{
    private static $video;
    private $tablename = '';
    private $tablename_categories = '';
    private $field_id = '';
    private $fields = [];
    private $fields_categories = [];
    private $display_block = '';
    private $display_var_name = '';
    private $search_limit = 0;
    private $broadcast_option = [];
    private $status_list= [];

    /**
     * @throws Exception
     */
    public function __construct(){
        $this->tablename = 'video';
        $this->field_id = 'videoid';
        $this->tablename_categories = 'video_categories';

        $this->fields = [
            'videoid'
            ,'videokey'
            ,'video_password'
            ,'video_users'
            ,'username'
            ,'userid'
            ,'title'
            ,'file_name'
            ,'file_type'
            ,'file_directory'
            ,'description'
            ,'broadcast'
            ,'location'
            ,'datecreated'
            ,'country'
            ,'allow_embedding'
            ,'rating'
            ,'rated_by'
            ,'voter_ids'
            ,'allow_comments'
            ,'comment_voting'
            ,'comments_count'
            ,'last_commented'
            ,'featured'
            ,'featured_date'
            ,'allow_rating'
            ,'active'
            ,'favourite_count'
            ,'playlist_count'
            ,'views'
            ,'last_viewed'
            ,'date_added'
            ,'flagged'
            ,'duration'
            ,'status'
            ,'default_thumb'
            ,'embed_code'
            ,'downloads'
            ,'uploader_ip'
            ,'video_files'
            ,'file_server_path'
            ,'video_version'
            ,'thumbs_version'
            ,'re_conv_status'
            ,'subscription_email'
        ];

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.3.0', '1')) {
            $this->fields[] = 'is_castable';
            $this->fields[] = 'bits_color';
        }
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '305')) {
            $this->fields[] = 'age_restriction';
        }
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '371')) {
            $this->fields[] = 'default_poster';
            $this->fields[] = 'default_backdrop';
        }
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '273')) {
            $this->fields[] = 'fov';
        }
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279')) {
            $this->fields[] = 'convert_percent';
        }
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '329')) {
            $this->fields[] = 'aspect_ratio';
        }

        $this->fields_categories = [
            'category_id'
            ,'parent_id'
            ,'category_name'
            ,'category_order'
            ,'category_desc'
            ,'date_added'
            ,'category_thumb'
            ,'isdefault'
        ];

        $this->display_block = LAYOUT . '/blocks/videos/video.html';
        $this->display_var_name = 'video';
        $this->search_limit = (int)config('videos_items_search_page');

        $this->broadcast_option = ['public' => lang('vdo_br_opt1'), 'private' => lang('vdo_br_opt2'), 'unlisted' => lang('vdo_broadcast_unlisted'), 'logged' => lang('logged_users_only')];
    }

    public function getBroadcastOption(): array
    {
        return $this->broadcast_option;
    }

    public static function getInstance(): self
    {
        if( empty(self::$video) ){
            self::$video = new self();
        }
        return self::$video;
    }

    public function getTableName(): string
    {
        return $this->tablename;
    }

    public function getTableNameCategories(): string
    {
        return $this->tablename_categories;
    }

    public function addFields(array $fields){
        if( empty($fields) ){
            return;
        }
        foreach($fields as $field){
            $this->fields[] = $field;
        }
    }

    private function getFields(): array
    {
        return $this->fields;
    }

    private function getFieldsCategories(): array
    {
        return $this->fields_categories;
    }

    private function getSQLFields($type = '', $prefix = false): array
    {
        switch($type){
            case 'video':
            default:
                $fields = $this->getFields();
                break;

            case 'categories':
                $fields = $this->getFieldsCategories();
                break;
        }

        return array_map(function($field) use ($prefix) {
            $field_name = $this->getTableName() . '.' . $field;
            if( $prefix ){
                $field_name .= ' AS `'.$this->getTableName() . '.' . $field.'`';
            }
            return $field_name;
        }, $fields);
    }

    private function getVideoFields($prefix = false): array
    {
        return $this->getSQLFields('video', $prefix);
    }

    private function getCategoriesFields($prefix = false): array
    {
        return $this->getSQLFields('categories', $prefix);
    }

    public function getSearchLimit(): int
    {
        return $this->search_limit;
    }

    public function getDisplayBlock(): string
    {
        return $this->display_block;
    }

    public function getDisplayVarName(): string
    {
        return $this->display_var_name;
    }

    /**
     * @throws Exception
     */
    public function getOne(array $params = [])
    {
        $params['first_only'] = true;
        $params['get_detail'] = true;
        return $this->getAll($params);
    }

    public function getFilterParams(string $value, array $params): array
    {
        switch ($value) {
            case 'most_recent':
            default:
                $params['order'] = $this->getTableName() . '.date_added DESC';
                break;
            case 'most_old':
                $params['order'] = $this->getTableName() . '.date_added ASC';
                break;
            case 'most_viewed':
                $params['order'] = $this->getTableName() . '.views DESC';
                break;

            case 'featured':
                $params['featured'] = true;
                break;

            case 'top_rated':
                $params['order'] = $this->getTableName() . '.rating DESC, ' . $this->getTableName() . '.rated_by DESC';
                break;

            case 'longer':
                $params['order'] = $this->getTableName() . '.duration DESC';
                break;

            case 'shorter':
                $params['order'] = $this->getTableName() . '.duration ASC';
                break;

            case 'viewed_recently':
                $params['order'] = $this->getTableName() . '.last_viewed DESC';
                break;

            case 'most_commented':
                if( config('enable_comments_video') == 'yes' ) {
                    $params['order'] = $this->getTableName() . '.comments_count DESC';
                }
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
                $column = $this->getTableName() . '.date_added';
                $params['condition'] = Search::date_margin($column, $value);
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
        $sorts = SortType::getSortTypes('videos');

        if (config('enable_comments_video') != 'yes') {
            unset($sorts[array_search('most_commented', $sorts)]);
        }

        if (config('video_rating') != '1') {
            unset($sorts[array_search('top_rated', $sorts)]);
        }

        return $sorts;
    }

    /**
     * @throws Exception
     * @noinspection DuplicatedCode
     */
    public function getAll(array $params = [])
    {
        $param_videoid = $params['videoid'] ?? false;
        $param_videoids = $params['videoids'] ?? false;
        $param_videokey = $params['videokey'] ?? false;
        $param_userid = $params['userid'] ?? false;
        $param_file_name = $params['file_name'] ?? false;
        $param_category = $params['category'] ?? false;
        $param_search = $params['search'] ?? false;
        $param_collection_id = $params['collection_id'] ?? false;
        $param_featured = $params['featured'] ?? false;
        $param_title = $params['title'] ?? false;
        $param_tags = $params['tags'] ?? false;
        $param_active = $params['active'] ?? false;
        $param_status = $params['status'] ?? false;
        $param_condition = $params['condition'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_show_unlisted = $params['show_unlisted'] ?? false;
        $param_first_only = $params['first_only'] ?? false;
        $param_exist = $params['exist'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_disable_generic_constraints = $params['disable_generic_constraints'] ?? false;
        $param_not_join_user_profile = $params['not_join_user_profile'] ?? false;
        $param_join_flag= $params['join_flag'];
        $param_get_detail = $params['get_detail'] ?? false;

        $conditions = [];
        if( $param_videoid ){
            $conditions[] = $this->getTableName() . '.videoid = \''.mysql_clean($param_videoid).'\'';
        }
        if( $param_videoids ){
            $conditions[] = $this->getTableName() . '.videoid IN ( '.mysql_clean(implode(', ', $param_videoids)).')';
        }
        if( $param_videokey ){
            $conditions[] = $this->getTableName() . '.videokey = \''.mysql_clean($param_videokey).'\'';
        }
        if( $param_userid ){
            $conditions[] = $this->getTableName() . '.userid = \''.mysql_clean($param_userid).'\'';
        }
        if( $param_file_name ){
            $conditions[] = $this->getTableName() . '.file_name = \''.mysql_clean($param_file_name).'\'';
        }
        if( $param_featured ){
            $conditions[] = $this->getTableName() . '.featured = \'yes\'';
        }
        if( $param_active ){
            $conditions[] = $this->getTableName() . '.active = \'' . mysql_clean($param_active) . '\'';
        }
        if( $param_status ){
            $conditions[] = $this->getTableName() . '.status = \'' . mysql_clean($param_status) . '\'';
        }
        if( $param_condition ){
            $conditions[] = '(' . $param_condition . ')';
        }

        $version = Update::getInstance()->getDBVersion();

        if( $param_search ){
            $param_search = mysql_clean($param_search);
            /* Search is done on video title, video tags, uploader username, video categories, video description */

            /** ORDER BY match score (100 pts if like match search query)
                - title
                - tag
                - username
                - categories
                - description
             */
            $match_title = 'MATCH(video.title) AGAINST (\'' . $param_search . '\' IN NATURAL LANGUAGE MODE)';
            $match_description = 'MATCH(video.description, video.title) AGAINST (\'' . $param_search . '\' IN NATURAL LANGUAGE MODE)';
            $like_title = 'LOWER(' . $this->getTableName() . '.title) LIKE \'%' . $param_search . '%\'';
            $order_search = ' ORDER BY CASE WHEN ' . $like_title . ' THEN 100 ELSE ' . $match_title . ' END DESC';
            $cond = '(' . $match_title . ' OR ' . $match_description . '  OR ' . $like_title;

            /** TAG */
            if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
                $match_tag = 'MATCH(tags.name) AGAINST (\'' . $param_search . '\' IN NATURAL LANGUAGE MODE)';
                $like_tag = 'LOWER(tags.name) LIKE \'%' . $param_search . '%\'';
                $cond .= ' OR ' . $match_tag . ' OR ' . $like_tag;
                $order_search .= ', MAX(CASE WHEN '.$like_tag.' THEN 100 ELSE ' . $match_tag . ' END) DESC ';
            }

            /** USER */
            $like_user = ' lower(users.username) LIKE \'' . $param_search . '\'';
            $cond .= ' OR ' . $like_user;
            $order_search .= ', MAX(CASE WHEN ' . $like_user . ' THEN 1 ELSE 0 END) DESC ';

            /** CATEG */
            if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
                $match_categ = 'MATCH(categories.category_name) AGAINST (\'' . $param_search . '\' IN NATURAL LANGUAGE MODE)';
                $like_categ = ' LOWER(categories.category_name) LIKE \'%' . $param_search . '%\' ';
                $cond .= ' OR ' . $match_categ . ' OR ' . $like_categ;
                $order_search .= ', MAX(CASE WHEN '.$like_title .' THEN 100 ELSE ' . $match_categ . ' END) DESC ';
            }
            $order_search .= ', ' . $match_description . ' DESC ';
            $cond .= ')';

            $conditions[] = $cond;
        }

        if ($param_tags && ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264))) {
            $conditions[] = 'MATCH(tags.name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(tags.name) LIKE \'%' . mysql_clean($param_search) . '%\'';
        }

        if ($param_title) {
            $conditions[] = 'MATCH(video.title) AGAINST (\'' . mysql_clean($param_title) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(' . $this->getTableName() . '.title) LIKE \'%' . mysql_clean($param_title) . '%\'';
        }

        if (!User::getInstance()->hasAdminAccess() && !$param_exist && !$param_disable_generic_constraints) {
            $conditions[] = $this->getGenericConstraints(['show_unlisted' => $param_first_only || $param_show_unlisted]);
        }

        $group = [];

        if( $param_count ){
            $select = ['COUNT(DISTINCT ' . $this->getTableName() . '.videoid) AS count'];
        } else {
            $select = $this->getVideoFields();

            foreach ($this->fields as $field) {
                $group[] = $this->tablename . '.' . $field;
            }
                $select[] = 'users.username AS user_username';
                $group[] = 'users.username';
        }

        $join = [];

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '264') && ($param_get_detail || $param_search || $param_tags)) {
            if( !$param_count ){
                $types = Tags::getVideoTypes();
                foreach ($types as $type) {
                    $select[] = 'GROUP_CONCAT( DISTINCT(CASE WHEN tags.id_tag_type = ' . mysql_clean($type['id_tag_type']) . ' THEN tags.name END) SEPARATOR \',\') AS tags_' . mysql_clean($type['name']);
                }
                $group[] = $this->getTableName() . '.videoid';
            }
            $join[] = 'LEFT JOIN ' . cb_sql_table('video_tags') . ' ON ' . $this->getTableName() . '.videoid = video_tags.id_video';
            $join[] = 'LEFT JOIN ' . cb_sql_table('tags') .' ON video_tags.id_tag = tags.id_tag';
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '331') && ($param_get_detail || $param_category || $param_search)) {
            $join[] = 'LEFT JOIN ' . cb_sql_table('videos_categories') . ' ON ' . $this->getTableName() . '.videoid = videos_categories.id_video';
            $join[] = 'LEFT JOIN ' . cb_sql_table('categories') . ' ON videos_categories.id_category = categories.category_id';

            if( !$param_count ){
                $select[] = 'GROUP_CONCAT( DISTINCT(categories.category_id) SEPARATOR \',\') AS category, GROUP_CONCAT( DISTINCT(categories.category_name) SEPARATOR \', \') AS category_names';
                $group[] = $this->getTableName() . '.videoid';
            }

            if( $param_get_detail ){
                $select[] = 'CONCAT(\'[\', GROUP_CONCAT(DISTINCT JSON_OBJECT(\'id\', categories.category_id, \'name\', categories.category_name)),\']\') AS category_list';
            }

            if( $param_category ){
                if( !is_array($param_category) ){
                    $conditions[] = 'categories.category_id = '.mysql_clean($param_category);
                } else {
                    $conditions[] = 'categories.category_id IN (' . implode(', ', $param_category) . ')';
                }
            }
        }

        if( $param_collection_id ){
            $collection_items_table = Collection::getInstance()->getTableNameItems();
            $join[] = 'INNER JOIN ' . cb_sql_table($collection_items_table) . ' ON ' . $collection_items_table . '.collection_id = ' . $param_collection_id . ' AND ' . $this->getTableName() . '.videoid = ' . $collection_items_table . '.object_id';
        }

        if (!$param_not_join_user_profile && $param_get_detail) {
            $join[] = 'LEFT JOIN ' . cb_sql_table('user_profile') . ' ON user_profile.userid = users.userid';

            if( !$param_count && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '136') ){
                $select[] = 'user_profile.disabled_channel';
                $group[] = 'user_profile.disabled_channel';
            }
        }

        if ($param_join_flag && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '248') && !$param_count) {
            $join[] = ' LEFT JOIN ' . cb_sql_table(Flag::getTableName()) . ' ON ' . Flag::getTableName() . '.id_element = ' . $this->tablename . '.videoid AND ' . Flag::getTableName() . '.id_flag_element_type = (SELECT id_flag_element_type FROM ' . tbl(Flag::getTableNameElementType()) . ' WHERE name = \'video\' ) ';
            $select[] = ' IF(COUNT(distinct ' . Flag::getTableName() . '.flag_id) > 0, 1, 0) AS is_flagged ';

        }

        if( $param_group ){
            $group[] = $param_group;
        }

        $having = '';
        if( $param_having ){
            $having = ' HAVING '.$param_having;
        }

        $order = '';
        if (!empty($order_search)) {
            $order = $order_search;
            if (!$param_count) {
                $group[]='video.title';
                $group[]='video.description';
            }
        } elseif( $param_order && !$param_count ){
            $replace_to_group = str_replace(['asc', 'desc', 'rand()'], '', strtolower($param_order));
            if (!empty($replace_to_group)) {
                $group[] = $replace_to_group;
            }
            $order = ' ORDER BY '.$param_order;
        }

        $limit = '';
        if( $param_limit ){
            $limit = ' LIMIT '.$param_limit;
        }

        $sql ='SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table($this->getTableName()) . '
                LEFT JOIN ' . cb_sql_table('users') . ' ON ' . $this->getTableName() . '.userid = users.userid '
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(',', $group))
            . $having
            . $order
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);

        if( $param_exist ){
            return !empty($result);
        }

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
     * @param array $params
     * @return string
     * @throws Exception
     */
    public function getGenericConstraints(array $params = []): string
    {
        if (User::getInstance()->hasAdminAccess()) {
            return '';
        }

        $show_unlisted = $params['show_unlisted'] ?? false;

        $cond = '( (video.active = \'yes\' AND video.status = \'Successful\'';

        $sql_age_restrict = '';
        if( config('enable_age_restriction') == 'yes' && config('enable_blur_restricted_content') != 'yes' ){
            $cond .= ' AND video.age_restriction IS NULL';
            $dob = user_dob();
            $sql_age_restrict = ' AND (video.age_restriction IS NULL OR TIMESTAMPDIFF(YEAR, \'' . mysql_clean($dob) . '\', NOW()) >= video.age_restriction )';
        }

        $cond .= ' AND (video.broadcast = \'public\'';

        if( $show_unlisted ){
            $cond .= ' OR (video.broadcast = \'unlisted\' AND video.video_password = \'\')';
        }
        $cond .= ')';

        $current_user_id = user_id();
        if ($current_user_id) {
            $select_contacts = 'SELECT contact_userid FROM ' . tbl('contacts') . ' WHERE confirmed = \'yes\' AND userid = ' . $current_user_id;
            $cond .= ' OR video.userid = ' . $current_user_id . ')';
            $cond .= ' OR (video.active = \'yes\' AND video.status = \'Successful\''.$sql_age_restrict.')';
            $cond .= ' OR (video.broadcast = \'private\' AND video.userid IN(' . $select_contacts . ')'.$sql_age_restrict.')';
        } else {
            $cond .= ')';
        }
        $cond .= ')';

        return $cond;
    }

    /**
     * @throws Exception
     */
    public static function display_restricted($video)
    {
        if( !empty($video['age_restriction']) ){
            echo '<span class="restricted" title="' . lang('access_forbidden_under_age', $video['age_restriction']) . '">-' . $video['age_restriction'] . '</span>';
        }
    }

    private static function getRating($video, $type = 'like')
    {
        $rating = $video['rating'];
        $ratings = $video['ratings'];
        $total = $video['total'];

        if (empty($ratings)) {
            $ratings = $video['rated_by'];
        }
        //Checking Percent
        if ($total <= 10) {
            $total = 10;
        }
        $perc = round($rating * 100 / $total);
        $likes = round($ratings * $perc / 100);

        switch($type)
        {
            default:
            case 'like':
                return $likes;
            case 'dislike':
                return $ratings - $likes;
        }
    }

    public static function getLike($video): int
    {
        return self::getRating($video, 'like');
    }

    public static function getDislike($video): int
    {
        return self::getRating($video, 'dislike');
    }

    /**
     * @throws Exception
     */
    public function isCurrentUserRestricted($video_id): string
    {
        if( User::getInstance()->hasPermission('video_moderation') ){
            return false;
        }

        $params = [];
        $params['videoid'] = $video_id;
        $video = $this->getOne($params);

        if (empty($video)) {
            return false;
        }

        if( empty($video['age_restriction']) ){
            return false;
        }

        if( !User::getInstance()->isUserConnected() ){
            return true;
        }

        if( User::getInstance()->getCurrentUserID() == $video['userid'] ){
            return false;
        }

        if( User::getInstance()->getCurrentUserAge() < $video['age_restriction'] ){
            return true;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function isToBlur($video_id)
    {
        if( config('enable_blur_restricted_content') != 'yes'){
            return false;
        }
        return $this->isCurrentUserRestricted($video_id);
    }

    /**
     * @throws Exception
     */
    public function setDefaultPicture($video_id, string $poster, string $type = 'auto')
    {
        if (empty($poster)) {
            e(lang('missing_param'));
            return;
        }
        if (!in_array($type, ['auto', 'custom', 'poster', 'backdrop']) ) {
            if( in_dev() ){
                e(lang('unknown_type', $type));
            } else {
                e(lang('technical_error'));
            }
            return;
        }

        if( in_array($type, ['auto', 'custom'])){
            $type = 'thumb';
        }

        $num = get_thumb_num($poster);
        if( empty($num) ){
            return;
        }
        Clipbucket_db::getInstance()->update(tbl('video'), ['default_' . $type], [$num], ' videoid=\'' . mysql_clean($video_id) . '\'');
    }
    /**
     * @throws Exception
     */
    public function resetDefaultPicture($video_id, string $type = 'auto')
    {
        if (!in_array($type, ['auto', 'custom', 'poster', 'backdrop']) ) {
            if( in_dev() ){
                e(lang('unknown_type', $type));
            } else {
                e(lang('technical_error'));
            }
            return;
        }

        if( in_array($type, ['auto', 'custom'])){
            $type = 'thumb';
        }

        Clipbucket_db::getInstance()->update(tbl('video'), ['default_' . $type], ['|f|null'], ' videoid=\'' . mysql_clean($video_id) . '\'');
    }

    /**
     * @param array $video_detail
     * @param string $type must one of following : thumb, poster, backdrop
     * @return void
     * @throws Exception
     */
    public function deletePictures(array $video_detail, string $type)
    {
        if (!in_array($type, ['auto', 'custom', 'poster', 'backdrop']) ) {
            if( in_dev() ){
                e(lang('unknown_type', $type));
            } else {
                e(lang('technical_error'));
            }
            return;
        }
        $results = Clipbucket_db::getInstance()->select(tbl('video_thumbs'), 'num', ' type= \''. mysql_clean($type) .'\' and videoid = ' . mysql_clean($video_detail['videoid']));
        if (!empty($results)) {
            foreach ($results as $result) {
                delete_video_thumb($video_detail, $result['num'], $type);
            }
            Video::getInstance()->resetDefaultPicture($video_detail['videoid'], $type);
        }
    }

    public function getDescription(string $description): string
    {
        $params = [
            'censor' => (config('enable_video_description_censor') == 'yes'),
            'functionList' => 'video_description',
            'links' => (config('enable_video_description_link') == 'yes')
        ];

        return CMS::getInstance($description, $params)->getClean();
    }

    /**
     * @throws Exception
     */
    public static function correctVideoCategorie($id)
    {
        Category::getInstance()->link('video', $id, Category::getInstance()->getDefaultByType('video')['category_id']);
    }

    /**
     * @param $videoid
     * @return void
     * @throws Exception
     */
    public static function deleteUnusedVideoFiles($videoid)
    {
        $video = CBvideo::getInstance()->get_video($videoid);
        $files = json_decode($video['video_files']);
        $nb_files = count($files);
        sort($files);
        $unused_resolutions = array_column(Clipbucket_db::getInstance()->select(tbl('video_resolution'), 'height', ' enabled = false', false, 'height ASC'), 'height');

        foreach ($files as $file) {
            if (in_array($file, $unused_resolutions) && $nb_files > 1) {
                CBvideo::getInstance()->remove_resolution($file, $video);
                $nb_files--;
            }
        }
    }

    /**
     * @param int|string $video_id
     * @return int
     * @throws Exception
     */
    public function getStorageUsage($video_id): int
    {
        $total = 0;
        $video = $this->getOne(['videoid' => $video_id, 'condition'=>' video_files != \'\' AND video_files IS NOT NULL']);
        if (empty($video)) {
            e(lang('class_vdo_exist_err'));
            return 0;
        }
        $total+= $this->getVideoFilesUsage($video['file_directory'], json_decode($video['video_files']), $video['file_type'], $video['file_name'], $video['video_version']);
        $total+= $this->getThumbsUsage($video['file_directory'], $video['file_name']);
        $total+= $this->getLogsUsage($video['file_name'], $video['file_directory']);
        $total+= $this->getSubtitlesUsage($video_id, $video['file_directory'], $video['file_name']);
        return $total;
    }

    /**
     * @param string $file_directory
     * @param array $resolutions
     * @param string $file_type
     * @param string $file_name
     * @param string $video_version
     * @return int
     * @throws Exception
     */
    public function getVideoFilesUsage(string $file_directory, array $resolutions, string $file_type, string $file_name, string $video_version):int
    {
        $total = 0;
        $directory_path = DirPath::get('videos') . $file_directory . DIRECTORY_SEPARATOR;
        foreach ($resolutions as $resolution) {
            switch ($file_type) {
                case 'mp4':
                    $file = $file_name . '-' . $resolution . '.mp4';

                    if ($video_version) {
                        if (file_exists($directory_path . $file) && is_file($directory_path . $file)) {
                            $total += filesize($directory_path . $file);
                        }
                    } else {
                        if (file_exists(DIRECTORY_SEPARATOR . $file) && is_file(DIRECTORY_SEPARATOR . $file)) {
                            $total += filesize(DIRECTORY_SEPARATOR . $file);
                        }
                    }
                    break;

                case 'hls':
                    $directory_path .= $file_name . DIRECTORY_SEPARATOR;
                    $vid_files = glob($directory_path . 'video_' . $resolution . '*');
                    foreach ($vid_files as $file) {
                        $total += filesize($file);
                    }
                    break;
                default:
                    e(lang('unknown_type'));
            }
        }
        return $total;
    }

    /**
     * @param string $file_directory
     * @param string $file_name
     * @return int
     */
    public function getThumbsUsage(string $file_directory, string $file_name):int
    {
        $total = 0;
        $pattern = DirPath::get('thumbs') . $file_directory . DIRECTORY_SEPARATOR . $file_name . '*';
        $glob = glob($pattern);
        foreach ($glob as $thumb) {
            $total += filesize($thumb);
        }
        return $total;
    }

    /**
     * @param string $file_name
     * @param string $file_directory
     * @return int
     */
    public function getLogsUsage(string $file_name, string $file_directory): int
    {
        $total = 0;
        $str = $file_directory . DIRECTORY_SEPARATOR;
        $file = DirPath::get('logs') . $str . $file_name . '.log';
        if (file_exists($file) && is_file($file)) {
            $total += filesize($file);
        }
        return $total;

    }

    /**
     * @param $video_id
     * @param string $file_directory
     * @param string $file_name
     * @return int
     * @throws Exception
     */
    public function getSubtitlesUsage($video_id, string $file_directory, string $file_name):int
    {
        $total = 0;
        $directory = DirPath::get('subtitles') . $file_directory . DIRECTORY_SEPARATOR;
        $query = 'SELECT * FROM ' . tbl('video_subtitle') . ' WHERE videoid = ' .$video_id;
        $result = db_select($query);
        if ($result) {
            foreach ($result as $row) {
                $filepath = $directory . $file_name . '-' . $row['number'] . '.srt';
                if (file_exists($filepath)) {
                    $total += filesize($filepath);
                }
            }
        }
        return $total;
    }

    /**
     * @throws Exception
     */
    public function setDefautThumb($num, $type, $videoid)
    {
        if (!empty(Upload::getInstance()->types_thumb[$type])) {
            $type_db = Upload::getInstance()->types_thumb[$type];
        } elseif (in_array($type, Upload::getInstance()->types_thumb) || $type == 'thumb') {
            $type_db = $type;
        } else {
            e(lang('error'));
            return false;
        }
        if ($type_db == 'auto' || $type_db == 'custom') {
            $type_db = 'thumb';
        }
        Clipbucket_db::getInstance()->update(tbl($this->tablename), ['default_' . $type_db], [(int)$num], ' videoid = ' . mysql_clean($videoid));
    }

    /**
     * @param int $videoid
     * @param int $page
     * @return array
     * @throws Exception
     */
    public function getVideoViewHistory(int $videoid, int $page): array
    {
        $sql = 'SELECT COUNT(`id_video_view`) as total FROM ' . cb_sql_table('video_views') . ' WHERE `id_video` = ' . mysql_clean($videoid);
        $total = Clipbucket_db::getInstance()->_select($sql)[0]['total'] ?? 0;

        $sql_limit = '';
        if (!empty($page)) {
            $sql_limit = ' LIMIT ' . create_query_limit($page, config('video_list_view_video_history'));
        }
        $sql = 'SELECT video_views.*, users.username FROM ' . cb_sql_table('video_views') . '
         LEFT JOIN ' . cb_sql_table('users') . ' ON video_views.id_user = users.userid
        WHERE id_video = ' . mysql_clean($videoid) . ' ORDER BY view_date DESC' . $sql_limit;
        $results = Clipbucket_db::getInstance()->_select($sql);

        return [
            'total_pages'   => count_pages($total, config('video_list_view_video_history')),
            'final_results' => $results
        ];
    }

    /**
     * @throws Exception
     */
    public function set(int $id_video, string $field, $value){
        if( !in_array($field, $this->fields) ){
            return;
        }

        $sql = 'UPDATE ' . tbl($this->tablename) . ' SET ' . $field . ' = ' . $value . ' WHERE ' . $this->field_id . ' = ' . $id_video;
        Clipbucket_db::getInstance()->execute($sql);
    }

    public static function get_thumbs_preview($vdetails, string $size = '416x260'): string
    {
        if( config('enable_video_thumbs_preview') != 'yes'){
            return '';
        }

        $thumbs = get_thumb($vdetails, true, $size, 'auto');
        if( empty($thumbs) ){
            return '';
        }

        $nb_thumbs = config('video_thumbs_preview_count');
        $total = count($thumbs);

        if ($nb_thumbs >= $total) {
            $result = $thumbs;
        } else {
            $result = [];
            $step = ($total - 1) / ($nb_thumbs - 1);

            for ($i = 0; $i < $nb_thumbs; $i++) {
                $index = (int) round($i * $step);
                $result[] = $thumbs[$index];
            }
        }


        return 'data-thumbs=\'' . json_encode($result) . '\'';
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getStatusList(): array
    {
        if (empty($this->status_list)) {
            $row = Clipbucket_db::getInstance()->_select('SHOW COLUMNS FROM '.tbl('video').' LIKE \'status\'')[0];
            preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
            $this->status_list = str_getcsv($matches[1], ",", "'");
        }
        return $this->status_list;
    }
}

class CBvideo extends CBCategory
{
    var $embed_func_list = []; //Function list that are applied while asking for video embed code
    var $action = ''; // variable used to call action class
    var $collection = '';
    var $email_template_vars = [];

    var $dbtbl = ['video' => 'video'];

    var $video_manager_funcs = [];

    var $video_delete_functions = []; //Holds all delete functions of video

    private $basic_fields = [];
    private $extra_fields = [];

    public static function getInstance()
    {
        global $cbvid;
        return $cbvid;
    }

    /**
     * __Constructor of CBVideo
     * @throws Exception
     */
    function init()
    {
        global $Cbucket, $cb_columns;
        $this->cat_tbl = 'videos_categories';
        $this->section_tbl = 'video';
        $this->use_sub_cats = true;
        $this->init_actions();
        $this->init_collections();
        $this->init_admin_menu();

        if (config('vid_cat_height')) {
            $this->cat_thumb_height = config('vid_cat_height');
        }
        if (config('vid_cat_width')) {
            $this->cat_thumb_width = config('vid_cat_width');
        }

        if (isSectionEnabled('videos')) {
            $Cbucket->search_types['videos'] = 'cbvid';
        }

        $this->video_delete_functions[] = 'delete_video_from_collection';

        $basic_fields = $this->basic_fields_setup();

        $cb_columns->object('videos')->register_columns($basic_fields);

        if( config('enable_age_restriction') == 'yes' ){
            register_anchor_function('display_restricted', 'in_video_thumb', Video::class);
        }
        register_anchor_function('display_banner', 'in_video_thumb', self::class);
        register_anchor_function('display_convert_percent', 'in_video_thumb', self::class);
    }

    /**
     * @throws Exception
     */
    public static function display_banner($vdo = [])
    {
        $text = '';
        $class = '';
        if ($vdo['active'] == 'no') {
            $text = lang('video_is', strtolower(lang('inactive')) );
            $class = 'label-danger';
        } else if ($vdo['status'] != 'Successful') {
            $text = lang('video_is', strtolower(lang(strtolower($vdo['status']))) );
            $class = 'label-warning';
        } else if ($vdo['broadcast'] == 'unlisted') {
            $text = lang('video_is', strtolower(lang('unlisted')));
            $class = 'label-info';
        }

        if( !empty($text) ){
            echo '<div class="thumb_banner '.$class.'">' . $text . '</div>';
        }
    }

    /**
     * @throws Exception
     */
    public static function display_convert_percent($video = [])
    {
        if( strtolower($video['status']) != 'processing' ){
            return;
        }

        if( !Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279') ){
            return;
        }

        echo '<div class="processing" data-id="' . $video['videoid'] . '">
                    <i class="fa fa-spinner fa-spin"></i>
                    <span>' . $video['convert_percent'] . '%</span>
              </div>';
    }

    /**
     * @throws Exception
     */
    function init_admin_menu()
    {
        if (NEED_UPDATE) {
            return;
        }

        if (User::getInstance()->hasPermission('video_moderation') && isSectionEnabled('videos')) {
            $menu_video = [
                'title'   => lang('videos')
                , 'class' => 'glyphicon glyphicon-facetime-video'
                , 'sub'   => []
            ];

            $menu_video['sub'][] =  [
                'title' => lang('manage_x', strtolower(lang('videos')))
                , 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'
            ];

            if( isSectionEnabled('playlists') ){
                $menu_video['sub'][] =  [
                    'title' => lang('manage_x', strtolower(lang('playlists')))
                    , 'url' => DirPath::getUrl('admin_area') . 'manage_playlist.php'
                ];
            }

            if (config('enable_video_categories') != 'no') {
                $menu_video['sub'][] = [
                    'title'   => lang('manage_x', strtolower(lang('categories')))
                    , 'url'   => DirPath::getUrl('admin_area') . 'category.php'
                ];
            }

            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '255')) {
                $menu_video['sub'][] = [
                    'title' => lang('video_flagged')
                    , 'url' => DirPath::getUrl('admin_area') . 'flagged_item.php?type=video'
                ];
            }
            $menu_video['sub'][] = [
                'title' => 'Mass Upload Videos'
                , 'url' => DirPath::getUrl('admin_area') . 'mass_uploader.php'
            ];
            $menu_video['sub'][] = [
                'title' => 'List Inactive Videos'
                , 'url' => DirPath::getUrl('admin_area') . 'video_manager.php?search=search&active=no'
            ];

            ClipBucket::getInstance()->addMenuAdmin($menu_video, 70);
        }
    }

    function set_basic_fields($fields = [])
    {
        return $this->basic_fields = $fields;
    }

    /**
     * @throws Exception
     */
    function basic_fields_setup(): array
    {
        # Set basic video fields
        $basic_fields = [
            'videoid', 'videokey', 'video_password', 'video_users', 'username', 'userid', 'title', 'file_name', 'file_type'
            , 'file_directory', 'description', 'broadcast', 'location', 'datecreated'
            , 'country', 'allow_embedding', 'rating', 'rated_by', 'voter_ids', 'allow_comments'
            , 'comment_voting', 'comments_count', 'last_commented', 'featured', 'featured_date', 'allow_rating'
            , 'active', 'favourite_count', 'playlist_count', 'views', 'last_viewed', 'date_added', 'flagged', 'duration', 'status'
            , 'default_thumb', 'embed_code', 'downloads', 'uploader_ip'
            , 'video_files', 'file_server_path', 'video_version', 'thumbs_version'
            , 're_conv_status', 'subscription_email'
        ];

        $version = Update::getInstance()->getDBVersion();
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.3.0', '1')) {
            $basic_fields[] = 'is_castable';
            $basic_fields[] = 'bits_color';
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '305')) {
            $basic_fields[] = 'age_restriction';
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '273')) {
            $basic_fields[] = 'fov';
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279')) {
            $basic_fields[] = 'convert_percent';
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '329')) {
            $basic_fields[] = 'aspect_ratio';
        }

        return $this->set_basic_fields($basic_fields);
    }

    function get_extra_fields()
    {
        return $this->extra_fields;
    }

    /**
     * Initiating Collections
     */
    function init_collections()
    {
        $this->collection = new Collections();
        $this->collection->objType = 'videos';
        $this->collection->objClass = 'cbvideo';
        $this->collection->objTable = 'video';
        $this->collection->objName = 'Video';
        $this->collection->objFunction = 'video_exists';
        $this->collection->objFieldID = 'videoid';
    }

    /**
     * Function used to check weather video exists or not
     *
     * @param int|string $vid
     *
     * @return bool|int
     * @throws Exception
     */
    function video_exists($vid)
    {
        if (is_numeric($vid)) {
            return Clipbucket_db::getInstance()->count(tbl('video'), 'videoid', ' videoid=\'' . mysql_clean($vid) . '\' ');
        }
        return Clipbucket_db::getInstance()->count(tbl('video'), 'videoid', ' videokey=\'' . mysql_clean($vid) . '\' ');
    }

    /**
     * Function used to get video data
     *
     * @param      $vid
     * @param bool $filename
     *
     * @return bool|mixed|STRING
     * @throws Exception
     */
    function get_video($vid, bool $filename = false)
    {
        $vid = mysql_clean($vid);

        $userFields = get_user_fields();
        $videoFields = get_video_fields();

        $fields = [
            'video' => $videoFields,
            'users' => $userFields
        ];

        $cond = (($filename) ? 'video.file_name' : (is_numeric($vid) ? 'video.videoid' : 'video.videokey')) . ' = \'%s\' ';

        $select_tag = '';
        $select_categ = '';
        $join_tag = '';
        $join_categ = '';
        $group = [];
        $version = Update::getInstance()->getDBVersion();

        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $types = Tags::getVideoTypes();
            foreach ($types as $type) {
                $select_tag .= ', GROUP_CONCAT( DISTINCT(CASE WHEN tags.id_tag_type = ' . mysql_clean($type['id_tag_type']) . ' THEN tags.name ELSE \'\' END) SEPARATOR \',\') AS tags_' . mysql_clean($type['name']);
            }
            $join_tag = ' LEFT JOIN ' . cb_sql_table('video_tags') . ' ON video.videoid = video_tags.id_video 
                    LEFT JOIN ' . cb_sql_table('tags') .' ON video_tags.id_tag = tags.id_tag';
            $group[] = ' video.videoid ';
        }

        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
            $select_categ = ', GROUP_CONCAT( DISTINCT(categories.category_name) SEPARATOR \', \') AS category';
            $join_categ .= ' LEFT JOIN ' . cb_sql_table('videos_categories') . ' ON video.videoid = videos_categories.id_video';
            $join_categ .= ' LEFT JOIN ' . cb_sql_table('categories') . ' ON videos_categories.id_category = categories.category_id';
            $group[] = ' video.videoid ';
        }

        $query = 'SELECT ' . table_fields($fields) . ' ' . $select_tag . ' ' . $select_categ . ' FROM ' . cb_sql_table('video');
        $query .= ' LEFT JOIN ' . cb_sql_table('users') . ' ON video.userid = users.userid';
        $query .= $join_tag;
        $query .= $join_categ;
        if ($cond) {
            $query .= ' WHERE ' . sprintf($cond, $vid);
        }

        $query .= (!empty($group) ? 'GROUP BY ' . implode(',', $group) :''). ' LIMIT 1';
        $query_id = cb_query_id($query);

        $data = cb_do_action('select_video', ['query_id' => $query_id, 'videoid' => $vid]);

        if ($data) {
            return $data;
        }

        $result = select($query);

        if ($result) {
            $result = apply_filters($result[0], 'get_video');

            cb_do_action('return_video', [
                'query_id'  => $query_id,
                'results'   => $result,
                'object_id' => $vid,
                'videoid'   => $vid
            ]);

            return $result;
        }
        return false;
    }

    /**
     * Function used to perform several actions with a video
     *
     * @param $case
     * @param $vid
     *
     * @return bool|string|void
     * @throws Exception
     */
    function action($case, $vid)
    {
        $video = $this->get_video($vid);

        if (empty($video)) {
            return false;
        }

        //Let's just check weather video exists or not
        switch ($case) {
            //Activating a video
            case 'activate':
            case 'av':
            case 'a':
                Clipbucket_db::getInstance()->update(tbl('video'), ['active'], ['yes'], ' videoid=\'' . mysql_clean($vid) . '\' OR videokey = \'' . mysql_clean($vid) . '\' ');
                e(lang('class_vdo_act_msg'), 'm');

                if (config('approve_video_notification') == 'yes') {
                    //Sending Email
                    $var = [
                        'video_link'   => video_link($video)
                        ,'video_title' => $video['title']
                    ];

                    if ($video['email'] != 'admin@thiswebsite.com') {
                        //Now Finally Sending Email
                        EmailTemplate::sendMail('video_activation', $video['userid'], $var);
                    }
                }

                if( $video['status'] == 'Successful' && in_array($video['broadcast'], ['public', 'logged']) && $video['subscription_email'] == 'pending' ){
                    //Sending Subscription email in background
                    if (stristr(PHP_OS, 'WIN')) {
                        exec(System::get_binaries('php') . ' -q ' . DirPath::get('actions') . 'send_subscription_email.php ' . $vid);
                    } else {
                        exec(System::get_binaries('php') . ' -q ' . DirPath::get('actions') . 'send_subscription_email.php ' . $vid . ' &> /dev/null &');
                    }
                }
                break;

            //Deactivating a video
            case 'deactivate':
            case 'dav':
            case 'd':
                Clipbucket_db::getInstance()->update(tbl('video'), ['active'], ['no'], ' videoid=\'' . mysql_clean($vid) . '\' OR videokey = \'' . mysql_clean($vid) . '\' ');
                e(lang('class_vdo_act_msg1'), 'm');
                break;

            //Featuring Video
            case 'feature':
            case 'featured':
            case 'f':
                Clipbucket_db::getInstance()->update(tbl('video'), ['featured', 'featured_date'], ['yes', now()], ' videoid=\'' . mysql_clean($vid) . '\' OR videokey = \'' . mysql_clean($vid) . '\' ');
                e(lang('class_vdo_fr_msg'), 'm');
                return 'featured';

            // Unfeatured video
            case 'unfeature':
            case 'unfeatured':
            case 'uf':
                Clipbucket_db::getInstance()->update(tbl('video'), ['featured'], ['no'], ' videoid=\'' . mysql_clean($vid) . '\' OR videokey = \'' . mysql_clean($vid) . '\' ');
                e(lang('class_fr_msg1'), 'm');
                break;

            case 'check_castable':
                update_castable_status($video);
                break;

            case 'update_bits_color':
                update_bits_color($video);
                break;
            case 'delete':
                $video_clean = mysql_clean($vid);
                $this->delete_video($video_clean);
                break;
        }
    }

    /**
     * Function used to update video
     *
     * @param null $array
     * @throws Exception
     */
    function update_video($array = null)
    {
        global $eh, $Upload, $userquery, $cbvid;

        if (!$array) {
            $array = $_POST;
        }
        $Upload->validate_video_upload_form($array, true);

        if (empty($eh->get_error())) {
            $required_fields = $Upload->loadRequiredFields($array);
            $location_fields = $Upload->loadLocationFields($array);
            $option_fields = $Upload->loadOptionFields($array);

            $upload_fields = array_merge($required_fields, $location_fields, $option_fields);

            //Adding Custom Upload Fields
            if (function_exists('custom_fields_list')) {
                $custom_flds = $Upload->load_custom_form_fields($array, true);
                $upload_fields = array_merge($upload_fields, $custom_flds);
            }


            if (isset($array['videoid'])) {
                $vid = $array['videoid'];
            } else {
                if (isset($array['file_name'])) {
                    $params = [
                        'filename' => $array['file_name']
                        , 'user'   => user_id()
                    ];
                    $video = get_videos($params);
                    if (isset($video[0])) {
                        $vid = $video[0]['videoid'];
                    } else {
                        $vid = null;
                    }
                }
            }

            if (is_array($_FILES)) {
                $array = array_merge($array, $_FILES);
            }

            foreach ($upload_fields as $field) {
                $name = formObj::rmBrackets($field['name']);
                $val = $array[$name];

                if (!empty($val) || !$field['use_if_value']) {
                    if (!empty($field['validate_function'])) {
                        if (isset($field['second_parameter_validate'])) {
                            $val = $field['validate_function']($val,$field['second_parameter_validate']);
                        } else {
                            $val = $field['validate_function']($val);
                        }
                    }

                    if (!empty($field['db_field'])) {
                        $query_field[] = $field['db_field'];
                    }

                    if ($field['clean_func'] && (apply_func($field['clean_func'], $val) || is_array($field['clean_func']))) {
                        $val = apply_func($field['clean_func'], mysql_clean('|no_mc|' . $val));
                    }

                    if (!empty($field['db_field'])) {
                        $query_val[] = $val;
                    }
                }
            }

            if (User::getInstance()->hasAdminAccess()) {
                if (!empty($array['status']) && in_array($array['status'], Video::getInstance()->getStatusList())) {
                    $query_field[] = 'status';
                    $query_val[] = $array['status'];
                }

                if (!empty($array['duration']) && is_numeric($array['duration']) && $array['duration'] > 0) {
                    $query_field[] = 'duration';
                    $query_val[] = $array['duration'];
                }

                if (!empty($array['views'])) {
                    $query_field[] = 'views';
                    $query_val[] = $array['views'];
                }

                if (!empty($array['rating'])) {
                    $query_field[] = 'rating';
                    $rating = $array['rating'];
                    if (!is_numeric($rating) || $rating < 0 || $rating > 10) {
                        $rating = 1;
                    }
                    $query_val[] = $rating;
                }

                if (!empty($array['rated_by'])) {
                    $query_field[] = 'rated_by';
                    $query_val[] = $array['rated_by'];
                }

                if (!empty($array['embed_code'])) {
                    $query_field[] = 'embed_code';
                    $query_val[] = $array['embed_code'];
                }

                if (!empty($array['video_fov']) && in_array($array['video_fov'], [180,360])) {
                    $query_field[] = 'fov';
                    $query_val[] = $array['video_fov'];
                }
            }
            //changes made
            //title index
            $query_val[0] = str_replace('&lt;!--', '', $query_val[0]);
            $query_val[0] = str_replace('\'', '’', $query_val[0]);
            //description index
            $query_val[1] = str_replace('&lt;!--', '', $query_val[1]);
            $query_val[1] = str_replace('\'', '’', $query_val[1]);
            //Tag index
            $query_val[3] = strtolower($query_val[3]);

            if (!user_id()) {
                e(lang('you_dont_have_permission_to_update_this_video'));
                return;
            }
            if (!$this->video_exists($vid)) {
                e(lang('class_vdo_del_err'));
                return;
            }
            if (!$this->is_video_owner($vid, user_id()) && !User::getInstance()->hasAdminAccess()) {
                e(lang('no_edit_video'));
                return;
            }

            validate_cb_form($upload_fields, $array);
            if( !empty(errorhandler::getInstance()->get_error()) ){
                return;
            }

            Clipbucket_db::getInstance()->update(tbl('video'), $query_field, $query_val, ' videoid=\'' . $vid . '\'');

            foreach ($array as $key => $item) {
                $matches = [];
                if (preg_match('/(tags)_*(.*)/',$key, $matches)) {
                    if (empty($matches['2'])) {
                        $type = 'video';
                    } else {
                        $type = $matches['2'];
                    }

                    if( empty($item) ){
                        $item = '';
                    }
                    Tags::saveTags($item, $type, $vid);
                }
            }

            if( !is_array($array['category']) ){
                $array['category'] = [$array['category']];
            }

            if (config('enable_video_categories') != 'no') {
                Category::getInstance()->saveLinks('video', $vid, $array['category']);
            } else {
                Category::getInstance()->saveLinks('video', $vid, [Category::getInstance()->getDefaultByType('video')['category_id']]);
            }

            cb_do_action('update_video', [
                'object_id' => $vid,
                'results'   => $array
            ]);

            $videoDetails = $cbvid->get_video($vid);
            if( !empty($videoDetails) && $videoDetails['status'] == 'Successful' && in_array($videoDetails['broadcast'], ['public', 'logged']) && $videoDetails['subscription_email'] == 'pending' && $videoDetails['active'] == 'yes' ){
                $userquery->sendSubscriptionEmail($videoDetails, true);
            }

            e(lang('class_vdo_update_msg'), 'm');
        }
    }

    /**
     * @throws Exception
     */
    function update_subtitle ($videoid, $number, $title)
    {
        if ($this->video_exists($videoid)) {
            Clipbucket_db::getInstance()->update(tbl('video_subtitle'), ['title'], [$title], ' videoid = ' . mysql_clean($videoid) . ' AND number LIKE \'' . $number . '\'');
        }
    }

    /**
     * Function used to delete a video
     *
     * @param $vid
     * @throws Exception
     */
    function delete_video($vid)
    {
        if ($this->video_exists($vid)) {
            $vdetails = $this->get_video($vid);

            if ($this->is_video_owner($vid, user_id()) || User::getInstance()->hasAdminAccess()) {
                #THIS SHOULD NOT BE REMOVED :O
                //list of functions to perform while deleting a video
                $del_vid_funcs = $this->video_delete_functions;

                if (is_array($del_vid_funcs)) {
                    foreach ($del_vid_funcs as $func) {
                        if (function_exists($func)) {
                            $func($vdetails);
                        }
                    }
                }

                //Remove tags
                Tags::deleteTags('video', $vdetails['videoid']);
                //delete reports for this video
                Flag::unFlagByElementId($vid, 'video');
                //Remove categories
                Category::getInstance()->unlinkAll('video', $vdetails['videoid']);

                Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('playlist_items') . ' WHERE object_id=\'' . mysql_clean($vid) . '\' AND playlist_item_type=\'v\'');
                Clipbucket_db::getInstance()->delete(tbl('favorites'), ['type', 'id'], ['v', $vdetails['videoid']]);
                Clipbucket_db::getInstance()->delete(tbl('video_views'), ['id_video'], [$vdetails['videoid']]);

                //Removing video Comments
                $params = [];
                $params['type'] = 'v';
                $params['type_id'] = $vdetails['videoid'];
                Comments::delete($params);

                //Finally Removing Database entry of video
                Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('video') . ' WHERE videoid=\'' . mysql_clean($vid) . '\'');
                Clipbucket_db::getInstance()->update(tbl('users'), ['total_videos'], ['|f|total_videos-1'], ' userid=\'' . $vdetails['userid'] . '\'');

                if( !error() && !warning() ) {
                    errorhandler::getInstance()->flush();
                    e(lang('class_vdo_del_msg'), 'm');
                }
            } else {
                e(lang('You cannot delete this video'));
            }
        } else {
            e(lang('class_vdo_del_err'));
        }
    }

    /**
     * Function used to remove video thumbs
     *
     * @param $vdetails
     * @throws Exception
     */
    function remove_thumbs($vdetails)
    {
        //delete olds thumbs from db and on disk
        Clipbucket_db::getInstance()->delete(tbl('video_thumbs'), ['videoid'], [$vdetails['videoid']]);
        $pattern = DirPath::get('thumbs') . $vdetails['file_directory'] . DIRECTORY_SEPARATOR . $vdetails['file_name'] . '*';
        $glob = glob($pattern);
        foreach ($glob as $thumb) {
            unlink($thumb);
        }

        //reset default thumb
        Clipbucket_db::getInstance()->update(tbl('video'), ['default_thumb'], [1], ' videoid = ' . mysql_clean($vdetails['videoid']));
        e(lang('vid_thumb_removed_msg'), 'm');
    }

    /**
     * Function used to remove video log
     *
     * @param $vdetails
     * @throws Exception
     */
    function remove_log($vdetails)
    {
        $str = $vdetails['file_directory'] . DIRECTORY_SEPARATOR;
        $file1 = DirPath::get('logs') . $str . $vdetails['file_name'] . '.log';
        if (file_exists($file1) && is_file($file1)) {
            unlink($file1);
        }
        e(lang('vid_log_delete_msg'), 'm');
    }

    /**
     * @param $vdetails
     * @param string|null $number
     * @throws Exception
     */
    function remove_subtitles($vdetails, string $number = null)
    {
        $directory = DirPath::get('subtitles') . $vdetails['file_directory'] . DIRECTORY_SEPARATOR;
        $query = 'SELECT * FROM ' . tbl('video_subtitle') . ' WHERE videoid = ' . $vdetails['videoid'];
        if ($number !== null) {
            $query .= ' AND number = \'' . mysql_clean($number) . '\'';
        }
        $result = db_select($query);
        if ($result) {
            foreach ($result as $row) {
                $filepath = $directory . $vdetails['file_name'] . '-' . $row['number'] . '.srt';
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
            $query_delete = 'DELETE FROM ' . tbl('video_subtitle') . ' WHERE videoid = ' . $vdetails['videoid'];
            if ($number !== null) {
                $query_delete .= ' AND number = \'' . mysql_clean($number) . '\'';
            }
            Clipbucket_db::getInstance()->execute($query_delete);
        }
        if ($number !== null) {
            e(str_replace('%s', $number,lang('video_subtitles_deleted_num')), 'm');
        } else {
            e(lang('video_subtitles_deleted'), 'm');
        }
    }

    /**
     * @param $resolution
     * @param $video_detail
     * @return void
     * @throws Exception
     */
    function remove_resolution($resolution, &$video_detail)
    {
        $directory_path = DirPath::get('videos') . $video_detail['file_directory'] . DIRECTORY_SEPARATOR;
        switch ($video_detail['file_type']) {
            default:
            case 'mp4':
                $file = $video_detail['file_name'] . '-' . $resolution . '.mp4';

                if ($video_detail['video_version'] >= 2.7) {
                    if (file_exists($directory_path . $file) && is_file($directory_path . $file)) {
                        unlink($directory_path . $file);
                    }
                } else {
                    if (file_exists(DIRECTORY_SEPARATOR . $file) && is_file(DIRECTORY_SEPARATOR . $file)) {
                        unlink(DIRECTORY_SEPARATOR . $file);
                    }
                }
                break;

            case 'hls':
                $directory_path .= $video_detail['file_name'] . DIRECTORY_SEPARATOR;
                $vid_files = glob($directory_path . 'video_' . $resolution . '*');
                foreach ($vid_files as $file) {
                    unlink($file);
                }
                //TODO regenerate index
                break;

        }

        $video_detail['video_files'] = json_encode(array_values(array_filter(json_decode($video_detail['video_files']), function ($reso) use ($resolution) {
            return $reso != $resolution;
        })));
        Clipbucket_db::getInstance()->update(tbl('video'), ['video_files'], [$video_detail['video_files']], 'videoid = ' . mysql_clean($video_detail['videoid']));
    }

    /**
     * Function used to remove video files
     *
     * @param $vdetails
     *
     * @return bool|void
     * @throws Exception
     */
    function remove_files($vdetails)
    {
        //Return nothing in case there is no input
        if (!$vdetails) {
            e('No input details specified');
            return false;
        }
        //Calling Video Delete Functions
        call_delete_video_function($vdetails);

        if ($vdetails['file_type'] === 'mp4') {
            $files = json_decode($vdetails['video_files']);

            foreach ($files as $quality) {
                $this->remove_resolution($quality, $vdetails);
            }
        } else if ($vdetails['file_type'] === 'hls') {
            $directory_path = DirPath::get('videos') . $vdetails['file_directory'] . DIRECTORY_SEPARATOR . $vdetails['file_name'] . DIRECTORY_SEPARATOR;
            if(is_dir($directory_path)) {
                $files_hls = array_diff(scandir($directory_path), ['.', '..']);
                foreach ($files_hls as $file_hls) {
                    unlink($directory_path . DIRECTORY_SEPARATOR . $file_hls);
                }
                rmdir($directory_path);
            }
        }
        e(lang('vid_files_removed_msg'), 'm');
    }


    /**
     * Function used to get videos
     * this function has all options
     * that you need to fetch videos
     * please see docs.clip-bucket.com for more details
     *
     * @param $params
     *
     * @return bool|array|void|int
     * @throws Exception
     */
    function get_videos($params)
    {
        global $cb_columns;

        $limit = $params['limit'];
        $order = $params['order'];

        $cond = '';
        $superCond = '';
        if (!User::getInstance()->hasAdminAccess()) {
            $superCond = Video::getInstance()->getGenericConstraints();
        } else {
            if ($params['active']) {
                $cond .= ' ' . ('video.active') . '=\'' . $params['active'] . '\'';
            }

            if ($params['status']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.status') . '=\'' . $params['status'] . '\'';
            }

            if ($params['broadcast']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.broadcast') . '=\'' . $params['broadcast'] . '\'';
            }
        }

        //Setting Category Condition
        $all = false;
        if (!is_array($params['category'])) {
            if (strtolower($params['category']) == 'all') {
                $all = true;
            }
        }

        if ($params['category'] && !$all) {
            if ($cond != '') {
                $cond .= ' AND ';
            }

            $cond .= ' (';

            if (!is_array($params['category'])) {
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
                $cond .= ' ' . ('video.category') . ' LIKE \'%#' . $cat_params . '#%\' ';
            }

            $cond .= ')';
        }

        //date span
        if ($params['date_span']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }

            if ($params['date_span_column']) {
                $column = $params['date_span_column'];
            } else {
                $column = 'date_added';
            }

            $cond .= ' ' . Search::date_margin($column, $params['date_span']);
        }

        //uid
        if ($params['user']) {
            if (!is_array($params['user'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.userid') . '=\'' . $params['user'] . '\'';
            } else {
                if ($cond != '') {
                    $cond .= ' AND (';
                }

                $uQu = 0;
                foreach ($params['user'] as $user) {
                    if ($uQu > 0) {
                        $cond .= ' OR ';
                    }
                    $cond .= ' ' . ('video.userid') . '=\'' . $user . '\'';
                    $uQu++;
                }

                $cond .= ' ) ';
            }
        }

        //non-uid to exclude user videos from related
        if ($params['nonuser']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('video.userid') . ' <> \'' . $params['nonuser'] . '\' ';
        }

        if ($params['editor_pick']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('in_editor_pick') . ' = \'' . $params['editor_pick'] . '\' ';
        }

        $tag_n_title = '';
        //Tags

        $version = Update::getInstance()->getDBVersion();
        if ($params['tags'] && ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) ) {
            //checking for commas ;)
            $tag_n_title .= 'T.name IN (\'' . $params['tags'] . '\') ' ;
        }
        //TITLE
        if ($params['title']) {
            if ($tag_n_title != '') {
                $tag_n_title .= ' OR ';
            }
            $tag_n_title .= ' ' . ('video.title') . ' LIKE \'%' . $params['title'] . '%\'';
        }

        if ($tag_n_title) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' (' . $tag_n_title . ') ';
        }

        //FEATURED
        if ($params['featured']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('video.featured') . ' = \'' . $params['featured'] . '\' ';
        }

        //VIDEO ID
        if ($params['videoid']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('video.videoid') . ' = \'' . $params['videoid'] . '\' ';
        }

        //VIDEO ID
        if ($params['videoids']) {
            if (is_array($params['videoids'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ( ';
                $curVid = 0;
                foreach ($params['videoids'] as $vid) {
                    if (is_numeric($vid)) {
                        if ($curVid > 0) {
                            $cond .= ' OR ';
                        }
                        $cond .= ' ' . ('video.videoid') . ' = \'' . $vid . '\' ';
                    }
                    $curVid++;
                }
                $cond .= ' ) ';
            }
        }

        //VIDEO KEY
        if ($params['videokey']) {
            if (!is_array($params['videokey'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.videokey') . ' = \'' . $params['videokey'] . '\' ';
            } else {
                if ($cond != '') {
                    $cond .= ' AND (';
                }

                $vkeyQue = 0;
                foreach ($params['videokey'] as $videokey) {
                    if ($vkeyQue > 0) {
                        $cond .= ' OR ';
                    }
                    $cond .= ' ' . ('video.videokey') . ' = \'' . $videokey . '\' ';
                    $vkeyQue++;
                }

                $cond .= ' ) ';
            }
        }

        //Exclude Vids
        if ($params['exclude']) {
            if (!is_array($params['exclude'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.videoid') . ' <> \'' . $params['exclude'] . '\' ';
            } else {
                foreach ($params['exclude'] as $exclude) {
                    if ($cond != '') {
                        $cond .= ' AND ';
                    }
                    $cond .= ' ' . ('video.videoid') . ' <> \'' . $exclude . '\' ';
                }
            }
        }

        //Duration
        if ($params['duration']) {
            $duration_op = $params['duration_op'];
            if (!$duration_op) {
                $duration_op = '=';
            }

            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('video.duration') . ' ' . $duration_op . ' \'' . $params['duration'] . '\' ';
        }

        //Filename
        if ($params['filename']) {
            if (!is_array($params['filename'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.file_name') . ' = \'' . $params['filename'] . '\' ';
            } else {
                if ($cond != '') {
                    $cond .= ' AND (';
                }

                $fileNameQue = 0;
                foreach ($params['filename'] as $filename) {
                    if ($fileNameQue > 0) {
                        $cond .= ' OR ';
                    }
                    $cond .= ' ' . ('video.file_name') . ' = \'' . $filename . '\' ';
                    $fileNameQue++;
                }

                $cond .= ' ) ';
            }
        }

        if ($params['cond']) {
            if ($params['cond_and']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
            }
            $cond .= ' ' . $params['cond'];
        }

        $functions = cb_get_functions('get_videos');
        if ($functions) {
            foreach ($functions as $func) {
                $array = ['params' => $params, 'cond' => $cond];
                if (function_exists($func['func'])) {
                    $returned = $func['func']($array);
                    if ($returned) {
                        $cond = $returned;
                    }
                }
            }
        }

        $fields = [
            'video' => get_video_fields(),
            'users' => $cb_columns->object('users')->temp_change('featured', 'user_featured')->get_columns(),
            'video_users'
        ];

        $fields = table_fields($fields);

        $join_tag = '';
        $group_tag = '';
        $match_tag='';
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $match_tag = 'T.name';
            $join_tag = ' LEFT JOIN ' . tbl('video_tags') . ' AS VT ON video.videoid = VT.id_video 
                    LEFT JOIN ' . tbl('tags') .' AS T ON VT.id_tag = T.id_tag';
            $group_tag = ' GROUP BY videoid';
        }

        if (!$params['count_only'] && !$params['show_related']) {
            $query = 'SELECT ' . $fields . ' FROM ' . cb_sql_table('video');
            $query .= ' LEFT JOIN ' . cb_sql_table('users') . ' ON video.userid = users.userid';
            $query .=  $join_tag;
            if (!empty($superCond)) {
                if ($cond !== '') {
                    $cond .= ' AND ' . $superCond;
                } else {
                    $cond .= $superCond;
                }
            }

            if ($cond) {
                $query .= ' WHERE ' . $cond;
            }

            $query .= $group_tag;
            $query .= $order ? ' ORDER BY ' . $order : false;
            $query .= $limit ? ' LIMIT ' . $limit : false;

            $result = select($query);
        }

        if ($params['show_related']) {
            $cond = '';

            if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
                if ($superCond) {
                    $cond = $superCond . ' AND ';
                }

                $cond .= '(MATCH(video.title) AGAINST (\'' . mysql_clean($params['title']) . '\' IN NATURAL LANGUAGE MODE) ';
                if( $match_tag != ''){
                    $cond .= 'OR MATCH('.$match_tag.') AGAINST (\'' . mysql_clean($params['title']) . '\' IN NATURAL LANGUAGE MODE)';
                }
                $cond .= ')';
            }

            if ($params['exclude']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.videoid') . ' <> \'' . $params['exclude'] . '\' ';
            }

            $query = ' SELECT ' . $fields . ' FROM ' . cb_sql_table('video');
            $query .= ' LEFT JOIN ' . cb_sql_table('users').' ON video.userid = users.userid ';
            $query .=  $join_tag;

            if ($cond) {
                $query .= ' WHERE ' . $cond;
            }

            $query .= ' GROUP BY videoid ';
            $query .= $order ? ' ORDER BY ' . $order : false;
            $query .= $limit ? ' LIMIT ' . $limit : false;

            $result = select($query);
            if (count($result) == 0) {
                $cond = '';

                if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
                    if ($superCond) {
                        $cond = $superCond . ' AND ';
                    }

                    //Try Finding videos via tags
                    $cond .= '(MATCH(video.title) AGAINST (\'' . mysql_clean($params['tags']) . '\' IN NATURAL LANGUAGE MODE) ';
                    if ($match_tag != '') {
                        $cond .= 'OR MATCH(' . $match_tag . ') AGAINST (\'' . mysql_clean($params['tags']) . '\' IN NATURAL LANGUAGE MODE)';
                    }
                    $cond .= ')';
                }

                if ($params['exclude']) {
                    if ($cond != '') {
                        $cond .= ' AND ';
                    }
                    $cond .= ' ' . ('video.videoid') . ' <> \'' . $params['exclude'] . '\' ';
                }

                $query = ' SELECT ' . $fields . ' FROM ' . cb_sql_table('video');
                $query .= ' LEFT JOIN ' . cb_sql_table('users').' ON video.userid = users.userid ';
                $query .=  $join_tag;

                if ($cond) {
                    $query .= ' WHERE ' . $cond;
                }

                $query .= ' GROUP BY videoid ';
                $query .= $order ? ' ORDER BY ' . $order : false;
                $query .= $limit ? ' LIMIT ' . $limit : false;

                $result = select($query);
            }

            assign($params['assign'], $result);
        }

        if ($params['pr']) {
            pr($result, true);
        }

        if ($params['count_only']) {
            if (!empty($superCond)) {
                if (!empty($cond)) {
                    $cond .= ' AND ';
                }
                $cond .= $superCond;
            }
            if (!empty($cond)) {
                $cond = ' WHERE ' . $cond;
            }

            $query_count = 'SELECT COUNT(*) AS total FROM (SELECT videoid FROM '.cb_sql_table('video') . ' ' . $cond . ' GROUP BY video.videoid) T';
            $count = Clipbucket_db::getInstance()->_select($query_count);
            if (!empty($count)) {
                $result = $count[0]['total'];
            } else {
                $result = 0;
            }
            return $result;
        }
        if ($params['assign']) {
            assign($params['assign'], apply_filters($result, 'get_video'));
        } else {
            return apply_filters($result, 'get_video');
        }
    }

    /**
     * Function used to generate Embed Code
     *
     * @param        $vdetails
     * @return string
     * @throws Exception
     */
    function embed_code($vdetails): string
    {
        //Checking for video details
        if (!is_array($vdetails)) {
            $vdetails = $this->get_video($vdetails);
        }

        $embed_code = false;

        $funcs = $this->embed_func_list;

        if (is_array($funcs)) {
            foreach ($funcs as $func) {
                if (@function_exists($func)) {
                    $embed_code = $func($vdetails);
                }

                if ($embed_code) {
                    break;
                }
            }
        }

        $embed_code = '<iframe width="' . config('embed_player_width') . '" height="' . config('embed_player_height') . '" ';
        $embed_code .= 'src="' . Network::get_server_url() . 'player/embed_player.php?vid=' . $vdetails['videokey'];

        if (config('autoplay_embed') == 'yes') {
            $embed_code .= '&autoplay=yes';
        }

        $embed_code .= '" frameborder="0" allowfullscreen></iframe>';

        return $embed_code;
    }

    /**
     * Function used to initialize action class
     * in order to call actions.class.php to
     * work with Video section, this function will be called first
     */
    function init_actions()
    {
        $this->action = new cbactions();
        $this->action->init();
        $this->action->type = 'v';
        $this->action->name = 'video';
        $this->action->obj_class = 'cbvideo';
        $this->action->check_func = 'video_exists';
        $this->action->type_tbl = $this->dbtbl['video'];
        $this->action->type_id_field = 'videoid';
    }

    /**
     * Function used to create value array for email templates
     * @param array $details video_details ARRAY
     * @throws Exception
     */
    function set_share_email($details)
    {
        $this->email_template_vars = [
            'video_description' => $details['description'],
            'video_title'       => $details['title'],
            'video_link'        => video_link($details),
            'video_thumb'       => get_thumb($details)
        ];

        $this->action->share_template_name = 'share_video';
        $this->action->val_array = $this->email_template_vars;
    }

    /**
     * Function used to check weather current user is video owner or not
     *
     * @param $vid
     * @param $uid
     *
     * @return bool
     * @throws Exception
     */
    function is_video_owner($vid, $uid): bool
    {
        $result = Clipbucket_db::getInstance()->count(tbl($this->dbtbl['video']), 'videoid', 'videoid=\'' . mysql_clean($vid) . '\' AND userid=\'' . mysql_clean($uid) . '\' ');
        if ($result > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to display video manger link
     *
     * @param $link
     * @param $vid
     *
     * @return string|void
     */
    function video_manager_link($link, $vid)
    {
        if (function_exists($link) && !is_array($link)) {
            return $link($vid);
        }

        if (!empty($link['title']) && !empty($link['link'])) {
            return '<a href="' . $link['link'] . '">' . $link['title'] . '</a>';
        }
    }

    /**
     * Function used to display video manger link temporary
     *
     * @param $link
     * @param $vid
     *
     * @return string
     */
    function video_manager_link_new($link, $vid)
    {
        if (function_exists($link) && !is_array($link)) {
            return $link($vid);
        }

        if (!empty($link['title']) && !empty($link['link'])) {
            return '<a href="' . $link['link'] . '">' . $link['title'] . '</a>';
        }
    }

    /**
     * Function used to display video categories manger link temporary
     *
     * @param $link
     * @param $vid
     *
     * @return string|void
     */
    function video_categories_manager_link($link, $vid)
    {
        if (function_exists($link) && !is_array($link)) {
            return $link($vid);
        }

        if (!empty($link['title']) && !empty($link['link'])) {
            return '<a href="' . $link['link'] . '">' . $link['title'] . '</a>';
        }
    }

    /**
     * Function used to get video rating details
     *
     * @param $id
     *
     * @return bool|array
     * @throws Exception
     */
    function get_video_rating($id)
    {
        if (is_numeric($id)) {
            $cond = ' videoid=\'' . mysql_clean($id) . '\'';
        } else {
            $cond = ' videokey=\'' . mysql_clean($id) . '\'';
        }
        $results = Clipbucket_db::getInstance()->select(tbl('video'), 'userid,allow_rating,rating,rated_by,voter_ids', $cond);

        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to display rating option for videos
     * this is an OLD TYPICAL RATING SYSTEM
     * and yes, still with AJAX
     *
     * @param $params
     *
     * @return array|void
     */
    function show_video_rating($params)
    {
        $rating = $params['rating'];
        $ratings = $params['ratings'];
        $total = $params['total'];
        $id = $params['id'];
        $type = $params['type'];
        $data_only = $params['data_only'];

        if (empty($ratings)) {
            $ratings = $params['rated_by'];
        }
        //Checking Percent
        if ($total <= 10) {
            $total = 10;
        }
        $perc = $rating * 100 / $total;
        $perc = round($perc);
        $disperc = 100 - $perc;
        if ($ratings <= 0 && $disperc == 100) {
            $disperc = 0;
        }

        $perc = $perc . '%';
        $disperc = $disperc . '%';

        if ($params['is_rating']) {
            if (error()) {
                $rating_msg = error();
                $rating_msg = '<span class="error">' . $rating_msg[0]['val'] . '</span>';
            }
            if (msg()) {
                $rating_msg = msg();
                $rating_msg = '<span class="msg">' . $rating_msg[0]['val'] . '</span>';
            }
        }

        $likes = Video::getLike($params);
        $dislikes = Video::getDislike($params);

        if ($data_only) {
            return [
                'perc'       => $perc,
                'disperc'    => $disperc,
                'id'         => $id,
                'type'       => $type,
                'rating_msg' => $rating_msg,
                'likes'      => $likes,
                'dislikes'   => $dislikes,
                'disable'    => $params['disable']
            ];
        }
        assign('perc', $perc);
        assign('disperc', $disperc);
        assign('id', $id);
        assign('type', $type);
        assign('id', $id);
        assign('rating_msg', $rating_msg);
        assign('likes', $likes);
        assign('dislikes', $dislikes);
        assign('disable', $params['disable']);

        Template('blocks/common/rating.html');
    }

    /**
     * Function used to rate video
     *
     * @param $id
     * @param $rating
     *
     * @return array
     * @throws Exception
     */
    function rate_video($id, $rating): array
    {
        if (!is_numeric($rating) || $rating <= 9) {
            $rating = 0;
        }
        if ($rating >= 10) {
            $rating = 10;
        }

        $rating_details = $this->get_video_rating($id);
        $voter_id = $rating_details['voter_ids'];

        $new_by = $rating_details['rated_by'];
        $newrate = $rating_details['rating'];

        $Oldvoters = explode('|', $voter_id);

        if (is_array($Oldvoters) && count($Oldvoters) > 2) {
            foreach ($Oldvoters as $voter) {
                if ($voter) {
                    $voters[$voter] = [
                        'userid' => $voter,
                        'time'   => now(),
                        'method' => 'old'
                    ];
                }
            }
        } else {
            if (!empty($js)) {
                $voters = $js->json_decode($voter_id, true);
            } else {
                $voters = json_decode($voter_id, true);
            }
        }

        if (!empty($voters)) {
            $already_voted = array_key_exists(user_id(), $voters);
        }

        if (!user_id()) {
            e(lang('please_login_to_rate'));
        } elseif (user_id() == $rating_details['userid'] && !config('own_video_rating')) {
            e(lang('you_cant_rate_own_video'));
        } elseif (!empty($already_voted)) {
            e(lang('you_hv_already_rated_vdo'));
        } elseif (!config('video_rating') || $rating_details['allow_rating'] != 'yes') {
            e(lang('vid_rate_disabled'));
        } else {
            $voters[user_id()] = [
                'userid'   => user_id(),
                'username' => user_name(),
                'time'     => now(),
                'rating'   => $rating
            ];

            $total_voters = count($voters);

            if (!empty($js)) {
                $voters = $js->json_encode($voters);
            } else {
                $voters = json_encode($voters);
            }

            $t = $rating_details['rated_by'] * $rating_details['rating'];
            $new_by = $total_voters;

            $newrate = ($t + $rating) / $new_by;
            if ($newrate > 10) {
                $newrate = 10;
            }
            Clipbucket_db::getInstance()->update(tbl($this->dbtbl['video']), ['rating', 'rated_by', 'voter_ids'], [$newrate, $new_by, '|no_mc|' . $voters], ' videoid=\'' . mysql_clean($id) . '\'');
            $userDetails = [
                'object_id' => $id,
                'type'      => 'video',
                'time'      => now(),
                'rating'    => $rating,
                'userid'    => user_id(),
                'username'  => user_name()
            ];
            /* Updating user details */
            update_user_voted($userDetails);
            e(lang('thnx_for_voting'), 'm');
        }

        return [
            'rating'    => $newrate
            , 'ratings' => $new_by
            , 'total'   => 10
            , 'id'      => $id
            , 'type'    => 'video'
            , 'disable' => 'disabled'
        ];
    }

    /**
     * Function used to get playlist items
     *
     * @param      $playlist_id
     * @param null $order
     * @param int $limit
     *
     * @return bool|mixed
     * @throws Exception
     */
    function get_playlist_items($playlist_id, $order = null, $limit = 10)
    {
        global $cb_columns;

        $fields = [
            'playlist_items' => $cb_columns->object('playlist_items')->temp_change('date_added', 'item_added')->get_columns(),
            'playlists'      => Playlist::getInstance()->getFields(),
            'video'          => $cb_columns->object('videos')->get_columns()
        ];

        $where = '';
        if( !User::getInstance()->hasAdminAccess() ){
            $where = ' AND ' . Video::getInstance()->getGenericConstraints(['show_unlisted' => true]);
        }

        $query = 'SELECT ' . table_fields($fields) . ' FROM ' . cb_sql_table('playlist_items');
        $query .= ' LEFT JOIN ' . cb_sql_table('playlists') . ' ON playlist_items.playlist_id = playlists.playlist_id';
        $query .= ' LEFT JOIN ' . cb_sql_table('video') . ' ON playlist_items.object_id = video.videoid';
        $query .= ' WHERE playlist_items.playlist_id = \'' . $playlist_id . '\'' . $where;

        if (!is_null($order)) {
            $query .= ' ORDER BY ' . $order;
        }

        if ($limit > 0) {
            $query .= ' LIMIT ' . $limit;
        }

        $query_id = cb_query_id($query);

        $data = cb_do_action('select_playlist_items', ['query_id' => $query_id, 'playlist_id' => $playlist_id]);

        if( !empty($data) ){
            return $data;
        }

        $data = select($query);
        if( empty($data) ){
            return false;
        }

        cb_do_action('return_playlist_items', [
            'query_id' => $query_id,
            'results'  => $data
        ]);

        return $data;
    }

    /**
     * Function used to check weather video is downloadable or not
     *
     * @param $vdo
     *
     * @return bool
     */
    function downloadable($vdo): bool
    {
        if ($vdo['file_type'] == 'hls') {
            return false;
        }
        $file = get_video_file($vdo, false);
        if ($file) {
            return true;
        }
        return false;
    }
}
