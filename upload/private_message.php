<?php
define('THIS_PAGE', 'private_message');

require 'includes/config.inc.php';

global $cbpm, $eh;

//Adding JS Scroll
add_js('jquery_plugs/compressed/jquery.scrollTo-min.js');

userquery::getInstance()->logincheck();
$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));

$mode = $_GET['mode'];

//Deleting Multiple Message
if (isset($_POST['delete_pm']) && is_array($_POST['msg_id'])) {
    if ($mode == 'inbox' || $mode == 'notification') {
        $box = 'in';
    } else {
        $box = 'out';
    }

    $total = count($_POST['msg_id']);
    for ($pms = 0; $pms < $total; $pms++) {
        if (!empty($_POST['msg_id'][$pms])) {
            $cbpm->delete_msg($_POST['msg_id'][$pms], user_id(), $box);
        }

        $eh->flush();
        e(lang('private_messags_deleted'), 'm');
    }
}

switch ($mode) {
    case 'inbox':
    default:
        assign('mode', 'inbox');

        //Deleting Message
        if ($_GET['delete_mid']) {
            $mid = mysql_clean($_GET['delete_mid']);
            $cbpm->delete_msg($mid, user_id());
        }

        //Getting Message
        if ($_GET['mid']) {
            $mid = mysql_clean($_GET['mid']);
            $pr_msg = $cbpm->get_inbox_message($mid, user_id());
            if ($pr_msg['message_status'] == 'unread') {
                $cbpm->set_message_status($mid, 'read');
            }
            assign('pr_msg', $pr_msg);
        }

        //Get User Messages
        assign('user_msgs', $cbpm->get_user_inbox_messages(user_id()));

        subtitle(lang('com_my_inbox'));
        break;

    case 'sent':
        assign('mode', 'sent');

        //Deleting Message
        if ($_GET['delete_mid']) {
            $mid = mysql_clean($_GET['delete_mid']);
            $cbpm->delete_msg($mid, user_id(), 'out');
        }

        //Getting Message
        if ($_GET['mid']) {
            $mid = mysql_clean($_GET['mid']);
            assign('pr_msg', $cbpm->get_outbox_message($mid, user_id()));
        }

        //Get User Messages
        assign('user_msgs', $cbpm->get_user_outbox_messages(user_id()));

        subtitle(lang('user_sent_box'));
        break;

    case 'notification':
        assign('mode', 'notification');

        //Deleting Message
        if ($_GET['delete_mid']) {
            $mid = mysql_clean($_GET['delete_mid']);
            $cbpm->delete_msg($mid, user_id());
        }

        //Getting Message
        if ($_GET['mid']) {
            $mid = mysql_clean($_GET['mid']);
            assign('pr_msg', $cbpm->get_inbox_message($mid, user_id()));
        }

        //Get User Messages
        assign('user_msgs', $cbpm->get_user_notification_messages(user_id()));

        subtitle(lang('my_notifications'));
        break;

    case 'new_msg':
    case 'compose':
        assign('mode', 'new_msg');

        //Checking if reply
        if ($_GET['reply'] != '') {
            $mid = mysql_clean($_GET['reply']);
            if (!isset($_POST['send_message']) && $cbpm->is_reply($mid, user_id())) {
                $reply_msg = $cbpm->get_inbox_message($mid, user_id());
                $_POST['to'] = userquery::getInstance()->get_user_field_only($reply_msg['message_from'], 'username');
                $_POST['subj'] = 'Re:' . $reply_msg['message_subject'];
            }
        }

        //sending message
        if (isset($_POST['send_message'])) {
            $array = $_POST;
            $array['reply_to'] = mysql_clean($_GET['reply']);
            $array['is_pm'] = true;
            $array['from'] = user_id();
            $cbpm->send_pm($array);
            unset($_POST);
            if (!error()) {
                $_POST = '';
            }
        }

        subtitle(lang('title_crt_new_msg'));
}
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
template_files('private_message.html');
display_it();
