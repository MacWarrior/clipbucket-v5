<?php
define('THIS_PAGE', 'system_info');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $db, $myquery;
userquery::getInstance()->admin_login_check();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('system_info'), 'url' => DirPath::getUrl('admin_area') . 'cb_server_conf_info.php'];

$isNginx = (strpos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false);
$can_access_nginx = false;
$client_max_body_size = '';
if( $isNginx ){
    if( System::check_php_function('exec', 'web', false) ){
        $nginx_path = System::get_binaries('nginx', false);
        if( !empty($nginx_path) ){
            $client_max_body_size = exec($nginx_path.' -T 2>&1 | grep client_max_body_size | awk \'BEGIN{RS=";"; FS="client_max_body_size "}NF>1{print $NF}\'');

            if( !empty($client_max_body_size) ){
                $can_access_nginx = true;
            }
        }
    } else {
        $can_access_nginx = false;
    }
}

assign('post_max_size', ini_get('post_max_size'));
assign('memory_limit', ini_get('memory_limit'));
assign('upload_max_filesize', ini_get('upload_max_filesize'));
assign('max_execution_time', ini_get('max_execution_time'));
assign('isNginx', $isNginx);
assign('canAccessNginx', $can_access_nginx);
assign('clientMaxBodySize', $client_max_body_size);

assign('phpWebExec', System::check_php_function('exec', 'web', false));
assign('phpWebShellExec', System::check_php_function('shell_exec', 'web', false));
assign('phpCliExec', System::check_php_function('exec', 'cli', false));
assign('phpCliShellExec', System::check_php_function('shell_exec', 'cli', false));

$phpVersionReq = '7.0.0';
assign('phpVersionReq',$phpVersionReq);
$php_web_version = System::get_software_version('php_web',false);
assign('phpVersionWeb', $php_web_version);
assign('phpVersionWebOK', $php_web_version >= $phpVersionReq);

$ffReq = '3';
$ffmpeg_version = System::get_software_version('ffmpeg', false);
assign('ffmpegVersion', $ffmpeg_version);
assign('ffmpegVersionOK', $ffmpeg_version >= $ffReq);

$ffprobe_version = System::get_software_version('ffprobe', false);
assign('ffprobe_path', $ffprobe_version);
assign('ffprobe_path_OK', $ffprobe_version >= $ffReq);

$media_info = System::get_software_version('media_info', false);
assign('media_info', $media_info);

$git_version = System::get_software_version('git', false);
assign('git_version', $git_version);

/** php info web */
ob_start();
phpinfo();
$phpinfo = ob_get_clean();
$phpinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$phpinfo);
assign('php_info', $phpinfo);

$php_cli_info = implode('<br/>',System::get_php_cli_info());
assign('cli_php_info', $php_cli_info);

$mysqlReq='5.6.0';
$clientMySqlVersion = System::get_software_version('mysql_client');
assign('clientMySqlVersion', $clientMySqlVersion);
assign('clientMySqlVersionOk', (version_compare($clientMySqlVersion, $mysqlReq) >= 0));

$serverMySqlVersion = getMysqlServerVersion()[0]['@@version'];
$regex_version = '(\d+\.\d+\.\d+)';
preg_match($regex_version, $serverMySqlVersion, $match_mysql);
$serverMySqlVersion = $match_mysql[0] ?? false;
assign('serverMySqlVersion', $serverMySqlVersion);
assign('serverMySqlVersionOk', (version_compare($serverMySqlVersion, $mysqlReq) >= 0));

$extensionsCLI = System::get_php_extensions('cli');
if (empty($php_cli_info)) {
    e(lang('php_cli_not_found'));
}
$phpVersionCli = System::get_software_version('php_cli');

$modulesWeb = System::get_php_extensions('web');

$extensionMessages = [
    'gd' => 'GD library Version',
    'mbstring' => 'libmbfl version',
    'mysqli' => 'Client API library version',
    'curl' => 'cURL Information',
    'xml' => 'libxml2 Version'
];

$extensionsWEB = [];
foreach ($extensionMessages as $extension => $version) {
    $res = $modulesWeb[$extension];
    if (!empty($res)) {
        if (empty($modulesWeb[$extension][$version]) && $extension == 'gd') {
            $extensionsWEB[$extension] = $modulesWeb[$extension]['GD Version'];
        } else {
            $matches = [];
            preg_match($regex_version, $modulesWeb[$extension][$version], $matches);
            $extensionsWEB[$extension] = $matches[0]??$modulesWeb[$extension][$version];
        }
    }
}
assign('phpVersionCli', $phpVersionCli);
assign('phpVersionCliOK', $phpVersionCli >= $phpVersionReq);
assign('post_max_size_cli', System::get_php_cli_config('post_max_size') ?? 0);
assign('memory_limit_cli', System::get_php_cli_config('memory_limit') ?? 0);
assign('upload_max_filesize_cli', System::get_php_cli_config('upload_max_filesize') ?? 0);
assign('max_execution_time_cli', System::get_php_cli_config('max_execution_time') ?? 1);
assign('extensionsCLI', $extensionsCLI);
assign('extensionsWEB', $extensionsWEB);

subtitle(lang('system_info'));
template_files("system_info.html");
display_it();
