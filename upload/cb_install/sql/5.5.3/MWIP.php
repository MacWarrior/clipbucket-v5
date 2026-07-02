<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_audio_tracks` (
            `videoid` BIGINT(20) NOT NULL,
            `track_number` TINYINT NULL,
            `title` VARCHAR(64) NOT NULL,
            `order` TINYINT NOT NULL,
            PRIMARY KEY (`videoid`, `track_number`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_audio_tracks` ADD CONSTRAINT `video_audio_tracks_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE NO ACTION;', [
            'table'  => 'video_audio_tracks',
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_audio_tracks_ibfk_1'
            ]
        ]);


        self::generateTranslation('video_audio_track_list_management', [
            'fr'=>'Pistes audios',
            'en'=>'Audio tracks'
        ]);
    }
}
