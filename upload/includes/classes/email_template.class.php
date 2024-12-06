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
            'code' => $fields['code'] ?: false
        ]);
        if (!empty($existing_code)) {
            e(lang('code_already_taken', [
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
                    if (stripos($value, '{{email_content}}')=== false) {
                        e(lang('empty_email_content'));
                        return false;
                    }
                    $value = '\''.mysql_clean($value).'\'';
                    break;
                case 'code':
                    if (empty($value)) {
                        e(lang('code_cannot_be_empty'));
                        return false;
                    }
                    $value = '\''.mysql_clean($value).'\'';
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

        $conditions = [];
        $join = [];

        if (!$param_count) {
            $select = self::getAllTemplateFields();
        } else {
            $select[] = 'COUNT(DISTINCT id_email_template) AS count';
        }

        $limit = '';
        if( $param_limit ){
            $limit = ' LIMIT '.$param_limit;
        }
        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table(self::$tableName)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . $limit ;

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
    public static function assignListEmailTemplate($params =[])
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
        assign('templates', $templates);
    }
}