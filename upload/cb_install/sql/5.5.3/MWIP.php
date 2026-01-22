<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

        self::deleteTranslation('you_have_already_voted_channel');
        self::deleteTranslation('you_hv_already_rated_vdo');
        self::deleteTranslation('you_hv_already_rated_photo');

    }
}
