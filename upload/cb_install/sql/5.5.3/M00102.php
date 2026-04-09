<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00102 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
      self::generateTranslation('template_compatible', [
          'fr'=>'Le thème est compatible avec la version actuelle de Clipbucket',
          'en'=>'Template is compatible with current Clipbucket version'
      ]);

      self::generateTranslation('template_not_compatible', [
          'fr'=>'Le thème est potentiellement incompatible avec la version actuelle de Clipbucket',
          'en'=>'Template might not be compatible with current Clipbucket version'
      ]);

      self::generateTranslation('compatibility', [
          'fr'=>'Compatibilité',
          'en'=>'Compatibility'
      ]);

      self::generateTranslation('unknown', [
          'fr'=>'Inconnue',
          'en'=>'Unknown'
      ]);
    }
}
