<?php
const THIS_PAGE = 'language_delete';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

Language::delete_lang($_POST['language_id']);
display_language_list();