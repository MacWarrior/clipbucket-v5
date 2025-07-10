<?php
define('THIS_PAGE', 'admin_unflag_item');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

if (empty($_POST['type'])) {
    return false;
}
$type = $_POST['type'];
User::getInstance()->hasPermissionAjax(Flag::getPermissionByType($type));
if (empty($_POST['id_flag_type']) || empty($_POST['id_element'])) {
    sessionMessageHandler::add_message(lang('unknown'), 'e');
    return false;
}
if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '255')) {
    sessionMessageHandler::add_message(lang('must_update_version'), 'e');
}
foreach (Flag::getAll([
    'id_flag_type' => $_POST['id_flag_type'],
    'id_element'   => $_POST['id_element']
]) as $flag) {
    Flag::unFlag($flag['flag_id']);
}
sessionMessageHandler::add_message(lang('unflag_successful'), 'm');
