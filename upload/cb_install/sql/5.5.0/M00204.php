<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00204 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` CHANGE `status` `status` ENUM(\'Successful\',\'Processing\',\'Failed\',\'Waiting\') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT \'Processing\';', [
            'table' => 'video',
            'column' => 'status'
        ]);
        self::generateTranslation('waiting', [
            'en' => 'Waiting',
            'fr' => 'En attente'
        ]);
    }
}