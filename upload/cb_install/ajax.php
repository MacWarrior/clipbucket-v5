<?php
define('THIS_PAGE', 'cb_install');

require_once dirname(__DIR__ ). DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
require_once DirPath::get('classes') . 'update.class.php';
require_once DirPath::get('includes') . 'clipbucket.php';
require_once DirPath::get('cb_install') . 'functions_install.php';

$mode = $_POST['mode'];

$result = [];
$dbhost = $_POST['dbhost'];
$dbpass = $_POST['dbpass'];
$dbuser = $_POST['dbuser'];
$dbname = $_POST['dbname'];
$dbprefix = $_POST['dbprefix'];

try{
    $cnnct = mysqli_connect($dbhost, $dbuser, $dbpass);

    try{
        $dbselect = mysqli_select_db($cnnct, $dbname);
        mysqli_query($cnnct, 'SET NAMES "utf8mb4"');
    }
    catch(\Exception $e){
        $result['err'] = "<span class='alert'>Unable to select database : " . $e->getMessage() . '</span>';
    }
}
catch(\Exception $e){
    $result['err'] = "<span class='alert'>Unable to connect to mysql : " . $e->getMessage() . '</span>';
}


if ($mode == 'dataimport' || !empty($result['err'])) {
    die(json_encode($result));
}

if ($mode == 'adminsettings') {

    $step = $_POST['step'];
    $files = [
        'structure'       => 'structure.sql',
        'version'         => 'table_version.sql',
        'configs'         => 'configs.sql',
        'languages'       => 'languages.sql',
        'language_ENG'    => 'language_ENG.sql',
        'language_FRA'    => 'language_FRA.sql',
        'language_DEU'    => 'language_DEU.sql',
        'language_POR'    => 'language_POR.sql',
        'ads_placements'  => 'ads_placements.sql',
        'countries'       => 'countries.sql',
        'email_templates' => 'email_templates.sql',
        'pages'           => 'pages.sql',
        'user_levels'     => 'user_levels.sql'
    ];

    $next = false;
    if (array_key_exists($step, $files) && $step) {
        $total = count($files);
        $count = 0;
        foreach ($files as $key => $file) {
            $count++;
            if ($next) {
                $next = $key;
                break;
            }
            if ($key == $step) {
                $current = $step;
                if ($count < $total) {
                    $next = true;
                }
            }
        }

        if (!$next) {
            $next = 'add_admin';
            $next_msg = 'adding admin account..';
        }

        if ($current) {
            install_execute_sql_file($cnnct, DirPath::get('sql') . $files[$current], $dbprefix, $dbname);
        }

        $return = [];
        $return['msg'] = '<div class="ok green">' . $files[$current] . ' has been imported successfully</div>';

        if (@$files[$next]) {
            $return['status'] = 'importing ' . $files[$next];
        } else {
            $return['status'] = $next_msg;
        }

        $return['step'] = $next;

        if ($step == 'configs') {
            $sql = 'UPDATE ' . $dbprefix . 'config SET value = "' . $cnnct->real_escape_string(exec('which php')) . '" WHERE name = "php_path"';
            mysqli_query($cnnct, $sql);
            $sql = 'UPDATE ' . $dbprefix . 'config SET value = "' . $cnnct->real_escape_string(exec('which ffmpeg')) . '" WHERE name = "ffmpegpath"';
            mysqli_query($cnnct, $sql);
            $sql = 'UPDATE ' . $dbprefix . 'config SET value = "' . $cnnct->real_escape_string(exec('which ffprobe')) . '" WHERE name = "ffprobe_path"';
            mysqli_query($cnnct, $sql);
            $sql = 'UPDATE ' . $dbprefix . 'config SET value = "' . $cnnct->real_escape_string(exec('which mediainfo')) . '" WHERE name = "media_info"';
            mysqli_query($cnnct, $sql);
        }
        //update database version from last json
        $versions = json_decode(file_get_contents(DirPath::get('changelog') . 'latest.json', false), true);
        $state = 'STABLE';
        if ($versions['stable'] != $versions['dev']) {
            $state = 'DEV';
        }
        if ($step == 'version') {
            $last_version = $versions[strtolower($state)];
            $changelog = json_decode(file_get_contents(DirPath::get('changelog') . $last_version . '.json', false), true);
            $sql = 'INSERT INTO ' . $dbprefix . 'version SET version = \'' . $cnnct->real_escape_string($changelog['version']) . '\' , revision = ' . $cnnct->real_escape_string($changelog['revision']) . ', id = 1
            ON DUPLICATE KEY UPDATE version = \'' . $cnnct->real_escape_string($changelog['version']) . '\' , revision = ' . $cnnct->real_escape_string($changelog['revision']);
            mysqli_query($cnnct, $sql);
        }
    } else {
        switch ($step) {

            case 'add_categories':
                install_execute_sql_file($cnnct, DirPath::get('sql') . 'categories.sql', $dbprefix, $dbname);
                $return['msg'] = '<div class="ok green">Videos, Users, Groups and Collections Categories have been created</div>';
                $return['status'] = 'adding admin account..';
                $return['step'] = 'add_admin';
                break;

            case 'add_admin':
                install_execute_sql_file($cnnct, DirPath::get('sql') . 'add_admin.sql', $dbprefix, $dbname);
                $return['msg'] = '<div class="ok green">Admin account has been created</div>';
                $return['status'] = 'Creating config files...';
                $return['step'] = 'create_files';
                break;

            case 'create_files':
                mysqli_close($cnnct);
                $dbconnect = file_get_contents(DirPath::get('cb_install') . 'config.php');
                $dbconnect = str_replace('_DB_HOST_', $dbhost, $dbconnect);
                $dbconnect = str_replace('_DB_NAME_', $dbname, $dbconnect);
                $dbconnect = str_replace('_DB_USER_', $dbuser, $dbconnect);
                $dbconnect = str_replace('_DB_PASS_', $dbpass, $dbconnect);
                $dbconnect = str_replace('_TABLE_PREFIX_', $dbprefix, $dbconnect);

                $fp = fopen(DirPath::get('includes') . 'config.php', 'w');
                fwrite($fp, $dbconnect);
                fclose($fp);

                $return['msg'] = '<div class="ok green">Config file has been created</div>';
                $return['status'] = 'forwarding you to admin settings..';
                $return['step'] = 'forward';
                break;
        }
    }
    echo json_encode($return);
}