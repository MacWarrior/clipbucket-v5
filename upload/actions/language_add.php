<?php
define('THIS_PAGE', 'language_add');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

Language::add_lang($_POST);

display_language_list();
