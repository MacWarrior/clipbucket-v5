<?php
define('BASEDIR', dirname(__FILE__, 2));

if (!file_exists(BASEDIR . '/files/temp/install.me') && !file_exists(BASEDIR.'/files/temp/install.me.not')) {
    $mode = 'lock';
}

function get_cbla()
{
    $license = file_get_contents(dirname(__FILE__, 2).DIRECTORY_SEPARATOR.'LICENSE');
    $license = str_replace("\n", '<BR>', $license);
    return $license;
}

function button($text, $params = null, $alt = false)
{
    echo '<span ' . $params . '>&nbsp;</span>';
    echo '<span class="btn btn-primary" ' . $params . '>' . $text . '</span>';
    echo '<span ' . $params . '>&nbsp;</span>';
}

function button_green($text, $params = null)
{
    echo '<span ' . $params . '>&nbsp;</span>';
    echo '<span class="btn btn-success" ' . $params . '>' . $text . '</span>';
    echo '<span ' . $params . '>&nbsp;</span>';
}

function button_danger($text, $params = null)
{
    echo '<span ' . $params . '>&nbsp;</span>';
    echo '<span class="btn btn-danger" ' . $params . '>' . $text . '</span>';
    echo '<span ' . $params . '>&nbsp;</span>';
}

function msg_arr($arr)
{
    if (@$arr['msg']) {
        return emsg($arr['msg'], 'ok');
    }
    return emsg($arr['err'], 'alert_cross');
}

if (!function_exists('emsg')) {
    function emsg($text, $type = 'ok')
    {
        return '<span class="msg ' . $type . '">' . $text . '</span>';
    }
}

function check_module($type): array
{
    $return = [];
    switch ($type) {
        case 'php':
            $php_version = phpversion();
            $php_path = exec('which php');
            $req = '7.0.0';
            if ($php_version < $req) {
                $return['err'] = sprintf(_('Found PHP %s but required is PHP %s : %s'), $php_version, $req, $php_path);
            } else {
                $return['msg'] = sprintf(_('Found PHP %s : %s'), $php_version, $php_path);
            }
            break;

        case 'ffmpeg':
            $ffmpeg_path = exec('which ffmpeg');
            $ffmpeg_version = shell_output("$ffmpeg_path -version | head -n1");

            $version = false;
            preg_match("/SVN-r([0-9]+)/i", $ffmpeg_version, $matches);
            if (@$matches[1]) {
                $version = 'r' . $matches[1];
            }
            preg_match("/version ([0-9.]+)/i", $ffmpeg_version, $matches);
            if (@$matches[1]) {
                $version = $matches[1];
            }

            if (!$version) {
                $return['err'] = _('Unable to find FFMPEG');
            } else {
                $return['msg'] = sprintf(_('Found FFMPEG %s : %s'), $version, $ffmpeg_path);
            }
            break;

        case 'ffprobe':
            $ffprobe_path = exec('which ffprobe');
            $ffprobe_version = shell_output("$ffprobe_path -version | head -n1");

            $version = false;
            preg_match("/SVN-r([0-9]+)/i", $ffprobe_version, $matches);
            if (@$matches[1]) {
                $version = 'r' . $matches[1];
            }
            preg_match("/version ([0-9.]+)/i", $ffprobe_version, $matches);
            if (@$matches[1]) {
                $version = $matches[1];
            }

            if (!$version) {
                $return['err'] = _('Unable to find FFPROBE');
            } else {
                $return['msg'] = sprintf(_('Found FFPROBE %s : %s'), $version, $ffprobe_path);
            }
            break;

        case 'media_info':
            $mediainfo_path = exec('which mediainfo');
            $mediainfo_result = shell_output("$mediainfo_path --version");

            $media_info_version = explode('v', $mediainfo_result);
            $version = false;
            if (isset($media_info_version[1])) {
                $version = $media_info_version[1];
            }

            if (!$version) {
                $return['err'] = _('Unable to find Media Info');
            } else {
                $return['msg'] = sprintf(_('Found Media Info %s : %s'), $version, $mediainfo_path);
            }
            break;

        case 'curl':
            $version = false;
            if (function_exists('curl_version')) {
                $version = @curl_version();
            }

            if (!$version) {
                $return['err'] = _('cURL extension is not enabled');
            } else {
                $return['msg'] = sprintf(_('cURL %s extension is enabled'), $version['version']);
            }
            break;
    }
    return $return;
}

if (!function_exists('_')) {
    function _($in)
    {
        return $in;
    }
}

if (!function_exists('shell_output')) {
    function shell_output($cmd)
    {
        if (stristr(PHP_OS, 'WIN')) {
            $cmd = $cmd;
        } else {
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
        'images/category_thumbs',
        'images/collection_thumbs',
        'images/groups_thumbs',
        'includes'
    ];

    $permsArray = [];
    foreach ($files as $file) {
        if (is_writeable(BASEDIR . DIRECTORY_SEPARATOR . $file)) {
            $permsArray[] = ['path' => $file, 'msg' => 'writeable'];
        } else {
            $permsArray[] = ['path' => $file, 'err' => 'please chmod this file/directory to 755'];
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
function install_execute_sql_file($cnnct, $path, $dbprefix): bool
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
                mysqli_query($cnnct, $templine);
                if ($cnnct->error != '') {
                    $result['err'] = "<span class='alert'><b>SQL</b> : ".$templine."<br/><b>Error</b> : ".$cnnct->error."</span>";
                    mysqli_rollback($cnnct);
                    die(json_encode($result));
                }
                $templine = '';
            }
        }
    } catch (Exception $e) {
        $result['err'] = "<span class='alert'><b>SQL</b> : ".$templine."<br/><b>Error</b> : ".$cnnct->error."</span>";
        mysqli_rollback($cnnct);
        die(json_encode($result));
    }

    mysqli_commit($cnnct);
    return true;
}