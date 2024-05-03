<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00170 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('system_info', [
            'en' => 'System Info',
            'fr' => 'Information système'
        ]);

        self::generateTranslation('hosting', [
            'en' => 'Hosting',
            'fr' => 'Hébergement'
        ]);

        self::generateTranslation('info_ffmpeg', [
            'en' => 'is used to covert videos from different versions to FLV , MP4 and many other formats.',
            'fr' => 'est utilisé pour convertir des vidéos aux formats FLV, MP4 et de nombreux autres formats.'
        ]);

        self::generateTranslation('tool_box', [
            'en' => 'Tool Box',
            'fr' => 'Boîte à Outils'
        ]);

        self::generateTranslation('info_php_cli', [
            'en' => 'is used to perform video conversion in a background process.',
            'fr' => 'est utilisé pour lancer la conversion vidéo en arrière plan'
        ]);

        self::generateTranslation('info_media_info', [
            'en' => 'supplies technical and tag information about a video or audio file.',
            'fr' => 'fournit des informations techniques sur un fichier vidéo ou audio'
        ]);

        self::generateTranslation('info_ffprobe', [
            'en' => 'is an Extension of FFMPEG used to get info of media file',
            'fr' => 'est une extension de FFMPEG utilsié pour récupérer des informations pour les fichiers multimédias'
        ]);

        self::generateTranslation('info_php_web', [
            'en' => 'is used to display this page',
            'fr' => 'est utilisé pour afficher cette page'
        ]);

        self::generateTranslation('must_be_least', [
            'en' => 'must be at least',
            'fr' => 'doit être au moins'
        ]);

        self::generateTranslation('php_cli_not_found', [
            'en' => 'PHP CLI is not correctly configured',
            'fr' => 'PHP CLI n\'est pas correctement configuré'
        ]);
    }
}