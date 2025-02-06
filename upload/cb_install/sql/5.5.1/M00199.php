<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00199 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}new_user_levels_permissions`
        (
            `id_user_levels_permission` INT                NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_user_permission_types`  INT                NOT NULL,
            `permission_name`           VARCHAR(32) UNIQUE NOT NULL,
            `permission_description`    VARCHAR(32)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci; ';
        self::query($sql);

        $sql = 'ALTER TABLE `{tbl_prefix}new_user_levels_permissions` 
                    ADD CONSTRAINT `fk_id_user_permission_types` FOREIGN KEY (`id_user_permission_types`) REFERENCES `{tbl_prefix}user_permission_types` (`user_permission_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'new_user_levels_permissions',
            'column' => 'id_user_permission_types'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_user_permission_types'
            ]
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}user_levels_permissions_values` (
            `user_level_id` INT NOT NULL,
            `id_user_levels_permission` INT NOT NULL,
            `permission_value` VARCHAR(32) NOT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci; ';
        self::query($sql);

        $sql = 'ALTER TABLE `{tbl_prefix}user_levels_permissions_values` ADD PRIMARY KEY(`user_level_id`, `id_user_levels_permission`);';
        self::alterTable($sql, [
            'table'   => 'user_levels_permissions_values',
            'columns' => [
                'user_level_id',
                'id_user_levels_permission'
            ]
        ], [
            'constraint' => [
                'type'  => 'PRIMARY KEY',
                'table' => 'user_levels_permissions_values'
            ]
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}user_levels_permissions_values` ADD CONSTRAINT `fk_user_level_id` FOREIGN KEY (`user_level_id`) REFERENCES `{tbl_prefix}user_levels` (`user_level_id`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'user_levels_permissions_values',
            'column' => 'user_level_id'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_user_level_id'
            ]
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}user_levels_permissions_values` ADD CONSTRAINT `fk_id_user_levels_permission` FOREIGN KEY (`id_user_levels_permission`) REFERENCES `{tbl_prefix}new_user_levels_permissions` (`id_user_levels_permission`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'user_levels_permissions_values',
            'column' => 'id_user_levels_permission'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_user_levels_permission'
            ]
        ]);

        $sql = 'SELECT column_name AS column_name, IFNULL(permission_type, 4) AS permission_type, permission_desc, permission_name FROM INFORMATION_SCHEMA.COLUMNS AS C 
                   LEFT JOIN `{tbl_prefix}user_permissions` AS TUP ON C.column_name = TUP.permission_code  
                   WHERE TABLE_NAME = \'{tbl_prefix}user_levels_permissions\' AND TABLE_SCHEMA = \'{dbname}\' AND COLUMN_NAME NOT IN (\'user_level_id\', \'user_level_permission_id\')';
        $columns = self::req($sql);
        //insert new_user_levels_permissions
        $sql = 'INSERT INTO `{tbl_prefix}new_user_levels_permissions` (id_user_permission_types, permission_name, permission_description) VALUES ';
        $permissions = [];
        foreach ($columns as $column) {
            if ($column['column_name'] == 'plugins_perms') {
                continue;
            }
            $permissions[] = '(' . $column['permission_type'] . ', \'' . $column['column_name'] . '\', \'' . $column['column_name'] . '_desc\')';
            if (!empty($column['permission_desc'])) {
                self::generateTranslation($column['column_name'] . '_desc', [
                    'en' => $column['permission_desc']
                ]);
            }
            if (!empty($column['permission_name'])) {
                self::generateTranslation($column['column_name'], [
                    'en' => $column['permission_name']
                ]);
            }
        }
        $sql .= implode(',', $permissions) . ';';
        self::query($sql);

        //insert user_levels_permission_values
        $sql = 'SELECT * FROM `{tbl_prefix}user_levels_permissions` ';
        $user_levels_permissions = self::req($sql);
        foreach ($user_levels_permissions as $user_levels_permission) {
            $user_level_id = $user_levels_permission['user_level_id'];
            foreach ($user_levels_permission as $permission => $value) {
                if ($permission == 'user_level_permission_id' || $permission == 'user_level_id') {
                    continue;
                }
                $sql = 'INSERT INTO `{tbl_prefix}user_levels_permissions_values` (user_level_id, id_user_levels_permission, permission_value)  
                            (SELECT ' . $user_level_id . ',
                              id_user_levels_permission ,
                              \'' . $value . '\'  FROM `{tbl_prefix}new_user_levels_permissions` WHERE permission_name = \'' . $permission . '\') ';
                self::query($sql);
            }
        }

        $sql = 'DROP TABLE IF EXISTS ' . tbl('user_levels_permissions');
        self::query($sql);
        $sql = 'DROP TABLE IF EXISTS ' . tbl('user_permissions');
        self::query($sql);

        self::alterTable('ALTER TABLE ' . tbl('new_user_levels_permissions') . ' RENAME ' . tbl('user_levels_permissions'), [
            'table' => 'new_user_levels_permissions'
        ], [
            'table' => 'user_levels_permissions'
        ]);

        self::updateTranslation('view_channels_desc', [
            'en'=>'Can view channels page'
        ]);
        self::generateTranslation('view_channels_desc', [
            'fr'=>'Peut voir la page chaînes'
        ]);

        $sql = 'UPDATE ' . tbl('user_levels_permissions') . ' SET id_user_permission_types = 1 WHERE permission_name = \'playlist_access\'';
        self::query($sql);
    }
}