<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00264 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}tags`
        (
            `id_tag`      INT          NOT NULL AUTO_INCREMENT,
            `id_tag_type` INT          NOT NULL,
            `name`        VARCHAR(128) NOT NULL,
            PRIMARY KEY (`id_tag`),
            UNIQUE `id_tag_type` (`id_tag_type`, `name`) USING BTREE
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}tags_type`
        (
            `id_tag_type` INT         NOT NULL AUTO_INCREMENT,
            `name`        VARCHAR(32) NOT NULL,
            PRIMARY KEY (`id_tag_type`)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}tags` ADD CONSTRAINT `tag_type` FOREIGN KEY (`id_tag_type`) REFERENCES `{tbl_prefix}tags_type` (`id_tag_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'           => 'tags',
            'column'          => 'id_tag_type'
            ],[
            'constraint_name' => 'tag_type',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_tags`
            (
                `id_video` BIGINT NOT NULL,
                `id_tag`   INT    NOT NULL,
                PRIMARY KEY (`id_video`, `id_tag`)
            ) ENGINE = InnoDB
              DEFAULT CHARSET = utf8mb4
              COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_tags` ADD CONSTRAINT `video_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'video_tags',
            'column'          => 'id_tag'
            ], [
            'constraint_name' => 'video_tags_tag',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_tags` ADD CONSTRAINT `video_tags_video` FOREIGN KEY (`id_video`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'video_tags',
            'column'          => 'id_video'
            ], [
            'constraint_name' => 'video_tags_video',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}photo_tags`
            (
                `id_photo` BIGINT NOT NULL,
                `id_tag`   INT    NOT NULL,
                PRIMARY KEY (`id_photo`, `id_tag`)
            ) ENGINE = InnoDB
              DEFAULT CHARSET = utf8mb4
              COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}photo_tags` ADD CONSTRAINT `photo_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'photo_tags',
            'column'          => 'id_tag'
            ], [
            'constraint_name' => 'photo_tags_tag',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}photo_tags` ADD CONSTRAINT `photo_tags_photo` FOREIGN KEY (`id_photo`) REFERENCES `{tbl_prefix}photos` (`photo_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'photo_tags',
            'column'          => 'id_photo'
            ], [
            'constraint_name' => 'photo_tags_photo',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_tags`
        (
            `id_collection` BIGINT NOT NULL,
            `id_tag`        INT    NOT NULL,
            PRIMARY KEY (`id_collection`, `id_tag`)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}collection_tags` ADD CONSTRAINT `collection_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'collection_tags',
            'column'          => 'id_tag'
            ], [
            'constraint_name' => 'collection_tags_tag',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collection_tags` ADD CONSTRAINT `collection_tags_collection` FOREIGN KEY (`id_collection`) REFERENCES `{tbl_prefix}collections` (`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'collection_tags',
            'column'          => 'id_collection'
            ], [
            'constraint_name' => 'collection_tags_collection',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}user_tags`
        (
            `id_user` BIGINT NOT NULL,
            `id_tag`     INT NOT NULL,
            PRIMARY KEY (`id_user`, `id_tag`)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_tags` ADD CONSTRAINT `user_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'user_tags',
            'column'          => 'id_tag'
            ], [
            'constraint_name' => 'user_tags_tag',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_tags` ADD CONSTRAINT `user_tags_profile` FOREIGN KEY (`id_user`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'user_tags',
            'column'          => 'id_user'
            ], [
            'constraint_name' => 'user_tags_profile',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}playlist_tags`
            (
                `id_playlist` INT NOT NULL,
                `id_tag`      INT NOT NULL,
                PRIMARY KEY (`id_playlist`, `id_tag`)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}playlist_tags` ADD CONSTRAINT `playlist_tags_tag` FOREIGN KEY (`id_tag`) REFERENCES `{tbl_prefix}tags` (`id_tag`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'playlist_tags',
            'column'          => 'id_tag'
            ], [
            'constraint_name' => 'playlist_tags_tag',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}playlist_tags` ADD CONSTRAINT `playlist_tags_playlist` FOREIGN KEY (`id_playlist`) REFERENCES `{tbl_prefix}playlists` (`playlist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table' => 'playlist_tags',
            'column'          => 'id_playlist'
            ], [
            'constraint_name' => 'playlist_tags_playlist',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'INSERT INTO `{tbl_prefix}tags_type` (`name`)
        VALUES (\'video\'),
               (\'photo\'),
               (\'collection\'),
               (\'profile\'),
               (\'playlist\');';
        self::query($sql);

        $sql = 'SET @type_video = (
            SELECT id_tag_type
            FROM `{tbl_prefix}tags_type`
            WHERE name LIKE \'video\'
        );';
        self::query($sql);

        $sql = 'SET @tags_video = (SELECT GROUP_CONCAT(`tags`) FROM `{tbl_prefix}video` WHERE `tags` IS NOT NULL AND TRIM(`tags`) != \'\');';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tags` (`id_tag_type`, `name`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_video) - LENGTH(REPLACE(@tags_video, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                @type_video
                ,SUBSTRING_INDEX(SUBSTRING_INDEX(@tags_video, \',\', seq.n + 1), \',\', -1) AS tags
            FROM NumberSequence seq
        ;';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}video_tags` (`id_tag`, `id_video`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_video) - LENGTH(REPLACE(@tags_video, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                tags.id_tag
                ,video.videoid
            FROM `{tbl_prefix}video` video
                CROSS JOIN NumberSequence seq
                INNER JOIN `{tbl_prefix}tags` tags ON tags.name = SUBSTRING_INDEX(SUBSTRING_INDEX(video.tags, \',\', seq.n + 1), \',\', -1) AND tags.id_tag_type = @type_video
            WHERE
                video.tags IS NOT NULL AND TRIM(video.tags) != \'\'
        ;';
        self::query($sql);

        $sql = 'SET @type_photo = (
            SELECT id_tag_type
            FROM `{tbl_prefix}tags_type`
            WHERE name LIKE \'photo\'
        );';
        self::query($sql);

        $sql = 'SET @tags_photo = (SELECT GROUP_CONCAT(`photo_tags`) FROM `{tbl_prefix}photos` WHERE `photo_tags` IS NOT NULL AND TRIM(`photo_tags`) != \'\');';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tags` (`id_tag_type`, `name`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_photo) - LENGTH(REPLACE(@tags_photo, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                @type_photo
                ,SUBSTRING_INDEX(SUBSTRING_INDEX(@tags_photo, \',\', seq.n + 1), \',\', -1) AS tags
            FROM NumberSequence seq
        ;';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}photo_tags` (`id_tag`, `id_photo`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_photo) - LENGTH(REPLACE(@tags_photo, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                tags.id_tag
                ,photo.photo_id
            FROM `{tbl_prefix}photos` photo
                 CROSS JOIN NumberSequence seq
                 INNER JOIN `{tbl_prefix}tags` tags ON tags.name = SUBSTRING_INDEX(SUBSTRING_INDEX(photo.photo_tags, \',\', seq.n + 1), \',\', -1) AND tags.id_tag_type = @type_photo
            WHERE
                photo.photo_tags IS NOT NULL AND TRIM(photo.photo_tags) != \'\'
        ;';
        self::query($sql);

        $sql = 'SET @type_collection = (
            SELECT id_tag_type
            FROM `{tbl_prefix}tags_type`
            WHERE name LIKE \'collection\'
        );';
        self::query($sql);

        $sql = 'SET @tags_collection = (SELECT GROUP_CONCAT(`collection_tags`) FROM `{tbl_prefix}collections` WHERE `collection_tags` IS NOT NULL AND TRIM(`collection_tags`) != \'\');';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tags` (`id_tag_type`, `name`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_collection) - LENGTH(REPLACE(@tags_collection, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                @type_collection
                ,SUBSTRING_INDEX(SUBSTRING_INDEX(@tags_collection, \',\', seq.n + 1), \',\', -1) AS tags
            FROM NumberSequence seq
        ;';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}collection_tags` (`id_tag`, `id_collection`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_collection) - LENGTH(REPLACE(@tags_collection, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                tags.id_tag
                ,collection.collection_id
            FROM `{tbl_prefix}collections` collection
                 CROSS JOIN NumberSequence seq
                 INNER JOIN `{tbl_prefix}tags` tags ON tags.name = SUBSTRING_INDEX(SUBSTRING_INDEX(collection.collection_tags, \',\', seq.n + 1), \',\', -1) AND tags.id_tag_type = @type_collection
            WHERE
            collection.collection_tags IS NOT NULL AND TRIM(collection.collection_tags) != \'\'
        ;';
        self::query($sql);

        $sql = 'SET @type_profile = (
            SELECT id_tag_type
            FROM `{tbl_prefix}tags_type`
            WHERE name LIKE \'profile\'
        );';
        self::query($sql);

        $sql = 'SET @tags_profile = (SELECT GROUP_CONCAT(`profile_tags`) FROM `{tbl_prefix}user_profile` WHERE `profile_tags` IS NOT NULL AND TRIM(`profile_tags`) != \'\');';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_profile) - LENGTH(REPLACE(@tags_profile, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                @type_profile
                ,SUBSTRING_INDEX(SUBSTRING_INDEX(@tags_profile, \',\', seq.n + 1), \',\', -1) AS tags
            FROM NumberSequence seq
        ;';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}user_tags` (`id_tag`, `id_user`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_profile) - LENGTH(REPLACE(@tags_profile, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                tags.id_tag
                ,profile.userid
            FROM `{tbl_prefix}user_profile` profile
                 CROSS JOIN NumberSequence seq
                 INNER JOIN `{tbl_prefix}tags` tags ON tags.name = SUBSTRING_INDEX(SUBSTRING_INDEX(profile.profile_tags, \',\', seq.n + 1), \',\', -1) AND tags.id_tag_type = @type_profile
            WHERE
                profile.profile_tags IS NOT NULL AND TRIM(profile.profile_tags) != \'\'
        ;';
        self::query($sql);

        $sql = 'SET @type_playlist = (
            SELECT id_tag_type
            FROM `{tbl_prefix}tags_type`
            WHERE name LIKE \'playlist\'
        );';
        self::query($sql);

        $sql = 'SET @tags_playlist = (SELECT GROUP_CONCAT(`tags`) FROM `{tbl_prefix}playlists` WHERE `tags` IS NOT NULL AND TRIM(`tags`) != \'\');';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tags` (id_tag_type, name)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_playlist) - LENGTH(REPLACE(@tags_playlist, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                @type_playlist
                ,SUBSTRING_INDEX(SUBSTRING_INDEX(@tags_playlist, \',\', seq.n + 1), \',\', -1) AS tags
            FROM NumberSequence seq
        ;';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}playlist_tags` (`id_tag`, `id_playlist`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 0 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n <= LENGTH(@tags_playlist) - LENGTH(REPLACE(@tags_playlist, \',\', \'\')) + 1
            )
            SELECT DISTINCT
                tags.id_tag
                ,playlist.playlist_id
            FROM `{tbl_prefix}playlists` playlist
                     CROSS JOIN NumberSequence seq
                     INNER JOIN `{tbl_prefix}tags` tags ON tags.name = SUBSTRING_INDEX(SUBSTRING_INDEX(playlist.tags, \',\', seq.n + 1), \',\', -1) AND tags.id_tag_type = @type_playlist
            WHERE
                playlist.tags IS NOT NULL AND TRIM(playlist.tags) != \'\'
        ;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `tags`;', [
            'table' => 'video',
            'column' => 'tags',
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP COLUMN `photo_tags`;', [
            'table' => 'photos',
            'column' => 'photo_tags',
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `collection_tags`;', [
            'table' => 'collections',
            'column' => 'collection_tags',
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` DROP COLUMN `profile_tags`;', [
            'table' => 'user_profile',
            'column' => 'profile_tags',
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}playlists` DROP COLUMN `tags`;', [
            'table' => 'playlists',
            'column' => 'tags',
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}tags` ADD FULLTEXT KEY `tag` (`name`);', [
            'table' => 'tags',
            'column' => 'name',
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) 
        VALUES (\'clean_orphan_tags\', \'clean_orphan_tags_description\', \'AdminTool::cleanOrphanTags\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('email_tester', [
            'en' => 'Email Tester',
            'fr' => 'Email Testeur'
        ]);

        self::generateTranslation('manage_tags', [
            'en' => 'Manage tags',
            'fr' => 'Gestion des tags'
        ]);

        self::generateTranslation('action', [
            'en' => 'Action',
            'fr' => 'Action'
        ]);

        self::generateTranslation('label', [
            'en' => 'Label',
            'fr' => 'Label'
        ]);

        self::generateTranslation('tag_updated', [
            'en' => 'Tag has been updated',
            'fr' => 'Le tag a été  mis à jour'
        ]);

        self::generateTranslation('tag_deleted', [
            'en' => 'Tag has been deleted',
            'fr' => 'Le tag a été supprimé'
        ]);

        self::generateTranslation('general', [
            'en' => 'General',
            'fr' => 'Général'
        ]);

        self::generateTranslation('confirm_delete_tag', [
            'en' => 'Do you really want delete tag : %s ?',
            'fr' => 'Êtes-vous certains de vouloir supprimer le tag : %s ?'
        ]);

        self::generateTranslation('clean_orphan_tags', [
            'en' => 'Delete orphan tags',
            'fr' => 'Suppression des tags orphelins'
        ]);

        self::generateTranslation('clean_orphan_tags_description', [
            'en' => 'Delete tags which are not related to a video, photo, collection, playlist or user',
            'fr' => 'Supprime les tags qui ne sont pas lié à une video, photo, collection, playlist ou utilisateur'
        ]);

        self::generateTranslation('cannot_delete_tag', [
            'en' => 'You cannot delete this tag',
            'fr' => 'Vous ne pouvez pas supprimer ce tag'
        ]);

        self::generateTranslation('tag_too_short', [
            'en' => 'Tags less than 3 characters are not allowed',
            'fr' => 'Les tags de moins de 3 caractères ne sont pas autorisés'
        ]);

        self::generateTranslation('tag_type', [
            'en' => 'Tag type',
            'fr' => 'Type de tag'
        ]);

        self::generateTranslation('playlist', [
            'en' => 'Playlist',
            'fr' => 'Playlist'
        ]);

        self::generateTranslation('profile', [
            'en' => 'Profile',
            'fr' => 'Profil'
        ]);

    }
}