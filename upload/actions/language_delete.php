<?php
define('THIS_PAGE', 'language_delete');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

Language::delete_lang($_POST['language_id']);
display_language_list();