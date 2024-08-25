<?php
class FileUpload
{
    private static $fileUpload = null;
    private $fileData = '';
    private $mimeType = '';
    private $destinationFilePath = '';
    private $maxFileSize = 0;
    private $allowedExtensions = [];
    private $tempFilePath = '';
    private $finalFileSize = 0;
    private $fileExtension = '';
    private $keepExtension = false;
    private $originalFileName = '';

    public function __construct($params){
        $this->fileData            = $params['fileData'];
        $this->mimeType            = $params['mimeType'];
        $this->destinationFilePath = $params['destinationFilePath'];
        $this->maxFileSize         = $params['maxFileSize'];
        $this->allowedExtensions   = explode(',', strtolower($params['allowedExtensions']));
        $this->keepExtension       = $params['keepExtension'];
    }

    public static function getInstance($params = []): self
    {
        if( empty(self::$fileUpload) ){
            self::$fileUpload = new self($params);
        }
        return self::$fileUpload;
    }

    /**
     * @throws Exception
     */
    private function error($error)
    {
        if( file_exists($this->tempFilePath) ){
            unlink($this->tempFilePath);
        }

        if( in_dev() ){
            error_log($error);
            DiscordLog::sendDump($error);
        } else {
            $error = lang('technical_error');
        }

        echo json_encode(['error' => $error]);
        die();
    }

    /**
     * @throws Exception
     */
    private function checkUploadedSize()
    {
        if( (int)$_SERVER['CONTENT_LENGTH'] > getBytesFromFileSize(Clipbucket::getInstance()->getMaxUploadSize('M')) ){
            $this->error('POST exceeded maximum allowed size.');
        }
    }

    /**
     * @throws Exception
     */
    private function checkFileData()
    {
        if( !isset($_FILES[$this->fileData]) ){
            $this->error('No file was selected');
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

        if (isset($_FILES[$this->fileData]['error']) && $_FILES[$this->fileData]['error'] != 0) {
            $this->error($uploadErrors[$_FILES[$this->fileData]['error']]);
        }

        if( empty($_FILES[$this->fileData]['tmp_name']) || !is_uploaded_file($_FILES[$this->fileData]['tmp_name']) ){
            $this->error('Upload failed is_uploaded_file test.');
        }

        $tempFile = $_FILES[$this->fileData]['tmp_name'];


        if( config('enable_chunk_upload') == 'yes'){
            $chunk = $_POST['chunk'] ?? false;
            $chunks = $_POST['chunks'] ?? false;
            $original_filename = $_POST['name'] ?? false;
            $unique_id = $_POST['unique_id'] ?? false;

            $userid = user_id();
            if( !$userid ) {
                $this->error('User not logged in');
            }

            $this->tempFilePath = DirPath::get('temp') . $userid . '-' . $unique_id . '.part';

            if( (empty($chunk) && $chunk != '0') || (empty($chunks) && $chunks != '0') || !$original_filename || empty($unique_id) ){
                $this->error('file_uploader : missing infos');
            }

            if( $chunk == 0 ){
                $content_type = get_mime_type($tempFile);
                if( $content_type != $this->mimeType ) {
                    $this->error('Invalid Content : ' . $content_type);
                }
            }
        } else {
            if (!isset($_FILES[$this->fileData]['name'])) {
                $this->error('File has no name.');
            }

            $content_type = get_mime_type($tempFile);
            if( $content_type != $this->mimeType ) {
                $this->error('Invalid Content : ' . $content_type);
            }
        }
    }

    /**
     * @throws Exception
     */
    private function manageChunkedFile()
    {
        $chunk = $_POST['chunk'] ?? false;
        $chunks = $_POST['chunks'] ?? false;
        $unique_id = $_POST['unique_id'] ?? false;

        if( $chunk === false || $chunks === false || $unique_id === false){
            $this->error('Missing chunked upload datas');
        }

        $filename = $_POST['name'];
        if( empty($filename) ){
            $this->error('Missing filename');
        }
        $this->fileExtension = getExt($filename) ?? false;
        $this->originalFileName = $filename;

        $temp_file = @fopen($this->tempFilePath, $chunk == 0 ? 'wb' : 'ab');
        if( !$temp_file ) {
            $this->error('manageChunkedFile : can\'t open ' . $this->tempFilePath);
        }

        $tmp_name = $_FILES[$this->fileData]['tmp_name'];
        $part = @fopen($tmp_name, 'rb');
        if( !$part ) {
            $this->error('manageChunkedFile : can\'t read ' . $tmp_name);
        }

        while ($buff = fread($part, 4096)){
            fwrite($temp_file, $buff);
        }

        @fclose($part);
        @fclose($temp_file);
        @unlink($tmp_name);

        if( $chunk+1 != $chunks ){
            // Everything is fine, keep uploading
            echo json_encode([]);
            die();
        }

        if( !file_exists($this->tempFilePath) ){
            $this->error(lang('manageChunkedFile : missing file ' . $this->tempFilePath));
        }

        $this->finalFileSize = filesize($this->tempFilePath);
        $this->allowedExtensions[] = 'blob';
    }

    /**
     * @throws Exception
     */
    private function manageFile()
    {
        if( config('enable_chunk_upload') == 'yes'){
            $this->manageChunkedFile();
        } else {
            $this->fileExtension = getExt($_FILES[$this->fileData]['name']);
            $this->originalFileName = $_FILES[$this->fileData]['name'];
            $this->tempFilePath = $_FILES[$this->fileData]['tmp_name'];
            $this->finalFileSize = @filesize($this->tempFilePath);
        }

        $extension = strtolower($this->fileExtension);
        if( !in_array($extension, $this->allowedExtensions)) {
            $this->error('Invalid extension');
        }

        $max_file_size_in_bytes = getBytesFromFileSize($this->maxFileSize . 'M');
        if (empty($this->finalFileSize) || $this->finalFileSize > $max_file_size_in_bytes) {
            $this->error(lang('file_size_cant_exceeds_x_x', [$this->maxFileSize,lang('mb')]));

        }

        if( $this->keepExtension ){
            $this->destinationFilePath .= '.' . $this->fileExtension;
        }

        if( config('enable_chunk_upload') == 'yes'){
            $moved = rename($this->tempFilePath, $this->destinationFilePath);
        } else {
            $moved = move_uploaded_file($this->tempFilePath, $this->destinationFilePath);
        }
        if( !$moved ) {
            $this->error('manageFile : can\'t move temp file ' . $this->tempFilePath . ' to ' . $this->destinationFilePath);
        }
    }

    /**
     * @throws Exception
     */
    public function processUpload()
    {
        $this->checkUploadedSize();
        $this->checkFileData();
        $this->manageFile();
    }

    public function getExtension(): string
    {
        return $this->fileExtension;
    }

    public function getDestinationFilePath(): string
    {
        return $this->destinationFilePath;
    }

    public function getOriginalFileName(): string
    {
        return $this->originalFileName;
    }
}