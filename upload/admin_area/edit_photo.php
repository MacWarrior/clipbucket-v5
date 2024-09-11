<?php
global $pages, $cbphoto, $breadcrumb;
define('THIS_PAGE', 'edit_photo');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
$pages->page_redir();

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
    $cbphoto->update_photo();
}

//Performing Actions
if ($_GET['mode'] != '') {
    $cbphoto->photo_actions($_GET['mode'], $id);
}

$p = Photo::getInstance()->getOne(['photo_id'=>$id]);
if (empty($p)) {
    redirect_to(BASEURL . DirPath::getUrl('admin_area') . 'photo_manager.php?missing_photo=' . ( $_GET['mode'] == 'delete' ? '2' : '1'));
}
$p['user'] = $p['userid'];

assign('data', $p);

$requiredFields = $cbphoto->load_required_forms($p);
$otherFields = $cbphoto->load_other_forms($p);
assign('requiredFields', $requiredFields);
assign('otherFields', $otherFields);

$min_suffixe = in_dev() ? '' : '.min';
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
