<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00037 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_channel_slogan','no');
        self::generateConfig('enable_channel_description','no');
        self::generateConfig('enable_channels_slogan_display','no');

        self::deleteTranslation('channel_title');

        self::generateTranslation('option_enable_channel_slogan', [
            'fr'=>'Activer le slogan de chaîne',
            'en'=>'Enable channel slogan'
        ]);
        self::generateTranslation('option_enable_channel_description', [
            'fr'=>'Activer la description de chaîne',
            'en'=>'Enable channel description'
        ]);
        self::generateTranslation('channel_slogan', [
            'fr'=>'Slogan de chaîne',
            'en'=>'Channel slogan'
        ]);
        self::generateTranslation('option_enable_channels_slogan_display', [
            'fr'=>'Activer l\'affichage des slogans de chaînes',
            'en'=>'Enable channels slogan display'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('user_profile') . ' CHANGE `profile_title` `profile_slogan` MEDIUMTEXT NOT NULL;', [
            'table'  => 'user_profile',
            'column' => 'profile_title'
        ]);
    }
}
