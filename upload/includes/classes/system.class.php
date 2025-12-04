<?php
class System{
    static array $extensionsWeb = [];
    static array $extensionsCli = [];
    static string $versionCli;
    static array $configsCli = [];
    static $is_in_dev = null;

    const MIN_PHP_VERSION = '9.0.0';
    const MIN_MYSQL_VERSION = '5.6.0';

    private static function init_php_extensions($type, $custom_filepath = null): array
    {
        switch($type){
            case 'php_web':
                self::$extensionsWeb = array_map('strtolower', get_loaded_extensions());
                break;

            case 'php_cli':
                $php_cli_info = System::get_php_cli_info($custom_filepath);
                if( !empty($php_cli_info['err']) ){
                    return ['err' => $php_cli_info['err']];
                }

                $regex_version = '(\d+\.\d+\.\d+)';
                $php_extensions = self::get_php_extensions_list();
                $configs = ['post_max_size', 'memory_limit', 'upload_max_filesize', 'max_execution_time', 'disable_functions', 'CurrentDatetime', 'ffi.enable'];

                foreach ($php_cli_info as $line) {
                    if (str_contains($line, 'PHP Version')) {
                        $line = explode('=>', $line);
                        $tmp_version  = trim(end($line));

                        preg_match($regex_version, $tmp_version, $match_version);
                        self::$versionCli = $match_version[0] ?? $tmp_version;

                        continue;
                    }

                    foreach($configs as $config){
                        if (str_contains($line, $config)) {
                            $line = explode('=>', $line);
                            self::$configsCli[$config] = trim(end($line));
                            continue 2;
                        }
                    }

                    foreach($php_extensions as $key => $extension) {
                        foreach ($extension['version_tags'] as $tag) {
                            if (str_contains($line, $tag)) {
                                self::$extensionsCli[$key] = $key;
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
        return [];
    }

    public static function get_php_extensions_list(): array
    {
        return [
            'gd' => [
                'display' => 'GD'
                ,'version_tags' => ['GD library Version','GD Version']
                ,'required' => true
            ],
            'mbstring' => [
                'display' => 'MBstring'
                ,'version_tags' => ['libmbfl version']
                ,'required' => true
            ],
            'mysqli' => [
                'display' => 'MySQLi'
                ,'version_tags' => ['Client API library version']
                ,'required' => true
            ],
            'xml' => [
                'display' => 'XML'
                ,'version_tags' => ['libxml2 Version']
                ,'required' => true
            ],
            'curl' => [
                'display' => 'cURL'
                ,'version_tags' => ['cURL Information']
                ,'required' => true
            ],
            'openssl' => [
                'display' => 'OpenSSL'
                ,'version_tags' => ['OpenSSL Library Version']
                ,'required' => true
            ],
            'fileinfo' => [
                'display' => 'Fileinfo'
                ,'version_tags' => ['fileinfo support']
                ,'required' => true
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
                $req = self::MIN_PHP_VERSION;
                $binary_path = $custom_filepath ?? System::get_binaries($software, false);
                if ($php_version < $req) {
                    return $verbose ? ['err' =>sprintf('Found PHP %s but required is PHP %s : %s', $php_version, $req, $binary_path)] : ($version_only ? $php_version : false);
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

                $req = System::MIN_PHP_VERSION;
                if (self::$versionCli < $req) {
                    return $verbose ? ['err' => sprintf('Found PHP CLI %s but required is PHP CLI %s : %s', self::$versionCli, $req, $binary_path)] :  ($version_only ? self::$versionCli : false);
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
                    if(str_contains($e->getMessage(), 'open_basedir')){
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

                $mysqlReq=System::MIN_MYSQL_VERSION;
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
                    if(str_contains($e->getMessage(), 'open_basedir')){
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

                if( !$version ){
                    preg_match('/version ([0-9.]+)/i', $ffmpeg_version, $matches);
                    if (@$matches[1]) {
                        $version = $matches[1];
                    }
                }

                if( !$version ) {
                    preg_match('/version\s+(.*?)\s+Copyright/', $ffmpeg_version, $matches);
                    if (@$matches[1]) {
                        $version = $matches[1];
                    }
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
                    if(str_contains($e->getMessage(), 'open_basedir')){
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
                    if(str_contains($e->getMessage(), 'open_basedir')){
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
                    if(str_contains($e->getMessage(), 'open_basedir')){
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
        $cmd = $php_path . ' ' . DirPath::get('admin_actions') . 'phpinfo.php' . $complement;

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
                    if (str_contains($line, 'disable_functions')) {
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
    public static function check_global_configs(): int
    {
        if (config('cache_enable') == 'yes') {
            $cache = CacheRedis::getInstance()->get('check_global_configs');
            if ($cache != '') {
                return $cache;
            }
        } elseif (time() < $_SESSION['check_global_configs']['time']) {
            return $_SESSION['check_global_configs']['val'];
        }

        //config
        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '261') && (empty(trim(config('base_url'))) || !filter_var(config('base_url'), FILTER_VALIDATE_URL)) ){
            self::displayConfigError('error config : base_url', -1);
            return -1;
        }

        //Hosting
        $max_execution_time = ini_get('max_execution_time');
        if ($max_execution_time > 0 && $max_execution_time < 7200) {
            self::displayConfigError('error config : max_execution_time');
            return false;
        }

        $target_upload_size = config('max_upload_size');
        $chunk_upload = config('enable_chunk_upload') == 'yes';

        $post_max_size = ini_get('post_max_size');
        $post_max_size_mb = (int)$post_max_size * pow(1024, stripos('KMGT', strtoupper(substr($post_max_size, -1)))) / 1024;

        $upload_max_filesize = ini_get('upload_max_filesize');
        $upload_max_filesize_mb = (int)$upload_max_filesize * pow(1024, stripos('KMGT', strtoupper(substr($upload_max_filesize, -1)))) / 1024;

        if (!$chunk_upload && $target_upload_size > min($post_max_size_mb, $upload_max_filesize_mb)) {
            self::displayConfigError('error config : post_size');
            return false;
        }

        $chunk_upload_size = config('chunk_upload_size');

        if ($chunk_upload && $chunk_upload_size > min($post_max_size_mb, $post_max_size_mb)) {
            self::displayConfigError('error config : chunk_upload_size');
            return false;
        }

        $cloudflare_upload_limit = config('cloudflare_upload_limit');
        if (Network::is_cloudflare()) {
            if (!$chunk_upload && $target_upload_size > $cloudflare_upload_limit) {
                self::displayConfigError('error config : cloudflare_upload_limit');
                return false;
            }
            if ($chunk_upload && $chunk_upload_size > $cloudflare_upload_limit) {
                self::displayConfigError('error config : cloudflare_upload_limit');
                return false;
            }
        }

        $memory_limit = ini_get('memory_limit');
        if ($memory_limit > 0 && getBytesFromFileSize($memory_limit) < getBytesFromFileSize('128M')) {
            self::displayConfigError('error config : memory_limit');
            return false;
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '99')) {
            if (!self::isDateTimeSynchro()) {
                self::displayConfigError('error config : isDateTimeSynchro');
                return false;
            }

            $current_datetime_cli = System::get_php_cli_config('CurrentDatetime');
            $tmp = [];
            if (!self::isDateTimeSynchro($tmp, $current_datetime_cli)) {
                self::displayConfigError('error config : isDateTimeSynchro cli');
                return false;
            }
        }

        // Services
        $phpVersionReq = System::MIN_PHP_VERSION;
        $php_web_version = System::getPHPVersionWeb();
        if ($php_web_version < $phpVersionReq) {
            self::displayConfigError('error config : php web');
            return false;
        }

        $ffReq = '3';
        $ffmpeg_version = System::get_software_version('ffmpeg', true, null, true);
        if (is_array($ffmpeg_version) && array_key_exists('err', $ffmpeg_version)) {
            $ffmpeg_version = 0;
        }

        if ($ffmpeg_version < $ffReq) {
            self::displayConfigError('error config : FFMPEG');
            return false;
        }

        $ffprobe_version = System::get_software_version('ffprobe', true, null, true);
        if (is_array($ffprobe_version) && array_key_exists('err', $ffprobe_version)) {
            $ffprobe_version = 0;
        }

        if ($ffprobe_version < $ffReq) {
            self::displayConfigError('error config : FFPROB');
            return false;
        }

        $media_info = System::get_software_version('media_info', true, null, true);
        if (is_array($media_info) && array_key_exists('err', $media_info)) {
            $media_info = 0;
        }

        if (!$media_info) {
            self::displayConfigError('error config : Media info');
            return false;
        }

        $mysqlReq = System::MIN_MYSQL_VERSION;
        $serverMySqlVersion = getMysqlServerVersion()[0]['@@version'];
        $regex_version = '(\d+\.\d+\.\d+)';
        preg_match($regex_version, $serverMySqlVersion, $match_mysql);
        $serverMySqlVersion = $match_mysql[0] ?? false;

        if ((version_compare($serverMySqlVersion, $mysqlReq) < 0)) {
            self::displayConfigError('error config : MYSQL ');
            return false;
        }

        $phpVersionCli = System::get_software_version('php_cli');

        if ($phpVersionCli < $phpVersionReq) {
            self::displayConfigError('error config : PHP CLi');
            return false;
        }

        $extensionsCLI = System::get_php_extensions('php_cli');
        $extensionsWEB = System::get_php_extensions('php_web');
        $php_extensions_list = System::get_php_extensions_list();
        foreach ($php_extensions_list as $key => $extension) {
            if (!$extension['required']) {
                continue;
            }
            $extensions_ok = (in_array($key, $extensionsCLI) && in_array($key, $extensionsWEB));

            if (!$extensions_ok) {
                self::displayConfigError('error config : ' . $extension['display']);
                return false;

            }
        }

        if( !Network::check_forbidden_directory(false) ){
            return false;
        }

        if( System::is_nginx() ){
            $nginx_infos = self::getNginxVhostInfos();
            $nginx_vhost_version = $nginx_infos['nginx_vhost_version'];
            $nginx_vhost_revision = $nginx_infos['nginx_vhost_revision'];

            if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '9') ){
                if( empty(config('nginx_vhost_version')) || empty(config('nginx_vhost_revision')) ){
                    return false;
                }

                if(config('nginx_vhost_version') < $nginx_vhost_version || (config('nginx_vhost_version') == $nginx_vhost_version && config('nginx_vhost_revision') < $nginx_vhost_revision) ){
                    return false;
                }
            }
        }

        $permissions = self::checkPermissions(self::getPermissions(false));
        self::setGlobalConfigCache($permissions);
        return $permissions;
    }

    /**
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    public static function setGlobalConfigCache($val): void
    {
        if (config('cache_enable') == 'yes') {
            CacheRedis::getInstance()->set('check_global_configs', $val, 60);
        } else {
            $_SESSION['check_global_configs']['val'] = $val;
            $_SESSION['check_global_configs']['time'] = time() + 60;
        }
    }

    /**
     * @throws \Predis\Connection\ConnectionException
     * @throws \Predis\Response\ServerException
     */
    private static function displayConfigError($error, $value = 0): void
    {
        if (System::isInDev()) {
            DiscordLog::sendDump($error . '```' . debug_backtrace_string() . '```');
        }
        self::setGlobalConfigCache($value);
    }

    public static function is_nginx(): bool
    {
        return str_contains($_SERVER['SERVER_SOFTWARE'], 'nginx');
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
            if (str_contains($line, $config_name)) {

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
            $space_usage_percent = $space_total > 0 ? round($space_used / $space_total * 100, 2) : 100;

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
                'space_usage_percent' => $space_usage_percent,
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
    public static function isDateTimeSynchro(array &$details = [], $force_datetime = null) :bool
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

    public static function getNginxVhostInfos(): array
    {
        $nginx_vhost = self::get_file_content(DirPath::get('docs') . 'nginx_vhost');

        if (preg_match('/^## Latest update\s*:\s*(.+)$/m', $nginx_vhost, $match_update)) {
            $nginx_vhost_update = trim($match_update[1]);
            $nginx_vhost = str_replace($match_update[0] . "\n", '', $nginx_vhost);
        } else {
            $nginx_vhost_update = null;
        }

        if (preg_match('/^## Latest version\s*:\s*(.+)$/m', $nginx_vhost, $match_version)) {
            $nginx_vhost_version = trim($match_version[1]);
            $nginx_vhost = str_replace($match_version[0] . "\n", '', $nginx_vhost);
        } else {
            $nginx_vhost_version = null;
        }

        if (preg_match('/^## Latest revision\s*:\s*(.+)$/m', $nginx_vhost, $match_revision)) {
            $nginx_vhost_revision = trim($match_revision[1]);
            $nginx_vhost = str_replace($match_revision[0] . "\n", '', $nginx_vhost);
        } else {
            $nginx_vhost_revision = null;
        }

        return [
            'nginx_vhost' => $nginx_vhost,
            'nginx_vhost_update' => $nginx_vhost_update,
            'nginx_vhost_version' => $nginx_vhost_version,
            'nginx_vhost_revision' => $nginx_vhost_revision
        ];
    }

    /**
     * @param array $permissions
     * @return int
     */
    public static function checkPermissions(array $permissions): int
    {
        foreach ($permissions as $permission) {
            if ( isset($permission['err'])) {
                if(System::isInDev()) {
                    DiscordLog::sendDump('error reading folder : ' . $permission['path'] . '```' . debug_backtrace_string() . '```');
                }
                return 0;
            }
        }
        return 1;
    }

    public static function get_file_content($filename, $secure = true): string
    {
        $root = realpath(DirPath::get('root'));
        $filepath = realpath($filename);

        if ($filepath === false || !str_starts_with($filepath, $root)) {
            return '';
        }

        $content = file_get_contents($filepath);
        if( $secure ){
            return htmlspecialchars($content);
        }
        return $content;
    }

    public static function isInDev(): bool
    {
        if( !empty(self::$is_in_dev) ){
            return self::$is_in_dev;
        }

        self::$is_in_dev = file_exists(DirPath::get('temp') . 'development.dev');
        return self::$is_in_dev;
    }

    public static function setInDev(bool $in_dev): void
    {
        self::$is_in_dev = $in_dev;
    }

    public static function isCli(): bool
    {
        return php_sapi_name() == 'cli';
    }

    public static function getPHPVersionWeb()
    {
        return self::get_software_version('php_web', false, null, true);
    }

}