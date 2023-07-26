<?php

$base_filepath = realpath(__DIR__ . '/../changelog');

$filepath_latest = $base_filepath . DIRECTORY_SEPARATOR.'latest.json';
$latest = json_decode(file_get_contents($filepath_latest), true);

$state = 'STABLE';
if ($latest['stable'] != $latest['dev']) {
    $state = 'DEV';
}
define('STATE', $state);

$version = $latest['dev'];
DEFINE('CHANGELOG', $version);

$filepath_changelog = $base_filepath . DIRECTORY_SEPARATOR . $version . '.json';
$changelog = json_decode(file_get_contents($filepath_changelog), true);
define('VERSION', $changelog['version']);
define('REV', $changelog['revision']);
