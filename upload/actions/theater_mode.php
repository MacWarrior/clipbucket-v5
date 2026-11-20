<?php
const THIS_PAGE = 'theater_mode';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

$mode = $_POST['mode'] ?? null;
if (in_array($mode, ['normal', 'cinema'], true) && Session::canRememberTheaterMode()) {
    Session::setCookie('theater_mode', $mode);
}

http_response_code(204);
