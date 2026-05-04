<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP2 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `id_tmdb`;', [
            'table'  => 'video_tmdb',
            'column' => 'id_tmdb'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `type_tmdb`;', [
            'table'  => 'video_tmdb',
            'column' => 'type_tmdb'
        ]);
    }
}
