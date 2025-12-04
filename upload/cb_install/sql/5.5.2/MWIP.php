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
        self::updateTranslation('warning_php_version', [
            'en'=>'Dear admin,<br/> It seems that you are using an old version of PHP (<b>%s</b>). This version won\'t be supported anymore on upcoming <b>%s </b> version .<br />Please update your PHP version to % s or above .<br /><br />Thank you for using ClipBucketV5 !'
        ]);
    }
}
