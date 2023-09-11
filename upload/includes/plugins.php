<?php
/*
Simple Plugin System
@ Author :  Arslan
*/

//Getting Plugin Config Details

global $cbplugin, $userquery, $Cbucket;
$installed_plugins = $cbplugin->getInstalledPlugins();
if (!empty($installed_plugins)) {
    $plug_permission = $userquery->permission['plugins_perms'];
    $plug_permission = json_decode($plug_permission, true);

    foreach ($installed_plugins as $plugin) {
        $folder = "";
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

/**
 * Adding Inactive sign on vdeo
 */
function display_inactive_sign($vdo = [])
{
    if ($vdo['active'] == 'no') {
        echo '<div style="position:absolute;top:2px;height:13px;background-color:#ed0000;width:100%;color:#fff;font-size:10px;text-align:center;z-index:9999;">' . lang('vdo_inactive') . '</div>';
    }
}

function show_pending_alert($data = [])
{
    if ($data['active'] == 'pen') {
        $out = "<div style='position:absolute;text-align:center;top:0px;left:0px;width:100%;padding:2px 0;color:#FFF;background:#d40000;font:normal 10px Tahoma;z-index:9999;'>";
        $out .= "Video is pending";
        $out .= "</div>";

        echo $out;
    }
}

register_anchor_function('show_pending_alert', 'in_video_thumb');
register_anchor_function('display_inactive_sign', 'in_video_thumb');
