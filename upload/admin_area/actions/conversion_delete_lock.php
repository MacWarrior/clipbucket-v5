<?php
const THIS_PAGE = 'conversion_delete_lock';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!User::getInstance()->hasPermission('advanced_settings')) {
    e(lang('you_dont_hv_perms'));
    echo json_encode(['msg' => getTemplateMsg()]);
    die;
}

FFMpeg::unlockAll();
e(lang('all_locks_deleted'),'m');

echo json_encode(['msg' => getTemplateMsg(), 'lang_title'=>lang('no_lock_to_delete')]);
die;