<?php

class UserLevel
{
    private static $user_permissions = [];

    private static $tableNamePermission = 'user_levels_permissions';
    private static $tableNamePermissionValue = 'user_levels_permissions_values';

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
                $permissions = self::getAll(['user_level_id'=>$user_level_id]);
            self::$user_permissions[$user_level_id] = array_combine(array_column($permissions, 'permission_name'), $permissions);
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
        return (self::getPermissions($user_level_id)[$permission]['permission_value'] ?? false);
    }


    /**
     * @param string $permission
     * @param int|null $user_level_id
     * @return bool
     * @throws Exception
     */
    public static function hasPermission(string $permission, int $user_level_id = null): bool
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
    public static function hasPermissionOrRedirect(string $permission, int $user_id = null, bool $must_be_logged = false): bool
    {
        if ($must_be_logged && !User::getInstance()->isUserConnected()) {
           User::redirectToLogin();
        }
        if (!self::hasPermission($permission, $user_id)) {
            redirect_to(BASEURL.'/403.php' );
        }
        return true;
    }



    /**
     * @param $params
     * @return array
     * @throws Exception
     */
    public static function getAll($params): array
    {
        $param_userid = $params['userid'] ?? false;
        $param_user_level_id = $params['user_level_id'] ?? false;

        $conditions = [];
        $join = [];
        if ($param_userid!== false) {
            $conditions[] = ' users.userid = ' . mysql_clean($param_userid);
            $join[] = ' LEFT JOIN ' . cb_sql_table('users') . ' ON users.level = ' . self::$tableNamePermissionValue . '.user_level_id';
        }

        $select = self::getAllFields();
        if ($param_user_level_id) {
            $conditions[] = ' ' . self::$tableNamePermissionValue . '.user_level_id = ' . mysql_clean($param_user_level_id);
        }

        $sql = 'SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table(self::$tableNamePermission) . '
                LEFT JOIN ' . cb_sql_table(self::$tableNamePermissionValue) . ' ON ' . self::$tableNamePermission . '.id_user_levels_permission = ' . self::$tableNamePermissionValue . '.id_user_levels_permission'
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions));

        $result = Clipbucket_db::getInstance()->_select($sql);
        return empty($result) ? [] : $result ;
    }

    /**
     * @return array
     */
    private static function getAllFields(): array
    {
        $fields_user = array_map(function ($field) {
            return self::$tableNamePermission . '.' . $field;
        }, self::$fieldsPermission);

        $fields_profile = array_map(function ($field) {
            return self::$tableNamePermissionValue . '.' . $field;
        }, self::$fieldsPermissionValue);

        return array_merge($fields_user, $fields_profile);
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
        Clipbucket_db::getInstance()->update(tbl(self::getTableNameLevelPermissionValue()), ['permission_value'], [$permission_value], 'user_level_id = '.mysql_clean($user_level_id) .' AND id_user_levels_permission = ' . mysql_clean($id_user_levels_permission));
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
        Clipbucket_db::getInstance()->insert(tbl(self::getTableNameLevelPermissionValue()), ['user_level_id', 'id_user_levels_permission','permission_value'], [$user_level_id, $id_user_levels_permission, $permission_value]);
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
        Clipbucket_db::getInstance()->update(tbl('user_levels'), ['user_level_name'], [$user_level_name], 'user_level_id = '.$user_level_id);

        foreach (self::getPermissions($user_level_id) as $permission) {
            if ($permission['permission_value'] == 'yes' && !isset($permissions[$permission['id_user_levels_permission']]) ) {
                //update no
                self::updateUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], 'no');
            } elseif ($permission['permission_value'] == 'no' && isset($permissions[$permission['id_user_levels_permission']])){
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
        foreach (self::getPermissions($user_level_id) as $permission) {
            if ($permission['permission_value'] == 'yes' && !isset($permissions[$permission['id_user_levels_permission']]) ) {
                //update no
                self::insertUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], 'no');
            } elseif ($permission['permission_value'] == 'no' && isset($permissions[$permission['id_user_levels_permission']])){
                //update yes
                self::insertUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], $permissions[$permission['id_user_levels_permission']]);
            } else {
                //update other
                self::insertUserPermissionValue($user_level_id, $permission['id_user_levels_permission'], $permissions[$permission['id_user_levels_permission']]);
            }
        }
    }



}