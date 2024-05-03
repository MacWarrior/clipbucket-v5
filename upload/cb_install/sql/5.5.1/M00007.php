<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00007 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'ALTER TABLE `' . tbl('tools_histo_log') . '`
            CHANGE `message` `message` VARCHAR(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;';
        self::query($sql);
    }
}