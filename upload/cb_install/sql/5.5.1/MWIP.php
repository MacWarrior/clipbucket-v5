<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{

    CONST MIN_VERSION_CODE = '5.5.2';
    CONST MIN_REVISION_CODE = '5000000';

    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('automate_launch_mode', 'user_activity');

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `frequency` varchar(30)', [
            'table' => 'tools'
        ], [
            'table' => 'tools',
            'column' => 'frequency'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `previous_calculated_datetime` datetime', [
            'table' => 'tools'
        ], [
            'table' => 'tools',
            'column' => 'previous_calculated_datetime'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `is_automatable` BOOL DEFAULT TRUE', [
            'table' => 'tools'
        ], [
            'table' => 'tools',
            'column' => 'is_automatable'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD COLUMN `is_disabled` BOOL DEFAULT FALSE', [
            'table' => 'tools'
        ], [
            'table' => 'tools',
            'column' => 'is_disabled'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}tools` ADD CONSTRAINT `chk_frequency_previous_calculated_datetime_required` 
                CHECK (
                    frequency IS NULL OR TRIM(frequency) = \'\' OR previous_calculated_datetime IS NOT NULL
                );', [
            'table'         => 'tools',
            'columns'         => ['frequency', 'previous_calculated_datetime']
        ],[
            'constraint_name' => 'chk_frequency_previous_calculated_datetime_required',
        ]);

        $sql = /** @lang MySQL */'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `code`, `frequency`, `previous_calculated_datetime`, `is_automatable`, `is_disabled`) 
                VALUES (\'automate_label\', \'automate_description\', \'AdminTool::checkAndStartToolsByFrequency\', \'automate\', NULL, NULL, 0, 0)';
        self::query($sql);

        self::generateTranslation('tool_not_found', [
            'fr'=>'L\'outil est introuvable',
            'en'=>'Tool not found'
        ]);
        self::generateTranslation('tips_automate_launch_mode', [
            'fr'=>'Avec l\'activité des utilisateurs, les automates sont lancés en tâche de fond au chargement des pages',
            'en'=>'With user activity, automates are launched in backgound at page loading'
        ]);
        self::generateTranslation('option_automate_launch_mode', [
            'fr'=>'Lancement des automates',
            'en'=>'Automate launching'
        ]);
        self::generateTranslation('option_automate_launch_mode_crontab', [
            'fr'=>'Crontab',
            'en'=>'Crontab'
        ]);
        self::generateTranslation('option_automate_launch_mode_user_activity', [
            'fr'=>'Activité des utilisateurs',
            'en'=>'Users activity'
        ]);
        self::generateTranslation('option_automate_launch_mode_disabled', [
            'fr'=>'Désactivé',
            'en'=>'Disabled'
        ]);
        self::generateTranslation('frequence', [
            'fr'=>'Fréquence',
            'en'=>'Frequency'
        ]);
        self::generateTranslation('frequence_enabled', [
            'fr'=>'Lancement automatique',
            'en'=>'Automatic launch'
        ]);
        self::generateTranslation('cron_format_title', [
            'fr'=>'Format crontab : * * * * * ',
            'en'=>'Crontab format : * * * * * '
        ]);
        self::generateTranslation('bad_format_cron', [
            'fr'=>'La fréquence doit être un format CRON valide',
            'en'=>'Frequency must be a valid CRON format'
        ]);
        self::generateTranslation('tool_already_launched', [
            'fr'=>'Cet outils est déjà en cours',
            'en'=>'This tool is already in progress'
        ]);
        self::generateTranslation('success_update_tools', [
            'fr'=>'L\'outil a bien était mis à jour',
            'en'=>'Tool has been updated'
        ]);
        self::generateTranslation('automate_label', [
            'fr'=>'Lancement automatique des outils',
            'en'=>'Automatic launch of tools'
        ]);
        self::generateTranslation('automate_description', [
            'fr'=>'Lance automatiquement les outils en fonction de leur fréquence',
            'en'=>'Automatically launches tools based on their frequency'
        ]);
        self::generateTranslation('datetime_synchro_error', [
            'fr'=>'Il existe un écart entre la date issue de PHP et la date issue de la base de donnée',
            'en'=>'There is a discrepancy between PHP and database dates'
        ]);
        self::generateTranslation('automate_laucn_disabled_in_config', [
            'fr'=>'Le lancement automatique des outils est désactivé',
            'en'=>'Automatic launch of tools is disabled'
        ]);
    }
}