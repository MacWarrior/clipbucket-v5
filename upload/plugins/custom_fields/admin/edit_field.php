<?php
// TODO : Complete URL
/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Custom Field', 'url' => ''];
$breadcrumb[1] = ['title' => 'Edit Custom Field', 'url' => ''];

if (isset($_GET['edit_customfield'])) {
    $id = $_GET['edit_customfield'];
    $listing_custom = view_customfield_detail($id);
    assign('listing_custom', $listing_custom);
}
if (isset($_POST['update_field'])) {
    $edit_id = $_POST['field_id'];
    $field_name = $_POST['field_name'];
    $field_type = $_POST['field_type'];
    $field_title = $_POST['field_title'];
    $default_value = $_POST['default_value'];
    $olddbfield_name = $_POST['olddbfield_name'];
    $db_field = $_POST['db_field'];
    $page_type = $_POST['page_type'];
    edit_field($field_name, $field_title, $field_type, $db_field, $default_value, $edit_id);
    if ($page_type == 'signup') {
        Clipbucket_db::getInstance()->execute("ALTER TABLE " . tbl('users') . " CHANGE $olddbfield_name $db_field TEXT NOT NULL");
    } else {
        Clipbucket_db::getInstance()->execute("ALTER TABLE " . tbl('video') . " CHANGE $olddbfield_name $db_field TEXT NOT NULL");
    }
    //ALTER TABLE cb_video CHANGE Addr myaddress TEXT NOT NULL
    e(lang("Custom field Update successfully"), "m");
}

template_files('edit_field.html', CB_CUSTOM_FIELDS_PLUG_DIR . '/admin');
