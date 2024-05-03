<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00195 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}phrases`;';
        self::query($sql);

        $sql = 'ALTER DATABASE `{dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}action_log` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'action_log'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}admin_notes` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'admin_notes'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}admin_todo` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'admin_todo'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}ads_data` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'ads_data'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}ads_placements` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'ads_placements'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'collections'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_categories` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'collection_categories'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_contributors` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'collection_contributors'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_items` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'collection_items'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}comments` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'comments'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}config` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'config'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}contacts` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'contacts'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}conversion_queue` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'conversion_queue'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}counters` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'counters'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}countries` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'countries'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}email_templates` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'email_templates'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}favorites` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'favorites'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}flags` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'flags'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}groups` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'groups'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_categories` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'group_categories'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_invitations` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'group_invitations'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_members` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'group_members'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_posts` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'group_posts'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_topics` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'group_topics'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}group_videos` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'group_videos'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}languages` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'languages'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}languages_keys` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'languages_keys'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}languages_translations` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'languages_translations'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}mass_emails` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'mass_emails'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}messages` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'messages'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}pages` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'pages'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'photos'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}playlists` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'playlists'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}playlist_items` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'playlist_items'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}plugins` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'plugins'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}plugin_config` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'plugin_config'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}sessions` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'sessions'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}stats` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'stats'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}subscriptions` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'subscriptions'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}template` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'template'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'users'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_categories` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'user_categories'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'user_levels'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels_permissions` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'user_levels_permissions'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_permissions` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'user_permissions'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_permission_types` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'user_permission_types'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'user_profile'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}version` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'version'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'video'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_categories` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'video_categories'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_favourites` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'video_favourites'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_files` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'video_files'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_resolution` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'video_resolution'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_subtitle` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'video_subtitle'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_thumbs` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'video_thumbs'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_views` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;', [
            'table' => 'video_views'
        ]);

    }
}