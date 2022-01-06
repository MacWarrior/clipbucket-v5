<?php
// This script runs only via command line
sleep(5);
define('THIS_PAGE','video_convert');

include(dirname(__FILE__).'/../includes/config.inc.php');
require_once( dirname( __FILE__, 2 ) .'/includes/classes/sLog.php');

global $db;

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
$queue_details = get_queued_video(true, $fileName);

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
if(!empty($_filename))
{
    $temp_file = TEMP_DIR.DIRECTORY_SEPARATOR.$_filename.'.'.$tmp_ext;
    $orig_file = CON_DIR.DIRECTORY_SEPARATOR.$_filename.'.'.$ext;

    /*
        Delete the uploaded file from temp directory
        and move it into the conversion queue directory for conversion
    */
    $renamed = rename( $temp_file, $orig_file );

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

    $db->update(tbl('video'), array('file_type'), array($ffmpeg->conversion_type), " file_name = '{$_filename}'");

    $ffmpeg->ClipBucket();

    $video_files = json_encode($ffmpeg->video_files);
    $db->update(tbl('video'), array('video_files'), array($video_files), " file_name = '{$_filename}'");

    if( config('chromecast_fix') ){
        $db->update(tbl('video'), array('is_castable'), array(true), " file_name = '{$_filename}'");
    }

    $vidDetails = $ffmpeg->get_file_info();
    if( !config('force_8bits') || $vidDetails['bits_per_raw_sample'] <= 8 ){
        $db->update(tbl('video'), array('bits_color'), array($vidDetails['bits_per_raw_sample']), " file_name = '{$_filename}'");
    } else if( config('force_8bits') ){
        $db->update(tbl('video'), array('bits_color'), array(8), " file_name = '{$_filename}'");
    }

    if( $reconvert ) {
        setVideoStatus( $_filename, 'completed', true, true );
    }

    if (stristr(PHP_OS, 'WIN'))
    {
        exec(php_path().' -q '.BASEDIR."/actions/verify_converted_videos.php $orig_file");
    } elseif(stristr(PHP_OS, 'darwin')) {
        exec(php_path().' -q '.BASEDIR."/actions/verify_converted_videos.php $orig_file </dev/null >/dev/null &");
    } else {
        exec(php_path().' -q '.BASEDIR."/actions/verify_converted_videos.php $orig_file &> /dev/null &");
    }

    unlink($orig_file);
}
