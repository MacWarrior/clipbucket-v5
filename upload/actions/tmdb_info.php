<?php
const THIS_PAGE = 'info_tmdb';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

if (config('tmdb_enable_on_front_end') != 'yes' || config('enable_tmdb') != 'yes' || config('tmdb_token') == '') {
    return false;
}

require DirPath::get('core') . 'tmdb_info_core.php';
