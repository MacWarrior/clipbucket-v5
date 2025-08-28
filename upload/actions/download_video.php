<?php
define('THIS_PAGE', 'download_video');
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

$mode = $_GET['mode'];
$videoKey = $_GET['videokey'];

if( empty($videoKey) || empty($mode) ) {
    redirect_to(get_server_url());
}

if( config('videosSection') != 'yes' || ($mode != 'cast ' && !User::getInstance()->hasPermission('view_video')) ){
    redirect_to(get_server_url() . '403.php');
}

$video = Video::getInstance()->getOne(['videokey' => $videoKey]);
if( empty($video) ) {
    redirect_to(get_server_url());
}

if( $video['file_type'] == 'mp4' && empty($_GET['res']) ) {
    redirect_to(get_server_url());
}

$video_playable = video_playable($video);
if( $mode != 'cast' && !$video_playable ) {
    redirect_to(get_server_url());
}

if( $mode == 'download' && !CbVideo::getInstance()->downloadable($video) ){
    redirect_to(get_server_url());
}

if( !$video_playable && $mode == 'cast' && !Video::getInstance($video['videoid'])->isCastAuthed() ){
    redirect_to(get_server_url());
}

$file = false;
if( $video['file_type'] == 'hls' && !empty($_GET['file']) ) {
    $file['filepath'] = DirPath::get('videos') . $video['file_directory'] . DIRECTORY_SEPARATOR . $video['file_name'] . DIRECTORY_SEPARATOR . basename($_GET['file']);
    $file['size'] = filesize($file['filepath']);
} else {
    $video_files = getResolution_list($video);

    if( $video['file_type'] == 'mp4' ){
        foreach($video_files as $video_file) {
            if( $video_file['resolution'] == $_GET['res'] ) {
                $file['size']     = $video_file['size'];
                $file['filepath'] = $video_file['filepath'];
                break;
            }
        }
    } else {
        $file = $video_files[0];
    }

    unset($video_files);
}


if( !$file || !file_exists($file['filepath']) ) {
    redirect_to(get_server_url() . '404.php');
}

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

if( $mode == 'download' ){
    header('Content-Type: application/octet-stream');
    $file_name = preg_replace('/[\x00-\x1F\x7F"\\\\]/', '', $video['title']) . '-' . CB_video_js::getVideoResolutionTitleFromFilePath($_GET['res']) . '.mp4';
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    $buffer_size = 8192;
} else {
    $file_extension = getExt($file['filepath']);
    switch( $file_extension ){
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

    if ($file_extension === 'm3u8') {
        $content = file_get_contents($file['filepath']);
        $content = preg_replace_callback('/(URI="([^"]+\.m3u8)")|([^#].*\.ts)|(^[^#].*\.m3u8)/m', function ($matches) use($videoKey, $mode) {
            if (!empty($matches[2])) {
                return 'URI="./download_video.php?mode=' . $mode . '&videokey=' . $videoKey . '&file=' . urlencode($matches[2]) . '"';
            } elseif (!empty($matches[3])) {
                return "\n" . './download_video.php?mode=' . $mode . '&videokey=' . $videoKey . '&file=' . urlencode(trim($matches[3]));
            } elseif (!empty($matches[4])) {
                return "\n" . './download_video.php?mode=' . $mode . '&videokey=' . $videoKey . '&file=' . urlencode(trim($matches[4]));
            }
        }, $content);

        echo $content;
        exit();
    }
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
    DiscordLog::sendDump('Erreur 500 ?');
    exit('Erreur lors de l\'ouverture du fichier.');
}

fseek($handle, $start);
echo fread($handle, $buffer_size);
flush();

if (connection_aborted()) {
    fclose($handle);
    exit();
}

// TODO : Get user speed limit
$user_dl_limit_speed = 1000;
$limit_enabled = $user_dl_limit_speed > 0;

$speed_limit = max(1, $user_dl_limit_speed);

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
