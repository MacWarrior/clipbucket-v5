<?php

namespace V5_1_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00001 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('chromecast_fix', '1');
        self::generateConfig('allowed_photo_types', 'jpg,jpeg,png');

        $sql = 'UPDATE `{tbl_prefix}config` SET name = \'allowed_video_types\' WHERE name = \'allowed_types\';';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name = \'users_items_subscribers\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}config` SET value = CONCAT(value, \',mkv\') WHERE name = \'allowed_video_types\' AND value NOT LIKE \'%mkv%\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}config` SET value = CONCAT(value, \',webm\') WHERE name = \'allowed_video_types\' AND value NOT LIKE \'%webm%\';';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE name IN(
            \'max_topic_title\',
            \'max_topic_length\',
            \'groups_list_per_page\',
            \'grps_items_search_page\',
            \'users_items_group_page\',
            \'videos_items_grp_page\');';
        self::query($sql);
    }
}