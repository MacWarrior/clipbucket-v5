<?php
global $userquery, $pages, $cbphoto, $Cbucket, $breadcrumb;
define('THIS_PAGE', 'edit_photo');
require_once '../includes/admin_config.php';

$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

// TODO : Complete URL
/* Generating breadcrumb */
$breadcrumb[0] = [
    'title' => 'Photos',
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => 'Photo Manager',
    'url'   => ADMIN_BASEURL . '/photo_manager.php'
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

$p = $cbphoto->get_photo($id);
$p['user'] = $p['userid'];

assign('data', $p);

$requiredFields = $cbphoto->load_required_forms($p);
$otherFields = $cbphoto->load_other_forms($p);
assign('requiredFields', $requiredFields);
assign('otherFields', $otherFields);

if (in_dev()) {
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
$Cbucket->addAdminJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin',
    'pages/edit_photo/edit_photo' . $min_suffixe . '.js'       => 'admin'
]);

$Cbucket->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);

$available_tags = Tags::fill_auto_complete_tags('photo');
assign('available_tags', $available_tags);

subtitle('Edit Photo');
template_files('edit_photo.html');
display_it();
