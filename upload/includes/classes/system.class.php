<?php
class System{
    static $extensionsWeb = [];
    static $extensionsCli = [];
    static $versionCli;
    static $configsCli = [];

    private static function init_php_extensions($type)
    {
        switch($type){
            case 'web':
                ob_start();
                phpinfo(INFO_MODULES);
                $s = ob_get_contents();
                ob_end_clean();

                $s = strip_tags($s, '<h2><th><td>');
                $s = preg_replace('/<th[^>]*>([^<]+)<\/th>/', "<info>\\1</info>", $s);
                $s = preg_replace('/<td[^>]*>([^<]+)<\/td>/', "<info>\\1</info>", $s);
                $vTmp = preg_split('/(<h2>[^<]+<\/h2>)/', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
                $vModules = [];
                for ($i = 1; $i < count($vTmp); $i++) {
                    if (preg_match('/<h2>([^<]+)<\/h2>/', $vTmp[$i], $vMat)) {
                        $vName = trim($vMat[1]);
                        $vTmp2 = explode("\n", $vTmp[$i + 1]);
                        foreach ($vTmp2 as $vOne) {
                            $vPat = '<info>([^<]+)<\/info>';
                            $vPat3 = "/$vPat\s*$vPat\s*$vPat/";
                            $vPat2 = "/$vPat\s*$vPat/";
                            if (preg_match($vPat3, $vOne, $vMat)) { // 3cols
                                $vModules[$vName][trim($vMat[1])] = [
                                    trim($vMat[2]),
                                    trim($vMat[3])
                                ];
                            } elseif (preg_match($vPat2, $vOne, $vMat)) { // 2cols
                                $vModules[$vName][trim($vMat[1])] = trim($vMat[2]);
                            }
                        }
                    }
                }
                self::$extensionsWeb = $vModules;
                break;

            case 'php_cli':
            case 'cli':
                $php_cli_info = System::get_php_cli_info();
                if( !empty($php_cli_info['err']) ){
                    return ['err' => $php_cli_info['err']];
                }

                $configs = ['post_max_size', 'memory_limit', 'upload_max_filesize', 'max_execution_time', 'disable_functions'];
                $extensions = [
                    'GD library Version' => 'gd'
                    ,'GD Version' => 'gd'
                    ,'libmbfl version' => 'mbstring'
                    ,'Client API library version' => 'mysqli'
                    ,'libxml2 Version' => 'xml'
                    ,'cURL Information' => 'curl'
                ];
                foreach ($php_cli_info as $line) {
                    if (strpos($line, 'PHP Version') !== false) {
                        $line = explode('=>', $line);
                        self::$versionCli = trim(end($line));
                        continue;
                    }

                    foreach($configs as $config){
                        if (strpos($line, $config) !== false) {
                            $line = explode('=>', $line);
                            self::$configsCli[$config] = trim(end($line));
                            continue 2;
                        }
                    }

                    foreach($extensions as $search => $key){
                        if (strpos($line, $search) !== false) {
                            if( strpos($line, 'mysqlnd') !== false){
                                $line = str_replace('mysqlnd', '', $line);
                            }
                            $line = explode('=>', $line);
                            self::$extensionsCli[$key] = trim(end($line));
                            continue 2;
                        }
                    }
                }
                break;

            default :
                e('Wrong System::init_php_extensions type : ' . $type);
                break;

        }
    }

    public static function get_php_extensions($type): array
    {
        switch($type){
            case 'web':
                if( empty(self::$extensionsWeb) ){
                    self::init_php_extensions($type);
                }
                return self::$extensionsWeb;

            case 'cli':
                if( empty(self::$extensionsCli) ){
                    self::init_php_extensions($type);
                }
                return self::$extensionsCli;

            default:
                e('Wrong System::get_php_extensions type : ' . $type);
                return [];
        }
    }

    public static function get_php_cli_config($config_name){
        if( empty(self::$configsCli) ){
            self::init_php_extensions('cli');
        }

        return self::$configsCli[$config_name] ?? false;
    }

    public static function get_software_version($software, $verbose = false)
    {
        switch($software){
            case 'php_web':
                $regVersionPHP = '/(\d+\.\d+\.\d+)/';
                preg_match($regVersionPHP, phpversion(), $match);
                $php_version = $match[1] ?? phpversion();
                $req = '7.0.0';
                $binary_path = System::get_binaries('php_web', false);
                if ($php_version < $req) {
                    return $verbose ? ['err' =>sprintf('Found PHP %s but required is PHP %s : %s', $php_version, $req, $binary_path)] : false;
                }
                return $verbose ? ['msg' => sprintf('Found PHP %s : %s', $php_version, $binary_path)] : $php_version;

            case 'php_cli':
                if (!System::check_php_function('exec', 'web', false)) {
                    return $verbose ? ['err' => 'Can\'t be tested because exec() function is not enabled'] : false;
                }

                $binary_path = System::get_binaries($software, false);
                if (empty($binary_path)) {
                    return $verbose ? ['err' => 'Unable to find PHP CLI'] : false;
                }

                if( empty(self::$extensionsCli) ){
                    $return = self::init_php_extensions('cli');
                }
                if( isset($return['err']) ){
                    return $verbose ? ['err' => $return['err']] : false;
                }

                if( empty(self::$versionCli) ){
                    return false;
                }

                $req = '7.0.0';
                if (self::$versionCli < $req) {
                    return $verbose ? ['err' => sprintf('Found PHP CLI %s but required is PHP CLI %s : %s', self::$versionCli, $req, $binary_path)] : false;
                }
                return $verbose ? ['msg' => sprintf('Found PHP CLI %s : %s', self::$versionCli, $binary_path)] : self::$versionCli;

            case 'mysql_client':
                if (!System::check_php_function('exec', 'web', false)) {
                    return $verbose ? ['err' => 'Can\'t be tested because exec() function is not enabled'] : false;
                }
                $binary_path = System::get_binaries('mysql', false);
                if( empty($binary_path) ){
                    return $verbose ? ['err' => 'Unable to find Mysql'] : false;
                }

                exec($binary_path . ' --version', $mysql_client_output);
                if( empty($mysql_client_output) ){
                    return $verbose ? ['err' => 'Mysql is not correctly configured'] : false;
                }

                $match_mysql = [];
                $regex_version = '/(\d+\.\d+\.\d+)/';
                preg_match($regex_version, $mysql_client_output[0], $match_mysql);
                $version = $match_mysql[0] ?? false;

                if (!$version) {
                    return $verbose ? ['err' => 'Unable to find MySQL Client'] : false;
                }

                $mysqlReq='5.6.0';
                if ((version_compare($version, $mysqlReq) < 0)) {
                    return $verbose ? ['err' => sprintf('Current version is %s, minimal version %s is required. Please update', $version, $mysqlReq)] : false;
                }
                return $verbose ? ['msg' => sprintf('Found MySQL Client %s : %s', $version, $binary_path)] : $version;

            case 'ffmpeg':
            case 'ffprobe':
                $functions = ['exec', 'shell_exec'];
                foreach($functions as $function) {
                    if (!System::check_php_function($function, 'web', false)) {
                        return $verbose ? ['err' => 'Can\'t be tested because ' . $function . '() function is not enabled'] : false;
                    }
                }
                $binary_path = System::get_binaries($software, false);
                if (empty($binary_path)) {
                    return $verbose ? ['err' => 'Unable to find ' . strtoupper($software)] : false;
                }
                $ffmpeg_version = System::shell_output($binary_path . ' -version | head -n1');
                if( empty($ffmpeg_version) ){
                    return $verbose ? ['err' => strtoupper($software) . ' is not correctly configured' . strtoupper($software)] : false;
                }

                $version = false;
                preg_match('/SVN-r([0-9]+)/i', $ffmpeg_version, $matches);
                if (@$matches[1]) {
                    $version = 'r' . $matches[1];
                }
                preg_match('/version ([0-9.]+)/i', $ffmpeg_version, $matches);
                if (@$matches[1]) {
                    $version = $matches[1];
                }

                if (!$version) {
                    return $verbose ? ['err' => 'Unable to find ' . strtoupper($software)] : false;
                }

                $req = '3.0';
                if ($version < $req) {
                    return $verbose ? ['err' => printf('Current version is %s, minimal version %s is required. Please update', $version, $req)] : false;
                }
                return $verbose ? ['msg' => sprintf('Found ' . strtoupper($software) . ' %s : %s', $version, $binary_path)] : $version;

            case 'media_info':
                $functions = ['exec', 'shell_exec'];
                foreach($functions as $function) {
                    if (!System::check_php_function($function, 'web', false)) {
                        return $verbose ? ['err' => 'Can\'t be tested because ' . $function . '() function is not enabled'] : false;
                    }
                }
                $binary_path = System::get_binaries($software, false);
                if (empty($binary_path)) {
                    return $verbose ? ['err' => 'Unable to find Media Info'] : false;
                }
                $mediainfo_result = System::shell_output($binary_path . ' --version');
                if( empty($mediainfo_result) ){
                    return $verbose ? ['err' => 'Media Info is not correctly configured'] : false;
                }

                $media_info_version = explode('v', $mediainfo_result);
                $version = false;
                if (isset($media_info_version[1])) {
                    $version = $media_info_version[1];
                }

                if (!$version) {
                    return $verbose ? ['err' => 'Unable to find Media Info'] : false;
                }
                return $verbose ? ['msg' => sprintf('Found Media Info %s : %s', $version, $binary_path)] : $version;

            case 'git':
                $functions = ['exec', 'shell_exec'];
                foreach($functions as $function) {
                    if (!System::check_php_function($function, 'web', false)) {
                        return $verbose ? ['err' => 'Can\'t be tested because ' . $function . '() function is not enabled'] : false;
                    }
                }
                $binary_path = System::get_binaries($software, false);
                if( empty($binary_path) ){
                    return $verbose ? ['err' => '[OPTIONNAL] Unable to find Git'] : false;
                }

                $git_version = System::shell_output($binary_path . ' --version');
                if( empty($git_version) ){
                    return $verbose ? ['err' => '[OPTIONNAL] Git is not correctly configured'] : false;
                }

                preg_match('/git version (.+)$/', strtolower($git_version), $matches);

                if (empty($matches[1])) {
                    return $verbose ? ['err' => 'Unable to find Git'] : false;
                }

                $version = array_pop($matches);
                return $verbose ? ['msg' => sprintf('Found Git %s : %s', $version, $binary_path)] : $version;

            default:
                e('Wrong System::get_software_version software : ' . $software);
                return '';
        }
    }

    public static function get_php_cli_path()
    {
        if( function_exists('config') ){
            return config('php_path');
        }

        $return = [];
        $php_path = exec('which php');
        if( empty($php_path) ) {
            $return['err'] = 'Unable to find PHP CLI';
            return $return;
        }

        return $php_path;
    }

    public static function get_php_cli_info($php_path = ''): array
    {
        if( empty($php_path) ) {
            $php_path = self::get_binaries('php', false);
        }

        if( !self::check_php_function('exec', 'web', false) ){
            return [];
        }

        $return = [];
        $php_cli_info = [];
        $cmd = $php_path . ' ' . DirPath::get('root') . 'phpinfo.php';
        exec($cmd, $php_cli_info);

        if( empty($php_cli_info) ){
            $return['err'] = 'PHP CLI is not correctly configured';
            return $return;
        }

        return $php_cli_info;
    }

    public static function check_php_function($function, $mode = 'web', $return_error = true){
        if( $mode == 'web' ){
            $safe_mode = ini_get('safe_mode');
            $disable_functions = ini_get('disable_functions');
        } else {
            if( !empty(self::$configsCli['disable_functions']) ){
                $disable_functions = self::$configsCli['disable_functions'];
            } else {
                $php_path = self::get_php_cli_path();
                if( !empty($php_path['err']) ) {
                    $return['err'] = $php_path['err'];
                    return $return;
                }

                $php_cli_info = self::get_php_cli_info($php_path);
                if( !empty($php_cli_info['err']) ){
                    $return['err'] = $php_cli_info['err'];
                    return $return;
                }

                $disable_functions = '';
                foreach ($php_cli_info as $line) {
                    if (strpos($line, 'disable_functions') !== false) {
                        $line = explode('=>', $line);
                        $disable_functions = end($line);
                        break;
                    }
                }
            }
        }

        $disable_functions = preg_replace('/\s+/', '', $disable_functions);

        switch($function){
            case 'exec':
            case 'shell_exec':
                if ( !empty($safe_mode) && strtolower($safe_mode) != 'off'){
                    if( $return_error ){
                        $return['err'] = 'safe_mode is enabled, so ' . $function . ' function is not enabled';
                    } else {
                        return false;
                    }
                }

                if ( !empty($disable_functions) && in_array($function, explode(',', $disable_functions), true) ){
                    if( $return_error ) {
                        $return['err'] = $function . ' function is not enabled';
                    } else {
                        return false;
                    }
                } else {
                    if( $return_error ) {
                        $return['msg'] = $function . ' function is enabled';
                    } else {
                        return true;
                    }
                }

                break;

            default:
                $return = false;
                break;
        }
        return $return;
    }

    public static function get_binaries($path, $error_message = true): string
    {
        $path = strtolower($path);
        if( function_exists('config') ){
            switch ($path) {
                case 'php_web':
                    return PHP_BINARY;

                case 'php':
                case 'php_cli':
                    $software_path = config('php_path');
                    break;

                case 'media_info':
                    $software_path = config('media_info');
                    break;

                case 'ffprobe':
                    $software_path = config('ffprobe_path');
                    break;

                case 'ffmpeg':
                    $software_path = config('ffmpegpath');
                    break;

                case 'git':
                    $software_path = config('git_path');
                    break;

                default:
                    $software_path = '';
                    break;
            }

            if ($software_path != '') {
                return trim($software_path);
            }
        }

        switch ($path) {
            case 'ffprobe':
            case 'ffmpeg':
            case 'git':
            case 'nginx':
            case 'mysql':
                $which = $path;
                break;
            case 'media_info':
                $which = 'mediainfo';
                break;
            case 'php':
            case 'php_cli':
                $which = 'php';
                break;

            case 'php_web':
                return PHP_BINARY;

            default:
                error_log('Wrong System::get_binaries path : ' . $path);
                return $error_message ? 'Unknown path : ' . $path : false;
        }

        $return_path = System::shell_output('which '.$which);
        if ( !empty($return_path) ) {
            return trim($return_path);
        }

        return $error_message ? 'Unable to find ' . $path . ' path' : false;
    }

    public static function shell_output($cmd)
    {
        if( !self::check_php_function('shell_exec', 'web', false) ){
            return false;
        }

        return shell_exec($cmd);
    }
}