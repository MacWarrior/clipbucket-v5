<?php
define('THIS_PAGE', 'collection_manager');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('collection_moderation',true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('collections'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('manage_x', strtolower(lang('collections'))),
    'url'   => DirPath::getUrl('admin_area') . 'collection_manager.php'
];

if (!empty($_GET['missing_collection'])) {
    e(lang('collection_not_exist'));
}

if (isset($_GET['make_feature'])) {
    Collections::getInstance()->collection_actions('make_feature', $_GET['make_feature']);
}
if (isset($_GET['make_unfeature'])) {
    Collections::getInstance()->collection_actions('make_unfeature', $_GET['make_unfeature']);
}
if (isset($_GET['activate'])) {
    Collections::getInstance()->collection_actions('activate', $_GET['activate']);
}
if (isset($_GET['deactivate'])) {
    Collections::getInstance()->collection_actions('deactivate', $_GET['deactivate']);
}
if (isset($_GET['make_public'])) {
    Collections::getInstance()->collection_actions('make_public', $_GET['make_public']);
}
if (isset($_GET['make_private'])) {
    Collections::getInstance()->collection_actions('make_private', $_GET['make_private']);
}
if (isset($_GET['delete_collection'])) {
    Collections::getInstance()->delete_collection($_GET['delete_collection']);
}

/* ACTIONS ON MULTI ITEMS */
if (isset($_POST['activate_selected']) && is_array($_POST['check_collection'])) {
    foreach($_POST['check_collection'] as $cid){
        Collections::getInstance()->collection_actions('activate', $cid);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e(count($_POST['check_collection']) . ' collections has been activated', 'm');
}

if (isset($_POST['deactivate_selected']) && is_array($_POST['check_collection'])) {
    foreach($_POST['check_collection'] as $cid){
        Collections::getInstance()->collection_actions('deactivate', $cid);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e(count($_POST['check_collection']) . ' collections has been deactivated', 'm');
}

if (isset($_POST['make_featured_selected']) && is_array($_POST['check_collection'])) {
    foreach($_POST['check_collection'] as $cid){
        Collections::getInstance()->collection_actions('make_feature', $cid);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e(count($_POST['check_collection']) . ' collections has been marked as <strong>' . lang('featured') . '</strong>', 'm',false);
}

if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_collection'])) {
    foreach($_POST['check_collection'] as $cid){
        Collections::getInstance()->collection_actions('make_unfeature', $cid);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    e(count($_POST['check_collection']) . ' collections has been marked as <strong>Unfeatured</strong>', 'm', false);
}

if (isset($_POST['delete_selected']) && is_array($_POST['check_collection'])) {
    foreach($_POST['check_collection'] as $cid){
        Collections::getInstance()->delete_collection($cid);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }

    $total = count($_POST['check_collection']);
    if( $total == 1 ){
        e(lang('collection_deleted'), 'm');
    } else {
        e(count($_POST['check_collection']) . ' collections has been deleted successfully', 'm');
    }
}

if (isset($_POST['make_public_selected']) && is_array($_POST['check_collection'])) {
    foreach($_POST['check_collection'] as $cid){
        Collections::getInstance()->collection_actions('make_public', $cid);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    $total = count($_POST['check_collection']);
    if( $total == 1 ){
        e(lang('collection_made_public'), 'm');
    } else {
        e(lang('x_collections_made_public', $total), 'm');
    }
}

if (isset($_POST['make_private_selected']) && is_array($_POST['check_collection'])) {
    foreach($_POST['check_collection'] as $cid){
        Collections::getInstance()->collection_actions('make_private', $cid);
    }
    if( empty(errorhandler::getInstance()->get_error()) ){
        errorhandler::getInstance()->flush();
    }
    $total = count($_POST['check_collection']);
    if( $total == 1 ){
        e(lang('collection_made_private'), 'm');
    } else {
        e(lang('x_collections_made_private', $total), 'm');
    }
}

$carray = [];
if( isset($_POST['search']) ){
    if( !empty($_POST['collection_name']) ){
        $carray['collection_name'] = $_POST['collection_name'];
    }
    if( !empty($_POST['collectionid']) ){
        $carray['collection_id'] = $_POST['collectionid'];
    }
    if( !empty($_POST['collection_type']) ){
        $carray['type'] = $_POST['collection_type'];
    }
    if( !empty($_POST['userid']) ){
        $carray['userid'] = $_POST['userid'];
    }
    if( !empty($_POST['order']) ){
        switch($_POST['order']){
            default:
                break;

            case 'total_objects':
                $carray['order'] = $_POST['order'] . ' DESC';
                break;

            case 'collection_id':
            case 'collection_name':
                $carray['order'] = Collection::getInstance()->getTableName() . '.' . $_POST['order'] . ' DESC';
                break;
        }
    }
    if( !empty($_POST['featured']) ){
        $carray['featured'] = $_POST['featured'];
    }
    if( !empty($_POST['active']) ){
        $carray['active'] = $_POST['active'];
    }
    if( !empty($_POST['broadcast']) ){
        $carray['broadcast'] = $_POST['broadcast'];
    }
    if( !empty($_POST['tags']) ){
        $carray['tags'] = $_POST['tags'];
    }
}

/* CREATING LIMIT */
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

$carray['limit'] = $get_limit;
$carray['allow_children'] = true;
$carray['hide_empty_collection'] = 'no';
if (empty($carray['order'])) {
    $carray['order'] = Collection::getInstance()->getTableName() . '.collection_id DESC';
}
$carray['join_flag'] = true;
$collections = Collection::getInstance()->getAll($carray);
assign('collections', $collections);

if( empty($collections) ){
    $total_rows = 0;
} else if( count($collections) < config('admin_pages') && ($page == 1 || empty($page)) ){
    $total_rows = count($collections);
} else {
    $carray['count'] = true;
    unset($carray['limit']);
    unset($carray['order']);
    $total_rows = Collection::getInstance()->getAll($carray);
}

$total_pages = count_pages($total_rows, config('admin_pages'));
pages::getInstance()->paginate($total_pages, $page);

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'jquery-ui-1.13.2.min.js'                                  => 'admin',
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'advanced_search/advanced_search' . $min_suffixe . '.js'   => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('collection');
assign('available_tags', $available_tags);
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());

subtitle(lang('manage_x', strtolower(lang('collections'))));
template_files('collection_manager.html');
display_it();
