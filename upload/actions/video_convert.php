<?php
// This script runs only via command line
sleep(5);
define('THIS_PAGE','video_convert');

include(dirname(__FILE__).'/../includes/config.inc.php');
require_once( dirname( __FILE__, 2 ) .'/includes/classes/sLog.php');

global $db,$cbvideo;

/*
    getting the arguments
    $argv[1] => first argument, in our case its the path of the file
*/

$fileName = $argv[1] ?? false;
//This is exact file name of a video e.g 132456789
$_filename = $argv[2] ?? false;

$file_directory_ = $argv[3] ?? false;
$file_directory = $file_directory_.DIRECTORY_SEPARATOR;

$logFile = $argv[4] ?? false;
if (empty($logFile)) {
    $logFile = LOGS_DIR.DIRECTORY_SEPARATOR.$file_directory.$_filename.'.log';
}

$audio_track = $argv[5] ?? false;
$reconvert = $argv[6] ?? false;

$log = new SLog($logFile);

$log->newSection('Starting Conversion Log');
$TempLogData = "Filename : {$fileName}\n";
$TempLogData .= "File directory : {$file_directory_}\n";
$TempLogData .= "Log file : {$logFile}\n";
$log->writeLine("Getting Arguments",$TempLogData, true, true);

/*
    Getting the videos which are currently in our queue
    waiting for conversion
*/
$extension = getExt($fileName);

switch($extension)
{
    default:
    case 'mp4':
        $queue_details = get_queued_video($fileName);
        break;
    case 'm3u8':
        $queue_details = get_queued_video($_filename.'.'.$extension);
        break;
}

$log->writeLine('Conversion queue','Getting the file information from the queue for conversion', true);

if(!$file_directory_){
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
$tmp_ext  = $queue_details['cqueue_tmp_ext'];
$ext 	  = $queue_details['cqueue_ext'];
if( empty($tmp_ext) ) {
    $tmp_ext = $ext;
}
if(!empty($_filename))
{
    switch($ext){
        default:
        case 'mp4':
            // Delete the uploaded file from temp directory
            // and move it into the conversion queue directory for conversion
            $temp_file = TEMP_DIR.DIRECTORY_SEPARATOR.$_filename.'.'.$tmp_ext;
            $orig_file = CON_DIR.DIRECTORY_SEPARATOR.$_filename.'.'.$ext;
            $renamed = rename( $temp_file, $orig_file );
            break;
        case 'm3u8':
            $temp_dir = TEMP_DIR.DIRECTORY_SEPARATOR.$_filename.DIRECTORY_SEPARATOR;
            $temp_files = $temp_dir.'*';
            $conversion_path = CON_DIR.DIRECTORY_SEPARATOR.$_filename.DIRECTORY_SEPARATOR;
            $orig_file = $conversion_path.$_filename.'.'.$ext;
            mkdir($conversion_path);
            foreach(glob($temp_files) as $file){
                $files_part = explode('/',$file);
                $video_file = $files_part[count($files_part)-1];
                rename($file, $conversion_path.$video_file);
            }
            rmdir($temp_dir);
            break;
    }

    if ($renamed){
        $log->writeLine('Conversion queue','File has been moved from temporary dir to Conversion Queue', true);
    } else {
        $log->writeLine('Conversion queue','Something went wrong in moving the file to Conversion Queue', true);
    }

    require_once(BASEDIR.'/includes/classes/conversion/ffmpeg.class.php');

    $ffmpeg = new FFMpeg($log);
    $ffmpeg->conversion_type = config('conversion_type');
    $ffmpeg->input_file = $orig_file;
    $ffmpeg->file_directory = $file_directory;
    $ffmpeg->file_name = $_filename;

    if( $audio_track && is_numeric($audio_track) ){
        $ffmpeg->audio_track = $audio_track;
    }

    $db->update(tbl('video'), ['file_type'], [$ffmpeg->conversion_type], " file_name = '{$_filename}'");

    $ffmpeg->ClipBucket();

    $video_files = json_encode($ffmpeg->video_files);
    $db->update(tbl('video'), ['video_files'], [$video_files], " file_name = '{$_filename}'");

    $videoDetails = $cbvideo->get_video($queue_details['cqueue_name'],true);
    update_bits_color($videoDetails);
    update_castable_status($videoDetails);

    if( $reconvert ) {
        setVideoStatus($_filename, 'completed', true, true);
    }

    if (stristr(PHP_OS, 'WIN')) {
        exec(php_path().' -q '.BASEDIR.'/actions/verify_converted_videos.php '.$queue_details['cqueue_name']);
    } elseif(stristr(PHP_OS, 'darwin')) {
        exec(php_path().' -q '.BASEDIR."/actions/verify_converted_videos.php {$queue_details['cqueue_name']} </dev/null >/dev/null &");
    } else {
        exec(php_path().' -q '.BASEDIR."/actions/verify_converted_videos.php {$queue_details['cqueue_name']} &> /dev/null &");
    }

    switch($ext){
        default:
        case 'mp4':
            unlink($orig_file);
            break;
        case 'm3u8':
            foreach(glob($conversion_path.'*') as $file){
                unlink($file);
                rmdir($conversion_path);
            }
    }

}
