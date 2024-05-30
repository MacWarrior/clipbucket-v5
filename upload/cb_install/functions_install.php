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

function check_extension($extension, $type) {
    $reg = '(\d+\.\d+\.\d+)';
    switch ($type) {
        case 'cli':
            $version = System::get_php_extensions('cli')[$extension] ?? false;
            if (!$version) {
                $return['err'] = $extension. ' extension is not enabled';
                break;
            }

            $matches =[];
            preg_match($reg, $version,$matches);
            $return['msg'] = sprintf('%s %s extension is enabled', $extension, $matches[1] ?? $version);
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
                $res = System::get_php_extensions('web')[$extension] ?? false;
                if (empty($res)) {
                    $return['err'] = $extension . ' extension is not enabled';
                } else {
                    $key = $extensionMessages[$extension];
                    if (empty($res[$key]) && $extension == 'gd') {
                        $key='GD Version';
                    }
                    $matches =[];
                    preg_match($reg, $res[$key],$matches);
                    $return['msg'] = sprintf('%s %s extension is enabled', $extension, $matches[0] ?? $res[$key]);
                }
            }
            break;
        default:
            $return = false;
            break;
    }
    return $return;
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

function selected($selected): string
{
    global $mode;
    if ($mode == $selected) {
        return 'class=\'selected\'';
    }
    return '';
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
        $result['err'] = "<span class='alert'>Sorry, An error occured</span>'";
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
