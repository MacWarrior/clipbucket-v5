<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00050 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}plugins` MODIFY COLUMN `plugin_version` VARCHAR(32) NOT NULL;', [
            'table'  => 'plugins',
            'column' => 'plugin_version'
        ]);
    }
}