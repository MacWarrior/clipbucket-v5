<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00069 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}users` DROP `background_attachement`;', [
            'table'  => 'users',
            'column' => 'background_attachement'
        ]);
    }
}