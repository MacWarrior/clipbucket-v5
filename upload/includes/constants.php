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

            case 'theme_css':
            case 'theme_js':
            case 'theme_image':
            case 'theme_asset':
            case 'theme_font':
                $base_path = $root_directory . DIRECTORY_SEPARATOR . 'styles' . DIRECTORY_SEPARATOR . config('template_dir') . DIRECTORY_SEPARATOR . 'theme' . DIRECTORY_SEPARATOR;
                $base_url = 'styles/' . config('template_dir') . '/theme/';

                switch($dir_name){
                    case 'theme_css':
                        $path = $base_path . 'css';
                        $url = $base_url . 'css';
                        break 2;

                    case 'theme_js':
                        $path = $base_path . 'js';
                        $url = $base_url . 'js';
                        break 2;

                    case 'theme_image':
                        $path = $base_path . 'images';
                        $url = $base_url . 'images';
                        break 2;

                    case 'theme_asset':
                        $path = $base_path . 'assets';
                        $url = $base_url . 'assets';
                        break 2;

                    case 'theme_font':
                        $path = $base_path . 'fonts';
                        $url = $base_url . 'fonts';
                        break 2;
                }


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