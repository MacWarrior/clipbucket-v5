<?php
/**
 * Lists all of custom fields by name
 * @return array : { array } { $flds } { an array with fields }
 * @throws \Exception
 */
function custom_fields_list()
{
    $raw_flds = Clipbucket_db::getInstance()->select(tbl("custom_fields"), 'custom_field_name', 'custom_field_list_id != 0');
    $flds = [];
    foreach ($raw_flds as $key => $name) {
        $flds[] = $name['custom_field_name'];
    }
    return $flds;
}

function push_custom_field($data = false)
{
    if (!is_array($data)) {
        $data = $_POST;
    }

    $name = str_replace(" ", "_", $data['fieldname']);
    $label = $data['fieldtitle'];
    $type = $data['type'];
    $df_val = $data['default_value'];
    $ptype = $data['section_type'];
    $flds = ['custom_field_name', 'custom_field_title', 'custom_field_type', 'custom_field_value', 'custom_field_ptype'];
    $vals = [$name, $label, $type, $df_val, $ptype];
    $insert_id = Clipbucket_db::getInstance()->insert(tbl("custom_fields"), $flds, $vals);
    if ($insert_id) {
        if ($ptype == 'video') {
            $table = 'video';
        } else {
            $table = 'users';
        }
        Clipbucket_db::getInstance()->execute("ALTER TABLE " . tbl($table) . " ADD `cfld_" . $name . "` varchar(255) NOT NULL");
        return $insert_id;
    }
    return false;
}

function pull_custom_fields($type = false, $id = false)
{
    if ($type) {
        $cond = "custom_field_ptype = '$type'";
    }
    if ($id) {
        $cond = "custom_field_list_id = '$id'";
        if ($type) {
            $cond .= " AND custom_field_ptype = '$type'";
        }
    }
    $raw_pull = Clipbucket_db::getInstance()->select(tbl("custom_fields"), "custom_field_list_id,custom_field_title,custom_field_type,custom_field_ptype,custom_field_name,custom_field_value,custom_field_required", $cond);
    if (is_array($raw_pull)) {
        return $raw_pull;
    }
    return false;
}

function update_cstm_field($data = false, $id = false)
{
    if (!is_array($data)) {
        $data = $_POST;
    }
    if (!$id) {
        $id = $_GET['custom_edit'];
    }
    $name = $data['field_name'];
    $label = $data['field_title'];
    $db_field = $data['db_field'];
    $type = $data['field_type'];

    $flds = ['custom_field_name', 'custom_field_title', 'custom_field_db_field', 'custom_field_type'];
    $vals = [$name, $label, $db_field, $type];
    Clipbucket_db::getInstance()->update(tbl("custom_fields"), $flds, $vals, "custom_field_list_id = '$id'");
}

function delete_custom_field($fid)
{
    $file_data = pull_custom_fields(false, $fid);
    $type = $file_data[0]['custom_field_ptype'];
    $name = $file_data[0]['custom_field_name'];
    if ($type == 'video') {
        $table = 'video';
    } else {
        $table = 'users';
    }
    Clipbucket_db::getInstance()->execute("ALTER TABLE " . tbl($table) . " DROP `cfld_" . $name . "` varchar(255) NOT NULL");
    Clipbucket_db::getInstance()->delete(tbl('custom_fields'), ['custom_field_list_id'], [$fid]);
}

/**
 * Function used to add custom field in upload form
 */
function add_custom_field($array)
{
    foreach ($array as $key => $attr) {
        if ($key == 'name' || $key == 'title') {
            if (empty($attr)) {
                e(lang('cust_field_err', $key));
            }
        }

        if (!error_list()) {
            if (!empty($attr)) {
                $fields_array[] = 'custom_field_' . $key;
                $value_array[] = mysql_clean($attr);
            }

            if ($key == 'db_field') {
                Clipbucket_db::getInstance()->execute("ALTER TABLE " . tbl('video') . " ADD `" . $attr . "` TEXT NOT NULL");
            }
        }

    }

    if (!error_list()) {
        Clipbucket_db::getInstance()->insert(tbl("custom_fields"), $fields_array, $value_array);
    }
}


/**
 * Function used add fields in upload form
 */
function load_form_fields()
{
    $results = Clipbucket_db::getInstance()->select(tbl("custom_fields"), "*");
    if (count($results[0]) > 0) {
        foreach ($results as $result) {
            $name = $result['custom_field_name'];
            foreach ($result as $field => $value) {
                $field_array[$name][substr($field, 13, strlen($field))] = $value;
            }
        }
    }

    if (count($field_array) > 0) {
        return false;
    }
    return $field_array;
}
