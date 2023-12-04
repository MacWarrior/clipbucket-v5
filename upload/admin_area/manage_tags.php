<?php

require_once '../includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');
/* Generating breadcrumb */
global $breadcrumb, $pages, $userquery, $Cbucket;

$userquery->admin_login_check();
$userquery->login_check('web_config_access');
$pages->page_redir();

$breadcrumb[0] = ['title' => lang('general'), 'url'   => ''];
$breadcrumb[1] = ['title' => lang('manage_tags'), 'url'   => ADMIN_BASEURL . '/manage_tags.php'];

$limit = RESULTS;

$current_page = $_GET['page'];
$current_page = is_numeric($current_page) && $current_page > 0 ? $current_page : 1;

$curr_limit = ($current_page - 1) * $limit . ',' . $limit;
$cond = [];
if (!empty($_GET['search'])) {
    $cond[] = ' T.name LIKE \'%' . mysql_clean($_GET['search']) . '%\'';
}
$selected_tag_type = 0;
if (!empty($_GET['id_tag_type'])) {
    $cond[] = ' T.id_tag_type = ' . mysql_clean($_GET['id_tag_type']);
    $selected_tag_type = $_GET['id_tag_type'];
}

$tag_types =  [lang('all')];
$tag_types = array_merge($tag_types, array_map(function ($item) {
    return ucfirst(lang($item));
}, array_column(Tags::getTagTypes(), 'name', 'id_tag_type')));

$tags = Tags::getTags($curr_limit, $cond);
$count = Tags::countTags($cond);
$total_pages = $count / $limit;
$total_pages = round($total_pages + 0.49, 0);
//Pagination
$pages->paginate($total_pages, $current_page);

assign('tags', $tags);
assign('tag_types', $tag_types);
assign('selected_tag_type', $selected_tag_type);

if (in_dev()) {
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
$Cbucket->addAdminJS(['pages/manage_tags/manage_tags' . $min_suffixe . '.js' => 'admin']);

subtitle(lang('manage_tags'));
template_files('manage_tags.html');
display_it();
