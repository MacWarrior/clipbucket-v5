<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00131 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::query('DROP TABLE ' . tbl('video_views'));

        self::query('CREATE TABLE ' . tbl('video_views') . '
            (
                `id_video_view` INT(11)   NOT NULL AUTO_INCREMENT,
                `id_video`      BIGINT   NOT NULL,
                `id_user`       BIGINT   NOT NULL,
                `view_date`     DATETIME NOT NULL,
                PRIMARY KEY (`id_video_view`)
            ) ENGINE = InnoDB
              DEFAULT CHARSET = utf8mb4
              COLLATE utf8mb4_unicode_520_ci;   
        ');

        self::alterTable(' ALTER TABLE `'.tbl('video_views').'`
            ADD CONSTRAINT `video_view_video` FOREIGN KEY (`id_video`) REFERENCES `'.tbl('video').'` (`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;
        ');
        self::alterTable('ALTER TABLE `'.tbl('video_views').'`
            ADD CONSTRAINT `video_view_user` FOREIGN KEY (`id_user`) REFERENCES `'.tbl('users').'` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;
        ');

        self::generateConfig('enable_video_view_history', 'no');

        self::generateTranslation('enable_video_view_history', [
            'fr'=>'Activer l\'historique de vue des vidéos',
            'en'=>'Enable video view history'
        ]);
    }
}
