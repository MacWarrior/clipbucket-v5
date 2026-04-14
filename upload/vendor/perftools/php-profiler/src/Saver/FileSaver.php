<?php

namespace Xhgui\Profiler\Saver;

final class FileSaver implements SaverInterface
{
    /** @var string */
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function isSupported()
    {
        return $this->file && is_writable(dirname($this->file));
    }

    public function save(array $data)
    {
        $json = json_encode($data, PHP_VERSION_ID >= 70200 ? JSON_INVALID_UTF8_IGNORE : 0);

        if ($json === false) {
            return false;
        }

        return file_put_contents($this->file, $json . PHP_EOL, FILE_APPEND);
    }
}
