<?php
define('THIS_PAGE', 'edit_video');
define('PARENT_PAGE', 'videos');

require 'includes/config.inc.php';

if( config('videosSection') != 'yes' ){
    redirect_to(BASEURL);
}

global $pages, $cbvid, $Upload, $eh;

userquery::getInstance()->logincheck();
$pages->page_redir();

$userid = user_id();
$udetails = userquery::getInstance()->get_user_details($userid);
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));

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
            Video::getInstance()->setDefautThumb($_POST['default_thumb'], 'thumb', $vid);
            Video::getInstance()->setDefautThumb($_POST['default_poster'], 'poster', $vid);
            Video::getInstance()->setDefautThumb($_POST['default_backdrop'], 'backdrop', $vid);
            $vdetails = Video::getInstance()->getOne(['videoid'=>$vid]);
        }
    }

    assign('v', $vdetails);
    assign('vidthumbs', get_thumb($vdetails,TRUE,'168x105','auto'));
    assign('vidthumbs_custom', get_thumb($vdetails,TRUE,'168x105','custom'));
    if( config('enable_video_poster') == 'yes' ){
        assign('vidthumbs_poster', get_thumb($vdetails,TRUE,'original','poster'));
    }

    if( config('enable_video_backdrop') == 'yes' ) {
        assign('vidthumbs_backdrop', get_thumb($vdetails, TRUE, 'original', 'backdrop'));
    }

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
