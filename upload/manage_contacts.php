<?php
define('THIS_PAGE', 'manage_channels');
define('PARENT_PAGE', 'channels');

require 'includes/config.inc.php';

userquery::getInstance()->logincheck();

$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));

$mode = $_GET['mode'];
if ($mode = 'request' && isset($_GET['confirm'])) {
    $confirm = mysql_clean($_GET['confirm']);
    userquery::getInstance()->confirm_request($confirm);
}

if ($mode = 'delete' && isset($_GET['userid'])) {
    $userid = mysql_clean($_GET['userid']);
    userquery::getInstance()->remove_contact($userid);
}

assign('mode', 'manage');
subtitle(lang('user_manage_contacts'));
template_files('manage_contacts.html');
display_it();
