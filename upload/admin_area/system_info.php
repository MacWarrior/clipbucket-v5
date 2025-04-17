<?php
define('THIS_PAGE', 'system_info');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('advanced_settings', true);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('tool_box'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('system_info'),
    'url'   => DirPath::getUrl('admin_area') . 'system_info.php'
];

//HOSTING
assign('is_cloudflare', Network::is_cloudflare());
assign('cloudflare_upload_limit', config('cloudflare_upload_limit'));
$chunk_upload = config('enable_chunk_upload') == 'yes';
assign('chunk_upload', $chunk_upload);
$chunk_upload_size_mb = config('chunk_upload_size');
assign('chunk_upload_size_mb', $chunk_upload_size_mb);

$post_max_size = ini_get('post_max_size');
$post_max_size_mb = (int)$post_max_size * pow(1024, stripos('KMGT', strtoupper(substr($post_max_size, -1)))) / 1024;
assign('post_max_size', $post_max_size);
assign('post_max_size_mb', $post_max_size_mb);

$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_mb = (int)$upload_max_filesize * pow(1024, stripos('KMGT', strtoupper(substr($upload_max_filesize, -1)))) / 1024;
assign('upload_max_filesize', $upload_max_filesize);
assign('upload_max_filesize_mb', $upload_max_filesize_mb);
assign('target_upload_size', config('max_upload_size'));

$max_upload_size_ok = (config('max_upload_size') < $post_max_size_mb || ($chunk_upload && $chunk_upload_size_mb <= $post_max_size_mb));
assign('max_upload_size_ok', $max_upload_size_ok);
$upload_max_size_ok = $upload_max_filesize_mb >= config('max_upload_size') || ($chunk_upload && $chunk_upload_size_mb <= $upload_max_filesize_mb);
assign('upload_max_size_ok', $upload_max_size_ok);
$memory_limit = ini_get('memory_limit');
assign('memory_limit', $memory_limit);
$memory_limit_ok = (getBytesFromFileSize($memory_limit) >= getBytesFromFileSize('128M') || $memory_limit == -1);
assign('memory_limit_ok', $memory_limit_ok);
$max_execution_time = ini_get('max_execution_time');
$max_execution_time_ok = $max_execution_time >= 7200 || $max_execution_time == 0;
assign('max_execution_time', $max_execution_time);
assign('max_execution_time_ok', $max_execution_time_ok);

$isNginx = System::is_nginx();
$can_access_nginx = false;
$client_max_body_size = '';
$client_max_body_size_mb = '';
if ($isNginx) {
    $client_max_body_size = System::get_nginx_config('client_max_body_size');
    if (empty($client_max_body_size)) {
        $can_access_nginx = false;
    } else {
        $client_max_body_size_mb = (int)$client_max_body_size * pow(1024, stripos('KMGT', strtoupper(substr($client_max_body_size, -1)))) / 1024;
        $can_access_nginx = true;

        $client_max_body_size_ok = ($client_max_body_size_mb <= $post_max_size_mb || ($chunk_upload && $chunk_upload_size_mb <= $client_max_body_size_mb));
        assign('client_max_body_size_ok', $client_max_body_size_ok);
    }
}

$phpWebExec = System::check_php_function('exec', 'web', false);
assign('phpWebExec',$phpWebExec);
$phpWebShellExec = System::check_php_function('shell_exec', 'web', false);
assign('phpWebShellExec',$phpWebShellExec);
$phpWebSSE = System::can_sse();
assign('phpWebSSE',$phpWebSSE);
$phpCliExec = System::check_php_function('exec', 'cli', false);
assign('phpCliExec',$phpCliExec);
$phpCliShellExec = System::check_php_function('shell_exec', 'cli', false);
assign('phpCliShellExec',$phpCliShellExec);

assign('isNginx', $isNginx);
assign('canAccessNginx', $can_access_nginx);
assign('client_max_body_size', $client_max_body_size);
assign('client_max_body_size_mb', $client_max_body_size_mb);
assign('memory_limit_cli', System::get_php_cli_config('memory_limit') ?? 0);
assign('max_execution_time_cli', System::get_php_cli_config('max_execution_time') ?? 1);
assign('disks_usage', System::get_disks_usage());

$check_ffi_cli = in_array(strtolower(System::get_php_cli_config('ffi.enable')), ['1','on']);
$check_ffi_web = in_array(strtolower(ini_get('ffi.enable')), ['1','on']);
assign('ffi_cli', $check_ffi_cli);
assign('ffi_web', $check_ffi_web);

$datetime_datas = [];
$check_time = System::isDateTimeSynchro($datetime_datas);
assign('check_time', $check_time);
assign('datetime_datas', $datetime_datas);

$current_datetime_cli = System::get_php_cli_config('CurrentDatetime');
$datetime_datas_cli = [];
$check_time_cli = System::isDateTimeSynchro($datetime_datas_cli, $current_datetime_cli);
assign('check_time_cli', $check_time_cli);
assign('datetime_datas_cli', $datetime_datas_cli);

assign('hosting_ok', ($max_upload_size_ok && $upload_max_size_ok && $memory_limit_ok && $max_execution_time_ok && $phpWebExec && $phpWebShellExec && $phpCliExec && $phpCliShellExec && $check_time_cli && $check_ffi_cli && $check_ffi_web));

//SERVICES
$phpVersionReq = '7.0.0';
assign('phpVersionReq', $phpVersionReq);
$php_web_version = System::get_software_version('php_web', false, null, true);
assign('phpVersionWeb', $php_web_version);
$phpVersionWebOK = $php_web_version >= $phpVersionReq;
assign('phpVersionWebOK', $phpVersionWebOK);

$ffReq = '3';
$ffmpeg_version = System::get_software_version('ffmpeg', true, null, true);
if (is_array($ffmpeg_version) && array_key_exists('err',$ffmpeg_version)) {
    $ffmpeg_version = 0;
}
assign('ffmpegVersion', $ffmpeg_version);
$ffmpegVersionOK = $ffmpeg_version >= $ffReq;
assign('ffmpegVersionOK', $ffmpegVersionOK);

$ffprobe_version = System::get_software_version('ffprobe', true, null, true);
if (is_array($ffprobe_version) && array_key_exists('err',$ffprobe_version)) {
    $ffprobe_version = 0;
}
assign('ffprobe_path', $ffprobe_version);
$ffprobe_path_OK = $ffprobe_version >= $ffReq;
assign('ffprobe_path_OK', $ffprobe_path_OK);

$media_info = System::get_software_version('media_info', true, null, true);
if (is_array($media_info) && array_key_exists('err',$media_info)) {
    $media_info = 0;
}
assign('media_info', $media_info);

$git_version = System::get_software_version('git', true, null, true);
if (is_array($git_version) && array_key_exists('err',$git_version)) {
    $git_version = 0;
}
assign('git_version', $git_version);

$mysqlReq = '5.6.0';
$serverMySqlVersion = getMysqlServerVersion()[0]['@@version'];
$regex_version = '(\d+\.\d+\.\d+)';
preg_match($regex_version, $serverMySqlVersion, $match_mysql);
$serverMySqlVersion = $match_mysql[0] ?? false;
assign('serverMySqlVersion', $serverMySqlVersion);
$serverMySqlVersionOk = (version_compare($serverMySqlVersion, $mysqlReq) >= 0);
assign('serverMySqlVersionOk', $serverMySqlVersionOk);

$phpVersionCli = System::get_software_version('php_cli');

assign('phpVersionCli', $phpVersionCli);
$phpVersionCliOK = $phpVersionCli >= $phpVersionReq;
assign('phpVersionCliOK', $phpVersionCliOK);

$extensionsCLI = System::get_php_extensions('php_cli');
assign('extensionsCLI', $extensionsCLI);
$extensionsWEB = System::get_php_extensions('php_web');
assign('extensionsWEB', $extensionsWEB);
$php_extensions_list = System::get_php_extensions_list();
assign('php_extensions_list',$php_extensions_list);
$extensions_ok = true;
foreach ($php_extensions_list as $key => $extension) {
    if( !$extension['required'] ){
        continue;
    }
    $extensions_ok = (in_array($key,$extensionsCLI) && in_array($key,$extensionsWEB));
    if (!$extensions_ok) {
        break;
    }
}

assign('services_ok', ($phpVersionWebOK && $phpVersionCliOK && $serverMySqlVersionOk && $ffprobe_path_OK && $ffmpegVersionOK && empty($git_version['err']) && $extensions_ok) );

//PHP_INFO
/** php info web */
ob_start();
phpinfo();
$phpinfo = ob_get_clean();
$phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
assign('php_info', $phpinfo);

$php_cli_info = implode('<br/>', System::get_php_cli_info());
if (empty($php_cli_info)) {
    e(lang('php_cli_not_found'));
}
assign('cli_php_info', $php_cli_info);

//PERMISSIONS
$permissions = System::getPermissions(false);
assign('permissions', $permissions);
assign('permissions_ok', System::checkPermissions($permissions));

subtitle(lang('system_info'));
template_files("system_info.html");
display_it();
