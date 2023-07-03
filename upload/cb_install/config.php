<?php
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
define('TABLE_PREFIX', '_TABLE_PREFIX_');

$db = new Clipbucket_db();

$db->connect($DBHOST, $DBNAME, $DBUSER, $DBPASS);

/*
 * Enable this array to overwrite configurations over DB values
 * This is usefull when you have multiple server working on a single DB with different server configurations
 *
 * $config_overwrite = [
 *    'config_name' => 'config_value'
 *    ,'config_name2' => 'config_value2'
 * ];
 */
