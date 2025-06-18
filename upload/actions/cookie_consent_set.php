<?php
define('THIS_PAGE', 'cookie_consent_set');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

if( config('enable_cookie_banner') != 'yes' ){
    die();
}

if( !isset($_POST['consent']) ){
    die();
}

Session::setCookieConsent($_POST['consent']);

echo json_encode([
    'cookies'=>Session::getCookiesList()
]);
