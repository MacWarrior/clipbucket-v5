<?php

class PhotoThumbs
{
    private static string $tableName = 'photo_image';

    private static string $tableNameThumb = 'photo_thumb';


    private static array $resolution_setting = [
        'original' => ['size_tag' => 'original', 'should_watermark' => true],
        'large'    => ['width' => 900, 'height' => 562, 'should_watermark' => true],
        'thumb'    => ['width' => 150, 'height' => 94, 'should_watermark' => false],
        'small'    => ['width' => 300, 'height' => 188, 'should_watermark' => false],
        'medium'   => ['width' => 550, 'height' => 344, 'should_watermark' => false]
        //150 300 550 (900)
    ];

    private static array $fieldsThumb = [
        'id_photo_thumb',
        'photo_id',
        'width',
        'extension',
        'version',
        'is_original_size'
    ];

    public static function getAllThumbs(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_photo_id = $params['photo_id'] ?? false;
        $param_width = $params['width'] ?? false;
        $param_height = $params['height'] ?? false;
        $param_get_photo_info = $params['get_photo_info'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        if (!$param_count) {
            $select = self::getAllFieldsThumbs();
            if ($param_get_photo_info) {
                $select[] = Photo::getInstance()->getTableName() . '.file_directory ';
                $select[] = Photo::getInstance()->getTableName() . '.filename ';
                $select[] = Photo::getInstance()->getTableName() . '.ext ';
            }
        } else {
            $select[] = 'COUNT(DISTINCT ' . self::$tableNameThumb . '.id_photo_thumb) AS count';
        }

        if ($param_photo_id !== false) {
            $conditions[] = self::$tableNameThumb . '.photo_id = ' . mysql_clean($param_photo_id);
        }

        if ($param_width == 'original' || $param_height == 'original') {
            $conditions[] = self::$tableNameThumb . '.is_original_size = ' . (mysql_clean($param_width) ? 1 : 0);
        } else {
            if ($param_width) {
                $conditions[] = self::$tableNameThumb . '.width = ' .  mysql_clean($param_width);
            }
            if ($param_height) {
                $conditions[] = self::$tableNameThumb . '.height = ' . mysql_clean($param_height);
            }
        }

        $join[] = ' LEFT JOIN ' . cb_sql_table(Photo::getInstance()->getTableName()) . ' ON ' . Photo::getInstance()->getTableName() . '.photo_id = ' . self::$tableNameThumb . '.photo_id';

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }

        $sql = 'SELECT ' . implode(', ', $select) . '
                    FROM ' . cb_sql_table(self::$tableNameThumb)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(', ', $group))
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($param_first_only) {
            return $result[0] ?? [];
        }
        if ($param_count) {
            return $result[0]['count'];
        }
        return empty($result) ? [] : $result;
    }

    /**
     * @param array $params
     * @return array
     * @throws Exception
     */
    public static function getOneThumb(array $params): array
    {
        $params['first_only'] = true;
        return self::getAllThumbs($params);
    }


    /**
     * @return array
     */
    private static function getAllFieldsThumbs(): array
    {
        return array_map(function ($field) {
            return self::$tableNameThumb . '.' . $field;
        }, self::$fieldsThumb);
    }

    public static function getTableNameThumb(): string
    {
        return self::$tableNameThumb;
    }



    /**
     * TODO
     * @return array
     */
    public function getPhotoDimension(): array
    {

    }

    /**
     * @param int $photo_id
     * @param int|string $width
     * @param string $return_type
     * @return array|string
     * @throws Exception
     */
    public static function getThumbFile(int $photo_id, int|string $width = 150, string $return_type = 'url'): array|string
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999') && $width != 'original') {
            $thumb_photo_directory_path = DirPath::get('thumbs') . 'photo' . DIRECTORY_SEPARATOR;
        } else {
            $thumb_photo_directory_path = DirPath::get('photos');
        }
        switch ($return_type) {
            default:
            case 'url':
                if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999') && $width != 'original') {
                    $thumb_photo_directory = DirPath::getUrl('thumbs') . 'photo' . DIRECTORY_SEPARATOR;
                } else {
                    $thumb_photo_directory = DirPath::getUrl('photos');
                }
                break;
            case 'filepath':
                $thumb_photo_directory = $thumb_photo_directory_path;
                break;
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $params = [
                'photo_id'       => $photo_id,
                'width'          => $width,
                'get_photo_info' => true
            ];
            $thumb = self::getOneThumb($params);
            if (!empty($thumb['is_original_size'])) {
                $thumb['width'] = 'original';
            }
        } else {
            //param old
            $photo = Photo::getInstance()->getOne(['photo_id' => $photo_id]);
            $res = preg_replace('/"attribute":\s*"width="(\d+)" height="(\d+)"\s*"/', '"attribute": "width=\\"$1\\" height=\\"$2\\""', $photo['photo_details']);
            $thumbs = json_decode($res, true);
            if ($width == 'original') {
                $thumb = $thumbs['o'];
            } else {
                $width_temp = 0;
                $min_width = 1000;
                foreach ($thumbs as $old_key => $thumb_photo) {
                    //searching for the thumb with the right width
                    if ($thumb_photo['width'] == $width) {
                        $thumb = $thumb_photo;
                        $thumb['width'] = $old_key;
                        break;
                    }
                    if ($thumb_photo['width'] < $min_width) {
                        $min_width = $thumb_photo['width'];
                        $min_key = $old_key;
                    }
                    if ($thumb_photo['width'] > $width_temp && $thumb_photo['width'] < $width) {
                        $width_temp = $thumb_photo['width'];
                        $thumb = $thumb_photo;
                        $thumb['width'] = $old_key;
                    }
                }
                if (!empty($min_key) && empty($thumb)) {
                    $thumb = ['width' => $min_key];
                }
            }
            if (!empty($thumb)) {
                $thumb['version'] = '5.5.2';
                $thumb['file_directory'] = $photo['file_directory'];
                $thumb['filename'] = $photo['filename'];
                $thumb['ext'] = $photo['ext'];
            }
        }
        if (empty($thumb)) {
            return self::getDefaultMissingThumb($return_type);
        }
        $thumb_path = self::getThumbPath($thumb['file_directory'], $thumb['filename'], $thumb['width'], $thumb['ext'], $thumb['version']);
        $filepath = $thumb_photo_directory . $thumb_path;
        if (!file_exists($thumb_photo_directory_path . $thumb_path)) {
            $filepath = self::getDefaultMissingThumb($return_type);
        }
        return $filepath;
    }


    /**
     * @param $type
     * @param $photo_file_directory
     * @param $photo_file_name
     * @param $thumb_is_auto
     * @param $thumb_num
     * @param $thumb_resolution
     * @param $thumb_width
     * @param $thumb_height
     * @param $thumb_extension
     * @param $thumb_version
     * @return string
     */
    public static function getThumbPath($photo_file_directory, $photo_file_name, $thumb_width, $thumb_extension, $thumb_version): string
    {
        if ($thumb_version > '5.5.2' && $thumb_width != 'original') {
            $filepath = $photo_file_directory . DIRECTORY_SEPARATOR . $photo_file_name .DIRECTORY_SEPARATOR;
        } else {
            $filepath = $photo_file_directory . DIRECTORY_SEPARATOR;
        }
        return $filepath . self::getThumbName($photo_file_name, $thumb_width, $thumb_extension, $thumb_version);
    }

    /**
     * @param $type
     * @param $photo_file_name
     * @param $thumb_is_auto
     * @param $thumb_num
     * @param $thumb_resolution
     * @param $thumb_width
     * @param $thumb_height
     * @param $thumb_extension
     * @param $thumb_version
     * @return string
     */
    public static function getThumbName($photo_file_name, $thumb_width, $thumb_extension, $thumb_version): string
    {
        if ($thumb_width == 'original') {
            return $photo_file_name . '.' . $thumb_extension;
        }
        if ($thumb_version <= '5.5.2') {
            $thumb_width = self::getOldNameFromResolutionArray()[$thumb_width] ?? $thumb_width;
            return $photo_file_name . '_' . $thumb_width . '.' . $thumb_extension;
        }
        return $photo_file_name . '-' . $thumb_width . '.' . $thumb_extension;
    }

    /**
     * get letter for resolution for old photos
     * @return string[]
     */
    private static function getOldNameFromResolutionArray(): array
    {
        return [
            'original'                                   => 'o',
            self::$resolution_setting['large']['width']  => 'l',
            self::$resolution_setting['medium']['width'] => 'm',
            self::$resolution_setting['thumb']['width']  => 't'
        ];
    }

    /**
     * @param string $return_type
     * @param bool $return_with_num
     * @return array|string
     */
    public static function getDefaultMissingThumb(string $return_type = 'url', bool $return_with_num = false): array|string
    {
        return $return_with_num ? ['thumb' => default_thumb($return_type), 'thumb_id' => 0, 'thumb_num' => 0] : default_thumb($return_type);
    }


    /**
     * @param array $photo
     * @param $file
     * @param $file_array_key
     * @param string $type
     * @param bool $is_auto
     * @return void
     * @throws Exception
     */
    public static function generateThumbs(array $photo, $ignore = false): void
    {
        if (empty($photo['photo_id'])) {
            return;
        }
        $thumb_photo_directory = DirPath::get('thumbs' ) . 'photo' . DIRECTORY_SEPARATOR;
        if (!file_exists($thumb_photo_directory . $photo['file_directory'] . DIRECTORY_SEPARATOR . $photo['filename'] . DIRECTORY_SEPARATOR) ) {
            mkdir($thumb_photo_directory. $photo['file_directory'] . DIRECTORY_SEPARATOR . $photo['filename'] . DIRECTORY_SEPARATOR, 0755, true);
        }
        $ext = $photo['ext'];
        $original_photo_path = DirPath::get('photos') . $photo['file_directory'] . DIRECTORY_SEPARATOR . $photo['filename'] . '.' . $ext;
        $original_sizes = getimagesize($original_photo_path);
        if (empty($original_sizes)) {
            return;
        }
        foreach (self::$resolution_setting as $resolution_key => $res) {
            if ($resolution_key == 'original') {
                $new_thumb_path = $original_photo_path;
            } else {
                $width = $res['width'] ;
                $new_thumb_path = $thumb_photo_directory . self::getThumbPath($photo['file_directory'], $photo['filename'], $width, $ext, Update::getInstance()->getCurrentCoreVersion());
                PhotoThumbs::CreateThumb($original_photo_path, $new_thumb_path, $width, $ext, $original_sizes);
            }
            if (file_exists($new_thumb_path)) {
                //watermark
                if ($res['should_watermark'] && config('watermark_photo')) {
                    self::watermark_image($new_thumb_path, $new_thumb_path);
                }
                Clipbucket_db::getInstance()->insert(tbl(self::$tableNameThumb), [
                    'photo_id',
                    'width',
                    'extension',
                    'version',
                    'is_original_size'
                ], [
                    $photo['photo_id'],
                    $res['width'] ?? 0,
                    $ext,
                    Update::getInstance()->getCurrentCoreVersion(),
                    (int)($resolution_key == 'original')
                ], ignore: $ignore);
            } else {
                e(lang('error_uploading_thumb'));
                return;
            }
        }
    }

    /**
     * @param $filename
     * @return false|float
     */
    public static function getMemoryNeededForImage($filename ): float|bool
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

    //Resize the following image

    /**
     * @param string $original_file_path
     * @param string $destination_path
     * @param int|string $destination_width
     * @param int $destination_height
     * @param string $extension
     * @param array $original_sizes
     * @return void
     * @throws Exception
     */
    public static function CreateThumb(string $original_file_path, string $destination_path, int|string $destination_width, string $extension, array $original_sizes): void
    {
        $org_width = $original_sizes[0];
        $org_height = $original_sizes[1];

        if ($org_width > $destination_width && !empty($destination_width) && $destination_width != 'original') {
            if( stristr(PHP_OS, 'WIN') ) {
                // On Windows hosts, imagecreatefromX functions consumes lots of RAM
                $memory_needed = PhotoThumbs::getMemoryNeededForImage($original_file_path);
                $memory_limit = ini_get('memory_limit');
                if ($memory_needed > getBytesFromFileSize($memory_limit)) {
                    $msg = 'Photo generation would requiere ~' . System::get_readable_filesize($memory_needed, 0) . ' of memory, but it\'s currently limited to ' . $memory_limit;
                    if (System::isInDev()) {
                        e($msg);
                    } else {
                        e(lang('technical_error'));
                    }
                    DiscordLog::sendDump($msg);
                    return;
                }
            }

            $ratio = $org_width / $destination_width; // We will resize it according to Width

            $width = $org_width / $ratio;
            $height = $org_height / $ratio;

            $image_r = imagecreatetruecolor($width, $height);

            switch ($extension) {
                case 'jpeg':
                case 'jpg':
                case 'JPG':
                case 'JPEG':
                    $image = imagecreatefromjpeg($original_file_path);
                    imagecopyresampled($image_r, $image, 0, 0, 0, 0, $width, $height, $org_width, $org_height);
                    imagejpeg($image_r, $destination_path, 90);
                    break;

                case 'png':
                case 'PNG':
                    $image = imagecreatefrompng($original_file_path);
                    imagecopyresampled($image_r, $image, 0, 0, 0, 0, $width, $height, $org_width, $org_height);
                    imagepng($image_r, $destination_path, 9);
                    break;

                case 'gif':
                case 'GIF':
                    $image = imagecreatefromgif($original_file_path);
                    imagecopyresampled($image_r, $image, 0, 0, 0, 0, $width, $height, $org_width, $org_height);
                    imagegif($image_r, $destination_path, 90);
                    break;
            }
            imagedestroy($image_r);
            imagedestroy($image);
        } else {
            if (!file_exists($destination_path)) {
                if (!is_dir($original_file_path)) {
                    copy($original_file_path, $destination_path);
                }
            }
        }
    }

    //Validating an Image
    public static function ValidateImage($file, $ext = null): bool
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


    /**
     * @param array $image
     * @param bool $msg
     * @return void
     * @throws Exception
     */
    public static function deleteThumbs(int $photo_id, bool $msg = true)
    {
        $thumbs = self::getAllThumbs(['photo_id' => $photo_id, 'get_photo_info'=>true]);
        foreach ($thumbs as $thumb) {
            self::deletePhotoThumb($thumb);
        }
        if ($msg) {
            e(lang('photo_delete_successfully'), 'm');
        }
    }

    public static function deletePhotoThumb(array $thumb)
    {
        $thumb_path = DirPath::get('thumbs') . 'photo' . DIRECTORY_SEPARATOR . self::getThumbPath($thumb['file_directory'], $thumb['filename'], ($thumb['is_original_size'] ? 'original' : $thumb['width']), $thumb['extension'], $thumb['version']);
        if (file_exists($thumb_path)) {
            unlink($thumb_path);
        }
        Clipbucket_db::getInstance()->delete(tbl(self::$tableNameThumb), ['id_photo_thumb'],[$thumb['id_photo_thumb']]);
    }


    /**
     * @param int $photo_id
     * @param int|string $width
     * @param $params_html
     * @return string
     * @throws Exception
     */
    public static function getHtmlThumbFile(int $photo_id, int|string $width, $params_html = []): string
    {
        $photo = Photo::getInstance()->getOne(['photo_id' => $photo_id]);
        $src = self::getThumbFile($photo_id, $width);

        $anchor_p = [
            'place' => 'photo_thumb',
            'data'  => $photo
        ];
        $attrs = [
            'src'   => str_replace(DIRECTORY_SEPARATOR, '/', $src),
            'id'    => (($params_html['id']) ? $params_html['id'] . '_' : 'photo_') . $photo_id,
            'html'  => $photo['photo_title'],
            'alt'   => TITLE . ' - ' . $photo['photo_title'],
            'extra' => ANCHOR($anchor_p)
        ];

        if (!empty($params_html['class'])) {
            $attrs['class'] = $params_html['class'];
        }

        if (!empty($params_html['crop']) && config('keep_ratio_photo')=='yes') {
            $attrs['class'] .= ' crop_image';
        }

        if (!empty($params_html['align'])) {
            $attrs['align'] = $params_html['align'];
        }

        if (isset($params_html['title']) and $params_html['title'] == '') {
            unset($attrs['title']);
        }

        if (!empty($params_html['style'])) {
            $attrs['style'] = $params_html['style'];
        }

        if (!empty($params_html['extra'])) {
            $attrs['extra'] = $params_html['extra'];
        }

        return cb_create_html_tag('img', true, $attrs);
    }

    /**
     * Used to get watermark file
     */
    public static function watermark_file()
    {
        if (file_exists(DirPath::get('images') . 'photo_watermark.png')) {
            return DirPath::getUrl('images') . 'photo_watermark.png';
        }
        return false;
    }

    /**
     * Fetches watermark default position from database
     * @return bool|string : { position of watermark }
     */
    public static function get_watermark_position()
    {
        return config('watermark_placement');
    }

    /**
     * Used to set watermark position
     *
     * @param $image_to_mark
     * @param $watermark
     *
     * @return array
     */
    public static function position_watermark($image_to_mark, $watermark): array
    {
        $watermark_pos = self::get_watermark_position();
        if (empty($watermark_pos)) {
            $info = ['right', 'top'];
        } else {
            $info = explode(":", $watermark_pos);
        }

        $x = $info[0];
        $y = $info[1];
        [$image_to_mark_width, $image_to_mark_height] = getimagesize($image_to_mark);
        [$watermark_width, $watermark_height] = getimagesize($watermark);
        $padding = 10;

        switch ($x) {
            case 'center':
                $finalxPadding = $image_to_mark_width / 2 - $watermark_width / 2;
                break;

            case 'left':
            default:
                $finalxPadding = $padding;
                break;

            case 'right':
                $finalxPadding = $image_to_mark_width - $watermark_width - $padding;
                break;
        }

        switch ($y) {
            case 'top':
            default:
                $finalyPadding = $padding;
                break;

            case 'center':
                $finalyPadding = $image_to_mark_height / 2 - $watermark_height / 2;
                break;

            case 'bottom':
                $finalyPadding = $image_to_mark_height - $watermark_height - $padding;
                break;
        }

        return [$finalxPadding, $finalyPadding];
    }

    /**
     * Used to watermark image
     *
     * @param $input
     * @param $output
     *
     * @return bool|void
     */
    public static function watermark_image($input, $output)
    {
        $watermark_file = self::watermark_file();
        if (!$watermark_file) {
            return false;
        }

        [$Swidth, $Sheight, $Stype] = getimagesize($input);
        $watermark_image = imagecreatefrompng($watermark_file);
        $watermark_width = imagesx($watermark_image);
        $watermark_height = imagesy($watermark_image);
        $paddings = self::position_watermark($input, $watermark_file);

        switch ($Stype) {
            case 1: //GIF
                $source_image = imagecreatefromgif($input);
                imagecopy($source_image, $watermark_image, $paddings[0], $paddings[1], 0, 0, $watermark_width, $watermark_height);
                imagejpeg($source_image, $output, 90);
                break;

            case 2: //JPEG
                $source_image = imagecreatefromjpeg($input);
                imagecopy($source_image, $watermark_image, $paddings[0], $paddings[1], 0, 0, $watermark_width, $watermark_height);
                imagejpeg($source_image, $output, 90);
                break;

            case 3: //PNG
                $source_image = imagecreatefrompng($input);
                imagecopy($source_image, $watermark_image, $paddings[0], $paddings[1], 0, 0, $watermark_width, $watermark_height);
                imagepng($source_image, $input, 9);
                break;
        }
    }

    /**
     * Used to crop the image
     * Image will be crop to dead-center
     *
     * @param $input
     * @param $output
     * @param $ext
     * @param $width
     * @param $height
     *
     * @return bool|void
     */
    public static function crop_image($input, $output, $ext, $width, $height)
    {
        $info = getimagesize($input);
        $Swidth = $info[0];
        $Sheight = $info[1];

        $canvas = imagecreatetruecolor($width, $height);
        $left_padding = $Swidth / 2 - $width / 2;
        $top_padding = $Sheight / 2 - $height / 2;

        switch ($ext) {
            case 'jpeg':
            case 'jpg':
            case 'JPG':
            case 'JPEG':
                $image = imagecreatefromjpeg($input);
                imagecopy($canvas, $image, 0, 0, $left_padding, $top_padding, $width, $height);
                imagejpeg($canvas, $output, 90);
                break;

            case 'png':
            case 'PNG':
                $image = imagecreatefrompng($input);
                imagecopy($canvas, $image, 0, 0, $left_padding, $top_padding, $width, $height);
                imagepng($canvas, $output, 9);
                break;

            case 'gif':
            case 'GIF':
                $image = imagecreatefromgif($input);
                imagecopy($canvas, $image, 0, 0, $left_padding, $top_padding, $width, $height);
                imagejpeg($canvas, $output, 90);
                break;

            default:
                return false;
        }
        imagedestroy($image);
        imagedestroy($canvas);
    }
}