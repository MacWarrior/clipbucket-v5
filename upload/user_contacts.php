<?php
define('THIS_PAGE', 'user_contacts');
define('PARENT_PAGE', 'channels');
require 'includes/config.inc.php';
$pages->page_redir();

$u = $_GET['user'];
$u = $u ? $u : $_GET['userid'];
$u = $u ? $u : $_GET['username'];
$u = $u ? $u : $_GET['uid'];
$u = $u ? $u : $_GET['u'];

$u = mysql_clean($u);
$udetails = $userquery->get_user_details($u);
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('channels_list_per_page'));

if ($udetails) {
    assign('u', $udetails);
    assign('p', $userquery->get_user_profile($udetails['userid']));
    $mode = $_GET['mode'];
    switch ($mode) {
        case 'contacts':
        default:
            assign('p', $userquery->get_user_profile($udetails['userid']));
            assign('mode', $mode);
            assign('friends', $userquery->get_contacts($udetails['userid'], 0, "yes"));
            break;

        case 'subscriptions':
            assign('mode', $mode);
            assign('heading', lang('user_subscriptions', $udetails['username']));
            assign('userSubs', $userquery->get_user_subscriptions($udetails['userid'], null));
            break;

        case 'subscribers':
            assign('mode', $mode);
            assign('heading', lang('users_subscribers', $udetails['username']));
            assign('userSubs', $userquery->get_user_subscribers_detail($udetails['userid'], null));
            break;
    }
} else {
    e(lang('usr_exist_err'));
    ClipBucket::getInstance()->show_page = false;
}

subtitle(lang('users_contacts', $udetails['username']));
if (ClipBucket::getInstance()->show_page) {
    Template('user_contacts.html');
} else {
    display_it();
}
