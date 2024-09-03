<?php
define('CB_PM', 'ON');
define('CB_PM_MAX_INBOX', 500); // 0 - OFF , U - Unlimited

/**
 * Function used to to attach video to pm
 *
 * @param array => 'attachment_video'
 *
 * @return string|void
 * @throws Exception
 */
function attach_video($array)
{
    global $cbvid;
    if ($cbvid->video_exists($array['attach_video'])) {
        return '{v:' . $array['attach_video'] . '}';
    }
}

/**
 * Function used to pars video from attachment
 *
 * @param $att
 * @throws Exception
 */
function parse_and_attach_video($att)
{
    global $cbvid;
    preg_match('/{v:(.*)}/', $att, $matches);
    $vkey = $matches[1];
    if (!empty($vkey)) {
        assign('video', $cbvid->get_video($vkey));
        assign('only_once', true);
        echo '<h3>Attached Video</h3>';
        echo '<div class="clearfix videos row">';
        template('blocks/videos/video.html');
        echo '</div>';
    }
}

/**
 * Function used to add custom video attachment form field
 * @throws Exception
 */
function video_attachment_form(): array
{
    global $cbvid;
    $vid_array = ['user' => user_id(), 'order' => 'date_added DESC', 'limit' => 15];
    $videos = $cbvid->get_videos($vid_array);
    $vids_array = ['' => lang('no_video')];

    if ($videos) {
        foreach ($videos as $video) {
            $vids_array[$video['videokey']] = display_clean($video['title']);
        }
    }

    return [
        'video_form' => [
            'title'         => lang('usr_attach_video'),
            'type'          => 'dropdown',
            'name'          => 'attach_video',
            'id'            => 'attach_video',
            'value'         => $vids_array,
            'checked'       => post('attach_video'),
            'anchor_before' => 'before_video_attach_box',
        ]
    ];
}


class cb_pm
{
    /**
     * Private messages table
     */
    var $tbl = 'messages';

    /**
     * Allow multi users
     */
    var $multi = true;

    /**
     * Default Template
     */
    var $email_template = 'pm_email_message';

    //Attachment functions
    var $pm_attachments = ['attach_video'];
    var $pm_attachments_parse = ['parse_and_attach_video'];
    var $pm_custom_field = [];

    /**
     * Sending PM
     * @throws Exception
     */
    function send_pm($array): bool
    {
        $to = $this->check_users($array['to'], $array['from']);

        //checking from user
        if (!userquery::getInstance()->user_exists($array['from'])) {
            e(lang('unknown_sender'));
            return false;
        }
        if (!$to) {//checking to user
            return false;
        }
        if (empty($array['subj'])) {//Checking if subject is empty
            e(lang('class_subj_err'));
            return false;
        }
        if (empty($array['content'])) {
            e(lang('please_enter_message'));
            return false;
        }

        $from = $this->get_the_user($array['from']);
        $attachments = $this->get_attachments($array);

        $fields = ['message_from', 'message_to', 'message_content', 'message_subject', 'date_added', 'message_attachments'];
        $values = [$from, $to, $array['content'], $array['subj'], now(), $attachments];

        $fields_tmp = $fields;
        $values_tmp = $values;
        $fields_tmp[] = 'message_box';
        $values_tmp[] = 'in';

        Clipbucket_db::getInstance()->insert(tbl($this->tbl), $fields_tmp, $values_tmp);
        $array['msg_id'] = Clipbucket_db::getInstance()->insert_id();

        if ($array['is_pm']) {
            $fields_tmp = $fields;
            $values_tmp = $values;

            $fields_tmp[] = 'message_box';
            $values_tmp[] = 'out';
            $fields_tmp[] = 'message_status';
            $values_tmp[] = 'read';

            Clipbucket_db::getInstance()->insert(tbl($this->tbl), $fields_tmp, $values_tmp);
        }

        //Sending Email
        //$this->send_pm_email($array);
        e(lang('pm_sent_success'), 'm');
        return true;
    }


    /**
     * Function used to check input users
     * are valid or not
     *
     * @param $input
     * @param $sender
     *
     * @return bool|string
     * @throws Exception
     */
    function check_users($input, $sender)
    {
        if (empty($input)) {
            e(lang("unknown_reciever"));
        } else {
            //check if usernames are separated by colon ';'
            $input = preg_replace('/;/', ',', $input);
            //Now Exploding Input and converting it to and array
            $usernames = explode(',', $input);

            //Now Checking for valid usernames
            $valid_users = [];
            foreach ($usernames as $username) {
                $user_id = $this->get_the_user($username);
                if (userquery::getInstance()->is_user_banned($username, user_id())) {
                    e(lang('cant_pm_banned_user', $username));
                } elseif (userquery::getInstance()->is_user_banned(user_name(), $username)) {
                    e(lang('cant_pm_user_banned_you', $username));
                } elseif (!userquery::getInstance()->user_exists($username) || $user_id == userquery::getInstance()->get_anonymous_user()) {
                    e(lang('unknown_reciever'));
                } elseif ($user_id == $sender) {
                    e(lang('you_cant_send_pm_yourself'));
                } else {
                    $valid_users[] = $user_id;
                }
            }

            $valid_users = array_unique($valid_users);

            if (count($valid_users) > 0) {
                $vusers = '';
                foreach ($valid_users as $vu) {
                    $vusers .= '#' . $vu . '#';
                }
                return $vusers;
            }
        }
        return false;
    }

    /**
     * Function used to get user
     */
    function get_the_user($user)
    {
        if (!is_numeric($user)) {
            return userquery::getInstance()->get_user_field_only($user, 'userid');
        }
        return $user;
    }

    /**
     * Function used to make attachment valid
     * and embed it in the message
     */
    function get_attachments($array): string
    {
        $funcs = $this->pm_attachments;
        $attachments = '';

        if (is_array($funcs)) {
            foreach ($funcs as $func) {
                if (function_exists($func)) {
                    $attachments .= $func($array);
                }
            }
        }
        return $attachments;
    }

    /**
     * function used to check weather message is reply or not
     *
     * @param $id
     * @param $uid
     *
     * @return bool
     * @throws Exception
     */
    function is_reply($id, $uid): bool
    {
        $results = Clipbucket_db::getInstance()->select(tbl($this->tbl), 'message_to', ' message_id = \'' . mysql_clean($id) . '\' AND message_to LIKE \'%#' . mysql_clean($uid) . '#%\'');
        if (count($results) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to get message from inbox, set the template
     * and display it
     *
     * @param $id
     *
     * @return bool|array
     * @throws Exception
     */
    function get_message($id)
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->tbl), '*', " message_id='$id'");
        if (count($result) > 0) {
            return $result[0];
        }
        e(lang('no_pm_exist'));
        return false;
    }

    /**
     * Function used to get user INBOX Message
     *
     * @param $mid
     * @param null $uid
     * @return bool|array
     * @throws Exception
     */
    function get_inbox_message($mid, $uid = null)
    {
        if (!$uid) {
            $uid = user_id();
        }
        $result = Clipbucket_db::getInstance()->select(tbl($this->tbl . ',users'), tbl($this->tbl . '.*,users.userid,users.username'), " message_id='$mid' AND message_to LIKE '%#$uid#%' AND userid=" . tbl($this->tbl) . '.message_from', null, ' date_added DESC ');

        if (count($result) > 0) {
            return $result[0];
        }
        e(lang('no_pm_exist'));
        return false;
    }

    /**
     * Function used to get user OUTBOX Message
     *
     * @param $mid
     * @param null $uid
     * @return bool|array
     * @throws Exception
     */
    function get_outbox_message($mid, $uid = null)
    {
        if (!$uid) {
            $uid = user_id();
        }
        $result = Clipbucket_db::getInstance()->select(tbl($this->tbl . ',users'), tbl($this->tbl . '.*,users.userid,users.username'), " message_id='$mid' AND message_from='$uid' AND userid=" . tbl($this->tbl . ".message_from"));

        if( !empty($result) ) {
            return $result[0];
        }
        e(lang('no_pm_exist'));
        return false;
    }

    /**
     * Function used to get user inbox messages
     * @throws Exception
     */
    function get_user_messages($uid, $box = 'all', $count_only = false)
    {
        if (!$uid) {
            $uid = user_id();
        }

        switch ($box) {
            case 'all':
                if ($count_only) {
                    $result = Clipbucket_db::getInstance()->count(tbl($this->tbl), 'message_id', " message_to LIKE '%#$uid#%' AND message_type='pm' ");
                } else {
                    $result = Clipbucket_db::getInstance()->select(tbl($this->tbl . ',users'), tbl($this->tbl . '.*,users.username AS message_from_user '),
                        tbl($this->tbl) . ".message_to LIKE '%#$uid#%' AND " . tbl("users") . ".userid = " . tbl($this->tbl) . ".message_from 
										   AND message_type='pm'", null, " date_added DESC");
                }
                break;

            case 'in':
                if ($count_only) {
                    $result = Clipbucket_db::getInstance()->count(tbl($this->tbl), 'message_id', " message_to LIKE '%#$uid#%' AND message_box ='in' AND message_type='pm' ");
                } else {
                    $result = Clipbucket_db::getInstance()->select(tbl($this->tbl . ',users'), tbl($this->tbl . '.*,users.username AS message_from_user '),
                        tbl($this->tbl) . ".message_to LIKE '%#$uid#%' AND " . tbl("users") . ".userid = " . tbl($this->tbl) . ".message_from 
										  AND " . tbl($this->tbl) . ".message_box ='in' AND message_type='pm'", null, " date_added DESC");
                }
                break;

            case 'out':
                if ($count_only) {
                    $result = Clipbucket_db::getInstance()->count(tbl($this->tbl), 'message_id', " message_from = '$uid' AND message_box ='out' ");
                } else {
                    $result = Clipbucket_db::getInstance()->select(tbl($this->tbl . ',users'), tbl($this->tbl . '.*,users.username AS message_from_user '),
                        tbl($this->tbl) . ".message_from = '$uid' AND " . tbl("users") . ".userid = " . tbl($this->tbl) . ".message_from 
										  AND " . tbl($this->tbl) . ".message_box ='out'", null, " date_added DESC");
                    //One More Query Need To be executed to get username of recievers
                    $count = 0;

                    $cond = "";
                    if (is_array($result)) {
                        foreach ($result as $re) {
                            $cond = '';
                            preg_match_all("/#(.*)#/Ui", $re['message_to'], $receivers);

                            foreach ($receivers[1] as $to_user) {

                                if (!empty($to_user)) {
                                    if (!empty($cond)) {
                                        $cond .= " OR ";
                                    }
                                    $cond .= " userid = '$to_user' ";
                                }
                            }

                            $to_names = Clipbucket_db::getInstance()->select(tbl('users'), 'username', $cond);
                            $t_names = [];

                            if (is_array($to_names)) {
                                foreach ($to_names as $tn) {
                                    $t_names[] = $tn[0];
                                }
                            }
                            if (is_array($t_names)) {
                                $to_user_names = implode(', ', $t_names);
                            } else {
                                $to_user_names = $t_names;
                            }
                            $result[$count]['to_usernames'] = $to_user_names;
                            $count++;
                        }
                    }
                }
                break;

            case 'notification':
                if ($count_only) {
                    $result = Clipbucket_db::getInstance()->count(tbl($this->tbl), 'message_id', " message_to LIKE '%#$uid#%' AND message_box ='in' AND message_type='pm' ");
                } else {
                    $result = Clipbucket_db::getInstance()->select(tbl($this->tbl . ',users'), tbl($this->tbl . '.*,users.username AS message_from_user '),
                        tbl($this->tbl) . ".message_to LIKE '%#$uid#' AND " . tbl("users.userid") . " = " . tbl($this->tbl) . ".message_from 
										  AND " . tbl($this->tbl) . ".message_box ='in' AND message_type='notification'", null, " date_added DESC");
                }
        }

        if( !empty($result) ){
            return $result;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    function get_user_inbox_messages($uid, $count_only = false)
    {
        return $this->get_user_messages($uid, 'in', $count_only);
    }

    /**
     * @throws Exception
     */
    function get_user_outbox_messages($uid, $count_only = false)
    {
        return $this->get_user_messages($uid, 'out', $count_only);
    }

    /**
     * @throws Exception
     */
    function get_user_notification_messages($uid, $count_only = false)
    {
        return $this->get_user_messages($uid, 'notification', $count_only);
    }

    /**
     * Function used parse attachments
     *
     * @param $attachment
     */
    function parse_attachments($attachment)
    {
        $funcs = $this->pm_attachments_parse;
        if (is_array($funcs)) {
            $attachments = '';
            foreach ($funcs as $func) {
                if (function_exists($func)) {
                    $attachments .= $func($attachment);
                }
            }
        }
    }


    /**
     * Function used to create PM FORM
     * @throws Exception
     */
    function load_compose_form(): array
    {
        $to = post('to');
        $to = $to ? $to : get('to');

        $array = [
            'to'      => [
                'title'    => lang('to'),
                'type'     => 'textfield',
                'name'     => 'to',
                'id'       => 'to',
                'value'    => $to,
                'required' => 'yes'
            ],
            'subj'    => [
                'title'    => lang('subject'),
                'type'     => 'textfield',
                'name'     => 'subj',
                'id'       => 'subj',
                'value'    => post('subj'),
                'required' => 'yes'
            ],
            'content' => [
                'title'         => lang('content'),
                'type'          => 'textarea',
                'name'          => 'content',
                'id'            => 'pm_content',
                'value'         => post('content'),
                'required'      => 'yes',
                'anchor_before' => 'before_pm_compose_box',
            ]
        ];

        $videos = video_attachment_form();
        $this->add_custom_field($videos);

        return array_merge($array, $this->pm_custom_field);
    }


    /**
     * Function used to add custom pm field
     */
    function add_custom_field($array)
    {
        $this->pm_custom_field = array_merge($array, $this->pm_custom_field);
    }


    /**
     * Function used to send PM EMAIL
     * @throws Exception
     */
    function send_pm_email($array)
    {
        global $cbemail, $userquery;
        $sender = userquery::getInstance()->get_user_field_only($array['from'], 'username');
        $content = mysql_clean($array['content']);
        $subject = mysql_clean($array['subj']);
        $msgid = $array['msg_id'];
        //Get To(Emails)
        $emails = $this->get_users_emails($array['to']);

        $vars = [
            '{sender}'  => $sender,
            '{content}' => $content,
            '{subject}' => $subject,
            '{msg_id}'  => $msgid
        ];

        $tpl = $cbemail->get_template($this->email_template);
        $subj = $cbemail->replace($tpl['email_template_subject'], $vars);
        $msg = $cbemail->replace($tpl['email_template'], $vars);

        cbmail(['to' => $emails, 'from' => WEBSITE_EMAIL, 'subject' => $subj, 'content' => $msg, 'nl2br' => true]);
    }

    /**
     * Function used to get emails of users from input
     * @throws Exception
     */
    function get_users_emails($input): string
    {
        //check if usernames are sperated by colon ';'
        $input = preg_replace('/;/', ',', $input);
        //Now Exploding Input and converting it to and array
        $usernames = explode(',', $input);
        $cond = '';
        foreach ($usernames as $user) {
            if (!empty($user)) {
                if (!empty($cond)) {
                    $cond .= " OR ";
                }
                $cond .= " username ='" . $user . "' ";
            }
        }

        $emails = [];
        $results = Clipbucket_db::getInstance()->select(tbl(userquery::getInstance()->dbtbl['users']), 'email', $cond);
        foreach ($results as $result) {
            $emails[] = $result['email'];
        }
        return implode(',', $emails);
    }


    /**
     * Function used to set private message status as read
     * @throws Exception
     */
    function set_message_status($mid, $status = 'read')
    {
        if ($mid) {
            Clipbucket_db::getInstance()->update(tbl($this->tbl), ['message_status'], [$status], " message_id='$mid'");
        }
    }

    /**
     * Function used to delete message from user messages box
     * @throws Exception
     */
    function delete_msg($mid, $uid, $box = 'in')
    {
        if ($box == 'in') {
            $inbox = $this->get_inbox_message($mid, $uid);
            if ($inbox) {
                $inbox_user = $inbox['message_to'];
                $inbox_user = preg_replace('/#' . $uid . '#/Ui', '', $inbox_user);
                if (empty($inbox_user)) {
                    Clipbucket_db::getInstance()->delete(tbl($this->tbl), ['message_id'], [$mid]);
                } else {
                    Clipbucket_db::getInstance()->update(tbl($this->tbl), ['message_to'], [$inbox_user], ' message_id=\'' . $inbox['message_id'] . '\' ');
                }
                e(lang('msg_delete_inbox'), 'm');
            }
        } else {
            $outbox = $this->get_outbox_message($mid, $uid);
            if ($outbox) {
                Clipbucket_db::getInstance()->delete(tbl($this->tbl), ['message_id'], [$mid]);
                e(lang('msg_delete_outbox'), 'm');
            }
        }
    }
    
    /**
     * Function used to get new messages
     * @throws Exception
     */
    function get_new_messages($uid = null, $type = 'pm')
    {
        if (!$uid) {
            $uid = user_id();
        }

        switch ($type) {
            case 'pm':
            default:
                $count = Clipbucket_db::getInstance()->count(tbl($this->tbl), 'message_id', " message_to LIKE '%#$uid#%' AND message_box='in' AND message_type='pm' AND message_status='unread'");
                break;

            case 'notification':
                $count = Clipbucket_db::getInstance()->count(tbl($this->tbl), 'message_id', " message_to LIKE '%#$uid#%' AND message_box='in' AND message_type='notification' AND message_status='unread'");
                break;
        }

        if ($count > 0) {
            return $count;
        }
        return '0';
    }
}
