<?php
define('THIS_PAGE', 'add_to_collection');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

$type = $_POST['type'];
$cid = $_POST['cid'];
$id = $_POST['obj_id'];
if (!user_id()) {
    e(lang('you_not_logged_in'));
} elseif (empty($type) || empty($cid) || empty($id)) {
    e(lang('missing_params'));
} else {
    Collection::getInstance()->addCollectionItem($id, $cid, $type);
}

echo json_encode(['msg' => getTemplateMsg()]);
