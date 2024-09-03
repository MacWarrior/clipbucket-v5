<?php

class Comments
{
    public static $libelle_type_channel = 'channel';
    /**
     * @throws Exception
     */
    public static function getAll(array $params = [])
    {
        $param_type = $params['type'] ?? false;
        $param_type_id = $params['type_id'] ?? false;
        $param_comment_id = $params['comment_id'] ?? false;
        $param_parent_id = $params['parent_id'] ?? false;
        $param_userid = $params['userid'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_first_only = $params['first_only'] ?? false;
        $param_hierarchy = $params['hierarchy'] ?? false;

        $left_join = '';
        $case_when = '';
        if( !$param_type || $param_type == 'v'){
            $left_join .= ' LEFT JOIN '.cb_sql_table('video').' ON comments.type = \'v\' AND comments.type_id = video.videoid';
            $case_when .= ' WHEN comments.type = \'v\' THEN video.title';
        }
        if( !$param_type || $param_type == 'p'){
            $left_join .= ' LEFT JOIN '.cb_sql_table('photos').' ON comments.type = \'p\' AND comments.type_id = photos.photo_id';
            $case_when .= ' WHEN comments.type = \'p\' THEN photos.photo_title';
        }
        if( !$param_type || $param_type == 'cl'){
            $left_join .= ' LEFT JOIN '.cb_sql_table('collections').' ON comments.type = \'cl\' AND comments.type_id = collections.collection_id';
            $case_when .= ' WHEN comments.type = \'cl\' THEN collections.collection_name';
        }
        if( !$param_type || $param_type == Comments::$libelle_type_channel){
            $left_join .= ' LEFT JOIN '.tbl('users').' channels ON comments.type = \''.Comments::$libelle_type_channel.'\' AND comments.type_id = channels.userid';
            $case_when .= ' WHEN comments.type = \''.Comments::$libelle_type_channel.'\' THEN channels.username';
        }

        $conditions = [];
        if( $param_type ){
            $conditions[] = 'comments.type = \''.mysql_clean($param_type).'\'';
        }
        if( $param_type_id ){
            $conditions[] = 'comments.type_id = '.mysql_clean($param_type_id);
        }
        if( $param_comment_id ){
            $conditions[] = 'comments.comment_id = '.mysql_clean($param_comment_id);
        }
        if( $param_userid ){
            $conditions[] = 'comments.userid = '.mysql_clean($param_userid);
        }
        if( $param_parent_id ){
            $conditions[] = 'comments.parent_id = '.mysql_clean($param_parent_id);
        }
        if( $param_hierarchy ){
            $conditions[] = 'comments.parent_id = 0';
        }

        $where = '';
        if( !empty($conditions) ){
            $where = ' WHERE '.implode(' AND ', $conditions);
        }

        $group = '';
        if( $param_group ){
            $group = ' GROUP BY '.$param_group;
        }

        $having = '';
        if( $param_having ){
            $having = ' HAVING '.$param_having;
        }

        $order = '';
        if( $param_order ){
            $order = ' ORDER BY '.$param_order;
        }

        $limit = '';
        if( $param_limit ){
            $limit = ' LIMIT '.$param_limit;
        }

        if( $param_count ){
            $select = ['COUNT(DISTINCT comments.comment_id) AS count'];
        } else {
            $select = [
                'comments.comment_id'
                ,'comments.type'
                ,'comments.comment'
                ,'comments.userid'
                ,'comments.anonym_name'
                ,'comments.anonym_email'
                ,'comments.parent_id'
                ,'comments.type_id'
                ,'comments.type_owner_id'
                ,'comments.spam_votes'
                ,'comments.spam_voters'
                ,'comments.date_added'
                ,'comments.comment_ip'
                ,'users.username'
                ,'users.email'
                ,'CASE ' . $case_when . ' END AS title'
            ];
        }

        $sql ='SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table('comments') . '
                LEFT JOIN ' . cb_sql_table('users') . ' ON comments.userid = users.userid'
            . $left_join
            . $where
            . $group
            . $having
            . $order
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);

        if( $param_count ){
            if( empty($result) ){
                return 0;
            }
            return $result[0]['count'];
        }

        if( !$result ){
            return false;
        }

        if( $param_first_only ){
            return $result[0];
        }

        if( $param_hierarchy ){
            foreach($result AS &$line){
                $params = [];
                $params['parent_id'] = $line['comment_id'];
                $children = self::getAll($params);
                if( $children ){
                    $line['children'] = $children;
                }
            }
        }

        return $result;
    }

    /**
     * @param array $params
     * @param bool $display_message
     * @return int
     * @throws Exception
     */
    public static function delete(array $params, bool $display_message = true): int
    {
        $param_type = $params['type'] ?? false;
        $param_type_id = $params['type_id'] ?? false;
        $param_comment_id = $params['comment_id'] ?? false;

        if(!empty($param_type_id) && !is_numeric($param_type_id)){
            return false;
        }

        if(!empty($param_comment_id) && !is_numeric($param_comment_id)){
            return false;
        }

        if( empty($param_type) && empty($param_type_id) && empty($param_comment_id) ){
            return false;
        }

        $user_id = user_id();
        if( !$user_id ){
            return false;
        }

        $params['first_only'] = true;
        $comment = self::getAll($params);

        if( !has_access('admin_del_access', false)
            && $comment['userid'] != $user_id
            && $comment['type_owner_id'] != $user_id
        ){
            e(lang('no_comment_del_perm'));
            return false;
        }

        $conditions = [];
        if( $param_type ){
            $conditions[] = 'type = \'' . mysql_clean($param_type) . '\'';
        }
        if( $param_type_id ){
            $conditions[] = 'type_id = ' . mysql_clean($param_type_id);
        }
        if( $param_comment_id ){
            $conditions[] = '(comment_id = '.mysql_clean($param_comment_id) . ' OR ' . ' parent_id = ' . mysql_clean($param_comment_id) . ')';
        }

        $where = '';
        if( !empty($conditions) ){
            $where = ' WHERE '.implode(' AND ', $conditions);
        }

        $sql = 'DELETE FROM ' . tbl('comments') . $where;
        Clipbucket_db::getInstance()->execute($sql);
        $nb_delete = Clipbucket_db::getInstance()->Affected_Rows();
        if( !$param_type && !$param_type_id){
            self::updateCommentsCount($comment['type'], $comment['type_id']);
        }

        if ($display_message) {
            e(lang('usr_cmt_del_msg'), 'm');
        }
        return $nb_delete;
    }

    /**
     * @throws Exception
     */
    public static function updateCommentsCount($type, $type_id)
    {
        $params = [];
        $params['type'] = $type;
        $params['type_id'] = $type_id;
        $params['count'] = true;
        $count_comment = self::getAll($params);
        switch($type){
            default:
                error_log('type : '.$type);
            case 'v':
                $table = 'video';
                $field = 'comments_count';
                $cond = 'videoid';
                break;
            case 'p':
                $table = 'photos';
                $field = 'total_comments';
                $cond = 'photo_id';
                break;
            case 'cl':
                $table = 'collections';
                $field = 'total_comments';
                $cond = 'collection_id';
                break;
            case Comments::$libelle_type_channel:
                $table = 'users';
                $field = 'comments_count';
                $cond = 'userid';
        }

        Clipbucket_db::getInstance()->update(tbl($table), [$field], [$count_comment], $cond.' = '.mysql_clean($type_id));
    }

    /**
     * @throws Exception
     */
    public static function setSpam($comment_id)
    {
        $user_id = user_id();
        if (!$user_id) {
            e(lang('login_to_mark_as_spam'));
            return false;
        }

        $params = [];
        $params['comment_id'] = $comment_id;
        $params['first_only'] = true;
        $comment = self::getAll($params);

        if( !$comment ){
            e(lang('no_comment_exists'));
            return false;
        }

        if( $comment['userid'] == $user_id || (Network::get_remote_ip() == $comment['comment_ip']) ){
            e(lang('no_own_commen_spam'));
            return false;
        }

        $spam_voters = $comment['spam_voters'];
        $already_voted = strpos('|'.$user_id.'|', $spam_voters) !== false;
        if( $already_voted ){
            e(lang('already_spammed_comment'));
            return false;
        }

        if( empty($spam_voters) ){
            $spam_voters .= '|';
        }
        $spam_voters .= $user_id.'|';
        $spam_votes = $comment['spam_votes'] + 1;

        Clipbucket_db::getInstance()->update(tbl('comments'), ['spam_votes', 'spam_voters'], [$spam_votes, $spam_voters], 'comment_id = '.mysql_clean($comment_id));
        e(lang('spam_comment_ok'), 'm');
        return $spam_votes;
    }

    /**
     * @throws Exception
     */
    public static function unsetSpam($comment_id): bool
    {
        if (!user_id()) {
            e(lang('login_to_mark_as_spam'));
            return false;
        }

        $params = [];
        $params['comment_id'] = $comment_id;
        $params['first_only'] = true;
        $comment = self::getAll($params);

        if( !$comment ){
            e(lang('no_comment_exists'));
            return false;
        }

        $spam_votes = $comment['spam_votes'];
        if (!$spam_votes) {
            e(lang('Comment is not a spam'));
            return false;
        }

        Clipbucket_db::getInstance()->update(tbl('comments'), ['spam_votes', 'spam_voters'], [0, 'NULL'], 'comment_id = '.mysql_clean($comment_id));
        e(lang('Spam removed from comment.'), 'm');
        return true;
    }

    /**
     * @throws Exception
     */
    public static function add($comment, $type_id, $type = 'v', $reply_to = null)
    {
        $user_id = user_id();
        if( !$user_id && config('anonym_comments') != 'yes' ){
            e(lang('you_not_logged_in'));
            return false;
        }

        if (empty($comment)) {
            e(lang('pelase_enter_something_for_comment'));
            return false;
        }

        $anonym_name = '';
        $anonym_email = '';
        if( !$user_id && config('anonym_comments') == 'yes' ){
            $anonym_name = trim($_POST['name']);
            $anonym_email = trim($_POST['email']);

            if (empty(trim($anonym_name))) {
                e(lang('please_enter_your_name'));
                return false;
            }

            if (empty(trim($anonym_email))) {
                e(lang('please_enter_your_email'));
                return false;
            }

            if( !isValidEmail($anonym_email)){
                e(lang('invalid_email'));
                return false;
            }
        }

        // TODO
        if (!verify_captcha()) {
            e(lang('recap_verify_failed'));
            return false;
        }

        $params = ['comment' => $comment, 'type_id' => $type_id, 'reply_to' => $reply_to, 'type' => $type];
        if( !self::isValid($params) ){
            return false;
        }

        $userid = $user_id ? $user_id : 'NULL';

        switch($type){
            default:
            case 'v':
            case 'video':
                $obj = CBvideo::getInstance()->get_video($type_id);
                $link = video_link($obj);
                break;
            case 'p':
            case 'photo':
                $photo = CBPhotos::getInstance();
                $obj = $photo->get_photo($type_id);
                $link = $photo->photo_links($obj,'view_item');
                break;
            case 'cl':
            case 'collection':
                $collection = Collections::getInstance();
                $obj = $collection->get_collection($type_id);
                $link = $collection->collection_links($obj);
                break;
            case Comments::$libelle_type_channel:
                $user = userquery::getInstance();
                $obj = $user->get_user_profile($type_id);
                $link = $user->profile_link($obj);
                break;
        }
        $owner_id = $obj['userid'];

        $comment_id = Clipbucket_db::getInstance()->insert(
            tbl('comments')
            ,['type', 'comment', 'type_id', 'userid', 'date_added', 'parent_id', 'anonym_name', 'anonym_email', 'comment_ip', 'type_owner_id']
            ,[$type, $comment, $type_id, $userid, NOW(), $reply_to, $anonym_name, $anonym_email, Network::get_remote_ip(), $owner_id]
        );

        if( $user_id ){
            Clipbucket_db::getInstance()->update(tbl('users'), ['total_comments'], ['|f|total_comments+1'], 'userid=' . mysql_clean($user_id));
        }

        self::updateCommentsCount($type, $type_id);

        $user_name = user_name() ?? $anonym_name;
        $user_email = user_email() ?? $anonym_email;
        $type_label = self::getTypeLabel($type);

        $log_array = [
            'success'        => 'yes',
            'action_obj_id'  => $comment_id,
            'action_done_id' => $type_id,
            'details'        => 'commented a '.$type_label,
            'username'       => $user_name,
            'useremail'      => $user_email
        ];
        insert_log($type . '_comment', $log_array);

        addFeed(['action' => 'comment_video', 'comment_id' => $comment_id, 'object_id' => $type_id, 'object' => 'video']);

        e(lang('grp_comment_msg'), 'm');

        $owner_email = userquery::getInstance()->get_user_field($owner_id, 'email');
        if( config('send_comment_notification') == 'yes' && isValidEmail($owner_email) ){
            $email = CBEmail::getInstance();

            $email_template = $email->get_template('user_comment_email');

            $email_params = [
                '{username}'  => $user_name
                ,'{obj}'      => $type_label
                ,'{comment}'  => $comment
                ,'{obj_link}' => $link . '#comment_' . $comment_id
            ];

            $subject = $email->replace($email_template['email_template_subject'], $email_params);
            $content = nl2br($email->replace($email_template['email_template'], $email_params));

            cbmail(['to' => $owner_email, 'from' => config('website_email'), 'subject' => $subject, 'content' => $content]);

            if( !empty($reply_to) ) {
                $params = [];
                $params['comment_id'] = $reply_to;
                $params['first_only'] = true;
                $comment = self::getAll($params);
                if (!empty($comment['userid'])) {
                    $reply_to = $comment['email'];
                } else {
                    $reply_to = $comment['anonym_email'];
                }

                if (isValidEmail($reply_to)) {
                    $email_template = $email->get_template('user_reply_email');
                    $subject = $email->replace($email_template['email_template_subject'], $email_params);
                    $content = nl2br($email->replace($email_template['email_template'], $email_params));

                    cbmail(['to' => $reply_to, 'from' => config('website_email'), 'subject' => $subject, 'content' => $content]);
                }
            }
        }

        return $comment_id;
    }

    /**
     * @throws Exception
     */
    public static function isValid($params):bool
    {
        $comment = $params['comment'];
        $type = $params['type'];
        $type_id = $params['type_id'];

        $comment_len = strlen($comment);
        $max_comment_chr = config('max_comment_chr');
        if ($comment_len > $max_comment_chr) {
            e(sprintf("'%d' characters allowed for comment", $max_comment_chr));
            return false;
        }
        if ($comment_len < 5) {
            e('Comment is too short. It should be at least 5 characters');
            return false;
        }

        switch($type){
            case 'v':
                if( !CBvideo::getInstance()->video_exists($type_id) ){
                    e(lang('class_vdo_del_err'));
                    return false;
                }
                break;
            case 'p':
                if( !CBPhotos::getInstance()->photo_exists($type_id) ){
                    e(lang('photo_not_exist'));
                    return false;
                }
                break;
            case 'cl':
                if( !Collections::getInstance()->collection_exists($type_id) ){
                    e(lang('collection_not_exist'));
                    return false;
                }
                break;
            case Comments::$libelle_type_channel:
                if ( !userquery::getInstance()->user_exists($type_id)) {
                    e(lang('channel_not_exist'));
                    return false;
                }
                break;
            default:
                e(lang('unknow_type'));
                return false;
        }

        $func_array = get_functions('validate_comment_functions');
        if (is_array($func_array)) {
            foreach ($func_array as $func) {
                if (function_exists($func)) {
                    return $func($params);
                }
            }
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public static function update($comment_id, $comment)
    {
        Clipbucket_db::getInstance()->update(tbl('comments'), ['comment'], [mysql_clean($comment)], ['comment_id = '.mysql_clean($comment_id)]);
    }

    /**
     * @throws Exception
     */
    private static function getTypeLabel($type)
    {
        switch($type){
            default:
            case 'v':
            case 'video':
                return lang('video');
            case 'p':
            case 'photo':
                return lang('photo');
            case 'cl':
            case 'collection':
                return lang('collection');
        }
    }

    public static function getClean(string $comment): string
    {
        $params = [
            'censor' => (config('enable_comments_censor') == 'yes'),
            'functionList' => 'comment'
        ];

        return CMS::getInstance($comment, $params)->getClean();
    }

}