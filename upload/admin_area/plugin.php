<?php
define('THIS_PAGE', 'plugin');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('plugins_moderation', true);
pages::getInstance()->page_redir();

$file = get('file');
$folder = get('folder');
$player = get('player');

$folder = str_replace('..', '', $folder);
$file = str_replace('..', '', $file);
$player = str_replace('..', '', $player);

if ($folder && $file) {
    if (!$player) {
        $file = DirPath::get('plugins') . $folder . DIRECTORY_SEPARATOR . $file;
    } else {
        $file = DirPath::get('player') . $folder . DIRECTORY_SEPARATOR . $file;
    }

    if (file_exists($file)) {
        require_once($file);
        display_it();
        exit();
    }
}

header('location:plugin_manager.php?err=no_file');
