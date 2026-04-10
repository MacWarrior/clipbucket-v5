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
        self::generateConfig('use_backdrop_as_default_thumb', 'disallowed');

        self::generateTranslation('option_use_backdrop_as_default_thumb', [
            'fr'=>'Utilisation du décor comme vignette par défaut',
            'en'=>'Usage of video backdrop as default thumb'
        ]);

        self::generateTranslation('use_backdrop_as_default_thumb', [
            'fr'=>'Utiliser le décor par défaut comme vignette par défaut',
            'en'=>'Use default backdrop as default thumb'
        ]);

        self::generateTranslation('allowed', [
            'fr'=>'Autorisé',
            'en'=>'Allowed'
        ]);

        self::generateTranslation('disallowed', [
            'fr'=>'Interdit',
            'en'=>'Disallowed'
        ]);

        self::generateTranslation('forced', [
            'fr'=>'Forcé',
            'en'=>'Forced'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN `use_backdrop_as_default_thumb` ENUM(\'yes\', \'no\') DEFAULT \'no\'', [
            'table' => 'video',
        ], [
            'table' => 'video',
            'column' => 'use_backdrop_as_default_thumb'
        ]);
    }
}

