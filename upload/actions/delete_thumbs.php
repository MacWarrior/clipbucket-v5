<?php
define('THIS_PAGE', 'delete_thumbs');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

# Generating more thumbs
$data = Video::getInstance()->getOne(['videoid'=>$_POST['videoid']]);

$num = $_POST['num'];
delete_video_thumb($data, $num, $_POST['type']);
display_thumb_list($data, $_POST['type']);
