<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('basic_settings', [
            'fr' => 'Configurations simples',
            'en' => 'Basic settings'
        ]);

        self::generateTranslation('advanced_settings', [
            'fr' => 'Configurations avancées',
            'en' => 'Advanced settings'
        ]);

        $sql = 'SELECT permission_value, user_level_id FROM ' . tbl('user_levels_permissions_values') . ' WHERE id_user_levels_permission = (SELECT id_user_levels_permission FROM ' . tbl('user_levels_permissions') . ' WHERE permission_name = \'web_config_access\')';
        $results = self::req($sql);

        self::generatePermission(3, 'advanced_settings', 'advanced_settings_desc', array_combine(array_column($results,'user_level_id'), array_column($results,'permission_value')));

        $sql = 'UPDATE ' . tbl('user_levels_permissions') . ' SET permission_name = \'basic_settings\', permission_description = \'basic_settings_desc\' WHERE permission_name = \'web_config_access\'';
        self::query($sql);

        self::deleteTranslation('web_config_access');
        self::deleteTranslation('web_config_access_desc');

        self::generateTranslation('basic_settings_desc', [
            'fr' => 'Permet de modifier les configurations simples du site',
            'en' => 'User can change website basic settings'
        ]);

        self::generateTranslation('advanced_settings_desc', [
            'fr' => 'Permet de modifier les configurations avancées',
            'en' => 'User can change website advanced settings'
        ]);

    }
}
