<?php

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
        'disabled',
        'permission_description'
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
            'code'              => $fields['code'] ?: false,
            'id_email_template' => ($fields['id_email_template'] ?: 0)
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
                    $value = '\'' . mysql_clean(preg_replace('(\\\n|\\\r)', '', $value)) . '\'';
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
        }, self::$fields);

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

        $conditions = [];
        $join = [];

        if ($param_id_email_template !== false) {
            $conditions[] = ' id_email_template = ' . mysql_clean($param_id_email_template);
        }
        if ($param_not_id_email_template !== false) {
            $conditions[] = ' id_email_template != ' . mysql_clean($param_not_id_email_template);
        }

        if ($param_code !== false) {
            $conditions[] = ' code LIKE \'' . mysql_clean($param_code) . '\'';
        }

        if (!$param_count) {
            $select = self::getAllTemplateFields();
        } else {
            $select[] = 'COUNT(DISTINCT id_email_template) AS count';
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


    public static function getAllEmail(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;

        $conditions = [];
        $join = [];

        $select = self::getAllEmailFields();

        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table(self::$tableName)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions));

        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($param_first_only) {
            return $result[0];
        }
        return empty($result) ? [] : $result;
    }


    /**
     * @param $params
     * @return void
     * @throws Exception
     */
    public static function assignListEmailTemplate($params = [])
    {
        // Creating Limit
        $page = mysql_clean($_GET['page']);
        $get_limit = create_query_limit($page, config('admin_pages'));

        $params['limit'] = $get_limit;

        $templates = EmailTemplate::getAllTemplate($params);
        $params['count'] = true;
        unset($params['limit']);
        unset($params['order']);
        $total_rows = EmailTemplate::getAllTemplate($params);

        $total_pages = count_pages($total_rows, config('admin_pages'));
        pages::getInstance()->paginate($total_pages, $page);
        assign('email_templates', $templates);
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
}