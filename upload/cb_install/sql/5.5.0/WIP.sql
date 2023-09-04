CREATE TABLE IF NOT EXISTS `{tbl_prefix}tags`
(
    `id_tag`      INT          NOT NULL AUTO_INCREMENT,
    `id_tag_type` INT          NOT NULL,
    `name`        VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id_tag`),
    UNIQUE  `id_tag_type` (`id_tag_type`, `name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tags_type`
(
    `id_tag_type` INT         NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(32) NOT NULL,
    PRIMARY KEY (`id_tag_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}tags` ADD CONSTRAINT `tag_type` FOREIGN KEY (`id_tag_type`) REFERENCES `{tbl_prefix}tags_type`(`id_tag_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_tags`
(
    `id_video` BIGINT NOT NULL,
    `id_tag`   INT    NOT NULL,
    PRIMARY KEY (`id_video`, `id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_tags` ADD CONSTRAINT `video_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags`(`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}video_tags` ADD CONSTRAINT `video_tags_video` FOREIGN KEY (`id_video`) REFERENCES `{tbl_prefix}video`(`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `{tbl_prefix}tags_type` (`name`) VALUES ('video'), ('photo'), ('collection'), ('profile');

SET @type_video = (SELECT id_tag_type FROM `{tbl_prefix}tags_type` WHERE name LIKE 'video');
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (SELECT @type_video, jsontable.tags AS tag FROM `{tbl_prefix}video` CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`tags` TEXT PATH '$')) jsontable);

SET @type_photo = (SELECT id_tag_type FROM `{tbl_prefix}tags_type` WHERE name LIKE 'photo');
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (SELECT @type_photo, jsontable.photo_tags AS tag FROM `{tbl_prefix}photos` CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`photo_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`photo_tags` TEXT PATH '$')) jsontable);

SET @type_collection = (SELECT id_tag_type FROM `{tbl_prefix}tags_type` WHERE name LIKE 'collection');
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (SELECT @type_collection, jsontable.collection_tags AS tag FROM `{tbl_prefix}collections` CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`collection_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`collection_tags` TEXT PATH '$')) jsontable);

SET @type_collection = (SELECT id_tag_type FROM `{tbl_prefix}tags_type` WHERE name LIKE 'profile');
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (SELECT @type_collection, jsontable.profile_tags AS tag FROM `{tbl_prefix}user_profile` CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`profile_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`profile_tags` TEXT PATH '$')) jsontable);

# DELETE CHAMp