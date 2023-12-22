<?php
class DirPath
{
    public static function get(string $dir_name, $get_url = false): string
    {
        $root_directory = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        switch($dir_name){
            default:
            case 'root':
                $path = $root_directory;
                $url = '';
                break;

            case 'files':
            case 'images':
            case 'player':
            case 'plugins':
            case 'admin_area':
            case 'styles':
            case 'cache':
            case 'js':
            case 'css':
            case 'actions':
            case 'changelog':
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
            case 'icons':
                $path = $root_directory . 'images' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'images/' . $dir_name;
                break;

            case 'userfeeds':
                $path = $root_directory . 'cache' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'cache/' . $dir_name;
                break;

            case 'sql':
                $path = $root_directory . 'cb_install' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'cb_install/' . $dir_name;
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


const TEMPLATEFOLDER = 'styles';





const IN_CLIPBUCKET = true;

//Setting Cookie Timeout
const COOKIE_TIMEOUT = 86400 * 1; // 1
const GARBAGE_TIMEOUT = COOKIE_TIMEOUT;
const REMBER_DAYS = 7;