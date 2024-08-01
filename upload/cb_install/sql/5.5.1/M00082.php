<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00082 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::query('set @id_statut_on_error = (SELECT `id_tools_histo_status` FROM ' . tbl('tools_histo_status') .' WHERE language_key_title = \'on_error\');');
        self::query('INSERT IGNORE INTO `' . tbl('tools_histo_status') . '` (`id_tools_histo_status`, `language_key_title`) VALUES (@id_statut_on_error, \'on_error\')' );

        self::generateTranslation('on_error', [
            'fr'=>'En erreur',
            'en'=>'On error'
        ]);
    }
}