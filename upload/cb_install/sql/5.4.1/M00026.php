<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00026 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` MODIFY COLUMN `userid` INT(60) NULL DEFAULT NULL;', [
            'table'  => '{tbl_prefix}comments',
            'column' => 'userid'
        ]);
    }
}