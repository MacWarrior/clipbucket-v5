<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00123 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}languages` (`language_id`, `language_code`, `language_name`, `language_regex`, `language_active`, `language_default`) VALUES
            (4, \'pt-BR\', \'Portuguesa\', \'/^pt-BR/i\', \'yes\', \'no\');';
        self::query($sql);
    }
}