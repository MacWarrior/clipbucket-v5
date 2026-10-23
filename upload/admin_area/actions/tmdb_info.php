<?php
const THIS_PAGE = 'admin_info_tmdb';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!User::getInstance()->hasAdminAccess()) {
    return false;
}

if (config('enable_tmdb') != 'yes' || config('tmdb_token') == '') {
    return false;
}

require DirPath::get('core') . 'tmdb_info_core.php';
