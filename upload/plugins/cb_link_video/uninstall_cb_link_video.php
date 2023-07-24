<?php
function uninstall_embed_video_mode()
{
    global $db;
    $db->execute("ALTER TABLE " . tbl('video') . " DROP `remote_play_url` ");
}

uninstall_embed_video_mode();
