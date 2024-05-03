<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00017 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video_categories` MODIFY COLUMN `category_thumb` MEDIUMTEXT NOT NULL;', [
            'table'  => 'video_categories',
            'column' => 'category_thumb'
        ]);
    }
}