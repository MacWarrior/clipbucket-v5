<?php
global $cbphoto;
define('THIS_PAGE', 'ajax');
include('../includes/config.inc.php');

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

        if (error()) {
            $response['error'] = error('single');
        }

        if (msg()) {
            $response['success'] = msg('single');
            $response['photoID'] = $insert_id;
            $details = $cbphoto->get_photo($insert_id);
            $details['filename'] = $_POST['file_name'];
            $cbphoto->generate_photos($details);
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
        if ((int)$_SERVER['CONTENT_LENGTH'] > getBytesFromFileSize(Clipbucket::getInstance()->getMaxUploadSize('M')) ) {
            upload_error('POST exceeded maximum allowed size.');
            die();
        }

        if (!isset($_FILES['Filedata'])) {
            upload_error('No file was selected');
            die();
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
            die();
        }

        if (!isset($_FILES['Filedata']['tmp_name']) || !@is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
            if( in_dev() ){
                upload_error('Upload failed is_uploaded_file test.');
            } else {
                upload_error(lang('technical_error'));
            }
            die();
        }

        $tempFile = $_FILES['Filedata']['tmp_name'];
        $content_type = get_mime_type($tempFile);
        $types = strtolower(config('allowed_photo_types'));
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
                die();
            }

            if( ($chunk == 0 && $content_type != 'image') || ($chunk > 0 && $content_type != 'application') ) {
                upload_error('Invalid Content');
                die();
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
                die();
            }

            $part = @fopen($_FILES['Filedata']['tmp_name'], 'rb');
            if( !$part ) {
                if( in_dev() ){
                    upload_error('file_uploader : can\'t read ' . $_FILES['Filedata']['tmp_name']);
                } else {
                    upload_error(lang('technical_error'));
                }
                die();
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
                die();
            }

            if( !file_exists($temp_filepath) ){
                upload_error(lang('technical_error'));
                die();
            }

            $file_size = @filesize($temp_filepath);

        } else {
            if (!isset($_FILES['Filedata']['name'])) {
                upload_error('File has no name.');
                die();
            }

            $original_filename = $_FILES['Filedata']['name'];
            $temp_filepath = $_FILES['Filedata']['tmp_name'];
            $file_size = @filesize($temp_filepath);

            if( $content_type != 'video' ) {
                upload_error('Invalid Content');
                die();
            }
            $save_to_db = true;
        }

        $extension = strtolower(getExt($original_filename));
        if( !in_array($extension, $supported_extensions)) {
            upload_error('Invalid video extension');
            die();
        }

        $max_file_size_in_bytes = getBytesFromFileSize(config('max_upload_size') . 'M');

        if (!$file_size || $file_size > $max_file_size_in_bytes) {
            upload_error(sprintf(lang('page_upload_video_limits'),config('max_upload_size'),config('max_video_duration')));
            @unlink($temp_filepath);
            die();
        }

        $targetDir = DirPath::get('photos');
        $directory = create_dated_folder($targetDir);
        $targetDir .= $directory;

        $filename = $cbphoto->create_filename();
        $targetFileName = $filename . '.' . $extension;
        $targetFile = $targetDir . DIRECTORY_SEPARATOR . $targetFileName;

        if( config('enable_chunk_upload') == 'yes'){
            $moved = rename($temp_filepath, $targetFile);
        } else {
            $moved = move_uploaded_file($temp_filepath, $targetFile);
        }

        echo json_encode(['success' => 'yes', 'file_name' => $filename, 'extension' => $extension, 'file_directory' => $directory]);
        break;
}

//function used to display error
function upload_error($error)
{
    echo json_encode(['error' => $error]);
} 
