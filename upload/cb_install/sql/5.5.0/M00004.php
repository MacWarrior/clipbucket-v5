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
        $tables = ['action_log', 'admin_notes', 'admin_todo', 'ads_data', 'ads_placements', 'collection_categories', 'collection_contributors', 'collection_items', 'collections', 'comments', 'config', 'contacts', 'conversion_queue', 'counters', 'countries', 'email_templates', 'favorites', 'flags', 'group_categories', 'group_invitations', 'group_members', 'group_posts', 'group_topics', 'group_videos', 'groups', 'languages', 'mass_emails', 'messages', 'pages', 'photos', 'phrases', 'playlist_items', 'playlists', 'plugin_config', 'plugins', 'sessions', 'stats', 'subscriptions', 'template', 'user_categories', 'user_levels', 'user_levels_permissions', 'user_permission_types', 'user_permissions', 'user_profile', 'users', 'validation_re', 'video', 'video_categories', 'video_favourites', 'video_files', 'video_views'];
        foreach($tables as $table) {
            self::alterTable('ALTER TABLE `{tbl_prefix}' . $table . '` ENGINE=InnoDB;', [
                'table' => $table
            ]);
        }

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