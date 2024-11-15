<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00150 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('permissions', [
           'fr'=>'Permissions',
           'en'=>'Permissions'
       ]);
       self::generateTranslation('writeable', [
           'fr'=>'Accessible en écriture',
           'en'=>'Writeable'
       ]);
       self::generateTranslation('chmod_file', [
           'fr'=>'Veuillez exécuter la commande chmod 755 sur ce fichier/dossier',
           'en'=>'Please chmod this file/directory to 755'
       ]);
    }
}
