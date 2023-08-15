<?php

class SLog
{
    private $logFile = false;
    private $fileHandle = false;
    private $logData = '';

    public function __construct($logFile = false)
    {
        if ($logFile) {
            $this->logFile = $logFile;

            $dirname = dirname($logFile);
            if (!is_dir($dirname)) {
                mkdir($dirname, 0755, true);
            }
        }
    }

    public function newSection($sectionName = false, $writeNow = true)
    {
        if (!$sectionName) {
            $sectionName = 'New Section';
        }
        $this->logData .= "\n\n".'==========================================';
        $this->logData .= "\n" . $sectionName;
        $this->logData .= "\n".'==========================================';

        if ($writeNow) {
            $this->writeLog();
        }
    }

    public function writeLine($title = false, $description = false, $writeNow = true, $append = false, $isHtml = false)
    {
        if (is_array($description)) {
            $description = json_encode($description);
        }

        $newLine = "\n";
        if( $isHtml ){
            $newLine = '';
        }

        if(!empty($title)){
            $this->logData .= $newLine.$title;
        }

        if(!empty($title) && !empty($description)){
            $loop = strlen($title);
            $underline = '';
            for ($i = 0; $i < $loop; $i++) {
                $underline .= '-';
            }
            $this->logData .= $newLine.$underline;
        }

        if(!empty($description)){
            $this->logData .= $newLine.$description;
        }

        if (!$append) {
            if ($writeNow) {
                $this->writeLog();
            }
        } else {
            if ($writeNow) {
                $this->appendLog();
            }
        }
    }

    public function writeLog()
    {
        if (!$this->logFile) {
            return;
        }
        $this->fileHandle = fopen($this->logFile, 'w+') or die('Unable to open file!');
        fwrite($this->fileHandle, $this->logData);
        fclose($this->fileHandle);
        return $this;
    }

    public function appendLog()
    {
        if (!$this->logFile) {
            return;
        }
        $TempData = file_get_contents($this->logFile);
        $this->logData = "\n{$TempData}\n{$this->logData}";
        file_put_contents($this->logFile, $this->logData);
        return $this;
    }

    public function clean()
    {
        $this->logData = '';
    }
}
