<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00168 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (\'update_castable_status_label\', \'update_castable_status_description\', \'AdminTool::updateCastableStatus\', 1, NULL, NULL);';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (\'update_bits_color_label\', \'update_bits_color_description\', \'AdminTool::updateBitsColor\', 1, NULL, NULL);';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (\'update_videos_duration_label\', \'update_videos_duration_description\', \'AdminTool::updateVideoDuration\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('update_castable_status_label', [
            'en' => 'Update videos castable status',
            'fr' => 'Mise à jour du statut de diffusion des vidéos'
        ]);

        self::generateTranslation('update_castable_status_description', [
            'en' => 'Update all videos castable status, based on video files',
            'fr' => 'Met à jour le statut de diffusion de toutes les vidéos, en se basant sur les fichiers vidéo'
        ]);

        self::generateTranslation('update_bits_color_label', [
            'en' => 'Update video colors encoding status',
            'fr' => 'Mise à jour du statut d\'encodage des couleurs des vidéos'
        ]);

        self::generateTranslation('update_bits_color_description', [
            'en' => 'Update all videos color encoding status, based on video files',
            'fr' => 'Met à jour le statut d\'encodage des couleurs des vidéos, en se basant sur les fichiers vidéo'
        ]);

        self::generateTranslation('update_videos_duration_label', [
            'en' => 'Update videos durations',
            'fr' => 'Mise à jour des durées des vidéos'
        ]);

        self::generateTranslation('update_videos_duration_description', [
            'en' => 'Update all videos durations, based on video files',
            'fr' => 'Met à jour la durée de toutes les vidéos, en se basant sur les fichiers vidéo'
        ]);

    }
}