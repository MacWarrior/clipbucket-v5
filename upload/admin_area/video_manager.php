<?php
define('THIS_PAGE', 'video_manager');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $cbvid, $userquery, $pages, $myquery, $eh, $cbvideo;
$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
if ($_GET['active'] == 'no') {
    $breadcrumb[1] = ['title' => 'List Inactive Videos', 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
} else {
    $breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('videos'))), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
}

if (isset($_POST['reconvert_selected']) || isset($_GET['reconvert_video'])) {
    reConvertVideos();
}

//Feature / UnFeature Video
if (isset($_GET['make_feature'])) {
    $video = mysql_clean($_GET['make_feature']);
    $cbvid->action('feature', $video);
    $row = $myquery->Get_Website_Details();
    if ($row['notification_option'] == '1') {
        send_video_notification($video);
    }
}

if (isset($_GET['make_unfeature'])) {
    $video = mysql_clean($_GET['make_unfeature']);
    $cbvid->action('unfeature', $video);
}

if (isset($_GET['check_castable'])) {
    $videoid = mysql_clean($_GET['check_castable']);
    $vdetails = get_video_details($videoid);
    update_castable_status($vdetails);
}
if (isset($_POST['check_castable_selected']) && is_array($_POST['check_video'])) {
    for ($id = 0; $id < count($_POST['check_video']); $id++) {
        $vdetails = get_video_details($_POST['check_video'][$id]);
        update_castable_status($vdetails);
    }
}

if (isset($_GET['update_bits_color'])) {
    $videoid = mysql_clean($_GET['update_bits_color']);
    $vdetails = get_video_details($videoid);
    update_bits_color($vdetails);
}
if (isset($_POST['update_bits_color_selected']) && is_array($_POST['check_video'])) {
    for ($id = 0; $id < count($_POST['check_video']); $id++) {
        $vdetails = get_video_details($_POST['check_video'][$id]);
        update_bits_color($vdetails);
    }
}

//Using Multiple Action
if (isset($_POST['make_featured_selected']) && is_array($_POST['check_video'])) {
    for ($id = 0; $id < count($_POST['check_video']); $id++) {
        $cbvid->action('feature', $_POST['check_video'][$id]);
    }
    $eh->flush();
    e('Selected videos have been set as featured', 'm');
}
if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_video'])) {
    for ($id = 0; $id < count($_POST['check_video']); $id++) {
        $cbvid->action('unfeature', $_POST['check_video'][$id]);
    }
    $eh->flush();
    e('Selected videos have been removed from featured list', 'm');
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
if (isset($_POST['activate_selected']) && is_array($_POST['check_video'])) {
    for ($id = 0; $id < count($_POST['check_video']); $id++) {
        $cbvid->action('activate', $_POST['check_video'][$id]);
    }
    $eh->flush();
    e('Selected Videos Have Been Activated', 'm');
}
if (isset($_POST['deactivate_selected']) && is_array($_POST['check_video'])) {
    for ($id = 0; $id < count($_POST['check_video']); $id++) {
        $cbvid->action('deactivate', $_POST['check_video'][$id]);
    }
    $eh->flush();
    e('Selected Videos Have Been Dectivated', 'm');
}

//Delete Video
if (isset($_GET['delete_video'])) {
    $video = mysql_clean($_GET['delete_video']);
    $cbvideo->delete_video($video);
}

//Deleting Multiple Videos
if (isset($_POST['delete_selected']) && is_array($_POST['check_video'])) {
    for ($id = 0; $id < count($_POST['check_video']); $id++) {
        $cbvideo->delete_video($_POST['check_video'][$id]);
    }
    $eh->flush();
    e(lang('vdo_multi_del_erro'), 'm');
}

//Calling Video Manager Functions
call_functions($cbvid->video_manager_funcs);

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

$version = Update::getInstance()->getDBVersion();

if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
    $all_categories = Category::getInstance()->getAll([
        'category_type' => Category::getInstance()->getIdsCategoriesType('video')
    ]);
    $all_category_ids = [];

    foreach ($all_categories as $cats) {
        $all_category_ids[] = $cats['category_id'];
    }
}
if (!empty($_GET['active'])) {
    $params = ['active' => $_GET['active']];
    assign('url_active', $_GET['active']);
}
if (isset($_POST['search'])) {
    $params = [
        'videoid'  => $_POST['videoid'] ?? false,
        'videokey' => $_POST['videokey'] ?? false,
        'title'    => $_POST['title'] ?? false,
        'tags'     => $_POST['tags'] ?? false,
        'userid'   => $_POST['userid'] ?? false,
        'category' => $_POST['category'] ?? false,
        'featured' => $_POST['featured'] ?? false,
        'active'   => $_POST['active'] ?? false,
        'status'   => $_POST['status'] ?? false
    ];
}
assign('param_search', $params);
//Getting Video List
$params['limit'] = $get_limit;
if (!$params['order']) {
    $params['order'] = ' videoid DESC ';
}

assign('anonymous_id', $userquery->get_anonymous_user());
$videos = Video::getInstance()->getAll($params);
Assign('videos', $videos);

if( empty($videos) ){
    $total_rows = 0;
} else if( count($videos) < config('admin_pages') && ($page == 1 || empty($page)) ){
    $total_rows = count($videos);
} else {
    $params['count'] = true;
    unset($params['limit']);
    unset($params['order']);
    $total_rows = Video::getInstance()->getAll($params);
}
$total_pages = count_pages($total_rows, config('admin_pages'));
$pages->paginate($total_pages, $page);

subtitle(lang('manage_x', strtolower(lang('videos'))));
template_files('video_manager.html');
display_it();
