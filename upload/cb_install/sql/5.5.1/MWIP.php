<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
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
            'fr' => 'Si le fichier est plus lourd que PHP max upload size ou post max size, alors il sera découpé en plus petits morceaux pour l\'upload',
            'en' => 'If filesize is larger than PHP max upload size or post max size, then it will be chunked into smaller parts for upload'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'enable_chunk_upload\', \'yes\');';
        self::query($sql);
    }
}