<?php
define('THIS_PAGE', 'view_collection');
define('PARENT_PAGE', 'collections');
require 'includes/config.inc.php';

pages::getInstance()->page_redir();

if( !isSectionEnabled('collections') || !User::getInstance()->hasPermission('view_collections')){
    redirect_to(DirPath::getUrl('root'));
}

$collection_id = (int)$_GET['cid'];

if( empty($collection_id) ){
    sessionMessageHandler::add_message(lang('collection_not_exists'), 'e', cblink(['name' => 'collections']));
}

if( !Collections::getInstance()->is_viewable($collection_id) ){
    ClipBucket::getInstance()->show_page = false;
    display_it();
    die();
}

$params = [];
$params['collection_id'] = $collection_id;
$cdetails = Collection::getInstance()->getOne($params);

if (!$cdetails || (!isSectionEnabled($cdetails['type']) && !User::getInstance()->hasAdminAccess()) ){
    ClipBucket::getInstance()->show_page = false;
    display_it();
    die();
}

$page = $_GET['page'];
$get_limit = create_query_limit($page, config('collection_items_page'));
if (config('enable_sub_collection') == 'yes') {
    $params = [];
    $params['collection_id_parent'] = $collection_id;
    $params['limit'] = $get_limit;
    $collections = Collection::getInstance()->getAll($params);
    assign('collections', $collections);
}

$params = [];
$params['collection_id'] = $collection_id;
$params['limit'] = $get_limit;
$sort_id = $_GET['sort_id']?? $cdetails['sort_type'];
assign('sort_id', $sort_id);
$sort_label = SortType::getSortLabelById($sort_id) ?? '';
$params['order_item'] = $sort_id;
$items = Collection::getInstance()->getItems($params);

if( empty($items) ){
    $total_items = 0;
} else if( count($items) < config('collection_items_page') ){
    $total_items = count($items);
} else {
    unset($params['limit']);
    $params['count'] = true;
    $total_items = Collection::getInstance()->getItems($params);
}

// Calling necessary function for view collection
call_view_collection_functions($cdetails);

$total_pages = count_pages($total_items, config('collection_items_page'));
//Pagination
pages::getInstance()->paginate($total_pages, $page);

if (config('enable_sub_collection') == 'yes') {
    $breadcrum = [];
    $collection_parent = $cdetails;
    do {
        $breadcrum[] = [
            'title' => $collection_parent['collection_name']
            , 'url' => Collections::getInstance()->collection_links($collection_parent,'view')
        ];
        $collection_parent = Collections::getInstance()->get_parent_collection($collection_parent);
    } while ($collection_parent);
    assign('breadcrum', array_reverse($breadcrum));
    assign('collection_baseurl', Collections::getInstance()->get_base_url());
}

$ids_to_check_progress = [];
if ($cdetails['type'] == 'videos' && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279')) {
    foreach ($items as $video) {
        if (in_array($video['status'], ['Processing', 'Waiting'])) {
            $ids_to_check_progress[] = $video['videoid'];
        }
    }
}
Assign('ids_to_check_progress', json_encode($ids_to_check_progress));
assign('objects', $items);
assign('c', $cdetails);
subtitle($cdetails['collection_name']);
$complement_url = base64_encode(json_encode($cdetails['collection_id']));
if ($cdetails['type'] == 'photos') {
    assign('sort_list', display_sort_lang_array(Photo::getInstance()->getSortList()));

    $base_url = cblink(['name' => 'photo_upload']);
    if (config('seo') == 'yes') {
        $link = $base_url . '/' . $complement_url;
    } else {
        $link = $base_url . '?collection=' . $complement_url;
    }
} elseif ($cdetails['type'] == 'videos') {
    assign('sort_list', display_sort_lang_array(Video::getInstance()->getSortList()));
    $base_url = cblink(['name' => 'upload']);

    if (config('seo') == 'yes') {
        $link = $base_url . '/' . $complement_url;
    } else {
        $link = $base_url . '?collection=' . $complement_url;
    }
}

assign('link_add_more',  $link);
assign('featured', Photo::getInstance()->getAll(['featured'=>true, 'limit'=>6]));
assign('link_edit_bo', DirPath::getUrl('admin_area') . 'edit_collection.php?collection=' .$collection_id);
assign('link_edit_fo',  DirPath::getUrl('root') . 'manage_collections.php?mode=edit_collection&cid=' . $collection_id);
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'pages/view_collection/view_collection'.$min_suffixe.'.js' => 'admin'
]);

if( config('enable_comments_collection') == 'yes' && $cdetails['allow_comments'] == 'yes' ){
    ClipBucket::getInstance()->addJS([
        'pages/add_comment/add_comment' . $min_suffixe . '.js'  => 'admin'
    ]);
    Comments::initVisualComments();
}

if( config('enable_collection_categories') == 'yes' ){
    $category_links = [];
    foreach (json_decode($cdetails['category_list'],true) as $collection_category) {
        $category_links[] = '<a href="' . cblink(['name' => 'category', 'data' => ['category_id' => $collection_category['id']], 'type' => 'collection']) . '">' . display_clean($collection_category['name']) . '</a>';
    }
    assign('category_links', implode(',', $category_links));
}

if( !empty($cdetails['tags']) ){
    ClipBucket::getInstance()->addJS([
        'tag-it'.$min_suffixe.'.js'                               => 'admin'
        ,'init_readonly_tag/init_readonly_tag'.$min_suffixe.'.js' => 'admin'
    ]);
    ClipBucket::getInstance()->addCSS([
        'jquery.tagit'.$min_suffixe.'.css'      => 'admin'
        ,'tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin'
        ,'readonly_tag'.$min_suffixe.'.css'     => 'admin'
    ]);
}

assign('sort_link', $sort_id??0);
assign('default_sort', SortType::getDefaultByType('videos'));

template_files('view_collection.html');
display_it();
