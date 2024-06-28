<?php
namespace V5_3_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00001 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('logo_name', '');
        self::generateConfig('favicon_name', '');
        self::generateConfig('comment_per_page', '10');
        self::generateConfig('stay_mp4', 'no');
        self::generateConfig('allow_conversion_1_percent', 'no');
        self::generateConfig('force_8bits', '1');
        self::generateConfig('bits_color_warning', '1');
        self::generateConfig('control_bar_logo', 'yes');
        self::generateConfig('contextual_menu_disabled', '');
        self::generateConfig('control_bar_logo_url', '/images/icons/player-logo.png');
        self::generateConfig('player_thumbnails', 'yes');

        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels_permissions` MODIFY COLUMN `plugins_perms` TEXT NULL DEFAULT NULL;', [
            'table'  =>'user_levels_permissions',
            'column' => 'plugins_perms'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users`
                MODIFY COLUMN `featured_video` MEDIUMTEXT NOT NULL,
                MODIFY COLUMN `avatar_url` TEXT NULL DEFAULT NULL,
                MODIFY COLUMN `featured_date` DATETIME NULL DEFAULT NULL,
                MODIFY COLUMN `total_videos` BIGINT(20) NOT NULL DEFAULT \'0\',
                MODIFY COLUMN `total_comments` BIGINT(20) NOT NULL DEFAULT \'0\',
                MODIFY COLUMN `total_photos` BIGINT(255) NOT NULL DEFAULT \'0\',
                MODIFY COLUMN `total_collections` BIGINT(255) NOT NULL DEFAULT \'0\',
                MODIFY COLUMN `comments_count` BIGINT(20) NOT NULL DEFAULT \'0\',
                MODIFY COLUMN `last_commented` DATETIME NULL DEFAULT NULL,
                MODIFY COLUMN `total_subscriptions` BIGINT(255) NOT NULL DEFAULT \'0\',
                MODIFY COLUMN `background` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                MODIFY COLUMN `background_color` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                MODIFY COLUMN `background_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                MODIFY COLUMN `total_groups` BIGINT(20) NOT NULL DEFAULT \'0\',
                MODIFY COLUMN `banned_users` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
                MODIFY COLUMN `total_downloads` BIGINT(255) NOT NULL DEFAULT \'0\';', [
            'table' =>'users',
            'columns'    => [
                'featured_video',
                'avatar_url',
                'featured_date',
                'total_videos',
                'total_comments',
                'total_photos',
                'total_collections',
                'comments_count',
                'last_commented',
                'total_subscriptions',
                'background',
                'background_color',
                'background_url',
                'total_groups',
                'banned_users',
                'total_downloads'
            ]
        ]);

        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name = \'i_magick\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video`
            MODIFY COLUMN `username` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `category_parents` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `blocked_countries` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `voter_ids` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            MODIFY COLUMN `last_commented` DATETIME NULL DEFAULT NULL,
            MODIFY COLUMN `featured_date` DATETIME NULL DEFAULT NULL,
            MODIFY COLUMN `featured_description` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `aspect_ratio` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `embed_code` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `refer_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `downloads` BIGINT(255) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `unique_embed_code` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `remote_play_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `video_files` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `server_ip` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `file_server_path` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `files_thumbs_path` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `file_thumbs_count` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `filegrp_size` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `extras` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `re_conv_status` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `conv_progress` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;', [
            'table' => 'video',
            'columns' => [
                'username',
                'category_parents',
                'blocked_countries',
                'voter_ids',
                'last_commented',
                'featured_date',
                'featured_description',
                'aspect_ratio',
                'embed_code',
                'refer_url',
                'downloads',
                'unique_embed_code',
                'remote_play_url',
                'video_files',
                'server_ip',
                'file_server_path',
                'files_thumbs_path',
                'file_thumbs_count',
                'filegrp_size',
                'extras',
                're_conv_status',
                'conv_progress'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD `is_castable` BOOLEAN NOT NULL DEFAULT FALSE, ADD `bits_color` TINYINT(4) DEFAULT NULL;', [
            'table' => 'video'
        ], [
            'table' => 'video',
            'columns' => ['is_castable', 'bits_color']
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile`
            MODIFY COLUMN `fb_url` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT \'\',
            MODIFY COLUMN `twitter_url` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT \'\',
            MODIFY COLUMN `profile_title` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `profile_desc` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `featured_video` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `about_me` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `schools` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `occupation` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `companies` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `hobbies` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `fav_movies` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `fav_music` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `fav_books` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `background` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `profile_video` INT(255) NULL DEFAULT NULL,
            MODIFY COLUMN `profile_item` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT \'\',
            MODIFY COLUMN `rating` TINYINT(2) NULL DEFAULT NULL,
            MODIFY COLUMN `voters` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `rated_by` INT(150) NULL DEFAULT NULL,
            MODIFY COLUMN `insta_url` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT \'\';', [
            'table' => 'user_profile',
            'columns' => [
                'fb_url',
                'twitter_url',
                'profile_title',
                'profile_desc',
                'featured_video',
                'about_me',
                'schools',
                'occupation',
                'companies',
                'hobbies',
                'fav_movies',
                'fav_music',
                'fav_books',
                'background',
                'profile_video',
                'profile_item',
                'rating',
                'voters',
                'rated_by',
                'insta_url'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}photos`
            MODIFY COLUMN `views` BIGINT(255) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `total_comments` INT(255) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `last_commented` DATETIME NULL DEFAULT NULL,
            MODIFY COLUMN `total_favorites` INT(255) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `rating` INT(15) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `rated_by` INT(25) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `voters` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `downloaded` BIGINT(255) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `server_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `photo_details` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;', [
            'table' => 'photos',
            'columns' => [
                'views',
                'total_comments',
                'last_commented',
                'total_favorites',
                'rating',
                'rated_by',
                'voters',
                'downloaded',
                'server_url',
                'photo_details'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections`
            MODIFY COLUMN `views` BIGINT(20) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `total_comments` BIGINT(20) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `last_commented` DATETIME NULL,
            MODIFY COLUMN `total_objects` BIGINT(20) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `rating` BIGINT(20) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `rated_by` BIGINT(20) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `voters` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;', [
            'table' => 'collections',
            'columns' => [
                'views',
                'total_comments',
                'last_commented',
                'total_objects',
                'rating',
                'rated_by',
                'voters'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}action_log` MODIFY COLUMN `action_success` ENUM(\'yes\',\'no\') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;', [
            'table' => 'action_log',
            'column' => 'action_success'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}comments`
            MODIFY `vote` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY `voters` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY `spam_votes` BIGINT(20) NOT NULL DEFAULT \'0\',
            MODIFY `spam_voters` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;', [
            'table' => 'comments',
            'columns' => [
                'vote',
                'voters',
                'spam_votes',
                'spam_voters'
            ]
        ]);
    }
}