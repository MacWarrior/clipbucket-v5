<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00096 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_video_bloc_style', [
            'fr' => 'Style du bloc vidéo',
            'en' => 'Video bloc style'
        ]);

        self::deleteTranslation('channel_video_style');

        self::generateConfig('videos_video_style', 'classic');
    }

}
