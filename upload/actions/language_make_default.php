<?php
define('THIS_PAGE', 'language_make_default');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

if (!empty($_POST['make_default'])) {
    Language::getInstance()->make_default($_POST['make_default']);
}

display_language_list();
