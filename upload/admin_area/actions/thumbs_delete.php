<?php
define('THIS_PAGE', 'delete_thumbs');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

# Generating more thumbs
$data = Video::getInstance()->getOne(['videoid'=>$_POST['videoid']]);

$num = $_POST['num'];
delete_video_thumb($data, $num, $_POST['type']);
display_thumb_list($data, $_POST['type']);
