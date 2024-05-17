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

        $tables = ['action_log', 'admin_notes', 'admin_todo', 'ads_data', 'ads_placements', 'collections', 'collection_categories', 'collection_contributors', 'collection_items', 'comments', 'config', 'contacts', 'conversion_queue', 'counters', 'countries', 'email_templates', 'favorites', 'flags', 'groups', 'group_categories', 'group_invitations', 'group_members', 'group_posts', 'group_topics', 'group_videos', 'languages', 'languages_keys', 'languages_translations', 'mass_emails', 'messages', 'pages', 'photos', 'playlists', 'playlist_items', 'plugins', 'plugin_config', 'sessions', 'stats', 'subscriptions', 'template', 'users', 'user_categories', 'user_levels', 'user_levels_permissions', 'user_permissions', 'user_permission_types', 'user_profile', 'version', 'video', 'video_categories', 'video_favourites', 'video_files', 'video_resolution', 'video_subtitle', 'video_thumbs', 'video_views'];
        foreach($tables as $table){
            $sql = 'ALTER TABLE `{tbl_prefix}' . $table . '` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
            self::query($sql);
        }
    }
}