<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00041 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_enable_chunk_upload', [
            'fr' => 'Activer le téléchargement morcelé',
            'en' => 'Enable chunked upload'
        ]);

        self::generateTranslation('tips_enable_chunk_upload', [
            'fr' => 'Lors de l\'upload, le fichier sera découpé en plus petits morceaux',
            'en' => 'During upload, file will be chunked into smaller parts'
        ]);

        self::generateTranslation('mb', [
            'fr' => 'Mo',
            'en' => 'Mb'
        ]);

        self::generateTranslation('in_x', [
            'fr' => 'En %s',
            'en' => 'In %s'
        ]);

        self::generateTranslation('cloudflare_upload_limit', [
            'fr' => 'Limite d\'upload Cloudflare',
            'en' => 'Cloudflare upload limit'
        ]);

        self::generateTranslation('option_nginx_path', [
            'fr' => 'Chemin Nginx',
            'en' => 'Nginx path'
        ]);

        self::generateConfig('enable_chunk_upload', 'yes');
        self::generateConfig('chunk_upload_size', '2');
        self::generateConfig('cloudflare_upload_limit', '100');
        self::generateConfig('nginx_path', '');
    }
}