<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00174 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}email`
                    SET `content` = REPLACE(`content`, \'TO\', \'to\' ) 
                WHERE `code` = \'verify_account\'';
        self::query($sql);
    }
}
