<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00028 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}contacts` MODIFY COLUMN `contact_group_id` INT(255) NOT NULL DEFAULT \'0\';', [
            'table' => '{tbl_prefix}contacts',
            'column' => 'contact_group_id'
        ]);
    }
}