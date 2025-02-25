<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00273 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_360_video', 'no');

        self::generateTranslation('option_enable_360_video', [
            'fr'=>'Activer le support des vidéos 360°',
            'en'=>'Enable 360° video support'
        ]);
        self::generateTranslation('x_fov', [
            'fr'=>'%s°',
            'en'=>'%s°'
        ]);
        self::generateTranslation('video_fov', [
            'fr'=>'Champ de vision',
            'en'=>'Field of view'
        ]);

        self::alterTable(/** @lang MySQL */'ALTER TABLE `{tbl_prefix}video` ADD COLUMN `fov` varchar(3) NULL DEFAULT NULL', [
            'table' => 'video'
        ], [
            'table'  => 'video',
            'column' => 'fov'
        ]);
    }
}
