<?php
define('THIS_PAGE', 'logout');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
$userquery->logout();
redirect_to('index.php');
