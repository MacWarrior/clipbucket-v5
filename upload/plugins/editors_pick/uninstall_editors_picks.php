<?php
function un_install_editors_pick()
{
    global $db;
    $db->execute('DROP TABLE ' . tbl('editors_picks'));
    $db->execute('ALTER TABLE ' . tbl('video') . ' DROP `in_editor_pick` ');
}

un_install_editors_pick();
