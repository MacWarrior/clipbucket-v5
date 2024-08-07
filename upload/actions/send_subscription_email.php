<?php
global $cbvid;
$in_bg_cron = true;

include(dirname(__FILE__, 2) . '/includes/config.inc.php');

$videoid = $argv[1];

$video = $cbvid->get_video($videoid);

if( !empty($video) && $video['status'] == 'Successful' && in_array($video['broadcast'], ['public', 'logged']) && $video['subscription_email'] == 'pending' && $video['active'] == 'yes' ){
    userquery::getInstance()->sendSubscriptionEmail($video, true);
}
