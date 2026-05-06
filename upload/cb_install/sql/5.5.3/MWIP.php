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
            tmdb_id INT NOT NULL,
            tmdb_type VARCHAR(255) NOT NULL,
            tmdb_rate_average FLOAT NULL,
            tmdb_rate_count INT NULL
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
                switch ($video['tmdb_type']) {
                    case 'movie':
                        $details =  \Tmdb::getInstance()->movieDetail($video['id_tmdb'])['response'];
                        break;
                    case 'series':
                        $details =  \Tmdb::getInstance()->seriesDetail($video['id_tmdb'])['response'];
                        break;
                }
                $sql = 'INSERT INTO ' . tbl('video_tmdb') . ' (video_id, tmdb_type, tmdb_id, tmdb_rate_average, tmdb_rate_count) VALUES ( ' . (int)$video['videoid'] . ', \'' . $video['type_tmdb'] . '\', ' . (int)$video['id_tmdb'] . ', ' . (float)$details['vote_average'] . ', ' . (int)$details['vote_count'] . ' )
                    ON DUPLICATE KEY UPDATE tmdb_id = VALUES(tmdb_id), tmdb_type = VALUES(tmdb_type), tmdb_rate_average = VALUES(tmdb_rate_average), tmdb_rate_count = VALUES(tmdb_rate_count)';
                \Clipbucket_db::getInstance()->execute($sql);
            }
        } while (!empty($videos));
    }
}
