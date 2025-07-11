<?php
const THIS_PAGE = 'collections';
const PARENT_PAGE = 'collections';

require 'includes/config.inc.php';

if( config('collectionsSection') != 'yes' || (config('videosSection') != 'yes' && config('photosSection') != 'yes') ) {
    redirect_to(DirPath::getUrl('root'));
}

$child_ids = false;
if ($_GET['cat'] && is_numeric($_GET['cat'])) {
    $child_ids = Category::getInstance()->getChildren($_GET['cat'], true);
    $child_ids[] = mysql_clean($_GET['cat']);
}

User::getInstance()->hasPermissionOrRedirect('view_collections');
pages::getInstance()->page_redir();

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('collection_per_page'));
$sort_label = SortType::getSortLabelById($_GET['sort']) ?? '';
$params = Collection::getInstance()->getFilterParams($sort_label, []);
$params = Collection::getInstance()->getFilterParams($_GET['time'] ?? '', $params);
$params['limit'] = $get_limit;
if( $child_ids ){
    $params['category'] = $child_ids;
}
$collections = Collection::getInstance()->getAll($params);
assign('collections', $collections);

$params = [
    'limit'   => config('collection_home_top_collections')
    , 'order' => 'COUNT(CASE WHEN collections.type = \'videos\' THEN video.videoid ELSE photos.photo_id END) DESC'
];

assign('top_collections', Collection::getInstance()->getAll($params));

if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
    assign('sort_list', display_sort_lang_array(Collection::getInstance()->getSortList()));
    assign('default_sort', SortType::getDefaultByType('collections'));
    assign('sort_link', $_GET['sort']??0);
}
assign('time_list', time_links());

if( empty($collections) ){
    $count = 0;
} else if( count($collections) < config('collection_per_page') && $page == 1 ){
    $count = count($collections);
} else {
    unset($params['limit']);
    unset($params['order']);
    $params['count'] = true;
    $count = Collection::getInstance()->getAll($params);
}

$total_pages = count_pages($count, config('collection_per_page'));

//Pagination
pages::getInstance()->paginate($total_pages, $page);

subtitle(lang('collections'));
//Displaying The Template
template_files('collections.html');
display_it();
