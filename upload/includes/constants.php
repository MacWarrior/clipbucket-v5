<?php
class DirPath
{
    public static function get(string $dir_name, $get_url = false): string
    {
        $root_directory = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        switch($dir_name){
            case 'files':
            case 'images':
            case 'player':
            case 'plugins':
            case 'admin_area':
            case 'styles':
            case 'cache':
                $path = $root_directory . $dir_name;
                $url = $dir_name;
                break;

            case 'avatars':
            case 'backgrounds':
            case 'videos':
            case 'subtitles':
            case 'thumbs':
            case 'original':
            case 'conversion_queue':
            case 'mass_uploads':
            case 'logs':
            case 'temp':
            case 'photos':
            case 'logos':
                $path = $root_directory . 'files' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'files/' . $dir_name;
                break;

            case 'category_thumbs':
            case 'collection_thumbs':
            case 'playlist_covers':
                $path = $root_directory . 'images' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'images/' . $dir_name;
                break;
        }

        if($get_url){
            return '/' . $url . '/';
        }
        return $path . DIRECTORY_SEPARATOR;
    }

    public static function getUrl($dir_name)
    {
        return self::get($dir_name, true);
    }
}
define("BASEDIR", dirname(__DIR__));

const FILES_DIR = BASEDIR . DIRECTORY_SEPARATOR . 'files';
const TEMP_DIR = FILES_DIR . DIRECTORY_SEPARATOR . 'temp';
const PLUG_DIR = BASEDIR . DIRECTORY_SEPARATOR . 'plugins';

const TEMPLATEFOLDER = 'styles';





const IN_CLIPBUCKET = true;

//Setting Cookie Timeout
const COOKIE_TIMEOUT = 86400 * 1; // 1
const GARBAGE_TIMEOUT = COOKIE_TIMEOUT;
const REMBER_DAYS = 7;

const JS_URL = '/js';
const CSS_URL = '/css';

const PLAYER_URL = '/player';

# ADVANCE CACHING
const CACHE_DIR = BASEDIR . '/cache';

# User Feeds
const USER_FEEDS_DIR = CACHE_DIR . '/userfeeds';


const PLUG_URL = '/plugins';