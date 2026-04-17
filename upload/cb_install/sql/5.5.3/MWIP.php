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
        self::doAlterTable();
        $limit = 100;
        /** migrate videos */
        $offset = 0;
        do {
            $sql = 'SELECT videoid,userid, rating, rated_by,voter_ids FROM ' . tbl('video') . ' WHERE `voter_ids` != \'\' limit ' . $offset . ',  ' . $limit;
            $videos = \Clipbucket_db::getInstance()->_select($sql);
            foreach ($videos as $video) {
                $vote_infos = json_decode($video['voter_ids'], true);
                foreach ($vote_infos as $vote) {
                    self::query('INSERT IGNORE INTO `{tbl_prefix}video_votes`  (id_video, id_user, date_voted, value) VALUE ( ' . mysql_clean($video['videoid']) . ',  ' . mysql_clean($vote['userid']) . ',  \'' . mysql_clean($vote['time']) . '\', ' . (int)mysql_clean($vote['rating'] == 10) . ')');
                }
            }
            $offset += $limit;
        } while (!empty($videos));
        /** migrate photos */
        $offset = 0;
        do {
            $sql = 'SELECT photo_id,userid, rating, rated_by,voters FROM ' . tbl('photos') . ' WHERE `voters` != \'\' limit ' . $offset . ',  ' . $limit;
            $photos = \Clipbucket_db::getInstance()->_select($sql);
            foreach ($photos as $photo) {
                $vote_infos = json_decode($photo['voters'], true);
                foreach ($vote_infos as $vote) {
                    self::query('INSERT IGNORE INTO `{tbl_prefix}photo_votes`  (id_photo,  id_user, date_voted, value) VALUE ( ' . mysql_clean($photo['photo_id']) . ',  ' . mysql_clean($vote['userid']) . ',  \'' . mysql_clean($vote['time']) . '\',  ' . (int)mysql_clean($vote['rating'] == 10) . ')');
                }
            }
            $offset += $limit;
        } while (!empty($photos));
        /** migrate comment */
        $offset = 0;
        do {
            $sql = 'SELECT comment_id,userid,rating, rated_by,voters FROM ' . tbl('comments') . ' WHERE `voters` != \'\' limit ' . $offset . ',  ' . $limit;
            $comments = \Clipbucket_db::getInstance()->_select($sql);
            foreach ($comments as $comment) {
                $vote_infos = json_decode($comment['voters'], true);
                foreach ($vote_infos as $vote) {
                    self::query('INSERT IGNORE INTO `{tbl_prefix}comment_votes`  (id_comment,  id_user, date_voted, value) VALUE ( ' . mysql_clean($comment['comment_id']) . ',  ' . mysql_clean($vote['userid']) . ',  \'' . mysql_clean($vote['time']) . '\',  ' . (int)mysql_clean($vote['rating'] == 10) . ')');
                }
            }

            $offset += $limit;
        } while (!empty($comments));
        /** migrate channels */
        $offset = 0;
        do {
            $sql = 'SELECT user_profile_id, userid, rating, rated_by,voters FROM ' . tbl('user_profile') . ' WHERE `voters` != \'\' limit ' . $offset . ',  ' . $limit;
            $channels = \Clipbucket_db::getInstance()->_select($sql);
            foreach ($channels as $channel) {
                $vote_infos = json_decode($channel['voters'], true);
                foreach ($vote_infos as $vote) {
                    self::query('INSERT IGNORE INTO `{tbl_prefix}channel_votes`  (id_channel, id_user, date_voted, value) VALUE ( ' . mysql_clean($channel['user_profile_id']) . ',  ' . mysql_clean($vote['userid']) . ',  \'' . mysql_clean($vote['time']) . '\',  ' . (int)mysql_clean($vote['rating'] == 10) . ')');
                }
            }
            $offset += $limit;
        } while (!empty($channels));
        /** migrate collections */
        $offset = 0;
        do {
            $sql = 'SELECT collection_id, rating,rated_by,voters,userid FROM ' . tbl('collections') . ' WHERE `voters` != \'\' limit ' . $offset . ',  ' . $limit;
            $collections = \Clipbucket_db::getInstance()->_select($sql);
            foreach ($collections as $collection) {
                $vote_infos = json_decode($collection['voters'], true);
                foreach ($vote_infos as $vote) {
                    self::query('INSERT IGNORE INTO `{tbl_prefix}collection_votes`  (id_collection, id_user, date_voted, value) VALUE ( ' . mysql_clean($collection['collection_id']) . ', ' . mysql_clean($vote['userid']) . ', \'' . mysql_clean($vote['time']) . '\', ' . (int)mysql_clean($vote['rating'] == 10) . ')');
                }
            }
            $offset += $limit;
        } while (!empty($collections));


    }

    /**
     * @return void
     * @throws \Exception
     */
    private static function doAlterTable()
    {
        self::alterTable('CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_votes` (
            id_vote INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_video BIGINT(20) NOT NULL,
            id_user BIGINT(20) NOT NULL,
            date_voted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            value BOOL NOT NULL,
            UNIQUE KEY (id_video , id_user)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
        ', [], [
            'table' => 'video_votes'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_votes` ADD CONSTRAINT `votes_id_video_ibfk_1` FOREIGN KEY (id_video) REFERENCES `{tbl_prefix}video` (videoid) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'video_votes',
            'column' => 'id_video'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_video_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_votes` ADD CONSTRAINT `votes_id_user_ibfk_1` FOREIGN KEY (id_user) REFERENCES `{tbl_prefix}users` (userid) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table' => 'users'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_user_ibfk_1'
            ]
        ]);

        self::alterTable('CREATE TABLE IF NOT EXISTS `{tbl_prefix}photo_votes` (
            id_vote INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_photo BIGINT(255) NOT NULL,
            id_user BIGINT(20) NOT NULL,
            date_voted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            value BOOL NOT NULL,
            UNIQUE KEY (id_photo , id_user)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
        ', [], [
            'table' => 'photo_votes'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photo_votes` ADD CONSTRAINT `votes_id_photo_ibfk_1` FOREIGN KEY (id_photo) REFERENCES `{tbl_prefix}photos` (photo_id) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'photo_votes',
            'column' => 'id_photo'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_photo_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}photo_votes` ADD CONSTRAINT `votes_id_user_ibfk_2` FOREIGN KEY (id_user) REFERENCES `{tbl_prefix}users` (userid) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table' => 'users'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_user_ibfk_2'
            ]
        ]);

        self::alterTable('CREATE TABLE IF NOT EXISTS `{tbl_prefix}comment_votes` (
            id_vote INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_comment INT(60) NOT NULL,
            id_user BIGINT(20) NOT NULL,
            date_voted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            value BOOL NOT NULL,
            UNIQUE KEY (id_comment , id_user)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
        ', [], [
            'table' => 'comment_votes'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}comment_votes` ADD CONSTRAINT `votes_id_comment_ibfk_1` FOREIGN KEY (id_comment) REFERENCES `{tbl_prefix}comments` (comment_id) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'comment_votes',
            'column' => 'id_comment'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_comment_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}comment_votes` ADD CONSTRAINT `votes_id_user_ibfk_3` FOREIGN KEY (id_user) REFERENCES `{tbl_prefix}users` (userid) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table' => 'users'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_user_ibfk_3'
            ]
        ]);

        self::alterTable('CREATE TABLE IF NOT EXISTS `{tbl_prefix}channel_votes` (
            id_vote INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_channel BIGINT(20) NOT NULL,
            id_user BIGINT(20) NOT NULL,
            date_voted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            value BOOL NOT NULL,
            UNIQUE KEY (id_channel , id_user)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
        ', [], [
            'table' => 'channel_votes'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}channel_votes` ADD CONSTRAINT `votes_id_channel_ibfk_1` FOREIGN KEY (id_channel) REFERENCES `{tbl_prefix}users` (userid) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'channel_votes',
            'column' => 'id_channel'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_channel_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}channel_votes` ADD CONSTRAINT `votes_id_user_ibfk_4` FOREIGN KEY (id_user) REFERENCES `{tbl_prefix}users` (userid) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table' => 'users'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_user_ibfk_4'
            ]
        ]);

        self::alterTable('CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_votes` (
            id_vote INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_collection BIGINT(25) NOT NULL,
            id_user BIGINT(20) NOT NULL,
            date_voted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            value BOOL NOT NULL,
            UNIQUE KEY (id_collection , id_user)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
        ', [], [
            'table' => 'collection_votes'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_votes` ADD CONSTRAINT `votes_id_collection_ibfk_1` FOREIGN KEY (id_collection) REFERENCES `{tbl_prefix}collections` (collection_id) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'collection_votes',
            'column' => 'id_collection'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_collection_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collection_votes` ADD CONSTRAINT `votes_id_user_ibfk_5` FOREIGN KEY (id_user) REFERENCES `{tbl_prefix}users` (userid) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table' => 'users'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'votes_id_user_ibfk_5'
            ]
        ]);

        /*
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `rated_by`;', [
            'table'  => 'video',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `voter_ids`;', [
            'table'  => 'video',
            'column' => 'voter_ids'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `rating`;', [
            'table'  => 'video',
            'column' => 'rating'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP COLUMN `rated_by`;', [
            'table'  => 'user_profile',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP COLUMN `voters`;', [
            'table'  => 'user_profile',
            'column' => 'voter_ids'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP COLUMN `rating`;', [
            'table'  => 'user_profile',
            'column' => 'rating'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `rated_by`;', [
            'table'  => 'collections',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `voters`;', [
            'table'  => 'collections',
            'column' => 'voter_ids'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `rating`;', [
            'table'  => 'collections',
            'column' => 'rating'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP COLUMN `rated_by`;', [
            'table'  => 'photos',
            'column' => 'rated_by'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP COLUMN `voters`;', [
            'table'  => 'photos',
            'column' => 'voter_ids'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP COLUMN `rating`;', [
            'table'  => 'photos',
            'column' => 'rating'
        ]);
        */
    }
}
