<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    public function start()
    {
        $legacy_columns = self::req('SHOW COLUMNS FROM `{tbl_prefix}video` WHERE Field IN (\'title\', \'description\')');
        if (count($legacy_columns) === 1) {
            throw new \RuntimeException('The video title and description columns must both be present to migrate video translations.');
        }

        self::query('CREATE TABLE IF NOT EXISTS `{tbl_prefix}videos_translations` (
            `videoid` BIGINT(20) NOT NULL,
            `language_id` INT(9) NOT NULL,
            `video_title` TEXT DEFAULT NULL,
            `video_description` TEXT DEFAULT NULL,
            PRIMARY KEY (`videoid`, `language_id`),
            KEY `language_id` (`language_id`),
            FULLTEXT KEY `video_title` (`video_title`),
            FULLTEXT KEY `video_description` (`video_description`, `video_title`),
            FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE,
            FOREIGN KEY (`language_id`) REFERENCES `{tbl_prefix}languages` (`language_id`) ON DELETE CASCADE
        ) ');

        if (!$legacy_columns) {
            return;
        }

        $legacy_schema = ['table' => 'video', 'columns' => ['title', 'description']];

        self::query('LOCK TABLES `{tbl_prefix}video` WRITE, `{tbl_prefix}videos_translations` WRITE, `{tbl_prefix}languages` READ, `{tbl_prefix}videos_translations` AS translation READ');
        try {
            $defaults = self::req('SELECT language_id FROM `{tbl_prefix}languages` WHERE language_default = \'yes\'');
            if (count($defaults) !== 1) {
                throw new \RuntimeException('Exactly one default language is required to migrate video translations.');
            }
            $language_id = (int)$defaults[0]['language_id'];

            self::constrainedQuery('INSERT INTO `{tbl_prefix}videos_translations` (videoid, language_id, video_title, video_description)
                SELECT `{tbl_prefix}video`.videoid, ' . $language_id . ', title, description
                FROM `{tbl_prefix}video`
                LEFT JOIN `{tbl_prefix}videos_translations` AS translation
                    ON translation.videoid = `{tbl_prefix}video`.videoid AND translation.language_id = ' . $language_id . '
                WHERE translation.videoid IS NULL', $legacy_schema);

            $unverified = self::req('SELECT `{tbl_prefix}video`.videoid FROM `{tbl_prefix}video`
                LEFT JOIN `{tbl_prefix}videos_translations` AS translation
                    ON translation.videoid = `{tbl_prefix}video`.videoid AND translation.language_id = ' . $language_id . '
                WHERE translation.videoid IS NULL
                    OR NOT (translation.video_title <=> title)
                    OR NOT (translation.video_description <=> description)
                LIMIT 1');
            if ($unverified) {
                throw new \RuntimeException('The copied translation differs from the legacy values for video ' . $unverified[0]['videoid'] . '.');
            }

            self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP INDEX `description`, DROP INDEX `title`, DROP COLUMN `title`, DROP COLUMN `description`', $legacy_schema);
        } finally {
            self::query('UNLOCK TABLES');
        }
    }
}
