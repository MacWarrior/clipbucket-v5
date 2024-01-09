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
    $childs = CBvideo::getInstance()->get_sub_categories($_GET['cat']);
    $child_ids = [];
    if ($childs) {
        foreach ($childs as $child) {
            $child_ids[] = $child['category_id'];
            $subchilds = $childs = CBvideo::getInstance()->get_sub_categories($child['category_id']);
            if ($subchilds) {
                foreach ($subchilds as $subchild) {
                    $child_ids[] = $subchild['category_id'];
                }
            }
        }
    }
    $child_ids[] = mysql_clean($_GET['cat']);
}

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, VLISTPP);
$params = Video::getInstance()->getFilterParams($_GET['sort'], []);
$params = Video::getInstance()->getFilterParams($_GET['time'], $params);
$params['limit'] = $get_limit;
if( $child_ids ){
    $params['category'] = $child_ids;
}
$videos = Video::getInstance()->getAll($params);
assign('videos', $videos);

if( empty($videos) ){
    $count = 0;
} else if( count($videos) < config('videos_list_per_page') ){
    $count = count($videos);
} else {
    unset($params['limit']);
    $params['count'] = true;
    $count = Video::getInstance()->getAll($params);
}

$total_pages = count_pages($count, VLISTPP);
//Pagination
$extra_params = null;
$tag = '<li><a #params#>#page#</a><li>';
pages::getInstance()->paginate($total_pages, $page, null, $extra_params, $tag);
subtitle(lang('videos'));
template_files('videos.html');
display_it();
