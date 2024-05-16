<?php

namespace V5_0_0;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';
class M00001 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        // Fixing date & datetime formats so MySQL8 won't fail upgrades
        self::alterTable('ALTER TABLE `{tbl_prefix}ads_data`
            MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\',
            MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'   => 'ads_data',
            'columns' => [
                'last_viewed',
                'date_added'
            ]
        ]);

        $sql = 'UPDATE `{tbl_prefix}collections` SET `last_commented` = \'1000-01-01 00:00:00\' WHERE CAST(`last_commented` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}pages` SET `date_added` = \'1000-01-01 00:00:00\' WHERE CAST(`date_added` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}photos`
            MODIFY COLUMN `last_viewed` DATETIME NOT NULL DEFAULT \'1000-01-01 00:00:00\';', [
            'table'   => 'photos',
            'columns' => [
                'last_viewed'
            ]
        ]);

        $sql = 'UPDATE `{tbl_prefix}users` SET `featured_date` = \'1000-01-01 00:00:00\' WHERE CAST(`featured_date` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}users` SET `last_commented` = \'1000-01-01 00:00:00\' WHERE CAST(`last_commented` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}users` SET `last_logged` = \'1000-01-01 00:00:00\' WHERE CAST(`last_logged` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}users` SET `last_active` = \'1970-01-02 00:00:01\' WHERE CAST(`last_active` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}users`
            MODIFY COLUMN `dob` date NOT NULL DEFAULT \'1000-01-01\',
            MODIFY COLUMN `last_logged` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\',
            MODIFY COLUMN `last_active` datetime NOT NULL DEFAULT \'1000-01-01 00:00:00\';', [
            'table'   => 'users',
            'columns' => [
                'dob',
                'last_logged',
                'last_active'
            ]
        ]);

        $sql = 'UPDATE `{tbl_prefix}video` SET `featured_date` = \'1000-01-01 00:00:00\' WHERE CAST(`featured_date` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}video` SET `last_viewed` = \'1970-01-02 00:00:01\' WHERE CAST(`last_viewed` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}video` SET `last_commented` = \'1000-01-01 00:00:00\' WHERE CAST(`last_commented` AS CHAR(20)) = \'0000-00-00 00:00:00\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}video` SET `datecreated` = \'1000-01-01\' WHERE CAST(`datecreated` AS CHAR(20)) = \'0000-00-00\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video`
            MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;', [
            'table'   => 'video',
            'columns' => [
                'date_added'
            ]
        ]);
        // Now MySQL8 should work properly

        $tables = ['action_log','admin_notes','admin_todo','ads_data','ads_placements','collections','collection_categories','collection_contributors','collection_items','comments','config','contacts','conversion_queue','counters','countries','editors_picks','email_templates','favorites','flags','groups','group_categories','group_invitations','group_members','group_posts','group_topics','group_videos','languages','mass_emails','messages','modules','pages','photos','phrases','playlists','playlist_items','plugins','plugin_config','sessions','stats','subscriptions','template','users','user_categories','user_levels','user_levels_permissions','user_permissions','user_permission_types','user_profile','validation_re','version','video','video_categories','video_favourites','video_files','video_views'];
        foreach($tables as $table){
            $sql = 'ALTER TABLE `{tbl_prefix}' . $table . '` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
            self::query($sql);
        }

        $datas = [
            'action_log' => ['action_type','action_username','action_useremail','action_ip','action_details'],
            'admin_notes' => ['note'],
            'admin_todo' => ['todo'],
            'ads_data' => ['ad_name', 'ad_code', 'ad_placement'],
            'ads_placements' => ['placement', 'placement_name'],
            'collection_categories' => ['category_name', 'category_desc', 'date_added'],
            'collection_items' => ['type'],
            'collections' => ['collection_name', 'collection_description', 'collection_tags', 'category', 'featured', 'broadcast', 'allow_comments', 'active', 'public_upload', 'type'],
            'comments' => ['type', 'comment', 'anonym_name', 'anonym_email', 'vote', 'voters', 'spam_voters', 'comment_ip'],
            'config' => ['name', 'value'],
            'conversion_queue' => ['cqueue_name', 'cqueue_ext', 'cqueue_tmp_ext', 'time_started', 'time_completed'],
            'counters' => ['section', 'query', 'query_md5', 'date_added'],
            'countries' => ['iso2', 'name', 'name_en', 'iso3'],
            'email_templates' => ['email_template_name', 'email_template_code', 'email_template_subject', 'email_template', 'email_template_allowed_tags'],
            'favorites' => ['type'],
            'flags' => ['type'],
            'group_categories' => ['category_name', 'category_desc', 'date_added', 'category_thumb'],
            'group_posts' => ['post_content'],
            'group_topics' => ['topic_title', 'topic_post', 'topic_icon'],
            'groups' => ['group_name', 'group_admins', 'group_description', 'group_tags', 'group_url', 'category'],
            'languages' => ['language_code', 'language_name', 'language_regex'],
            'mass_emails' => ['email_subj', 'email_from', 'email_msg', 'configs', 'users'],
            'messages' => ['message_to', 'message_content', 'message_attachments', 'message_subject'],
            'modules' => ['module_name', 'module_file', 'active', 'module_include_file'],
            'pages' => ['page_name', 'page_title', 'page_content'],
            'photos' => ['photo_key', 'photo_title', 'photo_description', 'photo_tags', 'voters', 'filename', 'file_directory', 'ext', 'server_url', 'owner_ip', 'photo_details'],
            'phrases' => ['lang_iso', 'varname', 'text'],
            'playlist_items' => ['playlist_item_type'],
            'playlists' => ['playlist_name', 'playlist_type', 'description', 'tags', 'voters', 'last_update', 'first_item', 'cover'],
            'plugin_config' => ['plugin_id_code', 'plugin_config_name', 'plugin_config_value', 'player_admin_file', 'player_include_file'],
            'plugins' => ['plugin_file', 'plugin_folder', 'plugin_license_type', 'plugin_license_key', 'plugin_license_code'],
            'sessions' => ['session', 'session_string', 'session_value', 'ip', 'current_page', 'referer', 'agent'],
            'stats' => ['video_stats', 'user_stats', 'group_stats'],
            'subscriptions' => ['subscribed_to'],
            'template' => ['template_name', 'template_dir'],
            'user_categories' => ['category_name', 'category_desc', 'date_added', 'category_thumb'],
            'user_levels' => ['user_level_name'],
            'user_levels_permissions' => ['plugins_perms'],
            'user_permission_types' => ['user_permission_type_name', 'user_permission_type_desc'],
            'user_permissions' => ['permission_name', 'permission_code', 'permission_desc'],
            'user_profile' => ['profile_title', 'profile_desc', 'featured_video', 'first_name', 'last_name', 'avatar', 'postal_code', 'profile_tags', 'web_url', 'hometown', 'city', 'browse_criteria', 'about_me', 'education', 'schools', 'occupation', 'companies', 'relation_status', 'hobbies', 'fav_movies', 'fav_music', 'fav_books', 'background', 'profile_item', 'voters'],
            'users' => ['featured_video', 'username', 'user_session_key', 'password', 'email', 'avatar', 'avatar_url', 'country', 'avcode', 'session', 'ip', 'signup_ip', 'upload', 'background', 'background_color', 'background_url', 'banned_users'],
            'validation_re' => ['re_name', 're_code', 're_syntax'],
            'video' => ['videokey', 'video_password', 'video_users', 'username', 'title', 'file_name', 'file_directory', 'description', 'tags', 'category', 'category_parents', 'broadcast', 'location', 'country', 'allow_embedding', 'rated_by', 'voter_ids', 'allow_comments', 'comment_voting', 'featured', 'featured_description', 'allow_rating', 'active', 'favourite_count', 'playlist_count', 'flagged', 'duration', 'aspect_ratio', 'embed_code', 'refer_url', 'uploader_ip', 'unique_embed_code', 'remote_play_url', 'server_ip', 'file_server_path', 'files_thumbs_path', 'file_thumbs_count', 'filegrp_size', 'video_version', 'extras', 'thumbs_version'],
            'video_categories' => ['category_name', 'category_desc', 'date_added', 'category_thumb'],
            'video_files' => ['file_conversion_log', 'encoder', 'command_used', 'src_path', 'src_name', 'src_ext', 'src_format', 'src_duration', 'src_size', 'src_bitrate', 'src_video_width', 'src_video_height', 'src_video_wh_ratio', 'src_video_codec', 'src_video_rate', 'src_video_bitrate', 'src_video_color', 'src_audio_codec', 'src_audio_bitrate', 'src_audio_rate', 'src_audio_channels', 'output_path', 'output_format', 'output_duration', 'output_size', 'output_bitrate', 'output_video_width', 'output_video_height', 'output_video_wh_ratio', 'output_video_codec', 'output_video_rate', 'output_video_bitrate', 'output_video_color', 'output_audio_codec', 'output_audio_bitrate', 'output_audio_rate', 'output_audio_channels'],
            'video_views' => ['video_id']
        ];

        foreach( $datas as $table => $columns){
            foreach($columns as $column){
                $sql = 'UPDATE `{tbl_prefix}' . $table . '` SET ' . $column . ' = CONVERT(CAST(CONVERT(' . $column . ' USING utf8mb4) AS BINARY) USING utf8);';
                self::query($sql);
            }
        }

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
        (\'password_salt\', SUBSTRING(HEX(SHA2(CONCAT(NOW(), RAND(), UUID()), 512)),1, 32) ),
        (\'show_collapsed_checkboxes\', \'0\'),
        (\'enable_advertisement\', \'no\'),
        (\'chromecast\', \'no\'),
        (\'vid_cat_width\', \'120\'),
        (\'vid_cat_height\', \'120\');';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}users` CHANGE `password` `password` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\';', [
            'table'  => 'users',
            'column' => 'password'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels_permissions` ADD `view_photos` ENUM(\'yes\', \'no\') NOT NULL DEFAULT \'yes\' AFTER `view_video`;', [
            'table' => 'user_levels_permissions'
        ], [
            'table' => 'user_levels_permissions',
            'column' => 'view_photos'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_levels_permissions` ADD `view_collections` ENUM(\'yes\', \'no\') NOT NULL DEFAULT \'yes\' AFTER `view_photos`;', [
            'table' => 'user_levels_permissions'
        ], [
            'table' => 'user_levels_permissions',
            'column' => 'view_collections'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}user_permissions` (`permission_type`, `permission_name`, `permission_code`, `permission_desc`, `permission_default`) VALUES
            (1, \'View Photos Page\', \'view_photos\', \'User can view photos page\', \'yes\'),
            (1, \'View Collections Page\', \'view_collections\', \'User can view collections page\', \'yes\');';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}languages` SET `language_id` = 1 WHERE `language_code` LIKE \'en\';';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages` (`language_id`, `language_code`, `language_name`, `language_regex`, `language_active`, `language_default`)
        VALUES (2, \'fr\', \'Français\', \'fra\', \'no\', \'no\');';
        self::query($sql);

        $sql = 'CREATE TEMPORARY TABLE IF NOT EXISTS tmb_config_to_delete
            WITH all_duplicates AS (
                SELECT * FROM `{tbl_prefix}config` WHERE `name` IN (SELECT `name` FROM `{tbl_prefix}config` GROUP BY `name` HAVING COUNT(*) > 1 )
            )
            , keep_one_of_each_duplicate AS (
                SELECT MIN(`configid`) AS configid, `name` FROM all_duplicates GROUP BY `name`
            )
            , all_duplicated_except_one_of_each AS (
                SELECT `configid` FROM all_duplicates WHERE `configid` NOT IN (SELECT `configid` FROM keep_one_of_each_duplicate )
            )
            SELECT `configid` FROM all_duplicated_except_one_of_each;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE `configid` IN(SELECT `configid` FROM tmb_config_to_delete);';
        self::query($sql);
    }
}