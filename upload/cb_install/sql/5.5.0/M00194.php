<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00194 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}config` SET value = \'0\' WHERE `name` = \'activation\' AND `value` = \'\';';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}languages_keys` SET `language_key` = \'videos_details\' WHERE `language_key` = \'videos_Details\';';
        self::query($sql);

        self::generateTranslation('videos_details', [
            'en'    => 'Videos Details',
            'de'    => 'Details zu den Videos',
            'pt-BR' => 'Detalhes dos Vídeos'
        ]);
    }
}