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
    
    template_files('add_custom_field.html',CUSTOM_FIELDS_ADMIN_DIR);

?>