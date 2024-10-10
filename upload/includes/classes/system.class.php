<?php
class System{
    static $extensionsWeb = [];
    static $extensionsCli = [];
    static $versionCli;
    static $configsCli = [];

    private static function init_php_extensions($type, $custom_filepath = null)
    {
        switch($type){
            case 'php_web':
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

                $regex_version = '(\d+\.\d+\.\d+)';
                $php_extensions = self::get_php_extensions_list();
                foreach($php_extensions as $key => $extension){
                    foreach($extension['version_tags'] as $tag){
                        if (!empty($vModules[$key][$tag]) && empty(self::$extensionsWeb[$key])) {
                            $matches = [];
                            preg_match($regex_version, $vModules[$key][$tag], $matches);
                            self::$extensionsWeb[$key] = $matches[0]??$vModules[$key][$tag];
                        }
                    }
                }

                break;

            case 'php_cli':
                $php_cli_info = System::get_php_cli_info($custom_filepath);
                if( !empty($php_cli_info['err']) ){
                    return ['err' => $php_cli_info['err']];
                }

                $regex_version = '(\d+\.\d+\.\d+)';
                $php_extensions = self::get_php_extensions_list();
                $configs = ['post_max_size', 'memory_limit', 'upload_max_filesize', 'max_execution_time', 'disable_functions', 'CurrentDatetime'];

                foreach ($php_cli_info as $line) {
                    if (strpos($line, 'PHP Version') !== false) {
                        $line = explode('=>', $line);
                        $tmp_version  = trim(end($line));

                        preg_match($regex_version, $tmp_version, $match_version);
                        self::$versionCli = $match_version[0] ?? $tmp_version;

                        continue;
                    }

                    foreach($configs as $config){
                        if (strpos($line, $config) !== false) {
                            $line = explode('=>', $line);
                            self::$configsCli[$config] = trim(end($line));
                            continue 2;
                        }
                    }

                    foreach($php_extensions as $key => $extension){
                        foreach($extension['version_tags'] as $tag){
                            if (strpos($line, $tag) !== false) {
                                $line = explode('=>', $line);
                                $tmp_version  = trim(end($line));

                                preg_match($regex_version, $tmp_version, $match_version);
                                self::$extensionsCli[$key] = $match_version[0] ?? $tmp_version;

                                continue 3;
                            }
                        }
                    }

                }
                break;

            default :
                e('Wrong System::init_php_extensions type : ' . $type);
                break;

        }
    }

    public static function get_php_extensions_list(): array
    {
        return [
            'gd' => [
                'display' => 'GD'
                ,'version_tags' => ['GD library Version','GD Version']
            ],
            'mbstring' => [
                'display' => 'MBstring'
                ,'version_tags' => ['libmbfl version']
            ],
            'mysqli' => [
                'display' => 'MySQLi'
                ,'version_tags' => ['Client API library version']
            ],
            'xml' => [
                'display' => 'XML'
                ,'version_tags' => ['libxml2 Version']
            ],
            'curl' => [
                'display' => 'cURL'
                ,'version_tags' => ['cURL Information']
            ],
            'openssl' => [
                'display' => 'OpenSSL'
                ,'version_tags' => ['OpenSSL Library Version']
            ],
            'fileinfo' => [
                'display' => 'Fileinfo'
                ,'version_tags' => ['fileinfo support']
            ]
        ];
    }

    public static function get_php_extensions($type, $custom_filepath = null): array
    {
        switch($type){
            case 'php_web':
                if( empty(self::$extensionsWeb) ){
                    self::init_php_extensions($type);
                }
                return self::$extensionsWeb;

            case 'php_cli':
                if( !System::get_software_version($type, false, $custom_filepath) ){
                    return [];
                }
                if( empty(self::$extensionsCli) ){
                    self::init_php_extensions($type, $custom_filepath);
                }

                return self::$extensionsCli;

            default:
                e('Wrong System::get_php_extensions type : ' . $type);
                return [];
        }
    }

    public static function get_php_cli_config($config_name){
        if( empty(self::$configsCli) ){
            self::init_php_extensions('php_cli');
        }

        return self::$configsCli[$config_name] ?? false;
    }

    public static function get_software_version($software, $verbose = false, $custom_filepath = null, $version_only = false)
    {
        switch($software){
            case 'php_web':
                $regVersionPHP = '/(\d+\.\d+\.\d+)/';
                preg_match($regVersionPHP, phpversion(), $match);
                $php_version = $match[1] ?? phpversion();
                $req = '7.0.0';
                $binary_path = $custom_filepath ?? System::get_binaries($software, false);
                if ($php_version < $req) {
                    return $verbose ? ['err' =>sprintf('Found PHP %s but required is PHP %s : %s', $php_version, $req, $binary_path)] : false;
                }
                return $verbose ? ['msg' => sprintf('Found PHP %s : %s', $php_version, $binary_path)] : $php_version;

            case 'php_cli':
                if (!System::check_php_function('exec', 'web', false)) {
                    return $verbose ? ['err' => 'Can\'t be tested because exec() function is not enabled'] : false;
                }

                $binary_path = $custom_filepath ?? System::get_binaries($software, false);
                if (empty($binary_path)) {
                    return $verbose ? ['err' => 'Unable to find PHP CLI'] : false;
                }

                if( empty(self::$extensionsCli) ){
                    $return = self::init_php_extensions($software, $binary_path);
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

                if( $version_only || !$verbose ){
                    return self::$versionCli;
                }
                return ['msg' => sprintf('Found PHP CLI %s : %s', self::$versionCli, $binary_path)];

            case 'mysql_client':
                if (!System::check_php_function('exec', 'web', false)) {
                    return $verbose ? ['err' => 'Can\'t be tested because exec() function is not enabled'] : false;
                }
                $binary_path = $custom_filepath ?? System::get_binaries('mysql', false);
                if( empty($binary_path) ){
                    return $verbose ? ['err' => 'Unable to find Mysql Client'] : false;
                }
                try{
                    if( !file_exists($binary_path) ){
                        return $verbose ? ['err' => 'Unable to find Mysql Client'] : false;
                    }
                }
                catch(Exception $e){
                    if( strpos($e->getMessage(), "open_basedir") !== false ){
                        return $verbose ? ['err' => 'PHP open_basedir restriction prevent access to Mysql Client (' . $binary_path . ')'] : false;
                    }
                    return $verbose ? ['err' => 'Unable to find Mysql Client'] : false;
                }

                exec($binary_path . ' --version', $mysql_client_output);
                if( empty($mysql_client_output) ){
                    return $verbose ? ['err' => 'Mysql Client is not correctly configured'] : false;
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

                if( $version_only || !$verbose ){
                    return $version;
                }
                return ['msg' => sprintf('Found MySQL Client %s : %s', $version, $binary_path)];

            case 'ffmpeg':
            case 'ffprobe':
                $functions = ['exec', 'shell_exec'];
                foreach($functions as $function) {
                    if (!System::check_php_function($function, 'web', false)) {
                        return $verbose ? ['err' => 'Can\'t be tested because ' . $function . '() function is not enabled'] : false;
                    }
                }
                $binary_path = $custom_filepath ?? System::get_binaries($software, false);
                if( empty($binary_path) ){
                    return $verbose ? ['err' => 'Unable to find ' . ucfirst($software)] : false;
                }
                try{
                    if( !file_exists($binary_path) ){
                        return $verbose ? ['err' => 'Unable to find ' . ucfirst($software)] : false;
                    }
                }
                catch(Exception $e){
                    if( strpos($e->getMessage(), "open_basedir") !== false ){
                        return $verbose ? ['err' => 'PHP open_basedir restriction prevent access to ' . ucfirst($software) . ' (' . $binary_path . ')'] : false;
                    }
                    return $verbose ? ['err' => 'Unable to find ' . ucfirst($software)] : false;
                }

                $ffmpeg_version = System::shell_output($binary_path . ' -version');
                if( empty($ffmpeg_version) ){
                    return $verbose ? ['err' => ucfirst($software) . ' is not correctly configured'] : false;
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
                    return $verbose ? ['err' => 'Unable to find ' . ucfirst($software)] : false;
                }

                $req = '3.0';
                if ($version < $req) {
                    return $verbose ? ['err' => printf('Current version is %s, minimal version %s is required. Please update', $version, $req)] : false;
                }

                if( $version_only || !$verbose ){
                    return $version;
                }
                return ['msg' => sprintf('Found ' . strtoupper($software) . ' %s : %s', $version, $binary_path)];

            case 'media_info':
                $functions = ['exec', 'shell_exec'];
                foreach($functions as $function) {
                    if (!System::check_php_function($function, 'web', false)) {
                        return $verbose ? ['err' => 'Can\'t be tested because ' . $function . '() function is not enabled'] : false;
                    }
                }
                $binary_path = $custom_filepath ?? System::get_binaries($software, false);
                if( empty($binary_path) ){
                    return $verbose ? ['err' => 'Unable to find Media Info'] : false;
                }
                try{
                    if( !file_exists($binary_path) ){
                        return $verbose ? ['err' => 'Unable to find Media Info'] : false;
                    }
                }
                catch(Exception $e){
                    if( strpos($e->getMessage(), "open_basedir") !== false ){
                        return $verbose ? ['err' => 'PHP open_basedir restriction prevent access to Media Info (' . $binary_path . ')'] : false;
                    }
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

                if( $version_only || !$verbose ){
                    return $version;
                }
                return ['msg' => sprintf('Found Media Info %s : %s', $version, $binary_path)];

            case 'git':
                $functions = ['exec', 'shell_exec'];
                foreach($functions as $function) {
                    if (!System::check_php_function($function, 'web', false)) {
                        return $verbose ? ['err' => 'Can\'t be tested because ' . $function . '() function is not enabled'] : false;
                    }
                }
                $binary_path = $custom_filepath ?? System::get_binaries($software, false);
                if( empty($binary_path) ){
                    return $verbose ? ['err' => 'Unable to find Git'] : false;
                }
                try{
                    if( !file_exists($binary_path) ){
                        return $verbose ? ['err' => 'Unable to find Git'] : false;
                    }
                }
                catch(Exception $e){
                    if( strpos($e->getMessage(), "open_basedir") !== false ){
                        return $verbose ? ['err' => 'PHP open_basedir restriction prevent access to Git (' . $binary_path . ')'] : false;
                    }
                    return $verbose ? ['err' => 'Unable to find Git'] : false;
                }

                $git_version = System::shell_output($binary_path . ' --version');
                if( empty($git_version) ){
                    return $verbose ? ['err' => 'Git is not correctly configured'] : false;
                }

                preg_match('/git version (.+)$/', strtolower($git_version), $matches);

                if (empty($matches[1])) {
                    return $verbose ? ['err' => 'Unable to find Git'] : false;
                }

                $version = array_pop($matches);

                if( $version_only || !$verbose ){
                    return $version;
                }
                return ['msg' => sprintf('Found Git %s : %s', $version, $binary_path)];

            case 'nginx':
                $functions = ['exec', 'shell_exec'];
                foreach($functions as $function) {
                    if (!System::check_php_function($function, 'web', false)) {
                        return $verbose ? ['err' => 'Can\'t be tested because ' . $function . '() function is not enabled'] : false;
                    }
                }
                $binary_path = $custom_filepath ?? System::get_binaries($software, false);
                if( empty($binary_path) ){
                    return $verbose ? ['err' => 'Unable to find Nginx'] : false;
                }
                try{
                    $file_exists = file_exists($binary_path);
                    if( !$file_exists ){
                        return $verbose ? ['err' => 'Unable to find Nginx'] : false;
                    }
                }
                catch(Exception $e){
                    if( strpos($e->getMessage(), "open_basedir") !== false ){
                        return $verbose ? ['err' => 'PHP open_basedir restriction prevent access to Nginx (' . $binary_path . ')'] : false;
                    }
                    return $verbose ? ['err' => 'Unable to find Nginx'] : false;
                }

                $nginx_version = System::shell_output($binary_path . ' -v 2>&1');
                if( empty($nginx_version) ){
                    return $verbose ? ['err' => 'Nginx is not correctly configured'] : false;
                }

                preg_match('/nginx\/(.+)$/', strtolower($nginx_version), $matches);

                if (empty($matches[1])) {
                    return $verbose ? ['err' => 'Unable to find Nginx'] : false;
                }

                $version = array_pop($matches);

                if( $version_only || !$verbose ){
                    return $version;
                }
                return ['msg' => sprintf('Found Nginx %s : %s', $version, $binary_path)];

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

    public static function get_php_cli_info($php_path = null): array
    {
        if( empty($php_path) ) {
            $php_path = self::get_binaries('php', false);
        }

        if( !self::check_php_function('exec', 'web', false) ){
            return [];
        }

        $return = [];
        $php_cli_info = [];

        $complement = '';
        if( THIS_PAGE == 'cb_install' ){
            $complement = ' install';
        }
        $cmd = $php_path . ' ' . DirPath::get('root') . 'phpinfo.php' . $complement;

        exec($cmd, $php_cli_info);

        if( empty($php_cli_info) ){
            $return['err'] = 'PHP CLI is not correctly configured';
            return $return;
        }

        return $php_cli_info;
    }

    public static function check_php_function($function, $mode = 'web', $return_error = true, $custom_filepath = null){
        if( $mode == 'web' ){
            $safe_mode = ini_get('safe_mode');
            $disable_functions = ini_get('disable_functions');
        } else {
            if( !empty(self::$configsCli['disable_functions']) ){
                $disable_functions = self::$configsCli['disable_functions'];
            } else {
                $php_path = $custom_filepath ?? self::get_php_cli_path();
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
                case 'mediainfo':
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

                case 'nginx':
                    $software_path = config('nginx_path');
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
            case 'mediainfo':
                $which = $path;
                break;
            case 'media_info':
                $which = 'mediainfo';
                break;
            case 'php':
            case 'php_cli':
            case 'cli':
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

    public static function can_sse(): bool
    {
        // Only available on PHP-FPM
        return function_exists('fastcgi_finish_request');
    }

    /**
     * @throws Exception
     */
    public static function check_global_configs(): bool
    {
        if (config('cache_enable') == 'yes') {
            $cache = CacheRedis::getInstance()->get('check_global_configs');
            if( $cache != '' ) {
                return $cache;
            }
        } elseif( time() < $_SESSION['check_global_configs']['time']) {
            return $_SESSION['check_global_configs']['val'];
        }

        $max_execution_time = ini_get('max_execution_time');
        if( $max_execution_time > 0 && $max_execution_time < 7200 ){
            if (in_dev()) {
                ob_start();
                debug_print_backtrace();
                print_r($_SERVER);
                $call_stack = ob_get_clean();
                DiscordLog::sendDump('error config : max_execution_time ' . $call_stack);
            }
            self::setGlobalConfigCache(0);
            return false;
        }

        $target_upload_size = config('max_upload_size');
        $chunk_upload = config('enable_chunk_upload') == 'yes';

        $post_max_size = ini_get('post_max_size');
        $post_max_size_mb = (int)$post_max_size * pow(1024, stripos('KMGT', strtoupper(substr($post_max_size, -1)))) / 1024;

        $upload_max_filesize = ini_get('upload_max_filesize');
        $upload_max_filesize_mb = (int)$upload_max_filesize * pow(1024, stripos('KMGT', strtoupper(substr($upload_max_filesize, -1)))) / 1024;

        if( !$chunk_upload && $target_upload_size > min($post_max_size_mb, $upload_max_filesize_mb) ){
            if (in_dev()) {
                ob_start();
                debug_print_backtrace();
                print_r($_SERVER);
                $call_stack = ob_get_clean();
                DiscordLog::sendDump('error config : post_size' . $call_stack);
            }
            self::setGlobalConfigCache(0);
            return false;
        }

        $chunk_upload_size = config('chunk_upload_size');

        if( $chunk_upload && $chunk_upload_size > min($post_max_size_mb, $post_max_size_mb) ){
            if (in_dev()) {
                ob_start();
                debug_print_backtrace();
                print_r($_SERVER);
                $call_stack = ob_get_clean();
                DiscordLog::sendDump('error config : chunk_upload_size ' . $call_stack);
            }
            self::setGlobalConfigCache(0);
            return false;
        }

        $cloudflare_upload_limit = config('cloudflare_upload_limit');
        if( Network::is_cloudflare() ){
            if( !$chunk_upload && $target_upload_size > $cloudflare_upload_limit ){
                if (in_dev()) {
                    ob_start();
                    debug_print_backtrace();
                    print_r($_SERVER);
                    $call_stack = ob_get_clean();
                    DiscordLog::sendDump('error config : cloudflare_upload_limit' . $call_stack);
                }
                self::setGlobalConfigCache(0);
                return false;
            }
            if( $chunk_upload && $chunk_upload_size > $cloudflare_upload_limit ){
                if (in_dev()) {
                    ob_start();
                    debug_print_backtrace();
                    print_r($_SERVER);
                    $call_stack = ob_get_clean();
                    DiscordLog::sendDump('error config : cloudflare_upload_limit' . $call_stack);
                }
                self::setGlobalConfigCache(0);
                return false;
            }
        }

        $memory_limit = ini_get('memory_limit');
        if( $memory_limit > 0 && getBytesFromFileSize($memory_limit) < getBytesFromFileSize('128M') ){
            if (in_dev()) {
                ob_start();
                debug_print_backtrace();
                print_r($_SERVER);
                $call_stack = ob_get_clean();
                DiscordLog::sendDump('error config : memory_limit' . $call_stack);
            }
            self::setGlobalConfigCache(0);
            return false;
        }

        if( !self::isDateTimeSynchro() ){
            if (in_dev()) {
                ob_start();
                debug_print_backtrace();
                print_r($_SERVER);
                $call_stack = ob_get_clean();
                DiscordLog::sendDump('error config : isDateTimeSynchro' . $call_stack);
            }
            self::setGlobalConfigCache(0);
            return false;
        }

        $current_datetime_cli = System::get_php_cli_config('CurrentDatetime');
        $tmp = [];
        if( !self::isDateTimeSynchro($tmp, $current_datetime_cli) ){
            if (in_dev()) {
                ob_start();
                debug_print_backtrace();
                print_r($_SERVER);
                $call_stack = ob_get_clean();
                DiscordLog::sendDump('error config : isDateTimeSynchro cli ' . $call_stack);
            }
            self::setGlobalConfigCache(0);
            return false;
        }

        $permissions = self::checkPermissions(self::getPermissions(false));
        self::setGlobalConfigCache($permissions);
        return $permissions;
    }

    /**
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    public static function setGlobalConfigCache($val)
    {
        if (config('cache_enable') == 'yes') {
            CacheRedis::getInstance()->set('check_global_configs', $val, 60);
        } else {
            $_SESSION['check_global_configs']['val'] = $val;
            $_SESSION['check_global_configs']['time'] = time() + 60;
        }
    }

    public static function is_nginx(): bool
    {
        return strpos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false;
    }

    public static function get_nginx_config(string $config_name): string
    {
        if (!self::is_nginx()) {
            return '';
        }

        $nginx_path = self::get_binaries('nginx', false);
        if (empty($nginx_path) || !file_exists($nginx_path)) {
            return '';
        }

        if (!self::check_php_function('shell_exec', 'web', false)) {
            return '';
        }

        chdir(dirname($nginx_path));
        $data = shell_exec($nginx_path . ' -T 2>&1');

        $separator = "\r\n";
        $line = strtok($data, $separator);

        while ($line !== false) {
            if (strpos($line, $config_name) !== false) {

                // Clear RAM usage from strtok
                unset($data);
                strtok('', '');

                return explode(' ', str_replace(';', '', $line))[1];
            }

            $line = strtok($separator);
        }

        // Clear RAM usage from strtok
        unset($data);
        strtok('', '');

        return '';
    }

    public static function get_disks_usage(): array
    {
        $dir_names = ['root', 'files', 'avatars', 'backgrounds', 'category_thumbs', 'conversion_queue', 'logos', 'logs', 'mass_uploads', 'photos', 'subtitles', 'temp', 'thumbs', 'videos'];
        $directories = [];
        foreach ($dir_names as $dir) {
            $directories[] = DirPath::get($dir);
        }

        $disks = [];
        foreach($directories as $files_dirpath){
            $space_total = disk_total_space($files_dirpath);
            $space_free = disk_free_space($files_dirpath);
            $space_used = $space_total - $space_free;

            foreach($disks as $disk){
                if( $disk['space_total'] == $space_total && $disk['space_free'] == $space_free ){
                    continue 2;
                }
            }

            $disks[] = [
                'path' => $files_dirpath,
                'space_total' => $space_total,
                'space_free' => $space_free,
                'space_used' => $space_used,
                'space_usage_percent' => round($space_used / $space_total * 100, 2),
                'readable_total' => self::get_readable_filesize($space_total, 2),
                'readable_free' => self::get_readable_filesize($space_free, 2),
                'readable_used' => self::get_readable_filesize($space_used, 2)
            ];
        }

        return $disks;
    }

    public static function get_readable_filesize(int $bytes, int $round = -1): String
    {
        $size   = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        $value = $bytes / (1024 ** $factor);
        if($round != -1){
            $value = round($value, $round);
        }

        return $value . ' ' . $size[$factor];
    }

    /**
     * Check if date php and date BDD is synchro
     * @param array $details detailed array with dates and diff
     * @param string $force_datetime
     * @return bool
     * @throws Exception
     */
    public static function isDateTimeSynchro(array &$details = [], string $force_datetime = null) :bool
    {
        $query = /** @lang MySQL */'SELECT NOW() AS t';
        $rs = Clipbucket_db::getInstance()->_select($query);

        $details['bdd'] = $rs[0]['t'];
        $details['php'] = $force_datetime ?? date('Y-m-d H:i:s');
        $details['php_timezone_default'] = date_default_timezone_get();

        $datetime1 = new \DateTime($details['bdd']);
        $datetime2 = new \DateTime($details['php']);
        $interval = $datetime1->diff($datetime2);
        $details['diff_in_minute'] = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

        return $details['diff_in_minute'] <= 1;
    }

    /**
     * @param bool $install
     * @return array
     */
    public static function getPermissions(bool $install = true): array
    {
        /**
         * Function used to check folder permissions
         */
        $files = [
            'cache',
            'cache/comments',
            'cache/userfeeds',
            'cache/views',
            'cb_install',
            'cb_install/sql',
            'changelog',
            'files',
            'files/avatars',
            'files/backgrounds',
            'files/category_thumbs',
            'files/conversion_queue',
            'files/logos',
            'files/logs',
            'files/mass_uploads',
            'files/original',
            'files/photos',
            'files/temp',
            'files/thumbs',
            'files/videos',
            'images',
            'includes'
        ];
        if ($install) {
            $files[] = 'files/temp/install.me';
        }

        $permsArray = [];
        foreach ($files as $file) {
            if (is_writeable(DirPath::get('root') . $file)) {
                $permsArray[] = [
                    'path' => $file,
                    'msg'  => 'writeable'
                ];
            } else {
                $permsArray[] = [
                    'path' => $file,
                    'err'  => 'please chmod this file/directory to 755'
                ];
            }
        }
        return $permsArray;
    }

    /**
     * @param array $permissions
     * @return int
     */
    public static function checkPermissions(array $permissions): int
    {
        foreach ($permissions as $permission) {
            if ( isset($permission['err'])) {
                if(in_dev()) {
                    ob_start();
                    debug_print_backtrace();
                    print_r($_SERVER);
                    $call_stack = ob_get_clean();
                    DiscordLog::sendDump('error reading folder : ' . $permission['path'] . ' ' . $call_stack);
                }
                return 0;
            }
        }
        return 1;
    }

    public static function get_license($filename)
    {
        $license = file_get_contents(DirPath::get('root') . $filename);
        return str_replace("\n", '<BR>', $license);
    }

}