<?php
namespace V5_4_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00038 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE `name` IN (
            \'default_time_zone\'
            ,\'user_max_chr\'
            ,\'captcha_type\'
            ,\'user_rate_opt1\'
            ,\'max_time_wait\'
            ,\'index_featured\'
            ,\'index_recent\'
            ,\'videos_items_columns\'
        ); ';
        self::query($sql);
    }
}