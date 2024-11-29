<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00198 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

      self::generateTranslation('limit_photo_related', [
          'fr'=>'Quantité de photo similaires',
          'en'=>'Related photos quantity'
      ]);

      self::generateTranslation('related_photos', [
          'fr'=>'Photos similaires'
      ]);

      self::generateConfig('limit_photo_related', 8);
    }
}