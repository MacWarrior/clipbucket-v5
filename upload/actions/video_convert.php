<?php
// This script runs only via command line
ini_set('max_execution_time', '0');
sleep(5);
define('THIS_PAGE', 'video_convert');

include(dirname(__FILE__) . '/../includes/config.inc.php');
require_once(dirname(__FILE__, 2) . '/includes/classes/sLog.php');

global $cbvideo;

/*
    getting the arguments
    $argv[1] => first argument, in our case its the path of the file
*/

$fileName = $argv[1] ?? false;
//This is exact file name of a video e.g 132456789
$_filename = $argv[2] ?? false;

$file_directory_ = $argv[3] ?? false;
$file_directory = $file_directory_ . DIRECTORY_SEPARATOR;

$logFile = $argv[4] ?? false;
if (empty($logFile)) {
    $logFile = DirPath::get('logs') . $file_directory . $_filename . '.log';
}

$audio_track = $argv[5] ?? false;
$reconvert = $argv[6] ?? false;

$log = new SLog($logFile);

$log->newSection('Starting conversion');
$log->writeLine(date('Y-m-d H:i:s').' - Filename : '.$fileName);
$log->writeLine(date('Y-m-d H:i:s').' - File directory : '.$file_directory_);
$log->writeLine(date('Y-m-d H:i:s').' - Log file : '.$logFile);

/*
    Getting the videos which are currently in our queue
    waiting for conversion
*/
$extension = getExt($fileName);

$log->writeLine(date('Y-m-d H:i:s').' - Getting file informations from queue...');
switch ($extension) {
    default:
    case 'mp4':
        $queue_filename = $fileName;
        break;
    case 'm3u8':
        $queue_filename = $_filename . '.' . $extension;
        break;
}

$queue_details = get_queued_video($queue_filename);
if( empty($queue_details) ){
    $log->writeLine(date('Y-m-d H:i:s').' - No queued video for '.$queue_filename);
}

if (!$file_directory_) {
    $fileDir = $queue_details['date_added'];
} else {
    $fileDir = $file_directory;
}
$dateAdded = explode(' ', $fileDir);
$dateAdded = array_shift($dateAdded);
$file_directory = implode(DIRECTORY_SEPARATOR, explode('-', $dateAdded));

/*
    Getting the file information from the queue for conversion
*/
$tmp_ext = $queue_details['cqueue_tmp_ext'];
$ext = $queue_details['cqueue_ext'];
if (empty($tmp_ext)) {
    $tmp_ext = $ext;
}

if (!empty($_filename)) {
    $log->writeLine(date('Y-m-d H:i:s').' - Moving file to conversion queue...');
    switch ($ext) {
        default:
        case 'mp4':
            // Delete the uploaded file from temp directory
            // and move it into the conversion queue directory for conversion
            $temp_file = DirPath::get('temp') . $_filename . '.' . $tmp_ext;
            $orig_file = DirPath::get('conversion_queue') . $_filename . '.' . $ext;
            $renamed = rename($temp_file, $orig_file);
            break;
        case 'm3u8':
            $temp_dir = DirPath::get('temp') . $_filename . DIRECTORY_SEPARATOR;
            $temp_files = $temp_dir . '*';
            $conversion_path = DirPath::get('conversion_queue') . $_filename . DIRECTORY_SEPARATOR;
            $orig_file = $conversion_path . $_filename . '.' . $ext;
            mkdir($conversion_path);
            foreach (glob($temp_files) as $file) {
                $files_part = explode('/', $file);
                $video_file = $files_part[count($files_part) - 1];
                rename($file, $conversion_path . $video_file);
            }
            rmdir($temp_dir);
            break;
    }

    if ($renamed) {
        $log->writeLine(date('Y-m-d H:i:s').' => File moved to '.$orig_file);
    } else {
        $log->writeLine(date('Y-m-d H:i:s').' => Something went wrong while moving file...');
    }

    require_once(DirPath::get('classes') . 'conversion/ffmpeg.class.php');

    $ffmpeg = new FFMpeg($log);
    $ffmpeg->conversion_type = config('conversion_type');
    $ffmpeg->input_file = $orig_file;
    $ffmpeg->file_directory = $file_directory;
    $ffmpeg->file_name = $_filename;

    if ($audio_track && is_numeric($audio_track)) {
        $ffmpeg->audio_track = $audio_track;
    }

    Clipbucket_db::getInstance()->update(tbl('video'), ['file_type', 'status'], [$ffmpeg->conversion_type, 'Waiting'], ' file_name = \''.display_clean($_filename).'\'');

    $ffmpeg->ClipBucket();

    $video_files = json_encode($ffmpeg->video_files);
    Clipbucket_db::getInstance()->update(tbl('video'), ['video_files', 'duration'], [$video_files, (int)$ffmpeg->input_details['duration']], ' file_name = \''.display_clean($_filename).'\'');

    $videoDetails = $cbvideo->get_video($queue_details['cqueue_name'], true);

    update_bits_color($videoDetails);
    update_castable_status($videoDetails);

    if ($reconvert) {
        setVideoStatus($_filename, 'completed', $reconvert, true);
    }

    $default_cmd = System::get_binaries('php') . ' -q ' . DirPath::get('actions') . 'verify_converted_videos.php ' . $queue_details['cqueue_name'];
    if (stristr(PHP_OS, 'WIN')) {
        $complement = '';
    } elseif (stristr(PHP_OS, 'darwin')) {
        $complement = ' </dev/null >/dev/null &';
    } else {
        $complement = ' &> /dev/null &';
    }
    exec($default_cmd . $complement);

    switch ($ext) {
        default:
        case 'mp4':
            unlink($orig_file);
            break;
        case 'm3u8':
            foreach (glob($conversion_path . '*') as $file) {
                unlink($file);
                rmdir($conversion_path);
            }
    }
}
