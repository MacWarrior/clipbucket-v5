<?php
function install_global_announcement()
{
    global $db;
    $db->execute(
        'CREATE TABLE IF NOT EXISTS ' . tbl('global_announcement') . ' (
        `announcement` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
    );

    //inserting new announcement
    $db->execute('INSERT INTO  ' . tbl('global_announcement') . ' (announcement) VALUES (\'\')');
}

install_global_announcement();
