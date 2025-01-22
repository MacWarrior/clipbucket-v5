<?php
define('THIS_PAGE', 'admin_import_tmdb');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

$right = 'admin_access';
if (empty($_POST['type'])) {
  return false;
}
$type = $_POST['type'] ;
User::getInstance()->hasPermissionAjax(Flag::getPermissionByType($type));
if (empty($_POST['id_flag_type']) || empty($_POST['id_element'])) {
    sessionMessageHandler::add_message(lang('unknown'), 'e');
    return false;
}
switch ($type) {
    case 'video':
        CBvideo::getInstance()->action('activate',$_POST['element_id']);
        break;
    case 'photo':
        CBPhotos::getInstance()->photo_actions('activate',$_POST['element_id']);
        break;
    case 'collection':
        Collections::getInstance()->collection_actions('activate',$_POST['element_id']);
        break;
    case 'user':
        userquery::getInstance()->action('activate', $_POST['element_id']);
        break;
    default:
}
foreach (Flag::getAll([
    'id_flag_type' => $_POST['id_flag_type'],
    'id_element'   => $_POST['id_element']
]) as $flag) {
    Flag::unFlag($flag['flag_id']);
}
sessionMessageHandler::add_message(lang('unflag_successful'), 'm');

