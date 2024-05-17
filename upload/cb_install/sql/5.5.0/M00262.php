<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00262 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES (\'repair_video_duration_label\', \'repair_video_duration_description\', \'AdminTool::repairVideoDuration\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('repair_video_duration_label', [
            'en' => 'Repair video duration',
            'fr' => 'Corrige la durée des vidéos'
        ]);

        self::generateTranslation('repair_video_duration_description', [
            'en' => 'Repair duration of videos with 0 duration',
            'fr' => 'Corrige la durée des vidéos ayant une durée de 0'
        ]);
    }
}