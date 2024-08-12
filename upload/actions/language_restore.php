<?php
define('THIS_PAGE', 'language_restore');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

Language::restore_lang($_POST['code']);

display_language_list();
