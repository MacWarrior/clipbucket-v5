<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00167 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`id_tool`, `language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (1, \'generate_missing_thumbs_label\', \'generate_missing_thumbs_description\', \'AdminTool::generateMissingThumbs\', 1, NULL, NULL);';
        self::query($sql);
    }
}