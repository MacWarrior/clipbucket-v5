<?php
const THIS_PAGE = 'edit_announcement';
require_once dirname(__DIR__, 3) . '/includes/admin_config.php';

$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang(cb_global_announcement::$lang_prefix.'menu'), 'url' => cb_global_announcement::getInstance()->pages_url.'edit_announcement.php'];

pages::getInstance()->page_redir();

if (isset($_POST['update'])) {
    cb_global_announcement::update_announcement($_POST['text']);
    $msg = e(lang(cb_global_announcement::$lang_prefix.'updated'), 'm');
}

assign('announcement', cb_global_announcement::get_global_announcement(false));

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'summernote/summernote' . $min_suffixe . '.js' => 'libs'
]);
ClipBucket::getInstance()->addAdminCSS([
    'summernote/summernote' . $min_suffixe . '.css'     => 'libs'
]);

subtitle(lang(cb_global_announcement::$lang_prefix.'subtitle'));
template_files('edit_announcement.html', cb_global_announcement::getInstance()->template_dir);
display_it();
