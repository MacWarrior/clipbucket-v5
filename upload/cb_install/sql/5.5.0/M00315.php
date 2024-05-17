<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00315 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = ' INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'display_video_comments\', \'yes\'), (\'display_photo_comments\', \'yes\'), (\'display_channel_comments\', \'no\'), (\'enable_collection_comments\', \'yes\'), (\'display_collection_comments\', \'yes\');';
        self::query($sql);

        self::generateTranslation('option_display_video_comments', [
            'en' => 'Display video comments',
            'fr' => 'Afficher les commentaires vidéos'
        ]);

        self::generateTranslation('option_display_photo_comments', [
            'en' => 'Display photo comments',
            'fr' => 'Afficher les commentaires photos'
        ]);

        self::generateTranslation('option_display_channel_comments', [
            'en' => 'Display channel comments',
            'fr' => 'Afficher les commentaires de chaîne'
        ]);

        self::generateTranslation('comment_disabled_for', [
            'en'    => 'Comments are disabled for this %s',
            'fr'    => 'Les commentaires sont désactivés pour cette %s',
            'de'    => 'Kommentare deaktiviert für dieses %s',
            'pt-BR' => 'Comentários desativados para este vídeo %s'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` MODIFY type VARCHAR(16);', [
            'table' => 'comments',
            'column' => 'type'
        ]);

        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'comm_disabled_for_vid\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);

        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'comm_disabled_for_collection\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);

        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'comments_disabled_for_photo\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);

        self::generateTranslation('enable_collection_comments', [
            'en' => 'Enable collection comments',
            'fr' => 'Autoriser les commentaires pour les collections'
        ]);

        self::generateTranslation('display_collection_comments', [
            'en' => 'Display collection comments',
            'fr' => 'Afficher les commentaires de collection'
        ]);
    }
}