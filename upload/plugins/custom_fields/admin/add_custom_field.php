<?php
	// TODO : Complete URL
	/* Generating breadcrumb */
	global $breadcrumb;
	$breadcrumb[0] = array('title' => 'Custom Field', 'url' => '');
	if (isset($_GET['custom_edit']))
		$breadcrumb[1] = array('title' => 'Edit Custom Field', 'url' => '');
	else
		$breadcrumb[1] = array('title' => 'Add Custom Field', 'url' => '');

    /*video fields inserted from here*/
    if (isset($_POST['submit']))
    {
        $data = $_POST;

        $inserted = push_custom_field($data);
        if ($inserted) {
            e("Custom Field has been inserted successfuly","m");
        } else {
            e("Something went wrong trying to insert custom field");
        }
    }

    if (isset($_POST['update_field'])) {
        update_cstm_field($_POST);
    }

    if (isset($_GET['custom_edit'])) {
        $cfield = $_GET['custom_edit'];
        $data = pull_custom_fields(false, $cfield);
        assign("field_to_edit", $data[0]);
    }

    if (isset($_GET['del_custom_field'])) {
        $dfield = $_GET['del_custom_field'];
        if (is_numeric($dfield)) {
            delete_custom_field($dfield);
            e("Successfuly deleted custom field with ID [".$dfield."]","m");
        } else {
            e("Unable to delete custom field with ID [".$dfield."]");
        }
    }

    $vcustom_fields = pull_custom_fields('video');
    assign("vcustom_fields",$vcustom_fields);
    $scustom_fields = pull_custom_fields('signup');
    assign("scustom_fields",$scustom_fields);
    $display_file = 'add_custom_field.html';
    if (isset($_GET['custom_edit'])) {
        $display_file = 'edit_field.html';
    }
    template_files($display_file,CUSTOM_FIELDS_ADMIN_DIR);
