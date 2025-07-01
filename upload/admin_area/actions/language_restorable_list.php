<?php
define('THIS_PAGE', 'language_restorable_list');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

display_restorable_language_list();
