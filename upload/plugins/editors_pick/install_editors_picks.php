<?php
function install_editors_pick()
{
    global $db;
    $db->execute(
        'CREATE TABLE IF NOT EXISTS ' . tbl('editors_picks') . " (
        `pick_id` int(225) NOT NULL AUTO_INCREMENT,
        `videoid` int(225) NOT NULL,
        `sort` bigint(5) NOT NULL DEFAULT '1',
        `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`pick_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
    );
    $db->execute('ALTER TABLE ' . tbl('video') . " ADD `in_editor_pick` varchar(255) DEFAULT 'no'");
}

install_editors_pick();
