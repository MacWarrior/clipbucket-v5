ALTER TABLE `{tbl_prefix}action_log` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}admin_notes` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}admin_todo` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}ads_data` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}ads_placements` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}collection_categories` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}collection_contributors` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}collection_items` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}collections` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}comments` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}config` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}contacts` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}conversion_queue` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}counters` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}countries` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}email_templates` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}favorites` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}flags` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}group_categories` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}group_invitations` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}group_members` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}group_posts` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}group_topics` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}group_videos` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}groups` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}languages` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}mass_emails` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}messages` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}pages` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}photos` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}phrases` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}playlist_items` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}playlists` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}plugin_config` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}plugins` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}sessions` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}stats` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}subscriptions` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}template` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}user_categories` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}user_levels` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}user_levels_permissions` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}user_permission_types` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}user_permissions` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}user_profile` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}users` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}validation_re` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}video` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}video_categories` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}video_favourites` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}video_files` ENGINE=InnoDB;
ALTER TABLE `{tbl_prefix}video_views` ENGINE=InnoDB;

INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('extract_subtitles', '1');

CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_subtitle` (
    `videoid` bigint(20) NOT NULL,
    `number` varchar(2) NOT NULL,
    `title` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_subtitle`
    ADD UNIQUE KEY `videoid` (`videoid`,`number`);

ALTER TABLE `{tbl_prefix}video_subtitle`
    ADD CONSTRAINT `{tbl_prefix}video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;
