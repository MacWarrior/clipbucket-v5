<?php
define('THIS_PAGE', 'videos');
define('PARENT_PAGE', 'videos');
require 'includes/config.inc.php';
global $cbvid, $pages, $userquery;
$pages->page_redir();
$userquery->perm_check('view_videos', true);
$sort = $_GET['sort'];
$child_ids = '';
$assign_arry = [];
if ($_GET['cat'] && is_numeric($_GET['cat'])) {
    $childs = $cbvid->get_sub_categories($_GET['cat']);
    $child_ids = [];
    if ($childs) {
        foreach ($childs as $child) {
            $child_ids[] = $child['category_id'];
            $subchilds = $childs = $cbvid->get_sub_categories($child['category_id']);
            if ($subchilds) {
                foreach ($subchilds as $subchild) {
                    $child_ids[] = $subchild['category_id'];
                }
            }
        }
    }
    $child_ids[] = mysql_clean($_GET['cat']);
}
$vid_cond = ['category' => $child_ids, 'date_span' => mysql_clean($_GET['time']), 'sub_cats'];
$vid_cond = build_sort($sort, $vid_cond);
//Getting Video List
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, VLISTPP);
$vlist = $vid_cond;
$count_query = $vid_cond;
$vlist['limit'] = $get_limit;
$videos = get_videos($vlist);
$assign_arry['videos'] = $videos;
$vcount = $vid_cond;
$counter = get_counter('video', $count_query);
if (!$counter) {
    $vcount['count_only'] = true;
    $total_rows = get_videos($vcount);
    $total_pages = count_pages($total_rows, VLISTPP);
    $counter = $total_rows ?: 0;
    update_counter('video', $count_query, $counter);
}
$total_pages = count_pages($counter, VLISTPP);
//Pagination
$extra_params = null;
$tag = '<li><a #params#>#page#</a><li>';
$pages->paginate($total_pages, $page, null, $extra_params, $tag);
subtitle(lang('videos'));
array_val_assign($assign_arry);
template_files('videos.html');
display_it();
