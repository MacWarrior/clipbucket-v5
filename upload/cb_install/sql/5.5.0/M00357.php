<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00357 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` ( `language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (\'clean_session_table_label\', \'clean_session_table_description\', \'AdminTool::cleanSessionTable\', 1, NULL, NULL);';
        self::query($sql);
        self::generateTranslation('clean_session_table_label', [
            'en' => 'Clean session table',
            'fr' => 'Nettoyage de la table des sessions'
        ]);
        self::generateTranslation('clean_session_table_description', [
            'en' => 'Delete table sessions entries older than one month',
            'fr' => 'Supprime les lignes de la table session datant de plus d\'un mois'
        ]);
    }
}