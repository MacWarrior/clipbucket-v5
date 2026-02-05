<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

require_once \DirPath::get('classes') . 'video_thumbs.class.php';
class M00024 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` CHANGE `file_type` `file_type` VARCHAR(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NULL DEFAULT NULL',[
            'table' => 'video'
            , 'column' => 'file_type'
        ]);

        self::generateTranslation('bps', [
            'fr'=>'bit/s',
            'en'=>'bit/s'
        ]);

        self::generateTranslation('hz', [
            'fr'=>'Hz',
            'en'=>'Hz'
        ]);

        self::generateTranslation('fps', [
            'fr'=>'image/s',
            'en'=>'frame/s'
        ]);

        self::generateConfig('video_thumbs_format', 'webp');

        self::generateTranslation('option_video_thumbs_format', [
            'fr'=>'Format des vignettes vidéo',
            'en'=>'Video thumbs format'
        ]);
    }
}
