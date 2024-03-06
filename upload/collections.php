<?php
define('THIS_PAGE', 'collections');
define('PARENT_PAGE', 'collections');

require 'includes/config.inc.php';

if( !isSectionEnabled('collections') ){
    redirect_to(BASEURL);
}

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_collections', true);


if (!isSectionEnabled('photos') && !isSectionEnabled('videos')) {
    $cond['type'] = 'none';
} else {
    if (!isSectionEnabled('photos')) {
        $cond['type'] = 'videos';
    } else {
        if (!isSectionEnabled('videos')) {
            $cond['type'] = 'photos';
        }
    }
}





$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('collection_per_page'));
$params = Collection::getInstance()->getFilterParams($_GET['sort'], []);
$params = Collection::getInstance()->getFilterParams($_GET['time'], $params);
$params['limit'] = $get_limit;

$collections = Collection::getInstance()->getAll($params);
assign('collections', $collections);

if( empty($collections) ){
    $count = 0;
} else if( count($collections) < config('collection_per_page') && $page == 1 ){
    $count = count($collections);
} else {
    unset($params['limit']);
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
