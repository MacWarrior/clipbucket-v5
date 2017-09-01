<?php
	/**
	* @Software : ClipBucket
	* @License : CBLA
	* @version :ClipBucket v2.1
	*/

	$BDTYPE = 'mysql';
	//Database Host
	$DBHOST = '_DB_HOST_';
	//Database Name
	$DBNAME = '_DB_NAME_';
	//Database Username
	$DBUSER = '_DB_USER_';
	//Database Password
	$DBPASS = '_DB_PASS_';
	//Setting Table Prefix
	define('TABLE_PREFIX','_TABLE_PREFIX_');


    $db = new Clipbucket_db();

    $db->connect($DBHOST,$DBNAME,$DBUSER,$DBPASS);
