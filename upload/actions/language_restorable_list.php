<?php
define('THIS_PAGE', 'language_restorable_list');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

display_restorable_language_list();
