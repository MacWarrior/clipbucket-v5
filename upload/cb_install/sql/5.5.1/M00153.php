<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00153 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('action_log') . ' CHANGE `action_ip` `action_ipv4` VARCHAR(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL;', [
            'table'  => 'action_log',
            'column' => 'action_ip'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('action_log') . ' ADD `action_ipv6` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL AFTER `action_ipv4`', [
            'table' => 'action_log'
        ], [
            'table'  => 'action_log',
            'column' => 'action_ipv6'
        ]);
    }
}
