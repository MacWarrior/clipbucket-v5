<?php
define('THIS_PAGE', 'photos');
define('PARENT_PAGE', 'photos');

require 'includes/config.inc.php';

if( !isSectionEnabled('photos') ){
    redirect_to(BASEURL);
}

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_photos', true);

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('photo_main_list'));
$params = Photo::getInstance()->getFilterParams($_GET['sort'], []);
$params = Photo::getInstance()->getFilterParams($_GET['time'], $params);
$params['limit'] = $get_limit;

$photos = Photo::getInstance()->getAll($params);
assign('photos', $photos);

assign('sort_list', Photo::getInstance()->getSortList());
assign('time_list', time_links());

if( empty($photos) ){
    $count = 0;
} else if( count($photos) < config('photo_main_list') && $page == 1 ){
    $count = count($photos);
} else {
    unset($params['limit']);
    unset($params['order']);
    $params['count'] = true;
    $count = Photo::getInstance()->getAll($params);
}

if (config('collectionsSection') == 'yes') {
    $collections = Collection::getInstance()->getAll([
        'limit'                 => config('collection_photos_top_collections'),
        'active'                => 'yes',
        'type'                  => 'photos',
        'parents_only'          => true,
        'hide_empty_collection' => true
    ]);
} else {
    $collections = [];
}
assign('collections', $collections);

assign('featured', Photo::getInstance()->getAll([
    'limit'    => '0,6',
    'featured' => true
]));

$total_pages = count_pages($count, config('photo_main_list'));
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
//Pagination
pages::getInstance()->paginate($total_pages, $page);
assign('url_edit', DirPath::getUrl('admin_area') . 'edit_photo.php?photo=');
assign('is_admin', userquery::getInstance()->admin_login_check(true));

subtitle(lang('photos'));
//Displaying The Template
template_files('photos.html');
display_it();
