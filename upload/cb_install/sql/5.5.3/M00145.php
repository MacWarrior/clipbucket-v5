<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00145 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('continue', [
            'fr' => 'Continuer',
            'en' => 'Continue'
        ]);
        self::generateTranslation('cant_upload_subtitle_until_video_is_converted', [
            'fr'=>'Vous ne pouvez pas téléverser de soustitre tant que la vidéo n\'est pas convertie',
            'en'=>'You cannot upload subtitles until the video is converted'
        ]);
        self::generateTranslation('video_isnt_saved_yet', [
            'fr'=>'La vidéo n\'a pas encore été sauvegardée !',
            'en'=>'Video hasn\'t been saved yet !'
        ]);
    }
}
