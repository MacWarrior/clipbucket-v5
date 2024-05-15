<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00238 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'collect_tag_hint\');';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
    }
}