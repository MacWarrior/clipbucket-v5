<?php
namespace V5_4_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00034 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}ads_data` MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, DROP `ad_category`;', [
            'table' => 'ads_data',
            'columns' => [
                'last_viewed',
                'ad_category'
            ]
        ]);
    }
}