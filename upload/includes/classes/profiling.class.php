<?php
class Profiling{

    private static bool $enabled = false;

    public static function isEnabled(): bool
    {
        if( !empty(self::$enabled) ){
            return self::$enabled;
        }

        if( !self::isAvailable() ){
            self::$enabled = false;
        } else {
            if (file_exists(DirPath::get('includes') . 'config_profiling.php')) {
                self::$enabled = true;
            } else {
                self::$enabled = false;
            }
        }

        return self::$enabled;
    }

    public static function enable(string $host = '', string $dbname = '', string $username = '', string $password = '', string $port = ''): bool
    {
        $file_disabled = DirPath::get('includes') . 'config_profiling.php.disabled';
        $file_enabled = DirPath::get('includes') . 'config_profiling.php';
        $file_default = DirPath::get('includes') . 'config_profiling.inc.php';

        if( file_exists($file_disabled) ){
            if( empty($host) && empty($dbname) && empty($username) && empty($password) && empty($port) ){
                $renamed = rename($file_disabled, $file_enabled);
                if( !$renamed ){
                    return false;
                }
                self::$enabled = true;
                return true;
            }
            unlink($file_disabled);
        }

        if( empty($host) && empty($dbname) && empty($username) && empty($password) && empty($port) ){
            return false;
        }

        $profiling_config = file_get_contents($file_default);
        $profiling_config = str_replace('_DB_HOST_', $host, $profiling_config);
        $profiling_config = str_replace('_DB_NAME_', $dbname, $profiling_config);
        $profiling_config = str_replace('_DB_USER_', $username, $profiling_config);
        $profiling_config = str_replace('_DB_PASS_', $password, $profiling_config);
        $profiling_config = str_replace('_DB_PORT_', $port, $profiling_config);

        $fp = fopen($file_enabled, 'w');
        fwrite($fp, $profiling_config);
        fclose($fp);
        self::$enabled = true;
        return true;
    }

    public static function disable(): bool
    {
        $file_disabled = DirPath::get('includes') . 'config_profiling.php.disabled';
        $file_enabled = DirPath::get('includes') . 'config_profiling.php';

        $renamed = rename($file_enabled, $file_disabled);
        if( !$renamed ){
            return false;
        }
        self::$enabled = false;
        return true;
    }

    /**
     * @return void
     * @throws Exception
     */
    public static function load(): void
    {
        require_once DirPath::get('includes') . 'config_profiling.php';

        if( isset($profiling_db_host) &&
            isset($profiling_db_name) &&
            isset($profiling_db_user) &&
            isset($profiling_db_password) &&
            isset($profiling_db_port)
        ) {
            try{
                $profiler = new \Xhgui\Profiler\Profiler([
                    'save.handler' => 'pdo',
                    'pdo' => [
                        'dsn'        => 'mysql:host=' . $profiling_db_host . ';port=' . $profiling_db_port . ';dbname=' . $profiling_db_name . ';charset=utf8mb4',
                        'user'       => $profiling_db_user,
                        'pass'       => $profiling_db_password,
                        'table'      => 'results',
                        'tableWatch' => 'watches',
                        'initSchema' => false
                    ],

                    'profiler.enable' => function () {
                        return true;
                    },
                ]);

                $profiler->start();
            }
            catch(\Exception $e){
                if( function_exists('e') && function_exists('lang') && class_exists('User') ){
                    if( User::getInstance()->hasAdminAccess() ){
                        e(lang('option_profiling_error', $e->getMessage()));
                    }
                }

                error_log($e->getMessage());
            }
        }
    }
    public static function isAvailable($check_cli = false): bool
    {
        if( !extension_loaded('xhprof') ){
            return false;
        }

        if( $check_cli ){
            $extensionsCLI = System::get_php_extensions('php_cli');
            if( !in_array('xhprof', $extensionsCLI) ){
                return false;
            }
        }

        return true;
    }
}