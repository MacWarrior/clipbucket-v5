<?php
require_once dirname(__DIR__, 2) . '/includes/admin_config.php';

global $userquery, $pages, $db;

$breadcrumb[0] = ['title' => 'Plugin Manager', 'url' => ''];
$breadcrumb[1] = ['title' => lang('plugin_global_announcement'), 'url' => PLUG_URL . '/global_announcement/edit_announcement.php'];

$userquery->admin_login_check();
$userquery->login_check('admin_access');
$pages->page_redir();

if (isset($_POST['update'])) {
    update_announcement($_POST['text']);
    $msg = e(lang('plugin_global_announcement_updated'), 'm');
}

$ann_array = $db->_select('SELECT * FROM ' . tbl('global_announcement'));

if (is_array($ann_array)) {
    assign('announcement', $ann_array[0]['announcement']);
} else {
    assign('announcement', '');
}

subtitle(lang('plugin_global_announcement_subtitle'));
template_files('edit_announcement.html');
display_it();
