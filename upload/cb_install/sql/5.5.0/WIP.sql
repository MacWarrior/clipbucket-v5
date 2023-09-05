CREATE TABLE IF NOT EXISTS `{tbl_prefix}tags`
(
    `id_tag`      INT          NOT NULL AUTO_INCREMENT,
    `id_tag_type` INT          NOT NULL,
    `name`        VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id_tag`),
    UNIQUE `id_tag_type` (`id_tag_type`, `name`) USING BTREE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tags_type`
(
    `id_tag_type` INT         NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(32) NOT NULL,
    PRIMARY KEY (`id_tag_type`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}tags`
    ADD CONSTRAINT `tag_type` FOREIGN KEY (`id_tag_type`) REFERENCES `{tbl_prefix}tags_type` (`id_tag_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_tags`
(
    `id_video` BIGINT NOT NULL,
    `id_tag`   INT    NOT NULL,
    PRIMARY KEY (`id_video`, `id_tag`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_tags`
    ADD CONSTRAINT `video_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}video_tags`
    ADD CONSTRAINT `video_tags_video` FOREIGN KEY (`id_video`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}photo_tags`
(
    `id_photo` BIGINT NOT NULL,
    `id_tag`   INT    NOT NULL,
    PRIMARY KEY (`id_photo`, `id_tag`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}photo_tags`
    ADD CONSTRAINT `photo_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}photo_tags`
    ADD CONSTRAINT `photo_tags_photo` FOREIGN KEY (`id_photo`) REFERENCES `{tbl_prefix}photos` (`photo_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_tags`
(
    `id_collection` BIGINT NOT NULL,
    `id_tag`        INT    NOT NULL,
    PRIMARY KEY (`id_collection`, `id_tag`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}collection_tags`
    ADD CONSTRAINT `collection_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}collection_tags`
    ADD CONSTRAINT `collection_tags_collection` FOREIGN KEY (`id_collection`) REFERENCES `{tbl_prefix}collections` (`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}profile_tags`
(
    `id_profile` INT NOT NULL,
    `id_tag`     INT NOT NULL,
    PRIMARY KEY (`id_profile`, `id_tag`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}profile_tags`
    ADD CONSTRAINT `profile_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}profile_tags`
    ADD CONSTRAINT `profile_tags_profile` FOREIGN KEY (`id_profile`) REFERENCES `{tbl_prefix}user_profile` (`user_profile_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `{tbl_prefix}tags_type` (`name`)
VALUES ('video'),
       ('photo'),
       ('collection'),
       ('profile');

SET @type_video = (SELECT id_tag_type
                   FROM `{tbl_prefix}tags_type`
                   WHERE name LIKE 'video');

INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (SELECT @type_video, jsontable.tags
                                                           FROM `{tbl_prefix}video`
                                                                    CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`tags` TEXT PATH '$')) jsontable);
INSERT IGNORE INTO `{tbl_prefix}video_tags` (`id_tag`, `id_video`) (
    SELECT T.id_tag, videoid
    FROM `{tbl_prefix}video`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`tags` TEXT PATH '$')) jsontable
    INNER JOIN `{tbl_prefix}tags` AS T ON T.name = LOWER(jsontable.tags) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_video
);

SET @type_photo = (SELECT id_tag_type
                   FROM `{tbl_prefix}tags_type`
                   WHERE name LIKE 'photo');
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (SELECT @type_photo, jsontable.photo_tags AS tag
                                                           FROM `{tbl_prefix}photos`
                                                                    CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`photo_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`photo_tags` TEXT PATH '$')) jsontable);
INSERT IGNORE INTO `{tbl_prefix}photo_tags` (`id_tag`, `id_photo`) (
    SELECT T.id_tag, photo_id
    FROM `{tbl_prefix}photos`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`photo_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`photo_tags` TEXT PATH '$')) jsontable
             INNER JOIN `{tbl_prefix}tags` AS T ON T.name = LOWER(jsontable.photo_tags) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_photo
);


SET @type_collection = (SELECT id_tag_type
                        FROM `{tbl_prefix}tags_type`
                        WHERE name LIKE 'collection');
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (SELECT @type_collection, jsontable.collection_tags AS tag
                                                           FROM `{tbl_prefix}collections`
                                                                    CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`collection_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`collection_tags` TEXT PATH '$')) jsontable);
INSERT IGNORE INTO `{tbl_prefix}collection_tags` (`id_tag`, `id_collection`) (
    SELECT T.id_tag, collection_id
    FROM `{tbl_prefix}collections`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`collection_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`collection_tags` TEXT PATH '$')) jsontable
             INNER JOIN `{tbl_prefix}tags` AS T ON T.name = LOWER(jsontable.collection_tags) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_collection
);


SET @type_profile = (SELECT id_tag_type
                        FROM `{tbl_prefix}tags_type`
                        WHERE name LIKE 'profile');
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (SELECT @type_profile, jsontable.profile_tags
                                                           FROM `{tbl_prefix}user_profile`
                                                                    CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`profile_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`profile_tags` TEXT PATH '$')) jsontable WHERE TRIM(jsontable.profile_tags) != '');
INSERT IGNORE INTO `{tbl_prefix}profile_tags` (`id_tag`, `id_profile`) (
    SELECT T.id_tag, user_profile_id AS tag
    FROM `{tbl_prefix}user_profile`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`profile_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`profile_tags` TEXT PATH '$')) jsontable
             INNER JOIN `{tbl_prefix}tags` AS T ON T.name = LOWER(jsontable.profile_tags) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_profile
);



# DELETE CHAMp