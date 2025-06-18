<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00077 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('channel_video_style', 'classic');
        self::generateTranslation('channel_video_style', [
            'fr'=>'Style des vidéos de la chaine'
            ,'en'=>'Channel video style'
        ]);
    }
}
