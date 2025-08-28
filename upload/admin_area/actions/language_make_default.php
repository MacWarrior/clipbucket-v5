<?php
const THIS_PAGE = 'language_make_default';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!empty($_POST['make_default'])) {
    Language::getInstance()->make_default($_POST['make_default']);
}

display_language_list();
