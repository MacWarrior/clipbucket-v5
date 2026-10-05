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
        self::generateTranslation('extracted_thumb_not_available_yet', [
            'fr'=>'Les vignettes extraites ne sont pas encore disponible, en attente du processus de conversion...',
            'en'=>'Extracted thumbs aren’t available yet, waiting for conversion process...'
        ]);
    }
}
