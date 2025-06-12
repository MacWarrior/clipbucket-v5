<?php
define('THIS_PAGE', 'manage_channels');
define('PARENT_PAGE', 'channels');

require 'includes/config.inc.php';

if (!isSectionEnabled('channels') || User::getInstance()->get('disabled_channel') == 'yes') {
    redirect_to(cblink(['name' => 'my_account']));
}
User::getInstance()->hasPermissionOrRedirect('view_channel', true);
User::getInstance()->hasPermissionOrRedirect('enable_channel_page', true);

$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));
$friend_id = $_REQUEST['userid'];
switch ($_REQUEST['mode']) {
    case 'unfriend':
        userquery::getInstance()->remove_contact($friend_id);
        break;
    case 'accept_request':
        userquery::getInstance()->confirm_request($friend_id);
        break;
    case 'cancel_request':
        userquery::getInstance()->remove_contact($friend_id, User::getInstance()->getCurrentUserID(), true);
        break;
}

assign('mode', 'manage');
subtitle(lang('user_manage_contacts'));
template_files('manage_contacts.html');
display_it();
