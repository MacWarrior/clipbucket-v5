<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00169 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('users') . ' MODIFY COLUMN `ip` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL;', [
            'table'  => 'users',
            'column' => 'ip'
        ]);
        self::alterTable('ALTER TABLE ' . tbl('users') . ' MODIFY COLUMN `signup_ip` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL;', [
            'table'  => 'users',
            'column' => 'signup_ip'
        ]);

    }
}
