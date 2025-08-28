<?php
const THIS_PAGE = 'language_restore';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

Language::restore_lang($_POST['code']);

display_language_list();
