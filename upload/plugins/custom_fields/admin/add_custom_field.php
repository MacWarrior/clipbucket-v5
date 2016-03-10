<?php
    /* Assigning page and subpage */
    if(!defined('MAIN_PAGE')){
        define('MAIN_PAGE', 'Custom Field');
    }
    if(!defined('SUB_PAGE')){
        define('SUB_PAGE', 'Custom Field');
    }
    /*video fields inserted from here*/
    if (isset($_POST['submit'])) {
        $data = $_POST;
        $inserted = push_custom_field($data);
        if ($inserted) {
            e("Custom Field has been inserted successfuly","m");
        } else {
            e("Something went wrong trying to insert custom field");
        }
    }

    if (isset($_POST['update_field'])) {
        pr($_POST,true);
    }

    if (isset($_GET['custom_edit'])) {
        $cfield = $_GET['custom_edit'];
        $data = pull_custom_fields(false, $cfield);
        assign("field_to_edit", $data[0]);
    }

    $custom_fields = pull_custom_fields();
    assign("custom_fields",$custom_fields);
    template_files('edit_field.html',CUSTOM_FIELDS_ADMIN_DIR);

?>