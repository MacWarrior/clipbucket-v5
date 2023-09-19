<?php
define('THIS_PAGE', 'edit_photo');
define('PARENT_PAGE', 'photos');

require 'includes/config.inc.php';

global $userquery, $cbphoto, $Cbucket;

$userquery->login_check('edit_video');

$udetails = $userquery->get_user_details(user_id());
assign('user', $udetails);
assign('p', $userquery->get_user_profile($udetails['userid']));

$pid = mysql_clean($_GET['photo']);
$photo = $cbphoto->get_photo($pid);

if (empty($photo)) {
    e(lang('photo_not_exist'));
} elseif ($photo['userid'] != user_id()) {
    e(lang('You can not edit this photo.'));
    $Cbucket->show_page = false;
} else {
    if (isset($_POST['update_photo'])) {
        $cbphoto->update_photo();
        $photo = $cbphoto->get_photo($pid);
    }
    assign('p', $photo);
}

if (in_dev()) {
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}

$Cbucket->addJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/edit_photo/edit_photo' . $min_suffixe . '.js'       => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin'
]);
$Cbucket->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);

$available_tags = Tags::fill_auto_complete_tags('photo');
assign('available_tags', $available_tags);

subtitle(lang('Edit Photo'));
template_files('edit_photo.html');
display_it();
