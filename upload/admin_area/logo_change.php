<?php
define('THIS_PAGE', 'logo_change');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('admin_access', true);
pages::getInstance()->page_redir();

subtitle('Logo Changer');

template_files('under_development.html');
display_it();
