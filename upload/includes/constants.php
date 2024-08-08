<?php
class DirPath
{
    public static function get(string $dir_name, $get_url = false): string
    {
        $root_directory = dirname(__DIR__);
        switch($dir_name){
            default:
            case 'root':
                $path = $root_directory;
                $url = '';
                break;

            case 'actions':
            case 'admin_area':
            case 'cache':
            case 'cb_install':
            case 'changelog':
            case 'css':
            case 'files':
            case 'images':
            case 'includes':
            case 'js':
            case 'player':
            case 'plugins':
            case 'styles':
            case 'vendor':
                $path = $root_directory . DIRECTORY_SEPARATOR . $dir_name;
                $url = $dir_name;
                break;

            case 'avatars':
            case 'backgrounds':
            case 'conversion_queue':
            case 'logos':
            case 'logs':
            case 'mass_uploads':
            case 'original':
            case 'photos':
            case 'subtitles':
            case 'temp':
            case 'thumbs':
            case 'videos':
            case 'category_thumbs':
                $path = $root_directory . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'files/' . $dir_name;
                break;

            case 'collection_thumbs':
            case 'icons':
            case 'playlist_covers':
                $path = $root_directory . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'images/' . $dir_name;
                break;

            case 'userfeeds':
            case 'views':
                $path = $root_directory . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'cache/' . $dir_name;
                break;

            case 'sql':
                $path = $root_directory . DIRECTORY_SEPARATOR . 'cb_install' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'cb_install/' . $dir_name;
                break;

            case 'classes':
                $path = $root_directory . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $dir_name;
                $url = 'includes/' . $dir_name;
                break;
        }

        if($get_url){
            return '/' . $url . '/';
        }
        return $path . DIRECTORY_SEPARATOR;
    }

    public static function getUrl($dir_name): string
    {
        return self::get($dir_name, true);
    }
}

const IN_CLIPBUCKET = true;

//Setting Cookie Timeout
const COOKIE_TIMEOUT = 86400 * 1; // 1
const REMBER_DAYS = 7;