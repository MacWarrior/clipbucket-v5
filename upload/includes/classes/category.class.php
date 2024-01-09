<?php

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
        return $this->get_category($cid);
    }

    /**
     * Function used to get category details
     *
     * @param $cid
     *
     * @return bool|array
     * @throws Exception
     */
    function get_category($cid)
    {
        global $db;
        $results = $db->select(tbl($this->cat_tbl), '*', ' category_id=\'' . mysql_clean($cid) . '\' ');
        if (count($results) > 0) {
            return $results[0];
        }
        return false;
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
     * Function used to make category as default
     *
     * @param $cid
     * @throws Exception
     */
    function make_default_category($cid)
    {
        global $db;
        if ($this->category_exists($cid)) {
            $db->update(tbl($this->cat_tbl), ['isdefault'], ['no'], ' isdefault=\'yes\' ');
            $db->update(tbl($this->cat_tbl), ['isdefault'], ['yes'], ' category_id=\'' . mysql_clean($cid) . '\' ');
            e(lang('cat_set_default_ok'), 'm');
        } else {
            e(lang('cat_exist_error'));
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
     * Function used to delete category
     *
     * @param $cid
     * @throws Exception
     */
    function delete_category($cid)
    {
        global $db;
        $cat_details = $this->category_exists($cid);
        if (!$cat_details) {
            e(lang('cat_exist_error'));
            return;
        }
        if ($cat_details['isdefault'] == 'yes') { //Checking if category is default or not
            e(lang('cat_default_err'));
            return;
        }

        if ($this->cat_tbl = 'user_categories') {
            $has_child = false;
            $to = $this->get_default_category()['category_id'];
        } else {
            $parent_category = $this->has_parent($cid, true);

            if ($parent_category) {
                if ($this->is_parent($cid)) {
                    $to = $parent_category[0]['category_id'];
                    $has_child = true;
                } else { //Checking if category is only child
                    $to = $parent_category[0]['category_id'];
                    $has_child = true;
                }
            } else {
                if ($this->is_parent($cid)) { //Checking if category is only parent
                    $to = null;
                    $has_child = false;
                    $db->update(tbl($this->cat_tbl), ['parent_id'], ['0'], ' parent_id = ' . mysql_clean($cid));
                }
            }
        }

        //Moving all contents to parent OR default category
        $this->change_category($cid, $to, $has_child);

        //Removing Category
        $db->execute('DELETE FROM ' . tbl($this->cat_tbl) . ' WHERE category_id=' . mysql_clean($cid));
        e(lang('class_cat_del_msg'), 'm');
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
     * Function used to get default category ID
     */
    function get_default_cid()
    {
        $default = $this->get_default_category();
        return $default['category_id'];
    }

    /**
     * Function used to move contents from one section to other
     *
     * @param      $from
     * @param null $to
     * @param null $has_child
     * @throws Exception
     */
    function change_category($from, $to = null, $has_child = null)
    {
        global $db;

        if (!$this->category_exists($to)) {
            $to = $this->get_default_cid();
        }

        if ($has_child) {
            $db->update(tbl($this->cat_tbl), ['parent_id'], [$to], ' parent_id = ' . $from);
        }

        if (!empty($this->section_tbl)) {
            $db->execute('UPDATE ' . tbl($this->section_tbl) . ' SET category = replace(category,\'#' . $from . '#\',\'#' . $to . '#\') WHERE category LIKE \'%#' . $from . '#%\'');
            $db->execute('UPDATE ' . tbl($this->section_tbl) . ' SET category = replace(category,\'#' . $to . '# #' . $to . '#\',\'#' . $to . '#\') WHERE category LIKE \'%#' . $to . '#%\'');
        }
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
     * Function used get parent category
     *
     * @param $pid
     *
     * @return array|bool
     * @throws Exception
     */
    function get_parent_category($pid)
    {
        global $db;
        $result = $db->select(tbl($this->cat_tbl), '*', ' category_id = ' . mysql_clean($pid));
        if (count($result) > 0) {
            return $result;
        }
        return false;
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
     * Function used to check wheather category has parent or not
     *
     * @param      $cid
     * @param bool $return_parent
     *
     * @return array|bool
     * @throws Exception
     */
    function has_parent($cid, $return_parent = false)
    {
        global $db;
        $result = $db->select(tbl($this->cat_tbl), '*', ' category_id = ' . mysql_clean($cid) . ' AND parent_id != 0');

        if (is_array($result) && count($result) > 0) {
            if ($return_parent) {
                return $this->get_parent_category($result[0]['parent_id']);
            }
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
