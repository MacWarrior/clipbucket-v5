<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('changelog', [
            'fr'=>'Changelog',
            'en'=>'Changelog'
        ]);

        self::generateTranslation('older_versions', [
            'fr'=>'Anciennes versions',
            'en'=>'Older versions'
        ]);
    }
}
