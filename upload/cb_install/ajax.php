<?php
define('THIS_PAGE', 'cb_install');

require_once dirname(__DIR__ ). DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'constants.php';
require_once DirPath::get('vendor') . 'autoload.php';
require_once DirPath::get('classes') . 'DiscordLog.php';
require_once DirPath::get('classes') . 'update.class.php';
require_once DirPath::get('includes') . 'clipbucket.php';
require_once DirPath::get('classes') . 'system.class.php';
require_once DirPath::get('cb_install') . 'functions_install.php';

if (file_exists(DirPath::get('temp') . 'development.dev')) {
    define('DEVELOPMENT_MODE', true);

} else {
    define('DEVELOPMENT_MODE', false);
}

if (!file_exists(DirPath::get('temp') . 'install.me') && !file_exists(DirPath::get('temp') . 'install.me.not')) {
    return false;
}

$mode = $_POST['mode'];

$result = [];
$dbhost = $_POST['dbhost'];
$dbpass = $_POST['dbpass'];
$dbuser = $_POST['dbuser'];
$dbname = $_POST['dbname'];
$dbprefix = $_POST['dbprefix'];
$dbport = $_POST['dbport'];
$reset_db = $_POST['reset_db'] ?? false;

try{
    $cnnct = mysqli_connect($dbhost, $dbuser, $dbpass, null, $dbport);

    try{
        $dbselect = mysqli_select_db($cnnct, $dbname);
        mysqli_query($cnnct, 'SET NAMES "utf8mb4"');

        $res = mysqli_query($cnnct,'SELECT @@version');
        $data=[];
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }
            $res->close();
        }
        $regex_version = '(\d+\.\d+\.\d+)';
        $serverMySqlVersion = $data[0]['@@version'];
        preg_match($regex_version, $serverMySqlVersion, $match_mysql);
        $serverMySqlVersion = $match_mysql[0] ?? $data[0]['@@version'];
        $mysqlReq='5.6.0';
        if (version_compare($serverMySqlVersion, $mysqlReq) < 0) {
            $result['err'] = '<span class="alert">MySql Server (v'.$serverMySqlVersion.') is outdated : version ' . $mysqlReq . ' minimal is required</span>';
        }
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

if ($mode == 'sitesettings') {

    $step = $_POST['step'];
    $files = [
        'structure'       => ['file'=>'structure.sql', 'msg'=>'Creating database structure...'],
        'version'         => ['file'=>'table_version.sql', 'msg'=>'Creating versionning...'],
        'configs'         => ['file'=>'configs.sql', 'msg'=>'Importing configs...'],
        'languages'       => ['file'=>'languages.sql', 'msg'=>'Importing languages...'],
        'language_ENG'    => ['file'=>'language_ENG.sql', 'msg'=>'Importing english translations...'],
        'language_FRA'    => ['file'=>'language_FRA.sql', 'msg'=>'Importing french translations...'],
        'language_DEU'    => ['file'=>'language_DEU.sql', 'msg'=>'Importing deutsch translations...'],
        'language_POR'    => ['file'=>'language_POR.sql', 'msg'=>'Importing portuguese translations...'],
        'language_ESP'    => ['file'=>'language_ESP.sql', 'msg'=>'Importing spanish translations...'],
        'ads_placements'  => ['file'=>'ads_placements.sql', 'msg'=>'Importing ads configurations...'],
        'countries'       => ['file'=>'countries.sql', 'msg'=>'Importing countries list...'],
        'email_templates' => ['file'=>'email_templates.sql', 'msg'=>'Importing email templates...'],
        'pages'           => ['file'=>'pages.sql', 'msg'=>'Importing default pages...'],
        'user_levels'     => ['file'=>'user_levels.sql', 'msg'=>'Importing user levels configurations...']
    ];

    if ($reset_db == 1) {
        $files = ['reset_db'=> ['file'=>'reset_db.sql', 'msg'=>'Dropping previous tables & datas...']] + $files;
    }
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
            $res = false;
            if ($current != 'reset_db' || DEVELOPMENT_MODE) {
                $res = install_execute_sql_file($cnnct, DirPath::get('sql') . $files[$current]['file'], $dbprefix, $dbname);
            }
        }

        $return = [];
        if ($res) {
            $return['msg'] = '<div class="ok green">' . $files[$current]['file'] . ' has been imported successfully</div>';
        }
        if (@$files[$next]) {
            $return['status'] = $files[$next]['msg'];
        } else {
            $return['status'] = $next_msg;
        }

        $return['step'] = $next;

        if ($step == 'configs') {
            $configs = [
                'ffmpeg' => ['which' => 'ffmpeg', 'config' => 'ffmpegpath'],
                'ffprobe' => ['which' => 'ffprobe', 'config' => 'ffprobe_path'],
                'git' => ['which' => 'git', 'config' => 'git_path'],
                'media_info' => ['which' => 'mediainfo', 'config' => 'media_info'],
                'php_cli' => ['which' => 'php', 'config' => 'php_path'],
                'nginx' => ['which' => 'nginx', 'config' => 'nginx_path']
            ];

            $skippable_options = get_skippable_options();

            foreach($configs as $key => $config) {
                if( !empty($skippable_options[$key]) && !empty($_POST['skip_' . $key]) ){
                    continue;
                }

                if( !empty($_POST[$key . '_filepath']) ){
                    $filepath = $_POST[$key . '_filepath'];
                } else {
                    $filepath = System::get_binaries($key);;
                }

                $sql = 'UPDATE ' . $dbprefix . 'config SET value = "' . $cnnct->real_escape_string($filepath) . '" WHERE name = "' . $config['config'] . '"';
                mysqli_query($cnnct, $sql);
            }
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
                install_execute_sql_file($cnnct, DirPath::get('sql') . 'add_anonymous_user.sql', $dbprefix, $dbname);
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
                $dbconnect = str_replace('_DB_PORT_', $dbport, $dbconnect);
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
