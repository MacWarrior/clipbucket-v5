<?php
$in_bg_cron = true;
define('THIS_PAGE', 'send_subscription_email');
include(dirname(__FILE__, 2) . '/includes/config.inc.php');

$videoid = $argv[1];

$video = CBvideo::getInstance()->get_video($videoid);

if( !empty($video) && $video['status'] == 'Successful' && in_array($video['broadcast'], ['public', 'logged']) && $video['subscription_email'] == 'pending' && $video['active'] == 'yes' ){
    userquery::getInstance()->sendSubscriptionEmail($video, true);
}
