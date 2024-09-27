<?php
//Getting Plugin Config Details
$installed_plugins = CBPlugin::getInstance()->getInstalledPlugins();
if (!empty($installed_plugins)) {
    $plug_permission = userquery::getInstance()->permission['plugins_perms'];
    $plug_permission = json_decode($plug_permission, true);

    foreach ($installed_plugins as $plugin) {
        $folder = '';
        if ($plugin['folder']) {
            $folder = $plugin['folder'];
        }
        $file = DirPath::get('plugins') . $folder . DIRECTORY_SEPARATOR . $plugin['file'];

        $plugin_code = $plugin['file'] . $folder;

        //Creating plugin permissions array
        ClipBucket::getInstance()->plugins_perms[] = ['plugin_code' => $plugin_code,
                                     'plugin_name' => $plugin['name'], 'plugin_desc' => $plugin['description']];

        if (file_exists($file) && $plug_permission[$plugin_code] != 'no') {
            $pluginFile = $file;
            include_once($file);
        }
    }
}

/**
 * Include ClipBucket Player
 */
if (ClipBucket::getInstance()->configs['player_file'] != '') {
    if (ClipBucket::getInstance()->configs['player_dir']) {
        $folder = ClipBucket::getInstance()->configs['player_dir'];
    }
    $file = DirPath::get('player') . $folder . DIRECTORY_SEPARATOR . ClipBucket::getInstance()->configs['player_file'];
    if (file_exists($file)) {
        include_once($file);
    }
}
