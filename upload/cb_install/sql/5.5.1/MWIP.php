<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'SELECT * FROM information_schema.STATISTICS WHERE `INDEX_TYPE` LIKE \'%FULLTEXT%\' AND TABLE_SCHEMA = \''.\Clipbucket_db::getInstance()->getTableName().'\' AND TABLE_NAME = \''.tbl('video').'\'';
        $results = \Clipbucket_db::getInstance()->_select($sql);
        if (empty($results)) {
            self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD FULLTEXT KEY `description` (`description`,`title`);', [
                'table'  => 'video',
                'columns' => ['description','title']
            ]);
            self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD FULLTEXT KEY `title` (`title`);', [
                'table'  => 'video',
                'column' => 'title'
            ]);
        }
    }
}