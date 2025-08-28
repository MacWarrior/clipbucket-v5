<?php
const THIS_PAGE = 'delete_thumbs';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

# Generating more thumbs
$data = Video::getInstance()->getOne(['videoid'=>$_POST['videoid']]);

$num = $_POST['num'];
delete_video_thumb($data, $num, $_POST['type']);
display_thumb_list($data, $_POST['type']);
