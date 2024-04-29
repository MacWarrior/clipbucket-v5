<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00104 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}playlists` MODIFY COLUMN `description` MEDIUMTEXT NOT NULL, MODIFY COLUMN `tags` MEDIUMTEXT NOT NULL;', [
            'table'   => '{tbl_prefix}playlists',
            'columns' => [
                'description',
                'tags'
            ],
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users` MODIFY COLUMN `featured_video` MEDIUMTEXT NOT NULL;', [
            'table'  => '{tbl_prefix}users',
            'column' => 'featured_video',
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_categories` MODIFY COLUMN `category_thumb` MEDIUMTEXT NOT NULL;', [
            'table'  => '{tbl_prefix}user_categories',
            'column' => 'category_thumb'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `flv`, MODIFY COLUMN `voter_ids` MEDIUMTEXT NOT NULL, MODIFY COLUMN `featured_description` MEDIUMTEXT NOT NULL;', [
            'table'   => '{tbl_prefix}video',
            'columns' => [
                'flv',
                'voter_ids',
                'description'
            ]
        ]);
    }
}