<?php
const THIS_PAGE = 'photos';
const PARENT_PAGE = 'photos';

require 'includes/config.inc.php';

if( !isSectionEnabled('photos') ){
    redirect_to(DirPath::getUrl('root'));
}

User::getInstance()->hasPermissionOrRedirect('view_photos');
pages::getInstance()->page_redir();

$child_ids = false;
if ($_GET['cat'] && is_numeric($_GET['cat'])) {
    $child_ids = Category::getInstance()->getChildren($_GET['cat'], true);
    $child_ids[] = mysql_clean($_GET['cat']);
}
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('photo_main_list'));
$sort_label = SortType::getSortLabelById($_GET['sort']) ?? '';
$params = Photo::getInstance()->getFilterParams($sort_label, []);
$params = Photo::getInstance()->getFilterParams($_GET['time'] ?? '', $params);
$params['limit'] = $get_limit;
if( $child_ids ){
    $params['category'] = $child_ids;
}
$photos = Photo::getInstance()->getAll($params);
assign('photos', $photos);

if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '299')) {
    assign('sort_list', display_sort_lang_array(Photo::getInstance()->getSortList()));
    assign('sort_link', $_GET['sort']??0);
    assign('default_sort', SortType::getDefaultByType('photos'));
}
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

$collections = [];
if( config('collectionsSection') == 'yes' && User::getInstance()->hasPermission('view_collections') ){
    $collections = Collection::getInstance()->getAll([
        'limit'                 => config('collection_photos_top_collections'),
        'active'                => 'yes',
        'type'                  => 'photos',
        'parents_only'          => true,
        'hide_empty_collection' => true
    ]);
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
assign('is_admin', User::getInstance()->hasAdminAccess());

subtitle(lang('photos'));
//Displaying The Template
template_files('photos.html');
display_it();
