<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00306 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'enable_quicklist\', \'yes\');';
        self::query($sql);

        self::generateTranslation('option_enable_quicklist', [
            'en' => 'Enable quicklist',
            'fr' => 'Activer la quicklist'
        ]);

        $sql = 'UPDATE `{tbl_prefix}video` SET `age_restriction` = NULL WHERE `age_restriction` = \'0\';';
        self::query($sql);
    }
}