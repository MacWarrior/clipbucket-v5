<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00077 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` MODIFY COLUMN `datecreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'  => '{tbl_prefix}video',
            'column' => 'datecreated'
        ]);
    }
}