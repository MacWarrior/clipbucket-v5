<?php

class UserLevel
{
    private static $user_permissions = [];

    private static $tableName = 'user_levels';
    private static $tableNamePermission = 'user_levels_permissions';
    private static $tableNamePermissionValue = 'user_levels_permissions_values';

    private static $fields = [
        'user_level_id',
        'user_level_active',
        'user_level_name',
        'user_level_is_default'
    ];
    private static $fieldsPermission = [
        'id_user_levels_permission',
        'id_user_permission_types',
        'permission_name',
        'permission_description'
    ];
    private static $fieldsPermissionValue = [
        'user_level_id',
        'id_user_levels_permission',
        'permission_value',
    ];

    /**
     * @param int $user_level_id
     * @return array|false|mixed
     * @throws Exception
     */
    public static function getPermissions($user_level_id = 4)
    {
        $user_level_id = empty($user_level_id) ? 4 : $user_level_id;
        if (empty(self::$user_permissions[$user_level_id])) {
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '197')) {
                $permissions = self::getAllPermissions(['user_level_id' => $user_level_id]);
                self::$user_permissions[$user_level_id] = array_combine(array_column($permissions, 'permission_name'), $permissions);
            } else {
                $result = Clipbucket_db::getInstance()->select(tbl('user_levels,user_levels_permissions'), '*',
                    tbl('user_levels_permissions.user_level_id') . "='" . $user_level_id . "' 
                              AND " . tbl('user_levels_permissions.user_level_id') . ' = ' . tbl('user_levels.user_level_id'), false, false, false, 600);
                self::$user_permissions[$user_level_id] = $result[0];
            }
        }
        return self::$user_permissions[$user_level_id];
    }

    public static function getTableNameLevelPermission(): string
    {
        return self::$tableNamePermission;
    }

    public static function getTableNameLevelPermissionValue(): string
    {
        return self::$tableNamePermissionValue;
    }

    /**
     * @param $permission
     * @param $user_level_id
     * @return false|mixed
     * @throws Exception
     */
    public static function getPermission($permission, $user_level_id)
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '197')) {
            return (self::getPermissions($user_level_id)[$permission]['permission_value'] ?? false);
        }

        return (self::getPermissions($user_level_id)[$permission] ?? false);
    }


    /**
     * @param string $permission
     * @param int|null $user_level_id
     * @return bool
     * @throws Exception
     */
    public static function hasPermission(string $permission, $user_level_id = null): bool
    {
        return (self::getPermission($permission, $user_level_id)) == 'yes';
    }

    /**
     * @param string $permission
     * @param int|null $user_id
     * @param bool $must_be_logged
     * @return true
     * @throws Exception
     */
    public static function hasPermissionOrRedirect(string $permission, $user_id = null, bool $must_be_logged = false): bool
    {
        if ($must_be_logged && !User::getInstance()->isUserConnected()) {
            User::redirectToLogin();
        }
        if (!self::hasPermission($permission, $user_id)) {
            redirect_to(BASEURL . '/403.php');
        }
        return true;
    }

    /**
     * @param $params
     * @return array
     * @throws Exception
     */
    public static function getAllPermissions($params): array
    {
        $param_userid = $params['userid'] ?? false;
        $param_user_level_id = $params['user_level_id'] ?? false;
        $param_no_values = $params['no_values'] ?? false;

        $conditions = [];
        $join = [];
        if ($param_userid !== false) {
            $conditions[] = ' users.userid = ' . mysql_clean($param_userid);
            $join[] = ' LEFT JOIN ' . cb_sql_table('users') . ' ON users.level = ' . self::$tableNamePermissionValue . '.user_level_id';
        }

        $select = self::getAllPermissionsFields($param_no_values);
        if ($param_user_level_id) {
            $conditions[] = ' ' . self::$tableNamePermissionValue . '.user_level_id = ' . mysql_clean($param_user_level_id);
        }

        if (!$param_no_values) {
            $join[] = ' INNER JOIN ' . cb_sql_table(self::$tableNamePermissionValue) . ' ON ' . self::$tableNamePermission . '.id_user_levels_permission = ' . self::$tableNamePermissionValue . '.id_user_levels_permission';
        }

        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table(self::$tableNamePermission)

            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions));

        $result = Clipbucket_db::getInstance()->_select($sql);
        return empty($result) ? [] : $result;
    }

    /**
     * @param bool $no_values
     * @return array
     */
    private static function getAllPermissionsFields(bool $no_values = false): array
    {
        $fields_user = array_map(function ($field) {
            return self::$tableNamePermission . '.' . $field;
        }, self::$fieldsPermission);

        if (!$no_values) {
            $fields_values = array_map(function ($field) {
                return self::$tableNamePermissionValue . '.' . $field;
            }, self::$fieldsPermissionValue);
        }

        return array_merge($fields_user, $fields_values ?? []);
    }


    /**
     * @param int $user_level_id
     * @param int $id_user_levels_permission
     * @param $permission_value
     * @return void
     * @throws Exception
     */
    public static function updateUserPermissionValue(int $user_level_id, int $id_user_levels_permission, $permission_value)
    {
        Clipbucket_db::getInstance()->update(tbl(self::getTableNameLevelPermissionValue()), ['permission_value'], [$permission_value], 'user_level_id = ' . mysql_clean($user_level_id) . ' AND id_user_levels_permission = ' . mysql_clean($id_user_levels_permission));
    }

    /**
     * @param int $user_level_id
     * @param int $id_user_levels_permission
     * @param $permission_value
     * @return void
     * @throws Exception
     */
    public static function insertUserPermissionValue(int $user_level_id, int $id_user_levels_permission, $permission_value)
    {
        Clipbucket_db::getInstance()->insert(tbl(self::getTableNameLevelPermissionValue()), [
            'user_level_id',
            'id_user_levels_permission',
            'permission_value'
        ], [
            $user_level_id,
            $id_user_levels_permission,
            $permission_value
        ]);
    }


    /**
     * @return array
     */
    private static function getAllFields(): array
    {
        return array_map(function ($field) {
            return self::$tableName . '.' . $field;
        }, self::$fields);

    }

    /**
     * @param array $params
     * @throws Exception
     */
    public static function getAll(array $params)
    {
        $param_user_level_id = $params['user_level_id'] ?? false;
        $param_first_only = $params['first_only'] ?? false;

        $conditions = [];
        $join = [];

        $select = self::getAllFields();
        if ($param_user_level_id) {
            $conditions[] = ' ' . self::$tableName . '.user_level_id = ' . mysql_clean($param_user_level_id);
        }


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
     * @param array $params
     * @return array
     */
    public static function getOne(array $params)
    {
        $params['first_only'] = true;
        return self::getAll($params);
    }

    /**
     * @param int $user_level_id
     * @param string $user_level_name
     * @param $permissions
     * @return void
     * @throws Exception
     */
    public static function updateUserLevel(int $user_level_id, string $user_level_name, $permissions)
    {
        Clipbucket_db::getInstance()->update(tbl('user_levels'), ['user_level_name'], [$user_level_name], 'user_level_id = ' . $user_level_id);

        foreach (self::getPermissions($user_level_id) as $permission) {
            if ($permission['permission_value'] == 'yes' && !isset($permissions[$permission['id_user_levels_permission']])) {
                //update no
                self::updateUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], 'no');
            } elseif ($permission['permission_value'] == 'no' && isset($permissions[$permission['id_user_levels_permission']])) {
                //update yes
                self::updateUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], $permissions[$permission['id_user_levels_permission']]);
            } else {
                //update other
                self::updateUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], $permissions[$permission['id_user_levels_permission']]);
            }
        }
    }

    public static function addUserLevel(string $user_level_name, $permissions)
    {
        Clipbucket_db::getInstance()->insert(tbl('user_levels'), ['user_level_name'], [$user_level_name]);
        $user_level_id = Clipbucket_db::getInstance()->insert_id();
        foreach (self::getPermissions(1) as $permission) {
            if ($permission['permission_value'] == 'yes' && !isset($permissions[$permission['id_user_levels_permission']])) {
                //update no
                self::insertUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], 'no');
            } elseif ($permission['permission_value'] == 'no' && isset($permissions[$permission['id_user_levels_permission']])) {
                //update yes
                self::insertUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], $permissions[$permission['id_user_levels_permission']]);
            } else {
                //update other
                self::insertUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], $permissions[$permission['id_user_levels_permission']]);
            }
        }
    }


    /**
     * @param int $user_level_id
     * @return bool
     * @throws Exception
     */
    public static function deleteUserLevel(int $user_level_id)
    {
        $user_level = self::getOne(['user_level_id' => $user_level_id]);
        if (!empty($user_level)) {
            if ($user_level['user_level_is_default'] == 'yes') {
                e(lang('level_not_deleteable'));
                return false;
            }
            Clipbucket_db::getInstance()->delete(tbl(self::$tableNamePermissionValue), ['user_level_id'], [$user_level_id]);
            Clipbucket_db::getInstance()->delete(tbl(self::$tableName), ['user_level_id'], [$user_level_id]);
            $inactive_user = self::getOne(['user_level_id' => 3]);;
            e(lang('level_del_sucess', $inactive_user['user_level_name']), 'm');
            Clipbucket_db::getInstance()->update(tbl('users'), ['level'], [3], ' level=' . mysql_clean($user_level_id));
            return true;
        }
        return false;
    }


}