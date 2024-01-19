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
    ADD CONSTRAINT `tag_type` FOREIGN KEY IF NOT EXISTS (`id_tag_type`) REFERENCES `{tbl_prefix}tags_type` (`id_tag_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_tags`
(
    `id_video` BIGINT NOT NULL,
    `id_tag`   INT    NOT NULL,
    PRIMARY KEY (`id_video`, `id_tag`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}video_tags`
    ADD CONSTRAINT `video_tags_tag` FOREIGN KEY IF NOT EXISTS (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}video_tags`
    ADD CONSTRAINT `video_tags_video` FOREIGN KEY IF NOT EXISTS (`id_video`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}photo_tags`
(
    `id_photo` BIGINT NOT NULL,
    `id_tag`   INT    NOT NULL,
    PRIMARY KEY (`id_photo`, `id_tag`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}photo_tags`
    ADD CONSTRAINT `photo_tags_tag` FOREIGN KEY IF NOT EXISTS (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}photo_tags`
    ADD CONSTRAINT `photo_tags_photo` FOREIGN KEY IF NOT EXISTS (`id_photo`) REFERENCES `{tbl_prefix}photos` (`photo_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_tags`
(
    `id_collection` BIGINT NOT NULL,
    `id_tag`        INT    NOT NULL,
    PRIMARY KEY (`id_collection`, `id_tag`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}collection_tags` ADD CONSTRAINT `collection_tags_tag` FOREIGN KEY IF NOT EXISTS (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}collection_tags` ADD CONSTRAINT `collection_tags_collection` FOREIGN KEY IF NOT EXISTS (`id_collection`) REFERENCES `{tbl_prefix}collections` (`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}user_tags`
(
    `id_user` BIGINT NOT NULL,
    `id_tag`     INT NOT NULL,
    PRIMARY KEY (`id_user`, `id_tag`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}user_tags` ADD CONSTRAINT `user_tags_tag` FOREIGN KEY IF NOT EXISTS (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}user_tags` ADD CONSTRAINT `user_tags_profile` FOREIGN KEY IF NOT EXISTS (`id_user`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}playlist_tags`
(
    `id_playlist` INT NOT NULL,
    `id_tag`      INT NOT NULL,
    PRIMARY KEY (`id_playlist`, `id_tag`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}playlist_tags` ADD CONSTRAINT `playlist_tags_tag` FOREIGN KEY IF NOT EXISTS (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `{tbl_prefix}playlist_tags` ADD CONSTRAINT `playlist_tags_playlist` FOREIGN KEY IF NOT EXISTS (`id_playlist`) REFERENCES `{tbl_prefix}playlists` (`playlist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `{tbl_prefix}tags_type` (`name`)
VALUES ('video'),
       ('photo'),
       ('collection'),
       ('profile'),
       ('playlist');

SET @type_video = (
    SELECT id_tag_type
    FROM `{tbl_prefix}tags_type`
    WHERE name LIKE 'video'
);
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (
    SELECT @type_video, TRIM(jsontable.tags)
    FROM `{tbl_prefix}video`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`tags` TEXT PATH '$')) jsontable
    WHERE TRIM(jsontable.tags) != ''
);
INSERT IGNORE INTO `{tbl_prefix}video_tags` (`id_tag`, `id_video`) (
    SELECT T.id_tag, videoid
    FROM `{tbl_prefix}video`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`tags` TEXT PATH '$')) jsontable
             INNER JOIN `{tbl_prefix}tags` AS T ON T.name = TRIM(LOWER(jsontable.tags)) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_video
    WHERE TRIM(jsontable.tags) != ''
);

SET @type_photo = (
    SELECT id_tag_type
    FROM `{tbl_prefix}tags_type`
    WHERE name LIKE 'photo'
);
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (
    SELECT @type_photo, TRIM(jsontable.photo_tags)
    FROM `{tbl_prefix}photos`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`photo_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`photo_tags` TEXT PATH '$')) jsontable
    WHERE TRIM(jsontable.photo_tags) != ''
);
INSERT IGNORE INTO `{tbl_prefix}photo_tags` (`id_tag`, `id_photo`) (
    SELECT T.id_tag, photo_id
    FROM `{tbl_prefix}photos`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`photo_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`photo_tags` TEXT PATH '$')) jsontable
             INNER JOIN `{tbl_prefix}tags` AS T ON T.name = TRIM(LOWER(jsontable.photo_tags)) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_photo
    WHERE TRIM(jsontable.photo_tags) != ''
);

SET @type_collection = (
    SELECT id_tag_type
    FROM `{tbl_prefix}tags_type`
    WHERE name LIKE 'collection'
);
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (
    SELECT @type_collection, TRIM(jsontable.collection_tags)
    FROM `{tbl_prefix}collections`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`collection_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`collection_tags` TEXT PATH '$')) jsontable
    WHERE TRIM(jsontable.collection_tags) != ''
);
INSERT IGNORE INTO `{tbl_prefix}collection_tags` (`id_tag`, `id_collection`) (
    SELECT T.id_tag, collection_id
    FROM `{tbl_prefix}collections`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`collection_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`collection_tags` TEXT PATH '$')) jsontable
             INNER JOIN `{tbl_prefix}tags` AS T ON T.name = TRIM(LOWER(jsontable.collection_tags)) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_collection
    WHERE TRIM(jsontable.collection_tags) != ''
);

SET @type_profile = (
    SELECT id_tag_type
    FROM `{tbl_prefix}tags_type`
    WHERE name LIKE 'profile'
);
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (
    SELECT @type_profile, TRIM(jsontable.profile_tags)
    FROM `{tbl_prefix}user_profile`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`profile_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`profile_tags` TEXT PATH '$')) jsontable
    WHERE TRIM(jsontable.profile_tags) != ''
);
INSERT IGNORE INTO `{tbl_prefix}user_tags` (`id_tag`, `id_user`) (
    SELECT T.id_tag, userid
    FROM `{tbl_prefix}user_profile`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`profile_tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`profile_tags` TEXT PATH '$')) jsontable
             INNER JOIN `{tbl_prefix}tags` AS T ON T.name = TRIM(LOWER(jsontable.profile_tags)) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_profile
    WHERE TRIM(jsontable.profile_tags) != ''
);

SET @type_playlist = (
    SELECT id_tag_type
    FROM `{tbl_prefix}tags_type`
    WHERE name LIKE 'playlist'
);
INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name) (
    SELECT @type_playlist, TRIM(jsontable.tags)
    FROM `{tbl_prefix}playlists`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`tags` TEXT PATH '$')) jsontable
    WHERE TRIM(jsontable.tags) != ''
);
INSERT IGNORE INTO `{tbl_prefix}playlist_tags` (`id_tag`, `id_playlist`) (
    SELECT T.id_tag, playlist_id
    FROM `{tbl_prefix}playlists`
             CROSS JOIN JSON_TABLE(CONCAT('["', REPLACE(LOWER(`tags`), ',', '","'), '"]'), '$[*]' COLUMNS (`tags` TEXT PATH '$')) jsontable
             INNER JOIN `{tbl_prefix}tags` AS T ON T.name = TRIM(LOWER(jsontable.tags)) COLLATE utf8mb4_unicode_520_ci AND T.id_tag_type = @type_playlist
    WHERE TRIM(jsontable.tags) != ''
);

ALTER TABLE `{tbl_prefix}video` DROP COLUMN IF EXISTS `tags`;
ALTER TABLE `{tbl_prefix}photos` DROP COLUMN IF EXISTS `photo_tags`;
ALTER TABLE `{tbl_prefix}collections` DROP COLUMN IF EXISTS `collection_tags`;
ALTER TABLE `{tbl_prefix}user_profile` DROP COLUMN IF EXISTS `profile_tags`;
ALTER TABLE `{tbl_prefix}playlists` DROP COLUMN IF EXISTS `tags`;
ALTER TABLE `{tbl_prefix}tags` ADD FULLTEXT KEY `tag` (`name`);

INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
    ('clean_orphan_tags', 'clean_orphan_tags_description', 'AdminTool::cleanOrphanTags', 1, NULL, NULL);

SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');

SET @language_key = 'email_tester' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Email Tester', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Email Testeur', @language_id_fra);

SET @language_key = 'manage_tags' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Manage tags', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Gestion des tags', @language_id_fra);

SET @language_key = 'action' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Action', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Action', @language_id_fra);

SET @language_key = 'label' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Label', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Label', @language_id_fra);

SET @language_key = 'tag_updated' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Tag has been updated', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Le tag a été  mis à jour', @language_id_fra);

SET @language_key = 'tag_deleted' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Tag has been deleted', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Le tag a été supprimé', @language_id_fra);

SET @language_key = 'general' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'General', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Général', @language_id_fra);

SET @language_key = 'confirm_delete_tag' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Do you really want delete tag : %s ?', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Êtes-vous certains de vouloir supprimer le tag : %s ?', @language_id_fra);

SET @language_key = 'clean_orphan_tags' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Delete orphan tags', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Suppression des tags orphelins', @language_id_fra);

SET @language_key = 'clean_orphan_tags_description' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Delete tags which are not related to a video, photo, collection, playlist or user', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Supprime les tags qui ne sont pas lié à une video, photo, collection, playlist ou utilisateur', @language_id_fra);

SET @language_key = 'cannot_delete_tag' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'You cannot delete this tag', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Vous ne pouvez pas supprimer ce tag', @language_id_fra);

SET @language_key = 'tag_too_short' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Tags less than 3 characters are not allowed', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Les tags de moins de 3 caractères ne sont pas autorisés', @language_id_fra);

SET @language_key = 'tag_type' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Tag type', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Type de tag', @language_id_fra);

SET @language_key = 'playlist' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Playlist', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Playlist', @language_id_fra);

SET @language_key = 'profile' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Profile', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES (@id_language_key, 'Profil', @language_id_fra);
