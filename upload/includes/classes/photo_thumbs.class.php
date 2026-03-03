<?php

class PhotoThumbs
{

    private static string $tableNameThumb = 'photo_thumb';

    private static array $resolution_setting = [
        'original' => ['size_tag' => 'original', 'should_watermark' => true],
        'large'    => ['width' => 900, 'height' => 562, 'should_watermark' => true],
        'thumb'    => ['width' => 150, 'height' => 94, 'should_watermark' => false],
        'small'    => ['width' => 300, 'height' => 188, 'should_watermark' => false],
        'medium'   => ['width' => 550, 'height' => 344, 'should_watermark' => false]
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
            $conditions[] = self::$tableNameThumb . '.photo_id = ' . (int)$param_photo_id;
        }

        if ($param_width == 'original' || $param_height == 'original') {
            $conditions[] = self::$tableNameThumb . '.is_original_size = ' . ($param_width ? 1 : 0);
        } else {
            if ($param_width) {
                $conditions[] = self::$tableNameThumb . '.width = ' .  (int)$param_width;
            }
            if ($param_height) {
                $conditions[] = self::$tableNameThumb . '.height = ' . (int)$param_height;
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
     * @param int $photo_id
     * @param int|string $width
     * @param string $return_type
     * @return array|string
     * @throws Exception
     */
    public static function getThumbFile(int $photo_id, int|string $width = 150, string $return_type = 'url'): array|string
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14') && $width != 'original') {
            $thumb_photo_directory_path = DirPath::get('thumbs') . 'photo' . DIRECTORY_SEPARATOR;
        } else {
            $thumb_photo_directory_path = DirPath::get('photos');
        }
        switch ($return_type) {
            default:
            case 'url':
                if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14') && $width != 'original') {
                    $thumb_photo_directory = DirPath::getUrl('thumbs') . 'photo' . DIRECTORY_SEPARATOR;
                } else {
                    $thumb_photo_directory = DirPath::getUrl('photos');
                }
                break;
            case 'filepath':
                $thumb_photo_directory = $thumb_photo_directory_path;
                break;
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
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
            $params_for_photo = $params;
            unset($params_for_photo['width']);
            $photo_thumb = self::getOneThumb($params_for_photo);
            if (empty($photo_thumb)) {
                return self::getDefaultMissingThumb($return_type);
            }
            $resolutions = self::getNearestResolutionThumb($photo_thumb['photo_id'], $width);
            if (empty($resolutions)) {
                return self::getDefaultMissingThumb($return_type);
            }
            $thumbs_files = self::getThumbFile($photo_id, $resolutions['width'], $return_type);
            if (!empty($thumbs_files)) {
                return $thumbs_files;
            }
        }
        $thumb_path = self::getThumbPath($thumb['file_directory'], $thumb['filename'], $thumb['width'], $thumb['ext'], $thumb['version']);
        $filepath = $thumb_photo_directory . $thumb_path;
        if (!file_exists($thumb_photo_directory_path . $thumb_path)) {
            $filepath = self::getDefaultMissingThumb($return_type);
        }
        return $filepath;
    }

    /**
     * @param $photo_file_directory
     * @param $photo_file_name
     * @param $thumb_width
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
     * @param $photo_file_name
     * @param $thumb_width
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
     * @param bool $ignore
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
        $original_photo_path = DirPath::get('photos') . $photo['file_directory'] . DIRECTORY_SEPARATOR . $photo['filename'] . '.' . $photo['ext'];
        $original_sizes = getimagesize($original_photo_path);
        if (empty($original_sizes)) {
            return;
        }
        $mime_type = self::getMimeType($original_sizes['mime']);
        if (empty($mime_type)) {
            throw new Exception(lang('remote_play_invalid_extension'));
        }
        if ( $mime_type != strtolower($photo['ext'])) {
            $temp_thumb_path = DirPath::get('photos') . $photo['file_directory'] . DIRECTORY_SEPARATOR . $photo['filename'] . '.' . $mime_type;
            rename($original_photo_path, $temp_thumb_path);
            $original_photo_path = $temp_thumb_path;
            if ( file_exists($original_photo_path)) {
                $sql = 'UPDATE ' . tbl(Photo::getInstance()->getTableName()) . ' SET ext = \'' . $mime_type . '\' WHERE photo_id = ' . (int)$photo['photo_id'];
                Clipbucket_db::getInstance()->execute($sql);
            } else {
                e(lang('error_uploading_thumb'));
                return;
            }
        }
        foreach (self::$resolution_setting as $resolution_key => $res) {
            if ($resolution_key == 'original') {
                $new_thumb_path = $original_photo_path;
            } else {
                $width = $res['width'] ;
                if ($width > $original_sizes[0]) {
                    continue;
                }
                $new_thumb_path = $thumb_photo_directory . self::getThumbPath($photo['file_directory'], $photo['filename'], $width, $mime_type, Update::getInstance()->getCurrentCoreVersion());
                PhotoThumbs::CreateThumb($original_photo_path, $new_thumb_path, $width, $mime_type, $original_sizes);
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
                    $mime_type,
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

    /**
     * @param string $original_file_path
     * @param string $destination_path
     * @param int|string $destination_width
     * @param string $extension
     * @param array $original_sizes
     * @return void
     * @throws Exception
     */
    public static function CreateThumb(string $original_file_path, string $destination_path, int|string $destination_width, string $extension, array $original_sizes): void
    {
        $org_width  = (int)($original_sizes[0] ?? 0);
        $org_height = (int)($original_sizes[1] ?? 0);

        if (empty($destination_width) || $destination_width === 'original' || $org_width <= (int)$destination_width) {
            if (!file_exists($destination_path)) {
                if (!is_dir($original_file_path)) {
                    copy($original_file_path, $destination_path);
                }
            }
            return;
        }

        $destination_width = (int)$destination_width;

        if (stristr(PHP_OS, 'WIN')) {
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

        $image_r = $image = null;
        try {
            if ($extension === 'gif') {
                FFmpeg::generateGif($original_file_path, $destination_path, $destination_width);
                return;
            }

            $ratio = $org_width / $destination_width;
            $width  = (int) round($org_width / $ratio);
            $height = (int) round($org_height / $ratio);

            $image_r = imagecreatetruecolor($width, $height);

            switch ($extension) {
                case 'jpeg':
                    $image = imagecreatefromjpeg($original_file_path);
                    imagecopyresampled($image_r, $image, 0, 0, 0, 0, $width, $height, $org_width, $org_height);
                    imagejpeg($image_r, $destination_path, 90);
                    break;

                case 'png':
                    $image = imagecreatefrompng($original_file_path);

                    if (!imageistruecolor($image)) {
                        imagepalettetotruecolor($image);
                    }

                    imagealphablending($image, false);
                    imagesavealpha($image, true);

                    imagealphablending($image_r, false);
                    imagesavealpha($image_r, true);

                    $transparent = imagecolorallocatealpha($image_r, 0, 0, 0, 127);
                    imagefilledrectangle($image_r, 0, 0, $width, $height, $transparent);

                    imagecopyresampled(
                        $image_r, $image,
                        0, 0, 0, 0,
                        $width, $height,
                        $org_width, $org_height
                    );

                    imagepng($image_r, $destination_path, 9);
                    break;

                default:
                    throw new Exception(lang('remote_play_invalid_extension'));
            }
        } catch (Exception $e) {
            e($e->getMessage());
        } finally {
            if ($image_r instanceof \GdImage || is_resource($image_r)) {
                imagedestroy($image_r);
            }
            if ($image instanceof \GdImage || is_resource($image)) {
                imagedestroy($image);
            }
        }
    }

    /**
     * @param $mime_type
     * @return string|null
     */
    public static function getMimeType($mime_type): string|null
    {
        return match ($mime_type) {
            'image/jpeg'  => 'jpeg'
            ,'image/png'  => 'png'
            ,'image/gif'  => 'gif'
            ,'image/webp' => 'webp'
            ,'image/bmp'  => 'bmp'
            ,'image/tiff' => 'tiff'
            ,default      => null
        };
    }

    /**
     * @param int $photo_id
     * @param bool $msg
     * @return void
     * @throws Exception
     */
    public static function deleteThumbs(int $photo_id, bool $msg = true): void
    {
        $thumbs = self::getAllThumbs(['photo_id' => $photo_id, 'get_photo_info'=>true]);
        foreach ($thumbs as $thumb) {
            self::deletePhotoThumb($thumb);
        }
        if ($msg) {
            e(lang('photo_delete_successfully'), 'm');
        }
    }

    /**
     * @throws Exception
     */
    public static function deletePhotoThumb(array $thumb): void
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
    public static function watermark_file(): bool|string
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

    /**
     * @param $id_photo
     * @param $requested_width
     * @return array|string[]
     * @throws Exception
     */
    public static function getNearestResolutionThumb($id_photo, $requested_width): array
    {
        if(empty($id_photo) ) {
            return [];
        }
        //search for a resolution that exists
        //the biggest resolution that is smaller than the requested one
        $sql = 'SELECT width FROM ' . tbl(self::$tableNameThumb) . ' WHERE photo_id = ' . (int)$id_photo . ' AND width < ' . (int)($requested_width).' ORDER BY width DESC LIMIT 1';
        $resolutions = Clipbucket_db::getInstance()->_select($sql);
        if (!empty($resolutions[0]) && !empty($resolutions[0]['width'])) {
            return $resolutions[0];
        }
        //if no resolution is found, return the smaller resolution that is bigger than the requested one
        $sql = 'SELECT width FROM ' . tbl(self::$tableNameThumb) . ' WHERE photo_id = ' . (int)$id_photo . ' AND width > ' . (int)($requested_width).'  ORDER BY width ASC LIMIT 1';
        $resolutions = Clipbucket_db::getInstance()->_select($sql);
        if (!empty($resolutions[0]) && !empty($resolutions[0]['width'])) {
            return $resolutions[0];
        }
        //if nothing is found return original
        return ['width' => 'original'];
    }
}