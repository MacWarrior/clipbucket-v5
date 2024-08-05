<?php
define('THIS_PAGE', 'ajax');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $userquery;
$userquery->admin_login_check();

$id_tag = $_POST['id_tag'];
$tag = $_POST['tag'];

$success = Tags::updateTag($tag, $id_tag);

echo json_encode(['msg' => getTemplateMsg(), 'id'=>$id_tag, 'success'=>$success]);
