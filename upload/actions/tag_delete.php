<?php
define('THIS_PAGE', 'tag_delete');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$id_tag = $_POST['id_tag'];

Tags::deleteTag($id_tag);

echo json_encode(['msg' => getTemplateMsg(), 'id'=>$id_tag]);
