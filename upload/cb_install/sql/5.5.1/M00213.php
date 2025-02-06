<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00213 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels` MODIFY COLUMN `user_level_id` int(20) NOT NULL AUTO_INCREMENT;', [
            'table' => 'user_levels',
            'column' => 'user_level_id'
        ]);
    }
}