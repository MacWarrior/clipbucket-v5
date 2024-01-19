<?php
define('THIS_PAGE', 'system_info');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $db, $myquery;
userquery::getInstance()->admin_login_check();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('system_info'), 'url' => DirPath::getUrl('admin_area') . 'cb_server_conf_info.php'];

/** hosting */
$post_max_size = ini_get('post_max_size');
$memory_limit = ini_get('memory_limit');
$upload_max_filesize = ini_get('upload_max_filesize');
$max_execution_time = ini_get('max_execution_time');

$isNginx = (strpos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false);
$can_access_nginx = false;
$client_max_body_size = '';
if( $isNginx ){
    $nginx_path = exec('which nginx');
    if( !empty($nginx_path) ){
        $client_max_body_size = exec($nginx_path.' -T 2>&1 | grep client_max_body_size | awk \'BEGIN{RS=";"; FS="client_max_body_size "}NF>1{print $NF}\'');

        if( !empty($client_max_body_size) ){
            $can_access_nginx = true;
        }
    }
}

assign('post_max_size', $post_max_size);
assign('memory_limit', $memory_limit);
assign('upload_max_filesize', $upload_max_filesize);
assign('max_execution_time', $max_execution_time);
assign('isNginx', $isNginx );
assign('canAccessNginx', $can_access_nginx );
assign('clientMaxBodySize', $client_max_body_size );

/** services info */
$ffReq = '3';
assign('ffReq', $ffReq);
$phpVersionReq = '7.0.0';
assign('phpVersionReq',$phpVersionReq);

$ffmpegVersion = check_version('ffmpeg');
assign('ffmpegVersion', $ffmpegVersion);
assign('ffmpegVersionOK', $ffmpegVersion >= $ffReq);
$ffprobe_path = check_version('ffprobe');
assign('ffprobe_path', $ffprobe_path);
assign('ffprobe_path_OK', $ffprobe_path >= $ffReq);

assign('phpVersionWeb', phpversion());
assign('phpVersionWebOK', phpversion() >= $phpVersionReq);

$media_info = check_version('media_info');
assign('media_info', $media_info);


/** php info web */
ob_start();
phpinfo();
$phpinfo = ob_get_clean();
$phpinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$phpinfo);
assign('php_info', $phpinfo);

/** php info cli */
$row = $myquery->Get_Website_Details();
$cmd = $row['php_path'] . ' ' . DirPath::get('root') . 'phpinfo.php';
exec($cmd, $exec_output);
assign('cli_php_info', implode('<br/>',$exec_output));

$regex_version = '(\d+\.\d+\.\d+)';
$mysqlReq='5.6.0';
assign('mysqlReq', $mysqlReq);
$cmd = 'mysql --version';
exec($cmd, $mysql_client_output);
$match_mysql = [];
preg_match($regex_version, $mysql_client_output[0], $match_mysql);
$clientMySqlVersion = $match_mysql[0] ?? false;
assign('clientMySqlVersion', $clientMySqlVersion);
assign('clientMySqlVersionOk', (version_compare($clientMySqlVersion, $mysqlReq) >= 0));

$serverMySqlVersion = getMysqlServerVersion()[0]['@@version'];
preg_match($regex_version, $serverMySqlVersion, $match_mysql);
$serverMySqlVersion = $match_mysql[0] ?? false;
assign('serverMySqlVersion', $serverMySqlVersion);
assign('serverMySqlVersionOk', (version_compare($serverMySqlVersion, $mysqlReq) >= 0));

$post_max_size_cli = 0;
$memory_limit_cli = 0;
$upload_max_filesize_cli = 0;
$max_execution_time_cli = 1;
$phpVersion = 0;

$extensionsCLI = [];
if (empty($exec_output)) {
    e(lang('php_cli_not_found'));
} else {
    $reg = '/^(\w*) => (-?\w*).*$/';
    $regVersion = '/(\w* \w*) => (.*)$/';
    foreach ($exec_output as $line) {
        $match= [];
        if (strpos($line, 'post_max_size') !== false) {
            preg_match($reg, $line, $match);
            if (!empty($match)) {
                $post_max_size_cli = $match[2];
            }
        } elseif (strpos($line, 'memory_limit') !== false) {
            preg_match($reg, $line, $match);
            if (!empty($match)) {
                $memory_limit_cli = $match[2];
            }
        } elseif (strpos($line, 'upload_max_filesize') !== false) {
            preg_match($reg, $line, $match);
            if (!empty($match)) {
                $upload_max_filesize_cli = $match[2];
            }
        } elseif (strpos($line, 'max_execution_time') !== false) {
            preg_match($reg, $line, $match);
            if (!empty($match)) {
                $max_execution_time_cli = $match[2];
            }
        } elseif (strpos($line, 'PHP Version') !== false) {
            preg_match($regVersion, $line, $match);
            if (!empty($match)) {
                $phpVersion = $match[2];
            }

        } elseif (strpos($line, 'GD library Version') !== false) {
            preg_match($regVersion, $line, $match);
            if (!empty($match)) {
                $extensionsCLI['gd'] = $match[2];
            }

        } elseif (strpos($line, 'libmbfl version') !== false) {
            preg_match($regVersion, $line, $match);
            if (!empty($match)) {
                $extensionsCLI['mbstring'] = $match[2];
            }

        } elseif (strpos($line, 'Client API library version') !== false) {
            preg_match($regVersion, $line, $match);
            if (!empty($match)) {
                $extensionsCLI['mysqli'] = $match[2];
            }

        } elseif (strpos($line, 'libxml2 Version') !== false) {
            preg_match($regVersion, $line, $match);
            if (!empty($match)) {
                $extensionsCLI['xml'] = $match[2];
            }

        } elseif (strpos($line, 'cURL Information') !== false) {
            preg_match($regVersion, $line, $match);
            if (!empty($match)) {
                $extensionsCLI['curl'] = $match[2];
            }
        }
    }
}

$modulesWeb = parseAllPHPModules();

$extensionMessages = [
    'gd' => 'GD library Version',
    'mbstring' => 'libmbfl version',
    'mysqli' => 'Client API library version',
    'curl' => 'cURL Information',
    'xml' => 'libxml2 Version',
];

$extensionsWEB = [];
foreach ($extensionMessages as $extension => $version) {
    $res = $modulesWeb[$extension];
    if (!empty($res)) {
        if (empty($modulesWeb[$extension][$version]) && $extension == 'gd') {
            $extensionsWEB[$extension] = $modulesWeb[$extension]['GD Version'];
        } else {
            $extensionsWEB[$extension] = $modulesWeb[$extension][$version];
        }
    }
}
assign('phpVersionCli', $phpVersion);
assign('phpVersionCliOK', $phpVersion >= $phpVersionReq);
assign('versionMySQLOK', $versionMySQLOK ?? false);
assign('versionMySQLCliOK', $versionMySQLCliOK ?? false);
assign('post_max_size_cli', $post_max_size_cli);
assign('memory_limit_cli', $memory_limit_cli);
assign('upload_max_filesize_cli', $upload_max_filesize_cli);
assign('max_execution_time_cli', $max_execution_time_cli);
assign('extensionsCLI', $extensionsCLI);
assign('extensionsWEB', $extensionsWEB);

subtitle(lang('system_info'));
template_files("system_info.html");
display_it();
