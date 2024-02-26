<?php

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