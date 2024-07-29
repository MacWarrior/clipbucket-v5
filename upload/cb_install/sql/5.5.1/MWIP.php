<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        execute_sql_file(\DirPath::get('cb_install') . DIRECTORY_SEPARATOR . 'sql' .DIRECTORY_SEPARATOR . 'add_anonymous_user.sql');

        self::generateTranslation('anonymous_locked', [
            'fr'=>'L\'utilisateur anonyme est verrouillé',
            'en'=>'Anonymous user is locked'
        ]);
        self::generateTranslation('anonymous', [
            'fr'=>'Anonyme',
            'en'=>'Anonymous'
        ]);
    }
}
