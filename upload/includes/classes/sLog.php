<?php

class SLog
{
    private $logFile = false;
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

    public function newSection($sectionName = false)
    {
        if (!$sectionName) {
            $sectionName = 'New Section';
        }
        $this->logData = "\n\n".'==========================================';
        $this->logData .= "\n" . $sectionName;
        $this->logData .= "\n".'==========================================';

        $this->appendLog();
    }

    public function writeLine($title = false, $description = false, $isHtml = false)
    {
        if (is_array($description)) {
            $description = json_encode($description);
        }

        $newLine = '';
        if( !$isHtml ){
            $newLine = "\n";
        }

        $this->logData = '';

        if(!empty($title)){
            $this->logData .= $newLine.$title;
        }

        if(!empty($title) && !empty($description)){
            $loop = strlen($title);
            $underline = str_repeat('-', $loop);
            $this->logData .= $newLine.$underline;
        }

        if(!empty($description)){
            $this->logData .= $newLine.$description;
        }

        $this->appendLog();
    }

    public function appendLog()
    {
        if (!$this->logFile) {
            return;
        }

        file_put_contents($this->logFile, $this->logData, FILE_APPEND);
        return $this;
    }
}
