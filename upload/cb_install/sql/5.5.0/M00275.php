<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00275 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'en\');';
        self::query($sql);
        $sql = 'SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'fr\');';
        self::query($sql);
        $sql = 'SET @language_key = \'clean_orphan_files_description\' COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations`
            SET `translation` = \'Delete videos, photos, subtitles, thumbs, logs, userfeeds which are not related to entries in database\'
            WHERE `id_language_key` = @id_language_key AND `language_id` = @language_id_eng;';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations`
            SET `translation` = \'Supprime les vidéos, photos, sous-titres, miniatures, logs et activités qui ne sont pas liés à une entrée de la base de données\'
            WHERE `id_language_key` = @id_language_key AND `language_id` = @language_id_fra;';
        self::query($sql);
    }
}