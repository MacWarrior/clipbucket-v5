<?php
define('THIS_PAGE', 'ajax');
require_once '../includes/admin_config.php';
global $userquery;
$userquery->admin_login_check();

$id_tag = $_POST['id_tag'];

Tags::deleteTag($id_tag);

echo json_encode(['msg' => getTemplateMsg(), 'id'=>$id_tag]);
