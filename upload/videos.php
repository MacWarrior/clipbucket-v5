<?php
define('THIS_PAGE', 'videos');
define('PARENT_PAGE', 'videos');
require 'includes/config.inc.php';

User::getInstance()->hasPermissionOrRedirect('view_videos');
pages::getInstance()->page_redir();

if( !isSectionEnabled('videos') ){
    redirect_to(DirPath::getUrl('root'));
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
$params = Video::getInstance()->getFilterParams($_GET['time'] ?? '', $params);
$params['limit'] = $get_limit;
if( $child_ids ){
    $params['category'] = $child_ids;
}
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
