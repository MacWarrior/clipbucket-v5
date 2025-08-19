<?php
const THIS_PAGE = 'tag_delete';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

$id_tag = $_POST['id_tag'];

Tags::deleteTag($id_tag);

echo json_encode(['msg' => getTemplateMsg(), 'id'=>$id_tag]);
