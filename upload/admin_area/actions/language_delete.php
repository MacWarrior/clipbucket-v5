<?php
define('THIS_PAGE', 'language_delete');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

Language::delete_lang($_POST['language_id']);
display_language_list();