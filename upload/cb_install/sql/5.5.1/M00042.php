<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00042 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('available', [
            'fr' => 'Disponible',
            'en' => 'Available'
        ]);

        self::generateTranslation('unavailable', [
            'fr' => 'Indisponible',
            'en' => 'Unavailable'
        ]);

        self::generateTranslation('sse_error_features_disabled', [
            'fr' => 'Des fonctionnalités tels que l\'actualisation automatique et les tâches de fond seront désactivées.',
            'en' => 'Some features like auto-refresh and background tasks will be disabled.'
        ]);

        self::generateTranslation('sse_error_please_use_php_fpm', [
            'fr' => 'Veuillez utiliser PHP-FPM pour une expérience optimale de ClipBucketV5.',
            'en' => 'Please use PHP-FPM for the best ClipBucketV5 experience.'
        ]);

    }
}