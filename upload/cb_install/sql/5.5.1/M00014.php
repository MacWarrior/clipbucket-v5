<?php

require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration'.DIRECTORY_SEPARATOR.'migration.class.php';
class M00014 extends Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->migration = function () {
            $sql = 'ALTER TABLE `'.tbl('tools_histo_status').'` ADD UNIQUE IF NOT EXISTS(`language_key_title`);';
            Clipbucket_db::getInstance()->execute($sql);

            DiscordLog::sendDump('toto');
        };
    }
}