<?php
define('THIS_PAGE', 'admin_delete_flagged_item');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

$right = 'admin_access';
if (empty($_POST['type'])) {
  return false;
}
$type = $_POST['type'] ;
User::getInstance()->hasPermissionAjax(Flag::getPermissionByType($type));
if (empty($_POST['id_element'])) {
    sessionMessageHandler::add_message(lang('unknown'), 'e');
    return false;
}
switch ($type) {
    case 'video':
        CBvideo::getInstance()->delete_video($_POST['id_element']);
        break;
    case 'photo':
        CBPhotos::getInstance()->delete_photo($_POST['id_element']);
        break;
    case 'collection':
        Collections::getInstance()->delete_collection($_POST['id_element']);
        break;
    case 'user':
        userquery::getInstance()->delete_user($_POST['id_element']);
        break;
    case 'playlist':
        CBvideo::getInstance()->action->delete_playlist($_POST['id_element']);
        break;
}
sessionMessageHandler::add_message(lang('unflag_successful'));
