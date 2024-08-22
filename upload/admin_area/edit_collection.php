<?php
define('THIS_PAGE', 'edit_collection');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages, $cbcollection, $cbvideo, $cbphoto, $cbvid;

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
$pages->page_redir();

if (!isset($_GET['collection'])) {
    redirect_to('/collection_manager.php');
}

if (isset($_POST['update_collection'])) {
    $cbcollection->update_collection();
}

if (isset($_POST['delete_preview'])) {
    $id = mysql_clean($_POST['delete_preview']);
    $cbcollection->delete_thumbs($id);
}

$id = $_GET['collection'];
//Performing Actionsf
if ($_GET['mode'] != '') {
    $cbcollection->collection_actions($_GET['mode'], $id);
}

$c = Collection::getInstance()->getOne([
    'collection_id'         => $id,
    'hide_empty_collection' => 'no'
]);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('collections'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('manage_collections'),
    'url'   => DirPath::getUrl('admin_area') . 'collection_manager.php'
];
$breadcrumb[2] = [
    'title' => 'Editing : ' . display_clean($c['collection_name']),
    'url'   => DirPath::getUrl('admin_area') . 'edit_collection.php?collection=' . display_clean($id)
];

switch ($c['type']) {
    case 'videos':
    case 'v':
        $items = $cbvideo->collection->get_collection_items_with_details($c['collection_id'], null, 4);
        break;

    case 'photos':
    case 'p':
        $items = $cbphoto->collection->get_collection_items_with_details($c['collection_id'], null, 4);
        break;
}

assign('data', $c);

$FlaggedPhotos = $cbvid->action->get_flagged_objects();
Assign('flaggedPhoto', $FlaggedPhotos);
$count_flagged_photos = $cbvid->action->count_flagged_objects();
Assign('count_flagged_photos', $FlaggedPhotos);

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'tag-it' . $min_suffixe . '.js'                                => 'admin',
    'pages/edit_collection/edit_collection' . $min_suffixe . '.js' => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js'     => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('collection');
assign('available_tags', $available_tags);
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
assign('randon_number', rand(-5000, 5000));
subtitle('Edit Collection');
template_files('edit_collection.html');
display_it();
