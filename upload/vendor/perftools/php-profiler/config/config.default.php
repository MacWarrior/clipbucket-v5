<?php
/**
 * Default configuration for PHP Profiler.
 *
 * To change these, create a file called `config.php` file in the same directory
 * and return an array from there with your overriding settings.
 */

use Xhgui\Profiler\Profiler;
use Xhgui\Profiler\ProfilingFlags;

return array(
    'save.handler' => Profiler::SAVER_STACK,
    'save.handler.stack' => array(
        'savers' => array(
            Profiler::SAVER_UPLOAD,
            Profiler::SAVER_FILE,
        ),
        'saveAll' => false,
    ),
    'save.handler.file' => array(
        'filename' => sys_get_temp_dir() . '/xhgui.data.jsonl',
    ),
    'profiler.enable' => function () {
        return true;
    },
    'profiler.flags' => array(
        ProfilingFlags::CPU,
        ProfilingFlags::MEMORY,
        ProfilingFlags::NO_BUILTINS,
        ProfilingFlags::NO_SPANS,
    ),
    'profiler.options' => array(),
    'profiler.exclude-env' => array(),
    'profiler.simple_url' => function ($url) {
        return preg_replace('/=\d+/', '', $url);
    },
    'profiler.replace_url' => null,
);
