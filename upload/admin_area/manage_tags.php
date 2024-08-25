<?php
define('THIS_PAGE', 'manage_tags');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('web_config_access');
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url'   => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('tags'))), 'url'   => DirPath::getUrl('admin_area') . 'manage_tags.php'];

$limit = config('admin_pages');

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
pages::getInstance()->paginate($total_pages, $current_page);

assign('tags', $tags);
assign('tag_types', $tag_types);
assign('selected_tag_type', $selected_tag_type);

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/manage_tags/manage_tags' . $min_suffixe . '.js' => 'admin']);

subtitle(lang('manage_x', strtolower(lang('tags'))));
template_files('manage_tags.html');
display_it();
