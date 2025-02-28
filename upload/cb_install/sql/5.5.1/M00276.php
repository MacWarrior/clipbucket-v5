<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00276 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $configs = [
            'max_video_tags'
            ,'min_video_tags'
        ];
        foreach($configs as $config_name){
            self::deleteConfig($config_name);
        }

        self::generateConfig('enable_video_thumbs_preview', 'no');
        self::generateConfig('video_thumbs_preview_count', '10');

        self::generateTranslation('option_enable_video_thumbs_preview', [
            'fr' => 'Activer la prévisualisation vidéo dans la vignette',
            'en' => 'Enable video thumbs preview',
        ]);
        self::generateTranslation('option_video_thumbs_preview_count', [
            'fr' => 'Nombre de vignettes de prévisualisation vidéo',
            'en' => 'Number of video preview thumbs',
        ]);
    }
}
