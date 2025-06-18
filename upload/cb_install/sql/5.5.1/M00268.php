<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00268 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateConfig('allow_tag_space', 'no');

       self::generateTranslation('allow_tag_space', [
           'fr'=>'Autoriser les espaces dans les tags',
           'en'=>'Allow spaces in tags'
       ]);

       self::generateTranslation('use_tab_tag', [
           'fr'=>'Utilisez la touche "Tab" pour passer au mot clé suivant',
           'en'=>'Use "Tab" key to switch to next tag'
       ]);
    }
}
