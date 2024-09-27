<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00141 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('will_be_upload_into_collection', [
            'fr'=>'Les %s seront téléversées dans la collection <strong><i>%s</i></strong>',
            'en'=>'%s will be upload into <strong><i>%s</i></strong> collection'
        ]);
    }
}
