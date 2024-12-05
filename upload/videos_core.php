<?php
require 'includes/config.inc.php';

pages::getInstance()->page_redir();
if (PARENT_PAGE == 'videos_public') {
    User::getInstance()->hasPermission('allow_public_video_page');
} else {
    User::getInstance()->hasPermission('view_videos');
}

if( !isSectionEnabled('videos') ){
    redirect_to(BASEURL);
}
if (config('enable_public_video_page') != 'yes' && PARENT_PAGE == 'videos_public') {
    redirect_to(BASEURL . '/' . 'videos.php');
}

$child_ids = false;
if ($_GET['cat'] && is_numeric($_GET['cat'])) {
    $child_ids = Category::getInstance()->getChildren($_GET['cat'], true);
    $child_ids[] = mysql_clean($_GET['cat']);
}

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('videos_list_per_page'));
$params = Video::getInstance()->getFilterParams($_GET['sort'], []);
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

assign('sort_list', Video::getInstance()->getSortList());
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
//Pagination
$extra_params = null;
$tag = '<li><a #params#>#page#</a><li>';
pages::getInstance()->paginate($total_pages, $page, null, $extra_params, $tag);
subtitle(lang('videos'));
template_files('videos.html');
display_it();
