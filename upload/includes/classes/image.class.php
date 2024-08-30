<?php
class Image{
    public static function getMemoryNeededForImage( $filename )
    {
        if( !file_exists($filename) ){
            return false;
        }

        $imageInfo = getimagesize($filename);
        $current_memory_usage = memory_get_usage();
        return round( ( $imageInfo[0] * $imageInfo[1]
                * $imageInfo['bits']
                * ($imageInfo['channels'] / 8)
            ) * 1.5 + $current_memory_usage
        );
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

            if (!$aspect_ratio && $dim_h != '') {
                $width = $dim;
                $height = $dim_h;
            }

            $image_p = imagecreatetruecolor($width, $height);

            switch (strtolower($ext)) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($file);
                    break;

                case 'png':
                    $image = imagecreatefrompng($file);
                    break;

                case 'gif':
                    $image = imagecreatefromgif($file);
                    break;

                default:
                    return;
            }

            // Output format is always jpeg
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            imagejpeg($image_p, $des, 90);

            imagedestroy($image_p);
            imagedestroy($image);
        } else {
            if (!file_exists($des)) {
                copy($file, $des);
            }
        }
    }

    //Validating an Image
    function ValidateImage($file, $ext = null): bool
    {
        if( !in_array(strtolower($ext), ['jpg','jpeg','gif','png']) ) {
            return false;
        }

        $array = getimagesize($file);
        if (empty($array[0]) || empty($array[1])) {
            return false;
        }

        return true;
    }
}