<?php
define('THIS_PAGE', 'edit_photo');
define('PARENT_PAGE', 'photos');

require 'includes/config.inc.php';

global $userquery, $cbphoto, $Cbucket;

$userquery->login_check('edit_video');

$udetails = $userquery->get_user_details(userid());
assign('user', $udetails);
assign('p', $userquery->get_user_profile($udetails['userid']));

$pid = mysql_clean($_GET['photo']);
$photo = $cbphoto->get_photo($pid);

if (empty($photo)) {
    e(lang('photo_not_exist'));
} elseif ($photo['userid'] != userid()) {
    e(lang('You can not edit this photo.'));
    $Cbucket->show_page = false;
} else {
    if (isset($_POST['update_photo'])) {
        $cbphoto->update_photo();
        $photo = $cbphoto->get_photo($pid);
    }
    assign('p', $photo);
}

subtitle(lang('Edit Photo'));
template_files('edit_photo.html');
display_it();
