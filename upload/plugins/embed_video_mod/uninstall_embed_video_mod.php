<?php
require_once('../includes/common.php');

function uninstall_embed_video_mode()
{
	global $db;
	$db->Execute("ALTER TABLE `".tbl('video')."` DROP `embed_code` ");
}
uninstall_embed_video_mode();
