<?php
const THIS_PAGE = 'manage_tags';

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once(DirPath::get('classes') . 'admin_tool.class.php');

$permission = 'advanced_settings';
if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '275')) {
    $permission = 'web_config_access';
}
User::getInstance()->hasPermissionOrRedirect($permission, true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('tags'))), 'url' => DirPath::getUrl('admin_area') . 'manage_tags.php'];

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
    $cond[] = ' T.id_tag_type = ' . (int)$_GET['id_tag_type'];
    $selected_tag_type = $_GET['id_tag_type'];
}
$tag_types[0] = lang('all');
$temp_tag_types = array_column(Tags::getTagTypes(), 'name', 'id_tag_type');
foreach ($temp_tag_types as $key => $item) {
    if (config('videosSection') != 'yes' && 'video' == $item) {
        continue;
    }
    if ((config('videosSection') != 'yes' || config('enable_video_genre') != 'yes') && 'genre' == $item) {
        continue;
    }
    if ((config('videosSection') != 'yes' || config('enable_video_actor') != 'yes') && 'actors' == $item) {
        continue;
    }
    if ((config('videosSection') != 'yes' || config('enable_video_producer') != 'yes') && 'producer' == $item) {
        continue;
    }
    if ((config('videosSection') != 'yes' || config('enable_video_executive_producer') != 'yes') && 'executive_producer' == $item) {
        continue;
    }
    if ((config('videosSection') != 'yes' || config('enable_video_director') != 'yes') && 'director' == $item) {
        continue;
    }
    if ((config('videosSection') != 'yes' || config('enable_video_crew') != 'yes') && 'crew' == $item) {
        continue;
    }
    if (config('photosSection') != 'yes' && 'photo' == $item) {
        continue;
    }
    if (config('channelsSection') != 'yes' && 'profile' == $item) {
        continue;
    }
    if (config('collectionsSection') != 'yes' && 'collection' == $item) {
        continue;
    }
    $tag_types[$key] = ucfirst(lang($item));
}


$cond[]= ' T.id_tag_type IN ('.implode(',', array_keys($tag_types)).')';
$tags = Tags::getTags($curr_limit, $cond);
$count = Tags::countTags($cond);
$total_pages = $count / $limit;
$total_pages = round($total_pages + 0.49, 0);
//Pagination
pages::getInstance()->paginate($total_pages, $current_page);

assign('tags', $tags);
assign('tag_types', $tag_types);
assign('selected_tag_type', $selected_tag_type);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/manage_tags/manage_tags' . $min_suffixe . '.js' => 'admin']);

subtitle(lang('manage_x', strtolower(lang('tags'))));
template_files('manage_tags.html');
display_it();
