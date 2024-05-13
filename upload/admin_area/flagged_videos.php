<?php
define('THIS_PAGE', 'flagged_videos');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $cbvideo, $eh, $cbvid;

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
$breadcrumb[1] = ['title' => 'List Flagged Videos', 'url' => DirPath::getUrl('admin_area') . 'flagged_videos.php'];

$mode = $_GET['mode'];

//Delete Video
if (isset($_GET['delete_video'])) {
    $video = mysql_clean($_GET['delete_video']);
    $cbvideo->delete_video($video);
}

//Deleting Multiple Videos
if (isset($_POST['delete_selected'])) {
    for ($id = 0; $id <= config('admin_pages'); $id++) {
        $cbvideo->delete_video($_POST['check_video'][$id]);
    }
    $eh->flush();
    e(lang('vdo_multi_del_erro'), 'm');
}

//Activate / Deactivate
if (isset($_GET['activate'])) {
    $video = mysql_clean($_GET['activate']);
    $cbvid->action('activate', $video);
}
if (isset($_GET['deactivate'])) {
    $video = mysql_clean($_GET['deactivate']);
    $cbvid->action('deactivate', $video);
}

//Using Multiple Action
if (isset($_POST['activate_selected'])) {
    for ($id = 0; $id <= config('admin_pages'); $id++) {
        $cbvid->action('activate', $_POST['check_video'][$id]);
    }
    e('Selected Videos Have Been Activated', 'm');
}
if (isset($_POST['deactivate_selected'])) {
    for ($id = 0; $id <= config('admin_pages'); $id++) {
        $cbvid->action('deactivate', $_POST['check_video'][$id]);
    }
    e('Selected Videos Have Been Dectivated', 'm');
}

if (isset($_REQUEST['delete_flags'])) {
    $video = mysql_clean($_GET['delete_flags']);
    $cbvid->action->delete_flags($video);
}

//Deleting Multiple Videos
if (isset($_POST['delete_flags'])) {
    for ($id = 0; $id <= config('admin_pages'); $id++) {
        $eh->flush();
        $cbvid->action->delete_flags($_POST['check_video'][$id]);
    }
}

switch ($mode) {
    case 'view':
    default:
        assign('mode', 'view');
        //Getting Video List
        $page = mysql_clean($_GET['page']);
        $get_limit = create_query_limit($page, 5);
        $videos = $cbvid->action->get_flagged_objects($get_limit);
        Assign('videos', $videos);

        //Collecting Data for Pagination
        $total_rows = $cbvid->action->count_flagged_objects();
        Assign('count_flagged_objects', $total_rows);
        $total_pages = count_pages($total_rows, 5);

        //Pagination
        pages::getInstance()->paginate($total_pages, $page);
        break;

    case 'view_flags':
        assign('mode', 'view_flags');
        $vid = mysql_clean($_GET['vid']);
        $vdetails = $cbvid->get_video($vid);
        if ($vdetails) {
            $flags = $cbvid->action->get_flags($vid);
            assign('flags', $flags);
            assign('video', $vdetails);
        } else {
            e('Video does not exist');
        }
        break;
}

subtitle('Flagged Videos');
template_files('flagged_videos.html');
display_it();