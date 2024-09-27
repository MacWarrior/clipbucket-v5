<?php
class Photo
{
    private static $photo;
    private $tablename = '';
    private $fields = [];
    private $display_block = '';
    private $search_limit = 0;
    private $display_var_name = '';

    /**
     * @throws Exception
     */
    public function __construct(){
        $this->tablename = 'photos';
        $this->fields = [
            'photo_id'
            ,'photo_key'
            ,'photo_title'
            ,'photo_description'
            ,'userid'
            ,'date_added'
            ,'last_viewed'
            ,'views'
            ,'allow_comments'
            ,'allow_embedding'
            ,'allow_tagging'
            ,'featured'
            ,'reported'
            ,'allow_rating'
            ,'broadcast'
            ,'active'
            ,'total_comments'
            ,'last_commented'
            ,'total_favorites'
            ,'rating'
            ,'rated_by'
            ,'voters'
            ,'filename'
            ,'file_directory'
            ,'ext'
            ,'downloaded'
            ,'server_url'
            ,'owner_ip'
            ,'photo_details'
        ];

        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 305)) {
            $this->fields[] = 'age_restriction';
        }

        $this->display_block = LAYOUT . '/blocks/photo.html';
        $this->display_var_name = 'photo';
        $this->search_limit = (int)config('photo_search_result');
    }

    public static function getInstance(): self
    {
        if( empty(self::$photo) ){
            self::$photo = new self();
        }
        return self::$photo;
    }

    public function getTableName(): string
    {
        return $this->tablename;
    }

    public function getAllFields($prefix = false): array
    {
        return array_map(function($field) use ($prefix) {
            $field_name = $this->getTableName() . '.' . $field;
            if( $prefix ){
                $field_name .= ' AS `'.$this->getTableName() . '.' . $field.'`';
            }
            return $field_name;
        }, $this->fields);
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
        return $this->getAll($params);
    }

    public function getFilterParams(string $value, array $params): array
    {
        switch ($value) {
            case 'most_recent':
            default:
                $params['order'] = $this->getTableName() . '.date_added DESC';
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

            case 'most_commented':
                if( config('enable_comments_photo') == 'yes' ) {
                    $params['order'] = $this->getTableName() . '.total_comments DESC';
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
        if (!isset($_GET['sort'])) {
            $_GET['sort'] = 'most_recent';
        }

        $sorts = [
            'most_recent'  => lang('most_recent')
            ,'most_viewed' => lang('mostly_viewed')
        ];

        if( config('enable_comments_photo') == 'yes' ){
            $sorts['most_commented'] = lang('most_comments');
        }

        if( config('photo_rating') == 'yes' ){
            $sorts['top_rated'] = lang('top_rated');
        }

        $sorts['featured'] = lang('featured');

        return $sorts;
    }

    /**
     * @throws Exception
     */
    public function getAll(array $params = [])
    {
        $param_photo_id = $params['photo_id'] ?? false;
        $param_photo_ids = $params['photo_ids'] ?? false;
        $param_photo_key = $params['photo_key'] ?? false;
        $param_filename = $params['filename'] ?? false;
        $param_userid = $params['userid'] ?? false;

        $param_title = $params['title'] ?? false;
        $param_tags = $params['tags'] ?? false;
        $param_extension = $params['extension'] ?? false;
        $param_active = $params['active'] ?? false;

        $param_search = $params['search'] ?? false;
        $param_collection_id = $params['collection_id'] ?? false;
        $param_featured = $params['featured'] ?? false;
        $param_condition = $params['condition'] ?? false;
        
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_first_only = $params['first_only'] ?? false;
        $param_show_unlisted = $params['show_unlisted'] ?? false;

        $conditions = [];
        if( $param_photo_id ){
            $conditions[] = $this->getTableName() . '.photo_id = \''.mysql_clean($param_photo_id).'\'';
        } elseif ( $param_photo_ids ) {
            $conditions[] = $this->getTableName() . '.photo_id IN ('.mysql_clean($param_photo_ids).')';
        }
        if( $param_photo_key ){
            $conditions[] = $this->getTableName() . '.photo_key = \''.mysql_clean($param_photo_key).'\'';
        }
        if( $param_title ){
            $conditions[] = 'LOWER(' . $this->getTableName() . '.photo_title) LIKE LOWER(\'%'.mysql_clean($param_title).'%\')';
        }
        if( $param_extension ){
            $conditions[] = 'LOWER(' . $this->getTableName() . '.extension) = LOWER(\''.mysql_clean($param_extension).'\')';
        }
        if( $param_userid ){
            $conditions[] = $this->getTableName() . '.userid = \''.mysql_clean($param_userid).'\'';
        }
        if( $param_filename ){
            $conditions[] = $this->getTableName() . '.file_name = \''.mysql_clean($param_filename).'\'';
        }
        if( $param_active ){
            $conditions[] = $this->getTableName() . '.active = LOWER(\''.mysql_clean($param_active).'\')';
        }
        if( $param_featured ){
            $conditions[] = $this->getTableName() . '.featured = \'yes\'';
        }
        if( $param_tags ){
            $conditions[] = 'tags.name LIKE \'%'.mysql_clean($param_tags).'%\'';
        }

        if( $param_condition ){
            $conditions[] = '(' . $param_condition . ')';
        }

        if (!has_access('admin_access', true)) {
            $conditions[] = $this->getGenericConstraints(['show_unlisted' => $param_first_only || $param_show_unlisted]);
        }

        $version = Update::getInstance()->getDBVersion();
        if( $param_search ){
            /* Search is done on photo title, photo tags */
            $cond = '(MATCH(photos.photo_title) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(photos.photo_title) LIKE \'%' . mysql_clean($param_search) . '%\'';
            if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
                $cond .= ' OR MATCH(tags.name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(tags.name) LIKE \'%' . mysql_clean($param_search) . '%\'';
            }
            if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
                $cond .= ' OR MATCH(categories.category_name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(categories.category_name) LIKE \'%' . mysql_clean($param_search) . '%\'';
            }
            $cond .= ')';

            $conditions[] = $cond;
        }

        $collection_items_table = Collection::getInstance()->getTableNameItems();
        if( $param_count ){
            $select = ['COUNT(DISTINCT photos.photo_id) AS count'];
        } else {
            $select = $this->getAllFields();
            $select[] = 'users.username';
            $select[] = $collection_items_table . '.collection_id ';
        }

        $join = [];
        $group = [];
        $version = Update::getInstance()->getDBVersion();
        if( $version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264) ){
            if( !$param_count ){
                $select[] = 'GROUP_CONCAT( DISTINCT(tags.name) SEPARATOR \',\') AS tags';
                $group[] = 'photos.photo_id';
            }
            $join[] = 'LEFT JOIN ' . cb_sql_table('photo_tags') . ' ON photos.photo_id = photo_tags.id_photo';
            $join[] = 'LEFT JOIN ' . cb_sql_table('tags') .' ON photo_tags.id_tag = tags.id_tag';
        }

        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
            $join[] = 'LEFT JOIN ' . cb_sql_table('photos_categories') . ' ON photos.photo_id = photos_categories.id_photo';
            $join[] = 'LEFT JOIN ' . cb_sql_table('categories') . ' ON photos_categories.id_category = categories.category_id';

            if( !$param_count ){
                $select[] = 'GROUP_CONCAT( DISTINCT(categories.category_id) SEPARATOR \',\') AS category';
                $group[] = 'photos.photo_id';
            }
        }

        if( $param_collection_id ){
            $join[] = 'INNER JOIN ' . cb_sql_table($collection_items_table) . ' ON ' . $collection_items_table . '.collection_id = ' . $param_collection_id . ' AND photos.photo_id = ' . $collection_items_table . '.object_id';
        } else {
            $join[] = 'LEFT JOIN  ' . cb_sql_table($collection_items_table) . ' ON  photos.photo_id = ' . $collection_items_table . '.object_id';
        }

        if( $param_group ){
            $group[] = $param_group;
        }

        $having = '';
        if( $param_having ){
            $having = ' HAVING '.$param_having;
        }

        $order = '';
        if( $param_order ){
            $group[] = str_replace(['asc', 'desc'], '', strtolower($param_order));
            $order = ' ORDER BY '.$param_order;
        }

        $limit = '';
        if( $param_limit ){
            $limit = ' LIMIT '.$param_limit;
        }

        $sql ='SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table('photos') . '
                LEFT JOIN ' . cb_sql_table('users') . ' ON photos.userid = users.userid '
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
    public function getGenericConstraints(array $params = []): string
    {
        if (has_access('admin_access', true)) {
            return '';
        }

        $show_unlisted = $params['show_unlisted'] ?? false;

        $cond = '(((photos.active = \'yes\'';

        $sql_age_restrict = '';
        if( config('enable_age_restriction') == 'yes' && config('enable_blur_restricted_content') != 'yes' ){
            $cond .= ' AND photos.age_restriction IS NULL';
            $dob = user_dob();
            $sql_age_restrict = ' AND (photos.age_restriction IS NULL OR TIMESTAMPDIFF(YEAR, \'' . mysql_clean($dob) . '\', now()) >= photos.age_restriction )';
        }

        $cond .= ' AND (photos.broadcast = \'public\'';
        if( $show_unlisted ){
            $cond .= ' OR (photos.broadcast = \'unlisted\')';
        }
        $cond_orphan = ' AND ' . Collection::getInstance()->getTableNameItems() .'.collection_id IS NOT NULL ' ;
        $cond .= ')';

        $current_user_id = user_id();
        if ($current_user_id) {
            $cond_orphan .= ' OR photos.userid = ' . $current_user_id ;
            $cond.=')';
            $select_contacts = 'SELECT contact_userid FROM ' . tbl('contacts') . ' WHERE confirmed = \'yes\' AND userid = ' . $current_user_id;
            $cond .= ' OR (photos.active = \'yes\' AND photos.broadcast IN(\'public\',\'logged\')'.$sql_age_restrict.')';
            $cond .= ' OR (photos.broadcast = \'private\' AND photos.userid IN(' . $select_contacts . ')'.$sql_age_restrict.')';
            $cond .= ' OR (photos.broadcast = \'private\' AND photos.userid IN(' . $select_contacts . ')'.$sql_age_restrict.')';
        } else {
            $cond .= ')';
        }
        $cond .= ')';
        $cond .= $cond_orphan . ')';
        return $cond;
    }

    /**
     * @throws Exception
     */
    public static function display_restricted($photo)
    {
        if( !empty($photo['age_restriction']) ){
            echo '<span class="restricted" title="' . lang('access_forbidden_under_age', $photo['age_restriction']) . '">' . lang('access_forbidden_under_age_display', $photo['age_restriction']) . '</span>';
        }
    }

    /**
     * @throws Exception
     */
    public function isCurrentUserRestricted($photo_id): string
    {
        if (has_access('video_moderation', true)) {
            return false;
        }

        $params = [];
        $params['photo_id'] = $photo_id;
        $photo = $this->getOne($params);

        if (empty($photo)) {
            return false;
        }

        if( empty($photo['age_restriction']) ){
            return false;
        }

        if( !User::getInstance()->isUserConnected() ){
            return true;
        }

        if( User::getInstance()->getCurrentUserID() == $photo['userid'] ){
            return false;
        }

        if( User::getInstance()->getCurrentUserAge() < $photo['age_restriction'] ){
            return true;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function isToBlur($photo_id)
    {
        if (config('enable_blur_restricted_content') != 'yes') {
            return false;
        }
        return $this->isCurrentUserRestricted($photo_id);
    }

    /**
     * @param $id
     * @return null
     * @throws Exception
     */
    public static function generatePhoto($id)
    {
        CBPhotos::getInstance()->generate_photos($id);
    }

    /**
     * @param string|int $id
     * @param string $file_name
     * @param string $file_directory
     * @param string $extension
     * @return int
     * @throws Exception
     */
    public function getUsage($id, string $file_name, string $file_directory, string $extension, string $photo_key): int
    {
        $total = 0;
        $details = [
            'photo_id' => $id,
            'photo_key' => $photo_key,
            'file_directory'=>$file_directory,
            'filename'=>$file_name,
            'ext'=>$extension
        ];
        $files = get_image_file(['details' => $details, 'size' => 't', 'multi' => true, 'with_orig' => true, 'with_path' => false]);
        if (!empty($files)) {
            foreach ($files as $file) {
                $file_dir = DirPath::get('photos') . $file;
                if (file_exists($file_dir)) {
                    $total += filesize($file_dir);
                }
            }
        }
        return $total;
    }

    public function getPhotoRelated($photo_id, $limit, $order = 'date_added DESC')
    {
        $photo = $this->getOne(['photo_id'=>$photo_id]);
        $version = Update::getInstance()->getDBVersion();

        $cond_title = '(MATCH(photos.photo_title) AGAINST (\'' . mysql_clean($photo['title']) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(photos.photo_title) LIKE \'%' . mysql_clean($param_search) . '%\'';
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $cond_title .= ' OR MATCH(tags.name) AGAINST (\'' . mysql_clean($photo['title']) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(tags.name) LIKE \'%' . mysql_clean($param_search) . '%\'';
        }
        $cond_title .= ')';
        $cond_tag = '(MATCH(photos.photo_title) AGAINST (\'' . mysql_clean($photo['tags']) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(photos.photo_title) LIKE \'%' . mysql_clean($param_search) . '%\'';
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $cond_tag .= ' OR MATCH(tags.name) AGAINST (\'' . mysql_clean($photo['tags']) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(tags.name) LIKE \'%' . mysql_clean($param_search) . '%\'';
        }
        $cond_tag .= ')';

        $sql = 'SELECT GROUP_CONCAT(DISTINCT (photo_id)) as ids FROM (
                    SELECT photo_id, 2 as score, photos.date_added FROM ' . cb_sql_table('photos') . '
                    LEFT JOIN ' . cb_sql_table('photo_tags') . ' ON photos.photo_id = photo_tags.id_photo
                    LEFT JOIN ' . cb_sql_table('tags') .' ON photo_tags.id_tag = tags.id_tag 
                    WHERE photo_id != ' . mysql_clean($photo_id) . ' 
                    AND '.$cond_title.' 
                UNION 
                    SELECT photo_id, 1 as score, photos.date_added FROM ' . cb_sql_table('photos') . '
                    LEFT JOIN ' . cb_sql_table('photo_tags') . ' ON photos.photo_id = photo_tags.id_photo
                    LEFT JOIN ' . cb_sql_table('tags') .' ON photo_tags.id_tag = tags.id_tag 
                    WHERE photo_id != ' . mysql_clean($photo_id) . ' 
                    AND '.$cond_tag.' 
                ) AS R
                ORDER BY score DESC,' . $order ;
        $result = Clipbucket_db::getInstance()->_select($sql);
        return $this->getAll(['photo_ids'=>$result[0]['ids']]);
    }
}

class CBPhotos
{
    var $action = '';
    var $collection = '';
    var $p_tbl = 'photos';
    var $exts = '';
    var $max_file_size; // image file size. Setting from Admin area;
    var $mid_width;
    var $mid_height;
    var $lar_width;
    var $thumb_width;
    var $thumb_height;
    var $position;
    var $cropping;
    var $padding = 10;
    var $max_watermark_width = 120;
    var $embed_types;
    var $share_email_vars;
    //var $max_uploads = MAX_PHOTO_UPLOAD;  Max number of uploads at once
    var $search;

    private $basic_fields = [];
    private $extra_fields = [];

    public static function getInstance()
    {
        global $cbphoto;
        return $cbphoto;
    }

    /**
     * __Constructor of CBPhotos
     */
    function __construct()
    {
        global $cb_columns;

        $this->exts = ['jpg', 'png', 'gif', 'jpeg']; // This should be added from Admin Area. may be some people also want to allow BMPs;
        $this->embed_types = ["html", "forum", "email", "direct"];


        $basic_fields = $this->basic_fields_setup();

        $cb_columns->object('photos')->register_columns($basic_fields);

        if( config('enable_age_restriction') == 'yes' ){
            register_anchor_function('display_restricted', 'in_photo_thumb', Photo::class);
        }
        register_anchor_function('display_banner', 'in_photo_thumb', self::class);
    }

    /**
     * @throws Exception
     */
    public static function display_banner($vdo = [])
    {
        if ($vdo['active'] == 'no') {
            $text = lang('photo_is', strtolower(lang('inactive')) );
            $class = 'label-danger';
            echo '<div class="thumb_banner '.$class.'">' . $text . '</div>';
        }

        if (empty($vdo['collection_id'])) {
            $text = lang('photo_is', strtolower(lang('orphan')) );
            $class = 'label-warning';
            echo '<div class="thumb_banner '.$class.'">' . $text . '</div>';
        }
    }

    /**
     * @return array
     */
    function get_basic_fields()
    {
        return $this->basic_fields;
    }

    function set_basic_fields($fields = [])
    {
        return $this->basic_fields = $fields;
    }

    /**
     * @throws Exception
     */
    function basic_fields_setup()
    {
        # Set basic photo fields
        $basic_fields = [
            'photo_id', 'photo_key', 'userid', 'photo_title', 'photo_description',
            'photo_details', 'date_added', 'filename', 'ext', 'active', 'broadcast', 'file_directory', 'views',
            'last_commented', 'total_comments'
        ];

        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 305)) {
            $basic_fields[] = 'age_restriction';
        }

        return $this->set_basic_fields($basic_fields);
    }

    function get_extra_fields()
    {
        return $this->extra_fields;
    }

    function set_extra_fields($fields = [])
    {
        return $this->extra_fields = $fields;
    }

    function get_photo_fields($extra_fields = [])
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
        $fields = array_unique($fields);

        return $fields;
    }

    function get_fields($extra_fields = [])
    {
        return $this->get_photo_fields();
    }

    function add_field($field)
    {
        $extra_fields = $this->get_extra_fields();

        if (is_array($field)) {
            $extra_fields = array_merge($extra_fields, $field);
        } else {
            $extra_fields[] = $field;
        }

        return $this->set_extra_fields($extra_fields);
    }

    function add_photo_field($field)
    {
        return $this->add_field($field);
    }

    /**
     * Setting up Photos Section
     */
    function init_photos()
    {
        $this->init_actions();
        $this->init_collections();
        $this->photos_admin_menu();
        $this->setting_other_things();
        $this->set_photo_max_size();
    }

    /**
     * Initiating Actions for Photos
     */
    function init_actions()
    {
        $this->action = new cbactions();
        $this->action->init();     // Setting up reporting excuses
        $this->action->type = 'p';
        $this->action->name = 'photo';
        $this->action->obj_class = 'cbphoto';
        $this->action->check_func = 'photo_exists';
        $this->action->type_tbl = "photos";
        $this->action->type_id_field = 'photo_id';
    }

    /**
     * Setting Email Settings
     *
     * @param $data
     */
    function set_share_email($data)
    {
        $this->share_email_vars = [
            '{photo_title}'       => $data['photo_title'],
            '{photo_description}' => $data['photo_description'],
            '{photo_link}'        => $this->collection->collection_links($data, 'view_item'),
            '{photo_thumb}'       => $this->get_image_file($data['photo_id'], 'm')
        ];
        $this->action->share_template_name = 'photo_share_template';
        $this->action->val_array = $this->share_email_vars;
    }

    /**
     * Initiating Collections for Photos
     */
    function init_collections()
    {
        $this->collection = new Collections();
        $this->collection->objType = "p";
        $this->collection->objClass = "cbphoto";
        $this->collection->objTable = "photos";
        $this->collection->objName = "Photo";
        $this->collection->objFunction = "photo_exists";
        $this->collection->objFieldID = "photo_id";
    }

    /**
     * Create Admin Area menu for photos
     * @throws Exception
     */
    function photos_admin_menu()
    {
        $per = userquery::getInstance()->get_user_level(user_id());

        if ($per['photos_moderation'] == "yes" && isSectionEnabled('photos') && !NEED_UPDATE) {
            $menu_photo = [
                'title'   => 'Photos'
                , 'class' => 'glyphicon glyphicon-picture'
                , 'sub'   => [
                    [
                        'title' => lang('manage_x', strtolower(lang('photos')))
                        , 'url' => DirPath::getUrl('admin_area') . 'photo_manager.php'
                    ]
                    , [
                        'title' => 'Inactive Photos'
                        , 'url' => DirPath::getUrl('admin_area') . 'photo_manager.php?search=search&active=no'
                    ]
                    , [
                        'title' => 'Flagged Photos'
                        , 'url' => DirPath::getUrl('admin_area') . 'flagged_photos.php'
                    ]
                    , [
                        'title' => 'Orphan Photos'
                        , 'url' => DirPath::getUrl('admin_area') . 'orphan_photos.php'
                    ]
                    , [
                        'title' => lang('manage_x', strtolower(lang('categories')))
                        , 'url' => DirPath::getUrl('admin_area') . 'category.php?type=photo'
                    ]
                ]
            ];
            ClipBucket::getInstance()->addMenuAdmin($menu_photo, 90);
        }
    }

    /**
     * Setting other things
     * @throws Exception
     */
    function setting_other_things()
    {
        // Search type
        if (isSectionEnabled('photos')) {
            ClipBucket::getInstance()->search_types['photos'] = "cbphoto";
        }

        // My account links
        $accountLinks = [
            lang('manage_photos')          => "manage_photos.php",
            lang('manage_favorite_photos') => "manage_photos.php?mode=favorite",
        ];
        if (isSectionEnabled('photos')) {
            userquery::getInstance()->user_account[lang('photos')] = $accountLinks;
        }

        //Setting Cbucket links
        ClipBucket::getInstance()->links['photos'] = ['photos.php', 'photos/'];
        ClipBucket::getInstance()->links['manage_photos'] = ['manage_photos.php', 'manage_photos.php'];
        ClipBucket::getInstance()->links['edit_photo'] = ['edit_photo.php?photo=', 'edit_photo.php?photo='];
        ClipBucket::getInstance()->links['photo_upload'] = ['photo_upload.php', 'photo_upload'];
        ClipBucket::getInstance()->links['manage_favorite_photos'] = ['manage_photos.php?mode=favorite', 'manage_photos.php?mode=favorite'];
        ClipBucket::getInstance()->links['manage_orphan_photos'] = ['manage_photos.php?mode=orphan', 'manage_photos.php?mode=orphan'];
        ClipBucket::getInstance()->links['user_photos'] = ['user_photos.php?mode=uploaded&amp;user=', 'user_photos.php?mode=uploaded&amp;user='];
        ClipBucket::getInstance()->links['user_fav_photos'] = ['user_photos.php?mode=favorite&amp;user=', 'user_photos.php?mode=favorite&amp;user='];
    }

    /**
     * Set File Max Size
     */
    function set_photo_max_size()
    {
        $adminSize = ClipBucket::getInstance()->configs['max_photo_size'];
        if (!$adminSize) {
            $this->max_file_size = 2 * 1024 * 1024;
        } else {
            $this->max_file_size = $adminSize * 1024 * 1024;
        }
    }

    /**
     * Check if photo exists or not
     *
     * @param $id
     *
     * @return bool
     * @throws Exception
     */
    function photo_exists($id): bool
    {
        if (is_numeric($id)) {
            $result = Clipbucket_db::getInstance()->select(tbl($this->p_tbl), 'photo_id', ' photo_id = \'' . $id . '\'');
        } else {
            $result = Clipbucket_db::getInstance()->select(tbl($this->p_tbl), 'photo_id', ' photo_key = \'' . $id . '\'');
        }

        if ($result) {
            return true;
        }
        return false;
    }

    /**
     * Get Photo
     *
     * @param $pid
     *
     * @return bool|array
     * @throws Exception
     */
    function get_photo($pid)
    {
        if (is_numeric($pid)) {
            $field = 'photo_id';
        } else {
            $field = 'photo_key';
        }

        $select_tag = '';
        $join_tag = '';
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $select_tag = ', GROUP_CONCAT( DISTINCT(T.name) SEPARATOR \',\') as photo_tags';
            $join_tag = 'LEFT JOIN ' . tbl('photo_tags') . ' AS PT ON P.photo_id = PT.id_photo  
                    LEFT JOIN ' . tbl('tags') . ' AS T ON PT.id_tag = T.id_tag';
        }

        $query = 'SELECT P.* '. $select_tag.'  
                    FROM ' . tbl($this->p_tbl) . ' AS P 
                   '.$join_tag.'
                    WHERE P.' . $field . ' = \'' . mysql_clean($pid) . '\'
                    GROUP BY P.photo_id';

        $result = Clipbucket_db::getInstance()->_select($query);
        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    /**
     * Get Photos
     *
     * @param $p
     *
     * @return bool|mixed
     * @throws Exception
     */
    function get_photos($p)
    {
        $order = $p['order'];
        $limit = $p['limit'];
        $cond = '';

        if (!has_access('admin_access', true)) {
            $cond .= Photo::getInstance()->getGenericConstraints();
        } else {
            if ($p['active']) {
                $cond .= 'photos.active = \'' . mysql_clean($p['active']) . '\'';
            }

            if ($p['broadcast']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= 'photos.broadcast = \'' . mysql_clean($p['broadcast']) . '\'';
            }
        }

        if ($p['pid']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= $this->constructMultipleQuery(['ids' => $p['pid'], 'sign' => '=', 'operator' => 'OR']);
        }

        if ($p['key']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'photos.photo_key = \'' . mysql_clean($p['key']) . '\'';
        }

        if ($p['filename']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'photos.filename = \'' . mysql_clean($p['filename']) . '\'';
        }

        if ($p['extension']) {
            foreach ($this->exts as $ext) {
                if (in_array($ext, $this->exts)) {
                    if ($cond != '') {
                        $cond .= ' AND ';
                    }
                    $cond .= 'photos.ext = \'' . mysql_clean($p['extension']) . '\'';
                }
            }
        }

        if ($p['date_span']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= Search::date_margin('photos.date_added', $p['date_span']);
        }

        if ($p['featured']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'photos.featured = \'' . mysql_clean($p['featured']) . '\'';
        }

        if ($p['user']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= $this->constructMultipleQuery(['ids' => $p['user'], 'sign' => '=', 'operator' => 'AND', 'column' => 'userid']);
        }

        if ($p['exclude']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= $this->constructMultipleQuery(['ids' => $p['exclude'], 'sign' => '<>']);
        }

        $title_tag = '';
        if ($p['title']) {
            $title_tag = 'photos.photo_title LIKE \'%' . mysql_clean($p['title']) . '%\'';
        }

        if (!empty($p['tags'])) {
            $tags = explode(',', $p['tags']);
            if ($title_tag != '') {
                $title_tag .= ' OR ';
            }
            $title_tag .= ' T.name IN (\'' . mysql_clean($p['tags']) . '\')';
        }

        if ($title_tag != '') {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= " ($title_tag) ";
        }

        if ($p['ex_user']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= $this->constructMultipleQuery(['ids' => $p['ex_user'], 'sign' => '<>', 'operator' => 'AND', 'column' => 'userid']);
        }

        if ($p['extra_cond']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= $p['extra_cond'];
        }

        if ($p['get_orphans'] || has_access('admin_access', true) || user_id() == ($p['user'] ?? 0)) {
            $p['collection'] = '0';
        }


        if (!isset($p['collection']) && !$p['get_orphans']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'collections.collection_id IS NOT NULL';
        }

        $fields = [
            'photos'      => get_photo_fields(),
            'users'       => get_user_fields(),
            'collections' => ['collection_name','collection_id', 'type', 'date_added']
        ];

        $select_complement = '';
        $join_tag = '';
        $group_tag = '';
        $match_tag='';
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $match_tag = 'T.name';
            $select_complement = ', GROUP_CONCAT( DISTINCT(T.name) SEPARATOR \',\') as photo_tags';
            $join_tag = ' LEFT JOIN ' . tbl('photo_tags') . ' AS PT ON photos.photo_id = PT.id_photo 
                    LEFT JOIN ' . tbl('tags') . ' AS T ON PT.id_tag = T.id_tag';
            $group_tag = ' GROUP BY photos.photo_id';
        }

        $select = table_fields($fields);

        $main_query = 'SELECT ' . $select . ' ' . $select_complement;
        $main_query .= ' FROM '.cb_sql_table('photos');

        $join_collection = ' LEFT JOIN ' . cb_sql_table('collection_items') . ' ON collection_items.object_id = photos.photo_id AND collection_items.type = \'photos\'
         LEFT JOIN ' . cb_sql_table('collections') . ' ON collection_items.collection_id = collections.collection_id';

        $join_collection .= ' LEFT JOIN ' . cb_sql_table('users') . ' ON photos.userid = users.userid';
        $main_query .= $join_tag;
        $main_query .= $join_collection;
        $order = $order ? ' ORDER BY ' . $order : false;
        $limit = $limit ? ' LIMIT ' . $limit : false;

        if (!$p['count_only'] && !$p['show_related']) {
            $query = $main_query;
            if ($cond) {
                $query .= ' WHERE ' . $cond;
            }

            $query .= $group_tag;
            $query .= $order;
            $query .= $limit;

            $result = select($query);
        }

        if ($p['show_related']) {
            $query = $main_query;

            if ($cond != '') {
                $cond .= ' AND ';
            }

            $cond .= '(MATCH(photos.photo_title) AGAINST (\'' . mysql_clean($p['title']) . '\' IN NATURAL LANGUAGE MODE) ';
            if( $match_tag != ''){
                $cond .= 'OR MATCH('.$match_tag.') AGAINST (\'' . mysql_clean($p['title']) . '\' IN NATURAL LANGUAGE MODE)';
            }
            $cond .= ')';

            if ($p['exclude']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= $this->constructMultipleQuery(['ids' => $p['exclude'], 'sign' => '<>']);
            }

            if ($p['collection']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= $this->constructMultipleQuery(['ids' => $p['collection'], 'sign' => '<>', 'column' => 'collection_id']);
                $cond .= '( collections.collection_id IN ('. is_array($p['collection']) ? implode(',', $p['collection']) : $p['collection'].'))';
            }

            if ($p['extra_cond']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= mysql_clean($p['extra_cond']);
            }

            $where = ' WHERE ' . $cond . ' AND collections.collection_id IS NOT NULL';

            $query .= $where;
            $query .= $group_tag;
            $query .= $order;
            $query .= $limit;

            $result = select($query);

            // We found nothing from TITLE of Photos, let's try TAGS
            if (count($result) == 0) {
                $query = $main_query;

                $tags = str_replace('+', '', $p['tags']);

                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= '(MATCH(photos.photo_title) AGAINST (\'' . mysql_clean($tags) . '\' IN NATURAL LANGUAGE MODE) ';
                if( $match_tag != ''){
                    $cond .= 'OR MATCH('.$match_tag.') AGAINST (\'' . mysql_clean($tags) . '\' IN NATURAL LANGUAGE MODE)';
                }
                $cond .= ')';

                if ($p['exclude']) {
                    if ($cond != '') {
                        $cond .= ' AND ';
                    }
                    $cond .= $this->constructMultipleQuery(['ids' => $p['exclude'], 'sign' => '<>']);
                }

                if ($p['collection']) {
                    if ($cond != '') {
                        $cond .= ' AND ';
                    }
                    $cond .= $this->constructMultipleQuery(['ids' => $p['collection'], 'sign' => '<>', 'column' => 'collection_id']);
                    $cond .= '( collections.collection_id IN ('. is_array($p['collection']) ? implode(',', $p['collection']) : $p['collection'].'))';
                }

                if ($p['extra_cond']) {
                    if ($cond != '') {
                        $cond .= ' AND ';
                    }
                    $cond .= $p['extra_cond'];
                }

                $where = ' WHERE ' . $cond . ' AND photos.collection_id <> 0';
                $query .= $where;
                $query .= $group_tag;
                $query .= $order;
                $query .= $limit;

                $result = select($query);
            }
        }

        if ($p['count_only']) {
            if ($p['extra_cond']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= $p['extra_cond'];
            }

            //don't remove alias T at the end, request will crash
            $query_count = 'SELECT COUNT(*) AS total FROM (SELECT photos.photo_id FROM ' . cb_sql_table('photos') . $join_tag . $join_collection  ;
            if ($cond) {
                $query_count .= ' WHERE ' . $cond;
            }
            $query_count .= $group_tag . ') T';
            $count = Clipbucket_db::getInstance()->_select($query_count);
            if (!empty($count)) {
                $result = $count[0]['total'];
            } else {
                $result = 0;
            }
        }

        if ($p['assign']) {
            assign($p['assign'], $result);
        } else {
            return $result;
        }
    }

    /**
     * Used to construct Multi Query
     * Only IDs will be excepted
     *
     * @param $params
     *
     * @return string
     */
    function constructMultipleQuery($params): string
    {
        $cond = '';
        $IDs = $params['ids'];
        if (!is_array($IDs)) {
            $IDs = explode(',', $IDs);
        }

        $count = 0;
        $cond .= '( ';
        foreach ($IDs as $id) {
            $id = str_replace(" ", "", $id);
            if (is_numeric($id) || $params['column'] == 'collection_id') {
                if ($count > 0) {
                    $cond .= ' ' . ($params['operator'] ? $params['operator'] : 'AND') . ' ';
                }
                $cond .= ('photos.' . ($params['column'] ? $params['column'] : 'photo_id')) . ' ' . ($params['sign'] ? $params['sign'] : '=') . " '" . $id . "'";
                $count++;
            }
        }
        $cond .= ' )';

        return $cond;
    }

    /**
     * Used to generate photo key
     * Replica of video_keygen function
     */
    function photo_key()
    {
        $char_list = 'ABDGHKMNORSUXWY';
        $char_list .= '123456789';
        // Todo : remove possible infinite loop
        while (1) {
            $photo_key = '';
            srand((double)microtime() * 1000000);
            for ($i = 0; $i < 12; $i++) {
                $photo_key .= substr($char_list, (rand() % (strlen($char_list))), 1);
            }

            if (!$this->pkey_exists($photo_key)) {
                break;
            }
        }

        return $photo_key;
    }

    /**
     * Used to check if key exists
     *
     * @param $key
     *
     * @return bool
     * @throws Exception
     */
    function pkey_exists($key): bool
    {
        $result = Clipbucket_db::getInstance()->select(tbl('photos'), 'photo_key', " photo_key = '$key'");
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Used to delete photo
     *
     * @param      $id
     * @param bool $orphan
     * @throws Exception
     */
    function delete_photo($id, $orphan = false)
    {
        if ($this->photo_exists($id)) {
            $photo = $this->get_photo($id);

            $del_photo_funcs = cb_get_functions('delete_photo');
            if (is_array($del_photo_funcs)) {
                foreach ($del_photo_funcs as $func) {
                    if (function_exists($func['func'])) {
                        $func['func']($photo);
                    }
                }
            }

            if (!$orphan && !empty($photo['collection_id'])) {//removing from collection
                $this->collection->remove_item($photo['photo_id'], $photo['collection_id']);
            }

            //Remove tags
            Tags::deleteTags('photo', $photo['photo_id']);

            //now removing photo files
            $this->delete_photo_files($photo);


            //Decrementing User Photos
            Clipbucket_db::getInstance()->update(tbl('users'), ['total_photos'], ['|f|total_photos-1'], " userid='" . $photo['userid'] . "'");

            //Removing Photo Comments
            $params = [];
            $params['type'] = 'p';
            $params['type_id'] = $photo['photo_id'];
            Comments::delete($params);

            //Removing Photo From Favorites
            Clipbucket_db::getInstance()->delete(tbl('favorites'), ['type', 'id'], ['p', $photo['photo_id']]);
            errorhandler::getInstance()->flush_msg();
            //finally removing from Database
            $this->delete_from_db($photo);
        } else {
            e(lang('photo_not_exist'));
        }
    }

    /**
     * Used to delete photo files
     *
     * @param $id
     * @throws Exception
     */
    function delete_photo_files($id)
    {
        if (!is_array($id)) {
            $photo = $this->get_photo($id);
        } else {
            $photo = $id;
        }

        $files = get_image_file(['details' => $photo, 'size' => 't', 'multi' => true, 'with_orig' => true, 'with_path' => false]);
        if (!empty($files)) {
            foreach ($files as $file) {
                $file_dir = DirPath::get('photos') . $file;
                if (file_exists($file_dir)) {
                    unlink($file_dir);
                }
            }

            e(lang('success_delete_file', display_clean($photo['photo_title'])), 'm');
        }
    }

    /**
     * Used to delete photo from database
     *
     * @param $id
     * @throws Exception
     */
    function delete_from_db($id)
    {
        if (is_array($id)) {
            $delete_id = $id['photo_id'];
        } else {
            $delete_id = $id;
        }

        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('photos') . " WHERE photo_id = $delete_id");
        e(lang("photo_success_deleted"), "m");
    }

    /**
     * Used to get photo owner
     *
     * @param $id
     *
     * @return bool|mixed
     * @throws Exception
     */
    function get_photo_owner($id)
    {
        return $this->get_photo_field($id, 'userid');
    }

    /**
     * Used to get photo any field
     *
     * @param $id
     * @param $field
     *
     * @return bool|mixed
     * @throws Exception
     */
    function get_photo_field($id, $field)
    {
        if (!$field) {
            return false;
        }

        if (!is_numeric($id)) {
            $result = Clipbucket_db::getInstance()->select(tbl($this->p_tbl), $field, ' photo_key = ' . $id . '');
        } else {
            $result = Clipbucket_db::getInstance()->select(tbl($this->p_tbl), $field, ' photo_id = ' . $id . '');
        }

        if ($result) {
            return $result[0][$field];
        }
        return false;
    }

    /**
     * Used to crop the image
     * Image will be crop to dead-center
     *
     * @param $input
     * @param $output
     * @param $ext
     * @param $width
     * @param $height
     *
     * @return bool|void
     */
    function crop_image($input, $output, $ext, $width, $height)
    {
        $info = getimagesize($input);
        $Swidth = $info[0];
        $Sheight = $info[1];

        $canvas = imagecreatetruecolor($width, $height);
        $left_padding = $Swidth / 2 - $width / 2;
        $top_padding = $Sheight / 2 - $height / 2;

        switch ($ext) {
            case 'jpeg':
            case 'jpg':
            case 'JPG':
            case 'JPEG':
                $image = imagecreatefromjpeg($input);
                imagecopy($canvas, $image, 0, 0, $left_padding, $top_padding, $width, $height);
                imagejpeg($canvas, $output, 90);
                break;

            case 'png':
            case 'PNG':
                $image = imagecreatefrompng($input);
                imagecopy($canvas, $image, 0, 0, $left_padding, $top_padding, $width, $height);
                imagepng($canvas, $output, 9);
                break;

            case 'gif':
            case 'GIF':
                $image = imagecreatefromgif($input);
                imagecopy($canvas, $image, 0, 0, $left_padding, $top_padding, $width, $height);
                imagejpeg($canvas, $output, 90);
                break;

            default:
                return false;
        }
        imagedestroy($image);
        imagedestroy($canvas);
    }

    /**
     * Used to resize and watermark image
     *
     * @param $array
     * @throws Exception
     */
    function generate_photos($array)
    {
        $path = DirPath::get('photos');

        if (!is_array($array)) {
            $p = $this->get_photo($array);
        } else {
            $p = $array;
        }

        $path .= get_photo_date_folder($p) . DIRECTORY_SEPARATOR;

        $filename = $p['filename'];
        $extension = $p['ext'];

        $this->createThumb($path . $filename . '.' . $extension, $path . $filename . '_o.' . $extension, $extension);
        $this->createThumb($path . $filename . '.' . $extension, $path . $filename . '_t.' . $extension, $extension, $this->thumb_width, $this->thumb_height);

        if (empty(errorhandler::getInstance()->get_error())) {
            $this->createThumb($path . $filename . '.' . $extension, $path . $filename . '_m.' . $extension, $extension, $this->mid_width, $this->mid_height);
            $this->createThumb($path . $filename . '.' . $extension, $path . $filename . '_l.' . $extension, $extension, $this->lar_width);

            $should_watermark = config('watermark_photo');

            if (!empty($should_watermark) && $should_watermark == 1) {
                $this->watermark_image($path . $filename . '_l.' . $extension, $path . $filename . '_l.' . $extension);
                $this->watermark_image($path . $filename . '_o.' . $extension, $path . $filename . '_o.' . $extension);
            }
        }

        /* GETTING DETAILS OF IMAGES AND STORING THEM IN DB */
        $this->update_image_details($p);
    }

    /**
     * This function is used to get photo files and extract
     * dimensions and file size of each file, put them in array
     * then encode in json and finally update photo details column
     *
     * @param $photo
     * @throws Exception
     */
    function update_image_details($photo)
    {
        if (is_array($photo) && !empty($photo['photo_id'])) {
            $p = $photo;
        } else {
            $p = $this->get_photo($photo);
        }

        if (!empty($photo)) {
            $images = get_image_file(['details' => $photo, 'size' => 't', 'multi' => true, 'with_path' => false]);

            if ($images) {
                foreach ($images as $image) {
                    $imageFile = DirPath::get('photos') . $image;

                    if (file_exists($imageFile)) {
                        $imageDetails = getimagesize($imageFile);
                        $imageSize = filesize($imageFile);
                        $data[$this->get_image_type($image)] = [
                            'width'     => $imageDetails[0],
                            'height'    => $imageDetails[1],
                            'attribute' => mysql_clean($imageDetails[3]),
                            'size'      => [
                                'bytes'     => round($imageSize),
                                'kilobytes' => round($imageSize / 1024),
                                'megabytes' => round($imageSize / 1024 / 1024, 2)
                            ]
                        ];
                    }
                }

                if (is_array($data) && !empty($data)) {
                    $encodedData = stripslashes(json_encode($data));
                    Clipbucket_db::getInstance()->update(tbl('photos'), ['photo_details'], ["|no_mc|$encodedData"], " photo_id = '" . $p['photo_id'] . "' ");
                }
            }
        }
    }

    /**
     * Creating resized photo
     *
     * @param      $from
     * @param      $to
     * @param      $ext
     * @param null $d_width
     * @param null $d_height
     * @param bool $force_copy
     * @throws Exception
     */
    function createThumb($from, $to, $ext, $d_width = null, $d_height = null, $force_copy = false)
    {
        $file = $from;
        $info = getimagesize($file);
        $org_width = $info[0];
        $org_height = $info[1];

        if ($org_width > $d_width && !empty($d_width)) {

            if( stristr(PHP_OS, 'WIN') ) {
                // On Windows hosts, imagecreatefromX functions consumes lots of RAM
                $memory_needed = Image::getMemoryNeededForImage($from);
                $memory_limit = ini_get('memory_limit');
                if ($memory_needed > getBytesFromFileSize($memory_limit)) {
                    $msg = 'Photo generation would requiere ~' . System::get_readable_filesize($memory_needed, 0) . ' of memory, but it\'s currently limited to ' . $memory_limit;
                    if (in_dev()) {
                        e($msg);
                    } else {
                        e(lang('technical_error'));
                    }
                    DiscordLog::sendDump($msg);
                    return;
                }
            }

            $ratio = $org_width / $d_width; // We will resize it according to Width

            $width = $org_width / $ratio;
            $height = $org_height / $ratio;

            $image_r = imagecreatetruecolor($width, $height);

            if (!empty($d_height) && $height > $d_height && $this->cropping == 1) {
                $crop_image = true;
            }

            switch ($ext) {
                case 'jpeg':
                case 'jpg':
                case 'JPG':
                case 'JPEG':
                    $image = imagecreatefromjpeg($file);
                    imagecopyresampled($image_r, $image, 0, 0, 0, 0, $width, $height, $org_width, $org_height);
                    imagejpeg($image_r, $to, 90);
                    if (!empty($crop_image)) {
                        $this->crop_image($to, $to, $ext, $width, $d_height);
                    }
                    break;

                case 'png':
                case 'PNG':
                    $image = imagecreatefrompng($file);
                    imagecopyresampled($image_r, $image, 0, 0, 0, 0, $width, $height, $org_width, $org_height);
                    imagepng($image_r, $to, 9);
                    if (!empty($crop_image)) {
                        $this->crop_image($to, $to, $ext, $width, $d_height);
                    }
                    break;

                case 'gif':
                case 'GIF':
                    $image = imagecreatefromgif($file);
                    imagecopyresampled($image_r, $image, 0, 0, 0, 0, $width, $height, $org_width, $org_height);
                    imagegif($image_r, $to, 90);
                    if (!empty($crop_image)) {
                        $this->crop_image($to, $to, $ext, $width, $d_height);
                    }
                    break;
            }
            imagedestroy($image_r);
            imagedestroy($image);
        } else {
            if (!file_exists($to) || $force_copy === true) {
                if (!is_dir($from)) {
                    copy($from, $to);
                }
            }
        }
    }

    /**
     * Used to get watermark file
     */
    function watermark_file()
    {
        if (file_exists(DirPath::get('images') . 'photo_watermark.png')) {
            return DirPath::getUrl('images') . 'photo_watermark.png';
        }
        return false;
    }

    /**
     * Fetches watermark default position from database
     * @return : { position of watermark }
     */
    function get_watermark_position()
    {
        return ClipBucket::getInstance()->configs['watermark_placement'];
    }

    /**
     * Used to set watermark position
     *
     * @param $file
     * @param $watermark
     *
     * @return array
     */
    function position_watermark($file, $watermark): array
    {
        $watermark_pos = $this->get_watermark_position();
        if (empty($watermark_pos)) {
            $info = ['right', 'top'];
        } else {
            $info = explode(":", $watermark_pos);
        }

        $x = $info[0];
        $y = $info[1];
        [$w, $h] = getimagesize($file);
        [$ww, $wh] = getimagesize($watermark);
        $padding = $this->padding;

        switch ($x) {
            case 'center':
                $finalxPadding = $w / 2 - $ww / 2;
                break;

            case 'left':
            default:
                $finalxPadding = $padding;
                break;

            case 'right':
                $finalxPadding = $w - $ww - $padding;
                break;
        }

        switch ($y) {
            case 'top':
            default:
                $finalyPadding = $padding;
                break;

            case 'center':
                $finalyPadding = $h / 2 - $wh / 2;
                break;

            case 'bottom':
                $finalyPadding = $h - $wh - $padding;
                break;
        }

        return [$finalxPadding, $finalyPadding];
    }

    /**
     * Used to watermark image
     *
     * @param $input
     * @param $output
     *
     * @return bool|void
     */
    function watermark_image($input, $output)
    {
        $watermark_file = $this->watermark_file();
        if (!$watermark_file) {
            return false;
        }

        [$Swidth, $Sheight, $Stype] = getimagesize($input);
        $wImage = imagecreatefrompng($watermark_file);
        $ww = imagesx($wImage);
        $wh = imagesy($wImage);
        $paddings = $this->position_watermark($input, $watermark_file);

        switch ($Stype) {
            case 1: //GIF
                $sImage = imagecreatefromgif($input);
                imagecopy($sImage, $wImage, $paddings[0], $paddings[1], 0, 0, $ww, $wh);
                imagejpeg($sImage, $output, 90);
                break;

            case 2: //JPEG
                $sImage = imagecreatefromjpeg($input);
                imagecopy($sImage, $wImage, $paddings[0], $paddings[1], 0, 0, $ww, $wh);
                imagejpeg($sImage, $output, 90);
                break;

            case 3: //PNG
                $sImage = imagecreatefrompng($input);
                imagecopy($sImage, $wImage, $paddings[0], $paddings[1], 0, 0, $ww, $wh);
                imagepng($sImage, $input, 9);
                break;
        }
    }

    /**
     * Load Required Form
     *
     * @param null $array
     *
     * @return array
     * @throws Exception
     */
    function load_required_forms($array = null): array
    {
        if ($array == null) {
            $array = $_POST;
        }

        $title = $array['photo_title'];
        $description = $array['photo_description'];
        $tags = $array['photo_tags'];

        if ($array['user']) {
            $p['user'] = $array['user'];
        } else {
            $p['user'] = user_id();
        }

        $collections = $this->collection->get_collections_list(0,null,null, 'photos',user_id()) ?? [];
        $cl_array = $this->parse_array($collections);
        $collection = $array['collection_id'];
        if ($collection == null && !empty($cl_array)) {
            $cl_array = [0=>''] + $cl_array;
        }
        $this->unique = rand(0, 9999);
        return [
            'name'       => [
                'title'       => lang('photo_title'),
                'name'        => 'photo_title',
                'type'        => 'textfield',
                'value'       => display_clean($title),
                'db_field'    => 'photo_title',
                'required'    => 'yes',
                'invalid_err' => lang('photo_title_err')
            ],
            'desc'       => [
                'title'         => lang('photo_caption'),
                'name'          => 'photo_description',
                'type'          => 'textarea',
                'value'         => display_clean($description),
                'db_field'      => 'photo_description',
                'anchor_before' => 'before_desc_compose_box',
                'required'      => 'yes',
                'invalid_err'   => lang('photo_caption_err')
            ],
            'tags' => [
                'title'             => lang('photo_tags'),
                'name'              => 'photo_tags',
                'type'              => 'hidden',
                'id'                => 'tags',
                'value'             => genTags($tags),
                'required'          => 'no',
                'validate_function' => 'genTags'
            ],
            'collection' => [
                'title'       => lang('collection'),
                'name'        => 'collection_id',
                'type'        => 'dropdown',
                'value'       => $cl_array,
                'checked'     => $collection,
                'invalid_err' => lang('collection_not_found')
            ]
        ];
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function insert_photo($array = null)
    {
        if ($array == null) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        $this->validate_form_fields($array);
        if (!error()) {
            $forms = $this->load_required_forms($array);
            $oForms = $this->load_other_forms($array);
            $FullForms = array_merge($forms, $oForms);
            if (!isset($array['allow_comments'])) {
                $array['allow_comments'] = 'yes';
            }
            if (!isset($array['allow_embedding'])) {
                $array['allow_embedding'] = 'yes';
            }
            if (!isset($array['allow_rating'])) {
                $array['allow_rating'] = 'yes';
            }
            if (!isset($array['age_restriction'])) {
                $array['age_restriction'] = 'null';
            }

            foreach ($FullForms as $field) {
                $name = formObj::rmBrackets($field['name']);
                $val = $array[$name];

                if ($field['use_func_val']) {
                    $val = $field['validate_function']($val);
                }

                if (!empty($field['db_field'])) {
                    $query_field[] = $field['db_field'];
                }

                if (is_array($val)) {
                    $new_val = '';
                    foreach ($val as $v) {
                        $new_val .= '#' . $v . '# ';
                    }
                    $val = $new_val;
                }

                if (!$field['clean_func'] || (!function_exists($field['clean_func']) && !is_array($field['clean_func']))) {
                    $val = ($val);
                } else {
                    $val = apply_func($field['clean_func'], mysql_clean('|no_mc|' . $val));
                }

                if (!empty($field['db_field'])) {
                    $query_val[] = $val;
                }
            }

            $query_field[] = 'userid';
            if (!$array['userid']) {
                $userid = user_id();
                $query_val[] = $userid;
            } else {
                $query_val[] = $array['userid'];
                $userid = $array['userid'];
            }

            $query_field[] = 'date_added';
            $query_val[] = NOW();

            $query_field[] = 'owner_ip';
            $query_val[] = Network::get_remote_ip();

            $query_field[] = 'ext';
            $query_val[] = $array['ext'];

            $query_field[] = 'photo_key';
            $query_val[] = $this->photo_key();

            $query_field[] = 'filename';
            $query_val[] = $array['filename'];

            $query_field[] = 'active';
            $query_val[] = $array['active'];

            if ($array['server_url'] && $array['server_url'] != 'undefined') {
                $query_field[] = 'server_url';
                $query_val[] = $array['server_url'];
            }

            if ($array['folder'] && $array['folder'] != 'undefined') {
                $query_field[] = 'file_directory';
                $query_val[] = $array['folder'];
            }
            $query_val['0'] = $array['title'];
            if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', 128)) {
                $query_field[] = 'collection_id';
                $query_val[] = 0;
            }

            $insert_id = Clipbucket_db::getInstance()->insert(tbl($this->p_tbl), $query_field, $query_val);

            $photo = $this->get_photo($insert_id);
            Collection::getInstance()->addCollectionItem($insert_id, $array['collection_id'], 'photos');

            if (!$array['server_url'] || $array['server_url'] == 'undefined') {
                $this->generate_photos($photo);
            }

            if (empty(errorhandler::getInstance()->get_error())) {
                e(lang('photo_is_saved_now', display_clean($photo['photo_title'])), 'm');
            }

            Clipbucket_db::getInstance()->update(tbl('users'), ['total_photos'], ['|f|total_photos+1'], " userid='" . $userid . "'");

            //Adding Photo Feed
            addFeed(['action' => 'upload_photo', 'object_id' => $insert_id, 'object' => 'photo']);
            return $insert_id;
        }
    }

    /**
     * Update watermark file
     *
     * @param $file
     * @throws Exception
     */
    function update_watermark($file)
    {
        if (empty($file)) {
            e(lang('no_watermark_found'));
        } else {
            $oldW = DirPath::get('images') . 'photo_watermark.png';
            if (file_exists($oldW)) {
                unset($oldW);
            }

            $info = getimagesize($file['tmp_name']);
            $width = $info[0];
            $type = $info[2];

            if ($type == 3) {
                if (move_uploaded_file($file['tmp_name'], DirPath::get('images') . 'photo_watermark.png')) {
                    $wFile = DirPath::get('images') . 'photo_watermark.png';
                    if ($width > $this->max_watermark_width) {
                        $this->createThumb($wFile, $wFile, 'png', $this->max_watermark_width);
                    }
                }
                e(lang('watermark_updated'), 'm');
            } else {
                e(lang('upload_png_watermark'));
            }
        }
    }

    /**
     * Load Other Form
     *
     * @param null $array
     *
     * @return array
     * @throws Exception
     */
    function load_other_forms($array = null): array
    {
        if ($array == null) {
            $array = $_POST;
        }

        $return = [];

        if( config('enable_comments_photo') == 'yes' ){
            $return['comments'] = [
                'title'             => lang('comments'),
                'name'              => 'allow_comments',
                'db_field'          => 'allow_comments',
                'type'              => 'radiobutton',
                'value'             => ['yes' => lang('vdo_allow_comm'), 'no' => lang('vdo_dallow_comm')],
                'required'          => 'no',
                'checked'           => config('enable_comments_photo') == 'yes' ? $array['allow_comments'] : 'no',
                'validate_function' => 'yes_or_no',
                'display_function'  => 'display_sharing_opt',
                'default_value'     => 'yes',
                'extra_tags'        => config('enable_comments_photo') == 'yes' ? '' : 'disabled="disabled" ',
            ];
        }

        $return ['embedding'] = [
            'title'             => lang('vdo_embedding'),
            'type'              => 'radiobutton',
            'name'              => 'allow_embedding',
            'db_field'          => 'allow_embedding',
            'value'             => ['yes' => lang('pic_allow_embed'), 'no' => lang('pic_dallow_embed')],
            'checked'           => $array['allow_embedding'],
            'validate_function' => 'yes_or_no',
            'display_function'  => 'display_sharing_opt',
            'default_value'     => 'yes'
        ];

        $return ['rating'] = [
            'title'             => lang('rating'),
            'name'              => 'allow_rating',
            'type'              => 'radiobutton',
            'db_field'          => 'allow_rating',
            'value'             => ['yes' => lang('pic_allow_rating'), 'no' => lang('pic_dallow_rating')],
            'checked'           => $array['allow_rating'],
            'validate_function' => 'yes_or_no',
            'display_function'  => 'display_sharing_opt',
            'default_value'     => 'yes'
        ];

        if( config('enable_age_restriction') == 'yes' ) {
            $age_restriction = $array['age_restriction'];
            $return['age_restriction'] = [
                'title'             => lang('age_restriction'),
                'type'              => 'textfield',
                'name'              => 'age_restriction',
                'id'                => 'age_restriction',
                'value'             =>  $age_restriction ?? '',
                'db_field'          => 'age_restriction',
                'required'          => 'no',
                'hint_2'            => lang('info_age_restriction'),
                'validate_function' => 'ageRestriction',
                'use_func_val'      => true,
                'class'             => 'form-control'
            ];
        }

        return $return;
    }

    /**
     * This will return a formatted array
     * return @Array
     * Array Format: Multidemsional
     * Array ( [photo_id] => array( ['field_name'] => 'value' ) )
     *
     * @param $arr
     *
     * @return mixed
     */
    function return_formatted_post($arr)
    {
        $photoID = '';
        foreach ($_POST as $key => $value) {
            $parts = explode('_', $key);
            $total = count($parts);
            $id = $parts[$total - 1];
            $name = array_splice($parts, 0, $total - 1);
            $name = implode("_", $name);

            if ($photoID != $id) {
                $values = [];
                $photoID = $id;
            }

            if (is_numeric($id)) {
                if (strpos($key, $id) !== false) {
                    $values[$name] = $value;
                    $PhotosArray[$id] = $values;
                }
            }
        }

        return $PhotosArray;
    }

    /**
     * Used to parse collections dropdown
     *
     * @param $array
     *
     * @return array
     */
    function parse_array($array):array
    {
        $cl_arr= [];
        if (is_array($array)) {
            foreach ($array as $key => $v) {
                $cl_arr[$key] = $v['name'];
            }
        }
        return $cl_arr;
    }

    /**
     * Used to create filename of photo
     */
    function create_filename(): string
    {
        return time() . RandomString(6);
    }

    /**
     * Construct extensions for SWF
     */
    function extensions(): string
    {
        $exts = $this->exts;
        $list = '';
        foreach ($exts as $ext) {
            $list .= "*." . $ext . ";";
        }
        return $list;

    }

    /**
     * Function used to validate form fields
     *
     * @param null $array
     * @throws \PHPMailer\PHPMailer\Exception|Exception
     */
    function validate_form_fields($array = null)
    {
        $reqFileds = $this->load_required_forms($array);

        if ($array == null) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        $otherFields = $this->load_other_forms($array);
        $photo_fields = array_merge($reqFileds, $otherFields);
        validate_cb_form($photo_fields, $array);
    }

    /**
     * Update Photo
     *
     * @param null $array
     * @throws Exception
     */
    function update_photo($array = null)
    {
        if ($array == null) {
            $array = $_POST;
        }
        $this->validate_form_fields($array);
        $pid = $array['photo_id'];
        $cid = Photo::getInstance()->getOne(['photo_id'=>$pid])['collection_id'];

        if (!error()) {
            $reqFields = $this->load_required_forms($array);
            $otherFields = $this->load_other_forms($array);

            $fields = array_merge($reqFields, $otherFields);
            foreach ($fields as $field) {
                $name = formObj::rmBrackets($field['name']);
                $val = $array[$name];

                if ($field['use_func_val']) {
                    $val = $field['validate_function']($val);
                }


                if (!empty($field['db_field'])) {
                    $query_field[] = $field['db_field'];
                }

                if (is_array($val)) {
                    $new_val = '';
                    foreach ($val as $v) {
                        $new_val .= "#" . $v . "# ";
                    }
                    $val = $new_val;
                }

                if (!$field['clean_func'] || (!function_exists($field['clean_func']) && !is_array($field['clean_func']))) {
                    $val = ($val);
                } else {
                    $val = apply_func($field['clean_func'], mysql_clean('|no_mc|' . $val));
                }

                if (!empty($field['db_field'])) {
                    $query_val[] = $val;
                }
            }

            if (has_access('admin_access', true)) {
                if (isset($array['views'])) {
                    $query_field[] = 'views';
                    $query_val[] = $array['views'];
                }

                if (isset($array['total_comments'])) {
                    $query_field[] = "total_comments";
                    $query_val[] = $array['total_comments'];
                }

                if (isset($array['total_favorites'])) {
                    $query_field[] = "total_favorites";
                    $query_val[] = $array['total_favorites'];
                }

                if (isset($array['downloaded'])) {
                    $query_field[] = "downloaded";
                    $query_val[] = $array['downloaded'];
                }

                if (isset($array['voters'])) {
                    $query_field[] = "voters";
                    $query_val[] = $array['voters'];
                }
            }

            if (!error()) {
                if (!user_id()) {
                    e(lang("you_not_logged_in"));
                } else {
                    if (!$this->photo_exists($pid)) {
                        e(lang("photo_not_exist"));
                    } else {
                        if ($this->get_photo_owner($pid) != user_id() && !has_access('admin_access', true)) {
                            e(lang("cant_edit_photo"));
                        } else {
                            if (empty($array['collection_id'])) {
                                e(lang('collection_not_found'), 'w');
                            } elseif ($cid != $array['collection_id']) {
                                $this->collection->change_collection($array['collection_id'], $pid, $cid);
                            }

                            Clipbucket_db::getInstance()->update(tbl('photos'), $query_field, $query_val, " photo_id='$pid'");

                            Tags::saveTags($array['photo_tags'], 'photo', $pid);
                            if (empty(errorhandler::getInstance()->get_error)) {
                                e(lang("photo_updated_successfully"), "m");
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Used to get image type
     * t = Thumb
     * m = Medium
     * l = Large
     *
     * @param $name
     *
     * @return bool|false|string
     */
    function get_image_type($name)
    {
        if (empty($name)) {
            return false;
        }

        $parts = explode("_", $name);
        if (is_array($parts)) {
            if (!empty($parts[1])) {
                return substr($parts[1], 0, 1);
            }
        }
    }

    /**
     * Used to get image file
     *
     * @param        $pid
     * @param string $size
     * @param bool $multi
     * @param null $assign
     * @param bool $with_path
     * @param bool $with_orig
     *
     * @return string|void
     */
    function get_image_file($pid, $size = 't', $multi = false, $assign = null, $with_path = true, $with_orig = false)
    {
        $params = [
            'details'     => $pid
            , 'size'      => $size
            , 'multi'     => $multi
            , 'assign'    => $assign
            , 'with_path' => $with_path
            , 'with_orig' => $with_orig
        ];
        return get_image_file($params);
    }

    /**
     * This will become a Smarty function.
     * I am writting this to eliminate the possiblitles
     * of distort pictures
     *
     * @param $p
     *
     * @return string|array
     * @throws Exception
     */
    function getFileSmarty($p)
    {
        $details = $p['details'];
        $output = $p['output'];
        if (empty($details)) {
            return $this->default_thumb($size, $output);
        } else {
            //Calling Custom Functions
            if (!empty(ClipBucket::getInstance()->custom_get_photo_funcs)) {
                foreach (ClipBucket::getInstance()->custom_get_photo_funcs as $funcs) {
                    if (function_exists($funcs)) {
                        $func_returned = $funcs($p);
                        if ($func_returned) {
                            return $func_returned;
                        }
                    }
                }
            }

            if (($p['size'] != 't' && $p['size'] != 'm' && $p['size'] != 'l' && $p['size'] != 'o') || empty($p['size'])) {
                $p['size'] = 't';
            }

            if ($p['with_path'] === false) {
                $p['with_path'] = false;
            } else {
                $p['with_path'] = true;
            }
            $with_path = $p['with_path'];
            $with_orig = $p['with_orig'] ? $p['with_orig'] : false;

            if (!is_array($details)) {
                $photo = $this->get_photo($details);
            } else {
                $photo = $details;
            }

            if (empty($photo['photo_id']) || empty($photo['photo_key'])) {
                return $this->default_thumb($size, $output);
            }

            if (!empty($photo['filename']) && !empty($photo['ext'])) {
                $files = glob(DirPath::get('photos') . $photo['filename'] . '*.' . $photo['ext']);
                if (!empty($files) && is_array($files)) {
                    $thumbs = [];
                    foreach ($files as $file) {
                        $file_parts = explode('/', $file);
                        $thumb_name = $file_parts[count($file_parts) - 1];

                        $type = $this->get_image_type($thumb_name);
                        if ($with_orig) {
                            if ($with_path) {
                                $thumbs[] = DirPath::getUrl('photos') . $thumb_name;
                            } else {
                                $thumbs[] = $thumb_name;
                            }
                        } elseif (!empty($type)) {
                            if ($with_path) {
                                $thumbs[] = DirPath::getUrl('photos') . $thumb_name;
                            } else {
                                $thumbs[] = $thumb_name;
                            }
                        }
                    }

                    if (empty($p['output']) || $p['output'] == 'non_html') {
                        if ($p['assign'] && $p['multi']) {
                            assign($p['assign'], $thumbs);
                        } else {
                            if (!$p['assign'] && $p['multi']) {
                                return $thumbs;
                            } else {
                                $size = '_' . $p['size'];
                                $return_thumb = array_find($photo['filename'] . $size, $thumbs);

                                if (empty($return_thumb)) {
                                    $this->default_thumb($size, $output);
                                } else {
                                    if ($p['assign'] != null) {
                                        assign($p['assign'], $return_thumb);
                                    } else {
                                        return $return_thumb;
                                    }
                                }
                            }
                        }
                    }

                    if ($p['output'] == 'html') {
                        $size = '_' . $p['size'];

                        $src = array_find($photo['filename'] . $size, $thumbs);
                        if (empty($src)) {
                            $src = $this->default_thumb($size);
                        }

                        if (!empty($js)) {
                            $imgDetails = $js->json_decode($photo['photo_details'], true);
                        } else {
                            $imgDetails = json_decode($photo['photo_details'], true);
                        }

                        if (empty($imgDetails) || empty($imgDetails[$p['size']])) {
                            $dem = getimagesize(str_replace(DirPath::getUrl('photos'), DirPath::get('photos'), $src));
                            $width = $dem[0];
                            $height = $dem[1];
                            /* UPDATING IMAGE DETAILS */
                            $this->update_image_details($details);
                        } else {
                            $width = $imgDetails[$p['size']]['width'];
                            $height = $imgDetails[$p['size']]['height'];
                        }

                        $img = '<img src=\'' . $src . '\'';

                        if ($p['id']) {
                            $img .= ' id=\'' . display_clean($p['id']) . '_' . $photo['photo_id'] . '\'';
                        }

                        if ($p['class']) {
                            $img .= ' class=\'' . display_clean($p['class']) . '\'';
                        }

                        if ($p['align']) {
                            $img .= ' align=\'' . $p['align'] . '\'';
                        }
                        if (($p['width'] && is_numeric($p['width'])) && ($p['height'] && is_numeric($p['height']))) {
                            $height = $p['height'];
                            $width = $p['width'];
                        } elseif ($p['width'] && is_numeric($p['width'])) {
                            $height = round($p['width'] / $width * $height);
                            $width = $p['width'];
                        } elseif ($p['height'] && is_numeric($p['height'])) {
                            $width = round($p['height'] * $width / $height);
                            $height = $p['height'];
                        }

                        $img .= ' width=\'' . $width . '\'';
                        $img .= ' height=\'' . $height . '\'';

                        if ($p['title']) {
                            $img .= " title='" . display_clean($p['title']) . '\'';
                        } else {
                            $img .= " title='" . display_clean($photo['photo_title']) . '\'';
                        }

                        if ($p['alt']) {
                            $img .= ' alt=\'' . display_clean($p['alt']) . '\'';
                        } else {
                            $img .= ' alt=\'' . display_clean($photo['photo_title']) . '\'';
                        }

                        if ($p['anchor']) {
                            $anchor_p = [
                                'place'  => $p['anchor']
                                , 'data' => $photo
                            ];
                            ANCHOR($anchor_p);
                        }

                        if ($p['style']) {
                            $img .= ' style=\'' . $p['style'] . '\'';
                        }

                        if ($p['extra']) {
                            $img .= ($p['extra']);
                        }

                        $img .= ' />';

                        if ($p['assign']) {
                            assign($p['assign'], $img);
                        } else {
                            return $img;
                        }
                    }
                } else {
                    return $this->default_thumb($size, $output);
                }
            }
        }
    }

    /**
     * Will be called when collection is being deleted
     * This will make photos in the collection orphan
     * User will be able to access them in orphan photos
     *
     * @param      $details
     * @param null $pid
     * @throws Exception
     */
    function make_photo_orphan($details, $pid = null)
    {
        if (is_numeric($details)) {
            $c = $this->collection->get_collection($details);
            $cid = $c['collection_id'];
        } else {
            $cid = $details['collection_id'];
        }

        $cond = '';
        if (!empty($pid)) {
            $cond = ' AND object_id = ' . mysql_clean($pid);
        }

        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('collection_items') . ' WHERE type = \'photos\' AND collection_id = ' . mysql_clean($cid) . $cond);
    }

    /**
     * used to create links
     *
     * @param $details
     * @param $type
     *
     * @return string
     */
    function photo_links($details, $type): string
    {
        if (empty($type)) {
            return BASEURL;
        }

        switch ($type) {
            case 'upload':
                if (SEO == 'yes') {
                    return '/photo_upload';
                }
                return '/photo_upload.php';

            case 'upload_more':
                if (SEO == 'yes') {
                    return '/photo_upload/' . $this->encode_key($details['collection_id']);
                }
                return '/photo_upload.php?collection=' . $this->encode_key($details['collection_id']);

            case 'view_item':
            case 'view_photo':
                return $this->collection->collection_links($details, 'view_item');

            default:
                return BASEURL;
        }
    }

    /**
     * Used to return default thumb
     *
     * @param null $size
     * @param null $output
     *
     * @return string|void
     */
    function default_thumb($size = null, $output = null)
    {
        if ($size != '_t' && $size != '_m') {
            $size = '_m';
        }

        if (file_exists(TEMPLATEDIR . '/images/thumbs/no-photo' . $size . '.png')) {
            $path = TEMPLATEURL . '/images/thumbs/no-photo' . $size . '.png';
        } else {
            $path = DirPath::getUrl('photos') . 'no-photo' . $size . '.png';
        }

        if (!empty($output) && $output == 'html') {
            echo '<img src=\'' . $path . '\' />';
        } else {
            return $path;
        }
    }

    /**
     * Used to check if collection can add
     * photos or not
     *
     * @param $cid
     *
     * @return bool
     */
    function is_addable($cid): bool
    {
        if (!is_array($cid)) {
            $details = $this->collection->get_collection($cid);
        } else {
            $details = $cid;
        }

        if (empty($details)) {
            return false;
        }

        if (($details['active'] == 'yes' || $details['broadcast'] == 'public') && $details['userid'] == user_id()) {
            return true;
        }
        if ($details['userid'] == user_id()) {
            return true;
        }
        return false;
    }

    /**
     * Used to display photo voterts details.
     * User who rated, how many stars and when user rated
     *
     * @param      $id
     * @param bool $return_array
     * @param bool $show_all
     *
     * @return bool|mixed
     * @throws Exception
     */
    function photo_voters($id, $return_array = false, $show_all = false)
    {
        $p = $this->get_photo($id);
        if ((!empty($p) && $p['userid'] == user_id()) || $show_all === true) {
            $voters = $p['voters'];
            $voters = json_decode($voters, true);

            if (!empty($voters)) {
                if ($return_array) {
                    return $voters;
                }

                foreach ($voters as $id => $details) {
                    $username = get_username($id);
                    $output = '<li id=\'user' . $id . $p['photo_id'] . '\' class=\'PhotoRatingStats\'>';
                    $output .= '<a href=\'' . userquery::getInstance()->profile_link($id) . '\'>' . display_clean($username) . '</a>';
                    $output .= ' rated <strong>' . $details['rate'] / 2 . '</strong> stars <small>(';
                    $output .= niceTime($details['time']) . ')</small>';
                    $output .= '</li>';
                    echo $output;
                }
            }
        } else {
            return false;
        }
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
        if (!is_numeric($id)) {
            $cond = ' photo_key=' . $id;
        } else {
            $cond = ' photo_id=' . $id;
        }

        $result = Clipbucket_db::getInstance()->select(tbl('photos'), 'userid,allow_rating,rating,rated_by,voters', $cond);

        if ($result) {
            return $result[0];
        }
        return false;
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
    function rate_photo($id, $rating): array
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
        } elseif (user_id() == $c_rating['userid'] && config('own_photo_rating') != 'yes') {
            e(lang('you_cannot_rate_own_photo'));
        } elseif (!empty($already_voted)) {
            e(lang('you_hv_already_rated_photo'));
        } elseif ($c_rating['allow_rating'] == 'no' || config('photo_rating') != 'yes') {
            e(lang('photo_rate_disabled'));
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
            Clipbucket_db::getInstance()->update(tbl('photos'), ['rating', 'rated_by', 'voters'], ["$new_rate", "$rated_by", "|no_mc|$voters"], ' photo_id = ' . $id);
            $userDetails = [
                "object_id" => $id,
                "type"      => 'photo',
                "time"      => now(),
                "rating"    => $rating,
                "userid"    => user_id(),
                "username"  => user_name()
            ];
            /* Updating user details */
            update_user_voted($userDetails);
            e(lang('thnx_for_voting'), 'm');
        }

        return ['rating' => $new_rate, 'rated_by' => $rated_by, 'total' => 10, 'id' => $id, 'type' => 'photo', 'disable' => 'disabled'];
    }

    /**
     * Used to generate different
     * embed codes
     *
     * @param $p
     *
     * @return bool|string
     * @throws Exception
     */
    function generate_embed_codes($p)
    {
        $details = $p['details'];
        $type = $p['type'];

        if (is_array($details)) {
            $photo = $details;
        } else {
            $photo = $this->get_photo($details);
        }

        $code = '';
        $image_file = $this->get_image_file($photo);
        if (is_array($image_file)) {
            $image_file = $image_file[0];
        }
        switch ($type) {
            case 'html':
                if ($p['with_url']) {
                    $code .= "&lt;a href='" . $this->collection->collection_links($photo, 'view_item') . "' target='_blank'&gt;";
                }
                $code .= "&lt;img src='" . BASEURL . $image_file . "' title='" . display_clean($photo['photo_title']) . "' alt='" . display_clean($photo['photo_title']) . '&nbsp;' . TITLE . "' /&gt;";
                if ($p['with_url']) {
                    $code .= '&lt;/a&gt;';
                }
                break;

            case 'forum':
                if ($p['with_url']) {
                    $code .= '&#91;URL=' . $this->collection->collection_links($photo, 'view_item') . '&#93;';
                }
                $code .= '&#91;IMG&#93;' . BASEURL . $image_file . '&#91;/IMG&#93;';
                if ($p['with_url']) {
                    $code .= '&#91;/URL&#93;';
                }
                break;

            case 'email':
                $code .= $this->collection->collection_links($photo, 'view_item');
                break;

            case 'direct':
                $code .= BASEURL . $image_file;
                break;

            default:
                return false;
        }

        return $code;
    }

    /**
     * Embed Codes
     *
     * @param $newArr
     *
     * @return array|void
     * @throws Exception
     */
    function photo_embed_codes($newArr)
    {
        if (empty($newArr['details'])) {
            echo "<div class='error'>" . e(lang("need_photo_details")) . "</div>";
        } else {
            if ($newArr['details']['allow_embedding'] == 'no') {
                echo "<div class='error'>" . e(lang("embedding_is_disabled")) . "</div>";
            } else {
                $t = $newArr['type'];
                if (is_array($t)) {
                    $types = $t;
                } else {
                    if ($t == 'all') {
                        $types = $this->embed_types;
                    } else {
                        $types = explode(',', $t);
                    }
                }

                foreach ($types as $type) {
                    $type = strtolower($type);
                    if (in_array($type, $this->embed_types)) {
                        $type = str_replace(' ', '', $type);
                        $newArr['type'] = $type;
                        $codes[] = ["name" => ucwords($type), "type" => $type, "code" => $this->generate_embed_codes($newArr)];
                    }
                }

                if ($newArr['assign']) {
                    assign($newArr['assign'], $codes);
                } else {
                    return $codes;
                }
            }
        }
    }

    /**
     * Used encode photo key
     *
     * @param $key
     *
     * @return string
     */
    function encode_key($key)
    {
        return base64_encode(serialize($key));
    }

    /**
     * Used encode photo key
     *
     * @param $key
     *
     * @return mixed
     */
    function decode_key($key)
    {
        return unserialize(base64_decode($key));
    }

    /**
     * Used to perform photo actions
     *
     * @param $action
     * @param $id
     * @throws Exception
     */
    function photo_actions($action, $id)
    {
        $id = (int)$id;

        switch ($action) {
            case 'activate':
            case 'activation':
            case 'ap':
                Clipbucket_db::getInstance()->update(tbl($this->p_tbl), ['active'], ['yes'], ' photo_id = ' . $id);
                e(lang('photo_activated'), 'm');
                break;

            case 'deactivate':
            case 'deactivation':
            case 'dap':
                Clipbucket_db::getInstance()->update(tbl($this->p_tbl), ['active'], ['no'], ' photo_id = ' . $id);
                e(lang('photo_deactivated'), 'm');
                break;

            case 'make_featured':
            case 'feature_photo':
            case 'fp':
                Clipbucket_db::getInstance()->update(tbl($this->p_tbl), ['featured'], ['yes'], ' photo_id = ' . $id);
                e(lang('photo_featured'), 'm');
                break;

            case 'make_unfeatured':
            case 'unfeature_photo':
            case 'ufp':
                Clipbucket_db::getInstance()->update(tbl($this->p_tbl), ['featured'], ['no'], ' photo_id = ' . $id);
                e(lang('photo_unfeatured'), 'm');
                break;
        }
    }

}
