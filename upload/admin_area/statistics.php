<?php
define('THIS_PAGE', 'statistics');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('web_config_access', true);

template_files('under_development.html');
display_it();
