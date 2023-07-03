<?php
error_reporting(-1);
ini_set('display_errors', 1);

define('THIS_PAGE', 'index');
require 'includes/config.inc.php';
global $pages, $userquery;
$pages->page_redir();

if (!$userquery->perm_check('view_videos', false, false, true) && !userid()) {
    template_files('signup_or_login.html');
} else {
    template_files('index.html');
}
display_it();
