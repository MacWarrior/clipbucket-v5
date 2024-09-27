<?php
define('THIS_PAGE', 'collection_manager');
global $cbcollection, $eh;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
$userquery = userquery::getInstance();
$userquery->admin_login_check();
$userquery->login_check('video_moderation');
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
    $id = mysql_clean($_GET['make_feature']);
    $cbcollection->collection_actions('mcf', $id);
}

if (isset($_GET['make_unfeature'])) {
    $id = mysql_clean($_GET['make_unfeature']);
    $cbcollection->collection_actions('mcuf', $id);
}

if (isset($_GET['activate'])) {
    $id = mysql_clean($_GET['activate']);
    $cbcollection->collection_actions('ac', $id);
}

if (isset($_GET['deactivate'])) {
    $id = mysql_clean($_GET['deactivate']);
    $cbcollection->collection_actions('dac', $id);
}

if (isset($_GET['delete_collection'])) {
    $id = mysql_clean($_GET['delete_collection']);
    $cbcollection->delete_collection($id);
}

/* ACTIONS ON MULTI ITEMS */
if (isset($_POST['activate_selected']) && is_array($_POST['check_collection'])) {
    $total = count($_POST['check_collection']);
    for ($i = 0; $i < $total; $i++) {
        $cbcollection->collection_actions('ac', $_POST['check_collection'][$i]);
    }
    $eh->flush();
    e($total . ' collections has been activated', 'm');
}

if (isset($_POST['deactivate_selected']) && is_array($_POST['check_collection'])) {
    $total = count($_POST['check_collection']);
    for ($i = 0; $i < $total; $i++) {
        $cbcollection->collection_actions('dac', $_POST['check_collection'][$i]);
    }
    $eh->flush();
    e($total . ' collections has been deactivated', 'm');
}

if (isset($_POST['make_featured_selected']) && is_array($_POST['check_collection'])) {
    $total = count($_POST['check_collection']);
    for ($i = 0; $i < $total; $i++) {
        $cbcollection->collection_actions('mcf', $_POST['check_collection'][$i]);
    }
    $eh->flush();
    e($total . ' collections has been marked as <strong>' . lang('featured') . '</strong>', 'm',false);
}

if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_collection'])) {
    $total = count($_POST['check_collection']);
    for ($i = 0; $i < $total; $i++) {
        $cbcollection->collection_actions('mcuf', $_POST['check_collection'][$i]);
    }
    $eh->flush();
    e($total . ' collections has been marked as <strong>Unfeatured</strong>', 'm', false);
}

if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_collection'])) {
    $total = count($_POST['check_collection']);
    for ($i = 0; $i < $total; $i++) {
        $cbcollection->collection_actions('mcuf', $_POST['check_collection'][$i]);
    }
    $eh->flush();
    e($total . ' collections has been marked as <strong>Unfeatured</strong>', 'm', false);
}

if (isset($_POST['delete_selected']) && is_array($_POST['check_collection'])) {
    $total = count($_POST['check_collection']);
    for ($i = 0; $i < $total; $i++) {
        $cbcollection->delete_collection($_POST['check_collection'][$i]);
    }
    $eh->flush();
    e($total . ' collection(s) has been deleted successfully', 'm');
}

/* IF SEARCH EXISTS */
if ($_GET['search']) {
    $carray = [
        'name'      => $_GET['title'],
        'tags'      => $_GET['tags'],
        'cid'       => $_GET['collectionid'],
        'type'      => $_GET['collection_type'],
        'user'      => $_GET['userid'],
        'order'     => $_GET['order'],
        'broadcast' => $_GET['broadcast'],
        'featured'  => $_GET['featured'],
        'active'    => $_GET['active']
    ];
} else {
    $carray = [];
}

/* CREATING LIMIT */
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

$carray['limit'] = $get_limit;
$carray['allow_children'] = true;
$carray['hide_empty_collection'] = 'no';
if (!empty($carray['order'])) {
    $carray['order'] = $carray['order'] . ' DESC';
} else {
    $carray['order'] = ' collection_id DESC';
}

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
assign('anonymous_id', $userquery->get_anonymous_user());

subtitle(lang('manage_x', strtolower(lang('collections'))));
template_files('collection_manager.html');
display_it();
