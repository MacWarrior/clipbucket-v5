<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP2 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}pages` DROP COLUMN `page_content`;', [
            'table' => 'pages',
            'column' => 'page_content'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}pages` DROP COLUMN `page_title`;', [
            'table' => 'pages',
            'column' => 'page_title'
        ]);
    }
}
