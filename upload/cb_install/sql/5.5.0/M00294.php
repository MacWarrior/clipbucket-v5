<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00294 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE `name` = \'embed_type\';';
        self::query($sql);

        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'embed_type\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);

        self::generateTranslation('video_not_available', [
            'en' => 'This video is not available',
            'fr' => 'Cette vidéo n\'est pas disponible'
        ]);

        self::generateTranslation('option_enable_video_social_sharing', [
            'en' => 'Enable social sharing',
            'fr' => 'Activer le partage sur les réseaux'
        ]);

        self::generateTranslation('option_enable_video_internal_sharing', [
            'Enable internal sharing',
            'fr' => 'Activer le partage interne'
        ]);

        self::generateTranslation('option_enable_video_link_sharing', [
            'en' => 'Enable link sharing',
            'fr' => 'Activer le partage de lien'
        ]);

        self::generateTranslation('download', [
            'en' => 'Download',
            'fr' => 'Télécharger'
        ]);

        self::generateTranslation('unlisted', [
            'en' => 'Unlisted',
            'fr' => 'Non répertoriée'
        ]);

        self::generateTranslation('of', [
            'en'    => 'of',
            'fr'    => 'de',
            'de'    => 'von',
            'pt-BR' => 'de'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'enable_video_social_sharing\', \'yes\'), (\'enable_video_internal_sharing\', \'yes\'), (\'enable_video_link_sharing\', \'yes\');';
        self::query($sql);
    }
}