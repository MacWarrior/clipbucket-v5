<?php
if (!file_exists(DirPath::get('temp') . 'install.me')) {
    if (!file_exists(DirPath::get('temp') . 'install.me.not') && !file_exists(DirPath::get('temp') . 'development.dev')) {
        header('Location: //' . $_SERVER['SERVER_NAME']);
        die();
    }

    if (!file_exists(DirPath::get('temp') . 'install.me.not')) {
        $mode = 'lock';
    }
}

function get_cbla()
{
    $license = file_get_contents(DirPath::get('root') . 'LICENSE');
    return str_replace("\n", '<BR>', $license);
}

function button($text, $params, $class = 'btn-primary')
{
    echo '<span ' . $params . '>&nbsp;</span>';
    echo '<span class="btn ' . $class . '" ' . $params . '>' . $text . '</span>';
    echo '<span ' . $params . '>&nbsp;</span>';
}

function button_green($text, $params = null)
{
    button($text, $params, 'btn-success');
}

function button_danger($text, $params = null)
{
    button($text, $params, 'btn-danger');
}

function msg_arr($arr): string
{
    if (@$arr['msg']) {
        $text = $arr['msg'];
        $type = 'ok';
    } else {
        $text = $arr['err'];
        $type = 'alert_cross';
    }

    return '<span class="msg ' . $type . '">' . $text . '</span>';
}
$extensionsCLI = [];
$extensionsWeb = install_parseAllPHPModules();
function check_module($type): array
{
    global $extensionsCLI;
    $return = [];
    $regex_version = '(\d+\.\d+\.\d+)';
    $mysqlReq='5.6.0';

    switch ($type) {
        case 'ffmpeg':
        case 'ffprobe':
            $ffmpeg_path = exec('which '.$type);
            $ffmpeg_version = shell_output($ffmpeg_path . ' -version | head -n1');

            $version = false;
            preg_match('/SVN-r([0-9]+)/i', $ffmpeg_version, $matches);
            if (@$matches[1]) {
                $version = 'r' . $matches[1];
            }
            preg_match('/version ([0-9.]+)/i', $ffmpeg_version, $matches);
            if (@$matches[1]) {
                $version = $matches[1];
            }

            $req = '3.0';
            if (!$version) {
                $return['err'] = 'Unable to find ' . strtoupper($type);
                break;
            }
            if ($version < $req) {
                $return['err'] = sprintf('Current version is %s, minimal version %s is required. Please update', $version, $req);
                break;
            }
            $return['msg'] = sprintf('Found ' . strtoupper($type) . ' %s : %s', $version, $ffmpeg_path);
            break;

        case 'git':
            $git_path = exec('which '.$type);
            if( empty($git_path) ){
                $return['err'] = '[OPTIONNAL] Unable to find Git';
                break;
            }

            $git_version = shell_output($git_path . ' --version');
            if( empty($git_version) ){
                $return['err'] = '[OPTIONNAL] Git is not correctly configured';
                break;
            }

            preg_match('/git version (.+)$/', strtolower($git_version), $matches);
            if( !empty($matches) ) {
                $return['msg'] = sprintf('Found Git %s', array_pop($matches));
            }
            break;

        case 'media_info':
            $mediainfo_path = exec('which mediainfo');
            $mediainfo_result = shell_output($mediainfo_path . ' --version');

            $media_info_version = explode('v', $mediainfo_result);
            $version = false;
            if (isset($media_info_version[1])) {
                $version = $media_info_version[1];
            }

            if (!$version) {
                $return['err'] = 'Unable to find Media Info';
                break;
            }
            $return['msg'] = sprintf('Found Media Info %s : %s', $version, $mediainfo_path);
            break;

        case 'mysql_client':
            $mysql_path = exec('which mysql');
            if( empty($mysql_path) ){
                $return['err'] = 'Unable to find Mysql';
                break;
            }

            exec($mysql_path . ' --version', $mysql_client_output);
            if( empty($mysql_client_output) ){
                $return['err'] = 'Mysql is not correctly configured';
                break;
            }

            $match_mysql = [];
            preg_match($regex_version, $mysql_client_output[0], $match_mysql);
            $clientMySqlVersion = $match_mysql[0] ?? false;

            if (!$clientMySqlVersion) {
                $return['err'] = 'Unable to find MySQL Client';
                break;
            }
            if ((version_compare($clientMySqlVersion, $mysqlReq) < 0)) {
                $return['err'] = sprintf('Current version is %s, minimal version %s is required. Please update', $clientMySqlVersion, $mysqlReq);
                break;
            }
            $return['msg'] = sprintf('Found MySQL Client %s', $clientMySqlVersion);
            break;

        case 'php_cli':
            $php_path = exec('which php');
            if( empty($php_path) ) {
                $return['err'] = 'Unable to find PHP CLI';
                break;
            }

            $cmd = $php_path . ' ' . DirPath::get('root') . 'phpinfo.php';
            exec($cmd, $php_cli_info);

            if( empty($php_cli_info) ){
                $return['err'] = 'PHP CLI is not correctly configured';
                break;
            }

            $regVersion = '/(\w* \w*) => (.*)$/';
            foreach ($php_cli_info as $line) {
                $match = [];
                if (strpos($line, 'PHP Version') !== false) {
                    preg_match($regVersion, $line, $match);
                    if (!empty($match)) {
                        $php_version = $match[2];
                    }
                }
                if (strpos($line, 'GD library Version') !== false) {
                    preg_match($regVersion, $line, $match);
                    if (!empty($match)) {
                        $extensionsCLI['gd'] = $match[2];
                    }
                }
                if (strpos($line, 'libmbfl version') !== false) {
                    preg_match($regVersion, $line, $match);
                    if (!empty($match)) {
                        $extensionsCLI['mbstring'] = $match[2];
                    }
                }
                if (strpos($line, 'Client API library version') !== false) {
                    preg_match($regVersion, $line, $match);
                    if (!empty($match)) {
                        $extensionsCLI['mysqli'] = $match[2];
                    }
                }
                if (strpos($line, 'libxml2 Version') !== false) {
                    preg_match($regVersion, $line, $match);
                    if (!empty($match)) {
                        $extensionsCLI['xml'] = $match[2];
                    }
                }
                if (strpos($line, 'cURL Information') !== false) {
                    preg_match($regVersion, $line, $match);
                    if (!empty($match)) {
                        $extensionsCLI['curl'] = $match[2];
                    }
                }
            }

            $req = '7.0.0';
            if ($php_version < $req) {
                $return['err'] = sprintf('Found PHP CLI %s but required is PHP %s : %s', $php_version, $req, $php_path);
                break;
            }
            $return['msg'] = sprintf('Found PHP CLI %s : %s', $php_version, $php_path);
            break;

        case 'php_web':
            $php_version = phpversion();
            $req = '7.0.0';
            if ($php_version < $req) {
                $return['err'] = sprintf('Found PHP %s but required is PHP %s : %s', $php_version, $req, PHP_BINARY);
                break;
            }
            $return['msg'] = sprintf('Found PHP %s : %s', $php_version, PHP_BINARY);
            break;
    }
    return $return;
}

function check_extension ($extension, $type) {
    global $extensionsCLI, $extensionsWeb;
    $reg = '/(\d+\.\d+\.\d+)$/';
    $mysqlReq = '5.6';
    switch ($type) {
        case 'cli':
            $version = $extensionsCLI[$extension] ?? false;
            if (!$version) {
                $return['err'] = $extension. ' extension is not enabled';
                break;
            }

            $error = false;
            if ($extension == 'mysqli') {
                $match_mysql = [];
                preg_match($reg, $version, $match_mysql);
                if ($match_mysql[1] < $mysqlReq) {
                    $error = sprintf('Current version of %s is %s, minimal version %s is required. Please update', $extension, $version, $mysqlReq);
                }
            }
            if ($error) {
                $return['err'] = $error;
                break;
            }
            $return['msg'] = sprintf('%s %s extension is enabled', $extension, $version);
            break;

        case 'web':
            $extensionMessages = [
                'gd' => 'GD library Version',
                'mbstring' => 'libmbfl version',
                'mysqli' => 'Client API library version',
                'curl' => 'cURL Information',
                'xml' => 'libxml2 Version'
            ];
            if (array_key_exists($extension, $extensionMessages)) {
                $res = $extensionsWeb[$extension] ?? false;
                if (empty($res)) {
                    $return['err'] = $extension . ' extension is not enabled';
                } else {
                    $key = $extensionMessages[$extension];
                    $error = false;
                    if ($extension == 'mysqli') {
                        $match_mysql = [];

                        preg_match($reg, $res[$key], $match_mysql);
                        if ($match_mysql[1] < $mysqlReq) {
                            $error = sprintf('Current version of %s is %s, minimal version %s is required. Please update', $extension, $res[$key], $mysqlReq);
                        }
                    }
                    if ($error) {
                        $return['err'] = $error;
                    } else {
                        $return['msg'] = sprintf('%s %s extension is enabled', $extension, $res[$key]);
                    }
                }
            }
            break;
        default:
            $return = false;
            break;
    }
    return $return;
}

function install_parseAllPHPModules(): array
{
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
    return $vModules;
}



if (!function_exists('shell_output')) {
    function shell_output($cmd)
    {
        if (!stristr(PHP_OS, 'WIN')) {
            $cmd = "PATH=\$PATH:/bin:/usr/bin:/usr/local/bin bash -c \"$cmd\" 2>&1";
        }
        return shell_exec($cmd);
    }
}

/**
 * Short form of print_r as pr
 */
if (!function_exists('pr')) {
    function pr($text, $wrap_pre = false)
    {
        if (!$wrap_pre) {
            $dump = print_r($text, true);
            echo display_clean($dump);
        } else {
            echo '<pre>';
            $dump = print_r($text, true);
            echo display_clean($dump);
            echo '</pre>';
        }
    }
}

/**
 * Function used to check folder permissions
 */
function checkPermissions(): array
{
    $files = [
        'cache',
        'cache/comments',
        'cache/userfeeds',
        'files',
        'files/backgrounds',
        'files/conversion_queue',
        'files/category_thumbs',
        'files/logs',
        'files/mass_uploads',
        'files/original',
        'files/photos',
        'files/temp',
        'files/temp/install.me',
        'files/thumbs',
        'files/videos',
        'images',
        'images/avatars',
        'images/collection_thumbs',
        'includes'
    ];

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

function selected($selected)
{
    global $mode;
    if ($mode == $selected) {
        return "class='selected'";
    }
}

function GetServerProtocol(): string
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        return 'https://';
    }
    $protocol = preg_replace('/^([a-z]+)\/.*$/', '\\1', strtolower($_SERVER['SERVER_PROTOCOL']));
    $protocol .= '://';
    return $protocol;
}

function GetServerURL(): string
{
    return GetServerProtocol() . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
}

/**
 * @throws Exception
 */
function install_execute_sql_file($cnnct, $path, $dbprefix, $dbname): bool
{
    $lines = file($path);
    if (empty($lines)) {
        $result['err'] = "<span class='alert'>Sorry, An Error Occured</span>'";
        die(json_encode($result));
    }

    $templine = '';
    mysqli_begin_transaction($cnnct);
    try {
        foreach ($lines as $line) {
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                $templine = preg_replace("/{tbl_prefix}/", $dbprefix, $templine);
                $templine = preg_replace("/{dbname}/", $dbname, $templine);
                mysqli_query($cnnct, $templine);
                if ($cnnct->error != '') {
                    $result['err'] = "<span class='alert'><b>SQL</b> : " . $templine . "<br/><b>Error</b> : " . $cnnct->error . "</span>";
                    mysqli_rollback($cnnct);
                    die(json_encode($result));
                }
                $templine = '';
            }
        }
    } catch (Exception $e) {
        $result['err'] = "<span class='alert'><b>SQL</b> : " . $templine . "<br/><b>Error</b> : " . $cnnct->error . "</span>";
        mysqli_rollback($cnnct);
        die(json_encode($result));
    }

    mysqli_commit($cnnct);
    return true;
}
