<?php

require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration'.DIRECTORY_SEPARATOR.'migration.class.php';
class P1_0_1 extends Migration {
    public function __construct()
    {
        parent::__construct();
        $this->migration = function () {
            DiscordLog::sendDump('plugin');
        };
    }
}