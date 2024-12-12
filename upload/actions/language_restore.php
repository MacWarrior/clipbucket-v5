<?php
define('THIS_PAGE', 'language_restore');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

Language::restore_lang($_POST['code']);

display_language_list();
