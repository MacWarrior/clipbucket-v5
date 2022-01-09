<?php
define('THIS_PAGE','verify_converted_videos');

global $ffmpeg, $db, $cbvideo, $userquery;

$in_bg_cron = true;

include(dirname(__FILE__).'/../includes/config.inc.php');

cb_call_functions('verify_converted_videos_cron');

$fileName = false;
if($argv[1]){
	$fileName = $argv[1];
}

$files = get_video_being_processed($fileName);

if(is_array($files)){
    foreach($files as $file)
    {
        $file_details = get_file_details($fileName,true);

        //Thanks to pandusetiawan @ forums.clip-bucket.com
        if($file_details['conversion_status']=='failed' or strpos($file_details['conversion_log'],'Conversion_status : failed') >0)
        {
            update_processed_video($file,'Failed');

            $db->update(tbl('conversion_queue'),
            array('cqueue_conversion'),
            array('yes')," cqueue_id = '".$file['cqueue_id']."'");

            /**
             * Calling Functions after converting Video
             */
            if(get_functions('after_convert_functions'))
            {
                foreach(get_functions('after_convert_functions') as $func)
                {
                    if(@function_exists($func)){
                        $func($file_details);
                    }
                }
            }

        } elseif($file_details['conversion_status']=='completed' or strpos($file_details['conversion_log'],'Conversion_status : completed') >0 or $file_details['conversion_status']=='Successful' or strpos($file_details['conversion_log'],'Conversion_status : Successful') >0) {
            update_processed_video($file,'Successful');
            $db->update(tbl('conversion_queue'),
            array('cqueue_conversion','time_completed'),
            array('yes',time())," cqueue_id = '".$file['cqueue_id']."'");

            /**
             * Calling Functions after converting Video
             */
            if(get_functions('after_convert_functions'))
            {
                foreach(get_functions('after_convert_functions') as $func)
                {
                    if(@function_exists($func)){
                        $func($file_details);
                    }
                }
            }

            //Sending Subscription Emails
            $videoDetails = $cbvideo->get_video($file['cqueue_name'],true);
            if($videoDetails)
            {
                if( ($videoDetails['broadcast']=='public' || $videoDetails['logged']) && $videoDetails['active']=='yes') {
                    $userquery->sendSubscriptionEmail($videoDetails,true);
                }
            }
        }
    }
}
