<?php
define('THIS_PAGE', 'ajax');

include('../includes/config.inc.php');
require_once(dirname(__FILE__, 2) . '/includes/classes/sLog.php');

if( !has_access('allow_video_upload') ){
    upload_error(lang('insufficient_privileges_loggin'));
    exit();
}

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
        \DiscordLog::sendDump($_POST['chunk']);
        sleep(10);

        if ((int)$_SERVER['CONTENT_LENGTH'] > getBytesFromFileSize(Clipbucket::getInstance()->getMaxUploadSize('M')) ) {
            upload_error('POST exceeded maximum allowed size.');
            exit(0);
        }

        if (!isset($_FILES['Filedata'])) {
            upload_error('No file was selected');
            exit(0);
        }

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

        if (isset($_FILES['Filedata']['error']) && $_FILES['Filedata']['error'] != 0) {
            if( in_dev() ){
                upload_error($uploadErrors[$_FILES['Filedata']['error']]);
            } else {
                upload_error(lang('technical_error'));
            }
            exit(0);
        }

        if (!isset($_FILES['Filedata']['tmp_name']) || !@is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
            if( in_dev() ){
                upload_error('Upload failed is_uploaded_file test.');
            } else {
                upload_error(lang('technical_error'));
            }
            exit(0);
        }

        $tempFile = $_FILES['Filedata']['tmp_name'];
        $content_type = get_mime_type($tempFile);
        $types = strtolower(config('allowed_video_types'));
        $supported_extensions = explode(',', $types);

        if( config('enable_chunk_upload') == 'yes'){
            $chunk = $_POST['chunk'] ?? false;
            $chunks = $_POST['chunks'] ?? false;
            $original_filename = $_POST['name'] ?? false;
            $unique_id = $_POST['unique_id'] ?? false;

            if( (empty($chunk) && $chunk != '0') || (empty($chunks) && $chunks != '0') || !$original_filename || empty($unique_id) ){
                if( in_dev() ){
                    upload_error('file_uploader : missing infos');
                } else {
                    upload_error(lang('technical_error'));
                }
                exit();
            }

            if( ($chunk == 0 && $content_type != 'video') || ($chunk > 0 && $content_type != 'application') ) {
                upload_error('Invalid Content');
                exit();
            }

            $supported_extensions[] = 'blob';
            $save_to_db = ($chunk+1 == $chunks);

            $userid = user_id();
            $temp_filename = $userid . '-' . $unique_id . '.part';
            $temp_filepath = DirPath::get('temp') . $temp_filename;
            $temp_file = @fopen($temp_filepath, $chunk == 0 ? 'wb' : 'ab');

            if( !$temp_file ) {
                if( in_dev() ){
                    upload_error('file_uploader : can\'t open ' . $temp_filepath);
                } else {
                    upload_error(lang('technical_error'));
                }
                exit();
            }

            $part = @fopen($_FILES['Filedata']['tmp_name'], 'rb');
            if( !$part ) {
                if( in_dev() ){
                    upload_error('file_uploader : can\'t read ' . $_FILES['Filedata']['tmp_name']);
                } else {
                    upload_error(lang('technical_error'));
                }
                exit();
            }

            while ($buff = fread($part, 4096)){
                fwrite($temp_file, $buff);
            }

            @fclose($part);
            @fclose($temp_file);
            @unlink($_FILES['Filedata']['tmp_name']);

            if( !$save_to_db ){
                // Everything is fine, keep uploading
                echo json_encode([]);
                exit();
            }

            if( !file_exists($temp_filepath) ){
                upload_error(lang('technical_error'));
                exit();
            }

            $file_size = @filesize($temp_filepath);

        } else {
            if (!isset($_FILES['Filedata']['name'])) {
                upload_error('File has no name.');
                exit();
            }

            $original_filename = $_FILES['Filedata']['name'];
            $temp_filepath = $_FILES['Filedata']['tmp_name'];
            $file_size = @filesize($temp_filepath);

            if( $content_type != 'video' ) {
                upload_error('Invalid Content');
                exit();
            }
            $save_to_db = true;
        }

        $extension = strtolower(getExt($original_filename));
        if( !in_array($extension, $supported_extensions)) {
            upload_error('Invalid video extension');
            exit();
        }

        $max_file_size_in_bytes = getBytesFromFileSize(config('max_upload_size') . 'M');

        if (!$file_size || $file_size > $max_file_size_in_bytes) {
            upload_error(sprintf(lang('page_upload_video_limits'),config('max_upload_size'),config('max_video_duration')));
            @unlink($temp_filepath);
            exit(0);
        }

        $file_name = time() . RandomString(5);
        $file_directory = date('Y/m/d');

        create_dated_folder(DirPath::get('logs'));
        $logFile = DirPath::get('logs') . $file_directory . DIRECTORY_SEPARATOR . $file_name . '.log';

        $log = new SLog($logFile);
        $log->newSection('Pre-Check Configurations');
        $log->writeLine('File to be converted', 'Initializing File <strong>' . $file_name . '.mp4</strong> and pre checking configurations...', true);

        $targetFileName = $file_name . '.' . $extension;
        $targetFile = DirPath::get('temp') . $targetFileName;

        if( config('enable_chunk_upload') == 'yes'){
            $moved = rename($temp_filepath, $targetFile);
        } else {
            $moved = move_uploaded_file($temp_filepath, $targetFile);
        }

        if ($moved) {
            $log->writeLine('Temporary Uploading', 'File Uploaded to Temp directory successfully and video conversion file is being executed !');
        } else {
            if( in_dev() ){
                upload_error('file_uploader : can\'t move temp file ' . $temp_filepath . ' to ' . $targetFile);
            } else {
                upload_error(lang('technical_error'));
            }
            @unlink($temp_filepath);
            exit();
        }

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
            exit();
        }

        $Upload->add_conversion_queue($targetFileName);

        $default_cmd = System::get_binaries('php') . ' -q ' . DirPath::get('actions') . 'video_convert.php ' . $targetFileName . ' ' . $file_name . ' ' . $file_directory . ' ' . $logFile;
        if (stristr(PHP_OS, 'WIN')) {
            $complement = '';
        } elseif (stristr(PHP_OS, 'darwin')) {
            $complement = ' </dev/null >/dev/null &';
        } else { // for ubuntu or linux
            $complement = ' > /dev/null &';
        }
        exec($default_cmd . $complement);

        $TempLogData = 'Video Converson File executed successfully with Target File > ' . $targetFileName;
        $log->writeLine('Video Conversion File Execution', $TempLogData);

        // inserting into video views as well
        $query = 'INSERT INTO ' . tbl('video_views') . ' (video_id, video_views, last_updated) VALUES(' . $vid . ',0,' . time() . ')';
        $db->execute($query);

        echo json_encode(['success' => 'yes', 'file_name' => $file_name, 'videoid'=>$vid]);
        exit();

    default:
        if( in_dev() ){
            upload_error('Unknown command : '.$mode);
        } else {
            upload_error('Unknown command');
        }
        exit();
}

//function used to display error
function upload_error($error)
{
    echo json_encode(['error' => $error]);
}
