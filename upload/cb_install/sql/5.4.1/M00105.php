<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00105 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `flv_file_url`;', [
            'table'  => '{tbl_prefix}video',
            'column' => 'flv_file_url'
        ]);
    }
}