<?php
function install_cb_link_video_mode()
{
    global $db;
    $db->execute("ALTER TABLE " . tbl('video') . " ADD `remote_play_url` TEXT NOT NULL ");
}

install_cb_link_video_mode();
