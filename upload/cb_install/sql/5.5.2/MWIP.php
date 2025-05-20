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
        self::updateTranslation('add_to_my_collection', [
            'fr'=>'Ajouter à une collection',
            'en'=>'Add to a collection'
        ]);

        $sql = 'UPDATE `{tbl_prefix}collections` SET `public_upload` = \'no\' ';
        self::query($sql);;
    }
}
