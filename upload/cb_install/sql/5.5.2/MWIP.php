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

        self::generateTranslation('anonymous_stats', [
            'fr' => 'Envoyer des statistiques d\'utilisation anonymes',
            'en' => 'Send anonymous usage statistics'
        ]);

        self::generateTranslation('anonymous_stats_hint', [
            'fr' => 'Avec votre autorisation, enverra régulièrement des statistiques anonymes, telles que la version de PHP utilisée, le nombre d\'éléments gérés et les configurations, à Oxygenz afin de nous aider à améliorer nos services. Aucune information personnelle, y compris les détails liés à vos comptes utilisateurs, ne sera transmise.',
            'en' => 'With your permission, anonymous statistics, such as the PHP version used, the number of items managed, and configuration details, will be sent periodically to Oxygenz to help us improve our services. No personal information, including user account details, will be shared.'
        ]);

        self::generateTranslation('unknown_task', [
            'fr' => 'Tâche inconnue',
            'en' => 'Unknown task'
        ]);

        self::generateTranslation('anonymous_stats_label', [
            'fr' => 'Statistiques d\'utilisation anonymes',
            'en' => 'Anonymous usage statistics'
        ]);

        self::generateTranslation('anonymous_stats_description', [
            'fr' => 'Récupère et envoi des statistiques d\'utilisation anonymes',
            'en' => 'Retrieves and sends anonymous usage statistics'
        ]);

        $sql = ' INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `code`, `frequency`, `previous_calculated_datetime`, `is_automatable`, `is_disabled`) VALUE
                 (\'anonymous_stats_label\', \'anonymous_stats_description\', \'AdminTool::anonymousStats\', \'anonymous_stats\', \'* * * * 1\', CURRENT_TIMESTAMP, \'1\', \'1\');';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}config` ADD COLUMN `allow_stat` BOOL DEFAULT TRUE',
            [
                'table' => 'config'
            ], [
                'table'  => 'config',
                'column' => 'allow_stat',
            ]
        );

        $sql = 'UPDATE `' . tbl('config') . '` SET allow_stat = FALSE WHERE name IN 
        (\'base_url\'
        , \'tmdb_token\'
        , \'smtp_host\'
        , \'smtp_user\'
        , \'smtp_pass\'
        , \'smtp_port\'
        , \'proxy_url\'
        , \'proxy_port\'
        , \'proxy_username\'
        , \'proxy_password\'
        , \'cache_host\'
        , \'cache_password\'
        , \'cache_port\')
        ;';
        self::query($sql);
    }

}
