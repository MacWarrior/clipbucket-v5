<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00152 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql='DELETE FROM `{tbl_prefix}plugins` WHERE `plugin_file` = \'customfield.php\'';
        self::query($sql);

        $sql='DROP TABLE IF EXISTS `{tbl_prefix}custom_field`';
        self::query($sql);
    }

}
