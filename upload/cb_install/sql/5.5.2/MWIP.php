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
        self::generateTranslation('embed_player_disabled', [
            'fr'=>'L\'intégration de vidéos est désactivée.',
            'en'=>'Video embedding is disabled.'
        ]);

        self::generateTranslation('restrict_content_login', [
            'fr'=>'Contenu restreint, vous devez être connecté pour visionner.',
            'en'=>'Restricted content, you must be logged in to watch.'
        ]);
    }
}
