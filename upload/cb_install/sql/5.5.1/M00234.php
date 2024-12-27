<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00234 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DELETE FROM ' . tbl('ads_data') . ' WHERE ad_placement IN(\'ad_160x600\',\'ad_468x60\',\'ad_120x600\');';
        self::query($sql);

        $sql = 'DELETE FROM ' . tbl('ads_placements') . ' WHERE placement IN(\'ad_160x600\',\'ad_468x60\',\'ad_120x600\');';
        self::query($sql);
    }
}