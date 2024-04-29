<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00009 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}plugins` MODIFY COLUMN `plugin_version` FLOAT NOT NULL DEFAULT \'0\';', [
            'table' => '{tbl_prefix}plugins',
            'column' => 'plugin_version',
        ]);
    }
}