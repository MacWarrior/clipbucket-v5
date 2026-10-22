<?php

class CollectionThumbs
{

    private static string $tableNameThumb = 'collection_thumb';

    private static array $resolution_setting = [
        'original' => ['size_tag' => 'original', 'should_watermark' => true],
        'large'    => ['width' => 900, 'height' => 562, 'should_watermark' => true],
        'thumb'    => ['width' => 150, 'height' => 94, 'should_watermark' => false],
        'small'    => ['width' => 300, 'height' => 188, 'should_watermark' => false],
        'medium'   => ['width' => 550, 'height' => 344, 'should_watermark' => false]
    ];

    private static array $fieldsThumb = [
        'id_collection_thumb',
        'collection_id',
        'width',
        'extension',
        'version',
        'is_original_size'
    ];

    /**
     * @throws Exception
     */
    public static function getAllThumbs(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_collection_id = $params['collection_id'] ?? false;
        $param_width = $params['width'] ?? false;
        $param_height = $params['height'] ?? false;
        $param_get_collection_info = $params['get_collection_info'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        if (!$param_count) {
            $select = self::getAllFieldsThumbs();
            if ($param_get_collection_info) {
                $select[] = Collection::getInstance()->getTableName() . '.collection_id ';
                $select[] = Collection::getInstance()->getTableName() . '.collection_name ';
                $select[] = self::$tableNameThumb . '.extension AS ext ';
            }
        } else {
            $select[] = 'COUNT(DISTINCT ' . self::$tableNameThumb . '.id_collection_thumb) AS count';
        }

        if ($param_collection_id !== false) {
            $conditions[] = self::$tableNameThumb . '.collection_id = ' . (int)$param_collection_id;
        }

        if ($param_width == 'original' || $param_height == 'original') {
            $conditions[] = self::$tableNameThumb . '.is_original_size = ' . ($param_width ? 1 : 0);
        } else {
            if ($param_width) {
                $conditions[] = self::$tableNameThumb . '.width = ' . (int)$param_width;
            }
            if ($param_height) {
                $conditions[] = self::$tableNameThumb . '.height = ' . (int)$param_height;
            }
        }

        $join[] = ' LEFT JOIN ' . cb_sql_table(Collection::getInstance()->getTableName()) . ' ON ' . Collection::getInstance()->getTableName() . '.collection_id = ' . self::$tableNameThumb . '.collection_id';

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
     * @param int $collection_id
     * @param int|string $width
     * @param string $return_type
     * @return array|string
     * @throws Exception
     */
    public static function getThumbFile(int $collection_id, int|string $width = 150, string $return_type = 'url'): array|string
    {
        $thumb_collection_directory_path = DirPath::get('thumbs') . 'collection' . DIRECTORY_SEPARATOR;
        switch ($return_type) {
            default:
            case 'url':
                $thumb_collection_directory = DirPath::getUrl('thumbs') . 'collection' . DIRECTORY_SEPARATOR;
                break;

            case 'filepath':
                $thumb_collection_directory = $thumb_collection_directory_path;
                break;
        }

        $params = [
            'collection_id'       => $collection_id,
            'width'               => $width,
            'get_collection_info' => true
        ];
        $thumb = self::getOneThumb($params);
        if (!empty($thumb['is_original_size'])) {
            $thumb['width'] = 'original';
        }
        if (empty($thumb)) {
            $params_for_collection = $params;
            unset($params_for_collection['width']);
            $collection_thumb = self::getOneThumb($params_for_collection);
            if (empty($collection_thumb)) {
                return false;
            }
            $resolutions = self::getNearestResolutionThumb($collection_thumb['collection_id'], $width);
            if (empty($resolutions)) {
                return false;
            }
            $thumbs_files = self::getThumbFile($collection_id, $resolutions['width'], $return_type);
            if (!empty($thumbs_files)) {
                return $thumbs_files;
            }
        }
        $thumb_path = self::getThumbPath($thumb['collection_id'], $thumb['width'], $thumb['ext']);
        $filepath = $thumb_collection_directory . $thumb_path;
        if (!file_exists($thumb_collection_directory_path . $thumb_path)) {
            $filepath = false;
        }
        return $filepath;
    }

    /**
     * @param $collection_collection_id
     * @param $thumb_width
     * @param $thumb_extension
     * @return string
     */
    public static function getThumbPath($collection_collection_id, $thumb_width, $thumb_extension): string
    {
        $filepath = $collection_collection_id . DIRECTORY_SEPARATOR;
        return $filepath . self::getThumbName($collection_collection_id, $thumb_width, $thumb_extension);
    }

    /**
     * @param $collection_file_name
     * @param $thumb_width
     * @param $thumb_extension
     * @return string
     */
    public static function getThumbName($collection_file_name, $thumb_width, $thumb_extension): string
    {
        if ($thumb_width == 'original') {
            return $collection_file_name . '.' . $thumb_extension;
        }
        return $collection_file_name . '-' . $thumb_width . '.' . $thumb_extension;
    }

    /**
     * @param array $collection
     * @param $file
     * @param $ignore
     * @return void
     * @throws Exception
     */
    public static function uploadThumb(array $collection, $file, $ignore = false): void
    {
        if (empty($collection['collection_id'])) {
            return;
        }

        $temp_directory = DirPath::get('temp');
        $thumb_collection_directory = DirPath::get('thumbs') . 'collection' . DIRECTORY_SEPARATOR;
        if (!file_exists($thumb_collection_directory . $collection['collection_id'] . DIRECTORY_SEPARATOR)) {
            mkdir($thumb_collection_directory . $collection['collection_id'] . DIRECTORY_SEPARATOR, 0755, true);
        }
        if (!empty($file['name'])) {
            $ext_original = getExt($file['name']);
            $ext_destination = strtolower((string)config('video_thumbs_format'));
            $temp_file_path = $temp_directory . $collection['collection_id'] . '.' . $ext_destination;
            foreach (self::$resolution_setting as $resolution_key => $res) {
                if (is_uploaded_file($file['tmp_name'])) {
                    move_uploaded_file($file['tmp_name'], $temp_file_path);
                } else {
                    rename($file['tmp_name'], $temp_file_path);
                }
                $imageDetails = getimagesize($temp_file_path);
                if ($resolution_key == 'original') {
                    $size_tag = 'original';
                    $res['width'] = $imageDetails[0] ?? '';
                    $res['height'] = $imageDetails[1] ?? '';
                } else {
                    $size_tag = $res['width'];
                }
                $new_thumb_path = $thumb_collection_directory . self::getThumbPath($collection['collection_id'], $size_tag, $ext_destination);
                if (!file_exists(dirname($new_thumb_path))) {
                    //needed if upload on old version
                    mkdir(dirname($new_thumb_path), 0755, true);
                }
                CollectionThumbs::CreateThumb($temp_file_path, $new_thumb_path, $size_tag, $ext_original, $imageDetails);
                if (file_exists($new_thumb_path)) {
                    //watermark

                    if ($res['should_watermark'] && config('watermark_collection')) {
                        self::watermark_image($new_thumb_path, $new_thumb_path);
                    }
                    Clipbucket_db::getInstance()->insert(tbl(self::$tableNameThumb), [
                        'collection_id',
                        'width',
                        'extension',
                        'version',
                        'is_original_size'
                    ], [
                        $collection['collection_id'],
                        $res['width'] ?? 0,
                        $ext_destination,
                        Update::getInstance()->getCurrentCoreVersion(),
                        (int)($resolution_key == 'original')
                    ], ignore: $ignore);
                } else {
                    e(lang('error_uploading_thumb'));
                    return;
                }
            }
        }
    }

    /**
     * @param $filename
     * @return false|float
     */
    public static function getMemoryNeededForImage($filename): float|bool
    {
        if (!file_exists($filename)) {
            return false;
        }

        $imageInfo = getimagesize($filename);
        $current_memory_usage = memory_get_usage();
        return round(($imageInfo[0] * $imageInfo[1]
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
        $org_width = (int)($original_sizes[0] ?? 0);
        $org_height = (int)($original_sizes[1] ?? 0);

        if (empty($destination_width) || $destination_width === 'original' || $org_width <= (int)$destination_width) {
            copy($original_file_path, $destination_path);
            return;
        }

        $destination_width = (int)$destination_width;

        if (stristr(PHP_OS, 'WIN')) {
            // On Windows hosts, imagecreatefromX functions consumes lots of RAM
            $memory_needed = CollectionThumbs::getMemoryNeededForImage($original_file_path);
            $memory_limit = ini_get('memory_limit');
            if ($memory_needed > getBytesFromFileSize($memory_limit)) {
                $msg = 'Collection generation would requiere ~' . System::get_readable_filesize($memory_needed, 0) . ' of memory, but it\'s currently limited to ' . $memory_limit;
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

            $data = file_get_contents($original_file_path);
            if ($data === false) {
                throw new Exception(lang('technical_error'));
            }

            $image = imagecreatefromstring($data);
            if ($image === false) {
                throw new Exception(lang('remote_play_invalid_extension'));
            }

            if (!imageistruecolor($image)) {
                imagepalettetotruecolor($image);
            }

            $ratio = $org_width / $destination_width;
            $width = (int)round($org_width / $ratio);
            $height = (int)round($org_height / $ratio);

            $image_r = imagecreatetruecolor($width, $height);

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

            switch ($extension) {
                case 'jpeg':
                case 'jpg':
                    imagejpeg($image_r, $destination_path, 90);
                    break;

                case 'png':
                    imagepng($image_r, $destination_path, 9);
                    break;

                case 'webp':
                    imagewebp($image_r, $destination_path, 90);
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
     * @param int $collection_id
     * @param bool $msg
     * @return void
     * @throws Exception
     */
    public static function deleteThumbs(int $collection_id, bool $msg = true): void
    {
        $thumbs = self::getAllThumbs(['collection_id' => $collection_id, 'get_collection_info' => true]);
        foreach ($thumbs as $thumb) {
            self::deleteCollectionThumb($thumb);
        }
        if ($msg) {
            e(lang('collection_delete_successfully'), 'm');
        }
    }

    /**
     * @throws Exception
     */
    public static function deleteCollectionThumb(array $thumb): void
    {
        $thumb_path = DirPath::get('thumbs') . 'collection' . DIRECTORY_SEPARATOR . self::getThumbPath($thumb['collection_id'], ($thumb['is_original_size'] ? 'original' : $thumb['width']), $thumb['extension']);
        if (file_exists($thumb_path)) {
            unlink($thumb_path);
        }
        Clipbucket_db::getInstance()->delete(tbl(self::$tableNameThumb), ['id_collection_thumb'], [$thumb['id_collection_thumb']]);
    }

    /**
     * @param int $collection_id
     * @param int|string $width
     * @param $params_html
     * @return string
     * @throws Exception
     */
    public static function getHtmlThumbFile(int $collection_id, int|string $width, $params_html = []): string
    {
        $collection = Collection::getInstance()->getOne(['collection_id' => $collection_id]);
        $src = self::getThumbFile($collection_id, $width);

        $anchor_p = [
            'place' => 'collection_thumb',
            'data'  => $collection
        ];
        $attrs = [
            'src'   => str_replace(DIRECTORY_SEPARATOR, '/', $src),
            'id'    => (($params_html['id']) ? $params_html['id'] . '_' : 'collection_') . $collection_id,
            'html'  => $collection['collection_title'],
            'alt'   => TITLE . ' - ' . $collection['collection_title'],
            'extra' => ANCHOR($anchor_p)
        ];

        if (!empty($params_html['class'])) {
            $attrs['class'] = $params_html['class'];
        }

        if (!empty($params_html['crop']) && config('keep_ratio_collection') == 'yes') {
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
        if (file_exists(DirPath::get('images') . 'collection_watermark.png')) {
            return DirPath::getUrl('images') . 'collection_watermark.png';
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
     * @param $id_collection
     * @param $requested_width
     * @return array|string[]
     * @throws Exception
     */
    public static function getNearestResolutionThumb($id_collection, $requested_width): array
    {
        if (empty($id_collection)) {
            return [];
        }
        //search for a resolution that exists
        //the biggest resolution that is smaller than the requested one
        $sql = 'SELECT width FROM ' . tbl(self::$tableNameThumb) . ' WHERE collection_id = ' . (int)$id_collection . ' AND width < ' . (int)($requested_width) . ' ORDER BY width DESC LIMIT 1';
        $resolutions = Clipbucket_db::getInstance()->_select($sql);
        if (!empty($resolutions[0]) && !empty($resolutions[0]['width'])) {
            return $resolutions[0];
        }
        //if no resolution is found, return the smaller resolution that is bigger than the requested one
        $sql = 'SELECT width FROM ' . tbl(self::$tableNameThumb) . ' WHERE collection_id = ' . (int)$id_collection . ' AND width > ' . (int)($requested_width) . '  ORDER BY width ASC LIMIT 1';
        $resolutions = Clipbucket_db::getInstance()->_select($sql);
        if (!empty($resolutions[0]) && !empty($resolutions[0]['width'])) {
            return $resolutions[0];
        }
        //if nothing is found return original
        return ['width' => 'original'];
    }
}