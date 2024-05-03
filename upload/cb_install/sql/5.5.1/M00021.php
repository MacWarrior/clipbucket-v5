<?php

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00021 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        DiscordLog::sendDump('toto');
        self::generateTranslation('test_migration', [
            'fr' => 'ceci est un test de \Migration',
            'en' => 'this is a \Migration test'
        ]);
    }
}