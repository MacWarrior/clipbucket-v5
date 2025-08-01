<?php
const THIS_PAGE = 'login';
const IS_AJAX = true;

require_once dirname(__FILE__, 2) . '/includes/config.inc.php';
$redirect = $_COOKIE['pageredir'] ? : '';

require_once DirPath::get('core').'login_core.php';
