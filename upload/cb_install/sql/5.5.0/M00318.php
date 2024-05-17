<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00318 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('discord_error_log', [
            'en' => 'Enable Discord error log',
            'fr' => 'Activer les logs d\'erreur Discord'
        ]);

        self::generateTranslation('discord_webhook_url', [
            'en' => 'Discord webhook URL',
            'fr' => 'URL du webhook Discord'
        ]);
        self::generateTranslation('discord_webhook_url_invalid', [
            'en' => 'Discord webhook URL is invalid',
            'fr' => 'L\'URL du webhook Discord n\'est pas valide'
        ]);
    }
}