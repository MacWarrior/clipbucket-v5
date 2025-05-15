<?php
define('THIS_PAGE', 'process_video');
include(dirname(__FILE__) . '/../includes/config.inc.php');

//Get vid
$vid = $_SERVER['argv'][1];

//Check video exists or not
if (myquery::getInstance()->video_exists($vid)) {
    Upload::getInstance()->do_after_video_upload($vid);
} else {
    e(lang('class_vdo_del_err'));
}
