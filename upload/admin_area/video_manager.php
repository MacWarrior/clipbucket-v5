<?php
const THIS_PAGE = 'video_manager';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('video_moderation', true);
pages::getInstance()->page_redir();

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
if( !empty($_GET['make_feature']) ){
    $video = (int)$_GET['make_feature'];
    CBvideo::getInstance()->action('feature', $video);
    $row = myquery::getInstance()->Get_Website_Details();
    if ($row['notification_option'] == '1') {
        send_video_notification($video);
    }
}

if( !empty($_GET['make_unfeature']) ){
    $video = (int)$_GET['make_unfeature'];
    CBvideo::getInstance()->action('unfeature', $video);
}

if( !empty($_GET['check_castable']) ){
    $videoid = (int)$_GET['check_castable'];
    $vdetails = get_video_details($videoid);
    update_castable_status($vdetails);
}
if( isset($_POST['check_castable_selected']) && is_array($_POST['check_video']) && !empty($_POST['check_video']) ){
    foreach($_POST['check_video'] as $id){
        $vdetails = get_video_details((int)$id);
        update_castable_status($vdetails);
    }
}

if( !empty($_GET['update_bits_color']) ){
    $videoid = (int)$_GET['update_bits_color'];
    $vdetails = get_video_details($videoid);
    update_bits_color($vdetails);
}
if( isset($_POST['update_bits_color_selected']) && is_array($_POST['check_video']) && !empty($_POST['check_video']) ){
    foreach($_POST['check_video'] as $id){
        $vdetails = get_video_details((int)$id);
        update_bits_color($vdetails);
    }
}

//Using Multiple Action
if( isset($_POST['make_featured_selected']) && is_array($_POST['check_video']) && !empty($_POST['check_video']) ){
    foreach($_POST['check_video'] as $id){
        CBvideo::getInstance()->action('feature', (int)$id);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e('Selected videos have been set as featured', 'm');
}
if( isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_video']) && !empty($_POST['check_video']) ){
    for ($id = 0; $id < count($_POST['check_video']); $id++) {
        CBvideo::getInstance()->action('unfeature', $_POST['check_video'][$id]);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e('Selected videos have been removed from featured list', 'm');
}

//Activate / Deactivate
if( !empty($_GET['activate']) ){
    $video = (int)$_GET['activate'];
    CBvideo::getInstance()->action('activate', $video);
}
if( !empty($_GET['deactivate']) ){
    $video = (int)$_GET['deactivate'];
    CBvideo::getInstance()->action('deactivate', $video);
}

//Using Multiple Action
if( isset($_POST['activate_selected']) && is_array($_POST['check_video']) && !empty($_POST['check_video']) ) {
    foreach($_POST['check_video'] as $id){
        CBvideo::getInstance()->action('activate', (int)$id);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e('Selected Videos Have Been Activated', 'm');
}
if( isset($_POST['deactivate_selected']) && is_array($_POST['check_video']) && !empty($_POST['check_video']) ) {
    foreach($_POST['check_video'] as $id){
        CBvideo::getInstance()->action('deactivate', (int)$id);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e('Selected Videos Have Been Dectivated', 'm');
}

//Delete Video
if( !empty($_GET['delete_video']) ){
    $video = (int)$_GET['delete_video'];
    CBvideo::getInstance()->delete_video($video);
}

//Deleting Multiple Videos
if( isset($_POST['delete_selected']) && is_array($_POST['check_video']) && !empty($_POST['check_video']) ){
    foreach($_POST['check_video'] as $id){
        CBvideo::getInstance()->delete_video((int)$id);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e(lang('vdo_multi_del_erro'), 'm');
}

//Calling Video Manager Functions
call_functions(CBvideo::getInstance()->video_manager_funcs);

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '331') ){
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

$params['join_flag']=true;
if (config('enable_video_categories') !='no') {
    $params['get_detail']=true;
}
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
$videos = Video::getInstance()->getAll($params);
$ids_to_check_progress = [];
foreach ($videos as $video) {
    if (in_array($video['status'], ['Processing', 'Waiting'])) {
        $ids_to_check_progress[] = $video['videoid'];
    }
}
Assign('videos', $videos);
Assign('ids_to_check_progress', json_encode($ids_to_check_progress));

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
pages::getInstance()->paginate($total_pages, $page);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/video_manager/video_manager'.$min_suffixe.'.js' => 'admin']);

subtitle(lang('manage_x', strtolower(lang('videos'))));
template_files('video_manager.html');
display_it();
