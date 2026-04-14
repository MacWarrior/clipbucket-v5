<?php

/**
 * This loads all classes used by this project.
 */

require_once __DIR__ . '/src/Profilers/ProfilerInterface.php';
require_once __DIR__ . '/src/Saver/SaverInterface.php';

require_once __DIR__ . '/src/Exception/ProfilerException.php';
require_once __DIR__ . '/src/Config.php';
require_once __DIR__ . '/src/Profiler.php';
require_once __DIR__ . '/src/ProfilerFactory.php';
require_once __DIR__ . '/src/Profilers/AbstractProfiler.php';
require_once __DIR__ . '/src/Profilers/Tideways.php';
require_once __DIR__ . '/src/Profilers/TidewaysXHProf.php';
require_once __DIR__ . '/src/Profilers/UProfiler.php';
require_once __DIR__ . '/src/Profilers/XHProf.php';
require_once __DIR__ . '/src/ProfilingData.php';
require_once __DIR__ . '/src/ProfilingFlags.php';
require_once __DIR__ . '/src/Saver/AbstractSaver.php';
require_once __DIR__ . '/src/Saver/FileSaver.php';
require_once __DIR__ . '/src/Saver/MongoSaver.php';
require_once __DIR__ . '/src/Saver/PdoSaver.php';
require_once __DIR__ . '/src/Saver/StackSaver.php';
require_once __DIR__ . '/src/Saver/UploadSaver.php';
require_once __DIR__ . '/src/SaverFactory.php';
