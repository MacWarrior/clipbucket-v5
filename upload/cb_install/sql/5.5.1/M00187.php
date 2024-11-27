<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00187 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('photos') . ' MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\' ON UPDATE CURRENT_TIMESTAMP;', [
            'table'  => 'photos',
            'column' => 'last_viewed'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD FULLTEXT KEY `description` (`description`,`title`);', [
            'table'   => 'video',
            'columns' => ['description','title']
        ],[
            'constraint_index' => [
                'table' => 'video',
                'type'  => 'FULLTEXT',
                'name'  => 'description'
            ]
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD FULLTEXT KEY `title` (`title`);', [
            'table'  => 'video',
            'column' => 'title'
        ],[
            'constraint_index' => [
                'table' => 'video',
                'type'  => 'FULLTEXT',
                'name'  => 'title'
            ]
        ]);
    }
}