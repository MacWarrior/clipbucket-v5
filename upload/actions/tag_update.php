<?php
define('THIS_PAGE', 'tag_update');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$id_tag = $_POST['id_tag'];
$tag = $_POST['tag'];

$success = Tags::updateTag($tag, $id_tag);

echo json_encode(['msg' => getTemplateMsg(), 'id'=>$id_tag, 'success'=>$success]);
