<?php
namespace V5_3_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00005 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` MODIFY COLUMN `user_profile_id` INT(11) NOT NULL AUTO_INCREMENT;', [
            'table' => 'user_profile',
            'column' => 'user_profile_id'
        ]);
    }
}