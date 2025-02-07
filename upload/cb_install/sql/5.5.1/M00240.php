<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00240 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('warning_php_version', [
            'fr' => 'Cher administrateur,<br/> Il semble que vous utilisez une ancienne version de PHP (<b>%s</b>). Cette version ne sera plus prise en charge dans la prochaine version <b>%s</b>.<br/>Veuillez mettre à jour votre version de PHP vers %s ou une version supérieure.<br/><br/>Merci d\'utiliser ClipBucketV5 !',
            'en' => 'Dear admin,<br/> It seems that you are using an old version of PHP (<b>%s</b>). This version won\'t be supported anymore on upcomming <b>%s</b> version.<br/>Please update your PHP version to %s or above.<br/><br/>Thank you for using ClipBucketV5 !'
        ]);
    }
}