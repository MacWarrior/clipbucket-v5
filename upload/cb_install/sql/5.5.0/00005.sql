INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('extract_audio_tracks', '1');

CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_audio_tracks` (
    `videoid` bigint(20) NOT NULL,
    `number` varchar(2) NOT NULL,
    `title` varchar(64) NOT NULL,
    `channels` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_audio_tracks`
    ADD UNIQUE KEY `videoid` (`videoid`,`number`);

ALTER TABLE `{tbl_prefix}video_audio_tracks`
    ADD CONSTRAINT `video_audio_tracks_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;
