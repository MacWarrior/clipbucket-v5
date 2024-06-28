<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00048 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}config` SET name = \'censored_words\' WHERE name = \'comments_censored_words\'';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}languages_keys` SET language_key = \'option_censored_words\' WHERE language_key = \'option_comments_censored_words\'';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'enable_video_description_censor\', \'no\');';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`) VALUES (\'enable_video_description_link\', \'yes\');';
        self::query($sql);

        self::generateTranslation('option_enable_description_censor', [
            'fr' => 'Activer la censure des descriptions',
            'en' => 'Enable description censor'
        ]);

        self::generateTranslation('option_enable_description_link', [
            'fr' => 'Activer les liens dans la description',
            'en' => 'Enable links in description'
        ]);
    }
}