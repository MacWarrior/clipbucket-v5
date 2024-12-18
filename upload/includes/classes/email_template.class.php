<?php

use PHPMailer\PHPMailer\PHPMailer;

class EmailTemplate
{
    private static $user_permissions = [];

    private static $tableName = 'email_template';
    private static $tableNameEmail = 'email';
    private static $tableNameEmailHisto = 'email_histo';
    private static $tableNameEmailVariable = 'email_variable';

    private static $fields = [
        'id_email_template',
        'code',
        'is_default',
        'is_deletable',
        'content',
        'disabled'
    ];
    private static $fieldsEmail = [
        'id_email',
        'code',
        'id_email_template',
        'is_deletable',
        'title',
        'content',
        'disabled'
    ];
    private static $fieldsEmailHisto = [
        'id_email_histo',
        'send_date',
        'id_email',
        'userid',
        'email',
        'title',
        'content'
    ];
    private static $fieldsEmailVariable = [
        'id_email_variable',
        'code',
        'type',
        'language_key'
    ];


    public static function formatAndValidateTemplateFields(array $fields)
    {
        //check code unique
        $existing_code = self::getOneTemplate([
            'code'                  => $fields['code'] ?: false,
            'not_id_email_template' => ($fields['id_email_template'] ?: 0),
            'disabled'              => false
        ]);
        if (!empty($existing_code)) {
            e(lang('code_already_exist', [
                $fields['code']
            ]));
            return false;
        }
        foreach ($fields as $field => &$value) {
            $value = mysql_clean($value);
            switch ($field) {
                case 'is_default':
                case 'is_deletable':
                case 'disabled':
                    $value = (bool)$value;
                    break;
                case 'content':
                    if (stripos($value, '{{email_content}}') === false) {
                        e(lang('empty_email_content'));
                        return false;
                    }
//                    $value = '\'' . mysql_clean(preg_replace('(\\\n|\\\r)', '', $value)) . '\'';
                    $value = '\'' . mysql_clean($value) . '\'';
                    break;
                case 'code':
                    if (empty($value)) {
                        e(lang('code_cannot_be_empty'));
                        return false;
                    }
                    $value = '\'' . mysql_clean($value) . '\'';
                    break;
                default:
                    break;

            }
        }
        return $fields;
    }

    public static function formatAndValidateEmailFields(array $fields)
    {
        //check code unique
        $existing_code = self::getOneEmail([
            'code'         => $fields['code'] ?: '',
            'not_id_email' => ($fields['id_email'] ?: 0),
            'disabled'     => false
        ]);
        if (!empty($existing_code)) {
            e(lang('code_already_exist', [
                $fields['code']
            ]));
            return false;
        }
        $existing_template = self::getOneTemplate([
            'id_email_template' => $fields['id_email_template'],
        ]);
        if (empty($existing_template)) {
            e(lang('template_dont_exist'));
            return false;
        }
//        $extracted_titles_variables = self::getVariablesFromEmail($fields, 'title');
//        $extracted_content_variables = self::getVariablesFromEmail($fields, 'email');
        foreach ($fields as $field => &$value) {
            $value = mysql_clean($value);
            switch ($field) {
                case 'is_deletable':
                case 'disabled':
                    $value = (bool)$value;
                    break;
                case 'content':
//                    $value = '\'' . mysql_clean(preg_replace('(\\\n|\\\r)', '', $value)) . '\'';
                    $value = '\'' . mysql_clean($value) . '\'';
                    break;
                case 'code':
                    if (empty($value)) {
                        e(lang($field . '_cannot_be_empty'));
                        return false;
                    }
                    $value = '\'' . mysql_clean($value) . '\'';
                    break;
                case 'title':
                    if (empty($value)) {
                        e(lang($field . '_cannot_be_empty'));
                        return false;
                    }
                    /*if (count) {

                    }*/
                    $value = '\'' . mysql_clean($value) . '\'';
                    break;
                default:
                    break;

            }
        }
        return $fields;
    }

    /**
     * @param array $email_template
     * @return bool|mysqli_result
     * @throws Exception
     */
    public static function insertEmailTemplate(array $email_template)
    {
        $sql = 'INSERT INTO ' . tbl(self::$tableName) . ' ';
        $fields = [];
        $values = [];
        $email_template = self::formatAndValidateTemplateFields($email_template);
        if ($email_template === false) {
            return false;
        }
        foreach (self::$fields as $field) {
            if ($field == 'id_email_template') {
                continue;
            }
            if (isset($email_template[$field])) {
                $fields[] = $field;
                $values[] = $email_template[$field];
            }
        }
        $sql .= ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ') ';
        Clipbucket_db::getInstance()->execute($sql);
        return Clipbucket_db::getInstance()->insert_id();
    }

    /**
     * @param array $email
     * @return bool|mysqli_result
     * @throws Exception
     */
    public static function insertEmail(array $email)
    {
        $sql = 'INSERT INTO ' . tbl(self::$tableNameEmail) . ' ';
        $fields = [];
        $values = [];
        $email = self::formatAndValidateEmailFields($email);
        if ($email === false) {
            return false;
        }
        foreach (self::$fieldsEmail as $field) {
            if ($field == 'id_email') {
                continue;
            }
            if (isset($email[$field])) {
                $fields[] = $field;
                $values[] = $email[$field];
            }
        }
        $sql .= ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ') ';
        Clipbucket_db::getInstance()->execute($sql);
        return Clipbucket_db::getInstance()->insert_id();
    }

    public static function updateEmailTemplate(array $email_template)
    {
        $sql = 'UPDATE  ' . tbl(self::$tableName) . ' SET ';
        $fields = [];
        $email_template = self::formatAndValidateTemplateFields($email_template);
        if ($email_template === false) {
            return false;
        }
        foreach (self::$fields as $field) {
            if ($field == 'id_email_template') {
                continue;
            }
            if (isset($email_template[$field])) {
                $fields[] = $field . ' = ' . $email_template[$field];
            }
        }
        $sql .= implode(', ', $fields) . ' WHERE id_email_template = ' . mysql_clean($email_template['id_email_template']);
        return Clipbucket_db::getInstance()->execute($sql);
    }

    public static function updateEmail(array $email)
    {
        $sql = 'UPDATE  ' . tbl(self::$tableNameEmail) . ' SET ';
        $fields = [];
        $email = self::formatAndValidateEmailFields($email);
        if ($email === false) {
            return false;
        }
        foreach (self::$fieldsEmail as $field) {
            if ($field == 'id_email') {
                continue;
            }
            if (isset($email[$field])) {
                $fields[] = $field . ' = ' . $email[$field];
            }
        }
        $sql .= implode(', ', $fields) . ' WHERE id_email = ' . mysql_clean($email['id_email']);
        return Clipbucket_db::getInstance()->execute($sql);
    }


    /**
     * @return array
     */
    private static function getAllTemplateFields(): array
    {
        return array_map(function ($field) {
            return self::$tableName . '.' . $field;
        }, self::$fields);

    }

    /**
     * @return array
     */
    private static function getAllEmailFields(): array
    {
        return array_map(function ($field) {
            return self::$tableNameEmail . '.' . $field;
        }, self::$fieldsEmail);

    }

    /**
     * @param array $params
     * @throws Exception
     */
    public static function getAllTemplate(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_id_email_template = $params['id_email_template'] ?? false;
        $param_not_id_email_template = $params['not_id_email_template'] ?? false;
        $param_code = $params['code'] ?? false;
        $param_disabled = $params['disabled'];
        $param_has_histo = $params['has_histo'] ?? false;
        $param_show_disabled = $params['show_disabled'] ?? false;

        $conditions = [];
        $join = [];

        if (!$param_show_disabled) {
            $conditions[] = self::$tableName . '.disabled = FALSE';
        }

        if ($param_id_email_template !== false) {
            $conditions[] = ' ' . self::$tableName . '.id_email_template = ' . mysql_clean($param_id_email_template);
        }
        if ($param_not_id_email_template !== false) {
            $conditions[] = ' ' . self::$tableName . '.id_email_template != ' . mysql_clean($param_not_id_email_template);
        }

        if ($param_code !== false) {
            $conditions[] = ' ' . self::$tableName . '.code LIKE \'' . mysql_clean($param_code) . '\'';
        }
        if ($param_disabled !== null) {
            $conditions[] = ' ' . self::$tableName . '.disabled = ' . ($param_disabled ? 'true' : 'false');
        }

        if (!$param_count) {
            $select = self::getAllTemplateFields();
        } else {
            $select[] = 'COUNT(DISTINCT id_email_template) AS count';
        }

        if ($param_has_histo) {
            $join[] = ' LEFT JOIN ' . cb_sql_table(self::$tableNameEmail) . ' ON ' . self::$tableNameEmail . '.id_email_template = ' . self::$tableName . '.id_email_template ';
            $join[] = ' LEFT JOIN ' . cb_sql_table(self::$tableNameEmailHisto) . ' ON ' . self::$tableNameEmailHisto . '.id_email = ' . self::$tableNameEmail . '.id_email ';
            $select[] = 'CASE WHEN COUNT(DISTINCT ' . self::$tableNameEmailHisto . '.id_email_histo ) > 0 THEN TRUE ELSE FALSE END as has_histo ';
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }
        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table(self::$tableName)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($param_first_only) {
            return $result[0];
        }
        if ($param_count) {
            return $result[0]['count'];
        }
        return empty($result) ? [] : $result;
    }

    /**
     * @param array $params
     * @return array|int|mixed
     * @throws Exception
     */
    public static function getOneTemplate(array $params)
    {
        $params['first_only'] = true;
        return self::getAllTemplate($params);
    }

    /**
     * @param array $params
     * @return array|int|mixed
     * @throws Exception
     */
    public static function getOneEmail(array $params)
    {
        $params['first_only'] = true;
        return self::getAllEmail($params);
    }


    public static function getAllEmail(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_id_email = $params['id_email'] ?? false;
        $param_not_id_email = $params['not_id_email'] ?? false;
        $param_code = $params['code'] ?? false;
        $param_disabled = $params['disabled'];
        $param_has_histo = $params['has_histo'] ?? false;
        $param_get_template_content = $params['get_template_content'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        $join[] = ' LEFT JOIN ' . cb_sql_table(self::$tableName) . ' ON ' . self::$tableName . '.id_email_template = ' . self::$tableNameEmail . '.id_email_template ';

        if ($param_id_email !== false) {
            $conditions[] = ' ' . self::$tableNameEmail . '.id_email = ' . mysql_clean($param_id_email);
        }
        if ($param_not_id_email !== false) {
            $conditions[] = ' ' . self::$tableNameEmail . '.id_email != ' . mysql_clean($param_not_id_email);
        }

        if ($param_code !== false) {
            $conditions[] = ' ' . self::$tableNameEmail . '.code LIKE \'' . mysql_clean($param_code) . '\'';
        }
        if ($param_disabled !== null) {
            $conditions[] = ' ' . self::$tableNameEmail . '.disabled = ' . ($param_disabled ? 'true' : 'false');
        }
        if (!$param_count) {
            $select = self::getAllEmailFields();
            $select[] = self::$tableName . '.code as template_code';
            $group[] = self::$tableNameEmail . '.id_email';
            if ($param_get_template_content) {
                $select[] = self::$tableName . '.content as template_content';
            }
        } else {
            $select[] = 'COUNT(DISTINCT ' . self::$tableNameEmail . '.id_email) AS count';
        }

        if ($param_has_histo) {
            $join[] = ' LEFT JOIN ' . cb_sql_table(self::$tableNameEmailHisto) . ' ON ' . self::$tableNameEmailHisto . '.id_email = ' . self::$tableNameEmail . '.id_email ';
            $select[] = 'CASE WHEN COUNT(DISTINCT ' . self::$tableNameEmailHisto . '.id_email_histo ) > 0 THEN TRUE ELSE FALSE END as has_histo ';
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }
        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table(self::$tableNameEmail)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(', ', $group))
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($param_first_only) {
            return $result[0];
        }
        if ($param_count) {
            return $result[0]['count'];
        }
        return empty($result) ? [] : $result;
    }


    /**
     * @param $params
     * @throws Exception
     */
    public static function assignListEmailTemplate($type, $params = [])
    {
        switch ($type) {
            case 'email_template':
                $function = 'getAllTemplate';
                $variable = 'email_templates';
                break;
            case 'email':
                $function = 'getAllEmail';
                $variable = 'emails';
                break;
            default:
                e(lang('error'));
                return false;
        }
        // Creating Limit
        $page = mysql_clean($_GET['page']);
        $get_limit = create_query_limit($page, config('admin_pages'));

        $params['limit'] = $get_limit;

        $list = EmailTemplate::$function($params);
        $params['count'] = true;
        unset($params['limit']);
        unset($params['order']);
        $total_rows = EmailTemplate::$function($params);

        $total_pages = count_pages($total_rows, config('admin_pages'));
        pages::getInstance()->paginate($total_pages, $page);
        assign($variable, $list);
    }

    /**
     * Make Language Default
     *
     * @param $lid
     * @throws Exception
     */
    public static function makeDefault($id_email_template)
    {
        $template = self::getOneTemplate(['id_email_template' => $id_email_template ?: 0]);
        if ($template) {
            Clipbucket_db::getInstance()->update(tbl(self::$tableName), ['is_default'], [0], ' is_default = 1 ');
            Clipbucket_db::getInstance()->update(tbl(self::$tableName), ['is_default'], [1], ' id_email_template = ' . mysql_clean($id_email_template));
            e(lang('template_set_default', [$template['code']]), 'm');

            Clipbucket_db::getInstance()->update(tbl(self::$tableNameEmail), ['id_email_template'], [mysql_clean($id_email_template)], ' 1 ');
        }
    }

    /**
     * @param $id_email_template
     * @return bool
     * @throws Exception
     */
    public static function deleteTemplate(int $id_email_template): bool
    {
        $template = self::getOneTemplate([
            'id_email_template' => $id_email_template,
            'has_histo'         => true
        ]);
        if (empty($template)) {
            e(lang('template_dont_exist'));
            return false;
        }
        if ($template['has_histo']) {
            self::updateEmailTemplate([
                'id_email_template' => $id_email_template,
                'disabled'          => true
            ]);
        } else {
            Clipbucket_db::getInstance()->delete(tbl(self::$tableName), ['id_email_template'], [$id_email_template]);
        }
        return true;
    }

    /**
     * @param $id_email
     * @return bool
     * @throws Exception
     */
    public static function deleteEmail(int $id_email): bool
    {
        $template = self::getOneEmail([
            'id_email_template' => $id_email,
            'has_histo'         => true
        ]);
        if (empty($template)) {
            e(lang('template_dont_exist'));
            return false;
        }
        if ($template['has_histo']) {
            self::updateEmail([
                'id_email' => $id_email,
                'disabled' => true
            ]);
        } else {
            Clipbucket_db::getInstance()->delete(tbl(self::$tableNameEmail), ['id_email'], [$id_email]);
        }
        return true;
    }

    public static function getVariablesFromEmail($email, string $type)
    {
        if (empty($email)) {
            return false;
        }
        $conditions = [];
        $conditions[] = ' type = \'' . $type . '\'';
        switch ($type) {
            case 'email':
                $matches_content = self::extractVariable($email['content']);
                $conditions[] = ' code IN (\'' . implode('\', \'', $matches_content) . '\')';
                break;
            case 'title':
                $matches_title = self::extractVariable($email['title']);
                $conditions[] = ' code IN (\'' . implode('\', \'', $matches_title) . '\')';
                break;
        }
        $sql = 'SELECT * FROM ' . cb_sql_table(self::$tableNameEmailVariable) . ' WHERE ' . implode(' AND ', $conditions);
        $result = Clipbucket_db::getInstance()->_select($sql);
        return empty($result) ? [] : $result;
    }

    /**
     * @param string $content
     * @return array
     */
    public static function extractVariable(string $content): array
    {
        $results = [];
        preg_match_all('/\{\{(\w+)}}/', $content, $results);
        return $results[1] ?? [];
    }

    /**
     * @param string $string
     * @param array $variables
     * @return string
     */
    public static function fillVariable(string $string, array $variables): string
    {
        foreach ($variables as $name => $value) {
            $string = str_replace('{{' . $name . '}}', $value, $string);
        }
        return $string;
    }

    /**
     * @param string $subject
     * @param string $content
     * @param array|string $to
     * @param $sender_email
     * @param $sender_name
     * @param $par_destinataire
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function send(string $subject, string $content, $to, $sender_email = '', $sender_name = '')
    {
        if (empty($sender_email)) {
            $sender_email = config('email_sender_address');
        }
        if (empty($sender_name)) {
            $sender_name = config('email_sender_name');
        }
        $mail = new PHPMailer();
//        two lines should be equal to $mail->addCustomHeader('Content-Type', 'text/html; charset="UTF-8"')
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->isHTML();
        $mail->setFrom($sender_email, $sender_name, false);
        $mail->addReplyTo($sender_email, $sender_name);

//        $mail->addCustomHeader('Content-Type', 'text/html; charset="UTF-8"');
//        $headers  = 'From: "'.$sender_name.'"<'.$sender_email.'>'."\n";
//        $headers .= 'Reply-To: '.$sender_email."\n";
//        $headers .= 'Content-Type: text/html; charset="UTF-8"';

        $mail->Subject = $subject;
        $mail->MsgHTML($content);
        if (config('mail_type') == 'smtp') {
            $mail->Host = config('smtp_host');
            if (config('smtp_auth') == 'yes') {
                $mail->SMTPAuth = true;
            }
            $mail->Port = config('smtp_port');
            $mail->Username = config('smtp_user');
            $mail->Password = config('smtp_pass');
        }

        if (is_array($to) && empty($to['name'])) {
            foreach ($to as $email) {
                self::addAddressAndNameIfExist($mail, $email);
            }
        } else {
            self::addAddressAndNameIfExist($mail, $to);
        }
        if ($mail->send()) {
            return true;
        } else {
            //send error
            return $mail->ErrorInfo;
        }
    }

    /**
     * @param PHPMailer $mail
     * @param array|string $to
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    private static function addAddressAndNameIfExist(PHPMailer &$mail, $to)
    {
        if (is_array($to)) {
            $mail->addAddress($to['mail'], $to['name']);
        } else {
            $mail->addAddress($to);
        }
    }

    /**
     * @param $id_email
     * @param $id_user
     * @param $to
     * @param $title
     * @param $content
     * @return bool
     * @throws Exception
     */
    public static function saveEmailHisto($id_email, $id_user, $to, $title, $content)
    {
        $sql = 'INSERT INTO ' . tbl(self::$tableNameEmailHisto) . ' ';
        $fields = [
            'id_email',
            'send_date',
            'title',
            'content'
        ];
        $values = [
            mysql_clean($id_email),
            'NOW()',
            mysql_clean($title),
            mysql_clean($content)
        ];

        if (!empty($id_user)) {
            $fields[] = 'userid';
            $values[] = $id_user;
        } elseif (!empty($to)) {
            $fields[] = 'email';
            $values[] = $to;
        } else {
            e(lang('missing_recipient'));
            return false;
        }

        $sql .= ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ') ';
        return (bool)Clipbucket_db::getInstance()->execute($sql);
    }

    /**
     * @param $code_email
     * @param $to
     * @param $variables
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function sendMail($code_email, $to, $variables, $from = '', $from_name = '', $display_error = false)
    {
        if (empty($to)) {
            e(lang('missing_recipient'));
            return false;
        }
        $email = self::getOneEmail([
            'code'                 => $code_email,
            'get_template_content' => true
        ]);
        if (empty($email)) {
            e(lang('unknown_email'));
        }
        if (is_numeric($to)) {
            //if $to = userid => get email + username
            //add in $variables if user_username is empty
            $user = User::getInstance()->getOne(['userid' => $to]);
            $to = [
                'mail' => $user['email'],
                'name' => $user['username']
            ];
            if (empty($variables['user_username'])) {
                $variables['user_username'] = $user['username'];
            }
            if (empty($variables['user_email'])) {
                $variables['user_email'] = $user['email'];
            }
        }
        //put variable on email
        $title = self::fillVariable($email['title'], $variables);
        $email_content = self::fillVariable($email['content'], $variables);
        //put email on template
        $content = self::fillVariable($email['template_content'], ['email_content' => $email_content]);
        //send emails
        if (is_array($to) && !isset($to['mail'])) {
            $result = self::send($title, $content, $to, $from, $from_name);
            if ($result === true) {
                foreach ($to as $email_address) {
                    self::saveEmailHisto($email['id_email'], null, $email_address, $title, $content);
                }
            }
        } else {
            $result = self::send($title, $content, $to, $from, $from_name);
            if ($result === true) {
                self::saveEmailHisto($email['id_email'], $user['userid'] ?? null, $to['mail'] ?? $to, $title, $content);
            }
        }
        if ($result !== true) {
            if ($display_error) {
                e(lang('error_mail', [$result]));
            } else {
                DiscordLog::getInstance()->error(lang('error_mail', [$result]));
            }
            return false;
        }
        return true;
    }

}
