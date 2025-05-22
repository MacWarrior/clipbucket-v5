<?php
define('THIS_PAGE', 'cookie_consent_get');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

if( config('enable_cookie_banner') != 'yes' ){
    die();
}

assign('custom_cookies', Session::getCookiesList());
echo templateWithMsgJson('blocks/cookie_consent_get.html');
