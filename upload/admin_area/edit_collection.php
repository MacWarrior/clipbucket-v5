<?php
const THIS_PAGE = 'edit_collection';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('collection_moderation', true);
pages::getInstance()->page_redir();

$id = $_GET['collection'];
if (isset($_POST['update_collection'])) {
    Collections::getInstance()->update_collection();
    if (isset($_POST['default_thumb'])) {
        Collection::getInstance()->setDefautThumb($_POST['default_thumb'], $id);
    }
}

if (isset($_POST['delete_preview'])) {
    $id = mysql_clean($_POST['delete_preview']);
    Collections::getInstance()->delete_thumbs($id);
}

//Performing Actionsf
if ($_GET['mode'] != '') {
    Collections::getInstance()->collection_actions($_GET['mode'], $id);
}

$collection = Collection::getInstance()->getOne([
    'collection_id'         => $id,
    'hide_empty_collection' => 'no',
    'with_items'            => true
]);
if (empty($collection)) {
    redirect_to(DirPath::getUrl('admin_area') . 'collection_manager.php?missing_collection=1');
}

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
$breadcrumb[2] = [
    'title' => 'Editing : ' . display_clean($collection['collection_name']),
    'url'   => DirPath::getUrl('admin_area') . 'edit_collection.php?collection=' . display_clean($id)
];

$items = Collection::getInstance()->getItemRecursivly(['collection_id'=> $collection['collection_id']]);
if ($collection['type'] == 'videos') {
    foreach ($items as &$item) {
        $item['id'] = $item['videoid'];
    }
} else {
    foreach ($items as &$item) {
        $item['id'] = $item['photo_id'];
    }
}
assign('items', $items);
assign('data', $collection);
assign('link_user', DirPath::getUrl('admin_area') . 'view_user.php?uid=' . $collection['userid']);

$params = [];
$params['type'] = 'cl';
$params['type_id'] = $collection['collection_id'];
$params['order'] = ' comment_id DESC';
$comments = Comments::getAll($params);
assign('comments', $comments);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'tag-it' . $min_suffixe . '.js'                                => 'admin',
    'pages/edit_collection/edit_collection' . $min_suffixe . '.js' => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js'     => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);

if( config('enable_visual_editor_comments') == 'yes' ){
    ClipBucket::getInstance()->addAdminJS(['toastui/toastui-editor-all' . $min_suffixe . '.js' => 'libs']);
    ClipBucket::getInstance()->addAdminCSS(['/toastui/toastui-editor' . $min_suffixe . '.css' => 'libs']);
}

$available_tags = Tags::fill_auto_complete_tags('collection');
assign('available_tags', $available_tags);
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
assign('randon_number', rand(-5000, 5000));
subtitle('Edit Collection');
template_files('edit_collection.html');
display_it();
