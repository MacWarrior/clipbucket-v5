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
        self::query('CREATE TABLE IF NOT EXISTS `{tbl_prefix}ratings` 
        (
            id_rating INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            object_id INT NOT NULL,
            id_object_type INT NOT NULL,
            userid BIGINT(20) NOT NULL,
            date_added DATETIME NOT NULL,
            vote BOOLEAN NOT NULL,
            UNIQUE KEY `unique_rating_per_vote` (`object_id`,`id_object_type`,`userid`), INDEX(object_id)
        )');

        self::alterTable('ALTER TABLE `{tbl_prefix}ratings` ADD FOREIGN KEY fk_rating_user(userid) REFERENCES `{tbl_prefix}users`(`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'ratings',
            'column' => 'userid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_rating_user',
            ]
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}ratings` ADD FOREIGN KEY fk_rating_object_type(id_object_type) REFERENCES `{tbl_prefix}object_type`(`id_object_type`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'ratings',
            'column' => 'id_object_type'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_rating_object_type',
            ]
        ]);

        $videos_rated = self::req('SELECT * FROM `{tbl_prefix}video` WHERE rated_by > 0 ');
        $id_type_video = \Video::getTypeId();
        foreach ($videos_rated as $video) {
            $vote_infos = json_decode($video['voter_ids'], true);
            foreach ($vote_infos as $vote) {
                self::query('INSERT IGNORE INTO `{tbl_prefix}ratings` SET object_id = ' . mysql_clean($video['videoid']) . ', id_object_type = ' . mysql_clean($id_type_video) . ', userid = ' . mysql_clean($vote['userid']) . ', date_added = \'' . mysql_clean($vote['time']) . '\', vote = ' . mysql_clean($vote['rating'] == 10));
            }
        }
/**
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
        ]);**/

        $id_type_photo = \Photo::getTypeId();
        $photos_rated = self::req('SELECT * FROM `{tbl_prefix}photos` WHERE rated_by > 0 ');
        foreach ($photos_rated as $photo) {
            $vote_infos = json_decode($photo['voters'], true);
            foreach ($vote_infos as $vote) {
                self::query('INSERT IGNORE INTO `{tbl_prefix}ratings` SET object_id = ' . mysql_clean($photo['photo_id']) . ', id_object_type = ' . mysql_clean($id_type_photo) . ', userid = ' . mysql_clean($vote['userid']) . ', date_added = \'' . mysql_clean($vote['time']) . '\', vote = ' . mysql_clean($vote['rating'] == 10));
            }
        }

        /**
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
        ]);**/


        $id_type_collection = \Collection::getTypeId();
        $collections_rated = self::req('SELECT * FROM `{tbl_prefix}collections` WHERE rated_by > 0 ');
        foreach ($collections_rated as $collection) {
            $vote_infos = json_decode($collection['voters'], true);
            foreach ($vote_infos as $vote) {
                self::query('INSERT IGNORE INTO `{tbl_prefix}ratings` SET object_id = ' . mysql_clean($collection['collection_id']) . ', id_object_type = ' . mysql_clean($id_type_collection) . ', userid = ' . mysql_clean($vote['userid']) . ', date_added = \'' . mysql_clean($vote['time']) . '\', vote = ' . mysql_clean($vote['rating'] == 10));
            }
        }

        /**
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
        ]);**/

        $id_type_user = \User::getTypeId();
        $channels_rated = self::req('SELECT * FROM `{tbl_prefix}user_profile` WHERE rated_by > 0 ');
        foreach ($channels_rated as $channel) {
            $vote_infos = json_decode($channel['voters'], true);
            foreach ($vote_infos as $vote) {
                self::query('INSERT IGNORE INTO `{tbl_prefix}ratings` SET object_id = ' . mysql_clean($channel['userid']) . ', id_object_type = ' . mysql_clean($id_type_user) . ', userid = ' . mysql_clean($vote['userid']) . ', date_added = \'' . mysql_clean($vote['time']) . '\', vote = ' . mysql_clean($vote['rating'] == 10));
            }
        }

        /**
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
        ]);**/


    }
}
