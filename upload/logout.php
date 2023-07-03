<?php
define('THIS_PAGE', 'logout');
global $userquery;
require_once 'includes/config.inc.php';
$userquery->logout();
set_cookie_secure('is_logout', 'yes');
redirect_to(BASEURL);
