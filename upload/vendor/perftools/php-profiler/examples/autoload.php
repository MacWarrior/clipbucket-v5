<?php

/**
 * Bootstrap for php-profiler. Copy and customize this file,
 * include this file inside some bootstrapper or other "early central point in execution"
 *
 * Documentation:
 * - https://github.com/perftools/php-profiler#create-profiler
 * - https://github.com/perftools/php-profiler#config
 */

use Xhgui\Profiler\Profiler;
use Xhgui\Profiler\ProfilingFlags;

require __DIR__ . '/../vendor/autoload.php';

try {
    $config = array(
        // If defined, use specific profiler
        // otherwise use any profiler that's found
        'profiler' => Profiler::PROFILER_TIDEWAYS_XHPROF,

        // This allows to configure, what profiling data to capture
        'profiler.flags' => array(
            ProfilingFlags::CPU,
            ProfilingFlags::MEMORY,
            ProfilingFlags::NO_BUILTINS,
            ProfilingFlags::NO_SPANS,
        ),

        // Saver to use.
        // Please note that 'pdo' and 'mongo' savers are deprecated
        // Prefer 'upload' or 'file' saver.
        'save.handler' => Profiler::SAVER_UPLOAD,

        // Saving profile data by upload is only recommended with HTTPS
        // endpoints that have IP whitelists applied.
        // https://github.com/perftools/php-profiler#upload-saver
        'save.handler.upload' => array(
            'url' => 'https://example.com/run/import',
            // The timeout option is in seconds and defaults to 3 if unspecified.
            'timeout' => 3,
            // the token must match 'upload.token' config in XHGui
            'token' => 'token',
        ),

        // https://github.com/perftools/php-profiler#file-saver
        'save.handler.file' => array(
            // Appends jsonlines formatted data to this path
            'filename' => '/tmp/xhgui.data.jsonl',
        ),

        // https://github.com/perftools/php-profiler#stack-saver
        'save.handler.stack' => array(
            'savers' => array(
                Profiler::SAVER_UPLOAD,
                Profiler::SAVER_FILE,
            ),
            // if saveAll=false, break the chain on successful save
            'saveAll' => false,
        ),

        // https://github.com/perftools/php-profiler#mongodb-saver
        'save.handler.mongodb' => array(
            'dsn' => 'mongodb://127.0.0.1:27017',
            'database' => 'xhprof',
            // Allows you to pass additional options like replicaSet to MongoClient.
            // 'username', 'password' and 'db' (where the user is added)
            'options' => array(),
            // Allows you to pass driver options like ca_file to MongoClient
            'driverOptions' => array(),
        ),

        // https://github.com/perftools/php-profiler#pdo-saver
        'save.handler.pdo' => array(
            'dsn' => 'sqlite:/tmp/xhgui.sqlite3',
            'user' => null,
            'pass' => null,
            'table' => 'results',
        ),

        // Environment variables to exclude from profiling data
        'profiler.exclude-env' => array(),
        'profiler.options' => array(),

        /**
         * Determine whether the profiler should run.
         * This default implementation just disables the profiler.
         * Override this with your custom logic in your config
         * @return bool
         */
        'profiler.enable' => function () {
            return true;
        },

        /**
         * Creates a simplified URL given a standard URL.
         * Does the following transformations:
         *
         * - Remove numeric values after "=" in query string.
         *
         * @param string $url
         * @return string
         */
        'profiler.simple_url' => function ($url) {
            return preg_replace('/=\d+/', '', $url);
        },

        /**
         * Enable this to clean up the url before submitting it to XHGui.
         * This way it is possible to remove sensitive data or discard any other data.
         *
         * The URL argument is the `REQUEST_URI` or `argv` value.
         *
         * @param string $url
         * @return string
         */
        'profiler.replace_url' => function ($url) {
            return str_replace('token', '', $url);
        },
    );

    /**
     * The constructor will throw an exception if the environment
     * isn't fit for profiling (extensions missing, other problems)
     */
    $profiler = new Profiler($config);

    // The profiler itself checks whether it should be enabled
    // for request (executes lambda function from config)
    $profiler->start();
} catch (Exception $e) {
    // throw away or log error about profiling instantiation failure
    error_log($e->getMessage());
}
