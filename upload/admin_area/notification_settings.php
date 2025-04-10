<?php
define('THIS_PAGE', 'notification_settings');

global $myquery;

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('admin_access', true);

if (
    !(config('videosSection')=='yes' && User::getInstance()->hasPermission('video_moderation'))
    && !(config('videosSection')=='yes' && User::getInstance()->hasPermission('video_moderation'))
    && !(config('videosSection')=='yes' && User::getInstance()->hasPermission('video_moderation'))
    && !(config('videosSection')=='yes' && User::getInstance()->hasPermission('video_moderation'))
) {
    redirect_to(DirPath::getUrl('root', true) . '403.php');
}
/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('notification_settings'), 'url' => DirPath::getUrl('admin_area') . 'notification_settings.php'];

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
