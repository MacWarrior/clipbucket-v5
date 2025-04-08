<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE ' . tbl('collections') . ' SET broadcast = CASE WHEN broadcast= \'yes\' THEN \'public\' ELSE \'private\' END WHERE 1 ';
        self::query($sql);
    }
}
