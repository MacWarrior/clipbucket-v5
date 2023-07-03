<?php
global $userquery, $myquery;

require_once '../includes/admin_config.php';

$userquery->admin_login_check();
$userquery->login_check('video_moderation');

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Notification settings', 'url' => ADMIN_BASEURL . '/notification_settings.php'];

$mode = $_GET['mode'];

if ($_POST['update_notification']) {
    $rows = ['notification_option'];

    foreach ($rows as $field) {
        $value = $_POST[$field];
        $myquery->Set_Website_Details($field, $value);
    }

    e('Notification Settings Have Been Updated', 'm');
    subtitle('Notification Settings');
}

subtitle('Notification Settings');
template_files('notification_settings.html');
display_it();
