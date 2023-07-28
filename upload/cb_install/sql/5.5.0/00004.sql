INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('extract_subtitles', '1');

CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_subtitle` (
    `videoid` bigint(20) NOT NULL,
    `number` varchar(2) NOT NULL,
    `title` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `{tbl_prefix}video_subtitle`
    ADD UNIQUE KEY `videoid` (`videoid`,`number`);

ALTER TABLE `{tbl_prefix}video_subtitle`
    ADD CONSTRAINT `{tbl_prefix}video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;
