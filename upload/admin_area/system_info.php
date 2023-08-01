<?php
require_once '../includes/admin_config.php';

global $db, $userquery, $myquery;
$userquery->admin_login_check();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('system_info'), 'url' => ADMIN_BASEURL . '/cb_server_conf_info.php'];

/** hosting */
$post_max_size = ini_get('post_max_size');
$memory_limit = ini_get('memory_limit');
$upload_max_filesize = ini_get('upload_max_filesize');
$max_execution_time = ini_get('max_execution_time');

assign("post_max_size", $post_max_size);
assign("memory_limit", $memory_limit);
assign("upload_max_filesize", $upload_max_filesize);
assign("max_execution_time", $max_execution_time);
assign('VERSION', VERSION);

/** services info */
$ffmpegVersion = check_version('ffmpeg');
assign('ffmpegVersion', $ffmpegVersion);


assign('phpVersionWeb', phpversion());

$media_info = check_version('media_info');
assign('media_info', $media_info);

$ffprobe_path = check_version('ffprobe');
assign('ffprobe_path', $ffprobe_path);

/** php info web */
ob_start();
phpinfo();
$phpinfo = ob_get_clean();
$phpinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$phpinfo);
assign('php_info', $phpinfo);

/** php info cli */
$row = $myquery->Get_Website_Details();
$cmd = $row['php_path'] . ' ' . BASEDIR . DIRECTORY_SEPARATOR . 'phpinfo.php';
exec($cmd, $exec_output);
assign('cli_php_info', implode('<br/>',$exec_output));

$post_max_size_cli = 0;
$memory_limit_cli = 0;
$upload_max_filesize_cli = 0;
$max_execution_time_cli = 1;
$phpVersion = 0;
if (empty($exec_output)) {
    e(lang('php_cli_not_found'));
} else {
    $reg = '/^(\w*) => (-?\w*).*$/';
    $regVersion = '/^(\w* \w*) => (.*)$/';
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
        }
    }
}

assign('isNginx', (strpos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false) );
assign('phpVersionCli', $phpVersion);
assign("post_max_size_cli", $post_max_size_cli);
assign("memory_limit_cli", $memory_limit_cli);
assign("upload_max_filesize_cli", $upload_max_filesize_cli);
assign("max_execution_time_cli", $max_execution_time_cli);
subtitle(lang('system_info'));
template_files("system_info.html");
display_it();
