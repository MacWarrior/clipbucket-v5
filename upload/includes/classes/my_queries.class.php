<?php
define('STATIC_COMM', false);

class myquery
{
    static $website_details = [];
    static $video_resolutions = [];

    /**
     * @throws Exception
     */
    function Set_Website_Details($name, $value)
    {
        global $db, $Cbucket;
        $db->update(tbl('config'), ['value'], [$value], " name = '" . $name . "'");
        $Cbucket->configs[$name] = $value;
        static::$website_details[$name] = $value;
    }

    /**
     * @throws Exception
     */
    function Get_Website_Details(): array
    {
        if (!empty(static::$website_details)) {
            return static::$website_details;
        }

        $query = 'SELECT * FROM ' . tbl('config');
        $data = db_select($query);

        if ($data) {
            global $config_overwrite;
            foreach ($data as $row) {
                $name = $row['name'];
                if (isset($config_overwrite, $config_overwrite[$name])) {
                    $data[$name] = $config_overwrite[$name];
                } else {
                    $data[$name] = $row['value'];
                }
            }
        }
        static::$website_details = $data;
        return $data;
    }

    public function getVideoResolutions(): array
    {
        if (!empty(static::$video_resolutions)) {
            return static::$video_resolutions;
        }

        $sql_select = 'SELECT title, ratio, enabled, width, height, video_bitrate FROM ' . tbl('video_resolution') . ' ORDER BY ratio, height DESC';
        $results = db_select($sql_select);

        static::$video_resolutions = [];
        foreach ($results as $line) {
            if (!isset(static::$video_resolutions[$line['ratio']])) {
                static::$video_resolutions[$line['ratio']] = [];
            }
            static::$video_resolutions[$line['ratio']][] = $line;
        }

        return static::$video_resolutions;
    }

    /**
     * @throws Exception
     */
    public function saveVideoResolutions($post)
    {
        global $db;

        $video_resolutions = self::getVideoResolutions();
        foreach ($video_resolutions as $ratio) {
            foreach ($ratio as $resolution) {

                if (isset($post['gen_' . $resolution['title']])) {
                    $post_value = $post['gen_' . $resolution['title']];
                    $enabled = $post_value == 'yes' ? 1 : 0;
                } else {
                    $enabled = 0;
                }

                $db->update(tbl('video_resolution'), ['enabled'], [$enabled], " title = '" . mysql_clean($resolution['title']) . "'");
            }
        }
        static::$video_resolutions = [];
    }

    /**
     * @throws Exception
     */
    public function getEnabledVideoResolutions(string $orderby = ''): array
    {
        $sql_select = 'SELECT height, width FROM ' . tbl('video_resolution') . ' WHERE enabled = 1';
        if ($orderby != '') {
            $sql_select .= ' ORDER BY ' . $orderby;
        }
        $results = db_select($sql_select);

        $data = [];
        foreach ($results as $line) {
            $data[$line['height']] = $line['width'];
        }
        return $data;
    }

    /**
     * @throws Exception
     */
    public function getVideoResolutionBitrateFromHeight($height): int
    {
        $sql_select = 'SELECT video_bitrate FROM ' . tbl('video_resolution') . ' WHERE height = \'' . mysql_clean($height) . '\'';
        $results = db_select($sql_select);

        if (empty($results)) {
            return 0;
        }
        return $results[0]['video_bitrate'];
    }

    /**
     * @throws Exception
     */
    public function getVideoResolutionTitleFromHeight($height): string
    {
        if ($height == 'index') {
            return lang('video_resolution_auto');
        }
        $sql_select = 'SELECT title FROM ' . tbl('video_resolution') . ' WHERE height = \'' . mysql_clean($height) . '\'';
        $results = db_select($sql_select);

        if (empty($results)) {
            return 0;
        }

        return $results[0]['title'];
    }

    /**
     * @throws Exception
     */
    function video_exists($videoid)
    {
        global $cbvid;
        return $cbvid->video_exists($videoid);
    }

    /**
     * Function used to get video details
     * from video table
     *
     * @param INPUT vid or videokey
     *
     * @return bool|mixed|STRING
     * @throws Exception
     */
    function get_video_details($vid)
    {
        global $cbvid;
        return $cbvid->get_video($vid);
    }

    /**
     * Function used to check weather username exists not
     * @throws Exception
     */
    function check_user($username)
    {
        global $userquery;
        return $userquery->username_exists($username);
    }

    /**
     * Function used to check weather email exists not
     * @throws Exception
     */
    function check_email($email)
    {
        global $userquery;
        return $userquery->email_exists($email);
    }

    /**
     * Function used to delete comments
     *
     * @param $cid
     * @param string $type
     * @param bool $is_reply
     * @param bool $forceDelete
     *
     * @return bool|mixed
     * @throws Exception
     */
    function delete_comment($cid, $type = 'v', $is_reply = false, $forceDelete = false)
    {
        global $db;
        //first get comment details

        $cdetails = $this->get_comment($cid);
        $uid = user_id();

        if (($uid == $cdetails['userid'] && $cdetails['userid'] != '')
            || $cdetails['type_owner_id'] == user_id()
            || has_access("admin_del_access", false)
            || $is_reply == true || $forceDelete) {
            $replies = $this->get_child_comments($cid);
            if (count($replies) > 0 && is_array($replies)) {
                foreach ($replies as $reply) {
                    $this->delete_comment($reply['comment_id'], $type, true, $forceDelete);
                }
            }

            $db->execute('DELETE FROM ' . tbl('comments') . " WHERE comment_id='$cid'");

            e(lang('usr_cmt_del_msg'), 'm');
            return $cdetails['type_id'];
        }
        e(lang('no_comment_del_perm'));
        return false;
    }

    /**
     * Function used to set comment as spam
     */
    function spam_comment($cid)
    {
        global $db;
        $comment = $this->get_comment($cid);
        if ($comment) {
            $voters = $comment['spam_voters'];

            $niddle = '|';
            $niddle .= user_id();
            $niddle .= '|';
            $flag = strstr($voters, $niddle);

            if (!$comment) {
                e(lang('no_comment_exists'));
            } elseif (!user_id()) {
                e(lang('login_to_mark_as_spam'));
            } elseif (user_id() == $comment['userid'] || (!user_id() && $_SERVER['REMOTE_ADDR'] == $comment['comment_ip'])) {
                e(lang('no_own_commen_spam'));
            } elseif (!empty($flag)) {
                e(lang('already_spammed_comment'));
            } else {
                if (empty($voters)) {
                    $voters .= '|';
                }

                $voters .= user_id();
                $voters .= '|';

                $newscore = $comment['spam_votes'] + 1;
                $db->update(tbl('comments'), ['spam_votes', 'spam_voters'], [$newscore, $voters], " comment_id='$cid'");
                e(lang('spam_comment_ok'), 'm');
                return $newscore;
            }

        }
        e(lang('no_comment_exists'));
        return false;
    }

    /**
     * Function used to set comment as spam
     */
    function remove_spam($cid)
    {
        global $db;
        $comment = $this->get_comment($cid);
        $vote = '0';
        $none = '';

        if ($comment) {
            $votes = $comment['spam_votes'];
            if (!$votes) {
                e(lang('Comment is not a spam'));
            } elseif (!user_id()) {
                e(lang('login_to_mark_as_spam'));
            } else {
                $db->update(tbl('comments'), ['spam_votes', 'spam_voters'], [$vote, $none], " comment_id='$cid'");
                e(lang('Spam removed from comment.'), 'm');
            }
        } else {
            e(lang('no_comment_exists'));
        }
    }


    /***
     * Function used to rate comment
     **
     *
     * @param $rate
     * @param $cid
     *
     * @return bool|mixed
     * @throws Exception
     */
    function rate_comment($rate, $cid)
    {
        global $db;
        $comment = $this->get_comment($cid);
        $voters = $comment['voters'];

        $niddle = '|';
        $niddle .= user_id();
        $niddle .= '|';
        $flag = strstr($voters, $niddle);

        if (!$comment) {
            e(lang('no_comment_exists'));
        } elseif (!user_id()) {
            e(lang('class_comment_err6'));
        } elseif (user_id() == $comment['userid'] || (!user_id() && $_SERVER['REMOTE_ADDR'] == $comment['comment_ip'])) {
            e(lang('no_own_commen_rate'));
        } elseif (!empty($flag)) {
            e(lang('class_comment_err7'));
        } else {
            if (empty($voters)) {
                $voters .= '|';
            }

            $voters .= user_id();
            $voters .= '|';

            $newscore = $comment['vote'] + $rate;
            $db->update(tbl('comments'), ['vote', 'voters'], [$newscore, $voters], " comment_id='$cid'");

            e(lang('thanks_rating_comment'), 'm');
            return $newscore;
        }

        return false;
    }

    /**
     * Function used to add comment
     * This is more advance function ,
     * in this function functions can be applied on comments
     *
     * @param        $comment
     * @param        $obj_id
     * @param null $reply_to
     * @param string $type
     * @param null $obj_owner
     * @param null $obj_link
     * @param bool $force_name_email
     *
     * @return bool|mixed
     * @throws phpmailerException
     * @throws Exception
     */
    function add_comment($comment, $obj_id, $reply_to = null, $type = 'v', $obj_owner = null, $obj_link = null, $force_name_email = false)
    {
        global $userquery, $eh, $db, $Cbucket;
        //Checking maximum comments characters allowed
        if (defined('MAX_COMMENT_CHR')) {
            $comment_len = strlen($comment);
            if ($comment_len > MAX_COMMENT_CHR) {
                e(sprintf("'%d' characters allowed for comment", MAX_COMMENT_CHR));
            } elseif ($comment_len < 5) {
                e('Comment is too short. It should be at least 5 characters');
            }
        }
        if (!verify_captcha()) {
            e(lang('recap_verify_failed'));
        }
        if (empty($comment)) {
            e(lang('pelase_enter_something_for_comment'));
        }

        $params = ['comment' => $comment, 'obj_id' => $obj_id, 'reply_to' => $reply_to, 'type' => $type];
        $this->validate_comment_functions($params);

        if (!user_id() && $Cbucket->configs['anonym_comments'] != 'yes') {
            e(lang('you_not_logged_in'));
        }

        if ((!user_id() && $Cbucket->configs['anonym_comments'] == 'yes') || $force_name_email) {
            //Checking for input name and email
            if (empty($_POST['name'])) {
                e(lang('please_enter_your_name'));
            }
            if (empty($_POST['email'])) {
                e(lang('please_enter_your_email'));
            }

            $name = $_POST['name'];
            $email = $_POST['email'];
        }

        if (empty($eh->get_error())) {
            $userid = user_id() ? user_id() : 'NULL';
            $db->insert(
                tbl('comments'),
                ['type,comment,type_id,userid,date_added,parent_id,anonym_name,anonym_email', 'comment_ip', 'type_owner_id'],
                [$type, $comment, $obj_id, $userid, NOW(), $reply_to, ($name ?? ''), ($email ?? ''), $_SERVER['REMOTE_ADDR'], $obj_owner]
            );
            $cid = $db->insert_id();

            if (user_id()) {
                $db->update(tbl('users'), ['total_comments'], ['|f|total_comments+1'], " userid='" . user_id() . "'");
            }

            e(lang('grp_comment_msg'), 'm');

            $own_details = $userquery->get_user_field_only($obj_owner, 'email');

            $username = user_name();
            $username = $username ? $username : post('name');
            $useremail = $email ?? '';

            $fullname = $username;

            if ($userquery->udetails['fullname']) {
                $fullname = $userquery->udetails['fullname'];
            }

            //Adding Comment Log
            $log_array = [
                'success'        => 'yes',
                'action_obj_id'  => $cid,
                'action_done_id' => $obj_id,
                'details'        => 'made a comment',
                'username'       => $username,
                'useremail'      => $useremail
            ];
            insert_log($type . '_comment', $log_array);

            //sending email
            if (SEND_COMMENT_NOTIFICATION == 'yes' && $own_details) {
                global $cbemail;
                $tpl = $cbemail->get_template('user_comment_email');

                $var = [
                    '{username}' => $username,
                    '{fullname}' => $fullname,
                    '{obj_link}' => $obj_link . '#comment_' . $cid,
                    '{comment}'  => $comment,
                    '{obj}'      => get_obj_type($type)
                ];

                $subj = $cbemail->replace($tpl['email_template_subject'], $var);
                $msg = nl2br($cbemail->replace($tpl['email_template'], $var));

                //Now Finally Sending Email
                cbmail(['to' => $own_details, 'from' => WEBSITE_EMAIL, 'subject' => $subj, 'content' => $msg]);

                if ($reply_to != 0) {
                    $tpl = $cbemail->get_template('user_reply_email');

                    $more_var = [
                        '{username}' => $username,
                        '{fullname}' => $fullname,
                        '{obj_link}' => $obj_link . '#comment_' . $cid,
                        '{comment}'  => $comment,
                        '{obj}'      => get_obj_type($type)
                    ];
                    $var = array_merge($more_var, $var);
                    $subj = $cbemail->replace($tpl['email_template_subject'], $var);
                    $msg = nl2br($cbemail->replace($tpl['email_template'], $var));

                    $cd = $this->get_comment($reply_to);
                    $replying_to_email = $cd['email'];
                    cbmail(['to' => $replying_to_email, 'from' => WEBSITE_EMAIL, 'subject' => $subj, 'content' => $msg]);
                }
            }

            //Adding Video Feed
            addFeed(['action' => 'comment_video', 'comment_id' => $cid, 'object_id' => $obj_id, 'object' => 'video']);
            return $cid;
        }

        return false;
    }

    /**
     * Function used to  get file details from database
     */
    function file_details($file_name)
    {
        return get_file_details($file_name);
    }

    /**
     * Function used to update video and set a thumb as default
     *
     * @param $vid
     * @param $thumb
     *
     * @return void
     * @throws Exception
     */
    function set_default_thumb($vid, $thumb)
    {
        global $cbvid;
        $cbvid->set_default_thumb($vid, $thumb);
    }

    /**
     * Function used to update video
     */
    function update_video()
    {
        global $cbvid;
        return $cbvid->update_video();
    }

    /**
     * Function used to get categorie details
     *
     * @param $id
     *
     * @return array
     * @throws Exception
     */
    function get_category($id): array
    {
        global $db;
        $results = $db->select(tbl('category'), '*', " categoryid='$id'");
        return $results[0];
    }


    /**
     * Function used to get comment from its ID
     *
     * @param $id
     *
     * @return array|bool
     * @throws Exception
     */
    function get_comment($id)
    {
        global $db, $userquery;
        $result = $db->select(tbl('comments'), '*', " comment_id='$id'");
        if (count($result) > 0) {
            $result = $result[0];
            if ($result['userid']) {
                $udetails = $userquery->get_user_details($result['userid']);
            }
            $avatar_url = $userquery->getUserThumb($udetails, true);
            $udetails['avatar_url'] = $avatar_url;
            if ($udetails) {
                $result = array_merge($result, $udetails);
            }
            return $result;
        }
        return false;
    }

    /**
     * Function used to get from database
     *
     * @param string $type_id
     * @param string $type
     * @param bool $count_only
     * @param string $get_type
     * @param        $parent_id
     *
     * @return bool
     * @throws Exception
     */
    function get_comments($type_id = '*', $type = 'v', $count_only = false, $get_type = 'all', $parent_id = null): bool
    {
        $params = [
            'type_id'    => $type_id,
            'type'       => $type,
            'count_only' => $count_only,
            'get_type'   => $get_type,
            'parent_id'  => $parent_id
        ];

        return $this->getComments($params);
    }


    /**
     * Function used to get comments against parent_id from database
     *
     * @param $parent_id
     *
     * @return array
     * @throws Exception
     */
    function get_child_comments($parent_id = null): array
    {
        global $db;
        return $db->select(tbl('comments'), '*', " parent_id='" . mysql_clean($parent_id) . "'");
    }

    /**
     * Function used to get using ARRAY as parameter
     * @throws Exception
     */
    function getComments($params)
    {
        global $db;
        $cond = '';

        $p = $params;
        extract($p, EXTR_SKIP);

        switch ($type) {
            case 'video':
            case 'videos':
            case 'v':
            case 'vdo':
                $type = 'v';
                break;

            case 'photo':
            case 'p':
            case 'photos':
                $type = 'p';
                break;

            case 'social':
            case 's':
                $type = 's';
                break;

            case 'channel':
            case 'c':
            case 'channels':
                $type = 'c';
                break;

            case 'cl':
            case 'collect':
            case 'collection':
            case 'collections':
                $type = 'cl';
                break;

        }

        if (!$count_only && STATIC_COMM) {
            $file = $type . $type_id . str_replace(',', '_', $limit) . '-' . strtotime($last_update) . '.tmp';

            $files = glob(COMM_CACHE_DIR . DIRECTORY_SEPARATOR . $type . $type_id . str_replace(',', '_', $limit) . '*');

            $theFile = getName($files[0]);
            $theFileDetails = explode('-', $theFile);
            $timeDiff = time() - $theFileDetails[1];

            if (file_exists(COMM_CACHE_DIR . DIRECTORY_SEPARATOR . $file) && $timeDiff < COMM_CACHE_TIME) {
                return json_decode(file_get_contents(COMM_CACHE_DIR . DIRECTORY_SEPARATOR . $file), true);
            }
        }

        if (!$order) {
            $order = ' date_added DESC ';
        }
        #Checking if user wants to get replies of comment
        if ($parent_id != null && $get_reply_only) {
            $cond .= " AND parent_id='$parent_id'";
        } else {
            $cond .= " AND parent_id='0' ";
        }

        if ($type_id != '*') {
            $typeid_query = "AND type_id='$type_id' ";
        }

        if (!$count_only) {
            /**
             * we have to get comments in such way that
             * comment replies comes along with their parents
             * in order to achieve this, we have to create a complex logic
             * lets see if we can get some tips from WP commenting system ;)
             * HAIL Open Source
             */
            $query = "SELECT * FROM " . tbl('comments');
            $query .= " WHERE type='$type' $typeid_query $cond ";

            if ($order) {
                $query .= ' ORDER BY ' . $order;
            }

            if ($limit) {
                $query .= ' LIMIT '.$limit;
            }

            $results = db_select($query);

            foreach ($results as $key => $val) {
                $results[$key]['comment'] = $results[$key]['comment'];
            }

            if (!$results) {
                return false;
            }

            //getting relies of comments
            if ($results) {
                $parents_array = [];
                foreach ($results as $result) {
                    $query = "SELECT * FROM " . tbl('comments');
                    $query .= " WHERE type='$type' $typeid_query AND parent_id='" . $result['comment_id'] . "' ";
                    $replies = db_select($query);

                    foreach ($replies as $key => $val) {
                        $replies[$key]['comment'] = $replies[$key]['comment'];
                    }

                    if ($replies) {
                        $replies = ['comments' => $replies];
                        $result['children'] = $replies;
                    } else {
                        $result['children'] = '';
                    }

                    $parents_array[] = $result;
                }
            }

            $comment['comments'] = $parents_array;

            //Deleting any other previuos comment file
            $files = glob(COMM_CACHE_DIR . DIRECTORY_SEPARATOR . $type . $type_id . str_replace(',', '_', $limit) . '*');

            foreach ($files as $delFile) {
                if (file_exists($delFile)) {
                    unlink($delFile);
                }
            }

            //Caching comment file
            if ($file) {
                file_put_contents(COMM_CACHE_DIR . DIRECTORY_SEPARATOR . $file, json_encode($comment));
            }
            foreach ($comment['comments'] as $key => $c) {
                $tempCom[] = $c;
            }
            $comment['comments'] = $tempCom;
            return $comment;
        }

        return $db->count(tbl('comments'), '*', " type='$type' $typeid_query $cond");
    }

    /**
     * Function used to set website template
     */
    function set_template($template)
    {
        global $myquery;
        if (is_dir(STYLES_DIR . DIRECTORY_SEPARATOR . $template) && $template) {
            $myquery->Set_Website_Details('template_dir', $template);
            e(lang('template_activated'), 'm');
        } else {
            e(lang('error_occured_changing_template'));
        }
    }

    /**
     * Function used to update comment
     * @throws Exception
     */
    function update_comment($cid, $text)
    {
        global $db;
        $db->execute('UPDATE ' . tbl('comments') . ' SET comment=\''.mysql_clean($text).'\' WHERE comment_id=\''.mysql_clean($cid).'\'');
    }

    /**
     * @throws Exception
     */
    function get_todos()
    {
        global $db;
        return $db->select(tbl('admin_todo'), '*', ' userid=\'' . user_id() . '\'', null, ' date_added DESC ');
    }

    /**
     * @throws Exception
     */
    function insert_todo($text)
    {
        global $db;
        $db->insert(tbl('admin_todo'), ['todo,date_added,userid'], [mysql_clean($text), NOW(), user_id()]);
    }

    /**
     * @throws Exception
     */
    function update_todo($id, $text)
    {
        global $db;
        $db->execute('UPDATE ' . tbl('admin_todo') . ' SET todo=\'' . mysql_clean($text) . '\' WHERE comment_id=\''.mysql_clean($id).'\'');
    }

    /**
     * @throws Exception
     */
    function delete_todo($id)
    {
        global $db;
        $db->delete(tbl('admin_todo'), ['todo_id'], [$id]);
    }

    /**
     * Function used to validate comments
     * @throws Exception
     */
    function validate_comment_functions($params)
    {
        $type = $params['type'];
        $obj_id = $params['obj_id'];

        if ($type == 'video' || $type == 'v') {
            if (!$this->video_exists($obj_id)) {
                e(lang('class_vdo_del_err'));
            }
        }

        $func_array = get_functions('validate_comment_functions');
        if (is_array($func_array)) {
            foreach ($func_array as $func) {
                if (function_exists($func)) {
                    return $func($params);
                }
            }
        }
    }

    /**
     * Function used to insert note in data base for admin referance
     * @throws Exception
     */
    function insert_note($note)
    {
        global $db;
        $db->insert(tbl('admin_notes'), ['note,date_added,userid'], [$note, now(), user_id()]);
    }

    /**
     * Function used to get notes
     * @throws Exception
     */
    function get_notes(): array
    {
        global $db;
        return $db->select(tbl('admin_notes'), '*', ' userid=\'' . user_id() . '\'', null, ' date_added DESC ');
    }

    /**
     * Function usde to delete note
     * @throws Exception
     */
    function delete_note($id)
    {
        global $db;
        $db->delete(tbl('admin_notes'), ['note_id'], [$id]);
    }

    /**
     * Function used to check weather object is commentable or not
     */
    function is_commentable($obj, $type)
    {
        switch ($type) {
            case 'video':
            case 'v':
            case 'vdo':
            case 'videos':
            case 'vid':
                if ($obj['allow_comments'] == 'yes' && config('video_comments') == 1) {
                    return true;
                }
                break;

            case 'channel':
            case 'user':
            case 'users':
            case 'u':
            case 'c':
                if ($obj['allow_comments'] == 'Yes' && config('channel_comments') == 1) {
                    return true;
                }
                break;

            case 'collection':
            case 'collect':
            case 'cl':
                if ($obj['allow_comments'] == 'yes') {
                    return true;
                }
                break;

            case 'photo':
            case 'p':
            case 'photos':
                if ($obj['allow_comments'] == 'yes' && config('photo_comments') == 1) {
                    return true;
                }
        }
        return false;
    }

    /**
     * Function used to get list of items in conversion queue
     * @params $Cond, $limit,$order
     *
     * @param null $cond
     * @param null $limit
     * @param string $order
     *
     * @return array|bool
     * @throws Exception
     */
    function get_conversion_queue($cond = null, $limit = null, $order = 'date_added DESC')
    {
        global $db;
        $result = $db->select(tbl('conversion_queue'), '*', $cond, $limit, $order);
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * function used to remove queue
     *
     * @param $action
     * @param $id
     * @throws Exception
     */
    function queue_action($action, $id)
    {
        global $db;

        $id = mysql_clean($id);
        switch ($action) {
            case 'delete':
                $db->execute('DELETE FROM ' . tbl('conversion_queue') . 'WHERE cqueue_id =\''.mysql_clean($id).'\'');
                break;
            case 'processed':
                $db->update(tbl('conversion_queue'), ['cqueue_conversion'], ['yes'], 'cqueue_id =\''.mysql_clean($id).'\'');
                break;
            case 'pending':
                $db->update(tbl('conversion_queue'), ['cqueue_conversion'], ['no'], 'cqueue_id =\''.mysql_clean($id).'\'');
                break;
        }
    }
}
