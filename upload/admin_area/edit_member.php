<?php
define('THIS_PAGE', 'edit_member');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
userquery::getInstance()->admin_login_check();

header('location:view_user.php?uid=' . $_GET['uid']);
