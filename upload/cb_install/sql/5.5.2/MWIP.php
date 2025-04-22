<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::deleteTranslation('grp_view_vdos');

        $sql = 'UPDATE `' . tbl('config') . '` SET value = \'images/icons/player-logo.png\' WHERE value = \'/images/icons/player-logo.png\' AND name = \'control_bar_logo_url\';';
        self::query($sql);
    }
}
