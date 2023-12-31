<?php
define('THIS_PAGE', 'video_manager');

require_once '../includes/admin_config.php';
require_once '../api/push.php';
global $cbvid, $userquery, $pages, $myquery, $eh, $cbvideo;
$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

if (!empty($_GET['missing_video'])) {
    e(lang('class_vdo_del_err'));
}

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('videos'), 'url' => ''];
if ($_GET['active'] == 'no') {
    $breadcrumb[1] = ['title' => 'List Inactive Videos', 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
} else {
    $breadcrumb[1] = ['title' => lang('videos_manager'), 'url' => DirPath::getUrl('admin_area') . 'video_manager.php'];
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
$get_limit = create_query_limit($page, RESULTS);

$all_categories = Category::getInstance()->getAll([
    'category_type' => Category::getInstance()->getIdsCategoriesType('video')
]);
$all_category_ids = [];

foreach ($all_categories as $cats) {
    $all_category_ids[] = $cats['category_id'];
}

if (isset($_GET['category'])) {
    if ($_GET['category'][0] == 'all') {
        $cat_field = '';
    } else {
        $cat_field = $_GET['category'];
    }
}

if (isset($_GET['search'])) {
    $array = [
        'videoid'  => $_GET['videoid'],
        'videokey' => $_GET['videokey'],
        'title'    => $_GET['title'],
        'tags'     => $_GET['tags'],
        'user'     => $_GET['userid'],
        'category' => $cat_field,
        'featured' => $_GET['featured'],
        'active'   => $_GET['active'],
        'status'   => $_GET['status']
    ];
}

$result_array = $array;
//Getting Video List
$result_array['limit'] = $get_limit;
if (!$array['order']) {
    $result_array['order'] = ' videoid DESC ';
}

$videos = Video::getInstance()->getAll($result_array);

Assign('videos', $videos);

//Collecting Data for Pagination
$vcount = $array;
$vcount['count_only'] = true;
$total_rows = get_videos($vcount);
$total_pages = count_pages($total_rows, RESULTS);
$pages->paginate($total_pages, $page);

//Category Array
if (is_array($_GET['category'])) {
    $cats_array = [$_GET['category']];
} else {
    preg_match_all('/#([0-9]+)#/', $_GET['category'], $m);
    $cats_array = [$m[1]];
}
$cat_array = [
    lang('vdo_cat'),
    'type'             => 'checkbox',
    'name'             => 'category',
    'id'               => 'category',
    'value'            => [$cats_array],
    'hint_1'           => lang('vdo_cat_msg'),
    'display_function' => 'convert_to_categories'
];

assign('cat_array', $cat_array);
subtitle(lang('videos_manager'));
template_files('video_manager.html');
display_it();
