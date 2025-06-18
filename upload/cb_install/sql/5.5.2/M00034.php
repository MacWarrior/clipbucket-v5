<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00034 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::query('INSERT IGNORE INTO ' . tbl('sorts') .' ( `label`, `type`, is_default) VALUES 
            (\'alphabetical\', \'videos\', false),
            (\'alphabetical\', \'photos\', false),
            (\'alphabetical\', \'collections\', false),
            (\'alphabetical\', \'channels\', false),
            (\'reverse_alphabetical\', \'videos\', false),
            (\'reverse_alphabetical\', \'photos\', false),
            (\'reverse_alphabetical\', \'collections\', false),
            (\'reverse_alphabetical\', \'channels\', false);
        ');

        self::generateTranslation('sort_by_alphabetical', [
            'fr'=>'Alphabétique',
            'en'=>'Alpbabetical'
        ]);

        self::generateTranslation('sort_by_reverse_alphabetical', [
            'fr'=>'Alphabétique inversé',
            'en'=>'Reverse alpbabetical'
        ]);
    }
}
