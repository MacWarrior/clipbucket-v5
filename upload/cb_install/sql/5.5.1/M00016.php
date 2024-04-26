<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00016 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (name, value) VALUES (\'only_keep_max_resolution\', \'no\');';
        self::query($sql);
        self::generateTranslation('only_keep_max_resolution', [
            'en' => 'Only keep max resolution',
            'fr' => 'Conserver uniquement la résolution maximale'
        ]);
    }
}