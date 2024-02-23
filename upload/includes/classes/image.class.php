<?php

class Image
{
    public static function getThumbnailsResolutions($type): array
    {
        switch($type)
        {
            default:
                e('Unknown type : '.$type);
                return [];

            case 'video_thumbnail':
                return [
                    ['168', '105']
                    ,['416', '260']
                    ,['632', '395']
                    ,['768', '432']
                ];

            // TODO
            case 'video_poster':
            case 'video_backdrop':
            case 'photo':
                return[];
        }
    }

    public static function generateThumbnail($params): bool
    {
        if( !file_exists($params['input_file']) ){
            e('Input file doesn\'t exists : ' . $params['input_file']);
            return false;
        }

        $input_extension = getExt($params['input_file']);
        if( $input_extension == 'jpg' ){
            $input_extension = 'jpeg';
        }

        $image_create_function_name = 'imagecreatefrom' . $input_extension;
        if( !function_exists($image_create_function_name) ){
            e('Unsupported image format : ' . $input_extension);
            return false;
        }

        $input_file = call_user_func($image_create_function_name, $params['input_file']);

        $input_width = imagesx($input_file);
        $input_height = imagesy($input_file);

        if( empty($input_width) || empty($input_height) ){
            e('Unable to get image size : ' . $params['input_file']);
            imagedestroy($input_file);
            return false;
        }

        if( $params['output_width'] < $input_width && $params['output_height'] < $input_height ){
            // Nothing to do, original file is smaller than asked size
            imagedestroy($input_file);
            return true;
        }

        $output_image = imagecreatetruecolor($params['output_width'], $params['output_height']);

        imagecopyresampled($output_image, $input_file, 0, 0, 0, 0, $params['output_width'], $params['output_height'], $input_width, $input_height);

        $image_save_function_name = 'image' . $params['output_extension'];
        call_user_func($image_save_function_name, $input_file, $params['output_file'], $params['output_quality'] ?? 100);

        imagedestroy($input_file);
        imagedestroy($output_image);

        if( !file_exists($params['output_file']) ){
            e('Output file hasn\'t been created : ' . $params['output_file']);
            return false;
        }

        return true;
    }
}

class ResizeImage
{
    //Resize the following image
    function CreateThumb($file, $des, $dim, $ext, $dim_h = null, $aspect_ratio = true)
    {
        $array = getimagesize($file);
        $width_orig = $array[0];
        $height_orig = $array[1];

        if ($width_orig > $dim || $height_orig > $dim) {
            if ($width_orig > $height_orig) {
                $ratio = $width_orig / $dim;
            } else {
                if ($dim_h == null) {
                    $ratio = $height_orig / $dim;
                } else {
                    $ratio = $height_orig / $dim_h;
                }
            }

            $width = $width_orig / $ratio;
            $height = $height_orig / $ratio;

            if ($aspect_ratio == false && $dim_h != '') {
                $width = $dim;
                $height = $dim_h;
            }

            $image_p = imagecreatetruecolor($width, $height);

            switch (strtolower($ext)) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($file);
                    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                    imagejpeg($image_p, $des, 90);
                    break;

                case 'png':
                    $image = imagecreatefrompng($file);
                    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                    imagepng($image_p, $des);
                    break;

                case 'gif':
                    $image = imagecreatefromgif($file);
                    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                    imagegif($image_p, $des);
                    break;
            }
        } else {
            if (!file_exists($des)) {
                copy($file, $des);
            }
        }
    }

    //Validating an Image
    function ValidateImage($file, $ext = null)
    {
        $array = getimagesize($file);
        if ($ext == 'jpg' || $ext == 'JPG' || $ext == 'JPEG' || $ext == 'gif' || $ext == 'GIF' || $ext == 'PNG' || $ext == 'png') {
            if (empty($array[0]) || empty($array[1])) {
                $validate = false;
            } else {
                $validate = true;
            }
        } else {
            $validate = false;
        }
        return $validate;
    }
}
