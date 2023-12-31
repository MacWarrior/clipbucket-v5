<?php
global $cbphoto;
define('THIS_PAGE', 'ajax');
include('../includes/config.inc.php');

if (isset($_REQUEST['plupload'])) {
    $mode = 'plupload';
}

if ($_FILES['photoUpload']) {
    $mode = 'uploadPhoto';
}
if ($_POST['photoForm']) {
    $mode = 'get_photo_form';
}
if ($_POST['insertPhoto']) {
    $mode = 'insert_photo';
}
if ($_POST['updatePhoto']) {
    $mode = 'update_photo';
}

switch ($mode) {
    case 'get_photo_form':
        $name = getName($_POST['name']);
        if (!$name) {
            $name = $_POST['name'];
        }
        $desc = $name;
        $tags = $name;
        $collection = $_POST['collection'];
        $photoArray = [
            'photo_title'       => $name,
            'photo_description' => $name,
            'photo_tags'        => $name,
            'collection_id'     => $collection
        ];
        assign('uniqueID', $_POST['objID']);
        assign('photoArray', $photoArray);
        $form = Fetch('/blocks/upload/photo_form.html');
        echo json_encode(['form' => $form]);
        break;

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

    case 'uploadPhoto':
        $exts = $cbphoto->exts;
        $max_size = 1048576; // 2MB in bytes
        $form = 'photoUpload';
        $path = DirPath::get('photos');

        // These are found in $_FILES. We can access them like $_FILES['file']['error'].
        $upErrors = [
            0 => 'There is no error, the file uploaded with success.',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            3 => 'The uploaded file was only partially uploaded.',
            4 => 'No file was uploaded.',
            6 => 'Missing a temporary folder.',
            7 => 'Failed to write file to disk.'
        ];

        // Let's see if everything is working fine by checking $_FILES.
        if (!isset($_FILES[$form])) {
            upload_error("No upload found in \$_FILES for " . $form);
            exit(0);
        }
        if (isset($_FILES[$form]['error']) && $_FILES[$form]['error'] != 0) {
            upload_error($upErrors[$_FILES[$form]['error']]);
            exit(0);
        }
        if (!isset($_FILES[$form]['tmp_name']) || !@is_uploaded_file($_FILES[$form]['tmp_name'])) {
            upload_error('Upload failed is_uploaded_file test.');
            exit(0);
        }
        if (empty($_FILES[$form]['name'])) {
            upload_error('File name is empty');
            exit(0);
        }

        //Checking Extension of File
        $info = pathinfo($_FILES[$form]['name']);
        $extension = strtolower($info['extension']);
        $valid_extension = false;

        foreach ($exts as $ext) {
            if (strcasecmp($extension, $ext) == 0) {
                $valid_extension = true;
                break;
            }
        }

        if (!$valid_extension) {
            upload_error('Invalid file extension');
            exit(0);
        }

        #checking for if the right file is uploaded
        $content_type = get_mime_type($_FILES[$form]['tmp_name']);
        if ($content_type != 'image') {
            upload_error('Invalid file type');
            exit();
        }

        //Check file size
        $max_file_size_in_bytes = config('max_photo_size') * 1024 * 1024;
        $file_size = @filesize($_FILES['Filedata']['tmp_name']);
        if (!$file_size || $file_size > $max_file_size_in_bytes) {
            upload_error('File exceeds the maximum allowed size');
            exit(0);
        }

        $filename = $cbphoto->create_filename();

        //Now uploading the file
        if (move_uploaded_file($_FILES[$form]['tmp_name'], $path . $filename . '.' . $extension)) {
            echo json_encode(['success' => 'yes', 'filename' => $filename, 'extension' => $extension]);
        } else {
            upload_error('File could not be saved.');
            exit(0);
        }
        break;


    case 'plupload':
        $status_array = [];
        // HTTP headers for no cache etc
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        #checking for if the right file is uploaded
        $content_type = get_mime_type($_FILES['file']['tmp_name']);
        if ($content_type != 'image') {
            echo json_encode(['status' => '400', 'err' => 'Invalid Content']);
            exit();
        }

        $extension = getExt($_FILES['file']['name']);
        $types = strtolower(config('allowed_photo_types'));
        $supported_extensions = explode(',', $types);

        if (!in_array($extension, $supported_extensions)) {
            echo json_encode(['status' => '504', 'msg' => 'Invalid extension']);
            exit();
        }

        $targetDir = DirPath::get('photos');
        $directory = create_dated_folder(DirPath::get('photos'));
        $targetDir .= $directory;

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        @set_time_limit(5 * 60);

        $chunk = isset($_REQUEST['chunk']) ? intval($_REQUEST['chunk']) : 0;
        $chunks = isset($_REQUEST['chunks']) ? intval($_REQUEST['chunks']) : 0;
        $fileName = $_REQUEST['name'] ?? '';

        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

        // Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b)) {
                $count++;
            }

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        // Remove old temp files
        if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
                    @unlink($tmpfilePath);
                }
            }

            closedir($dir);
        } else {
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        }


        // Look for the content type header
        if (isset($_SERVER['HTTP_CONTENT_TYPE'])) {
            $contentType = $_SERVER['HTTP_CONTENT_TYPE'];
        }

        if (isset($_SERVER['CONTENT_TYPE'])) {
            $contentType = $_SERVER['CONTENT_TYPE'];
        }

        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, 'multipart') !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = fopen("{$filePath}.part", $chunk == 0 ? 'wb' : 'ab');
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], 'rb');

                    if ($in) {
                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }
                    } else {
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    }
                    fclose($in);
                    fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
                }
            } else {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }
        } else {
            // Open temp file
            $out = fopen("{$filePath}.part", $chunk == 0 ? 'wb' : 'ab');
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = fopen('php://input', 'rb');

                if ($in) {
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                } else {
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }

                fclose($in);
                fclose($out);
            } else {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }

        $filename = $cbphoto->create_filename();
        $targetFileName = $filename . '.' . getExt($filePath);
        $targetFile = $targetDir . DIRECTORY_SEPARATOR . $targetFileName;

        rename($filePath, $targetFile);

        echo json_encode(['success' => 'yes', 'file_name' => $filename, 'extension' => getExt($filePath), 'file_directory' => $directory]);
        break;
}

//function used to display error
function upload_error($error)
{
    echo json_encode(['error' => $error]);
} 
