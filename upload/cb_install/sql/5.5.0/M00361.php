<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00361 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) 
            VALUES (\'recreate_thumb_label\', \'recreate_thumb_description\', \'AdminTool::recreateThumb\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('recreate_thumb_label', [
            'en' => 'Recreate photos thumbs',
            'fr' => 'Régénération des vignettes photos'
        ]);
        self::generateTranslation('recreate_thumb_description', [
            'en' => 'Recreate all photos thumbs',
            'fr' => 'Régénère toutes les vignettes photoss'
        ]);
    }
}