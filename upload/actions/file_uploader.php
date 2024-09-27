<?php
define('THIS_PAGE', 'file_uploader');

include('../includes/config.inc.php');
require_once(dirname(__FILE__, 2) . '/includes/classes/sLog.php');

if( !has_access('allow_video_upload') ){
    upload_error(lang('insufficient_privileges_loggin'));
    die();
}

global $cbvid, $Upload, $eh;

$mode = '';
if ($_FILES['Filedata']) {
    $mode = 'upload';
}
if ($_POST['updateVideo']) {
    $mode = 'update_video';
}
if ($_POST['getForm']) {
    $mode = 'get_form';
}

switch ($mode) {
    case 'update_video':
        $cbvid->update_video();

        if (error()) {
            echo json_encode(['error' => error('single')]);
        } else {
            echo json_encode(['valid' => lang('video_detail_saved')]);
        }
        die();

    case 'get_form':
        $title = getName($_POST['title']);
        if (!$title) {
            $title = $_POST['title'];
        }
        $desc = $_POST['desc'];
        $tags = $_POST['tags'];

        if (!$desc) {
            $desc = $title;
        }
        if (!$tags) {
            $tags = $title;
        }

        $vidDetails = [
            'title'       => $title,
            'description' => $desc,
            'tags'        => $tags
        ];

        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
            $category = [Category::getInstance()->getDefaultByType('video')['category_id']];
        } else {
            $category = [];
        }
        $vidDetails['category'] = $category;

        assign('objId', $_POST['objId']);
        assign('input', $vidDetails);

        $vid = $_POST['vid'];
        assign('videoid', $vid);

        $videoFields = $Upload->load_video_fields($vidDetails);
        Template('blocks/upload/upload_form.html');
        break;

    case 'upload':
        $file_name = time() . RandomString(5);
        $targetFile = DirPath::get('temp') . $file_name;

        $params = [
            'fileData' => 'Filedata',
            'mimeType' => 'video',
            'destinationFilePath' => $targetFile,
            'keepExtension' => true,
            'maxFileSize' => config('max_upload_size'),
            'allowedExtensions' => config('allowed_video_types')
        ];

        FileUpload::getInstance($params)->processUpload();
        $DestinationFilePath = FileUpload::getInstance()->getDestinationFilePath();
        $original_filename = FileUpload::getInstance()->getOriginalFileName();
        $extension = FileUpload::getInstance()->getExtension();

        create_dated_folder(DirPath::get('logs'));
        $file_directory = date('Y/m/d');
        $logFile = DirPath::get('logs') . $file_directory . DIRECTORY_SEPARATOR . $file_name . '.log';

        $log = new SLog($logFile);
        $log->newSection('Pre-Check Configurations');
        $log->writeLine('File to be converted', 'Initializing File <strong>' . $file_name . '.mp4</strong> and pre checking configurations...', true);
        $log->writeLine('Temporary Uploading', 'File Uploaded to Temp directory successfully and video conversion file is being executed !');

        $filename_without_ext = pathinfo($original_filename, PATHINFO_FILENAME);
        if (strlen($filename_without_ext) > config('max_video_title')) {
            $filename_without_ext = substr($filename_without_ext, 0, config('max_video_title'));
        }

        $version = Update::getInstance()->getDBVersion();
        if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
            $category = [Category::getInstance()->getDefaultByType('video')['category_id']];
        } else {
            $category = [];
        }

        $vidDetails = [
            'title'             => $filename_without_ext
            , 'file_name'       => $file_name
            , 'file_directory'  => $file_directory
            , 'description'     => $filename_without_ext
            , 'category'        => $category
            , 'userid'          => user_id()
            , 'allow_comments'  => 'yes'
            , 'comment_voting'  => 'yes'
            , 'allow_rating'    => 'yes'
            , 'allow_embedding' => 'yes'
            , 'broadcast'       => 'public'
        ];

        $vid = $Upload->submit_upload($vidDetails);

        if (!$vid) {
            upload_error($eh->get_error()[0]['val']);
            die();
        }

        if (!empty($_POST['collection_id'])) {
            Collection::getInstance()->addCollectionItem($vid, $_POST['collection_id'], 'videos');
        }
        $Upload->add_conversion_queue($file_name . '.' . $extension);

        $default_cmd = System::get_binaries('php') . ' -q ' . DirPath::get('actions') . 'video_convert.php ' . $DestinationFilePath . ' ' . $file_name . ' ' . $file_directory . ' ' . $logFile;
        if (stristr(PHP_OS, 'WIN')) {
            $complement = '';
        } elseif (stristr(PHP_OS, 'darwin')) {
            $complement = ' </dev/null >/dev/null &';
        } else { // for ubuntu or linux
            $complement = ' > /dev/null &';
        }
        exec($default_cmd . $complement);

        $TempLogData = 'Video Converson File executed successfully with Target File > ' . $DestinationFilePath;
        $log->writeLine('Video Conversion File Execution', $TempLogData);

        echo json_encode(['success' => 'yes', 'file_name' => $file_name, 'videoid'=>$vid]);
        die();

    default:
        if( in_dev() ){
            upload_error('Unknown command : '.$mode);
        } else {
            upload_error('Unknown command');
        }
        die();
}

//function used to display error
function upload_error($error)
{
    echo json_encode(['error' => $error]);
}
