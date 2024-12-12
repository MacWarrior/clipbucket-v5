<?php
class CBEmail
{
    var $smtp = false;
    var $db_tpl = 'email_templates';

    public static function getInstance()
    {
        global $cbemail;
        return $cbemail;
    }

    function __construct()
    {
        //Constructor - do nothing
    }

    /**
     * Function used to get email template from database
     *
     * @param $code
     *
     * @return bool|array
     * @throws Exception
     */
    function get_email_template($code)
    {
        $result = Clipbucket_db::getInstance()->select(tbl($this->db_tpl), "*", " email_template_code='" . $code . "' OR email_template_id='$code' ");
        if (count($result) > 0) {
            $result[0]['email_template'] = stripslashes($result[0]['email_template']);
            $result[0]['email_template_subject'] = stripslashes($result[0]['email_template_subject']);
            return $result[0];
        }
        return false;
    }

    /**
     * @throws Exception
     */
    function get_template($code)
    {
        return $this->get_email_template($code);
    }

    /**
     * Check template exists or not
     *
     * @param $code
     *
     * @return bool
     * @throws Exception
     */
    function template_exists($code)
    {
        return $this->get_email_template($code);
    }

    /**
     * Function used to replace content
     * of email template with variables
     * it can either be email subject or message content
     *
     * @param : Content STRING
     * @param : array ARRAY => array({somevar}=>$isvar)
     *
     * @return null|string|string[]
     */
    function replace($content, $array)
    {
        //Common Variables
        $com_array = [
            '{website_title}' => TITLE,
            '{baseurl}'       => BASEURL,
            '{website_url}'   => BASEURL,
            '{date_format}'   => cbdate(DATE_FORMAT),
            '{date}'          => cbdate(),
            '{username}'      => user_name(),
            '{userid}'        => user_id(),
            '{date_year}'     => cbdate("Y"),
            '{date_month}'    => cbdate("m"),
            '{date_day}'      => cbdate("d"),
            '{signup_link}'   => cblink(['name' => 'signup'], true),
            '{login_link}'    => cblink(['name' => 'login'], true)
        ];

        if (is_array($array) && count($array) > 0) {
            $array = array_merge($com_array, $array);
        } else {
            $array = $com_array;
        }
        foreach ($array as $key => $val) {
            $var_array[] = '/' . $key . '/';
            $val_array[] = $val;
        }
        return preg_replace($var_array, $val_array, $content);
    }

    /**
     * Function used to get all templates
     * @throws Exception
     */
    function get_templates()
    {
        $results = Clipbucket_db::getInstance()->select(tbl($this->db_tpl), "*", null, null, " email_template_name DESC");
        if (count($results) > 0) {
            return $results;
        }
        return false;
    }

    /**
     * Function used to update email template
     *
     * @param $params
     * @throws Exception
     */
    function update_template($params)
    {
        $id = $params['id'];
        $subj = $params['subj'];
        $msg = $params['msg'];

        if (!$this->template_exists($id)) {
            e(lang("email_template_not_exist"));
        } elseif (empty($subj)) {
            e(lang("email_subj_empty"));
        } elseif (empty($msg)) {
            e(lang("email_msg_empty"));
        } else {
            Clipbucket_db::getInstance()->update(
                tbl($this->db_tpl),
                ["email_template_subject", "email_template"],
                [$subj, '|no_mc|' . $msg],
                " email_template_id='$id'"
            );
            e(lang("email_tpl_has_updated"), "m");
        }
    }

    /**
     * Mass Email
     *
     * @param null $array
     *
     * @return bool
     * @throws Exception
     */
    function add_mass_email($array = null): bool
    {
        if (!$array) {
            $array = $_POST;
        }

        $from = $array['from'];
        unset($array['from']);
        $loop = $array['loop_size'];
        $subj = $array['subject'];
        unset($array['subject']);
        $msg = $array['message'];
        unset($array['message']);
        $users = $array['users'];
        unset($array['users']);
        $method = $array['method'];
        unset($array['method']);

        $settings = $array;
        unset($array);

        if (!isValidEmail($from)) {
            e(lang('Please enter valid email in \'from\' field'));
        }
        if (!is_numeric($loop) || $loop < 1 || $loop > 10000) {
            e(lang('Please enter valid numeric value from 1 to 10000 for loop size'));
        }
        if (!$subj) {
            e(lang('Please enter a valid subject for your email'));
        }
        if (!$msg) {
            e(lang('Email body was empty, please enter your email content'));
        }

        if (!error()) {
            Clipbucket_db::getInstance()->insert(tbl('mass_emails'), ['email_subj', 'email_from', 'email_msg', 'configs', 'users', 'method', 'status', 'date_added'],
                [$subj, $from, '|no_mc|' . $msg, '|no_mc|' . json_encode($settings), $users, $method, 'pending', now()]);

            e('Mass email has been added', 'm');
            return true;
        }
        return false;
    }

    /**
     * function used to get email
     * @throws Exception
     */
    function get_mass_emails()
    {
        $results = Clipbucket_db::getInstance()->select(tbl("mass_emails"), "*");

        if (count($results) > 0) {
            return $results;
        }
        return false;
    }

    /**
     * function used to delete, send emails
     *
     * @param $id
     * @param $action
     *
     * @return bool|void
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function action($id, $action)
    {
        $email = $this->email_exists($id);
        if (!$email) {
            e(lang("Email does not exist"));
            return false;
        }

        switch ($action) {
            case "delete":
                Clipbucket_db::getInstance()->execute("DELETE FROM " . tbl('mass_emails') . " WHERE id='$id'");
                e(lang("Email has been deleted"), "m");
                break;

            case "send_email":
                $this->send_emails($email);
                break;
        }
    }

    /**
     * function used to check email exists or not
     *
     * @param $id
     *
     * @return bool|array
     * @throws Exception
     */
    function get_email($id)
    {
        $result = Clipbucket_db::getInstance()->select(tbl('mass_emails'), '*', 'id='.mysql_clean($id));
        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    /**
     * @throws Exception
     */
    function email_exists($id)
    {
        return $this->get_email($id);
    }

    /**
     * @param $id
     *
     * @return array|bool|void
     * @throws Exception
     */
    function send_emails($id)
    {
        global $cbemail;
        if (!is_array($id)) {
            $email = $this->get_email($id);
        } else {
            $email = $id;
        }

        if ($email['status'] == 'completed') {
            return false;
        }
        $settings = json_decode($email['configs'], true);
        $users = $email['users'];
        $total = $email['total'];

        //Creating limit
        $start_index = $email['start_index'];
        $limit = $start_index . ',' . $settings['loop_size'];

        //Creating condition
        $condition = "";

        //Levels
        $level_query = "";
        $levels = $settings['level'];
        if ($levels) {
            foreach ($levels as $level) {
                if ($level_query) {
                    $level_query .= " OR ";
                }
                $level_query .= " level='$level' ";
            }

            if ($condition) {
                $condition .= " AND ";
            }
            $condition = $level_query = " ( " . $level_query . ") ";
        }

        //Categories
        $cats_query = "";
        $cats = $settings['cat'];
        if ($cats) {
            foreach ($cats as $cat) {
                if ($cats_query) {
                    $cats_query .= " OR ";
                }
                $cats_query .= " category='$cat' ";
            }

            $cats_query = " ( " . $cats_query . ") ";
            if ($condition) {
                $condition .= " AND ";
            }
            $condition .= $cats_query;
        }

        //Ative users
        if ($settings['active'] != 'any') {
            if ($condition) {
                $condition .= " AND ";
            }

            if ($settings['active'] == 'yes') {
                $condition .= "	usr_status = 'Ok' ";
            }
            if ($settings['active'] == 'no') {
                $condition .= "	usr_status = 'ToActivate' ";
            }
        }

        //Banned users
        if ($settings['ban'] != 'any') {
            if ($condition) {
                $condition .= " AND ";
            }

            if ($settings['ban'] == 'yes') {
                $condition .= "	ban_status = 'yes' ";
            }
            if ($settings['ban'] == 'no') {
                $condition .= "	ban_status = 'no' ";
            }
        }

        if (!$users) {
            $users = Clipbucket_db::getInstance()->select(tbl("users"), "*", $condition, $limit, " userid ASC ");

            if (!$total) {
                $total = Clipbucket_db::getInstance()->count(tbl("users"), "userid", $condition);
            }

            $sent = $email['sent'];
            $send_msg = [];
            foreach ($users as $user) {
                $var = [
                    '{username}'   => $user['username'],
                    '{userid}'     => $user['userid'],
                    '{email}'      => $user['email'],
                    '{datejoined}' => $user['doj'],
                    '{avcode}'     => $user['avcode'],
                    '{avlink}'     => '/activation.php?av_username=' . $user['username'] . '&avcode=' . $user['avcode']
                ];
                $subj = $cbemail->replace($email['email_subj'], $var);
                $msg = nl2br($cbemail->replace($email['email_msg'], $var));

                $send_message = "";

                //Now Finally Sending Email
                cbmail(['from_name' => TITLE, 'to' => $user['email'], 'from' => $email['email_from'], 'subject' => $subj, 'content' => $msg]);
                $sent++;

                $send_msg[] = $user['userid'] . ": Email has been sent to <strong><em>" . $user['username'] . "</em></strong>";
            }

            $sent_to = $start_index + $settings['loop_size'];

            if ($sent_to > $total) {
                $sent_to = $total;
            }

            e(lang('Sending email from %s to %s', [$start_index + 1, $sent_to]), 'm');

            $start_index = $start_index + $settings['loop_size'];

            if ($sent == $total || $sent > $total) {
                $status = 'completed';
            } else {
                $status = 'sending';
            }

            Clipbucket_db::getInstance()->update(tbl('mass_emails'), ['sent', 'total', 'start_index', 'status', 'last_update'],
                [$sent, $total, $start_index, $status, now()], " id='" . $email['id'] . "' ");

            return $send_msg;
        }
    }


    /**
     * @param $email
     * @param $username
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    function friend_request_email($email, $username)
    {
        $condition = "email = '$email'";
        $receiver_name = Clipbucket_db::getInstance()->select(tbl('users'), 'username', $condition);
        $var = ['{sender}'        => user_name(),
                '{website_title}' => TITLE,
                '{reciever}'      => $receiver_name[0]['username'],
                '{sender_link}'   => '/user/' . $username,
                '{request_link}'  => '/manage_contacts.php?mode=manage',
        ];
        $templates = $this->get_templates();
        $subj = $this->replace($templates[10]['email_template_subject'], $var);
        $msg = nl2br($this->replace($templates[10]['email_template'], $var));
        cbmail(['from_name' => TITLE, 'to' => $email, 'from' => WEBSITE_EMAIL, 'subject' => $subj, 'content' => $msg]);
    }
}
