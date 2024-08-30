<?php
define('THIS_PAGE', 'videos');
define('PARENT_PAGE', 'videos');
require 'includes/config.inc.php';

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_videos', true);

if( !isSectionEnabled('videos') ){
    redirect_to(BASEURL);
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
