<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00171 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('cache', [
            'en'=>'cache',
            'fr'=>'cache'
        ]);

        self::generateTranslation('enable_cache', [
            'en'=>'Enable cache',
            'fr'=>'Activer le cache'
        ]);

        self::generateTranslation('enable_cache_authentification', [
            'en'=>'Enable cache authentification',
            'fr'=>'Activer l\'authentification du cache'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`)
            VALUES (\'cache_enable\', \'no\'), (\'cache_auth\', \'no\'), (\'cache_host\', \'\'), (\'cache_password\', \'\'), (\'cache_port\', \'\');';
        self::query($sql);

        $sql='INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (\'reset_cache_label\', \'reset_cache_description\', \'AdminTool::resetCache\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('reset_cache_label', [
            'en'=>'Reset Cache',
            'fr'=>'Réinitialisation du cache'
        ]);

        self::generateTranslation('reset_cache_description', [
            'en'=>'Clear all entries from cache',
            'fr'=>'Vide toutes les entrées du cache'
        ]);
    }
}