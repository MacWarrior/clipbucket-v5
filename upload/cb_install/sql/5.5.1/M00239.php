<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00239 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('no_vid_in_playlist', [
            'fr' => 'Aucune vidéo trouvée dans cette playlist !',
            'en' => 'No video found in this playlist!',
            'de' => 'Kein Video in dieser Wiedergabeliste gefunden!',
            'pt-BR' => 'Nenhum vídeo encontrado nesta lista de reprodução!'
        ]);
    }
}