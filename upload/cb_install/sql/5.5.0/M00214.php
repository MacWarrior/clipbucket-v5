<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00214 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `remote_play_url`;', [
            'table' => 'video',
            'column' => 'remote_play_url'
        ]);

        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` IN( SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` IN( \'link_video_msg\', \'remote_play\' ) );';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`
        WHERE `language_key` IN(
                \'link_video_msg\',
                \'remote_play\'
        );';
        self::query($sql);

        self::generateTranslation('video_upload_disabled', [
            'en' => 'Video Upload is disabled',
            'fr' => 'L\'envoi de vidéo est désactivé'
        ]);
    }
}