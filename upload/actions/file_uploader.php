<?php
define('THIS_PAGE', 'ajax');

include('../includes/config.inc.php');
require_once(dirname(__FILE__, 2) . '/includes/classes/sLog.php');
global $cbvid, $Upload, $db, $eh;

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
        exit();

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
            'tags'        => $tags,
            'category'    => [$cbvid->get_default_cid()]
        ];

        assign('objId', $_POST['objId']);
        assign('input', $vidDetails);

        $vid = $_POST['vid'];
        assign('videoid', $vid);

        $videoFields = $Upload->load_video_fields($vidDetails);
        Template('blocks/upload/upload_form.html');
        break;

    case 'upload':
        $ffmpegpath = ClipBucket::getInstance()->configs['ffmpegpath'];
        $extension = getExt($_FILES['Filedata']['name']);

        #checking for if the right file is uploaded
        $tempFile = $_FILES['Filedata']['tmp_name'];
        $content_type = get_mime_type($tempFile);
        if ($content_type != 'video') {
            echo json_encode(['status' => '400', 'err' => 'Invalid Content']);
            exit();
        }

        $types = strtolower(config('allowed_video_types'));
        $supported_extensions = explode(',', $types);
        if (!in_array($extension, $supported_extensions)) {
            echo json_encode(['status' => '504', 'msg' => 'Invalid video extension']);
            exit();
        }

        $file_name = time() . RandomString(5);
        $file_directory = date('Y/m/d');
        $targetFileName = $file_name . '.' . $extension;

        create_dated_folder(DirPath::get('logs'));
        $logFile = DirPath::get('logs') . $file_directory . DIRECTORY_SEPARATOR . $file_name . '.log';

        $log = new SLog($logFile);
        $log->newSection('Pre-Check Configurations');
        $log->writeLine('File to be converted', 'Initializing File <strong>' . $file_name . '.mp4</strong> and pre checking configurations...', true);

        $max_file_size_in_bytes = config('max_upload_size') * 1024 * 1024;

        //Checking filesize
        $POST_MAX_SIZE = ini_get('post_max_size');
        $unit = strtoupper(substr($POST_MAX_SIZE, -1));
        $multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

        if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier * (int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
            header('HTTP/1.1 500 Internal Server Error'); // This will trigger an uploadError event in SWFUpload
            upload_error('POST exceeded maximum allowed size.');
            exit(0);
        }

        //Checking uploading errors
        $uploadErrors = [
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk',
            8 => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help'
        ];
        if (!isset($_FILES['Filedata'])) {
            upload_error('No file was selected');
            exit(0);
        }
        if (isset($_FILES['Filedata']['error']) && $_FILES['Filedata']['error'] != 0) {
            upload_error($uploadErrors[$_FILES['Filedata']['error']]);
            exit(0);
        }
        if (!isset($_FILES['Filedata']['tmp_name']) || !@is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
            upload_error('Upload failed is_uploaded_file test.');
            exit(0);
        }
        if (!isset($_FILES['Filedata']['name'])) {
            upload_error('File has no name.');
            exit(0);
        }

        //Check file size
        $file_size = @filesize($_FILES['Filedata']['tmp_name']);
        if (!$file_size || $file_size > $max_file_size_in_bytes) {
            upload_error('File exceeds the maximum allowed size');
            exit(0);
        }

        $targetFile = DirPath::get('temp') . $targetFileName;
        $moved = move_uploaded_file($tempFile, $targetFile);

        if ($moved) {
            $log->writeLine('Temporary Uploading', 'File Uploaded to Temp directory successfully and video conversion file is being executed !', true);
        } else {
            $log->writeLine('Temporary Uploading', 'Went something wrong in moving the file in Temp directory!', true);
        }

        $filename_without_ext = pathinfo($_FILES['Filedata']['name'], PATHINFO_FILENAME);
        if (strlen($filename_without_ext) > config('max_video_title')) {
            $filename_without_ext = substr($filename_without_ext, 0, config('max_video_title'));
        }
        $vidDetails = [
            'title'             => $filename_without_ext
            , 'file_name'       => $file_name
            , 'file_directory'  => $file_directory
            , 'description'     => $filename_without_ext
            , 'category'        => [$cbvid->get_default_cid()]
            , 'userid'          => user_id()
            , 'allow_comments'  => 'yes'
            , 'comment_voting'  => 'yes'
            , 'allow_rating'    => 'yes'
            , 'allow_embedding' => 'yes'
            , 'broadcast'       => 'public'
        ];

        $vid = $Upload->submit_upload($vidDetails);

        if (!$vid) {
            echo json_encode(['success' => 'no', 'file_name' => $filename_without_ext]);
            exit();
        }

        $Upload->add_conversion_queue($targetFileName);

        if (stristr(PHP_OS, 'WIN')) {
            exec(php_path() . ' -q ' . DirPath::get('actions') . 'video_convert.php ' . $targetFileName);
        } elseif (stristr(PHP_OS, 'darwin')) {
            exec(php_path() . ' -q ' . DirPath::get('actions') . 'video_convert.php ' . $targetFileName . ' </dev/null >/dev/null &');
        } else { // for ubuntu or linux
            exec(php_path() . ' -q ' . DirPath::get('actions') . 'video_convert.php ' . $targetFileName . ' ' . $file_name . ' ' . $file_directory . ' ' . $logFile . ' > /dev/null &');
        }

        $TempLogData = 'Video Converson File executed successfully with Target File > ' . $targetFileName;
        $log->writeLine('Video Conversion File Execution', $TempLogData, true);

        // inserting into video views as well
        $query = 'INSERT INTO ' . tbl('video_views') . ' (video_id, video_views, last_updated) VALUES(' . $vid . ',0,' . time() . ')';
        $db->execute($query);

        echo json_encode(['success' => 'yes', 'file_name' => $file_name]);
        exit();

    default:
        upload_error('Unknown command');
        exit();
}

//function used to display error
function upload_error($error)
{
    echo json_encode(['error' => $error]);
}
