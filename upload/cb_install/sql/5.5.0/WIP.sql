CREATE TABLE `{tbl_prefix}video_audio_track`
(
    `videoid` BIGINT(20)  NOT NULL,
    `number`  VARCHAR(2)  NOT NULL,
    `title`   VARCHAR(64) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_audio_track`
    ADD UNIQUE KEY `videoid` (`videoid`, `number`);

ALTER TABLE `{tbl_prefix}video_audio_track`
    ADD CONSTRAINT `{tbl_prefix}video_audio_track` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;