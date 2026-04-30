<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN `last_modified` DATETIME NOT NULL DEFAULT NOW()', [
            'table' => 'video'
        ], [
            'table' => 'video',
            'column' => 'last_modified'
        ]);
    }
}
