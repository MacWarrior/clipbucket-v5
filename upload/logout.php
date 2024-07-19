<?php
define('THIS_PAGE', 'logout');
require_once 'includes/config.inc.php';

userquery::getInstance()->logout();
set_cookie_secure('is_logout', 'yes');
redirect_to(BASEURL);
