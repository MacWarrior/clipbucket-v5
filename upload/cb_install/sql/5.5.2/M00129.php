<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00129 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('log_file_doesnt_exist', [
            'fr' => 'Le fichier de log n\'existe pas',
            'en' => 'Log file does not exist'
        ]);

        self::generateTranslation('tool_disabled', [
            'fr' => 'Cet outil est désactivé',
            'en' => 'This tool is disabled'
        ]);

        $sql_update = 'UPDATE ' . tbl('tools_histo') . ' SET id_tools_histo_status = 1 WHERE id_tool IN(SELECT id_tool FROM ' . tbl('tools') . ' WHERE code = \'calc_user_storage\') AND id_tools_histo_status != 1;';
        self::query($sql_update);;
    }
}
