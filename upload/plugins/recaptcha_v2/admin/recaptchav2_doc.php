<?php
if (!defined('IN_CLIPBUCKET')) {
    exit('Invalid access');
}

User::getInstance()->hasPermissionOrRedirect('admin_access', true);
$pages->page_redir();

if (!defined('MAIN_PAGE')) {
    define('MAIN_PAGE', 'reCaptcha v2');
}
if (!defined('SUB_PAGE')) {
    define('SUB_PAGE', "ReCaptcha v2 docs");
}

subtitle("Documentation");
template_files(RECAPTCHA_V2_DIR . '/admin/recaptchav2_doc.html');
