<?php
define('THIS_PAGE', 'language_delete');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

Language::delete_lang($_POST['language_id']);
display_language_list();