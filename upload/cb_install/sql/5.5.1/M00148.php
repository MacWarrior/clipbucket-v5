<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00148 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
      self::generateTranslation('add_collection', [
          'fr'=>'Ajouter la collection',
          'en'=>'Add collection'
      ]);
    }
}
