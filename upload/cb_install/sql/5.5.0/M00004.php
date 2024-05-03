<?php

namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00004 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}action_log` ENGINE=InnoDB;', [
            'table' => 'action_log'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}admin_notes` ENGINE=InnoDB;', [
            'table' => 'admin_notes'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}admin_todo` ENGINE=InnoDB;', [
            'table' => 'admin_todo'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}ads_data` ENGINE=InnoDB;', [
            'table' => 'ads_data'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}ads_placements` ENGINE=InnoDB;', [
            'table' => 'ads_placements'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_categories` ENGINE=InnoDB;', [
            'table' => 'collection_categories'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_contributors` ENGINE=InnoDB;', [
            'table' => 'collection_contributors'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_items` ENGINE=InnoDB;', [
            'table' => 'collection_items'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ENGINE=InnoDB;', [
            'table' => 'collections'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` ENGINE=InnoDB;', [
            'table' => 'comments'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}config` ENGINE=InnoDB;', [
            'table' => 'config'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}contacts` ENGINE=InnoDB;', [
            'table' => 'contacts'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}conversion_queue` ENGINE=InnoDB;', [
            'table' => 'conversion_queue'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}counters` ENGINE=InnoDB;', [
            'table' => 'counters'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}countries` ENGINE=InnoDB;', [
            'table' => 'countries'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}email_templates` ENGINE=InnoDB;', [
            'table' => 'email_templates'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}favorites` ENGINE=InnoDB;', [
            'table' => 'favorites'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}flags` ENGINE=InnoDB;', [
            'table' => 'flags'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_categories` ENGINE=InnoDB;', [
            'table' => 'group_categories'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_invitations` ENGINE=InnoDB;', [
            'table' => 'group_invitations'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_members` ENGINE=InnoDB;', [
            'table' => 'group_members'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_posts` ENGINE=InnoDB;', [
            'table' => 'group_posts'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_topics` ENGINE=InnoDB;', [
            'table' => 'group_topics'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_videos` ENGINE=InnoDB;', [
            'table' => 'group_videos'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}groups` ENGINE=InnoDB;', [
            'table' => 'groups'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}languages` ENGINE=InnoDB;', [
            'table' => 'languages'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}mass_emails` ENGINE=InnoDB;', [
            'table' => 'mass_emails'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}messages` ENGINE=InnoDB;', [
            'table' => 'messages'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}pages` ENGINE=InnoDB;', [
            'table' => 'pages'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` ENGINE=InnoDB;', [
            'table' => 'photos'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}phrases` ENGINE=InnoDB;', [
            'table' => 'phrases'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}playlist_items` ENGINE=InnoDB;', [
            'table' => 'playlist_items'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}playlists` ENGINE=InnoDB;', [
            'table' => 'playlists'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}plugin_config` ENGINE=InnoDB;', [
            'table' => 'plugin_config'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}plugins` ENGINE=InnoDB;', [
            'table' => 'plugins'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}sessions` ENGINE=InnoDB;', [
            'table' => 'sessions'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}stats` ENGINE=InnoDB;', [
            'table' => 'stats'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}subscriptions` ENGINE=InnoDB;', [
            'table' => 'subscriptions'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}template` ENGINE=InnoDB;', [
            'table' => 'template'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_categories` ENGINE=InnoDB;', [
            'table' => 'user_categories'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels` ENGINE=InnoDB;', [
            'table' => 'user_levels'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels_permissions` ENGINE=InnoDB;', [
            'table' => 'user_levels_permissions'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_permission_types` ENGINE=InnoDB;', [
            'table' => 'user_permission_types'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_permissions` ENGINE=InnoDB;', [
            'table' => 'user_permissions'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` ENGINE=InnoDB;', [
            'table' => 'user_profile'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}users` ENGINE=InnoDB;', [
            'table' => 'users'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}validation_re` ENGINE=InnoDB;', [
            'table' => 'validation_re'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ENGINE=InnoDB;', [
            'table' => 'video'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_categories` ENGINE=InnoDB;', [
            'table' => 'video_categories'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_favourites` ENGINE=InnoDB;', [
            'table' => 'video_favourites'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_files` ENGINE=InnoDB;', [
            'table' => 'video_files'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_views` ENGINE=InnoDB;', [
            'table' => 'video_views'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'extract_subtitles\', \'1\');';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_subtitle` (
            `videoid` BIGINT(20) NOT NULL,
            `number` VARCHAR(2) NOT NULL,
            `title` VARCHAR(64) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_subtitle` ADD UNIQUE KEY `videoid` (`videoid`,`number`);', [
            'table'   => 'video_subtitle',
            'columns' => [
                'videoid',
                'number'
            ]
        ], [
            'constraint_name'   => 'videoid',
            'constraint_type'   => 'UNIQUE',
            'constraint_schema' => '{dbname}'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_subtitle` ADD CONSTRAINT `video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;', [
            'table'  => 'video_subtitle',
            'column' => 'videoid'
        ], [
            'constraint_name' => 'video_subtitle_ibfk_1',
            'constraint_type' => 'FOREIGN KEY'
        ]);
    }
}