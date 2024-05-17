<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00180 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES (\'reset_video_log_label\', \'reset_video_log_description\', \'AdminTool::resetVideoLog\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('reset_video_log_label', [
            'en' => 'Delete conversion logs',
            'fr' => 'Suppression des logs de conversion'
        ]);

        self::generateTranslation('reset_video_log_description', [
            'en' => 'Delete conversion logs of videos successfully converted',
            'fr' => 'Supprime les logs de conversion des vidéos correctement converties'
        ]);

        self::generateTranslation('no_conversion_log', [
            'en' => 'No conversion log file available',
            'fr' => 'Aucun fichier de log disponible'
        ]);

        self::generateTranslation('watch_conversion_log', [
            'en' => 'See Conversion log',
            'fr' => 'Voir le log de conversion'
        ]);

        self::generateTranslation('conversion_log', [
            'en' => 'Conversion log',
            'fr' => 'Log de conversion'
        ]);
    }
}