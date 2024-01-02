<?php

class Category
{
    private static $category;
    private $tablename = '';
    private $primary_key = '';
    private $fields = [];

    private $cat_thumb_height = '';
    private $cat_thumb_width = '';
    private $default_thumb = '';

    private $typeNamesByIds = [];
    public function __construct()
    {
        $this->tablename = 'categories';
        $this->primary_key = 'category_id';
        $this->fields = [
            'category_id'
            ,'parent_id'
            ,'id_category_type'
            ,'category_name'
            ,'category_order'
            ,'category_desc'
            ,'date_added'
            ,'category_thumb'
            ,'is_default'
        ];
        $this->cat_thumb_height = '125';
        $this->cat_thumb_width = '125';
        $this->default_thumb = 'no_thumb.jpg';
        $this->typeNamesByIds = array_column(self::getAllCategoryTypes(), 'name', 'id_category_type');
    }

    /**
     * @param $name
     * @return array|mixed|null
     */
    public function getIdsCategoriesType($name = '')
    {
        if (!empty($name)) {
            return array_search($name, $this->typeNamesByIds);
        }
        return $this->typeNamesByIds;
    }

    public static function getInstance(): self
    {
        if( empty(self::$category) ){
            self::$category = new self();
        }
        return self::$category;
    }

    /**
     * @throws Exception
     */
    public static function getAllCategoryTypes(): array
    {
        return Clipbucket_db::getInstance()->_select('SELECT * FROM ' . cb_sql_table('categories_type'));
    }

    private function getAllFields(): array
    {
        return array_map(function($field) {
            return $this->tablename . '.' . $field;
        }, $this->fields);
    }

    public function getAll(array $params = [])
    {
        $param_category_id = $params['category_id'] ?? false;
        $param_category_type = $params['category_type'] ?? false;
        $param_category_default = $params['category_default'] ?? false;
        $param_parent_id = $params['parent_id'] ?? false;
        $param_parent_only = $params['parent_only'] ?? false;
        $param_search = $params['search'] ?? false;

        $param_condition = $params['condition'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_first_only = $params['first_only'] ?? false;

        $conditions = [];

        if ($param_category_id !== false) {
            $conditions[] = 'category_id = '. mysql_clean($param_category_id);
        }
        if ($param_category_type !== false) {
            $conditions[] = 'id_category_type = '. mysql_clean($param_category_type);
        }
        if ($param_category_default !== false) {
            $conditions[] = 'is_default = '. mysql_clean($param_category_type);
        }
        if ($param_parent_id !== false) {
            $conditions[] = 'parent_id = '. mysql_clean($param_parent_id);
        }
        if ($param_parent_only !== false) {
            $conditions[] = 'parent_id IS NULL ';
        }

        if( $param_condition ){
            $conditions[] = '(' . $param_condition . ')';
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

        if( $param_count ){
            $select = ['COUNT(category.category_id) AS count'];
        } else {
            $select = $this->getAllFields();
        }

        $join = [];
        $group = [];

        $sql ='SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table('categories') . ' '
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
     * @param $categ_type
     * @param $obj_id
     * @param array $new_vals
     * @return bool
     * @throws Exception
     */
    public function saveLinks($categ_type, $obj_id, array $new_vals): bool
    {
        if (!in_array($categ_type, $this->typeNamesByIds)) {
            e(lang('unknow_categ'));
            return false;
        }
        if (empty($new_vals)) {
            e(lang('unknow_categ'));
            return false;
        }
        $categ_table_name = $categ_type . 's_categories';
        $categ_id = 'id_' . $categ_type;

        Clipbucket_db::getInstance()->delete(tbl($categ_table_name),  [$categ_id], [$obj_id]);
        foreach ($new_vals as $new_val) {
            Clipbucket_db::getInstance()->insert(tbl($categ_table_name), ['id_category', $categ_id], [$new_val, $obj_id]);
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function update(array $param = [])
    {
        if (empty($param[$this->primary_key])) {
            e(lang('no_pk_provided'));
            return false;
        }
        $param_primary_key = $param[$this->primary_key] ?? false;
        $sets = [];
        foreach ($this->fields as $field) {
            if (isset($param[$field]) && $field != $this->primary_key) {
                $sets[] = $field . ' = \'' . mysql_clean($param[$field]) . '\'';
            }
        }
        if (empty($sets)) {
            e(lang('no_vals_provided'));
            return false;
        }

        $sql = 'UPDATE ' . cb_sql_table($this->tablename)
            . ' SET ' . implode(', ', $sets)
            . ' WHERE ' . $this->primary_key . ' = ' . mysql_clean($param_primary_key);

        Clipbucket_db::getInstance()->execute($sql);
        return true;
    }

    /**
     * @param array $param
     * @return bool|int
     * @throws Exception
     */
    public function insert(array $param = [])
    {
        foreach ($this->fields as $field) {
            if (isset($param[$field]) && $field != $this->primary_key) {
                $sets[] = $field . ' = \'' . mysql_clean($param[$field]).'\'';
            }
        }
        if (empty($sets)) {
            e(lang('no_vals_provided'));
            return false;
        }
        $sql = 'INSERT INTO ' . tbl($this->tablename)
            . ' SET ' . implode(', ', $sets);

        Clipbucket_db::getInstance()->execute($sql);
        return Clipbucket_db::getInstance()->insert_id();
    }

    /**
     * @throws Exception
     */
    public function delete($category_id)
    {
        $cat_details = $this->getById($category_id);
        if (!$cat_details) {
            e(lang('cat_exist_error'));
            return;
        }
        if ($cat_details['is_default'] == 'yes') { //Checking if category is default or not
            e(lang('cat_default_err'));
            return;
        }

        //si has child
        $childs = $this->getAll([
            'condition' => 'parent_id = \'' . mysql_clean($category_id) . '\''
        ]);
        if (!empty($childs)) {
            //deplacer
            //si a un parent => décaler vers parent sinon vers default
            $dest_category_id = (!empty($cat_details['parent_id']) ? $cat_details['parent_id'] : $this->getDefaultByType($this->typeNamesByIds[$cat_details['id_category_type']])['category_id']);
            //@TODO rework update for update all children with 1 request
            foreach ($childs as $child) {
                $this->update([
                    $this->primary_key => $child[$this->primary_key],
                    'parent_id' => $dest_category_id
                ]);
            }
        }

        //Removing Category
        Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl($this->tablename) . ' WHERE '. $this->primary_key .' = ' . mysql_clean($category_id));
        e(lang('class_cat_del_msg'), 'm');
    }

    /**
     * @param $category_id
     * @return array|false|int|mixed
     */
    public function getById($category_id)
    {
        return Category::getInstance()->getAll([
            'category_id'   => $category_id,
            'first_only'    => true
        ]);
    }

    public function getDefaultByType($type)
    {
        $categ_type_id = $this->getIdsCategoriesType($type);
        if (empty($categ_type_id)) {
            e(lang('unknow_categ'));
            return false;
        }
        return $this->getAll([
            'category_type' => $categ_type_id,
            'is_default'    => 'yes',
            'first_only'    => true
        ]);
    }

    /**
     * @param string $type
     * @param $category_id
     * @return false|void
     * @throws Exception
     */
    public function makeDefault(string $type, $category_id)
    {
        $categ_type_id = $this->getIdsCategoriesType($type);
        if (empty($categ_type_id)) {
            e(lang('unknow_categ'));
            return false;
        }
        if (!empty($this->getById($category_id))) {
            $sql = 'UPDATE ' . cb_sql_table($this->tablename) . ' SET is_default = \'no\' WHERE id_category_type = ' . mysql_clean($categ_type_id);
            Clipbucket_db::getInstance()->execute($sql);
            $sql = 'UPDATE ' . cb_sql_table($this->tablename) . ' SET is_default = \'yes\' WHERE category_id = ' . mysql_clean($category_id);
            Clipbucket_db::getInstance()->execute($sql);
            e(lang('cat_set_default_ok'), 'm');
        } else {
            e(lang('cat_exist_error'));
        }
    }

    /**
     * @param $category_id
     * @param $multi_level bool if returned array contain children which contain their children in 'children' case, false if all result in 1 level array
     * @param $only_id bool
     * @return array|false|int|mixed
     */
    public function getChildren($category_id, $multi_level = true,$only_id = false)
    {
        if (empty($category_id)) {
            return [];
        }
        $children = $this->getAll([
            'parent_id' => $category_id
        ]);
        if (empty($children)) {
            return [];
        } else {
            foreach ($children as &$child) {
                $children_of_child = $this->getChildren($child['category_id'], $multi_level, $only_id);
                if ($multi_level) {
                    $child['children'] = $children_of_child;
                } else {
                    $children = array_merge($children, $children_of_child);
                }
            }
        }
        if ($only_id) {
            $children = array_map(function ($elem){
                return $elem['category_id'];
            }, $children);
        }
        return $children;
    }

    public function getParent($category_id)
    {
        return $this->getAll([
            'parent_id'  => $category_id,
            'first_only' => true
        ]);
    }

    public function add_category_thumb($cid, $file)
    {
        global $imgObj;
        $category = $this->getById($cid);
        if (empty($category)) {
            return false;
        }
        //Checking for category thumbs directory
        $dir = $this->typeNamesByIds[$category['id_type_category']] . 's';

        //Checking File Extension
        $ext = getext($file['name']);

        if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
            e(lang('cat_img_error'));
            return false;
        }
        $dir_path = CAT_THUMB_DIR . DIRECTORY_SEPARATOR . $dir;
        if (!is_dir($dir_path)) {
            @mkdir($dir_path, 0777);
        }

        if (is_dir($dir_path)) {
            e(lang('cat_dir_make_err'));
            return false;
        }

        $path = $dir_path . DIRECTORY_SEPARATOR . $cid . '.' . $ext;

        //Removing File if already exists
        if (file_exists($path)) {
            unlink($path);
        }
        move_uploaded_file($file['tmp_name'], $path);

        //Now checking if file is really an image
        if (!@$imgObj->ValidateImage($path, $ext)) {
            e(lang('pic_upload_vali_err'));
            unlink($path);
        } else {
            $imgObj->CreateThumb($path, $path, $this->cat_thumb_width, $ext, $this->cat_thumb_height);
            Category::getInstance()->update([
                'category_id'    => $cid,
                'category_thumb' => $file['name']
            ]);
        }
        return true;
    }


}
abstract class CBCategory
{
    var $cat_tbl = ''; //Name of category Table
    var $section_tbl = ''; //Name of table that related to $cat_tbl
    var $use_sub_cats = false; // Set to true if you using Sub-Categories
    var $cat_thumb_height = '125';
    var $cat_thumb_width = '125';
    var $default_thumb = 'no_thumb.jpg';

    /**
     * Function used to check weather category exists or not
     *
     * @param $cid
     *
     * @return bool|array
     * @throws Exception
     */
    function category_exists($cid)
    {
        return !empty(Category::getInstance()->getById($cid));
    }

    /**
     * Function used to get category name
     *
     * @param $cid
     *
     * @return bool
     * @throws Exception
     */
    function get_category_name($cid)
    {
        global $db;
        $results = $db->select(tbl($this->cat_tbl), 'category_name', ' category_id=\'' . mysql_clean($cid) . '\' ');
        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to get category by name
     *
     * @param $name
     *
     * @return bool|array
     * @throws Exception
     */
    function get_cat_by_name($name)
    {
        global $db;
        $results = $db->select(tbl($this->cat_tbl), '*', ' category_name=\'' . mysql_clean($name) . '\' ');
        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to add new category
     *
     * @param $array
     * @throws Exception
     */
    function add_category($array)
    {
        global $db;
        $name = $array['name'];
        $desc = $array['desc'];
        $default = mysql_clean($array['default']);

        $flds = ['category_name', 'category_desc', 'date_added', 'category_thumb'];
        $values = [$name, $desc, now(), ''];

        if (!empty($this->use_sub_cats)) {
            $parent_id = mysql_clean($array['parent_cat']);
            $flds[] = 'parent_id';
            $values[] = $parent_id;
        }

        if ($this->get_cat_by_name($name)) {
            e(lang('add_cat_erro'));
        } else {
            if (empty($name)) {
                e(lang('add_cat_no_name_err'));
            } else {
                $cid = $db->insert(tbl($this->cat_tbl), $flds, $values);

                if ($default == 'yes' || !$this->get_default_category()) {
                    $this->make_default_category($cid);
                }

                if (!error()) {
                    e(lang('cat_add_msg'), 'm');
                }

                //Uploading thumb
                if (!empty($_FILES['cat_thumb']['tmp_name'])) {
                    $this->add_category_thumb($cid, $_FILES['cat_thumb']);
                }
            }
        }
    }

    /**
     * Function used to get list of categories
     * @throws Exception
     */
    function get_categories(): array
    {
        global $db;
        return $db->select(tbl($this->cat_tbl), '*', null, null, ' category_order ASC');
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function getCbCategories($params): array
    {
        global $db;
        $params['use_sub_cats'] = $params['use_sub_cats'] ?: 'yes';
        if ($this->use_sub_cats && config('use_subs') == 1 && $params['use_sub_cats'] == 'yes' &&
            ($params['type'] == 'videos' || $params['type'] == 'video' || $params['type'] == 'v')) {
            $cond = ' parent_id = 0';
            $subCategories = true;
        } else {
            $cond = null;
        }
        $orderby = $params['orderby'] = $params['orderby'] ?: 'category_order';
        $order = $params['order'] = $params['order'] ?: 'ASC';
        $limit = $params['limit'] = $params['limit'] ? (is_numeric($params['limit']) ? $params['limit'] : null) : null;

        $categories = $db->select(tbl($this->cat_tbl), '*', $cond, $limit, " $orderby $order");

        $finalArray = [];
        if ($params['with_all']) {
            $finalArray[] = ['category_id' => 'all', 'category_name' => lang('cat_all')];
        }

        foreach ($categories as $cat) {
            $finalArray[$cat['category_id']] = $cat;
            if ($subCategories === true && $this->is_parent($cat['category_id'])) {
                $finalArray[$cat['category_id']]['children'] = $this->getCbSubCategories($cat['category_id'], $params);
            }
        }

        return $finalArray;
    }

    /**
     * @throws Exception
     */
    function getCbSubCategories($category_id, $params)
    {
        global $db;
        if (empty($category_id)) {
            return false;
        }

        $orderby = $params['orderby'];
        $order = $params['order'];
        $finalOrder = $orderby . ' ' . $order;

        $limit = null;
        if ($params['limit_sub']) {
            if (is_numeric($params['limit_sub'])) {
                $limit = $params['limit_sub'];
            } elseif ($params['limit_sub'] == 'parent') {
                $limit = $params['limit'];
            }
        }

        if ($params['sub_order']) {
            $finalOrder = $params['sub_order'];
        }

        $subCats = $db->select(tbl($this->cat_tbl), '*', ' parent_id = \'' . $category_id . '\'', $limit, $finalOrder);
        if ($subCats) {
            $subArray = [];
            foreach ($subCats as $subCat) {
                $subArray[$subCat['category_id']] = $subCat;
                if ($this->is_parent($subCat['category_id'])) {
                    $subArray[$subCat['category_id']]['children'] = $this->getCbSubCategories($subCat['category_id'], $params);
                }
            }
            return $subArray;
        }
    }

    function displayOptions($catArray, $params, $spacer = ''): string
    {
        $html = '';
        foreach ($catArray as $cat) {
            if ($_GET['cat'] == $cat['category_id'] || ($params['selected'] && $params['selected'] == $cat['category_id'])) {
                $selected = ' selected=selected';
            } else {
                $selected = '';
            }
            if ($params['value'] == 'link') {
                $value = cblink(['name' => 'category', 'data' => $cat, 'type' => $params['type']]);
            } else {
                $value = $cat['category_id'];
            }

            $html .= "<option value='$value' $selected>";
            $html .= $spacer . display_clean($cat['category_name']);
            $html .= '</option>';

            if ($cat['children']) {
                $html .= $this->displayOptions($cat['children'], $params, $spacer . ($params['spacer'] ?: '- '));
            }
        }

        return $html;
    }

    function displayDropdownCategory($catArray, $params): string
    {
        $html = '';
        if ($params['name']) {
            $name = $params['name'];
        } else {
            $name = 'cat';
        }
        if ($params['id']) {
            $id = $params['id'];
        } else {
            $id = 'cat';
        }
        if ($params['class']) {
            $class = $params['class'];
        } else {
            $class = 'cbSelectCat';
        }

        $html .= "<select name='$name' id='$id' class='$class'>";
        if ($params['blank_option']) {
            $html .= "<option value='0'>None</option>";
        }
        $html .= $this->displayOptions($catArray, $params);
        $html .= '</select>';
        return $html;
    }

    function displayOutput($CatArray, $params)
    {
        if (is_array($CatArray)) {
            return $this->displayDropdownCategory($CatArray, $params);
        }
        return false;
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    function cbCategories($params = null)
    {
        $p = $params;
        $p['type'] = $p['type'] ?: 'video';
        $p['echo'] = $p['echo'] ?: false;
        $p['with_all'] = $p['with_all'] ?: false;

        $categories = $this->getCbCategories($p);

        if ($categories) {
            if ($p['echo'] == true) {
                $html = $this->displayOutput($categories, $p);
                if ($p['assign']) {
                    assign($p['assign'], $html);
                } else {
                    echo $html;
                }
            } else {
                if ($p['assign']) {
                    assign($p['assign'], $categories);
                } else {
                    return $categories;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * Function used to count total number of categories
     * @throws Exception
     */
    function total_categories()
    {
        global $db;
        return $db->count(tbl($this->cat_tbl), '*');
    }

    /**
     * Function used to get default category
     * @throws Exception
     */
    function get_default_category()
    {
        global $db;
        $results = $db->select(tbl($this->cat_tbl), '*', ' isdefault=\'yes\' ');
        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to edit category
     * submit values and it will update category
     *
     * @param $array
     * @throws Exception
     */
    function update_category($array)
    {
        global $db;
        $name = $array['name'];
        $desc = $array['desc'];
        $default = $array['default_categ'];
        $pcat = $array['parent_cat'];

        $flds = ['category_name', 'category_desc', 'isdefault'];
        if ($this->cat_tbl != 'user_categories') {
            $flds[] = 'parent_id';
        }

        $values = [$name, $desc, $default, $pcat];
        $cur_name = $array['cur_name'];
        $cid = mysql_clean($array['cid']);

        if ($this->get_cat_by_name($name) && $cur_name != $name) {
            e(lang('add_cat_erro'));
        } elseif (empty($name)) {
            e(lang('add_cat_no_name_err'));
        } elseif ($pcat == $cid) {
            e(lang('You can not make category parent of itself'));
        } else {
            $db->update(tbl($this->cat_tbl), $flds, $values, ' category_id=\'' . $cid . '\'');
            if ($default == lang('yes')) {
                $this->make_default_category($cid);
            }
            e(lang('cat_update_msg'), 'm');

            //Uploading thumb
            if (!empty($_FILES['cat_thumb']['tmp_name'])) {
                $this->add_category_thumb($cid, $_FILES['cat_thumb']);
            }
        }
    }


    /**
     * Function used to add category thumbnail
     *
     * @param $cid
     * @param $file
     *
     * @throws Exception
     * @internal param and $Cid Array
     */
    function add_category_thumb($cid, $file)
    {
        global $imgObj;
        if ($this->category_exists($cid)) {
            //Checking for category thumbs directory
            $dir = $this->thumb_dir ?? $this->section_tbl;

            //Checking File Extension
            $ext = getext($file['name']);

            if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
                $dir_path = DirPath::get('category_thumbs') . $dir;
                if (!is_dir($dir_path)) {
                    @mkdir($dir_path, 0777);
                }

                if (is_dir($dir_path)) {
                    $path = $dir_path . DIRECTORY_SEPARATOR . $cid . '.' . $ext;

                    //Removing File if already exists
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    move_uploaded_file($file['tmp_name'], $path);

                    //Now checking if file is really an image
                    if (!@$imgObj->ValidateImage($path, $ext)) {
                        e(lang('pic_upload_vali_err'));
                        unlink($path);
                    } else {
                        $imgObj->CreateThumb($path, $path, $this->cat_thumb_width, $ext, $this->cat_thumb_height, true);
                    }
                } else {
                    e(lang('cat_dir_make_err'));
                }
            } else {
                e(lang('cat_img_error'));
            }
        }
    }

    /**
     * Function used to get category thumb
     *
     * @param        $cat_details
     * @param string $dir
     *
     * @return string
     */
    function get_cat_thumb($cat_details, $dir = ''): string
    {
        $cid = $cat_details['category_id'];
        $path = DirPath::get('category_thumbs') . $dir . DIRECTORY_SEPARATOR . $cid . '.';
        $exts = ['jpg', 'png', 'gif'];

        $file_exists = false;
        foreach ($exts as $ext) {
            if (file_exists($path . $ext)) {
                $file_exists = true;
                break;
            }
        }

        if ($file_exists) {
            return DirPath::get('category_thumbs') . $dir . '/' . $cid . '.' . $ext;
        }
        return $this->default_thumb();
    }

    function get_category_thumb($i, $dir): string
    {
        return $this->get_cat_thumb($i, $dir);
    }

    /**
     * function used to return default thumb
     */
    function default_thumb(): string
    {
        if (empty($this->default_thumb)) {
            $this->default_thumb = 'no_thumb.jpg';
        }
        return DirPath::get('category_thumbs') . $this->default_thumb;
    }

    /**
     * Function used to update category id
     *
     * @param $id
     * @param $order
     * @throws Exception
     */
    function update_cat_order($id, $order)
    {
        $id = mysql_clean($id);

        global $db;
        $cat = $this->category_exists($id);
        if (!$cat) {
            e(lang('cat_exist_error'));
        } else {
            if (!is_numeric($order) || $order < 1) {
                $order = 1;
            }
            $db->update(tbl($this->cat_tbl), ['category_order'], [$order], ' category_id=\'' . mysql_clean($id) . '\'');
        }
    }


    /**
     * Function used to check category is parent or not
     *
     * @param $cid
     *
     * @return bool
     * @throws Exception
     */
    function is_parent($cid)
    {
        global $db;
        $result = $db->count(tbl($this->cat_tbl), 'category_id', ' parent_id = ' . mysql_clean($cid));

        if ($result > 0) {
            return true;
        }
        return false;
    }


    /**
     * Function used to get parent categories
     *
     * @param bool $count
     *
     * @return array|bool
     * @throws Exception
     */
    function get_parents($count = false)
    {
        global $db;

        if ($count) {
            return $db->count(tbl($this->cat_tbl), '*', ' parent_id = 0');
        }
        return $db->select(tbl($this->cat_tbl), '*', ' parent_id = 0');
    }

    /**
     * Function used to list categories in admin area
     * with indention
     *
     * @param $selected
     *
     * @return string
     * @throws Exception
     */
    function admin_area_cats($selected): string
    {
        $html = '';
        $pcats = $this->get_parents();

        if (!empty($pcats)) {
            foreach ($pcats as $pcat) {
                if ($selected == $pcat['category_id']) {
                    $select = 'selected=\'selected\'';
                } else {
                    $select = null;
                }

                $html .= '<option value=\'' . $pcat['category_id'] . '\' ' . $select . '>';
                $html .= $pcat['category_name'];
                $html .= '</option>';
                if ($this->is_parent($pcat['category_id'])) {
                    $html .= $this->get_sub_subs($pcat['category_id'], $selected);
                }
            }
        }
        return $html;
    }

    /**
     * Function used to get child categories
     *
     * @param $cid
     *
     * @return array|bool
     * @throws Exception
     */
    function get_sub_categories($cid)
    {
        global $db;
        $result = $db->select(tbl($this->cat_tbl), '*', ' parent_id = ' . (int)mysql_clean($cid));

        if ($result > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to get child child categories
     *
     * @param        $cid
     * @param        $selected
     * @param string $space
     *
     * @return string
     * @throws Exception
     */
    function get_sub_subs($cid, $selected, $space = '&nbsp; - '): string
    {
        $html = '';
        $subs = $this->get_sub_categories($cid);
        if (!empty($subs)) {
            foreach ($subs as $sub) {
                if ($selected == $sub['category_id']) {
                    $select = 'selected=\'selected\'';
                } else {
                    $select = null;
                }

                $html .= '<option value=\'' . $sub['category_id'] . '\' ' . $select . '>';
                $html .= $space . $sub['category_name'];
                $html .= '</option>';
                if ($this->is_parent($sub['category_id'])) {
                    $html .= $this->get_sub_subs($sub['category_id'], $selected, $space . ' - ');
                }
            }
        }
        return $html;
    }

    /**
     * @throws Exception
     */
    function get_category_field($cid, $field)
    {
        global $db;
        $result = $db->select(tbl($this->cat_tbl), $field, 'category_id =' . mysql_clean($cid));

        if ($result) {
            return $result[0][$field];
        }
        return false;
    }

    /**
     * Function used to get multiple category names
     *
     * @param $cid_array
     *
     * @return array
     * @throws Exception
     */
    function get_category_names($cid_array): array
    {
        $cat_name = [];
        $cid = explode(' ', $cid_array);
        $cid = array_slice($cid, 0, -1);
        foreach ($cid as $key => $value) {
            $cat_id = str_replace('#', '', $value);
            $results = $this->get_category($cat_id);
            $cat_name[] = $results;
        }
        return $cat_name;
    }

}
