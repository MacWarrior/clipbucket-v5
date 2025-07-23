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
            'fr'=>'Envoyer des statistiques d\'utilisation anonymes',
            'en'=>'Send anonymous usage statistics'
        ]);

        self::generateTranslation('anonymous_stats_hint', [
            'fr'=>'Avec votre autorisation, enverra régulièrement des statistiques anonymes, telles que la version de PHP utilisée, le nombre d\'éléments gérés et les configurations, à Oxygenz afin de nous aider à améliorer nos services. Aucune information personnelle, y compris les détails liés à vos comptes utilisateurs, ne sera transmise.',
            'en'=>'With your permission, anonymous statistics, such as the PHP version used, the number of items managed, and configuration details, will be sent periodically to Oxygenz to help us improve our services. No personal information, including user account details, will be shared.'
        ]);

        self::generateTranslation('unknown_task', [
            'fr'=>'Tâche inconnue',
            'en'=>'Unknown task'
        ]);
    }

}
