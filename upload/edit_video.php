<?php
define('THIS_PAGE', 'edit_video');
define('PARENT_PAGE', 'videos');

require 'includes/config.inc.php';

global $userquery, $pages, $cbvid, $Cbucket, $Upload, $eh;

$userquery->logincheck();
$pages->page_redir();

$userid = user_id();
$udetails = $userquery->get_user_details($userid);
assign('user', $udetails);
assign('p', $userquery->get_user_profile($udetails['userid']));

$vid = mysql_clean($_GET['vid']);
//get video details
$vdetails = $cbvid->get_video_details($vid);

if ($vdetails['userid'] != $userid) {
    e(lang('no_edit_video'));
    $Cbucket->show_page = false;
} else {
    //Updating Video Details
    if (isset($_POST['update_video'])) {
        $Upload->validate_video_upload_form();
        if (empty($eh->get_error())) {
            $_POST['videoid'] = $vid;
            $cbvid->update_video();
            $cbvid->set_default_thumb($vid, mysql_clean(post('default_thumb')));
            $vdetails = $cbvid->get_video_details($vid);
        }
    }

    assign('v', $vdetails);
}

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
$Cbucket->addJS(['jquery-ui-1.13.2.min.js' => 'global']);
$Cbucket->addJS(['tag-it'.$min_suffixe.'.js' => 'global']);
$Cbucket->addJS(['init_default_tag/init_default_tag'.$min_suffixe.'.js' => 'admin']);
$Cbucket->addCSS(['jquery.tagit'.$min_suffixe.'.css' => 'admin']);
$Cbucket->addCSS(['tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin']);

subtitle(lang('vdo_edit_vdo'));
template_files('edit_video.html');
display_it();
