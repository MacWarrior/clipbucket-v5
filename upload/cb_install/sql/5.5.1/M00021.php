<?php

require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00021 extends Migration
{
    public function start()
    {
        DiscordLog::sendDump('toto');
        self::generateTranslation('test_migration', [
            'fr' => 'ceci est un test de migration',
            'en' => 'this is a migration test'
        ]);
    }
}