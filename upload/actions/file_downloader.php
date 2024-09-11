<?php
define('THIS_PAGE', 'file_downloader');

global $cbvid, $Upload;

include('../includes/config.inc.php');
include('../includes/classes/curl/class.curl.php');
ini_set('max_execution_time', 3000);

if (isset($_POST['check_url'])) {
    $url = $_POST['check_url'];

    $types_array = preg_replace('/,/', ' ', strtolower(config('allowed_video_types')));
    $types_array = explode(' ', $types_array);
    $file_ext = getExt($url);

    if (checkRemoteFile($url) && in_array($file_ext, $types_array)) {
        echo json_encode(['ok' => 'yes']);
    } else {
        echo json_encode(['err' => 'Invalid remote url']);
    }
    exit();
}

/**
 * Call back function of cURL handlers
 * when it downloads a file, it works with php >= 5.3.0
 * @param $download_size total file size of the file
 * @param $downloaded total file size that has been downloaded
 * @param $upload_size total file size that has to be uploaded
 * @param $uploadsed total file size that is uploaded
 *
 * Writes the log in file
 */

if (!isCurlInstalled()) {
    exit(json_encode(['error' => 'Sorry, we do not support remote upload']));
}

//checking if user is logged in or not
if (!user_id()) {
    exit(json_encode(['error' => 'You are not logged in']));
}

/*Setting up file name for the video to be converted*/
$file_name = time() . RandomString(5);

$logDetails = [];

/*
A callback accepting five parameters. The first is the cURL resource, 
the second is the total number of bytes expected to be downloaded in 
this transfer, the third is the number of bytes downloaded so far, 
the fourth is the total number of bytes expected to be uploaded in 
this transfer, and the fifth is the number of bytes uploaded so far. 
*/

function callback($resource, $download_size, $downloaded, $upload_size, $uploaded)
{
    global $log_file, $logDetails;

    $fo = fopen($log_file, 'w+');

    if (is_object($resource)) {
        $curl_info = [
            'total_size' => $download_size,
            'downloaded' => $downloaded
        ];
    } else {
        // for some curl extensions
        $curl_info = [
            'total_size' => $resource,
            'downloaded' => $download_size
        ];
    }
    fwrite($fo, json_encode($curl_info));
    $logDetails = $curl_info;
    fclose($fo);
}

$file = $_POST['file'];

$log_file = DirPath::get('temp') . $file_name . '_curl_log.cblog';

//For PHP < 5.3.0
$dummy_file = DirPath::get('temp') . $file_name . '_curl_dummy.cblog';

$ext = getExt($file);
$svfile = DirPath::get('temp') . $file_name . '.' . $ext;

//Checking for the url
if (empty($file)) {
    echo 'error';
    $array['error'] = 'Please enter file url';
    echo json_encode($array);
    exit();
}
//Checking if extension is wrong
$types = strtolower(ClipBucket::getInstance()->configs['allowed_video_types']);
$types_array = preg_replace('/,/', ' ', $types);
$types_array = explode(' ', $types_array);

$extension_whitelist = $types_array;
if (!in_array($ext, $extension_whitelist)) {
    $array['error'] = 'This file type is not allowed : ' . $ext . ' (' . $file . ')';
    echo json_encode($array);
    exit();
}

$curl = new curl($file);
$curl->setopt(CURLOPT_FOLLOWLOCATION, true);


//Checking if file size is not that goood
if (!is_numeric($curl->file_size) || $curl->file_size == '') {
    $array['error'] = 'Unknown file size';
    echo json_encode($array);
    exit();
}

//Opening video file
$temp_fo = fopen($svfile, 'w+');
$curlOpt = '';
$curl->setopt(CURLOPT_FILE, $temp_fo);
$curl->exec();

if ($theError = $curl->hasError()) {
    $array['error'] = $theError;
    echo json_encode($array);
}

//Finish Writing File
fclose($temp_fo);

sleep(2);
$details = $logDetails;
$targetFileName = $file_name . '.' . $ext;
$Upload->add_conversion_queue($targetFileName);

if (file_exists($log_file)) {
    unlink($log_file);
}
if (file_exists($dummy_file)) {
    unlink($dummy_file);
}

//Inserting data
$title = urldecode(mysql_clean(getName($file)));
$title = $title ?: 'Untitled';

$vidDetails = [
    'title'          => $title,
    'description'    => $title,
    'duration'       => $total,
    'tags'           => genTags(str_replace(' ', ', ', $title)),
    'category'       => [Category::getInstance()->getDefaultByType('video')['category_id']],
    'file_name'      => $file_name,
    'userid'         => user_id(),
    'file_directory' => create_dated_folder()
];

$vid = $Upload->submit_upload($vidDetails);

echo json_encode(['vid' => $vid]);
$file_dir = $vidDetails['file_directory'];
$logFile = DirPath::get('logs') . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.log';

if (stristr(PHP_OS, 'WIN')) {
    exec(System::get_binaries('php') . ' -q ' . DirPath::get('actions') . 'video_convert.php ' . $targetFileName . ' sleep');
} else {
    exec(System::get_binaries('php') . ' -q ' . DirPath::get('actions') . 'video_convert.php ' . $targetFileName . ' ' . $file_name . ' ' . $file_dir . ' ' . $logFile . ' > /dev/null &');
}
