<?php
namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00101 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}action_log` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;', [
            'table'  => 'action_log',
            'column' => 'date_added'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}ads_data`
            MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\',
            MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'   => 'ads_data',
            'columns' => [
                'last_viewed',
                'date_added'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collection_categories`
            MODIFY COLUMN `category_desc` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'   => 'collection_categories',
            'columns' => [
                'category_desc',
                'date_added'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}comments` MODIFY COLUMN `voters` TEXT NULL DEFAULT NULL, MODIFY COLUMN `spam_voters` TEXT NULL DEFAULT NULL;', [
            'table'   => 'comments',
            'columns' => [
                'voters',
                'spam_voters'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}conversion_queue` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;', [
            'table'  => 'conversion_queue',
            'column' => 'date_added'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}group_categories` MODIFY COLUMN `date_added` DATETIME NOT NULL;', [
            'table'  => 'group_categories',
            'column' => 'date_added'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}group_invitations` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'  => 'group_invitations',
            'column' => 'date_added'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}group_members` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'  => 'group_members',
            'column' => 'date_added'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}group_videos` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'  => 'group_videos',
            'column' => 'date_added'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}messages` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'  => 'messages',
            'column' => 'date_added'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos`
            MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\' ON UPDATE CURRENT_TIMESTAMP,
            MODIFY COLUMN `server_url` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `photo_details` TEXT NULL DEFAULT NULL;', [
            'table'   => 'photos',
            'columns' => [
                'last_viewed',
                'server_url',
                'photo_details'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}playlists`
            MODIFY COLUMN `voters` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `last_update` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `first_item` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `cover` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;', [
            'table'   => 'playlists',
            'columns' => [
                'voters',
                'last_update',
                'first_item',
                'cover',
                'date_added'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}playlist_items` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;', [
            'table'  => 'playlist_items',
            'column' => 'date_added'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}subscriptions` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'  => 'subscriptions',
            'column' => 'date_added'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users`
            MODIFY COLUMN `avatar_url` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `dob` DATE NOT NULL DEFAULT \'1000-01-01\',
            MODIFY COLUMN `doj` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            MODIFY COLUMN `last_logged` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\',
            MODIFY COLUMN `last_active` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\';', [
            'table'   => 'users',
            'columns' => [
                'avatar_url',
                'dob',
                'doj',
                'last_logged',
                'last_active'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_categories`
            MODIFY COLUMN `date_added` DATETIME NOT NULL;', [
            'table'  => 'user_categories',
            'column' => 'date_added'
        ]);

        self::alterTable('
        ALTER TABLE `{tbl_prefix}video`
            MODIFY COLUMN `username` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `category_parents` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `blocked_countries` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\' ON UPDATE CURRENT_TIMESTAMP,
            MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            MODIFY COLUMN `embed_code` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `refer_url` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `remote_play_url` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `video_files` TINYTEXT NULL DEFAULT NULL,
            MODIFY COLUMN `file_server_path` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `files_thumbs_path` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `video_version` VARCHAR(30) NOT NULL DEFAULT \'5.4.1\',
            MODIFY COLUMN `thumbs_version` VARCHAR(5) NOT NULL DEFAULT \'5.4.1\',
            MODIFY COLUMN `re_conv_status` TINYTEXT NULL DEFAULT NULL,
            MODIFY COLUMN `conv_progress` TEXT NULL DEFAULT NULL;', [
            'table'   => 'video',
            'columns' => [
                'username',
                'category_parents',
                'blocked_countries',
                'last_viewed',
                'date_added',
                'embed_code',
                'refer_url',
                'remote_play_url',
                'video_files',
                'file_server_path',
                'files_thumbs_path',
                'video_version',
                'thumbs_version',
                're_conv_status',
                'conv_progress'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_categories`
            MODIFY COLUMN `category_desc` TEXT NULL DEFAULT NULL,
            MODIFY COLUMN `date_added` DATETIME NULL DEFAULT NULL;', [
            'table'   => 'video_categories',
            'columns' => [
                'category_desc',
                'date_added'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_favourites` MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'  => 'video_favourites',
            'column' => 'date_added'
        ]);
    }
}