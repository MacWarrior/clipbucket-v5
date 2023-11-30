<?php
class Collection
{
    private static $collection;
    private $tablename = '';
    private $fields = [];
    private $display_block = '';
    private $search_limit = 0;
    private $display_var_name = '';

    public function __construct(){
        $this->tablename = 'collections';
        $this->fields = [
            'collection_id'
            ,'collection_id_parent'
            ,'collection_name'
            ,'collection_description'
            ,'category'
            ,'userid'
            ,'views'
            ,'date_added'
            ,'featured'
            ,'broadcast'
            ,'allow_comments'
            ,'allow_rating'
            ,'total_comments'
            ,'last_commented'
            ,'rating'
            ,'rated_by'
            ,'voters'
            ,'active'
            ,'public_upload'
            ,'type'
        ];
        $this->display_block = LAYOUT . '/blocks/collection.html';
        $this->display_var_name = 'collection';
        $this->search_limit = (int)config('collection_search_result');
    }

    public static function getInstance(): self
    {
        if( empty(self::$collection) ){
            self::$collection = new self();
        }
        return self::$collection;
    }

    private function getAllFields(): array
    {
        return array_map(function($field) {
            return $this->tablename . '.' . $field;
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
    public function getAll(array $params = [])
    {
        $param_collection_id = $params['collection_id'] ?? false;
        $param_collection_id_parent = $params['collection_id_parent'] ?? false;
        $param_category = $params['category'] ?? false;
        $param_userid = $params['userid'] ?? false;
        $param_search = $params['search'] ?? false;

        $param_condition = $params['condition'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_first_only = $params['first_only'] ?? false;

        $conditions = [];
        if( $param_collection_id ){
            $conditions[] = 'collections.collection_id = \''.mysql_clean($param_collection_id).'\'';
        }
        if( $param_collection_id_parent ){
            $conditions[] = 'collections.collection_id_parent = \''.mysql_clean($param_collection_id_parent).'\'';
        }
        if( $param_userid ){
            $conditions[] = 'collections.userid = \''.mysql_clean($param_userid).'\'';
        }
        if( $param_category ){
            if( !is_array($param_category) ){
                $conditions[] = 'collections.category LIKE \'%#'.mysql_clean($param_category).'#%\'';
            } else {
                $category_cond = [];
                foreach($param_category as $category){
                    $category_cond[] = 'collections.category LIKE \'%#'.mysql_clean($category).'#%\'';
                }
                $conditions[] = '(' . implode(' OR ', $category_cond) . ')';
            }
        }
        if( $param_condition ){
            $conditions[] = '(' . $param_condition . ')';
        }

        $version = Update::getInstance()->getDBVersion();

        if( $param_search ){
            /* Search is done on collection title, collection tags */
            // TODO : Add search on collection categories
            $cond = '(MATCH(collections.collection_name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(collections.collection_name) LIKE \'%' . mysql_clean($param_search) . '%\'';
            if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
                $cond .= ' OR MATCH(tags.name) AGAINST (\'' . mysql_clean($param_search) . '\' IN NATURAL LANGUAGE MODE) OR LOWER(tags.name) LIKE \'%' . mysql_clean($param_search) . '%\'';
            }
            $cond .= ')';

            $conditions[] = $cond;
        }

        if( !has_access('admin_access', true) ){
            $conditions[] = $this->getGenericConstraints();
        }

        if( $param_count ){
            $select = ['COUNT(collections.collection_id) AS count'];
        } else {
            $select = $this->getAllFields();
            $select[] = 'users.username AS user_username';
            $select[] = 'COUNT(CASE WHEN collections.type = \'videos\' THEN video.videoid ELSE photos.photo_id END) AS total_objects';
        }

        $join = [];
        $group = ['collections.collection_id'];
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $select[] = 'GROUP_CONCAT(tags.name SEPARATOR \',\') AS tags';
            $join[] = 'LEFT JOIN ' . cb_sql_table('collection_tags') . ' ON collections.collection_id = collection_tags.id_collection';
            $join[] = 'LEFT JOIN ' . cb_sql_table('tags') .' ON collection_tags.id_tag = tags.id_tag';
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
            $order = ' ORDER BY '.$param_order;
        }

        $limit = '';
        if( $param_limit ){
            $limit = ' LIMIT '.$param_limit;
        }

        $left_join_video_cond = '';
        $left_join_photos_cond = '';
        if( !has_access('admin_access', true) ) {
            $left_join_video_cond .= ' AND ' . Video::getInstance()->getGenericConstraints();
            $left_join_photos_cond .= ' AND ' . Photo::getInstance()->getGenericConstraints();
        }

        $sql ='SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table('collections') . '
                LEFT JOIN ' . cb_sql_table('users') . ' ON collections.userid = users.userid
                LEFT JOIN ' . cb_sql_table('collection_items') . ' ON collections.collection_id = collection_items.collection_id
                LEFT JOIN ' . cb_sql_table('video') . ' ON collections.type = \'videos\' AND collection_items.object_id = video.videoid' . $left_join_video_cond . '
                LEFT JOIN ' . cb_sql_table('photos') . ' ON collections.type = \'photos\' AND collection_items.object_id = photos.photo_id' . $left_join_photos_cond
            . ' ' . implode(' ', $join)
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
     * @return string
     * @throws Exception
     */
    public function getGenericConstraints(): string
    {
        if (has_access('admin_access', true)) {
            return '';
        }

        $cond = '(collections.active = \'yes\' AND collections.broadcast = \'public\'';

        $current_user_id = user_id();
        if( $current_user_id ){
            $select_contacts = 'SELECT contact_userid FROM '.tbl('contacts').' WHERE confirmed = \'yes\' AND userid = '.$current_user_id;
            $cond .= ' OR collections.userid = '.$current_user_id.')';
            $cond .= ' OR ( collections.broadcast = \'private\' AND collections.userid IN('.$select_contacts.'))';
        } else {
            $cond .= ') ';
        }
        return $cond;
    }

    /**
     * @throws Exception
     */
    public static function display_banner($collection = [])
    {
        $text = '';
        $class = '';
        if ($collection['broadcast'] == 'private') {
            $text = sprintf(lang('collection_is'), strtolower(lang('private')));
            $class = 'label-warning';
        }

        if( !empty($text) ){
            echo '<div class="thumb_banner '.$class.'">' . $text . '</div>';
        }
    }

}


class Collections extends CBCategory
{
    public $search;

    var $collect_thumb_width = 360;
    var $collect_thumb_height = 680;
    var $collect_orignal_thumb_width = 1399;
    var $collect_orignal_thumb_height = 800;
    var $collect_small_thumb_width = 120;
    var $collect_small_thumb_height = 90;
    var $items = 'collection_items'; // ITEMS TABLE
    var $types = ''; // TYPES OF COLLECTIONS
    var $custom_collection_fields = [];
    var $collection_delete_functions = [];
    var $action = '';
    var $share_variables;

    /**
     * Setting variables of different thing which will
     * help makes this class reusble for very object
     */
    var $objTable = 'photos';
    var $objType = 'p';
    var $objName = 'Photo';
    var $objClass = 'cbphoto';
    var $objFunction = 'photo_exists';
    var $objFieldID = 'photo_id';

    public static function getInstance()
    {
        global $cbcollection;
        return $cbcollection;
    }

    /**
     * Constructor function to set values of tables
     * @throws Exception
     */
    function __construct()
    {
        global $cb_columns;

        $this->cat_tbl = 'collection_categories';
        $this->section_tbl = 'collections';
        $this->types = [];
        if (isSectionEnabled('videos')) {
            $this->types['videos'] = lang('videos');
        }

        if (isSectionEnabled('photos')) {
            $this->types['photos'] = lang('photos');
        }

        ksort($this->types);
        $this->setting_up_collections();
        $this->init_actions();

        $fields = ['collection_id', 'collection_name', 'collection_description',
            'collection_tags', 'userid', 'type', 'category', 'views', 'date_added',
            'active', 'rating', 'rated_by', 'voters'];

        $cb_columns->object('collections')->register_columns($fields);

        global $Cbucket;
        if (isSectionEnabled('collections')) {
            $Cbucket->search_types['collections'] = 'cbcollection';
        }

        register_anchor_function('display_banner', 'in_collection_thumb', Collection::class);
    }

    /**
     *     Settings up Action Class
     * @throws Exception
     */
    function init_actions()
    {
        $this->action = new cbactions();
        $this->action->init();     // Setting up reporting excuses
        $this->action->type = 'cl';
        $this->action->name = 'collection';
        $this->action->obj_class = 'cbcollection';
        $this->action->check_func = 'collection_exists';
        $this->action->type_tbl = 'collections';
        $this->action->type_id_field = 'collection_id';
    }

    /**
     * Setting links up in my account Edited on 12 march 2014 for collections links
     * @throws Exception
     */
    function setting_up_collections()
    {
        global $userquery, $Cbucket;
        $per = $userquery->get_user_level(user_id());
        // Adding My Account Links    
        if (isSectionEnabled('collections') && !NEED_UPDATE) {
            $userquery->user_account[lang('collections')] = [
                lang('add_new_collection')          => cblink(['name' => 'manage_collections', 'extra_params' => 'mode=add_new']),
                lang('manage_collections')          => cblink(['name' => 'manage_collections']),
                lang('manage_favorite_collections') => cblink(['name' => 'manage_collections', 'extra_params' => 'mode=favorite'])
            ];

            // Adding Collection links in Admin Area
            if ($per['collection_moderation'] == 'yes') {
                $menu_collection = [
                    'title'   => lang('collections')
                    , 'class' => 'glyphicon glyphicon-folder-close'
                    , 'sub'   => [
                        [
                            'title' => lang('manage_collections')
                            , 'url' => ADMIN_BASEURL . '/collection_manager.php'
                        ]
                        , [
                            'title' => lang('manage_categories')
                            , 'url' => ADMIN_BASEURL . '/collection_category.php'
                        ]
                        , [
                            'title' => lang('flagged_collections')
                            , 'url' => ADMIN_BASEURL . '/flagged_collections.php'
                        ]
                    ]
                ];
                $Cbucket->addMenuAdmin($menu_collection, 80);
            }

            // Adding Collection links in Cbucket Class
            $Cbucket->links['collections'] = ['collections.php', 'collections/'];
            $Cbucket->links['manage_collections'] = ['manage_collections.php', 'manage_collections.php'];
            $Cbucket->links['edit_collection'] = [
                'manage_collections.php?mode=edit_collection&amp;cid=',
                'manage_collections.php?mode=edit_collection&amp;cid='
            ];
            $Cbucket->links['manage_items'] = [
                'manage_collections.php?mode=manage_items&amp;cid=%s&amp;type=%s',
                'manage_collections.php?mode=manage_items&amp;cid=%s&amp;type=%s'
            ];
        }
    }

    /**
     * Function used to set-up sharing
     *
     * @param $data
     * @throws Exception
     */
    function set_share_mail($data)
    {
        $this->share_variables = [
            '{name}'             => $data['collection_name'],
            '{description}'      => $data['collection_description'],
            '{type}'             => $data['type'],
            '{total_items}'      => $data['total_objects'],
            '{collection_link}'  => $this->collection_links($data, 'view'),
            '{collection_thumb}' => $this->get_thumb($data, 'small', true)
        ];
        $this->action->share_template_name = 'collection_share_template';
        $this->action->val_array = $this->share_variables;
    }

    /**
     * Function used to check if collection exists
     *
     * @param $id
     *
     * @return bool
     * @throws Exception
     */
    function collection_exists($id): bool
    {
        global $db;
        $result = $db->count(tbl($this->section_tbl), 'collection_id', ' collection_id = ' . $id);
        if ($result) {
            return true;
        }
        return false;
    }

    /**
     * Function used to check if object exists
     * This is a replica of actions.class, exists function
     *
     * @param $id
     *
     * @return mixed
     */
    function object_exists($id)
    {
        $obj = $this->objClass;
        global ${$obj};
        $obj = ${$obj};
        $func = $this->objFunction;
        return $obj->{$func}($id);
    }

    /**
     * Function used to get collection
     *
     * @param      $id
     * @param null $cond
     *
     * @return bool|array
     * @throws Exception
     */
    function get_collection($id, $cond = null)
    {
        if( empty($id) ){
            return false;
        }

        $version = Update::getInstance()->getDBVersion();
        $select_tag = '';
        $join_tag = '';
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $select_tag = ', GROUP_CONCAT(T.name SEPARATOR \',\') AS collection_tags';
            $join_tag = ' LEFT JOIN ' . tbl('collection_tags') . ' CT ON collections.collection_id = CT.id_collection  
                    LEFT JOIN ' . tbl('tags') . ' T ON CT.id_tag = T.id_tag';
        }

        $where = '';
        if( !empty($cond) ){
            $where .= 'WHERE '.$cond;
        }

        $left_join_cond = '';
        if( !has_access('admin_access', true) ) {
            if( $this->objTable == 'video' ){
                $left_join_cond = ' AND ' . Video::getInstance()->getGenericConstraints();
            } else {
                $left_join_cond = ' AND ' . Photo::getInstance()->getGenericConstraints();
            }
        }

        $result = Clipbucket_db::getInstance()->select(cb_sql_table($this->section_tbl) . '
            INNER JOIN ' . cb_sql_table('users') . ' ON collections.userid = users.userid
            LEFT JOIN ' . cb_sql_table($this->items) . ' ON collections.collection_id = collection_items.collection_id
            LEFT JOIN ' . cb_sql_table($this->objTable) . ' ON ' . $this->objTable . '.'.$this->objFieldID .' = collection_items.object_id' . $left_join_cond
            . $join_tag
            ,'collections.*, users.userid, users.username, COUNT(DISTINCT ' . $this->objTable . '.' . $this->objFieldID . ') AS total_objects' . $select_tag,
            ' collections.collection_id = ' . mysql_clean($id) . ' ' . $where . ' GROUP BY collections.collection_id') ;

        if ($result) {
            return $result[0];
        }
        return false;
    }

    /**
     * @throws Exception
     */
    private function get_collection_childs($id, $cond = null)
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->section_tbl) . ' C
            INNER JOIN ' . tbl('users') . ' U ON C.userid = U.userid
            LEFT JOIN ' . tbl($this->items) . ' citem ON C.collection_id = citem.collection_id
            LEFT JOIN ' . tbl($this->objTable) . ' obj ON obj.'.$this->objFieldID .' = citem.object_id',
            'C.* ,U.userid,U.username, COUNT(DISTINCT citem.ci_id) AS total_objects',
            'C.collection_id_parent = ' . mysql_clean($id) . ' ' . $cond . ' GROUP BY C.collection_id');

        if ($result) {
            return $result;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    private function get_total_object_sub_collection($collection)
    {
        $childrens = $this->get_collection_childs($collection['collection_id']);
        $total = $collection['total_objects'];
        if ($childrens) {
            foreach ($childrens as $child) {
                $total += $this->get_total_object_sub_collection($child);
            }
        }
        return $total;
    }

    /**
     * @throws Exception
     */
    function is_viewable($cid): bool
    {
        global $userquery;

        $params = [];
        $params['collection_id'] = $cid;
        $params['first_only'] = true;
        $c = Collection::getInstance()->getAll($params);

        if (empty($c)) {
            e(lang('collection_not_exists'));
            return false;
        }

        if (!has_access('admin_access', true)) {
            return true;
        }

        if ($c['active'] == 'no') {
            e(lang('collection_not_active'));
            return true;
        }

        $userid = user_id();
        if ($c['broadcast'] == 'private' && !$userquery->is_confirmed_friend($c['userid'], $userid) && $c['userid'] != $userid ) {
            e(sprintf(lang('collection_is'), strtolower(lang('private'))));
            return false;
        }


        return true;
    }

    /**
     * @throws Exception
     */
    public function get_parent_collection($collection)
    {
        if (is_null($collection['collection_id_parent'])) {
            return false;
        }
        return $this->get_collection($collection['collection_id_parent']);
    }

    /**
     * Function used to get collections
     *
     * @param null $p
     * @param bool $brace
     *
     * @return array|bool|void
     * @throws Exception
     */
    function get_collections($p = null, $brace = false)
    {
        $limit = $p['limit'];
        $order = $p['order'];
        $cond = '';

        if (!empty($p['category'])) {
            $get_all = false;
            if (!is_array($p['category'])) {
                if (strtolower($p['category']) == 'all') {
                    $get_all = true;
                }
            }

            if (!$get_all) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }

                $cond .= '(';
                if (!is_array($p['category'])) {
                    $cats = explode(',', $p['category']);
                } else {
                    $cats = $p['category'];
                }
                $count = 0;

                foreach ($cats as $cat) {
                    $count++;
                    if ($count > 1) {
                        $cond .= ' OR ';
                    }
                    $cond .= 'collections.category LIKE \'%#' . $cat . '#%\'';
                }
                $cond .= ')';
            }
        }

        if ($p['date_span']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= cbsearch::date_margin('collections.date_added', $p['date_span']);
        }

        if ($p['type']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'collections.type = \'' . $p['type'] . '\'';
        }

        if ($p['user']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            if ($brace) {
                $cond .= '(';
            }
            $cond .= 'collections.userid = \'' . $p['user'] . '\'';
        }

        if ($p['featured']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'collections.featured = \'' . $p['featured'] . '\'';
        }

        if ($p['public_upload']) {
            if ($cond != '') {
                $cond .= ' OR ';
            }

            $cond .= 'collections.public_upload = \'' . $p['public_upload'] . '\'';
            if ($brace) {
                $cond .= ')';
            }
        }

        if ($p['exclude']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'collections.collection_id <> \'' . $p['exclude'] . '\'';
        }

        if ($p['cid']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'collections.collection_id = \'' . $p['cid'] . '\'';
        }

        $count = 'COUNT( DISTINCT
                CASE WHEN collections.type = \'photos\' THEN photos.photo_id ELSE video.videoid END
            )';

        $having = '';
        if ($p['has_items']) {
            $having = $count.' >= 1';
        }

        $title_tag = '';
        if ($p['name']) {
            $title_tag .= 'collections.collection_name LIKE \'%' . $p['name'] . '%\'';
        }

        if ($p['tags']) {
            if (!empty($title_tag)) {
                $title_tag .= ' OR ';
            }
            $title_tag .= 'T.name IN (\'' . $p['tags'] . '\') ' ;
        }

        if ($p['parents_only']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'collections.collection_id_parent IS NULL';
        }

        if ($p['parent_id']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= 'collections.collection_id_parent = ' . mysql_clean($p['parent_id']);
        }

        if ($title_tag != '') {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= '(' . $title_tag . ')';
        }

        $left_join_video_cond = '';
        $left_join_photos_cond = '';
        if( !has_access('admin_access', true) ) {
            $left_join_video_cond .= ' AND ' . Video::getInstance()->getGenericConstraints();
            $left_join_photos_cond .= ' AND ' . Photo::getInstance()->getGenericConstraints();

            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= Collection::getInstance()->getGenericConstraints();
        }

        $select_tag = '';
        $join_tag = '';
        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 264)) {
            $select_tag = ', GROUP_CONCAT(T.name SEPARATOR \',\') AS collection_tags';
            $join_tag = ' LEFT JOIN ' . tbl('collection_tags') . ' AS CT ON collections.collection_id = CT.id_collection 
                    LEFT JOIN ' . tbl('tags') . ' AS T ON CT.id_tag = T.id_tag';
        }
        $from = cb_sql_table('collections') .
            ' INNER JOIN ' . cb_sql_table('users') . ' ON collections.userid = users.userid
            LEFT JOIN ' . tbl('collections') . ' CPARENT ON collections.collection_id_parent = CPARENT.collection_id
            LEFT JOIN ' . tbl($this->items) . ' citem ON collections.collection_id = citem.collection_id
            LEFT JOIN ' . cb_sql_table('video') . ' ON collections.type = \'videos\' AND citem.object_id = video.videoid' . $left_join_video_cond . '
            LEFT JOIN ' . cb_sql_table('photos') . ' ON collections.type = \'photos\' AND citem.object_id = photos.photo_id' . $left_join_photos_cond
            . $join_tag;

        if (!empty ($cond)) {
            $cond .= ' GROUP BY collections.collection_id';
        } else {
            $cond = ' 1 GROUP BY collections.collection_id';
        }

        if (!empty($having)){
            $cond .= ' HAVING '.$having;
        }

        if ($p['count_only']) {
            return Clipbucket_db::getInstance()->count($from, 'collections.collection_id', $cond);
        }

        if (isset($p['count_only'])) {
            $select = 'COUNT(collections.collection_id) AS total_collections';
        } else {
            $select = 'collections.*, users.username, CPARENT.collection_name AS collection_name_parent, '.$count.' AS total_objects' . $select_tag;
        }

        $result = Clipbucket_db::getInstance()->select($from, $select, $cond, $limit, $order);

        if (config('enable_sub_collection')) {
            foreach ($result as &$line) {
                $line['total_objects'] = $this->get_total_object_sub_collection($line);
            }
        }

        if ($p['assign']) {
            assign($p['assign'], $result);
        } else {
            if (isset($p['count_only'])) {
                return $result[0]['total_collections'];
            }
            return $result;
        }
    }

    /**
     * Function used to get collection items
     *
     * @param      $id
     * @param null $order
     * @param null $limit
     *
     * @return array|bool
     * @throws Exception
     */
    function get_collection_items($id, $order = null, $limit = null)
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->items), '*', ' collection_id = ' . $id, $limit, $order);
        if ($result) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to get next / previous collection item
     *
     * @param        $ci_id
     * @param        $cid
     * @param string $item
     * @param int $limit
     * @param bool $check_only
     *
     * @return array|bool
     * @throws Exception
     */
    function get_next_prev_item($ci_id, $cid, $item = 'prev', $limit = 1, $check_only = false)
    {
        $iTbl = tbl($this->items);
        $oTbl = tbl($this->objTable);
        $uTbl = tbl('users');
        $tbls = $iTbl . ',' . $oTbl . ',' . $uTbl;

        if ($item == 'prev') {
            $op = '>';
            $order = '';
        } elseif ($item == 'next') {
            $op = '<';
            $order = $iTbl . '.ci_id DESC';
        } elseif ($item == null) {
            $op = '=';
            $order = '';
        }

        $cond = ' ' . $iTbl . '.collection_id = ' . $cid . ' AND ' . $iTbl . '.ci_id ' . $op . ' ' . $ci_id . ' AND ' . $iTbl . '.object_id = ' . $oTbl . '.' . $this->objFieldID . ' AND ' . $oTbl . '.userid = ' . $uTbl . '.userid';
        if (!$check_only) {
            $result = Clipbucket_db::getInstance()->select($tbls, $iTbl . '.*,' . $oTbl . '.*,' . $uTbl . '.username', $cond, $limit, $order);

            // Result was empty. Checking if we were going backwards, So bring last item
            if (empty($result) && $item == 'prev') {
                $order = $iTbl . '.ci_id ASC';
                $op = '<';
                $result = Clipbucket_db::getInstance()->select($tbls, $iTbl . '.*,' . $oTbl . '.*,' . $uTbl . '.username', ' ' . $iTbl . '.collection_id = ' . $cid . ' AND ' . $iTbl . '.ci_id ' . $op . ' ' . $ci_id . ' AND ' . $iTbl . '.object_id = ' . $oTbl . '.' . $this->objFieldID . ' AND ' . $oTbl . '.userid = ' . $uTbl . '.userid', $limit, $order);
            }

            // Result was empty. Checking if we were going forwards, So bring first item
            if (empty($result) && $item == 'next') {
                $order = $iTbl . '.ci_id DESC';
                $op = '>';
                $result = Clipbucket_db::getInstance()->select($tbls, $iTbl . '.*,' . $oTbl . '.*,' . $uTbl . '.username', ' ' . $iTbl . '.collection_id = ' . $cid . ' AND ' . $iTbl . '.ci_id ' . $op . ' ' . $ci_id . ' AND ' . $iTbl . '.object_id = ' . $oTbl . '.' . $this->objFieldID . ' AND ' . $oTbl . '.userid = ' . $uTbl . '.userid', $limit, $order);
            }
        } else {
            $result = Clipbucket_db::getInstance()->count($iTbl . ',' . $oTbl, $iTbl . '.ci_id', ' ' . $iTbl . '.collection_id = ' . $cid . ' AND ' . $iTbl . '.ci_id ' . $op . ' ' . $ci_id . ' AND ' . $iTbl . '.object_id = $oTbl.' . $this->objFieldID, $limit, $order);
        }

        if ($result) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to get collection items with details
     *
     * @param      $id
     * @param null $order
     * @param null $limit
     * @param bool $count_only
     *
     * @return array|bool
     * @throws Exception
     */
    function get_collection_items_with_details($id, $order = null, $limit = null, $count_only = false)
    {
        $tables = cb_sql_table($this->items) . ',' . cb_sql_table($this->objTable) . ', '.cb_sql_table('users');

        $condition[] = $this->items . '.collection_id = ' . mysql_clean($id);
        $condition[] = $this->items . '.object_id = ' . $this->objTable . '.' . $this->objFieldID;
        $condition[] = $this->objTable . '.userid = ' .'users.userid';

        if (!has_access('admin_access', true) ) {
            if( $this->objTable == 'video' ){
                $condition[] = Video::getInstance()->getGenericConstraints();
            } else {
                $condition[] = Photo::getInstance()->getGenericConstraints();
            }
        }

        if (!$count_only) {
            $result = Clipbucket_db::getInstance()->select($tables, $this->items . '.ci_id,' . $this->items . '.collection_id,' . $this->objTable . '.*,' . 'users.username', implode(' AND ', $condition), $limit, $order);
        } else {
            $result = Clipbucket_db::getInstance()->count($tables, 'ci_id', implode(' AND ', $condition));
        }

        if ($result) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to get collection items with
     * specific fields
     *
     * @param $cid
     * @param $objID
     * @param $fields
     *
     * @return array|bool
     * @throws Exception
     */
    function get_collection_item_fields($cid, $objID, $fields)
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->items), $fields, ' object_id = ' . $objID . ' AND collection_id = ' . $cid);
        if ($result) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to load collections fields
     *
     * @param null $default
     *
     * @return array
     * @throws Exception
     */
    function load_required_fields($default = null): array
    {
        if ($default == null) {
            $default = $_POST;
        }

        $name = $default['collection_name'];
        $description = $default['collection_description'];
        $tags = $default['collection_tags'];
        $type = $default['type'];
        $collection_id_parent = $default['collection_id_parent'];
        $collection_id = $default['collection_id'];
        if (is_array($default['category'])) {
            $cat_array = [$default['category']];
        } else {
            preg_match_all('/#([0-9]+)#/', $default['category'], $m);
            $cat_array = [$m[1]];
        }

        $data = [
            'name' => [
                'title'       => lang('collection_name'),
                'type'        => 'textfield',
                'name'        => 'collection_name',
                'id'          => 'collection_name',
                'value'       => $name,
                'db_field'    => 'collection_name',
                'required'    => 'yes',
                'invalid_err' => lang('collect_name_er')
            ],
            'desc' => [
                'title'         => lang('collection_description'),
                'type'          => 'textarea',
                'name'          => 'collection_description',
                'id'            => 'colleciton_desciption',
                'value'         => $description,
                'db_field'      => 'collection_description',
                'required'      => 'yes',
                'anchor_before' => 'before_desc_compose_box',
                'invalid_err'   => lang('collect_descp_er')
            ],
            'tags' => [
                'title'             => lang('collection_tags'),
                'type'              => 'hidden',
                'name'              => 'collection_tags',
                'id'                => 'collection_tags',
                'value'             => genTags($tags),
                'required'          => 'no',
                'invalid_err'       => lang('collect_tag_er'),
                'validate_function' => 'genTags'
            ],
            'cat'  => [
                'title'             => lang('collect_category'),
                'type'              => 'checkbox',
                'name'              => 'category[]',
                'id'                => 'category',
                'value'             => ['category', $cat_array],
                'db_field'          => 'category',
                'required'          => 'yes',
                'validate_function' => 'validate_collection_category',
                'invalid_err'       => lang('collect_cat_er'),
                'display_function'  => 'convert_to_categories',
                'category_type'     => 'collections'
            ],
            'type' => [
                'title'    => lang('collect_type'),
                'type'     => 'dropdown',
                'name'     => 'type',
                'id'       => 'type',
                'value'    => $this->types,
                'db_field' => 'type',
                'required' => 'yes',
                'checked'  => $type
            ]
        ];

        if ($default['total_objects'] > 0) {
            $data['type']['disabled'] = true;
            $data['type']['input_hidden'] = true;
        }

        if (config('enable_sub_collection')) {
            $list_parent_categories = ['null' => lang('collection_no_parent')];
            $type = $default['type'] ?? null;
            foreach ($this->get_collections_list(0, null, $collection_id, $type, user_id()) as $col_id => $col_data) {
                $list_parent_categories[$col_id] = $col_data['name'];
            }
            //getting direct parent collection
            if (array_key_exists('null', $list_parent_categories) && !empty($collection_id_parent)) {
                $parent = $this->get_collection($collection_id_parent);
                if ($parent) {
                    $list_parent_categories [$parent['collection_id']] =$parent['collection_name'];
                }
            }

            $data['parent'] = [
                'title'    => lang('collection_parent'),
                'type'     => 'dropdown',
                'name'     => 'collection_id_parent',
                'id'       => 'collection_id_parent',
                'value'    => $list_parent_categories,
                'db_field' => 'collection_id_parent',
                'required' => 'yes',
                'checked'  => $collection_id_parent
            ];
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    public function get_collections_list(int $level = 0, $collection_id = null, $exclude_id = null, $type = null, $userid = null): array
    {
        $data = [];

        if ($level == 0 && is_null($collection_id)) {
            $cond = ' C.collection_id_parent IS NULL';
        } else {
            $cond = ' C.collection_id_parent = ' . mysql_clean($collection_id);
        }

        if (!is_null($exclude_id)) {
            $cond .= ' AND C.collection_id != ' . mysql_clean($exclude_id);
        }

        if (!is_null($type)) {
            $cond .= ' AND C.type = \'' . mysql_clean($type) . '\'';
        }

        if (!is_null($type)) {
            $cond .= ' AND C.userid = ' . mysql_clean($userid);
        }
        if (!empty ($cond)) {
            $cond .= ' GROUP BY C.collection_id';
        } else {
            $cond = ' 1 GROUP BY C.collection_id';
        }
        $collections_parent = Clipbucket_db::getInstance()->select(tbl($this->section_tbl) . ' C  
            LEFT JOIN ' . tbl($this->items) . ' citem ON C.collection_id = citem.collection_id'
            , 'C.*, COUNT(DISTINCT citem.ci_id) AS total_objects'
            , $cond);
        foreach ($collections_parent as $col_parent) {
            $space = '';
            if (config('enable_sub_collection')) {
                $space = str_repeat('&nbsp;', $level * 3);
            }
            $data[$col_parent['collection_id']]['name'] = $space . display_clean($col_parent['collection_name']);
            $data[$col_parent['collection_id']]['count'] = $col_parent['total_objects'];
            $collections_children = $this->get_collections_list(($level + 1), $col_parent['collection_id'], $exclude_id, $type, $userid);
            foreach ($collections_children as $col_id => $col_name) {
                $data[$col_id] = $col_name;
            }
        }

        return $data;
    }

    /**
     * Function used to load collections optional fields
     * @throws Exception
     */
    function load_other_fields($default = null): array
    {
        if ($default == null) {
            $default = $_POST;
        }

        $return = [
            'broadcast'     => [
                'title'             => lang('vdo_br_opt'),
                'type'              => 'radiobutton',
                'name'              => 'broadcast',
                'id'                => 'broadcast',
                'value'             => ['public' => lang('collect_borad_pub'), 'private' => lang('collect_broad_pri')],
                'checked'           => $default['broadcast'],
                'db_field'          => 'broadcast',
                'required'          => 'no',
                'validate_function' => 'yes_or_no',
                'display_function'  => 'display_sharing_opt',
                'default_value'     => 'yes'
            ],
            'comments'      => [
                'title'             => lang('comments'),
                'type'              => 'radiobutton',
                'id'                => 'allow_comments',
                'name'              => 'allow_comments',
                'value'             => ['yes' => lang('vdo_allow_comm'), 'no' => lang('vdo_dallow_comm')],
                'checked'           => $default['allow_comments'],
                'db_field'          => 'allow_comments',
                'required'          => 'no',
                'validate_function' => 'yes_or_no',
                'display_function'  => 'display_sharing_opt',
                'default_value'     => 'yes'
            ],
            'public_upload' => [
                'title'             => lang('collect_allow_public_up'),
                'type'              => 'radiobutton',
                'id'                => 'public_upload',
                'name'              => 'public_upload',
                'value'             => ['no' => lang('collect_pub_up_dallow'), 'yes' => lang('collect_pub_up_allow')],
                'checked'           => $default['public_upload'],
                'db_field'          => 'public_upload',
                'required'          => 'no',
                'validate_function' => 'yes_or_no',
                'display_function'  => 'display_sharing_opt',
                'default_value'     => 'no'
            ]
        ];

        return $return;
    }

    /**
     * Function used to validate form fields
     *
     * @param null $array
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function validate_form_fields($array = null)
    {
        $reqFileds = $this->load_required_fields($array);

        if ($array == null) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        $otherFields = $this->load_other_fields($array);
        $collection_fields = array_merge($reqFileds, $otherFields);
        validate_cb_form($collection_fields, $array);
    }

    /**
     * Function used to validate collection category
     *
     * @param $array
     *
     * @return bool
     * @throws Exception
     */
    function validate_collection_category($array = null): bool
    {
        if ($array == null) {
            $array = $_POST['category'];
        }

        if (!is_array($array) || count($array) == 0) {
            return false;
        }

        $new_array = [];
        foreach ($array as $arr) {
            if ($this->category_exists($arr)) {
                $new_array[] = $arr;
            }
        }

        if (count($new_array) == 0) {
            e(lang('vdo_cat_err3'));
            return false;
        }

        return true;
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function create_collection($array = null)
    {
        if (!has_access('allow_create_collection', false)) {
            return false;
        }

        if ($array == null) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        $this->validate_form_fields($array);
        if (!error()) {
            $fields = $this->load_required_fields($array);
            $collection_fields = array_merge($fields, $this->load_other_fields($array));

            if (count($this->custom_collection_fields) > 0) {
                $collection_fields = array_merge($collection_fields, $this->custom_collection_fields);
            }

            foreach ($collection_fields as $field) {
                $name = formObj::rmBrackets($field['name']);
                $val = $array[$name];

                if ($name == 'collection_id_parent') {
                    if (!config('enable_sub_collection')) {
                        continue;
                    }
                }

                if (is_array($val)) {
                    $new_val = '';
                    foreach ($val as $v) {
                        $new_val .= '#' . $v . '# ';
                    }
                    $val = $new_val;
                }

                if ($field['use_func_val']) {
                    $val = $field['validate_function']($val);
                }

                if (!empty($field['db_field'])) {
                    $query_field[] = $field['db_field'];
                }

                if (!$field['clean_func'] || (!function_exists($field['clean_func']) && !is_array($field['clean_func']))) {
                    $val = ($val);
                } else {
                    $val = apply_func($field['clean_func'], '|no_mc|' . $val);
                }

                if (!empty($field['db_field'])) {
                    $query_val[] = $val;
                }
            }

            // date_added
            $query_field[] = 'date_added';
            $query_val[] = NOW();

            // user
            $query_field[] = 'userid';
            if ($array['userid']) {
                $query_val[] = $userid = $array['userid'];
            } else {
                $query_val[] = $userid = user_id();
            }

            // active
            $query_field[] = 'active';
            $query_val[] = 'yes';

            $insert_id = Clipbucket_db::getInstance()->insert(tbl($this->section_tbl), $query_field, $query_val);
            addFeed(['action' => 'add_collection', 'object_id' => $insert_id, 'object' => 'collection']);

            //Incrementing usr collection
            Clipbucket_db::getInstance()->update(tbl('users'), ['total_collections'], ['|f|total_collections+1'], ' userid=\'' . $userid . '\'');
            Tags::saveTags($array['collection_tags'], 'collection', $insert_id);

            e(lang('collect_added_msg'), 'm');
            return $insert_id;
        }
    }

    /**
     * Function used to add item in collection
     *
     * @param $objID
     * @param $cid
     * @throws Exception
     */
    function add_collection_item($objID, $cid)
    {
        $objID = mysql_clean($objID);
        $cid = mysql_clean($cid);

        if ($this->collection_exists($cid)) {
            if (!user_id()) {
                e(lang('you_not_logged_in'));
            } elseif (!$this->object_exists($objID)) {
                e(sprintf(lang('object_does_not_exists'), $this->objName));
            } elseif ($this->object_in_collection($objID, $cid)) {
                e(sprintf(lang('object_exists_collection'), $this->objName));
            } else {
                $flds = ['collection_id', 'object_id', 'type', 'userid', 'date_added'];
                $vls = [$cid, $objID, $this->objType, user_id(), NOW()];
                Clipbucket_db::getInstance()->insert(tbl($this->items), $flds, $vls);
                e(sprintf(lang('item_added_in_collection'), $this->objName), 'm');
            }
        } else {
            e(lang('collect_not_exist'));
        }
    }

    /**
     * Function used to check if object exists in collection
     *
     * @param $id
     * @param $cid
     *
     * @return bool|array
     * @throws Exception
     */
    function object_in_collection($id, $cid)
    {
        $id = mysql_clean($id);
        $cid = mysql_clean($cid);
        $result = Clipbucket_db::getInstance()->select(tbl($this->items), '*', ' object_id = ' . $id . ' AND collection_id = ' . $cid);
        if ($result) {
            return $result[0];
        }
        return false;
    }

    /**
     * Extract collection's name using Collection's id
     * function is mostly used via Smarty template engine
     *
     * @param $cid
     * @param null $field
     * @return bool|array
     * @throws Exception
     */
    function get_collection_field($cid, $field = null)
    {
        if ($field == null) {
            $field = '*';
        }
        if (is_array($cid)) {
            $cid = $cid['collection_id'];
        }
        $cid = mysql_clean($cid);
        $field = mysql_clean($field);
        $result = Clipbucket_db::getInstance()->select(tbl($this->section_tbl), $field, ' collection_id = ' . $cid);
        if ($result) {
            if (count($result[0]) > 2) {
                return $result[0];
            }
            return $result[0][$field];
        }
        return false;
    }

    /**
     * Function used to check if user collection owner
     *
     * @param      $cdetails
     * @param null $userid
     *
     * @return bool
     * @throws Exception
     */
    function is_collection_owner($cdetails, $userid = null): bool
    {
        if ($userid == null) {
            $userid = user_id();
        }

        if (!is_array($cdetails)) {
            $details = $this->get_collection($cdetails);
        } else {
            $details = $cdetails;
        }

        if ($details['userid'] == $userid) {
            return true;
        }
        return false;
    }

    /**
     * Function used to delete collection
     *
     * @param $cid
     * @throws Exception
     */
    function delete_collection($cid)
    {
        $collection = $this->get_collection($cid);
        if (empty($collection)) {
            e(lang('collection_not_exists'));
            return;
        }

        if ($collection['userid'] != user_id() && !has_access('admin_access', true)) {
            e(lang('cant_perform_action_collect'));
            return;
        }

        $cid = mysql_clean($cid);
        $del_funcs = $this->collection_delete_functions;
        if (is_array($del_funcs) && !empty($del_funcs)) {
            foreach ($del_funcs as $func) {
                if (function_exists($func)) {
                    $func($collection);
                }
            }
        }

        $collection_id_parent = $collection['collection_id_parent'];
        if (is_null($collection_id_parent)) {
            $collection_id_parent = '|f|null';
        }
        Clipbucket_db::getInstance()->update(tbl($this->section_tbl), ['collection_id_parent'], [$collection_id_parent], ' collection_id_parent = ' . $cid);

        //Remove tags
        \Tags::saveTags('', 'collection', $cid);

        Clipbucket_db::getInstance()->delete(tbl($this->items), ['collection_id'], [$cid]);
        $this->delete_thumbs($cid);
        Clipbucket_db::getInstance()->delete(tbl($this->section_tbl), ['collection_id'], [$cid]);

        //Decrementing users total collection
        Clipbucket_db::getInstance()->update(tbl('users'), ['total_collections'], ['|f|total_collections-1'], ' userid=\'' . $cid . '\'');

        $params = [];
        $params['type'] = 'cl';
        $params['type_id'] = $cid;
        Comments::delete($params);

        //Removing video From Favorites
        Clipbucket_db::getInstance()->delete(tbl('favorites'), ['type', 'id'], ['cl', $cid]);
        e(lang('collection_deleted'), 'm');
    }

    /**
     * Function used to delete collection items
     *
     * @param $id
     * @param $cid
     *
     * @return bool|void
     * @throws Exception
     */
    function remove_item($id, $cid)
    {
        $id = mysql_clean($id);
        $cid = mysql_clean($cid);

        if (!$this->collection_exists($cid)) {
            e(lang('collect_not_exists'));
            return false;
        }

        if (!user_id()) {
            e(lang('you_not_logged_in'));
        } elseif (!$this->object_in_collection($id, $cid)) {
            e(sprintf(lang('object_not_in_collect'), $this->objName));
        } elseif (!$this->is_collection_owner($cid) && !has_access('admin_access', true)) {
            e(lang('cant_perform_action_collect'));
        } else {
            Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl($this->items) . ' WHERE object_id = ' . $id . ' AND collection_id = ' . $cid);
            e(sprintf(lang('collect_item_removed'), $this->objName), 'm');
        }
    }

    /**
     * Function used to count collection items
     *
     * @param $cid
     *
     * @return bool|int
     * @throws Exception
     */
    function count_items($cid)
    {
        $cid = mysql_clean($cid);
        $count = Clipbucket_db::getInstance()->count($this->items, 'ci_id', ' collection_id = ' . $cid);
        if ($count) {
            return $count;
        }
        return 0;
    }

    /**
     * Function used to delete collection preview
     *
     * @param $cid
     *
     * @return bool|void
     */
    function delete_thumbs($cid)
    {
        $glob = glob(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '*.jpg');
        if( !$glob ){
            return false;
        }

        foreach ($glob as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Function used to create collection preview
     *
     * @param $cid
     * @param $file
     */
    function upload_thumb($cid, $file)
    {
        global $imgObj;
        $file_ext = getext($file['name']);

        $exts = ['jpg', 'gif', 'jpeg', 'png'];

        foreach ($exts as $ext) {
            if ($ext == $file_ext) {
                $thumb = COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '.' . $ext;

                $sThumb = COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '-small.' . $ext;
                $oThumb = COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '-orignal.' . $ext;
                foreach ($exts as $un_ext) {
                    if (file_exists(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '.' . $un_ext) && file_exists(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '-small.' . $un_ext) && file_exists(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '-orignal.' . $un_ext)) {
                        unlink(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '.' . $un_ext);
                        unlink(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '-small.' . $un_ext);
                        unlink(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . '-orignal.' . $un_ext);
                    }
                }
                move_uploaded_file($file['tmp_name'], $thumb);
                if (!$imgObj->ValidateImage($thumb, $ext)) {
                    e('pic_upload_vali_err');
                } else {
                    $imgObj->createThumb($thumb, $thumb, $this->collect_thumb_width, $ext, $this->collect_thumb_height);
                    $imgObj->createThumb($thumb, $sThumb, $this->collect_small_thumb_width, $ext, $this->collect_small_thumb_height);
                    $imgObj->createThumb($thumb, $oThumb, $this->collect_orignal_thumb_width, $ext, $this->collect_orignal_thumb_height);
                }
            }
        }
    }

    /**
     * Function used to create collection preview
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function update_collection($array = null)
    {
        if ($array == null) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        $this->validate_form_fields($array);
        $cid = $array['collection_id'];

        if (!error()) {
            $reqFields = $this->load_required_fields($array);
            $otherFields = $this->load_other_fields($array);

            $collection_fields = array_merge($reqFields, $otherFields);
            if ($this->custom_collection_fields > 0) {
                $collection_fields = array_merge($collection_fields, $this->custom_collection_fields);
            }

            foreach ($collection_fields as $field) {
                $name = formObj::rmBrackets($field['name']);
                $val = $array[$name];

                if ($name == 'collection_id_parent' && $val == 'null') {
                    $val = '|f|null';
                }

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

            if (has_access('admin_access', true)) {
                if (!empty($array['total_comments'])) {
                    $total_comments = $array['total_comments'];
                    if (!is_numeric($total_comments) || $total_comments < 0) {
                        $total_comments = 0;
                    }
                    $query_field[] = 'total_comments';
                    $query_val[] = $total_comments;
                }
            }
        }

        if (!error()) {
            if (!user_id()) {
                e(lang('you_not_logged_in'));
            } elseif (!$this->collection_exists($cid)) {
                e(lang('collect_not_exist'));
            } elseif (!$this->is_collection_owner($cid, user_id()) && !has_access('admin_access', true)) {
                e(lang('cant_edit_collection'));
            } else {
                $cid = mysql_clean($cid);
                Clipbucket_db::getInstance()->update(tbl($this->section_tbl), $query_field, $query_val, ' collection_id = ' . $cid);

                Tags::saveTags($array['collection_tags'], 'collection', $cid);

                e(lang('collection_updated'), 'm');

                if (!empty($array['collection_thumb']['tmp_name'])) {
                    $this->upload_thumb($cid, $array['collection_thumb']);
                }
            }
        }
    }

    /**
     * Function used get default thumb
     */
    function get_default_thumb($size = null): string
    {
        if ($size == 'small' && file_exists(TEMPLATEDIR . '/images/thumbs/collection_thumb-small.png')) {
            return TEMPLATEDIR . '/images/thumbs/collection_thumb-small.png';
        }

        if (!$size && file_exists(TEMPLATEDIR . '/images/thumbs/collection_thumb.png')) {
            return TEMPLATEDIR . '/images/thumbs/collection_thumb.png';
        }

        if ($size == 'small') {
            $thumb = COLLECT_THUMBS_URL . DIRECTORY_SEPARATOR . 'no_thumb-small.png';
        } else {
            $thumb = COLLECT_THUMBS_URL . DIRECTORY_SEPARATOR . 'no_thumb.png';
        }

        return $thumb;
    }

    /**
     * Function used get collection thumb
     * @throws Exception
     */
    function get_thumb($cdetails, $size = null, $return_c_thumb = false)
    {
        if (is_numeric($cdetails)) {
            $cdetails = $this->get_collection($cdetails);
            $cid = $cdetails['collection_id'];
        } else {
            $cid = $cdetails['collection_id'];
        }

        $exts = ['jpg', 'png', 'gif', 'jpeg'];

        if ($return_c_thumb) {
            foreach ($exts as $ext) {
                if ($size == 'small') {
                    $s = '-small';
                }
                if (file_exists(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . $s . '.' . $ext)) {
                    return COLLECT_THUMBS_URL . '/' . $cid . $s . '.' . $ext;
                }
            }
        } else {
            $item = $this->get_collection_items($cid, 'ci_id DESC', 1);
            $type = $item[0]['type'];
            switch ($type) {
                case 'v':
                    global $cbvideo;
                    $thumb = get_thumb($cbvideo->get_video($item[0]['object_id']));
                    break;

                case 'p':
                    global $cbphoto;
                    $thumb = $cbphoto->get_image_file($cbphoto->get_photo($item[0]['object_id']));
                    break;
            }

            if ($thumb) {
                return $thumb;
            }

            foreach ($exts as $ext) {
                if ($size == 'small') {
                    $s = '-small';
                }
                if (file_exists(COLLECT_THUMBS_DIR . DIRECTORY_SEPARATOR . $cid . $s . '.' . $ext)) {
                    return COLLECT_THUMBS_URL . '/' . $cid . $s . '.' . $ext;
                }
            }
        }

        return $this->get_default_thumb($size);
    }


    /**
     * Used to display collection voterts details.
     * User who rated, how many stars and when user rated
     *
     * @param      $id
     * @param bool $return_array
     * @param bool $show_all
     *
     * @return bool|mixed
     * @throws Exception
     */
    function collection_voters($id, $return_array = false, $show_all = false)
    {
        $c = $this->get_collection($id);
        if ((!empty($c) && $c['userid'] == user_id()) || $show_all === true) {
            global $userquery;
            $voters = $c['voters'];
            $voters = json_decode($voters, true);

            if (!empty($voters)) {
                if ($return_array) {
                    return $voters;
                }

                foreach ($voters as $id => $details) {
                    $username = get_username($id);
                    $output = '<li id=\'user' . $id . $c['collection_id'] . '\' class=\'PhotoRatingStats\'>';
                    $output .= '<a href=\'' . $userquery->profile_link($id) . '\'>' . $username . '</a>';
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
        $id = mysql_clean($id);
        $result = Clipbucket_db::getInstance()->select(tbl('collections'), 'allow_rating,rating,rated_by,voters,userid', ' collection_id = ' . $id);
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
    function rate_collection($id, $rating): array
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
        } elseif (user_id() == $c_rating['userid'] && !config('own_collection_rating')) {
            e(lang('you_cannot_rate_own_collection'));
        } elseif (!empty($already_voted)) {
            e(lang('you_hv_already_rated_photo'));
        } elseif ($c_rating['allow_rating'] == 'no' || !config('collection_rating')) {
            e(lang('collection_rating_not_allowed'));
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

            $id = mysql_clean($id);
            Clipbucket_db::getInstance()->update(tbl('collections'), ['rating', 'rated_by', 'voters'], [$new_rate, $rated_by, '|no_mc|' . $voters], ' collection_id = ' . $id);
            $userDetails = [
                'object_id' => $id,
                'type'      => 'collection',
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
            'rating'     => $new_rate
            , 'rated_by' => $rated_by
            , 'total'    => 10
            , 'id'       => $id
            , 'type'     => 'collection'
            , 'disable'  => 'disabled'
        ];
    }

    /**
     * Function used generate collection link
     *
     * @param $cid
     * @param $type
     *
     * @return float
     */
    function collection_rating($cid, $type)
    {
        switch ($type) {
            case 'videos':
            case 'v':
                global $cbvideo;
                $items = $cbvideo->collection->get_collection_items_with_details($cid);
                break;

            case 'photos':
            case 'p':
                global $cbphoto;
                $items = $cbphoto->collection->get_collection_items_with_details($cid);
                break;
        }

        $total_rating = '';
        if (!empty($items)) {
            foreach ($items as $item) {
                $total_rating += $item['rating'];
                if (!empty($item['rated_by']) && $item['rated_by'] != 0) {
                    $voters[] = $item['rated_by'];
                }
            }
        }

        $total_voters = count($voters);
        if (!empty($total_rating) && $total_voters != 0) {
            $collect_rating = $total_rating / $total_voters;
            return round($collect_rating, 2);
        }
        return 0;
    }

    public function get_base_url(): string
    {
        if (config('seo') == 'yes') {
            return '/collections/';
        }
        return '/collections.php';
    }

    /**
     * Function used return collection links
     *
     * @param      $details
     * @param null $type
     *
     * @return string
     * @throws Exception
     */
    function collection_links($details, $type = null): string
    {
        if (is_array($details)) {
            if (empty($details['collection_id'])) {
                return BASEURL;
            }
            $cdetails = $details;
        } else {
            if (is_numeric($details)) {
                $cdetails = $this->get_collection($details);
            } else {
                return BASEURL;
            }
        }

        if (!empty($cdetails)) {
            if ($type == null || $type == 'main') {
                return $this->get_base_url();
            }
            if ($type == 'vc' || $type == 'view_collection' || $type == 'view') {
                if (SEO == 'yes') {
                    return BASEURL . '/collection/' . $cdetails['collection_id'] . '/' . $cdetails['type'] . '/' . SEO(($cdetails['collection_name']));
                }
                return BASEURL . '/view_collection.php?cid=' . $cdetails['collection_id'];
            }
            if ($type == 'vi' || $type == 'view_item' || $type == 'item') {
                if (SEO == 'yes') {
                    return BASEURL . '/item/photos/' . $details['collection_id'] . '/' . $details['photo_key'] . '/' . SEO(clean(str_replace(' ', '-', $details['photo_title'])));
                }
                return BASEURL . '/view_item.php?item=' . $details['photo_key'] . '&amp;collection=' . $details['collection_id'];
            }
            if ($type == 'load_more' || $type == 'more_items' || $type = 'moreItems') {
                if (empty($cdetails['page_no'])) {
                    $cdetails['page_no'] = 2;
                }

                if (SEO == 'yes') {
                    return BASEURL . '?cid=' . $cdetails['collection_id'] . '&amp;page=' . $cdetails['page_no'];
                }
                return BASEURL . '?cid=' . $cdetails['collection_id'] . '&amp;page=' . $cdetails['page_no'];
            }
        }
        return BASEURL;
    }

    /**
     *    Used to change collection of product
     *
     * @param      $new
     * @param      $obj
     * @param null $old
     * @throws Exception
     */
    function change_collection($new, $obj, $old = null)
    {
        /* THIS MEANS OBJECT IS ORPHAN MOST PROBABLY AND HOPEFULLY - PHOTO
           NOW WE WILL ADD $OBJ TO $NEW */

        if ($old == 0 || $old == null) {
            $this->add_collection_item($obj, $new);
        } else {
            Clipbucket_db::getInstance()->update(tbl($this->items), ['collection_id'], [$new], ' collection_id = ' . $old . ' AND type = \'' . $this->objType . '\' AND object_id = ' . $obj);
        }
    }

    /**
     * Sorting links for collection
     * @throws Exception
     */
    function sorting_links()
    {
        if (!isset($_GET['sort'])) {
            $_GET['sort'] = 'most_recent';
        }

        return [
            'most_recent'    => lang('most_recent'),
            'most_viewed'    => lang('mostly_viewed'),
            'featured'       => lang('featured'),
            'most_items'     => lang('Most Items'),
            'most_commented' => lang('most_comments')
        ];
    }

    /**
     * Used to perform actions on collection
     *
     * @param $action
     * @param $cid
     * @throws Exception
     */
    function collection_actions($action, $cid)
    {
        $cid = mysql_clean($cid);
        switch ($action) {
            case 'activate':
            case 'activation':
            case 'ac':
                Clipbucket_db::getInstance()->update(tbl($this->section_tbl), ['active'], ['yes'], ' collection_id = ' . $cid);
                e(lang('collection_activated'), 'm');
                break;

            case 'deactivate':
            case 'deactivation':
            case 'dac':
                Clipbucket_db::getInstance()->update(tbl($this->section_tbl), ['active'], ['no'], ' collection_id = ' . $cid);
                e(lang('collection_deactivated'), 'm');
                break;

            case 'make_feature':
            case 'featured':
            case 'mcf':
                Clipbucket_db::getInstance()->update(tbl($this->section_tbl), ['featured'], ['yes'], ' collection_id = ' . $cid);
                e(lang('collection_featured'), 'm');
                break;

            case 'make_unfeature':
            case 'unfeatured':
            case 'mcuf':
                Clipbucket_db::getInstance()->update(tbl($this->section_tbl), ['featured'], ['no'], ' collection_id = ' . $cid);
                e(lang('collection_unfeatured'), 'm');
                break;

            default:
                header('location:' . BASEURL);
                break;
        }
    }

    /**
     * Function used to remove item from collections
     * and decrement collection item count
     * @param $objId
     * @param null $type
     * @throws Exception
     */
    function deleteItemFromCollections($objId, $type = null)
    {
        if (!$type) {
            $type = $this->objType;
        }

        $objId = mysql_clean($objId);

        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('collection_items') . ' WHERE '
            . ('type=\'' . $type . '\'') . ' AND ' . ('object_id=\'' . $objId . '\''));
    }

    /**
     * @throws Exception
     */
    function coll_first_thumb($col_data, $size = false)
    {
        global $cbphoto, $cbvid;
        if (is_array($col_data)) {
            if (isset($_GET['h']) && isset($_GET['w'])) {
                $size = $_GET['h'] . 'x' . $_GET['w'];
            }
            switch ($col_data['type']) {
                case 'photos':
                default :
                    $order = 'photos.date_added DESC';
                    $first_col = $cbphoto->collection->get_collection_items_with_details($col_data['collection_id'], $order, 1, false);
                    $param['details'] = $first_col[0];
                    if (!$size) {
                        $param['size'] = 's';
                    } else {
                        $param['size'] = $size;
                    }
                    $param['class'] = 'img-responsive';
                    return get_photo($param);

                case 'videos':
                    $first_col = $cbvid->collection->get_collection_items_with_details($col_data['collection_id'], 0, 1, false);

                    if( empty($first_col) ){
                        return default_thumb();
                    }

                    $vdata = $first_col[0];
                    if (!$size || $size == 's') {
                        $size = '168x105';
                    } else {
                        if ($size == 'l') {
                            $size = '632x395';
                        } else {
                            $size = '416x260';
                        }
                    }
                    return get_thumb($vdata, false, $size);
            }
        }
        return false;
    }

}
