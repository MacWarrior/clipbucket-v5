<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00266 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `total_objects`;', [
            'table'  => '{tbl_prefix}collections',
            'column' => 'total_objects',
        ]);
    }
}