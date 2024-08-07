<?php
define('THIS_PAGE', 'statistics');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('web_config_access');

template_files('under_development.html');
display_it();
