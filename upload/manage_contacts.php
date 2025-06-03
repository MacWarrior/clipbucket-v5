<?php
define('THIS_PAGE', 'manage_channels');
define('PARENT_PAGE', 'channels');

require 'includes/config.inc.php';

if (!isSectionEnabled('channels') || (!User::getInstance()->hasPermission('view_channel') && (!User::getInstance()->hasPermission('enable_channel_page') || User::getInstance()->get('disabled_channel') == 'yes'))) {
    e(lang('error'));
} elseif (!User::getInstance()->getCurrentUserID()) {
    e(lang('you_not_logged_in'));
} else {
    $friend_details = User::getInstance()->getOne(['userid' => mysql_clean($_POST['friend_id'])]);
    $friend_id = $friend_details['userid'];
    assign('user', $friend_details);

    switch ($_POST['mode']) {
        case 'add_friend':
            $username = user_name();
            $mailId = userquery::getInstance()->get_user_details($friend_id, false, true);
            Email::send_friend_request($mailId['email'], $username);

            if (User::getInstance()->getCurrentUserID()) {
                userquery::getInstance()->add_contact(User::getInstance()->getCurrentUserID(), $friend_id);
            } else {
                e(lang('you_not_logged_in'));
            }
            break;
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
}

echo templateWithMsgJson('blocks/view_channel/channel_add_friend.html');
