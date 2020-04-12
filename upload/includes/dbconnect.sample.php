<?php
$BDTYPE = 'mysql';
//Database Host
$DBHOST = 'localhost';
//Database Name
$DBNAME = 'clipbucket_svn';
//Database Username
$DBUSER = 'root';
//Database Password
$DBPASS = '';
//Setting Table Prefix
define('TABLE_PREFIX','cb_');

$db = new Clipbucket_db();

$db->connect($DBHOST,$DBNAME,$DBUSER,$DBPASS);
