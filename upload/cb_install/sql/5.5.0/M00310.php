<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00310 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'hide_empty_collection\', \'no\');';
        self::query($sql);

        self::generateTranslation('option_hide_empty_collection', [
            'en' => 'Hide empty collections',
            'fr' => 'Masquer les collections vides'
        ]);
    }
}