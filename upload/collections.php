<?php
define('THIS_PAGE', 'collections');
define('PARENT_PAGE', 'collections');

require 'includes/config.inc.php';

if( config('collectionsSection') != 'yes' || (config('videosSection') != 'yes' && config('photosSection') != 'yes') ) {
    redirect_to(BASEURL);
}

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_collections', true);

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('collection_per_page'));
$params = Collection::getInstance()->getFilterParams($_GET['sort'], []);
$params = Collection::getInstance()->getFilterParams($_GET['time'], $params);
$params['limit'] = $get_limit;

$collections = Collection::getInstance()->getAll($params);
assign('collections', $collections);

$params = [
    'limit'   => config('collection_home_top_collections')
    , 'order' => 'COUNT(CASE WHEN collections.type = \'videos\' THEN video.videoid ELSE photos.photo_id END) DESC'
];

assign('top_collections', Collection::getInstance()->getAll($params));

assign('sort_list', Collection::getInstance()->getSortList());
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
