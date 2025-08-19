<?php
const THIS_PAGE = 'language_update';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

Language::update_lang($_POST);

display_language_edit();
