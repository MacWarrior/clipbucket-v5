<?php
const THIS_PAGE = 'get_collection_update';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

User::getInstance()->hasPermissionAjax('allow_create_collection');

$type = $_POST['type'];
if (empty($type)) {
    e(lang('missing_params'));
} else {
    $sorts = SortType::getSortTypes($type);
    $fields = Collections::getInstance()->load_required_fields(['collection_id'=>$_POST['id']?:0, 'type'=>$type]);
    $form = new formObj();
    ob_start();
    $form->createField($fields['parent']);
    $select_html = ob_get_clean();
}

echo json_encode(['msg' => getTemplateMsg(), 'sort_types' => display_sort_lang_array($sorts), 'parents' => $select_html]);
