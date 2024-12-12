<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00215 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('tmdb_token_check', [
            'en' => 'Check TMDB token',
            'fr' => 'Vérifier le token TMDB'
        ]);

        self::generateTranslation('tool_ended', [
            'en' => 'Tool ended',
            'fr' => 'Outil terminé'
        ]);

        self::generateTranslation('not_found', [
            'en' => 'Not found',
            'fr' => 'Introuvable'
        ]);
    }
}