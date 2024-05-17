<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00277 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}video` SET `broadcast` = \'public\' WHERE `broadcast` = \'\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD FULLTEXT KEY `collection_name` (`collection_name`);', [
            'table' => 'collections',
            'column' => 'collection_name'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users` ADD FULLTEXT KEY `username_fulltext` (`username`);', [
            'table' => 'users',
            'column' => 'username'
        ]);
    }
}