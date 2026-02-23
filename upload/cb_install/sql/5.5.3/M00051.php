<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00051 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('option_enable_profiling', [
            'fr'=>'Activer le profiling PHP',
            'en'=>'Enable PHP profiling'
        ]);

        self::generateTranslation('option_profiling_db_host', [
            'fr'=>'Hôte',
            'en'=>'Host'
        ]);

        self::generateTranslation('option_profiling_db_name', [
            'fr'=>'Base de donnée',
            'en'=>'Database'
        ]);

        self::generateTranslation('option_profiling_db_user', [
            'fr'=>'Utilisateur',
            'en'=>'User'
        ]);

        self::generateTranslation('option_profiling_db_password', [
            'fr'=>'Mot de passe',
            'en'=>'Password'
        ]);

        self::generateTranslation('option_profiling_db_port', [
            'fr'=>'Port',
            'en'=>'Port'
        ]);

        self::generateTranslation('option_profiling_hidden_tips', [
            'fr'=>'Les éléments de connexion sont masqués pour des raisons de sécurité',
            'en'=>'Connection details are hidden for security reasons'
        ]);

        self::generateTranslation('option_profiling_tips', [
            'fr'=>'Stocke les données de profiling dans une BDD MySQL',
            'en'=>'Store profiling data in MySQL database'
        ]);

        self::generateTranslation('option_profiling_error', [
            'fr'=>'Une erreur est survenue lors de l\'activation du profiling : %s',
            'en'=>'An issue occured during profiling activation : %s'
        ]);

        self::generateTranslation('warning_profiling_requirements', [
            'fr'=>'Le profiling nécessite l\'extension Xhprof',
            'en'=>'Profiling requires Xhprof extension'
        ]);
    }
}
