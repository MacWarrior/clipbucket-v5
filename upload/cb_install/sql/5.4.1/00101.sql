ALTER TABLE `{tbl_prefix}action_log`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}ads_data`
    MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}collection_categories`
    MODIFY COLUMN `category_desc` text NULL DEFAULT NULL,
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}comments`
    MODIFY COLUMN `voters` text NULL DEFAULT NULL,
    MODIFY COLUMN `spam_voters` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}conversion_queue`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_categories`
    MODIFY COLUMN `date_added` datetime NOT NULL;

ALTER TABLE `{tbl_prefix}group_invitations`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_members`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}group_videos`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}messages`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}photos`
    MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
    MODIFY COLUMN `server_url` text NULL DEFAULT NULL,
    MODIFY COLUMN `photo_details` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}playlists`
    MODIFY COLUMN `voters` text NULL DEFAULT NULL,
    MODIFY COLUMN `last_update` text NULL DEFAULT NULL,
    MODIFY COLUMN `first_item` text NULL DEFAULT NULL,
    MODIFY COLUMN `cover` text NULL DEFAULT NULL,
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}playlist_items`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}subscriptions`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `{tbl_prefix}users`
    MODIFY COLUMN `avatar_url` text NULL DEFAULT NULL,
    MODIFY COLUMN `dob` date NOT NULL DEFAULT '1000-01-01',
    MODIFY COLUMN `doj` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    MODIFY COLUMN `last_logged` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
    MODIFY COLUMN `last_active` datetime NOT NULL DEFAULT '1000-01-01 00:00:00';

ALTER TABLE `{tbl_prefix}user_categories`
    MODIFY COLUMN `date_added` datetime NOT NULL;

ALTER TABLE `{tbl_prefix}video`
    MODIFY COLUMN `username` text NULL DEFAULT NULL,
    MODIFY COLUMN `category_parents` text NULL DEFAULT NULL,
    MODIFY COLUMN `blocked_countries` text NULL DEFAULT NULL,
    MODIFY COLUMN `last_viewed` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    MODIFY COLUMN `embed_code` text NULL DEFAULT NULL,
    MODIFY COLUMN `refer_url` text NULL DEFAULT NULL,
    MODIFY COLUMN `remote_play_url` text NULL DEFAULT NULL,
    MODIFY COLUMN `video_files` tinytext NULL DEFAULT NULL,
    MODIFY COLUMN `file_server_path` text NULL DEFAULT NULL,
    MODIFY COLUMN `files_thumbs_path` text NULL DEFAULT NULL,
    MODIFY COLUMN `video_version` varchar(30) NOT NULL DEFAULT '5.4.1',
    MODIFY COLUMN `thumbs_version` varchar(5) NOT NULL DEFAULT '5.4.1',
    MODIFY COLUMN `re_conv_status` tinytext NULL DEFAULT NULL,
    MODIFY COLUMN `conv_progress` text NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}video_categories`
    MODIFY COLUMN `category_desc` text NULL DEFAULT NULL,
    MODIFY COLUMN `date_added` datetime NULL DEFAULT NULL;

ALTER TABLE `{tbl_prefix}video_favourites`
    MODIFY COLUMN `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;
