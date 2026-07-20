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
       self::alterTable('ALTER TABLE {tbl_prefix}collections ADD COLUMN featured_subitem BOOLEAN DEFAULT FALSE', [
           'table'=>'collections'
       ], [
           'table'=>'collections',
           'column'=>'featured_subitem'
       ]);
        self::generateTranslation('option_featured_subitem', [
            'fr'=>'Sous-éléments en vedette',
            'en'=>'Featured sub-items'
        ]);
    }
}
