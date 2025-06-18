<?php
define('THIS_PAGE', 'edit_photo');
define('PARENT_PAGE', 'photos');
require 'includes/config.inc.php';

User::getInstance()->isUserConnectedOrRedirect();

User::getInstance()->hasPermissionOrRedirect('edit_video');

global $breadcrumb;
$breadcrumb[0] = ['title' => 'Photos', 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('photos'))), 'url' => 'manage_photos.php'];
$breadcrumb[2] = ['title' => lang('manage_x', strtolower(lang('photos'))), 'url' => DirPath::getUrl('admin_area') . 'photo_manager.php'];

$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));

$pid = mysql_clean($_GET['photo']);
$photo = Photo::getInstance()->getOne(['photo_id' => $pid]);

if (empty($photo)) {
    e(lang('photo_not_exist'));
} elseif ($photo['userid'] != user_id()) {
    e(lang('You can not edit this photo.'));
    ClipBucket::getInstance()->show_page = false;
} else {
    if (isset($_POST['update_photo'])) {
        CBPhotos::getInstance()->update_photo();
        $photo = Photo::getInstance()->getOne(['photo_id' => $pid]);
    }
    assign('p', $photo);
}

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/edit_photo/edit_photo' . $min_suffixe . '.js'       => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('photo');
assign('available_tags', $available_tags);

subtitle(lang('edit_photo'));
template_files('edit_photo.html');
display_it();
