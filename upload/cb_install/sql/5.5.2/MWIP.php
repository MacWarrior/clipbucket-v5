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
        self::generateTranslation('error_php_version', [
            'fr'=>'Votre version PHP actuelle (%s) est dépréciée et ne sera plus compatible avec les futures version de ClipBucketV5, veuillez mettre à jour vers à minima PHP 8.1 (8.3 recommandé)',
            'en'=>'Your current PHP version (%s) is deprecated and won’t be compatible with future ClipBucketV5 versions, please update to at least PHP 8.1 (8.3 recommanded)'
        ]);
    }
}
