<?php
define("CB_CUSTOM_FIELDS_DIR_NAME", basename(dirname(__FILE__)));
define('CB_CUSTOM_FIELDS_PLUG_DIR', DirPath::get('plugins') . CB_CUSTOM_FIELDS_DIR_NAME);
define("SITE_MODE", '/admin_area');
define("CB_CUSTOM_FIELDS_EditPAGE_URL", SITE_MODE . "/plugin.php?folder=" . CB_CUSTOM_FIELDS_DIR_NAME . "/admin&file=edit_field.php");

assign("cb_custom_fields_edit_page", CB_CUSTOM_FIELDS_EditPAGE_URL);

/**
 * This function is used to add Custom field
 * @throws Exception
 */
function add_custom_file($field_name, $field_title, $field_type, $db_field, $default_value, $type_page, $date)
{
    Clipbucket_db::getInstance()->insert(tbl('custom_fields'), ["custom_field_name", "fcustom_field_title", "custom_field_type", "custom_db_field", "default_value", "customfields_flag", "date_added"], [$field_name, $field_title, $field_type, $db_field, $default_value, $type_page, $date]);
}

/**
 *This function is used to list custom fields on custom field plugin page for editing and deleting
 * @throws Exception
 */
function list_custom_field()
{
    $results = Clipbucket_db::getInstance()->select(tbl('custom_field'), '*', $limit, $order);
    foreach ($results as $value) {
        $list[] = $value;
    }
    return $list;
}

/**
 *This function is used to list specific custom field for editing purpose
 * @throws Exception
 */

function view_customfield_detail($field_id)
{
    $result = Clipbucket_db::getInstance()->select(tbl('custom_field'), "*", "custom_field_list_id='$field_id'");
    foreach ($result as $value) {
        $listdetail[] = $value;
    }
    return $listdetail;
}

/**
 *This function is used edit custom fields
 * @throws Exception
 */
function edit_field($field_name, $field_title, $field_type, $db_field, $default_value, $edit_id)
{
    $sql = "UPDATE " . tbl("custom_field") . " SET field_name= '" . $field_name . "',field_type='$field_type',field_title='$field_title',default_value='$default_value',db_field='$db_field' WHERE custom_field_list_id='" . $edit_id . "'";
    Clipbucket_db::getInstance()->execute($sql);
}

/**
 *Function for loading custom fields on video page
 * @throws Exception
 */
function load_custom_fields($data, $ck_display_admin = false, $ck_display_user = false)
{
    $results = Clipbucket_db::getInstance()->select(tbl("custom_field"), "*", "customfields_flag='video'");
    foreach ($results as $result) {
        $name = $result['field_name'];
        $type = $result['field_type'];
        $title = $result['field_title'];
        $value = $result['default_value'];
        $db_field = $result['db_field'];
        if ($type == 'dropdown') {
            $defaultselectvalue = explode(",", $value);

            $selectbuttonvalues = [];
            foreach ($defaultselectvalue as $key => $value) {
                $selectbuttonvalues[$value] = $value;
            }
            $array = [$name => ['title' => $title, 'type' => $type, 'value' => $selectbuttonvalues, 'name' => $name, 'id' => $name, 'db_field' => $db_field,]];
        } else {
            if ($type == 'radiobutton' || $type == 'checkbox') {
                $defaultradio = explode(",", $value);
                $radiobuttonvalues = [];
                foreach ($defaultradio as $key => $value) {
                    $radiobuttonvalues[$value] = $value;
                }
                $array = [$name => [
                    'title'     => $title,
                    'type'      => $type,
                    'name'      => $name,
                    'id'        => $name,
                    'value'     => $radiobuttonvalues,
                    'checked'   => $defaultradio[0],
                    'db_field'  => $db_field,
                    'auto_view' => 'no',
                    'sep'       => '&nbsp;'
                ]];
            } else {
                $array = [$name => ['title' => $title, 'type' => $type, 'name' => $name, 'id' => $name, 'db_field' => $db_field,]];
            }
        }
        foreach ($array as $key => $fields) {
            $new_array[$key] = $fields;
        }
    }
    return $new_array;
}

/**
 *Function for loading custom fields for signup page
 * @throws Exception
 */
//$data,$ck_display_admin=FALSE,$ck_display_user=FALSE
function load_custom_fields_signup()
{
    $results = Clipbucket_db::getInstance()->select(tbl("custom_field"), "*", "customfields_flag='signup'");
    foreach ($results as $result) {
        $name = $result['field_name'];
        $type = $result['field_type'];
        $title = $result['field_title'];
        $value = $result['default_value'];
        $db_field = $result['db_field'];
        if ($type == 'dropdown') {
            $defaultselectvalue = explode(",", $value);

            $selectbuttonvalues = [];
            foreach ($defaultselectvalue as $key => $value) {
                $selectbuttonvalues[$value] = $value;
            }
            $array = [$name => ['title' => $title, 'type' => $type, 'value' => $selectbuttonvalues, 'name' => $name, 'id' => $name, 'db_field' => $db_field,]];
        } else {
            if ($type == 'radiobutton' || $type == 'checkbox') {
                $defaultradio = explode(",", $value);
                $radiobuttonvalues = [];
                foreach ($defaultradio as $key => $value) {
                    $radiobuttonvalues[$value] = $value;
                }
                $array = [$name => [
                    'title'     => $title,
                    'type'      => $type,
                    'name'      => $name,
                    'id'        => $name,
                    'value'     => $radiobuttonvalues,
                    'checked'   => $defaultradio[0],
                    'db_field'  => $db_field,
                    'auto_view' => 'no',
                    'sep'       => '&nbsp;'
                ]];
            } else {
                $array = [$name => ['title' => $title, 'type' => $type, 'name' => $name, 'id' => $name, 'db_field' => $db_field,]];
            }
        }
        foreach ($array as $key => $fields) {
            $new_array[$key] = $fields;
        }
    }
    return $new_array;
}
