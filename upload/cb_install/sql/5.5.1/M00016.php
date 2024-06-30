<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00016 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('only_keep_max_resolution', 'no');

        self::generateTranslation('only_keep_max_resolution', [
            'en' => 'Only keep max resolution',
            'fr' => 'Conserver uniquement la résolution maximale'
        ]);
    }
}