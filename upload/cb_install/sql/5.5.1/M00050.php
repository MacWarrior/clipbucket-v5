<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00050 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP `profile_item`;', [
            'table'  => 'user_profile',
            'column' => 'profile_item'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP `profile_video`;', [
            'table'  => 'user_profile',
            'column' => 'profile_video'
        ]);
    }
}