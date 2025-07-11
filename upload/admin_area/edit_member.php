<?php
const THIS_PAGE = 'edit_member';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
User::getInstance()->hasPermissionOrRedirect('admin_access', true);

header('location:view_user.php?uid=' . $_GET['uid']);
