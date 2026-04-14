#!/usr/bin/env php
<?php

use Xhgui\Profiler\ImporterFactory;

require __DIR__ . '/../vendor/autoload.php';

$importer = ImporterFactory::create();

if ($argc > 1) {
    foreach (array_splice($argv, 1) as $file) {
        if (!is_readable($file)) {
            throw new RuntimeException("{$file} isn't readable");
        }

        $fp = fopen($file, 'r');
        if (!$fp) {
            throw new RuntimeException("Can't open {$file}");
        }
        $importer->import($fp);
        fclose($fp);
    }
} else {
    $importer->import(STDIN);
}

