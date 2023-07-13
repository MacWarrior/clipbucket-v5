SET @enable_video_file_upload = (SELECT `value` FROM `{tbl_prefix}config` WHERE `name` = 'load_upload_form');
SET @enable_video_remote_upload = (SELECT `value` FROM `{tbl_prefix}config` WHERE `name` = 'load_remote_upload_form');
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('enable_video_file_upload', @enable_video_file_upload),
    ('enable_video_remote_upload', @enable_video_remote_upload),
    ('enable_photo_file_upload', 'yes');
DELETE FROM `{tbl_prefix}config` WHERE `name` IN ('load_upload_form','load_remote_upload_form');
