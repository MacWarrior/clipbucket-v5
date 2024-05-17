<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00322 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_enable_sitemap', [
            'en' => 'Enable sitemap',
            'fr' => 'Activer le sitemap'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'enable_sitemap\', \'yes\');';
        self::query($sql);
    }
}