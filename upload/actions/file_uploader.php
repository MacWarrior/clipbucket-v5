<?php
const THIS_PAGE = 'file_uploader';
include('../includes/config.inc.php');

require_once DirPath::get('classes') . 'sLog.php';

if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '148')) {
    upload_error('Sorry, you cannot upload new videos until the application has been fully updated by an administrator');
    die();
}

if( !User::getInstance()->hasPermission('allow_video_upload') ){
    upload_error(lang('insufficient_privileges_loggin'));
    die();
}

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
        CBvideo::getInstance()->update_video();
        if (empty(errorhandler::getInstance()->get_error()) && !empty($_POST['videoid'])) {
            if( !empty($_POST['default_thumb']) ){
                Video::getInstance()->setDefautThumb($_POST['default_thumb'], 'thumb', $_POST['videoid']);
            }
            if (config('enable_video_poster') == 'yes' && !empty($_POST['default_poster'])) {
                Video::getInstance()->setDefautThumb($_POST['default_poster'], 'poster', $_POST['videoid']);
            }
            if (config('enable_video_backdrop') == 'yes' && !empty($_POST['default_backdrop'])) {
                Video::getInstance()->setDefautThumb($_POST['default_backdrop'], 'backdrop', $_POST['videoid']);
            }
        }

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

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '331') ){
            $category = [Category::getInstance()->getDefaultByType('video')['category_id']];
        } else {
            $category = [];
        }
        $vidDetails['category'] = $category;

        assign('objId', $_POST['objId']);
        assign('input', $vidDetails);

        $vid = $_POST['vid'];
        assign('videoid', $vid);

        $videoFields = Upload::getInstance()->load_video_fields($vidDetails);
        Template('blocks/upload/upload_form.html');
        break;

    case 'upload':
        $file_name = time() . RandomString(5);
        $targetFile = DirPath::get('temp') . $file_name;

        $params = [
            'fileData'            => 'Filedata',
            'mimeType'            => 'video',
            'destinationFilePath' => $targetFile,
            'keepExtension'       => true,
            'maxFileSize'         => !empty((int)config('max_upload_size')) ? config('max_upload_size') : 1000,
            'allowedExtensions'   => config('allowed_video_types')
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
        $log->writeLine(date('Y-m-d H:i:s').' - Initializing File ' . $file_name . '.mp4 and pre checking configurations...');
        $log->writeLine(date('Y-m-d H:i:s').' - File Uploaded to Temp directory successfully and video conversion file is being executed !');

        $filename_without_ext = pathinfo($original_filename, PATHINFO_FILENAME);
        if (strlen($filename_without_ext) > config('max_video_title')) {
            $filename_without_ext = substr($filename_without_ext, 0, config('max_video_title'));
        }

        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '331') ){
            $category = [Category::getInstance()->getDefaultByType('video')['category_id']];
        } else {
            $category = [];
        }

        $vidDetails = [
            'title'             => $filename_without_ext
            , 'file_name'       => $file_name
            , 'file_directory'  => $file_directory
            , 'description'     => $filename_without_ext
            , 'file_type'       => $extension
            , 'category'        => $category
            , 'userid'          => user_id()
            , 'allow_comments'  => 'yes'
            , 'comment_voting'  => 'yes'
            , 'allow_rating'    => 'yes'
            , 'allow_embedding' => 'yes'
            , 'broadcast'       => 'public'
        ];
        if (config('enable_public_video_page') == 'yes') {
            $vidDetails['broadcast'] = 'logged';
        }

        $vid = Upload::getInstance()->submit_upload($vidDetails);

        if (!$vid) {
            upload_error(errorhandler::getInstance()->get_error()[0]['val']);
            die();
        }

        if (!empty($_POST['collection_id'])) {
            Collection::getInstance()->addCollectionItem($vid, $_POST['collection_id'], 'videos');
        }
        VideoConversionQueue::insert($vid);

        echo json_encode(['success' => 'yes', 'file_name' => $file_name, 'videoid'=>$vid]);
        die();

    default:
        if( System::isInDev() ){
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
