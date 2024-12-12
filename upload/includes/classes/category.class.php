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

    /**
     * @throws Exception
     */
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
        $this->typeNamesByIds = array_column($this->getAllCategoryTypes(), 'name', 'id_category_type');
    }

    public static function getInstance(): self
    {
        if( empty(self::$category) ){
            self::$category = new self();
        }
        return self::$category;
    }

    private function getAllFields(): array
    {
        return array_map(function($field) {
            return $this->tablename . '.' . $field;
        }, $this->fields);
    }

    /**
     * @throws Exception
     */
    public function getAll(array $params = [])
    {
        $param_category_id = $params['category_id'] ?? false;
        $param_category_type = $params['category_type'] ?? false;
        $param_category_default = $params['category_default'] ?? false;
        $param_parent_id = $params['parent_id'] ?? false;
        $param_parent_only = $params['parent_only'] ?? false;

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
            $select = ['COUNT(DISTINCT category.category_id) AS count'];
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
     * @param string $name
     * @return array|false|int|string
     */
    public function getIdsCategoriesType(string $name = '')
    {
        if (!empty($name)) {
            return array_search($name, $this->typeNamesByIds);
        }
        return $this->typeNamesByIds;
    }

    /**
     * @throws Exception
     */
    private function getAllCategoryTypes(): array
    {
        return Clipbucket_db::getInstance()->_select('SELECT id_category_type, name FROM ' . cb_sql_table('categories_type'));
    }

    private function getTypeTableName(string $categ_type): string
    {
        return $categ_type . 's_categories';
    }

    private function getTypeTableID(string $categ_type): string
    {
        return 'id_' . $categ_type;
    }

    /**
     * @throws Exception
     */
    public function unlinkAll(string $categ_type, int $obj_id)
    {
        $categ_table_name = $this->getTypeTableName($categ_type);
        $categ_id = $this->getTypeTableID($categ_type);
        Clipbucket_db::getInstance()->delete(tbl($categ_table_name),  [$categ_id], [$obj_id]);
    }

    /**
     * @throws Exception
     */
    public function link(string $categ_type, int $obj_id, int $id_category)
    {
        $categ_table_name = $this->getTypeTableName($categ_type);
        $categ_id = $this->getTypeTableID($categ_type);
        Clipbucket_db::getInstance()->insert(tbl($categ_table_name), ['id_category', $categ_id], [$id_category, $obj_id]);
    }

    /**
     * @param string $categ_type
     * @param int $obj_id
     * @param array $categories
     * @return bool
     * @throws Exception
     */
    public function saveLinks(string $categ_type, int $obj_id, array $categories): bool
    {
        if (!in_array($categ_type, $this->typeNamesByIds)) {
            e(lang('category_type_unknown', $categ_type));
            return false;
        }

        $this->unlinkAll($categ_type, $obj_id);

        foreach ($categories as $category_id) {
            $this->link($categ_type, $obj_id, $category_id);
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function update(array $param = []): bool
    {
        if (empty($param[$this->primary_key])) {
            e(lang('technical_error'));
            return false;
        }
        $param_primary_key = $param[$this->primary_key] ?? false;
        $sets = $this->setSQLValues($param);
        if (empty($sets)) {
            e(lang('technical_error'));
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
        $sets = $this->setSQLValues($param);
        if (empty($sets)) {
            e(lang('technical_error'));
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
     * @throws Exception
     */
    public function getById($category_id)
    {
        return Category::getInstance()->getAll([
            'category_id'   => $category_id,
            'first_only'    => true
        ]);
    }

    /**
     * @throws Exception
     */
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
     * @throws Exception
     */
    public function validate($array): bool
    {
        if ($array == null) {
            $array = $_POST['category'];
        }

        if (!is_array($array)) {
            return false;
        }

        if (count($array) == 0) {
            return false;
        }

        $new_array = [];
        foreach ($array as $arr) {
            if (!empty(Category::getInstance()->getById($arr))) {
                $new_array[] = $arr;
            }
        }

        if (count($new_array) == 0) {
            e(lang('vdo_cat_err3'));
            return false;
        }

        if (count($new_array) > config('video_categories')) {
            e(lang('vdo_cat_err2', config('video_categories')));
            return false;
        }

        return true;    }

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
     * @param int $category_id
     * @param $only_id bool
     * @return array|false|int|mixed
     * @throws Exception
     */
    public function getChildren(int $category_id, bool $only_id = false): array
    {
        if (empty($category_id)) {
            return [];
        }
        $children = $this->getAll([
            'parent_id' => $category_id
        ]);
        if (empty($children)) {
            return [];
        }
        $children_to_add=[];
        foreach ($children as &$child) {
            if ($only_id && is_array($child)) {
                $child = $child['category_id'];
            }
            $children_of_child = $this->getChildren((is_array($child) ? $child['category_id'] : $child), $only_id);
            if ($only_id) {
                foreach ($children_of_child as $child_of_child) {
                    $children_to_add[]= $child_of_child;
                }
            } else {
                $child['children'] = $children_of_child;
            }
        }


        return array_merge($children, $children_to_add);
    }

    /**
     * @throws Exception
     */
    public function getParent($category_id)
    {
        return $this->getAll([
            'parent_id'  => $category_id,
            'first_only' => true
        ]);
    }

    /**
     * @throws Exception
     */
    public function add_category_thumb($cid, $file): bool
    {
        global $imgObj;
        $category = $this->getById($cid);
        if (empty($category)) {
            return false;
        }
        //Checking for category thumbs directory
        $dir = $this->typeNamesByIds[$category['id_category_type']];

        //Checking File Extension
        $ext = getext($file['name']);

        $types = strtolower(config('allowed_photo_types'));
        $supported_extensions = explode(',', $types);
        if (!in_array($ext, $supported_extensions)) {
             e(lang('error_allow_photo_types', implode(', ', $supported_extensions)));
            return false;
        }

        $dir_path = DirPath::get('category_thumbs') . $dir . DIRECTORY_SEPARATOR;
        if (!is_dir($dir_path)) {
            @mkdir($dir_path, 0777);
        }
        if (!is_dir($dir_path)) {
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

    /**
     * @param array $param
     * @return array
     */
    private function setSQLValues(array $param): array
    {
        $sets = [];
        foreach ($this->fields as $field) {
            if (isset($param[$field]) && $field != $this->primary_key) {
                if ($field == 'parent_id' && (int)$param[$field] === 0) {
                    $sets[] = $field . ' = NULL';
                } else {
                    $sets[] = $field . ' = \'' . mysql_clean($param[$field]) . '\'';
                }
            }
        }
        return $sets;
    }

    /**
     * @param $type
     * @param $parent_id
     * @return int|mixed
     * @throws Exception
     */
    public function getNextOrderForParent($type, $parent_id): int
    {
        $categ_type_id = $this->getIdsCategoriesType($type);
        $sql = 'SELECT MAX(category_order) + 1 AS next_order_place FROM ' . tbl($this->tablename) . ' 
        WHERE id_category_type = ' . mysql_clean($categ_type_id) . ' AND parent_id ' . ((empty($parent_id) || $parent_id == 'null') ? ' IS NULL ' : ' = ' . mysql_clean($parent_id));
        $results = Clipbucket_db::getInstance()->_select($sql);
        if (!empty($results[0]['next_order_place'])) {
            return $results[0]['next_order_place'];
        }
        return 0;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getTypeNamesByIds($key)
    {
        return $this->typeNamesByIds[$key];
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
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function getCbCategories($params): array
    {
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

        $categories = Clipbucket_db::getInstance()->select(tbl($this->cat_tbl), '*', $cond, $limit, " $orderby $order");

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

        $subCats = Clipbucket_db::getInstance()->select(tbl($this->cat_tbl), '*', ' parent_id = \'' . $category_id . '\'', $limit, $finalOrder);
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
            return DirPath::getUrl('category_thumbs') . $dir . '/' . $cid . '.' . $ext;
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
        return DirPath::getUrl('images') . $this->default_thumb;
    }

    /**
     * Function used to check category is parent or not
     *
     * @param $cid
     *
     * @return bool
     * @throws Exception
     */
    function is_parent($cid): bool
    {
        $result = Clipbucket_db::getInstance()->count(tbl($this->cat_tbl), 'category_id', ' parent_id = ' . mysql_clean($cid));

        if ($result > 0) {
            return true;
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
