<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00076 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` CHANGE `allow_comments` `allow_comments` ENUM(\'yes\',\'no\') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT \'yes\';', [
            'table'  => 'collections',
            'column' => 'allow_comments'
        ]);
    }
}
