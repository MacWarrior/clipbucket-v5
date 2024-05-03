<?php

namespace V5_4_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00114 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_resolution` (
            `id_video_resolution` INT(11) NOT NULL ,
            `title` VARCHAR(32) NOT NULL DEFAULT \'\',
            `ratio` VARCHAR(8) NOT NULL DEFAULT \'\',
            `enabled` TINYINT(1) NOT NULL DEFAULT 1,
            `width` INT(11) UNSIGNED NOT NULL DEFAULT 0,
            `height` INT(11) UNSIGNED NOT NULL DEFAULT 0,
            `video_bitrate` INT(10) UNSIGNED NOT NULL DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_resolution` ADD PRIMARY KEY (`id_video_resolution`);', [
            'table'  => 'video_resolution',
            'column' => 'id_video_resolution'
        ], [
            'constraint_type' => 'PRIMARY KEY',
            'constraint_name' => 'id_video_resolution'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_resolution` ADD UNIQUE KEY `title` (`title`);', [
            'table'  => 'video_resolution',
            'column' => 'title'
        ], [
            'constraint_name' => 'title',
            'constraint_type' => 'UNIQUE'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_resolution` MODIFY `id_video_resolution` INT(11) NOT NULL AUTO_INCREMENT;', [
            'table'  => 'video_resolution',
            'column' => 'id_video_resolution'
        ]);

        $sql = 'INSERT INTO `{tbl_prefix}video_resolution` (`title`, `ratio`, `enabled`, `width`, `height`, `video_bitrate`) VALUES
        (\'240p\', \'16/9\', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'cb_combo_res\') = \'no\' THEN 0 ELSE (SELECT CASE WHEN value = \'yes\' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = \'gen_240\') END), 428, 240, (CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_240\') IS NULL THEN \'240000\' ELSE (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_240\') END)),
        (\'360p\', \'16/9\', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'cb_combo_res\') = \'no\' THEN 1 ELSE (SELECT CASE WHEN value = \'yes\' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = \'gen_360\') END), 640, 360, (CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_360\') IS NULL THEN \'400000\' ELSE (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_360\') END)),
        (\'480p\', \'16/9\', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'cb_combo_res\') = \'no\' THEN 0 ELSE (SELECT CASE WHEN value = \'yes\' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = \'gen_480\') END), 854, 480, (CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_480\') IS NULL THEN \'700000\' ELSE (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_480\') END)),
        (\'720p\', \'16/9\', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'cb_combo_res\') = \'no\' THEN 1 ELSE (SELECT CASE WHEN value = \'yes\' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = \'gen_720\') END), 1280, 720, (CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_720\') IS NULL THEN \'2500000\' ELSE (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_720\') END)),
        (\'1080p\', \'16/9\', (SELECT CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'cb_combo_res\') = \'no\' THEN 0 ELSE (SELECT CASE WHEN value = \'yes\' THEN 1 ELSE 0 END FROM `{tbl_prefix}config` WHERE name = \'gen_1080\') END), 1920, 1080, (CASE WHEN (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_1080\') IS NULL THEN \'4096000\' ELSE (SELECT value FROM `{tbl_prefix}config` WHERE name = \'vbrate_1080\') END)),
        (\'1440p\', \'16/9\', 0, 2560, 1440, 7280000),
        (\'2160p\', \'16/9\', 0, 4096, 2160, 17472000);';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name IN(\'gen_240\',\'gen_360\',\'gen_480\',\'gen_720\',\'gen_1080\',\'cb_combo_res\',\'vbrate\',\'vbrate_hd\',\'vbrate_240\',\'vbrate_360\',\'vbrate_480\',\'vbrate_720\',\'vbrate_1080\');';
        self::query($sql);
    }
}