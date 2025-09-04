<?php
// This script runs only via command line
ini_set('max_execution_time', '0');
const THIS_PAGE = 'video_convert';

include(dirname(__FILE__) . '/../includes/config.inc.php');
require_once DirPath::get('classes') . 'sLog.php';

/*
    getting the arguments
    $argv[1] => first argument, in our case its the path of the file
*/

$fileName = $argv[1] ?? false;
if (empty($fileName)) {
    die();
}

$audio_track = $argv[2] ?? false;

$videoDetails = CBvideo::getInstance()->get_video($fileName, true);
$ext = $videoDetails['file_type'];
$file_directory = $videoDetails['file_directory'] . DIRECTORY_SEPARATOR;
$logFile = DirPath::get('logs') . $file_directory . $fileName . '.log';

$log = new SLog($logFile);
switch ($ext) {
    default:
    case 'mp4':
        $orig_file = DirPath::get('conversion_queue') . $fileName . '.' . $ext;
        break;
    case 'hls':
        $conversion_path = DirPath::get('conversion_queue') . $fileName . DIRECTORY_SEPARATOR;
        $orig_file = $conversion_path . $fileName . '.m3u8';
        break;
}

$log->newSection('Starting conversion' );
$log->writeLine(date('Y-m-d H:i:s') . ' - Filename : ' . $fileName);
$log->writeLine(date('Y-m-d H:i:s') . ' - File directory : ' . $file_directory);
$log->writeLine(date('Y-m-d H:i:s') . ' - Moving file to conversion queue...');

switch ($ext) {
    default:
    case 'mp4':
        // Delete the uploaded file from temp directory
        // and move it into the conversion queue directory for conversion
        $temp_file = DirPath::get('temp') . $fileName . '.' . $ext;
        $renamed = rename($temp_file, $orig_file);
        break;
    case 'hls':
        $temp_dir = DirPath::get('temp') . $fileName . DIRECTORY_SEPARATOR;
        $temp_file = $temp_dir . '*';
        mkdir($conversion_path);
        foreach (glob($temp_file) as $file) {
            $files_part = explode('/', $file);
            $video_file = $files_part[count($files_part) - 1];
            $renamed = rename($file, $conversion_path . $video_file);
        }
        rmdir($temp_dir);
        break;
}

if (!$renamed) {
    $log->writeLine(date('Y-m-d H:i:s') . ' => Something went wrong while moving file ' . $temp_file . ' ...');
    setVideoStatus($videoDetails['videoid'], 'Failed');
    die();
}

$log->writeLine(date('Y-m-d H:i:s') . ' => File moved to ' . $orig_file);

$ffmpeg = new FFMpeg($log);
$ffmpeg->conversion_type = config('conversion_type');
$ffmpeg->input_file = $orig_file;
$ffmpeg->file_directory = $file_directory;
$ffmpeg->file_name = $fileName;

if ($audio_track && is_numeric($audio_track)) {
    $ffmpeg->audio_track = $audio_track;
}

$fields = ['file_type', 'status'];
$values = [$ffmpeg->conversion_type, 'Waiting'];

update_video_by_filename($fileName, $fields, $values);

$ffmpeg->ClipBucket();

$video_files = json_encode($ffmpeg->video_files);

$fields = ['video_files', 'duration'];
$values = [$video_files, (int)$ffmpeg->input_details['duration']];

if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '273') && !empty($ffmpeg->input_details['fov'])) {
    $fields[] = 'fov';
    $values[] = $ffmpeg->input_details['fov'];
}

if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279')) {
    $fields[] = 'convert_percent';
    $values[] = 100;
}

update_video_by_filename($fileName, $fields, $values);

$videoDetails = CBvideo::getInstance()->get_video($fileName, true);
if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
    $queue = VideoConversionQueue::getOne(['videoid' => $videoDetails['videoid'], 'not_complete' => true]);
    Clipbucket_db::getInstance()->update(tbl(VideoConversionQueue::getTableName()), ['date_ended', 'is_completed'],['|no_mc||f|NOW()', true], 'id = ' . mysql_clean($queue['id']));
}
update_bits_color($videoDetails);
update_castable_status($videoDetails);

$active = config('activation') ? 'no' : 'yes';
if (config('video_enable_nsfw_check') == 'yes' && AIVision::isAvailable()) {
    $thumbs = get_thumb($videoDetails, true, 'original', 'auto', null, 'filepath');

    if (!empty($thumbs)) {
        switch (config('video_nsfw_check_model')) {
            default:
            case 'nudity+nsfw':
                $models = [
                    'nudity',
                    'nsfw'
                ];
                break;
            case 'nsfw':
            case 'nudity':
                $models = [config('video_nsfw_check_model')];
                break;
        }

        foreach ($models as $model) {
            $ia = new AIVision([
                'modelType' => $model,
                'autoload'  => true
            ]);

            foreach ($thumbs as $thumb) {
                if ($ia->is($thumb, $model)) {
                    $active = 'no';
                    if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '255')) {
                        Flag::flagItem($videoDetails['videoid'], 'video', array_search('sexual_content', Flag::getFlagTypes()), 0);
                    }
                    break 2;
                }
            }
        }
    }
}
if ($active == 'yes') {
    Clipbucket_db::getInstance()->update(tbl('video'), ['active'], ['yes'], 'videoid = ' . mysql_clean($videoDetails['videoid']));
}

$default_cmd = System::get_binaries('php') . ' -q ' . DirPath::get('actions') . 'verify_converted_videos.php ' . $fileName;
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
    case 'hls':
        foreach (glob($conversion_path . '*') as $file) {
            unlink($file);
        }
        rmdir($conversion_path);
}
