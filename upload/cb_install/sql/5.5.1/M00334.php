<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00334 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE ' . tbl('collections') . ' SET broadcast = \'public\' WHERE broadcast = \'yes\';';
        self::query($sql);
    }
}
