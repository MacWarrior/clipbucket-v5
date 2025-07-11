<?php
const THIS_PAGE = 'language_add';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

Language::add_lang($_POST);

display_language_list();
