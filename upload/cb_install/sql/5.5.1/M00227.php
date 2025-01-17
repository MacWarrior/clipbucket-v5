<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00227 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('sessions') . ' MODIFY COLUMN `ip` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;', [
            'table'  => 'sessions',
            'column' => 'ip'
        ]);
    }
}