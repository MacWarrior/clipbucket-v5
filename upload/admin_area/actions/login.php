<?php
const THIS_PAGE = 'admin_login';
const IS_AJAX = true;


require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
$redirect = DirPath::getUrl('admin_area') . 'index.php';

require_once DirPath::get('core').'login_core.php';
