<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00036 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_categories` MODIFY COLUMN `category_thumb` MEDIUMTEXT NOT NULL;', [
            'table' => 'collection_categories',
            'column' => 'category_thumb'
        ]);
    }
}