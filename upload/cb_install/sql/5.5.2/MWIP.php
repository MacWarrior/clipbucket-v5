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
        $sql='CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_conversion_queue` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `videoid` bigint(20) NOT NULL,
            `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `date_started` datetime DEFAULT NULL,
            `date_ended` datetime DEFAULT NULL,
            `is_completed` boolean DEFAULT 0 NOT NULL, 
            INDEX(is_completed)
        )';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_conversion_queue` ADD CONSTRAINT `video_conversion_fk` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'video_conversion_queue',
            'column' => 'videoid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_conversion_fk'
            ]
        ]);

        self::insertTool('launch_video_conversion', 'AdminTool::launchVideoConversion', '* * * * *', true);

        self::generateTranslation('launch_video_conversion_label', [
            'fr'=>'Conversion de vidéo',
            'en'=>'Video Conversion'
        ]);

        self::generateTranslation('launch_video_conversion_description', [
            'fr'=>'Lance la conversion des vidéos dans la file d\'attente',
            'en'=>'Launch video conversion from queue'
        ]);

        self::generateTranslation('video_is_not_convertable', [
            'fr'=>'La vidéo avec l\'id : %s n\'est pas convertible',
            'en'=>'Video with id : %s is not convertable'
        ]);

        self::generateTranslation('video_is_already_processing', [
            'fr'=>'La vidéo avec l\'id : %s est déjà en cours de conversion',
            'en'=>'Video with id : %s is already processing'
        ]);

        self::generateTranslation('all_locks_deleted', [
            'fr'=>'Tous les fichiers de verrous ont été supprimés',
            'en'=>'All locks files have been deleted'
        ]);
        self::generateTranslation('delete_conversion_lock', [
            'fr'=>'Supprimer les verrous de conversion',
            'en'=>'Delete all conversion locks'
        ]);
        self::generateTranslation('no_lock_to_delete', [
            'fr'=>'Aucun verrou de conversion à supprimer',
            'en'=>'No conversion lock to delete'
        ]);

        $sql='DROP TABLE IF EXISTS `{tbl_prefix}conversion_queue`;';
        self::query($sql);
    }

}
