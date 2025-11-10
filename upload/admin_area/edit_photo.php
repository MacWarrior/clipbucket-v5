<?php
global $breadcrumb;
const THIS_PAGE = 'edit_photo';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('video_moderation');
pages::getInstance()->page_redir();

// TODO : Complete URL
/* Generating breadcrumb */
$breadcrumb[0] = [
    'title' => 'Photos',
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('manage_x', strtolower(lang('photos'))),
    'url'   => DirPath::getUrl('admin_area') . 'photo_manager.php'
];
$breadcrumb[2] = [
    'title' => 'Edit Photo',
    'url'   => ''
];

$id = mysql_clean($_GET['photo']);

if (isset($_POST['photo_id'])) {
    CBPhotos::getInstance()->update_photo();
}

//Performing Actions
if ($_GET['mode'] != '') {
    CBPhotos::getInstance()->photo_actions($_GET['mode'], $id);
}

$p = Photo::getInstance()->getOne(['photo_id'=>$id]);
if (empty($p)) {
    redirect_to(DirPath::getUrl('admin_area') . 'photo_manager.php?missing_photo=' . ( $_GET['mode'] == 'delete' ? '2' : '1'));
}
$p['user'] = $p['userid'];

assign('data', $p);

if( !empty($p['collection_id']) ){
    $collection_name = Collection::getInstance()->getOne(['collection_id'=>$p['collection_id']])['collection_name'];
    assign('collection_name', $collection_name);
}

$requiredFields = CBPhotos::getInstance()->load_required_forms($p);
$otherFields = CBPhotos::getInstance()->load_other_forms($p);
assign('requiredFields', $requiredFields);
assign('otherFields', $otherFields);
assign('comments', Comments::getAll(['type' => 'p', 'type_id' => $id, 'order' => ' comment_id DESC']));
$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin',
    'pages/edit_photo/edit_photo' . $min_suffixe . '.js'       => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('photo');
assign('available_tags', $available_tags);

subtitle('Edit Photo');
template_files('edit_photo.html');
display_it();
