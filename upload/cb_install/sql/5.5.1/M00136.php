<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00136 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('enable_channel_page', [
            'fr'=>'Activer la page de chaîne',
            'en'=>'Enable channel page'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('user_levels_permissions') . '  ADD COLUMN `enable_channel_page` ENUM(\'yes\',\'no\') NOT NULL DEFAULT \'yes\'',
            [
                'table'  => 'user_levels_permissions'
            ], [
                'table'  => 'user_levels_permissions',
                'column' => 'enable_channel_page'
            ]
        );
        self::alterTable('ALTER TABLE ' . tbl('user_profile') . '  ADD COLUMN `disabled_channel` ENUM(\'yes\',\'no\') NOT NULL DEFAULT \'no\'',
            [
                'table'  => 'user_profile'
            ], [
                'table'  => 'user_profile',
                'column' => 'disabled_channel'
            ]
        );

        self::generateTranslation('channel_settings', [
            'fr'=>'Paramètre de chaîne'
        ]);

        self::generateTranslation('disable_channel', [
            'fr'=>'Désactiver la chaîne',
            'en'=>'Disable channel'
        ]);
    }
}
