<?php
namespace V5_4_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00039 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video_categories`
            MODIFY COLUMN `category_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            MODIFY COLUMN `category_thumb` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;', [
            'table'   => 'video_categories',
            'columns' => [
                'category_desc',
                'date_added',
                'category_thumb'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collection_categories`
            MODIFY COLUMN `category_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `category_order` INT(5) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `category_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            MODIFY COLUMN `category_thumb` MEDIUMINT(9) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `isdefault` ENUM(\'yes\',\'no\') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'no\';',
            [
                'table'   => 'collection_categories',
                'columns' => [
                    'category_name',
                    'category_order',
                    'category_desc',
                    'date_added',
                    'category_thumb',
                    'isdefault'
                ]
            ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}playlists`
            MODIFY COLUMN `playlist_name` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `userid` INT(11) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `playlist_type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'\',
            MODIFY COLUMN `description` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `tags` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `total_comments` INT(255) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `total_items` INT(255) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `rating` INT(3) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `rated_by` INT(255) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `voters` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `last_update` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `runtime` INT(200) NOT NULL DEFAULT \'0\',
            MODIFY COLUMN `first_item` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `cover` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            MODIFY COLUMN `played` INT(255) NOT NULL DEFAULT \'0\';', [
            'table'   => 'playlists',
            'columns' => [
                'playlist_name',
                'userid',
                'playlist_type',
                'description',
                'tags',
                'total_comments',
                'total_items',
                'rating',
                'rated_by',
                'voters',
                'last_update',
                'runtime',
                'first_item',
                'cover',
                'played'
            ]
        ]);
    }
}