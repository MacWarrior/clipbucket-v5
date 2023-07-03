<?php
define('THIS_PAGE', 'file_downloader');

global $Cbucket, $cbvid, $Upload, $db;

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
if (!userid()) {
    exit(json_encode(['error' => 'You are not logged in']));
}

/*Setting up file name for the video to be converted*/
$file_name = time() . RandomString(5);

if (isset($_POST['youtube'])) {
    $youtube_url = $_POST['file'];
    $ParseUrl = parse_url($youtube_url);
    parse_str($ParseUrl['query'], $youtube_url_prop);
    $YouTubeId = $youtube_url_prop['v'] ?? '';

    if (!$YouTubeId) {
        exit(json_encode(['error' => 'Invalid youtube url']));
    }

    ########################################
    # YouTube Api 3 Starts 				   #
    ########################################
    /**
     * After deprecation of YouTube Api 2, ClipBucket is now evolving as
     * it allos grabbing of youtube videos with API 3 now.
     * @author Saqib Razzaq
     *
     * Tip: Replace part between 'key' to '&' to use your own key
     */
    $apiKey = $Cbucket->configs['youtube_api_key'];
    // grabs video details (snippet, contentDetails)
    $request = 'https://www.googleapis.com/youtube/v3/videos?id=' . $YouTubeId . '&key=' . $apiKey . '&part=snippet,contentDetails';
    //replaced file get contents

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $request);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $youtube_content = curl_exec($ch);
    curl_close($ch);

    $content = json_decode($youtube_content, true);
    $thumb_contents = maxres_youtube($content);
    $max_quality_thumb = $thumb_contents['thumb'];

    $data = $content['items'][0]['snippet'];

    // getting time out of contentDetails
    $time = $content['items'][0]['contentDetails']['duration'];

    /**
     * Converting YouTube Time in seconds
     */
    $total = yt_time_convert($time);
    $vid_array['title'] = $data['title'];
    $vid_array['description'] = $data['description'];
    $vid_array['tags'] = $data['title'];
    $vid_array['duration'] = $total;
    $vid_array['thumbs'] = $max_quality_thumb;
    $vid_array['embed_code'] = '<iframe width="560" height="315"';
    $vid_array['embed_code'] .= ' src="//www.youtube.com/embed/' . $YouTubeId . '" ';
    $vid_array['embed_code'] .= 'frameborder="0" allowfullscreen></iframe>';
    $file_directory = createDataFolders();
    $vid_array['file_directory'] = $file_directory;
    $vid_array['category'] = [$cbvid->get_default_cid()];
    $vid_array['file_name'] = $file_name;
    $vid_array['userid'] = userid();

    $duration = $vid_array['duration'];
    $vid = $Upload->submit_upload($vid_array);

    if (!function_exists('get_refer_url_from_embed_code')) {
        exit(json_encode(['error' => 'Clipbucket embed module is not installed']));
    }

    $ref_url = get_refer_url_from_embed_code(unhtmlentities(stripslashes($vid_array['embed_code'])));
    $ref_url = $ref_url['url'];
    $db->update(tbl('video'), ['status', 'refer_url', 'duration'], ['Successful', $ref_url, $duration], ' videoid=\'' . $vid . '\'');

    //Downloading thumb
    $downloaded_thumb = snatch_it(urlencode($max_quality_thumb), THUMBS_DIR . DIRECTORY_SEPARATOR . $file_directory, $file_name . '-ytmax.jpg');

    $params = [];
    $params['filepath'] = $downloaded_thumb;
    $params['files_dir'] = $file_directory;
    $params['file_name'] = $file_name;
    $params['width'] = $thumb_contents['width'];
    $params['height'] = $thumb_contents['height'];

    thumbs_black_magic($params);

    exit(json_encode([
        'youtubeID' => $YouTubeId,
        'vid'       => $vid,
        'title'     => $vid_array['title'], 'desc' => $vid_array['description'],
        'tags'      => $vid_array['tags']
    ]));
}

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

$log_file = TEMP_DIR . DIRECTORY_SEPARATOR . $file_name . '_curl_log.cblog';

//For PHP < 5.3.0
$dummy_file = TEMP_DIR . DIRECTORY_SEPARATOR . $file_name . '_curl_dummy.cblog';

$ext = getExt($file);
$svfile = TEMP_DIR . DIRECTORY_SEPARATOR . $file_name . '.' . $ext;

//Checking for the url
if (empty($file)) {
    echo 'error';
    $array['error'] = 'Please enter file url';
    echo json_encode($array);
    exit();
}
//Checking if extension is wrong
$types = strtolower($Cbucket->configs['allowed_video_types']);
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
    'category'       => [$cbvid->get_default_cid()],
    'file_name'      => $file_name,
    'userid'         => userid(),
    'file_directory' => createDataFolders()
];

$vid = $Upload->submit_upload($vidDetails);

echo json_encode(['vid' => $vid]);
$file_dir = $vidDetails['file_directory'];
$logFile = LOGS_DIR . DIRECTORY_SEPARATOR . $file_dir . DIRECTORY_SEPARATOR . $file_name . '.log';

if (stristr(PHP_OS, 'WIN')) {
    exec(php_path() . ' -q ' . BASEDIR . '/actions/video_convert.php ' . $targetFileName . ' sleep');
} else {
    exec(php_path() . ' -q ' . BASEDIR . '/actions/video_convert.php ' . $targetFileName . ' ' . $file_name . ' ' . $file_dir . ' ' . $logFile . ' > /dev/null &');
}
