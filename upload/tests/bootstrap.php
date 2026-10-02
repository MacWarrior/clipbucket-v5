<?php

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

/**
 * Standalone stubs for video_playable()'s dependencies (User/userquery, lang/e/config,
 * user_id/user_name, cb_get_functions). This lets the real includes/functions_video.php
 * run without the app's DB/session bootstrap, which this checkout doesn't have configured.
 * Only functions_video.php's actual code is under test; everything below is test scaffolding.
 */

$GLOBALS['__test_user_id'] = 0;
$GLOBALS['__test_user_name'] = '';
$GLOBALS['__test_configs'] = ['enable_age_restriction' => 'no'];

function user_id()
{
    return $GLOBALS['__test_user_id'];
}

function user_name()
{
    return $GLOBALS['__test_user_name'];
}

function config($key)
{
    return $GLOBALS['__test_configs'][$key] ?? null;
}

function lang($key)
{
    return $key;
}

function e($message, $type = 'e')
{
}

function cb_get_functions($hook)
{
    return false;
}

class User
{
    private static ?User $instance = null;

    public static function getInstance(): User
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function hasAdminAccess(): bool
    {
        return false;
    }

    public function hasPermission($permission): bool
    {
        return false;
    }
}

class userquery
{
    private static ?userquery $instance = null;

    public static function getInstance(): userquery
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function is_confirmed_friend($userid, $contact_userid): bool
    {
        return false;
    }
}

require_once __DIR__ . '/../includes/functions_video.php';
