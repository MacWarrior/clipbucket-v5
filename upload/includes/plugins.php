<?php
//Getting Plugin Config Details

global $cbplugin, $userquery, $Cbucket;
$installed_plugins = $cbplugin->getInstalledPlugins();
if (!empty($installed_plugins)) {
    $plug_permission = $userquery->permission['plugins_perms'];
    $plug_permission = json_decode($plug_permission, true);

    foreach ($installed_plugins as $plugin) {
        $folder = '';
        if ($plugin['folder']) {
            $folder = '/' . $plugin['folder'];
        }
        $file = PLUG_DIR . $folder . DIRECTORY_SEPARATOR . $plugin['file'];

        $plugin_code = $plugin['file'] . $folder;

        //Creating plugin permissions array
        $Cbucket->plugins_perms[] = ['plugin_code' => $plugin_code,
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
if ($Cbucket->configs['player_file'] != '') {
    if ($Cbucket->configs['player_dir']) {
        $folder = '/' . $Cbucket->configs['player_dir'];
    }
    $file = PLAYER_DIR . $folder . DIRECTORY_SEPARATOR . $Cbucket->configs['player_file'];
    if (file_exists($file)) {
        include_once($file);
    }
}
