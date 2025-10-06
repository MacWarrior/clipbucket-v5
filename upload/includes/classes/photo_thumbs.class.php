<?php

class PhotoThumbs
{
    private static string $tableName = 'photo_image';

    private static string $tableNameThumb = 'photo_thumb';


    private static array $resolution_setting = [
        'original' => ['size_tag' => 'original'],
        'large'    => ['width'  => 900],
        'thumb'    => ['width'  => 150],
        'small'    => ['width'  => 300],
        'medium'   => ['width'  => 550]
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

        if ($param_photo_id) {
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
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
            $thumb_photo_directory_path = DirPath::get('thumbs') . 'photo' . DIRECTORY_SEPARATOR;
        } else {
            $thumb_photo_directory_path = DirPath::get('photos');
        }
        switch ($return_type) {
            default:
            case 'url':
                if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
                    $thumb_photo_directory = DirPath::getUrl('thumbs') . 'photo' . DIRECTORY_SEPARATOR;
                } else {
                    $thumb_photo_directory = DirPath::getUrl('photos');
                }
                break;
            case 'filepath':
                $thumb_photo_directory = $thumb_photo_directory_path;
                break;
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
            $params = [
                'photo_id'       => $photo_id,
                'width'          => $width,
            ];
            $thumb = self::getOneThumb($params);
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
        if ($thumb_version > '5.5.2') {
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
     * @param array $video
     * @param $file
     * @param $file_array_key
     * @param string $type
     * @param bool $is_auto
     * @return void
     * @throws Exception
     */
    public static function uploadThumb(array $video, $file, $file_array_key, string $type = 'thumbnail', bool $is_auto = false): void
    {
        $thumb_video_directory = DirPath::get('thumbs' ) . 'video' . DIRECTORY_SEPARATOR;
        if (!empty($file['name'])) {
            $ext_original = getExt($file['name'][$file_array_key]);
            $ext_destination = 'jpg';
            $num = self::getLastNum($video['photo_id'], $type, $is_auto) + 1;
            $temp_file_path = $thumb_video_directory . $video['file_name'] . '-' . $num . '-' . $type . '.' . $ext_destination;

            if (self::ValidateImage($file['tmp_name'][$file_array_key], $ext_original)) {
                $id_video_image = Clipbucket_db::getInstance()->insert(tbl(self::$tableName), [
                    'photo_id',
                    'type',
                    'num',
                    'is_auto'
                ], [
                    $video['photo_id'],
                    $type,
                    $num,
                    (int)$is_auto
                ]);
                foreach (self::$resolution_setting[$type] as $resolution_key => $res) {
                    if (is_uploaded_file($file['tmp_name'][$file_array_key])) {
                        move_uploaded_file($file['tmp_name'][$file_array_key], $temp_file_path);
                    } else {
                        rename($file['tmp_name'][$file_array_key], $temp_file_path);
                    }
                    if ($resolution_key == 'original') {
                        $size_tag = 'original';
                        $imageDetails = getimagesize($temp_file_path);
                        $res['width'] = $imageDetails[0] ?? '';
                        $res['height'] = $imageDetails[1] ?? '';
                    } else {
                        $size_tag = $res['width'] . 'x' . $res['height'];
                    }
                    $new_thumb_path = $thumb_video_directory . self::getThumbPath($video['file_directory'], $video['file_name'],  $res['width'], $ext_destination, Update::getInstance()->getCurrentCoreVersion());
                    PhotoThumbs::CreateThumb($temp_file_path, $new_thumb_path, $res['width'], $ext_original, $res['height'], false);
                    if (file_exists($new_thumb_path)) {
                        Clipbucket_db::getInstance()->insert(tbl(self::$tableNameThumb), [
                            'id_video_image',
                            'width',
                            'height',
                            'extension',
                            'version',
                            'is_original_size'
                        ], [
                            $id_video_image,
                            $res['width'] ?? null,
                            $res['height'] ?? null,
                            $ext_destination,
                            Update::getInstance()->getCurrentCoreVersion(),
                            (int)($resolution_key == 'original')
                        ]);
                    } else {
                        e(lang('error_uploading_thumb'));
                        return;
                    }
                }
                unlink($temp_file_path);
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
     * @param string $file
     * @param string $des
     * @param int $dim
     * @param string $ext
     * @param int|null $dim_h
     * @param bool $aspect_ratio
     * @return void
     */
    public static function CreateThumb(string $file, string $des, int $dim, string $ext, int $dim_h = null, bool $aspect_ratio = true)
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
        $thumb_path = DirPath::get('thumbs') . 'photo' . DIRECTORY_SEPARATOR . self::getThumbPath($thumb['file_directory'], $thumb['filename'], $thumb['width'], $thumb['extension'], $thumb['version']);
        if (file_exists($thumb_path)) {
            unlink($thumb_path);
        }
        Clipbucket_db::getInstance()->delete(tbl(self::$tableNameThumb), ['id_photo_thumb'],[$thumb['id_photo_thumb']]);
    }

    /**
     * @param int $id_video_thumb
     * @return void
     * @throws Exception
     */
    public static function deleteVideoThumbById(int $id_video_thumb)
    {
        $thumb = self::getOneThumb(['id_video_thumb' => $id_video_thumb,'get_video_directory'=>true, 'get_video_file_name'=>true]);
        self::deletePhotoThumb($thumb);
    }

    /**
     * @param $size
     * @return array|string[]
     */
    public static function getWidthHeightFromSize($size)
    {
        $preg_matches = [];
        preg_match_all('/(\d+)x(\d+)/', $size, $preg_matches);
        $width = isset($preg_matches[1]) ? $preg_matches[1][0] : 'original';
        $height = isset($preg_matches[2]) ? $preg_matches[2][0] : 'original';
        return [
            'width'  => $width,
            'height' => $height
        ];
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

        $attrs = ['src' => str_replace(DIRECTORY_SEPARATOR, '/', $src)];

        $attrs['id'] = (($params_html['id']) ? $params_html['id'] . '_' : 'photo_') . $photo_id;

        if (!empty($params_html['class'])) {
            $attrs['class'] = $params_html['class'];
        }

        if (!empty($params_html['align'])) {
            $attrs['align'] = $params_html['align'];
        }

        $attrs['title'] = $photo['photo_title'];

        if (isset($params_html['title']) and $params_html['title'] == '') {
            unset($attrs['title']);
        }

        $attrs['alt'] = TITLE . ' - ' . $photo['photo_title'];

        $anchor_p = [
            'place' => 'photo_thumb',
            'data'  => $photo
        ];
        $params_html['extra'] = ANCHOR($anchor_p);

        if (!empty($params_html['style'])) {
            $attrs['style'] = $params_html['style'];
        }

        if (!empty($params_html['extra'])) {
            $attrs['extra'] = $params_html['extra'];
        }

        return cb_create_html_tag('img', true, $attrs);
    }
}