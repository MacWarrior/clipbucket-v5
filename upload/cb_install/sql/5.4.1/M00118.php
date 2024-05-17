<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00118 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` MODIFY COLUMN `profile_video` INT(255) NOT NULL DEFAULT 0', [
            'table'  =>'user_profile',
            'column' => 'profile_video'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` MODIFY COLUMN `profile_item` VARCHAR(25) NOT NULL DEFAULT \'\'', [
            'table'  =>'user_profile',
            'column' => 'profile_item'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` MODIFY COLUMN `rating` TINYINT(2) NOT NULL DEFAULT 0', [
            'table'  =>'user_profile',
            'column' => 'profile_item'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` MODIFY COLUMN `rated_by` INT(150) NOT NULL DEFAULT 0', [
            'table'  =>'user_profile',
            'column' => 'profile_item'
        ]);
    }
}