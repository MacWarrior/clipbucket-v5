<?php
function install_global_announcement()
{
	global $db;
	$db->Execute(
        'CREATE TABLE IF NOT EXISTS '.tbl('global_announcement').' (
        `announcement` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
	);
	
	//inserting new announcement
	$db->Execute('INSERT INTO  '.tbl('global_announcement').' (announcement) VALUES (\'\')');
}

//This will first check if plugin is installed or not, if not this function will install the plugin details
install_global_announcement();
