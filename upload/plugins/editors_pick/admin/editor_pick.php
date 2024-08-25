<?php
define('THIS_PAGE', 'editor_pick');
require_once dirname(__DIR__, 3) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();

/* Generating breadcrumb */
$breadcrumb[0] = ['title' => lang('manage_x', strtolower(lang('plugins'))), 'url' => ''];
$breadcrumb[1] = ['title' => lang('plugin_editors_picks'), 'url' => DirPath::getUrl('plugins') . 'editors_pick/admin/editor_pick.php'];

//Removing
if (isset($_GET['remove'])) {
    $id = mysql_clean($_GET['remove']);
    remove_vid_editors_pick($id);
}

if (isset($_POST['delete_selected']) && is_array($_POST['check_video'])) {
    for ($id = 0; $id <= count($_POST['check_video']); $id++) {
        remove_vid_editors_pick($_POST['check_video'][$id]);
    }
    errorhandler::getInstance()->flush();
    e(lang('plugin_editors_picks_removed_plural'), 'm');
}

$ep_videos = get_ep_videos();

if (isset($_POST['update_order'])) {
    if (is_array($ep_videos)) {
        foreach ($ep_videos as $epvid) {
            $order = $_POST['ep_order_' . $epvid['pick_id']];
            move_epick($epvid['videoid'], $order);
        }
    }
    $ep_videos = get_ep_videos();
}

if (isset($_POST['upload_special'])) {
    pr($_POST, true);
    pr($_FILES, true);
}

assign('videos', $ep_videos);

subtitle(lang('plugin_editors_picks'));
template_files('editor_pick.html', DirPath::get('plugins') . 'editors_pick/templates/admin/');
display_it();
