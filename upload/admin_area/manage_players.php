<?php
define('THIS_PAGE', 'manage_players');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $Upload, $myquery, $cbplayer;

User::getInstance()->hasPermissionOrRedirect('admin_access', true);
pages::getInstance()->page_redir();

if( count($cbplayer->getPlayers()) <= 1 && !in_dev() ){
    redirect_to(DirPath::getUrl('admin_area'));
}

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title'=> lang('configurations'), 'url'=>''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('players'))), 'url' => DirPath::getUrl('admin_area') . 'manage_players.php'];

if ($_GET['set']) {
    $cbplayer->set_player($_GET);
}

subtitle('Manage Players');
template_files('manage_players.html');
display_it();
