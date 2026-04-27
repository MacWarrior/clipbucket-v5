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
        self::alterTable('CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_tmdb` (
            video_id BIGINT(20) NOT NULL PRIMARY KEY,
            id_tmdb INT NOT NULL,
            type_tmdb VARCHAR(255) NOT NULL,
            rate_tmdb INT NULL
        )', [], [
            'table' => 'video_tmdb'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_tmdb` ADD FOREIGN KEY `tmdb_video_ibfk_1` (`video_id`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE NO ACTION ON UPDATE NO ACTION ;',
            [
                'table'  => 'video_tmdb',
                'column' => 'video_id'
            ], [
                'constraint' => [
                    'type' => 'FOREIGN KEY',
                    'name' => 'tmdb_video_ibfk_1'
                ]
            ]
        );


    }
}
