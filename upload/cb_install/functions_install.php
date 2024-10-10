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

function button($text, $params, $class = 'btn-primary')
{
    echo '<span>&nbsp;</span>';
    echo '<button class="btn ' . $class . '" ' . $params . '>' . $text . '</button>';
    echo '<span>&nbsp;</span>';
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
    $text = $type = '';

    if (!empty($arr['msg'])) {
        $text = $arr['msg'];
        $type = 'ok';
    } else if (!empty($arr['err']) ) {
        $text = $arr['err'];
        $type = 'alert_cross';
    } else if (!empty($arr['war']) ) {
        $text = $arr['war'];
        $type = 'warning';
    }

    return '<span class="msg ' . $type . '">' . $text . '</span>';
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

function get_required_softwares(): array
{
    $softwares = [
        'ffmpeg' => 'FFmpeg',
        'ffprobe' => 'FFprobe',
        'media_info' => 'Media Info',
        'mysql_client' => 'MySQL Client',
        'git' => 'Git'
    ];

    if( System::is_nginx() ){
        $softwares['nginx'] = 'Nginx';
    }
    return $softwares;
}

function get_required_php(): array
{
    return [
        'php_web' => 'PHP Web',
        'php_cli' => 'PHP CLI'
    ];
}

function get_php_functions(): array
{
    return [
        'exec' => 'exec()',
        'shell_exec' => 'shell_exec()'
    ];
}

function get_skippable_options(): array
{
    return [
        'mysql_client' => 'I\'ll use a distant MySQL server',
        'git' => 'I won\'t use integrated update system'
    ];
}

function show_hidden_inputs()
{
    $required_php = get_required_php();
    $required_softwares = get_required_softwares();
    $required_softwares = array_merge($required_php, $required_softwares);

    foreach ($required_softwares as $soft => $name) {
        $input_name = $soft . '_filepath';
        if( !empty($_POST[$input_name]) ){
            echo '<input type="hidden" name="' . $input_name . '" value="' . $_POST[$input_name] . '">';
        }
    }

    $skippable_option = get_skippable_options();
    foreach($skippable_option as $soft => $value){
        $input_name = 'skip_' . $soft;
        if( !empty($_POST[$input_name]) ){
            echo '<input type="hidden" name="' . $input_name . '" value="' . $_POST[$input_name] . '">';
        }
    }
}