CREATE TABLE `{tbl_prefix}video_thumbs`
(
    `videoid`    BIGINT(20)  NOT NULL,
    `resolution` VARCHAR(16) NOT NULL,
    `num`        VARCHAR(4)  NOT NULL,
    `extension`  VARCHAR(4)  NOT NULL,
    `version`    VARCHAR(30) NOT NULL,
    PRIMARY KEY `resolution` (`videoid`, `resolution`, `num`),
    KEY `videoid` (`videoid`)
);

ALTER TABLE `{tbl_prefix}video_thumbs`
    ADD CONSTRAINT `{tbl_prefix}video_thumbs_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE NO ACTION;
