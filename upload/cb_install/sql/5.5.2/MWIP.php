<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('video_title_exceed', [
            'fr'=>'Le titre de la vidéo, %s, dépasse le nombre de caractères autorisés. (%s)',
            'en'=>'Video title, %s, exceeds the maximum length. (%s)'
        ]);
    }

}
