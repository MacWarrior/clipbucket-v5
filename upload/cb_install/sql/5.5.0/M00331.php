<?php

namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00331 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}categories`
        (
            `category_id`      INT(255)          NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `parent_id`        INT(255)          NULL     DEFAULT NULL,
            `id_category_type` INT(255)          NOT NULL,
            `category_name`    VARCHAR(30)       NOT NULL DEFAULT \'\',
            `category_order`   INT(5)            NOT NULL DEFAULT 0,
            `category_desc`    TEXT              NULL     DEFAULT NULL,
            `date_added`       DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `category_thumb`   MEDIUMTEXT        NULL,
            `is_default`       ENUM (\'yes\',\'no\') NOT NULL DEFAULT \'no\',
            `old_category_id`  INT(255) NULL
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        self::alterTable('ALTER TABLE `{tbl_prefix}categories` ADD FULLTEXT KEY `categorie` (`category_name`);', [
            'table'  => 'categories',
            'column' => 'category_name'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}categories_type`
        (
            `id_category_type` INT         NOT NULL AUTO_INCREMENT,
            `name`             VARCHAR(32) NOT NULL,
            PRIMARY KEY (`id_category_type`)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}categories` ADD CONSTRAINT `categorie_type` FOREIGN KEY (`id_category_type`) REFERENCES `{tbl_prefix}categories_type` (`id_category_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'categories',
            'column' => 'id_category_type'
        ], [
            'constraint_name'  => 'categorie_type',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}videos_categories`
            (
                `id_video`    BIGINT NOT NULL,
                `id_category` INT    NOT NULL,
                PRIMARY KEY (`id_video`, `id_category`)
            ) ENGINE = InnoDB
              DEFAULT CHARSET = utf8mb4
              COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}videos_categories` ADD CONSTRAINT `video_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'videos_categories',
            'column' => 'id_category'
        ], [
            'constraint_name'  => 'video_categories_category',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}videos_categories` ADD CONSTRAINT `video_categories_video` FOREIGN KEY (`id_video`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'videos_categories',
            'column' => 'id_video'
        ], [
            'constraint_name'  => 'video_categories_video',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}photos_categories`
            (
                `id_photo`    BIGINT NOT NULL,
                `id_category` INT    NOT NULL,
                PRIMARY KEY (`id_photo`, `id_category`)
            ) ENGINE = InnoDB
              DEFAULT CHARSET = utf8mb4
              COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}photos_categories` ADD CONSTRAINT `photo_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'photos_categories',
            'column' => 'id_category'
        ], [
            'constraint_name'  => 'photo_categories_category',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}photos_categories` ADD CONSTRAINT `photo_categories_photo` FOREIGN KEY (`id_photo`) REFERENCES `{tbl_prefix}photos` (`photo_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'photos_categories',
            'column' => 'id_photo'
        ], [
            'constraint_name'  => 'photo_categories_photo',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}collections_categories`
            (
                `id_collection` BIGINT NOT NULL,
                `id_category`   INT    NOT NULL,
                PRIMARY KEY (`id_collection`, `id_category`)
            ) ENGINE = InnoDB
              DEFAULT CHARSET = utf8mb4
              COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections_categories` ADD CONSTRAINT `collection_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'collections_categories',
            'column' => 'id_category'
        ], [
            'constraint_name'  => 'collection_categories_category',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections_categories` ADD CONSTRAINT `collection_categories_collection` FOREIGN KEY (`id_collection`) REFERENCES `{tbl_prefix}collections` (`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'collections_categories',
            'column' => 'id_collection'
        ], [
            'constraint_name'  => 'collection_categories_collection',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}users_categories`
            (
                `id_user`     BIGINT NOT NULL,
                `id_category` INT    NOT NULL,
                PRIMARY KEY (`id_user`, `id_category`)
            ) ENGINE = InnoDB
              DEFAULT CHARSET = utf8mb4
              COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}users_categories` ADD CONSTRAINT `user_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'user_categories',
            'column' => 'id_category'
        ], [
            'constraint_name'  => 'user_categories_category',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users_categories` ADD CONSTRAINT `user_categories_profile` FOREIGN KEY (`id_user`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'user_categories',
            'column' => 'id_user'
        ], [
            'constraint_name'  => 'user_categories_profile',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}playlists_categories`
            (
                `id_playlist` INT NOT NULL,
                `id_category` INT NOT NULL,
                PRIMARY KEY (`id_playlist`, `id_category`)
            ) ENGINE = InnoDB
              DEFAULT CHARSET = utf8mb4
              COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}playlists_categories` ADD CONSTRAINT `playlist_categories_category` FOREIGN KEY (`id_category`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'playlists_categories',
            'column' => 'id_category'
        ], [
            'constraint_name'  => 'playlist_categories_category',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}playlists_categories` ADD CONSTRAINT `playlist_categories_playlist` FOREIGN KEY (`id_playlist`) REFERENCES `{tbl_prefix}playlists` (`playlist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;', [
            'table'  => 'playlists_categories',
            'column' => 'id_playlist'
        ], [
            'constraint_name'  => 'playlist_categories_playlist',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        $sql = 'INSERT INTO `{tbl_prefix}categories_type` (`name`) VALUES (\'video\'), (\'photo\'), (\'collection\'), (\'user\'), (\'playlist\');';
        self::query($sql);

        /** Collections */
        $sql = 'SET @type_category = ( SELECT id_category_type FROM `{tbl_prefix}categories_type` WHERE name LIKE \'collection\' );';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}categories` (id_category_type, parent_id, category_name, category_order, category_desc, date_added, category_thumb, is_default, old_category_id) 
                SELECT @type_category, CASE WHEN parent_id = \'0\' OR parent_id = category_id THEN NULL ELSE parent_id END, category_name,
                     category_order, category_desc, date_added, category_thumb, isdefault, category_id
                  FROM `{tbl_prefix}collection_categories`
                  WHERE 1;';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}collections_categories` (`id_category`, `id_collection`)
                WITH RECURSIVE NumberSequence AS (
                    SELECT 1 AS n
                    UNION ALL
                    SELECT n + 1
                    FROM NumberSequence
                    WHERE n < (SELECT COUNT(*) FROM `{tbl_prefix}collection_categories`)
                )
                SELECT
                    SUBSTRING_INDEX(SUBSTRING_INDEX(C.category, \'#\', seq.n+1), \'#\', -1) AS extracted_number
                     ,C.collection_id
                FROM
                    `{tbl_prefix}collections` C
                    JOIN NumberSequence seq ON seq.n < LENGTH(C.category)-LENGTH(REPLACE(C.category, \'#\', \'\'))+1
                WHERE
                    C.category IS NOT NULL
                    AND C.category != \'\'
                    AND SUBSTRING_INDEX(SUBSTRING_INDEX(C.category, \'#\', seq.n+1), \'#\', -1) != \'\';';
        self::query($sql);

        /** Vidéos */
        $sql = 'SET @type_category = ( SELECT id_category_type FROM `{tbl_prefix}categories_type` WHERE name LIKE \'video\' );';
        self::query($sql);

        $sql = 'SET @id_categ = (
                SELECT max(category_id)
                FROM `{tbl_prefix}categories`
                WHERE 1
            );';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}categories` (category_id, id_category_type, parent_id, category_name, category_order, category_desc, date_added, category_thumb, is_default, old_category_id) 
                SELECT category_id+@id_categ AS category_id, @type_category, CASE WHEN parent_id = \'0\' OR parent_id = category_id  THEN NULL ELSE parent_id END , category_name, category_order, category_desc, date_added, category_thumb, isdefault, category_id
                FROM `{tbl_prefix}video_categories`
                WHERE 1;';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}videos_categories` (`id_category`, `id_video`)
        WITH RECURSIVE NumberSequence AS (
            SELECT 1 AS n
            UNION ALL
            SELECT n + 1
            FROM NumberSequence
            WHERE n < (SELECT COUNT(*) FROM `{tbl_prefix}video_categories`)
        )
        SELECT
            SUBSTRING_INDEX(SUBSTRING_INDEX(V.category, \'#\', seq.n+1), \'#\', -1) + @id_categ AS extracted_number
            ,V.videoid
        FROM
            `{tbl_prefix}video` V
            JOIN NumberSequence seq ON seq.n < LENGTH(V.category)-LENGTH(REPLACE(V.category, \'#\', \'\'))+1
        WHERE
            V.category IS NOT NULL
          AND V.category != \'\'
          AND SUBSTRING_INDEX(SUBSTRING_INDEX(V.category, \'#\', seq.n+1), \'#\', -1) != \'\';';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}videos_categories` (`id_category`, `id_video`)
            SELECT C.category_id, V.videoid
            FROM `{tbl_prefix}video` V , `{tbl_prefix}categories` C
            WHERE (V.category IS NULL OR V.category = \'\') AND C.is_default = \'yes\' AND C.id_category_type = @type_category;';
        self::query($sql);

        /** Users */
        $sql = 'SET @type_category = (
            SELECT id_category_type
            FROM `{tbl_prefix}categories_type`
            WHERE name LIKE \'user\'
        );';
        self::query($sql);
        $sql = 'SET @id_categ = (
                SELECT max(category_id)
                FROM `{tbl_prefix}categories`
                WHERE 1
            );';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}categories` (category_id, id_category_type, parent_id, category_name, category_order, category_desc, date_added, category_thumb, is_default)
            SELECT category_id+@id_categ AS category_id, @type_category, NULL, category_name, category_order, category_desc, date_added, category_thumb, isdefault
            FROM `{tbl_prefix}user_categories`
            WHERE 1;';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}users_categories` (`id_category`, `id_user`)
            WITH RECURSIVE NumberSequence AS (
                SELECT 1 AS n
                UNION ALL
                SELECT n + 1
                FROM NumberSequence
                WHERE n < (SELECT COUNT(*) FROM `{tbl_prefix}user_categories`)
            )
            SELECT
                SUBSTRING_INDEX(SUBSTRING_INDEX(U.category, \'#\', seq.n+1), \'#\', -1) + @id_categ AS extracted_number
                 ,U.userid
            FROM
                `{tbl_prefix}users` U
                JOIN NumberSequence seq ON seq.n < LENGTH(U.category)-LENGTH(REPLACE(U.category, \'#\', \'\'))+1
            WHERE
                U.category IS NOT NULL
              AND U.category != \'\'
              AND SUBSTRING_INDEX(SUBSTRING_INDEX(U.category, \'#\', seq.n+1), \'#\', -1) != \'\';';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}categories` C
            INNER JOIN `{tbl_prefix}categories` CP ON CP.old_category_id = C.parent_id AND CP.id_category_type = C.id_category_type
        SET C.parent_id = CP.category_id
        WHERE C.parent_id != 0 AND C.parent_id IS NOT NULL;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}categories` ADD CONSTRAINT `categorie_parent` FOREIGN KEY (`parent_id`) REFERENCES `{tbl_prefix}categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'categories',
            'column' => 'parent_id'
        ], [
            'constraint_name' => 'categorie_parent',
            'constraint_type' => 'FOREIGN KEY'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` DROP COLUMN `category`;', [
            'table'  => 'collections',
            'column' => 'category'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}playlists` DROP COLUMN `category`;', [
            'table'  => 'playlists',
            'column' => 'category'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}users` DROP COLUMN `category`;', [
            'table'  => 'users',
            'column' => 'category'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `category`;', [
            'table'  => 'video',
            'column' => 'category'
        ]);

        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}collection_categories`;';
        self::query($sql);
        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}user_categories`;';
        self::query($sql);
        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}video_categories`;';
        self::query($sql);
    }
}