<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00043 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('page_order_has_been_updated', [
            'fr'=>'L\'ordre des pages a été mis à jour.',
            'en'=>'Page order has been updated.'
        ]);
    }
}
