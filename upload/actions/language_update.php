<?php
define('THIS_PAGE', 'language_update');
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

Language::update_lang($_POST);

display_language_edit();
