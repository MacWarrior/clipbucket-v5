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
        ];

        $this->fields_user_membership = [
            'id_user_membership',
            'userid',
            'id_membership',
            'date_start',
            'date_end',
            'price'
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
        $param_id_membership = $params['id_membership'] ?? false;
        $param_userid = $params['userid'] ?? false;
        $param_first_only = $params['first_only'] ?? false;

        $conditions = [];
        if ($param_id_membership !== false) {
            $conditions[] = $this->tablename . '.id_membership = \'' . mysql_clean($param_id_membership) . '\'';
        }
        if ($param_user_level_id !== false) {
            $conditions[] = $this->tablename . '.user_level_id = \'' . mysql_clean($param_user_level_id) . '\'';
        }
        if ($param_userid !== false) {
            $conditions[] = $this->tablename_user_membership . '.userid = \'' . mysql_clean($param_userid) . '\'';
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
            $group[] = str_replace([
                'asc',
                'desc'
            ], '', strtolower($param_order));
            $order = ' ORDER BY ' . $param_order;
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }

        if ($param_count) {
            $select = ['COUNT(DISTINCT ' . $this->tablename . '.id_membership) AS count'];
        } else {
            $select = $this->getSQLFields('membership');
            $select[] = 'user_levels.user_level_name';
            $select[] = $this->tablename_user_membership.'.id_user_membership';
        }

        $join = [];

        $join[] = ' LEFT JOIN ' . cb_sql_table('user_levels') . ' ON user_levels.user_level_id = ' . $this->tablename . '.user_level_id';
        $join[] = ' LEFT JOIN ' . cb_sql_table($this->tablename_user_membership) . ' ON '.$this->tablename_user_membership.'.id_membership = ' . $this->tablename . '.id_membership';

        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table($this->tablename)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(',', $group))
            . $having
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
        foreach ($this->fields as $field) {
            if ($field == 'id_membership') {
                continue;
            }
            if (isset($membership[$field])) {
                if ((int)$membership[$field] == $membership[$field]) {
                    $value = mysql_clean($membership[$field]);
                } else {
                    $value = '\'' . mysql_clean($membership[$field]) . '\'';
                }
                $updated_fields[] = $field . ' = ' . $value;
            }
        }
        $sql .= implode(', ', $updated_fields) . ' WHERE id_membership = ' . mysql_clean($membership['id_membership']);
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
        foreach ($this->fields as $field) {
            if ($field == 'id_membership') {
                continue;
            }
            if (isset($membership[$field])) {
                $fields[] = $field;
                if ((int)$membership[$field] == $membership[$field]) {
                    $value = mysql_clean($membership[$field]);
                } else {
                    $value = '\'' . mysql_clean($membership[$field]) . '\'';
                }
                $values[] = $value;
            }
        }
        $sql .= ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ') ';
        Clipbucket_db::getInstance()->execute($sql);
        return Clipbucket_db::getInstance()->insert_id();
    }



    public function delete(int $id_membership): bool
    {
        if (empty($id_membership)) {
            e(lang('missing_param'));
            return false;
        }
        return Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl($this->tablename) . ' WHERE id_membership = ' . mysql_clean($id_membership));
    }

}