<?php
define('THIS_PAGE','upload_thumb');
require 'includes/config.inc.php';

global $userquery, $myquery, $db, $Upload;

$userquery->logincheck();

if(@$_GET['msg']){
    $msg[] = clean($_GET['msg']);
}

$video = mysql_clean($_GET['video']);

//Check Video Exists or Not
if($myquery->VideoExists($video))
{
    # Setting Default thumb
    if(isset($_POST['update_default_thumb'])) {
        $myquery->set_default_thumb($video,$_POST['default_thumb']);
    }

    $data = get_video_details($video);
    $vid_file = VIDEOS_DIR.DIRECTORY_SEPARATOR.$data['file_directory'].DIRECTORY_SEPARATOR.get_video_file($data,false,false);

    # Uploading Thumbs
    if(isset($_POST['upload_thumbs'])) {
        $Upload->upload_thumbs($data['file_name'],$_FILES['vid_thumb'],$data['file_directory'],$data['thumbs_version']);
    }

    # Generating more thumbs
    if(isset($_GET['gen_more']))
    {
        $thumbs_settings_28 = thumbs_res_settings_28();
        $vid_file = get_high_res_file($data,true);
        $thumbs_num = config('num_thumbs');

        $thumbs_input['vid_file'] = $vid_file;
        $thumbs_input['num'] = $thumbs_num;
        $thumbs_input['duration'] = $data['duration'];

        $thumbs_input['file_directory'] = $data['file_directory'];
        $thumbs_input['file_name'] = $data['file_name'];

        require_once(BASEDIR.'/includes/classes/sLog.php');
        $log = new SLog();

        require_once(BASEDIR.'/includes/classes/conversion/ffmpeg.class.php');
        $ffmpeg = new FFMpeg($log);
        foreach ($thumbs_settings_28 as $key => $thumbs_size)
        {
            $height_setting = $thumbs_size[1];
            $width_setting = $thumbs_size[0];
            $thumbs_input['dim'] = $width_setting.'x'.$height_setting;
            if($key == 'original'){
                $thumbs_input['dim'] = $key;
                $thumbs_input['size_tag'] = $key;
            } else {
                $thumbs_input['size_tag'] = $width_setting.'x'.$height_setting;
            }
            $ffmpeg->generateThumbs($thumbs_input);
        }

        e(lang('Video thumbs has been regenerated successfully'),'m');
        $db->update(tbl('video'), array('thumbs_version'), array(VERSION), " file_name = '".$data['file_name']."' ");
    }

    Assign('data',$data);
    Assign('rand',rand(44,444));
} else {
    $msg[] = lang('class_vdo_del_err');
}

redirect_to('/edit_video.php?vid='.$data['videoid']);
