<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00232 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = ' UPDATE ' . cb_sql_table('user_levels_permissions_values') . ' set permission_value = \'yes\' WHERE user_level_id = 1;';
        self::query($sql);
    }
}