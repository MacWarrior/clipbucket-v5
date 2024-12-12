<?php
define('THIS_PAGE', 'verify_converted_videos');

global $cbvideo;

$in_bg_cron = true;

include(dirname(__FILE__) . '/../includes/config.inc.php');

cb_call_functions('verify_converted_videos_cron');

$fileName = false;
if ($argv[1]) {
    $fileName = $argv[1];
}

$files = get_video_being_processed($fileName);

if (is_array($files)) {
    foreach ($files as $file) {
        $file_details = get_file_details($fileName, true);

        Clipbucket_db::getInstance()->update(tbl('conversion_queue'),
            ['cqueue_conversion', 'time_completed'],
            ['yes', time()], " cqueue_id = '" . $file['cqueue_id'] . "'");

        /**
         * Calling Functions after converting Video
         */
        if (get_functions('after_convert_functions')) {
            foreach (get_functions('after_convert_functions') as $func) {
                if (@function_exists($func)) {
                    $func($file_details);
                }
            }
        }

        if(config('disable_email') == 'no') {
            //Sending Subscription Emails
            $videoDetails = $cbvideo->get_video($file['cqueue_name'], true);

            if( !empty($videoDetails) && $videoDetails['status'] == 'Successful' && in_array($videoDetails['broadcast'], ['public', 'logged']) && $videoDetails['subscription_email'] == 'pending' && $videoDetails['active'] == 'yes' ){
                userquery::getInstance()->sendSubscriptionEmail($videoDetails, true);
            }
        }
    }
}
