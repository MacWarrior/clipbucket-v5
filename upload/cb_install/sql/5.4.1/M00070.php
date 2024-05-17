<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00070 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` MODIFY COLUMN `avatar` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'no_avatar.png\';', [
            'table'  => 'user_profile',
            'column' => 'avatar'
        ]);
    }
}