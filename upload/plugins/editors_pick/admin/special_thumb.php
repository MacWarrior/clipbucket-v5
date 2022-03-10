<?php
require_once '../../../includes/admin_config.php';

global $userquery,$pages;

$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
$breadcrumb[0] = ['title' => 'Plugin Manager', 'url' => ''];
$breadcrumb[1] = ['title' => lang('plugin_editors_picks'), 'url' => PLUG_URL.'/editors_pick/admin/special_thumb.php'];

$vid = $_GET['vid'];

assign('ep_ajax_url',PLUG_URL.'/editors_pick/admin/ajax.php');

subtitle(lang('plugin_editors_picks'));
template_files('../templates/admin/special_thumb.html');
display_it();
