<?php
/*
    Plugin Name: Server Thumb for ClipBucket
    Description: Increase photos thumbs quality of default theme
    Author: Mohammad Shoaib & MacWarrior
    Website: https://github.com/MacWarrior/clipbucket-v5/
    Version: 2.0.3
    ClipBucket Version: 5.5.1
*/
const DEFAULT_WIDTH = 200;
const DEFAULT_HEIGHT = 120;

$__resize_thumbs = true;

$cache_dir = DirPath::get('cache') . 'cb_server_thumb' . DIRECTORY_SEPARATOR;
if (!is_writable($cache_dir)) {
    $__resize_thumbs = false;

    if (has_access('admin_access')) {
        e($cache_dir . ' directory is not writeable', 'w');
    }
}

/**
 * @throws Exception
 */
function get_server_img($params)
{
    global $__resize_thumbs;

    if (!$__resize_thumbs) {
        return false;
    }

    $w = DEFAULT_WIDTH;
    $h = DEFAULT_HEIGHT;

    $timthumb_path = DirPath::getUrl('plugins') . 'cb_server_thumb/timthumb.php?src=';

    $details = $params['details'];
    $output = $params['output'];
    $size = $params['size'];

    //on view photo page image with original size needed so this is simple patch
    if (THIS_PAGE == 'view_item' && isset($details['photo_key']) && isset($_GET['item']) && $_GET['item'] == $details['photo_key']) {
        $url = DirPath::getUrl('photos');
        $path = DirPath::get('photos');

        $image_name = $details['filename'] . '.' . $details['ext'];

        if (isset($details['file_directory']) && $details['file_directory'] != '') {
            $photo_link = $url . $details['file_directory'] . '/' . $image_name;
            $photo_path = $path . $details['file_directory'] . DIRECTORY_SEPARATOR . $image_name;
        } else {
            $photo_link = $url . $image_name;
            $photo_path = $path . $image_name;
        }

        if (file_exists($photo_path)) {
            $max_width = 900;

            $image_size = getimagesize($photo_path);
            $image_width = $image_size[0];
            $image_height = $image_size[1];

            if ($image_width >= $max_width) {
                $image_height = ($max_width / $image_width) * $image_height;

                if ($details['file_directory'] != '') {
                    $image_directory = $details['file_directory'] . DIRECTORY_SEPARATOR;
                } else {
                    $image_directory = '';
                }

                $photo_link = $timthumb_path . $image_name . '&directory=photos/' . $image_directory . '&type=photos&h=' . $image_height . '&w=900&zc=1';
            }

            $photo_link = str_replace('.jpg', '_l.jpg', $photo_link);
            if ($output == 'html') {
                return "<img class='img-responsive' src='$photo_link'/>";
            }
            return $photo_link;
        }

        return get_photo_default_thumb(null, $output);
    }

    $default = ['t', 'm', 'l', 'o'];
    $thumbs = [];
    if (!$details) {
        return get_photo_default_thumb($size, $output);
    }

    if (!is_array($details)) {
        global $cbphoto;
        $photo = $cbphoto->get_photo($details, true);
    } else {
        $photo = $details;
    }

    if (empty($photo['photo_id']) || empty($photo['photo_key'])) {
        return get_photo_default_thumb($size, $output);
    }

    if (empty($photo['filename']) || empty($photo['ext'])) {
        return get_photo_default_thumb($size, $output);
    }

    $params['photo'] = $photo;

    $path = DirPath::get('photos');
    $directory = get_photo_date_folder($photo);
    $with_original = $params['with_orig'];

    $size = (!in_array($size, $default) || !$size) ? 't' : $size;

    if ($size == 'l') {
        $w = 320;
        $h = 250;
    } else {
        if ($size == 'm') {
            $w = 160;
            $h = 90;
        } else {
            if ($size == 't') {
                $w = 120;
                $h = 60;
            }
        }
    }

    list($width, $height) = explode('x', $params['size']);
    if (isset($width) && is_numeric($width) && isset($height) && is_numeric($height)) {
        $w = $width;
        $h = $height;
    }

    $tim_postfix = '&type=photos&h=' . $h . '&w=' . $w . '&zc=1';

    if ($directory) {
        $directory .= DIRECTORY_SEPARATOR;
    }

    $path .= DIRECTORY_SEPARATOR . $directory;
    $filename = $photo['filename'] . '%s.' . $photo['ext'];

    $files = glob($path . sprintf($filename, '*'));

    if (empty($files)) {
        return get_photo_default_thumb($size, $output);
    }

    global $cbphoto;
    foreach ($files as $file) {
        $thumb_name = explode('/', $file);
        $thumb_name = end($thumb_name);
        $thumb_type = $cbphoto->get_image_type($thumb_name);

        if ($with_original || !empty($thumb_type)) {
            $thumbs[] = $timthumb_path . $thumb_name . '&directory=photos/' . $directory . $tim_postfix;
        }
    }

    if (empty($output) || $output == 'non_html') {
        if ($params['assign'] && $params['multi']) {
            assign($params['assign'], $thumbs);
        } else {
            if ($params['multi']) {
                return $thumbs;
            } else {
                $search_name = sprintf($filename, '_' . $size);
                $return_thumb = array_find($search_name, $thumbs);

                if (empty($return_thumb)) {
                    return get_photo_default_thumb($size, $output);
                }

                if ($params['assign']) {
                    assign($params['assign'], $return_thumb);
                } else {
                    return $return_thumb;
                }
            }
        }
    }

    if ($output == 'html') {
        $search_name = sprintf($filename, '_' . $size);
        $src = array_find($search_name, $thumbs);

        $src = (empty($src)) ? get_photo_default_thumb($size) : $src;
        $attrs = ['src' => $src];

        $image_details = json_decode($photo['photo_details'], true);

        if (empty($image_details) || empty($image_details[$size])) {
            /* UPDATING IMAGE DETAILS */
            $cbphoto->update_image_details($photo);
        }

        $attrs['id'] = ($params['id'] ? $params['id'] . '_' : 'photo_') . $photo['photo_id'];

        if ($params['class']) {
            $attrs['class'] = mysql_clean($params['class']);
        }

        if ($params['align']) {
            $attrs['align'] = mysql_clean($params['align']);
        }

        $attrs['title'] = $photo['photo_title'];

        if (isset($params['title']) && $params['title'] == '') {
            unset($attrs['title']);
        }

        $attrs['alt'] = TITLE . ' - ' . $photo['photo_title'];

        $anchor_p = ['place' => 'photo_thumb', 'data' => $photo];
        ANCHOR($anchor_p);

        if ($params['style']) {
            $attrs['style'] = $params['style'];
        }

        if ($params['extra']) {
            $attrs['extra'] = $params['extra'];
        }

        $image = cb_create_html_tag('img', true, $attrs);

        if ($params['assign']) {
            assign($params['assign'], $image);
        } else {
            return $image;
        }
    }

    return false;
}

global $Cbucket;
$Cbucket->custom_get_photo_funcs[] = 'get_server_img';
$Cbucket->custom_user_thumb[] = 'user_thumb';
