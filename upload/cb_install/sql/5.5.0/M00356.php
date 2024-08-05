<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00356 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_git_path', [
            'en' => 'Git path',
            'fr' => 'Chemin PHP'
        ]);
        self::generateTranslation('core_upgrade_avaible', [
            'en' => 'Core upgrade available, click here to update : ',
            'fr' => 'Une mise à jour est disponible, cliquez ici pour mettre à jour : '
        ]);
        self::generateTranslation('core_upgrade_avaible', [
            'en' => 'Core upgrade available, click here to update : ',
            'fr' => 'Une mise à jour est disponible, cliquez ici pour mettre à jour : '
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'git_path\', \'\');';
        self::query($sql);

        self::generateTranslation('update_core_label', [
            'en' => 'Core update',
            'fr' => 'Mise à jour du coeur'
        ]);

        self::generateTranslation('update_core_description', [
            'en' => 'Use GIT to revert all core changes and update to latest revision',
            'fr' => 'Utilise GIT pour annuler tous les changements et mettre à jour à la dernière revision'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`id_tool`, `language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (11, \'update_core_label\', \'update_core_description\', \'AdminTool::updateCore\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('core_up_to_date', [
            'en' => 'Your core is up to date',
            'fr' => 'Votre coeur est à jour'
        ]);
    }
}