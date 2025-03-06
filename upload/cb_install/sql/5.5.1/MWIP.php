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
      self::generateTranslation('most_old', [
          'fr'=>'Plus Ancien',
          'en'=>'Most Old'
      ]);
    }
}
