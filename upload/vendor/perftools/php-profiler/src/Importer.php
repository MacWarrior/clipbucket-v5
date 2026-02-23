<?php

namespace Xhgui\Profiler;

use Exception;
use Xhgui\Profiler\Saver\SaverInterface;

final class Importer
{
    /** @var SaverInterface */
    private $saver;

    public function __construct(SaverInterface $saver)
    {
        $this->saver = $saver;
    }

    public function import($stream)
    {
        $saver = $this->saver;
        $lines = 0;
        while (!feof($stream)) {
            $line = trim(fgets($stream));
            if (!$line) {
                continue;
            }
            $data = json_decode($line, true);
            if (!$data) {
                error_log("Ignoring malformed JSON line: $line");
                continue;
            }

            try {
                $saver->save($data);
                $lines++;
            } catch (Exception $e) {
                error_log($e);
            }
        }
        error_log("Imported {$lines} lines");
    }
}
