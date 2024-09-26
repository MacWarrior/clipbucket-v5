<?php
define('THIS_PAGE', 'plugin_manager');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $cbplugin;

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('plugins'))), 'url' => DirPath::getUrl('admin_area') . 'plugin_manager.php'];

//uninstalling Plugin
if (isset($_GET['uninstall'])) {
    $folder = $_GET['f'];
    $cbplugin->uninstallPlugin(mysql_clean($_GET['uninstall']), $folder);
    CacheRedis::flushAll();
}

/**
 * Uninstalling Multiple Plugins
 */
if (isset($_POST['uninstall_selected']) && is_array($_POST['check_plugin'])) {
    $plugs = count($_POST['check_plugin']);
    for ($i = 0; $i < $plugs; $i++) {
        $itr = $_POST['check_plugin'][$i];
        $cbplugin->uninstallPlugin($_POST['plugin_file_' . $itr], $_POST['plugin_folder_' . $itr]);
    }
    CacheRedis::flushAll();
}

//Activation or deactivating plugin
if (isset($_GET['activate'])) {
    $folder = $_GET['f'];
    $id = mysql_clean($_GET['activate']);
    $msg = $cbplugin->pluginActive($id, 'yes', $folder);
    CacheRedis::flushAll();
}

/**
 * Activating Multiple
 */
if (isset($_POST['activate_selected']) && is_array($_POST['check_plugin'])) {
    $plugs = count($_POST['check_plugin']);
    for ($i = 0; $i < $plugs; $i++) {
        $itr = $_POST['check_plugin'][$i];
        $cbplugin->pluginActive($_POST['plugin_file_' . $itr], 'yes', $_POST['plugin_folder_' . $itr]);
    }
    CacheRedis::flushAll();
}

if (isset($_GET['deactivate'])) {
    $folder = $_GET['f'];
    $id = mysql_clean($_GET['deactivate']);
    $msg = $cbplugin->pluginActive($id, 'no', $folder);
    CacheRedis::flushAll();
}

/**
 * deactivating Multiple
 */
if (isset($_POST['deactivate_selected']) && is_array($_POST['check_plugin'])) {
    $plugs = count($_POST['check_plugin']);
    for ($i = 0; $i < $plugs; $i++) {
        $itr = $_POST['check_plugin'][$i];
        $cbplugin->pluginActive($_POST['plugin_file_' . $itr], 'no', $_POST['plugin_folder_' . $itr]);
    }
    CacheRedis::flushAll();
}

//Installing Plugin
if (isset($_GET['install_plugin'])) {
    $folder = $_GET['f'];
    $installed = $cbplugin->installPlugin(mysql_clean($_GET['install_plugin']), $folder);
    if ($installed) {
        include($installed);
    }
    CacheRedis::flushAll();
}

/**
 * Installing Multiple Plugins
 */
if (isset($_POST['install_selected']) && is_array($_POST['check_plugin'])) {
    $plugs = count($_POST['check_plugin']);
    for ($i = 0; $i < $plugs; $i++) {
        $itr = $_POST['check_plugin'][$i];
        $installed = $cbplugin->installPlugin($_POST['plugin_file_' . $itr], $_POST['plugin_folder_' . $itr]);
        if ($installed) {
            include($installed);
        }
    }
    CacheRedis::flushAll();
}

//Get New Plugin List
$availabe_plugin_list = $cbplugin->getNewPlugins();
Assign('new_plugin_list', $availabe_plugin_list);

//Get Installed Plugin List
$installed_plugin_list = $cbplugin->getInstalledPlugins();

Assign('installed_plugin_list', $installed_plugin_list);
Assign('msg', @$msg);
subtitle(lang('manage_x', strtolower(lang('plugins'))));
template_files('plugin_manager.html');
display_it();
