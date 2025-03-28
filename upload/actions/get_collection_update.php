<?php
define('THIS_PAGE', 'get_collection_update');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

User::getInstance()->hasPermissionAjax('allow_create_collection');

$type = $_POST['type'];
if (empty($type)) {
    e(lang('missing_params'));
} else {
    $sorts = SortType::getSortTypes($type);
    $parents = Collection::getInstance()->getAvailableParents($_POST['id']?:0, $type);
}

echo json_encode(['msg' => getTemplateMsg(), 'sort_types' => display_sort_lang_array($sorts), 'parents' => $parents]);
