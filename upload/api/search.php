<?php
include('../includes/config.inc.php');
include('global.php');

$request = $_REQUEST;
$type = $request['type'];
$page = mysql_clean($request['page']);
$limit = 20;

if (!$type) {
    $type = 'video';
}

$search = cbsearch::init_search($type);
$search->limit = create_query_limit($page, $limit);
$search->key = mysql_clean($request['query']);

$results = $search->search();
print_r($results);
die;
