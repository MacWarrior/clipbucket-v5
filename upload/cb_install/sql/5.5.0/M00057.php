<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00057 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` MODIFY COLUMN `category` VARCHAR(200) NULL DEFAULT NULL;', [
            'table'  => '{tbl_prefix}video',
            'column' => 'category'
        ]);
    }
}