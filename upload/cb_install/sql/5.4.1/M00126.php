<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00126 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}video` SET `datecreated` = \'1000-01-01\' WHERE CAST(`datecreated` AS CHAR(20)) = \'0000-00-00\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` MODIFY COLUMN `datecreated` DATE NOT NULL DEFAULT \'1000-01-01\';', [
            'table'  => 'video',
            'column' => 'datecreated'
        ]);
    }
}