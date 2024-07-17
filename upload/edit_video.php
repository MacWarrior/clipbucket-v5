<?php
define('THIS_PAGE', 'edit_video');
define('PARENT_PAGE', 'videos');

require 'includes/config.inc.php';

if( config('videosSection') != 'yes' ){
    redirect_to(BASEURL);
}

global $userquery, $pages, $cbvid, $Upload, $eh;

$userquery->logincheck();
$pages->page_redir();

$userid = user_id();
$udetails = $userquery->get_user_details($userid);
assign('user', $udetails);
assign('p', $userquery->get_user_profile($udetails['userid']));

$vid = mysql_clean($_GET['vid']);
//get video details
$vdetails = Video::getInstance()->getOne(['videoid'=>$vid]);

if ($vdetails['userid'] != $userid) {
    e(lang('no_edit_video'));
    ClipBucket::getInstance()->show_page = false;
} else {
    //Updating Video Details
    if (isset($_POST['update_video'])) {
        $Upload->validate_video_upload_form();
        if (empty($eh->get_error())) {
            $_POST['videoid'] = $vid;
            $cbvid->update_video();
            $cbvid->set_default_thumb($vid, mysql_clean(post('default_thumb')));
            $vdetails = $cbvid->get_video($vid);
        }
    }

    assign('v', $vdetails);
    assign('vidthumbs', get_thumb($vdetails,TRUE,'168x105','auto'));
    assign('vidthumbs_custom', get_thumb($vdetails,TRUE,'168x105','custom'));
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin',
    'pages/edit_video/edit_video' . $min_suffixe . '.js' => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('video');
assign('available_tags', $available_tags);

subtitle(lang('vdo_edit_vdo'));
template_files('edit_video.html');
display_it();
