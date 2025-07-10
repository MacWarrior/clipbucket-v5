<?php
define('THIS_PAGE', 'admin_save_subtitle');
const IS_AJAX = true;

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

save_subtitle_ajax();
