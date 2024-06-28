<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00051 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::query('insert into `{tbl_prefix}config` (`name`, `value`) VALUES (\'enable_edit_photo_button\', \'yes\')');
    }
}