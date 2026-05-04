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
            rate_average_tmdb FLOAT NULL,
            rate_count_tmdb INT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;', [], [
            'table' => 'video_tmdb'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_tmdb` ADD CONSTRAINT `tmdb_video_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE NO ACTION ON UPDATE NO ACTION ;', [
            'table'  => 'video_tmdb',
            'column' => 'video_id'
        ], [
                'constraint' => [
                    'type' => 'FOREIGN KEY',
                    'name' => 'tmdb_video_ibfk_1'
                ]
            ]
        );

        $limit = 100;
        $offset = 0;
        do {
            $videos = \Video::getInstance()->getAll([
                'limit'     => $offset . ' , ' . $limit,
                'condition' => 'id_tmdb IS NOT NULL'
            ]);
            $offset += $limit;
            foreach ($videos as $video) {
                //get rating
                switch ($video['type_tmdb']) {
                    case 'movie':
                        $details =  \Tmdb::getInstance()->movieDetail($video['id_tmdb'])['response'];
                        break;
                    case 'series':
                        $details =  \Tmdb::getInstance()->seriesDetail($video['id_tmdb'])['response'];
                        break;
                }
                $sql = 'INSERT INTO ' . tbl('video_tmdb') . ' (video_id, type_tmdb, id_tmdb, rate_average_tmdb, rate_count_tmdb) VALUES ( ' . (int)$video['videoid'] . ', \'' . $video['type_tmdb'] . '\', ' . (int)$video['id_tmdb'] . ', ' . (float)$details['vote_average'] . ', ' . (int)$details['vote_count'] . ' )
                    ON DUPLICATE KEY UPDATE id_tmdb = VALUES(id_tmdb), type_tmdb = VALUES(type_tmdb), rate_average_tmdb = VALUES(rate_average_tmdb), rate_count_tmdb = VALUES(rate_count_tmdb)';
                \Clipbucket_db::getInstance()->execute($sql);
            }
        } while (!empty($videos));
    }
}
