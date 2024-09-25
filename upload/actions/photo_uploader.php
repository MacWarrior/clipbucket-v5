<?php
global $cbphoto;
define('THIS_PAGE', 'photo_uploader');
include('../includes/config.inc.php');

if( !has_access('allow_photo_upload') ){
    upload_error(lang('insufficient_privileges_loggin'));
    die();
}

if ($_FILES['Filedata']) {
    $mode = 'upload';
}
if ($_POST['insertPhoto']) {
    $mode = 'insert_photo';
}
if ($_POST['updatePhoto']) {
    $mode = 'update_photo';
}

switch ($mode) {
    case 'insert_photo':
        $_POST['photo_title'] = mysql_clean($_POST['photo_title']);
        $_POST['photo_description'] = mysql_clean($_POST['photo_description']);
        $_POST['photo_tags'] = genTags(str_replace([' ', '_', '-'], ', ', $_POST['photo_tags']));
        $_POST['server_url'] = 'undefined';
        $_POST['active'] = config('photo_activation') ? 'no' : 'yes';
        $_POST['folder'] = str_replace('..', '', mysql_clean($_POST['folder']));
        $_POST['folder'] = create_dated_folder(DirPath::get('photos'));
        $_POST['filename'] = mysql_clean($_POST['file_name']);
        $insert_id = $cbphoto->insert_photo();

        if (!empty(errorhandler::getInstance()->get_error())) {
            $response['error'] = error('single');
        } else {
            $response['photoID'] = $insert_id;
            $details = $cbphoto->get_photo($insert_id);
            $details['filename'] = $_POST['file_name'];
            $response['success'] = msg('single');
            $params = ['details' => $details, 'size' => 'm', 'static' => true];
            $response['photoPreview'] = get_image_file($params);
        }

        echo json_encode($response);
        break;

    case 'update_photo':
        $_POST['photo_title'] = mysql_clean($_POST['photo_title']);
        $_POST['photo_description'] = mysql_clean($_POST['photo_description']);
        $cbphoto->update_photo();

        if (error()) {
            $error = error('single');
        }
        if (msg()) {
            $success = msg('single');
        }

        $updateResponse['error'] = $error;
        $updateResponse['success'] = $success;

        echo json_encode($updateResponse);
        break;

    case 'upload':
        $targetDir = DirPath::get('photos');
        $directory = create_dated_folder($targetDir);
        $targetDir .= $directory;

        $filename = $cbphoto->create_filename();
        $targetFileName = $filename;
        $targetFile = $targetDir . DIRECTORY_SEPARATOR . $targetFileName;

        $params = [
            'fileData' => 'Filedata',
            'mimeType' => 'image',
            'destinationFilePath' => $targetFile,
            'keepExtension' => true,
            'maxFileSize' => config('max_upload_size'),
            'allowedExtensions' => config('allowed_photo_types')
        ];

        FileUpload::getInstance($params)->processUpload();
        $extension = FileUpload::getInstance()->getExtension();

        echo json_encode(['success' => 'yes', 'file_name' => $filename, 'extension' => $extension, 'file_directory' => $directory]);
        die();
}
