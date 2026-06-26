<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::updateTranslation('info_upload_subtitle', [
            'fr' => 'Le fichier doit être de type VTT et peser au maximum %s %s',
            'en' => 'File must be in VTT format and maximum %s %s'
        ]);

        //SUBTITLES
        $subtitles = new \GlobIterator(\DirPath::get('subtitles') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.srt');
        foreach ($subtitles as $subtitle) {
            rename($subtitle->getPathname(), str_replace('.srt', '.vtt', $subtitle->getPathname()));
        }
        unset($subtitles);
    }
}
