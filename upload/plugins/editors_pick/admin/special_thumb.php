<?php
require_once '../../../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
$breadcrumb[0] = array('title' => 'Plugin Manager', 'url' => '');
$breadcrumb[1] = array('title' => 'Editor\'s Pick', 'url' => PLUG_URL.'/editors_pick/admin/special_thumb.php');

$vid = $_GET['vid'];

assign("ep_ajax_url",PLUG_URL.'/editors_pick/admin/ajax.php');

subtitle("Editor's Pick");
template_files('../templates/admin/special_thumb.html');
display_it();
