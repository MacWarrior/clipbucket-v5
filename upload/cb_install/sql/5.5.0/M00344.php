<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00344 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = \'cat_img_error\');';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;';
        self::query($sql);
        $sql = 'DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;';
        self::query($sql);

        self::generateTranslation('error_allow_photo_types', [
            'en' => 'Only the following image formats are allowed: %s',
            'fr' => 'Seuls les formats d\'image suivants sont autorisés : %s'
        ]);
    }
}