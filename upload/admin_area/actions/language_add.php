<?php
define('THIS_PAGE', 'language_add');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

Language::add_lang($_POST);

display_language_list();
