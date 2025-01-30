<?php
define('THIS_PAGE', 'download_video');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

if( !User::getInstance()->hasPermission('view_video') || config('videosSection') != 'yes' ){
    redirect_to(get_server_url() . '403.php');
}

if( empty($_GET['videokey']) || empty($_GET['res']) || empty($_GET['mode']) ) {
    redirect_to(get_server_url());
}

$video = Video::getInstance()->getOne(['videokey' => $_GET['videokey']]);
if( empty($video) ) {
    redirect_to(get_server_url());
}

// TODO : Refactor this checkup
if( !video_playable($video) ) {
    redirect_to(get_server_url());
}

if( $_GET['mode'] == 'dl' && !CbVideo::getInstance()->downloadable($video) ){
    redirect_to(get_server_url());
}

$video_files = getResolution_list($video);
$file = false;
dump($video_files);die();
foreach($video_files as $video_file) {
    if( $video_file['resolution'] == $_GET['res'] ) {
        $file['size']     = $video_file['size'];
        $file['filepath'] = $video_file['filepath'];
        break;
    }
}

unset($video_files);

if( !$file || !file_exists($file['filepath']) ) {
    redirect_to(get_server_url() . '404.php');
}

$default_speed = 1000;
$limit_enabled = true;

$speed_limit = max(1, $default_speed);

if (isset($_SERVER['HTTP_RANGE'])) {
    list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
    list($start, $end) = explode('-', $range);
    $start = intval($start);
    $end = ($end === '') ? $file['size'] - 1 : intval($end);

    header('HTTP/1.1 206 Partial Content');
    header('Content-Range: bytes ' . $start . '-' . $end . '/' . $file['size']);
} else {
    $start = 0;
    $end = $file['size'] - 1;
    header('HTTP/1.1 200 OK');
}

if( $_GET['mode'] == 'dl' ){
    header('Content-Type: application/octet-stream');
    $file_name = preg_replace('/[\x00-\x1F\x7F"\\\\]/', '', $video['title']) . '-' . CB_video_js::getVideoResolutionTitleFromFilePath($_GET['res']) . '.mp4';
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    $buffer_size = 8192;
} else {
    switch( getExt($file['filepath']) ){
        case 'm3u8':
            header('Content-Type: application/vnd.apple.mpegurl');
            break;
        case 'ts':
            header('Content-Type: video/mp2t');
            header('Accept-Ranges: bytes');
            break;
        default:
            header('Content-Type: video/mp4');
            header('Accept-Ranges: bytes');
            break;
    }
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    header('X-Accel-Buffering: no');
    $buffer_size = 65536;
}

unset($video);
session_destroy();
Clipbucket_db::getInstance()->close();

header('Content-Length: ' . ($end - $start + 1));
header('Connection: close');

ob_end_clean();
flush();

$handle = fopen($file['filepath'], 'rb');
if ($handle === false) {
    header('HTTP/1.0 500 Internal Server Error');
    exit('Erreur lors de l\'ouverture du fichier.');
}

fseek($handle, $start);
echo fread($handle, $buffer_size);
flush();

if (connection_aborted()) {
    fclose($handle);
    exit();
}

while (!feof($handle) && ($pos = ftell($handle)) <= $end) {
    $start_time = microtime(true);

    $buffer_size = min($speed_limit * 1024, $end - $pos + 1);
    echo fread($handle, $buffer_size);
    flush();

    if (connection_aborted()) {
        fclose($handle);
        exit();
    }

    if ($limit_enabled) {
        $elapsed_time = microtime(true) - $start_time;
        $sleep_time = ($buffer_size / ($speed_limit * 1024)) - $elapsed_time;

        if ($sleep_time > 0) {
            usleep((int) ($sleep_time * 1e6));
        }
    }
}

fclose($handle);
exit();
