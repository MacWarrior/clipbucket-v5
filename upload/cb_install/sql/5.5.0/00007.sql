DELETE FROM `{tbl_prefix}config` WHERE name = 'extract_audio_tracks';

DROP TABLE IF EXISTS `{tbl_prefix}video_audio_tracks`;
