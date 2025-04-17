<?php
require 'includes/config.inc.php';

pages::getInstance()->page_redir();
if (PARENT_PAGE == 'videos_public') {
    User::getInstance()->hasPermission('allow_public_video_page');
} else {
    User::getInstance()->hasPermission('view_videos');
}

if( !isSectionEnabled('videos') ){
    redirect_to(Network::get_server_url());
}
if (config('enable_public_video_page') != 'yes' && PARENT_PAGE == 'videos_public') {
    redirect_to(Network::get_server_url() . 'videos.php');
}

$child_ids = false;
if ($_GET['cat'] && is_numeric($_GET['cat'])) {
    $child_ids = Category::getInstance()->getChildren($_GET['cat'], true);
    $child_ids[] = mysql_clean($_GET['cat']);
}

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('videos_list_per_page'));
$sort_label = SortType::getSortLabelById($_GET['sort']) ?? '';
$params = Video::getInstance()->getFilterParams($sort_label, []);
$params = Video::getInstance()->getFilterParams($_GET['time'], $params);
$params['limit'] = $get_limit;
if( $child_ids ){
    $params['category'] = $child_ids;
}
if (config('enable_public_video_page') == 'yes') {
    if (User::getInstance()->hasPermission('view_videos') && User::getInstance()->hasPermission('allow_public_video_page')) {
        $params['public'] = false;
    }
    //hide public videos, they are listed ind public video menu
    if (!empty($public)) {
        $params['public'] = true;
    }
}

assign('is_public_page', $params['public'] ?? false);
assign('type_link', 'videos' . (!empty($params['public']) ? '_public' : ''));

$videos = Video::getInstance()->getAll($params);
assign('videos', $videos);

assign('sort_list', display_sort_lang_array(Video::getInstance()->getSortList()));
assign('sort_link', $_GET['sort']??0);
assign('default_sort', SortType::getDefaultByType('videos'));
assign('time_list', time_links());

if( empty($videos) ){
    $count = 0;
} else if( count($videos) < config('videos_list_per_page') && $page == 1 ){
    $count = count($videos);
} else {
    unset($params['limit']);
    unset($params['order']);
    $params['count'] = true;
    $count = Video::getInstance()->getAll($params);
}
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
$total_pages = count_pages($count, config('videos_list_per_page'));
$ids_to_check_progress = [];
foreach ($videos as $video) {
    if (in_array($video['status'], ['Processing', 'Waiting'])) {
        $ids_to_check_progress[] = $video['videoid'];
    }
}
Assign('ids_to_check_progress', json_encode($ids_to_check_progress));

//Pagination
$extra_params = null;
$tag = '<li><a #params#>#page#</a><li>';
pages::getInstance()->paginate($total_pages, $page, null, $extra_params, $tag);
subtitle(lang('videos'));
template_files('videos.html');
display_it();
