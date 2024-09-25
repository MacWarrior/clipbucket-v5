INSERT INTO `{tbl_prefix}user_levels` (`user_level_id`, `user_level_active`, `user_level_name`, `user_level_is_default`) VALUES
(1, 'yes', 'Administrator', 'yes'),
(2, 'yes', 'Registered User', 'yes'),
(3, 'yes', 'Inactive User', 'yes'),
(4, 'yes', 'Guest', 'yes'),
(5, 'yes', 'Global Moderator', 'yes'),
(6, 'no', 'Anonymous', 'yes');

INSERT INTO `{tbl_prefix}user_levels_permissions` (`user_level_permission_id`, `user_level_id`, `admin_access`, `allow_video_upload`, `view_video`, `view_photos`, `view_collections`, `view_channel`, `view_videos`, `avatar_upload`, `video_moderation`, `member_moderation`, `ad_manager_access`, `manage_template_access`, `group_moderation`, `web_config_access`, `view_channels`, `playlist_access`, `allow_channel_bg`, `private_msg_access`, `edit_video`, `download_video`, `admin_del_access`, `photos_moderation`, `collection_moderation`, `plugins_moderation`, `tool_box`, `plugins_perms`, `allow_manage_user_level`, `allow_create_collection`, `allow_create_playlist`, `enable_channel_page`, `allow_photo_upload`) VALUES
(1, 1, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', '', 'yes', 'yes', 'yes','yes','yes'),
(2, 2, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', '', 'no', 'yes', 'yes','yes','yes'),
(3, 3, 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', '', 'no', 'yes', 'yes','yes','yes'),
(4, 4, 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', '', 'no', 'no', 'no','no','no'),
(5, 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', '', 'no', 'yes', 'yes','yes','yes'),
(6, 6, 'no', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', '', 'no', 'yes', 'yes','yes','yes');

INSERT INTO `{tbl_prefix}user_permission_types` (`user_permission_type_id`, `user_permission_type_name`, `user_permission_type_desc`) VALUES
(1, 'Viewing Permission', ''),
(2, 'Uploading Permission', ''),
(3, 'Administrator Permission', ''),
(4, 'General Permission', '');

INSERT INTO `{tbl_prefix}user_permissions` (`permission_id`, `permission_type`, `permission_name`, `permission_code`, `permission_desc`, `permission_default`) VALUES
(1, 2, 'Allow Video Upload', 'allow_video_upload', 'Allow user to upload videos', 'yes'),
(31, 2, 'Allow Photo Upload', 'allow_photo_upload', 'Allow user to upload photos', 'yes'),
(2, 3, 'Admin Access', 'admin_access', 'User can access admin panel', 'no'),
(3, 1, 'View Video', 'view_video', 'User can view videos', 'yes'),
(4, 1, 'View Channel', 'view_channel', 'User Can View Channel', 'yes'),
(6, 1, 'View Videos Page', 'view_videos', 'User Can view videos page', 'yes'),
(7, 2, 'Allow Avatar Upload', 'avatar_upload', 'User can upload video', 'yes'),
(8, 1, 'View Collections Page', 'view_collections', 'User can view collections page', 'yes'),
(9, 3, 'Video Moderation', 'video_moderation', 'User Can Moderate Videos', 'no'),
(10, 3, 'Member Moderation', 'member_moderation', 'User Can Moderate Members', 'no'),
(11, 3, 'Advertisment Manager', 'ad_manager_access', 'User can change advertisment', 'no'),
(12, 3, 'Manage Templates', 'manage_template_access', 'User can manage website templates', 'no'),
(13, 3, 'Groups Moderation', 'group_moderation', 'User can moderate group', 'no'),
(14, 3, 'Website Configurations', 'web_config_access', 'User can change website settings', 'no'),
(15, 1, 'View channels', 'view_channels', 'User can channels', 'yes'),
(17, 1, 'View Photos Page', 'view_photos', 'User can view photos page', 'yes'),
(18, 4, 'Playlist Access', 'playlist_access', 'User can access playlists', 'yes'),
(19, 2, 'Allow Channel Background', 'allow_channel_bg', 'Allow user to change channel background', 'yes'),
(20, 4, 'Private Messages', 'private_msg_access', 'User can use private messaging system', 'yes'),
(21, 4, 'Edit Video', 'edit_video', 'User can edit video', 'yes'),
(22, 4, 'Download Video', 'download_video', 'User can download videos', 'yes'),
(23, 3, 'Admin Delete Access', 'admin_del_access', 'User can delete comments if has admin access', 'no'),
(24, 3, 'Allow manage user levels', 'allow_manage_user_level', 'Allow user to edit user levels', 'no'),
(25, 3, 'Allow photo moderation', 'photos_moderation', 'Allow user to moderation photos from admin panel', 'yes'),
(26, 3, 'Collection moderation', 'collection_moderation', 'Allow users to moderate collection', 'yes'),
(27, 3, 'Plugins moderation', 'plugins_moderation', 'Allow user to moderate plugins', 'yes'),
(28, 3, 'Tool Box', 'tool_box', 'Allow users to access tool box', 'yes'),
(29, 2, 'Allow create collection', 'allow_create_collection', 'Allow users to create collection', 'yes'),
(30, 2, 'Allow create playlist', 'allow_create_playlist', 'Allow users to create playlist', 'yes');


