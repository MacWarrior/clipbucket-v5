<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00032 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('tmdb_enable_on_front', [
            'fr' => 'Activer TMDB sur le front office',
            'en' => 'Enable TMDB on front end'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'tmdb_enable_on_front_end\', \'no\');';
        self::query($sql);
    }
}