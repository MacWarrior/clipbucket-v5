<?php

require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00019 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        self::generateTranslation('add_more', ['fr'=>'Rajouter']);
    }
}