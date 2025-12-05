<?php
const THIS_PAGE = 'plugin';
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
        $file_path = DirPath::get('plugins') . $folder . DIRECTORY_SEPARATOR . $file;
    } else {
        $file_path = DirPath::get('player') . $folder . DIRECTORY_SEPARATOR . $file;
    }
    $plugin = Plugin::getInstance()->getAll([
        'plugin_folder' => $folder,
        'plugin_file'   => $file,
        'first_only'    => true
    ]);
    if (file_exists($file_path) && !empty($plugin) && $plugin['plugin_active'] == 'yes') {
        require_once($file_path);
        display_it();
        exit();
    }
}

header('location:plugin_manager.php?err=no_file');
