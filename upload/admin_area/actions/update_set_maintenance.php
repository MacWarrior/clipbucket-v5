<?php
const THIS_PAGE = 'update_set_maintenance';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

$return['success'] = !empty(myquery::getInstance()->Set_Website_Details('closed', 1));
$return['msg']= getTemplateMsg();
echo json_encode($return);