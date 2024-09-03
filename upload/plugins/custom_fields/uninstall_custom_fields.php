<?php
require_once('../includes/common.php');

function uninstall_embed_video_mode()
{
    Clipbucket_db::getInstance()->execute("DROP TABLE `" . tbl('custom_fields') . "`");
}

uninstall_embed_video_mode();
