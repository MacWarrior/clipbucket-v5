<?php
define('THIS_PAGE', 'logout');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->logout();
redirect_to('index.php');
