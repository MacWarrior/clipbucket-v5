<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00043 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD `collection_id_parent` BIGINT(25) NULL DEFAULT NULL AFTER `collection_id`, ADD INDEX(`collection_id_parent`);', [
            'table' => 'collections'
            ,'column' => 'collection_id'
        ], [
            'table' => 'collections',
            'column' => 'collection_id_parent'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD FOREIGN KEY (`collection_id_parent`) REFERENCES `{tbl_prefix}collections`(`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'collections',
            'columns' => [
                'collection_id_parent',
                'collection_id'
            ],
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'collection_id_parent'
            ]
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'enable_sub_collection\', \'1\');';
        self::query($sql);
    }
}