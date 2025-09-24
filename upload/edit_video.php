<?php
const THIS_PAGE = 'edit_video';
const PARENT_PAGE = 'videos';

require 'includes/config.inc.php';

User::getInstance()->isUserConnectedOrRedirect();

if( config('videosSection') != 'yes' ){
    redirect_to(DirPath::getUrl('root'));
}

pages::getInstance()->page_redir();

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
        $_POST['videoid'] = $vid;
        CBvideo::getInstance()->update_video();
        if (empty(errorhandler::getInstance()->get_error())) {
            if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
                e('Sorry, you cannot perform this action until the application has been fully updated by an administrator');
            } else {
                if (!empty($_POST['default_thumb'])) {
                    Video::getInstance()->setDefautThumb($_POST['default_thumb'], 'thumbnail', $vid);
                }
                if (config('enable_video_poster') == 'yes' && !empty($_POST['default_poster'])) {
                    Video::getInstance()->setDefautThumb($_POST['default_poster'], 'poster', $vid);
                }
                if (config('enable_video_backdrop') == 'yes' && !empty($_POST['default_backdrop'])) {
                    Video::getInstance()->setDefautThumb($_POST['default_backdrop'], 'backdrop', $vid);
                }
            }
            $vdetails = Video::getInstance()->getOne(['videoid' => $vid]);
        }
    }

    assign('v', $vdetails);
    assign('vidthumbs', VideoThumbs::getAllThumbFiles($vid, '168','105',type: 'thumbnail', is_auto: true, return_with_num: true) ?: [VideoThumbs::getDefaultMissingThumb(return_with_num: true)]);
    assign('vidthumbs_custom', VideoThumbs::getAllThumbFiles($vid, '168','105',type: 'thumbnail', is_auto: false, return_with_num: true));
    if( config('enable_video_poster') == 'yes' ){
        assign('vidthumbs_poster', get_thumb($vdetails,TRUE,'original','poster'));
    }

    if( config('enable_video_backdrop') == 'yes' ) {
        assign('vidthumbs_backdrop', get_thumb($vdetails, TRUE, 'original', 'backdrop'));
    }

}

$min_suffixe = System::isInDev() ? '' : '.min';
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
$subtitle_list = get_video_subtitles($vdetails) ?: [];
assign('subtitle_list', $subtitle_list);

subtitle(lang('vdo_edit_vdo'));
template_files('edit_video.html');
display_it();
