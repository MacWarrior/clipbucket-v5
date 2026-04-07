<?php

class Membership
{
    static $membership;
    private $tablename = '';

    private $tablename_user_membership = '';
    private $fields = [];
    private $fields_user_membership = [];

    private $frequencies = [];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->tablename = 'memberships';
        $this->tablename_user_membership = 'user_memberships';

        $this->fields = [
            'id_membership',
            'user_level_id',
            'frequency',
            'base_price',
            'description',
            'storage_quota_included',
            'storage_price_per_go',
            'disabled',
            'id_currency',
            'allowed_emails',
            'only_visible_eligible',
        ];

        $this->fields_user_membership = [
            'id_user_membership',
            'userid',
            'id_membership',
            'id_user_memberships_status',
            'date_start',
            'date_end',
            'id_user_billing_address',
            'is_card_saved',
            'is_auto_renew'
        ];

        $this->frequencies = [
            'daily',
            'weekly',
            'monthly',
            'yearly',
        ];
    }

    /**
     * @return string[]
     */
    public function getFrequencies(): array
    {
        return $this->frequencies;
    }

    public function getTablename(): string
    {
        return $this->tablename;
    }

    public function getTablenameUserMembership(): string
    {
        return $this->tablename_user_membership;
    }

    /**
     * @param array $params
     * @return array|int|mixed
     * @throws Exception
     */
    public function getOne(array $params)
    {
        $params['first_only'] = true;
        return $this->getAll($params);
    }

    /**
     * @throws Exception
     */
    public function getAll(array $params)
    {
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_user_level_id = $params['user_level_id'] ?? false;
        $param_not_user_level_id = $params['not_user_level_id'] ?? false;
        $param_id_membership = $params['id_membership'] ?? false;
        $param_ids_membership = $params['ids_membership'] ?? false;
        $param_not_id_membership = $params['not_id_membership'] ?? false;
        $param_userid = $params['userid'] ?? false;
        $param_username = $params['username'] ?? false;
        $param_frequency = $params['frequency'] ?? false;
        $param_first_only = $params['first_only'] ?? false;
        $param_join_users = $params['join_users'] ?? false;
        $param_type_join_user_membership = $params['type_join_user_membership'] ?? false;
        $param_get_user_membership = $params['get_user_membership'] ?? false;
        $param_date_between = $params['date_between'] ?? false;
        $param_is_disabled = $params['is_disabled'] ?? null;
        $param_get_nb_users = $params['get_nb_users'] ?? false;
        $param_language_key_title = $params['language_key_title'] ?? null;
        $param_id_user_membership = $params['id_user_membership'] ?? null;

        //CONDITIONS
        $conditions = [];
        if ($param_is_disabled !== null) {
            $conditions[] = $this->tablename . '.disabled = ' . mysql_clean($param_is_disabled);
        }
        if ($param_id_membership !== false) {
            $conditions[] = $this->tablename . '.id_membership = ' . mysql_clean($param_id_membership);
        }
        if ($param_ids_membership !== false) {
            $conditions[] = $this->tablename . '.id_membership IN (' . mysql_clean($param_ids_membership) . ')';
        }
        if ($param_not_id_membership !== false) {
            $conditions[] = $this->tablename . '.id_membership != ' . mysql_clean($param_not_id_membership);
        }
        if ($param_user_level_id !== false) {
            $conditions[] = $this->tablename . '.user_level_id = \'' . mysql_clean($param_user_level_id) . '\'';
        }
        if ($param_not_user_level_id !== false) {
            $conditions[] = $this->tablename . '.user_level_id != \'' . mysql_clean($param_not_user_level_id) . '\'';
        }
        if ($param_frequency !== false) {
            $conditions[] = $this->tablename . '.frequency = \'' . mysql_clean($param_frequency) . '\'';
        }
        if ($param_userid !== false) {
            $conditions[] = $this->tablename_user_membership . '.userid = \'' . mysql_clean($param_userid) . '\'';
        }
        if ($param_username !== false && $param_join_users) {
            $conditions[] = ' users.username like \'%' . mysql_clean($param_username) . '%\'';
        }
        if ($param_date_between !== false ) {
            $conditions[] = ' \''.mysql_clean($param_date_between) . '\'  BETWEEN ' . $this->tablename_user_membership . '.date_start AND (CASE WHEN ' . $this->tablename_user_membership . '.date_end IS NULL THEN \'2999-12-12\' ELSE ' . $this->tablename_user_membership . '.date_end END)';
        }
        if ($param_language_key_title !== null ) {

            if(!is_array($param_language_key_title)) {
                $param_language_key_title = [$param_language_key_title];
            }
            $constrain = [];
            foreach ($param_language_key_title as $value){
                $constrain[] = ' \''.mysql_clean($value).'\' ';
            }
            $conditions[] = ' language_key_title IN ('.implode(',', $constrain).') ';
        }
        if ($param_id_user_membership !== null ) {
            $conditions[] = ' user_memberships.id_user_membership = \''.mysql_clean($param_id_user_membership).'\'';
        }

        if ($param_group) {
            $group[] = $param_group;
        }

        $having = '';
        if ($param_having) {
            $having = ' HAVING ' . $param_having;
        }

        $order = '';
        if ($param_order && !$param_count) {
            $order = ' ORDER BY ' . $param_order;
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }

        //JOIN
        if ($param_type_join_user_membership == 'INNER' || $param_type_join_user_membership == 'LEFT') {
            $type_join = $param_type_join_user_membership;
        } else {
            $type_join = ' LEFT ';
        }

        $join = [];
        $join[] = ' LEFT JOIN ' . cb_sql_table('currency') . ' ON currency.id_currency = ' . $this->tablename . '.id_currency';

        if ($param_join_users) {
            $join[] = ' ' . $type_join . ' JOIN ' . cb_sql_table($this->tablename_user_membership) . ' ON ' . $this->tablename_user_membership . '.id_membership = ' . $this->tablename . '.id_membership';
            $join[] = ' LEFT JOIN ' . cb_sql_table('user_levels') . ' ON user_levels.user_level_id = ' . $this->tablename . '.user_level_id';
            $select[] = 'user_levels.user_level_name';

            $join[] = ' LEFT JOIN ' . cb_sql_table('users') . ' ON users.userid = ' . $this->tablename_user_membership . '.userid';
            $select[] = 'users.username';
        }

        //SELECT
        if ($param_count) {
            if ($param_get_user_membership) {
                $select = ['COUNT(DISTINCT ' . $this->tablename_user_membership . '.id_user_membership) AS count'];
            } else {
                $select = ['COUNT(DISTINCT ' . $this->tablename . '.id_membership) AS count'];
            }
        } else {
            if ($param_get_user_membership) {
                $select = $this->getSQLFields('user_membership');
                $select[] = $this->tablename . '.frequency';
                $select[] = '\'unknown\' AS next_date_renew';
                $select[] = $this->tablename . '.storage_quota_included';
                $select[] = $this->tablename . '.storage_price_per_go';

                $join[] = ' LEFT JOIN ' . cb_sql_table('user_memberships_status') . ' ON user_memberships_status.id_user_memberships_status = ' . $this->tablename_user_membership . '.id_user_memberships_status ';
                $select[] = 'user_memberships_status.language_key_title';
                $select[] = $this->tablename.'.id_membership AS id_membership_from_join';

                if (!$param_join_users) {
                    throw new Exception('params join_users must be present for user_membership');
                }

                $select[] = 'user_levels.user_level_name';

                // add membership fields
                $select[] = $this->tablename.'.base_price';
                $select[] = $this->tablename.'.disabled = 1 AS is_membership_disabled';
                $select[] = 'currency.code AS code_currency';

                $join[] = ' LEFT JOIN ' . cb_sql_table('user_billing_address') . ' ON user_billing_address.id_user_billing_address = ' . $this->tablename_user_membership . '.id_user_billing_address ';
                $select[] = 'user_billing_address.billing_name';
                $select[] = 'user_billing_address.billing_address_line_1';
                $select[] = 'user_billing_address.billing_address_line_2';
                $select[] = 'user_billing_address.billing_admin_area_1';
                $select[] = 'user_billing_address.billing_admin_area_2';
                $select[] = 'user_billing_address.billing_postal_code';
                $select[] = 'user_billing_address.billing_country_code';

            } else {
                $select = $this->getSQLFields('membership');
                if ($param_get_nb_users) {
                    $select[] = ' COUNT(DISTINCT '.$this->tablename_user_membership . '.id_user_membership) AS nb_user_membership ';
                }
            }
            $select[] = 'currency.symbol';
        }

        $sql = 'SELECT * FROM (SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table($this->tablename)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(',', $group))
            . $having . ') AS R'
            . $order
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);

        if ($param_count) {
            if (empty($result)) {
                return 0;
            }
            return $result[0]['count'];
        }

        if (!$result) {
            return [];
        }

        if ($param_first_only) {
            return $result[0];
        }

        return $result;

    }

    public function getAllSubscribers(array $params)
    {
        $param_order = $params['order'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_user_level_id = $params['user_level_id'] ?? false;
        $param_id_membership = $params['id_membership'] ?? false;
        $param_not_id_membership = $params['not_id_membership'] ?? false;
        $param_userid = $params['userid'] ?? false;
        $param_username = $params['username'] ?? false;
        $param_frequency = $params['frequency'] ?? false;
        $param_first_only = $params['first_only'] ?? false;

        if ($param_id_membership !== false) {
            $conditions[] = $this->tablename . '.id_membership = \'' . mysql_clean($param_id_membership) . '\'';
        }
        if ($param_not_id_membership !== false) {
            $conditions[] = $this->tablename . '.id_membership != \'' . mysql_clean($param_not_id_membership) . '\'';
        }
        if ($param_user_level_id !== false) {
            $conditions[] = $this->tablename . '.user_level_id = \'' . mysql_clean($param_user_level_id) . '\'';
        }
        if ($param_frequency !== false) {
            $conditions[] = $this->tablename . '.frequency = \'' . mysql_clean($param_frequency) . '\'';
        }
        if ($param_userid !== false) {
            $conditions[] = $this->tablename_user_membership . '.userid = \'' . mysql_clean($param_userid) . '\'';
        }
        if ($param_username !== false) {
            $conditions[] = ' users.username like \'%' . mysql_clean($param_username) . '%\'';
        }

        $order = '';
        if ($param_order && !$param_count) {
            $order = ' ORDER BY ' . $param_order;
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }

        $sql = /** @lang MySQL */
            'WITH R AS (SELECT users.username, user_memberships.userid, user_memberships.date_start
                , user_memberships.date_end, user_memberships.id_user_membership
                , SUM(user_memberships.price)                                                  AS sum_price
                , symbol, user_level_name, frequency
                , MAX(user_memberships.date_start) OVER (PARTITION BY user_memberships.userid) AS max_date_start
                , MIN(date_start) OVER (PARTITION BY user_memberships.userid)                  AS min_date_start
           FROM '.cb_sql_table($this->tablename).' 
                    INNER JOIN '.cb_sql_table($this->tablename_user_membership).' ON user_memberships.id_membership = memberships.id_membership
                    LEFT JOIN '.cb_sql_table('user_levels').' ON user_levels.user_level_id = memberships.user_level_id
                    LEFT JOIN '.cb_sql_table('currency').' ON currency.id_currency = memberships.id_currency
                    LEFT JOIN '.cb_sql_table('users').' ON users.userid = user_memberships.userid
           '. (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions)). '
           GROUP BY user_memberships.userid, memberships.id_currency, date_start, date_end, id_user_membership)
            SELECT R_first.username, R_first.userid,
                   GROUP_CONCAT(R.sum_price, \' \', R.symbol)                                                           AS sum_price,
                   R_first.date_start                                                                                   AS first_start,
                   CASE WHEN COUNT(R_last.date_end) < COUNT(R_last.userid) THEN \'2999-12-12\' ELSE R_last.date_end END AS last_end,
                   COUNT(R.id_user_membership)                                                                          AS nb_membership,
                   R_last.user_level_name,
                   R_last.frequency
            FROM R
             INNER JOIN R AS R_first ON R_first.userid = R.userid AND R_first.date_start = R_first.min_date_start
             INNER JOIN R AS R_last ON R_last.userid = R.userid AND R_last.date_start = R_last.max_date_start
            GROUP BY R.username, R.userid, R_last.user_level_name, R_last.frequency, first_start, R_last.date_end'
            . $order . $limit;
        $result = Clipbucket_db::getInstance()->_select($sql);

        if ($param_count) {
            if (empty($result)) {
                return 0;
            }
            return $result[0]['count'];
        }

        if (!$result) {
            return [];
        }
        if ($param_first_only) {
            return $result[0];
        }
        return $result;
    }

    public function getAllHistoMembershipForUser(array $params)
    {
        if (empty($params['userid'])) {
            return false;
        }
        $params['join_users'] = true;
        $params['get_user_membership'] = true;
        $params['type_join_user_membership'] = 'INNER';
        if (empty($params['order'])) {
            $params['order'] = 'date_start DESC';
        }
        return $this->getAll($params);
    }

    private function getSQLFields($type = '', $prefix = false): array
    {
        switch ($type) {
            case 'membership':
            default:
                $fields = $this->fields;
                $tablename = $this->tablename;
                break;

            case 'user_membership':
                $fields = $this->fields_user_membership;
                $tablename = $this->tablename_user_membership;
                break;
        }

        return array_map(function ($field) use ($prefix, $tablename) {
            $field_name = $tablename . '.' . $field;
            if ($prefix) {
                $field_name .= ' AS `' . $tablename . '.' . $field . '`';
            }
            return $field_name;
        }, $fields);
    }

    public static function getInstance(): self
    {
        if (empty(self::$membership)) {
            self::$membership = new self();
        }
        return self::$membership;
    }

    /**
     * @param array $membership
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function update(array $membership)
    {
        $sql = 'UPDATE ' . tbl($this->tablename) . ' SET ';
        $updated_fields = [];
        $membership = $this->formatAndValidateFields($membership);
        if ($membership === false) {
            return false;
        }
        foreach ($this->fields as $field) {
            if ($field == 'id_membership') {
                continue;
            }
            if (isset($membership[$field])) {
                $updated_fields[] = $field . ' = ' . $membership[$field];
            }
        }
        $sql .= implode(', ', $updated_fields) . ' WHERE id_membership = ' . mysql_clean($membership['id_membership']);
        return Clipbucket_db::getInstance()->execute($sql);
    }

    /**
     * @param array $histoMembership
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function updateHistoMembership(array $histoMembership)
    {
        $sql = 'UPDATE ' . tbl($this->tablename_user_membership) . ' SET ';
        $updated_fields = [];
        $histoMembership = $this->formatAndValidateFieldsHistoMembership($histoMembership);
        if ($histoMembership === false) {
            return false;
        }
        foreach ($this->fields_user_membership as $field) {
            if ($field == 'id_user_membership') {
                continue;
            }
            if (isset($histoMembership[$field])) {
                $updated_fields[] = $field . ' = \'' . $histoMembership[$field].'\'';
            }
        }
        $sql .= implode(', ', $updated_fields) . ' WHERE id_user_membership = ' . mysql_clean($histoMembership['id_user_membership']);
        return Clipbucket_db::getInstance()->execute($sql);
    }

    /**
     * @param array $membership
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function insert(array $membership)
    {
        $sql = 'INSERT INTO ' . tbl($this->tablename) . ' ';
        $fields = [];
        $values = [];
        $membership = $this->formatAndValidateFields($membership);
        if ($membership === false) {
            return false;
        }
        foreach ($this->fields as $field) {
            if ($field == 'id_membership') {
                continue;
            }
            if (isset($membership[$field])) {
                $fields[] = $field;
                $values[] = '\''.$membership[$field].'\'';
            }
        }
        $sql .= ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ') ';
        Clipbucket_db::getInstance()->execute($sql);
        return Clipbucket_db::getInstance()->insert_id();
    }

    /**
     * @param array $histoMembership
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function insertHistoMembership(array $histoMembership)
    {
        if (empty($histoMembership['userid'])) {
            return false;
        }

        $sql = 'INSERT INTO ' . tbl($this->tablename_user_membership) . ' ';
        $fields = [];
        $values = [];
        $histoMembership = $this->formatAndValidateFieldsHistoMembership($histoMembership);

        if ($histoMembership === false) {
            return false;
        }
        foreach ($this->fields_user_membership as $field) {
            if ($field == 'id_user_membership') {
                continue;
            }
            if (isset($histoMembership[$field])) {
                $fields[] = $field;
                $values[] = $histoMembership[$field];
            }
        }

        $sql .= ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ') ';
        Clipbucket_db::getInstance()->execute($sql);
        return Clipbucket_db::getInstance()->insert_id();
    }


    public function formatAndValidateFieldsHistoMembership(array $fields)
    {
        foreach ($fields as $field => &$value) {
            $value = mysql_clean($value);
            switch ($field) {
                case 'userid':
                case 'id_membership':
                case 'id_user_billing_address':
                    if (empty($value)) {
                        e(lang('missing_params'));
                        return false;
                    } elseif ((int)$value != $value) {
                        e(lang('error_type'));
                        return false;
                    }
                    break;

                case 'id_user_memberships_status':
                    if (empty($value)) {
                        e(lang('missing_params'));
                        return false;
                    }
                    /** @todo Clement : a remplir je ne sait pas comment vous verifier */
                    break;

                case 'is_card_saved':
                case 'is_auto_renew':
                    if (empty($value)) {
                        e(lang('missing_params'));
                        return false;
                    } elseif (!in_array($value, ['yes', 'no'])) {
                        e(lang('error_type'));
                        return false;
                    }
                    break;

                case 'date_start':
                case 'date_end':
                    /** @todo Clement : a remplir je ne sait pas comment vous verifiez les dates */
                    break;
                default:
                    break;

            }
        }
        return $fields;
    }

    public function formatAndValidateFields(array $fields)
    {
        //check user_level/frequency

        if (!empty($fields['frequency']) && !empty($fields['user_level_id'])) {
            $existing_user_level_frequency = $this->getOne([
                'frequency'         => $fields['frequency'],
                'user_level_id'     => $fields['user_level_id'],
                'not_id_membership' => $fields['id_membership'] ?: false
            ]);
        }
        if (!empty($existing_user_level_frequency)) {
            e(lang('user_level_frequency_already_exist', [
                lang(str_replace(' ', '_', strtolower($existing_user_level_frequency['user_level_name']))),
                lang('frequency_' . $existing_user_level_frequency['frequency'])
            ]));
            return false;
        }

        foreach ($fields as $field => &$value) {
            $value = mysql_clean($value);
            switch ($field) {
                case 'base_price':
                case 'storage_price_per_go':
                case 'storage_quota_included':
                    if (empty($value)) {
                        $value = 0;
                    } elseif ((int)$value != $value) {
                        e(lang('error_type'));
                        return false;
                    }
                    break;
                case 'id_currency':
                    if (empty(trim($value,'^\r\n\t\f\v  '))) {
                        e(lang('missing_currency'));
                        return false;
                    }
                    break;
                case 'description':
                case 'frequency':
                    if (empty($value)) {
                        e(lang('missing_params'));
                        return false;
                    }
                    $value = '\'' . $value . '\'';
                    break;
                case 'allowed_emails':
                    if (!empty($value)) {
                        $list_email = explode(',', $value);
                        foreach ($list_email as $email) {
                            if (!isValidEmail($email)) {
                                e(lang('email_is_not_valid',[$email]));
                                return false;
                            }
                        }
                    }
                    $value = '\'' . $value . '\'';
                    break;
                case 'user_level_id':
                    if ($value == UserLevel::getDefaultId()) {
                        e(lang('membership_cant_be_configured_for_default_user_level'));
                        return false;
                    }
                    break;
                default:
                    break;

            }
        }
        if (!isset($fields['disabled'])) {
            $fields['disabled'] = 1;
        }
        if (!isset($fields['only_visible_eligible'])) {
            $fields['only_visible_eligible'] = 0;
        }
        return $fields;
    }

    public function delete(int $id_membership): bool
    {
        if (empty($id_membership)) {
            e(lang('missing_params'));
            return false;
        }
        return Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl($this->tablename) . ' WHERE id_membership = ' . mysql_clean($id_membership));
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getAllCurrency(): array
    {
        $sql = 'SELECT * FROM ' . tbl('currency');
        $results = Clipbucket_db::getInstance()->_select($sql);
        if (empty($results)) {
            return [];
        }
        return $results;
    }

    public function getCurrentMembershipForUser(int $user_id)
    {
        $results = Membership::getInstance()->getAll([
            'first_only'          => true,
            'date_between'        => date('Y-m-d H:i:s'),
            'userid'              => $user_id,
            'get_user_membership' => true,
            'join_users'          => true,
            'language_key_title'  => ['completed', 'canceled', 'refunded'],
            'order'               => 'CASE 
                                        WHEN language_key_title = \'completed\' THEN 0 
                                        ELSE 1
                                      END ASC, date_start DESC, id_user_membership DESC',
            'limit'               => 1
        ]);

        if(empty($results)){
            return [];
        }

        return $results;
    }

    public function isUserMembershipHasAlreadyHaveCompletedTransactionInHisHistory(int $id_user_membership)
    {
        $sql = 'SELECT 1 
                FROM ' . cb_sql_table('user_memberships_transactions') .' 
                INNER JOIN ' . cb_sql_table('paypal_transactions') .' ON user_memberships_transactions.id_paypal_transaction = paypal_transactions.id_paypal_transaction
                WHERE paypal_transactions.status in (\'COMPLETED\', \'REFUND\')
                AND user_memberships_transactions.id_user_membership = '.(int)$id_user_membership.'
                ';
        $result = Clipbucket_db::getInstance()->_select($sql);
        return !empty($result);
    }
}