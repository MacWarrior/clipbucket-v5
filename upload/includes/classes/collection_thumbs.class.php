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

    private static string $tableName = 'collection_image';

    private static array $image_resolution_setting = [
        'poster' => [
            'original' => [],
            ['width' => 90, 'height' => 140],
            ['width' => 200, 'height' => 300]
        ],
        'backdrop' => [
            'original' => [],
            ['width' => 168, 'height' => 105],
            ['width' => 416, 'height' => 260],
            ['width' => 512, 'height' => 320],
            ['width' => 768, 'height' => 480],
            ['width' => 896, 'height' => 560]
        ]
    ];

    private static array $fields = [
        'id_collection_image',
        'collection_id',
        'type',
        'num',
        'is_auto'
    ];

    private static array $fieldsThumb = [
        'id_collection_thumb',
        'id_collection_image',
        'width',
        'height',
        'extension',
        'version',
        'is_original_size'
    ];

    /**
     * Check whether the image type is enabled for the collection.
     *
     * @param array $collection
     * @param string $type
     * @return bool
     */
    public static function isTypeAllowed(array $collection, string $type): bool
    {
        if (empty($collection['collection_id'])) {
            return false;
        }
        if ($type == 'thumbnail') {
            return true;
        }
        if (!in_array($type, ['poster', 'backdrop'], true)) {
            return false;
        }
        if ($collection['type'] != 'videos') {
            return false;
        }
        return config('enable_collection_' . $type) == 'yes';
    }

    /**
     * Return the source image table name.
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return self::$tableName;
    }

    /**
     * Return the thumbnail rendition table name.
     *
     * @return string
     */
    public static function getTableNameThumb(): string
    {
        return self::$tableNameThumb;
    }

    /**
     * Get source images matching the supplied filters.
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public static function getAll(array $params): array
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $param_first_only = $params['first_only'] ?? false;
            $param_collection_id = $params['collection_id'] ?? false;
            $param_id_collection_image = $params['id_collection_image'] ?? false;
            $param_type = $params['type'] ?? false;
            $param_num = $params['num'] ?? false;
            $param_is_auto = $params['is_auto'] ?? null;

            $conditions = [];

            $select = self::getAllFields();

            if ($param_collection_id !== false) {
                $conditions[] = self::$tableName . '.collection_id = ' . (int)$param_collection_id;
            }
            if ($param_id_collection_image !== false) {
                $conditions[] = self::$tableName . '.id_collection_image = ' . (int)$param_id_collection_image;
            }
            if ($param_type !== false) {
                $conditions[] = self::$tableName . '.type = \'' . mysql_clean($param_type) . '\'';
            }
            if ($param_num !== false) {
                $conditions[] = self::$tableName . '.num = ' . (int)$param_num;
            }
            if ($param_is_auto !== null) {
                $conditions[] = self::$tableName . '.is_auto = ' . (int)$param_is_auto;
            }

            $order = ' ORDER BY ' . self::$tableName . '.num, ' . self::$tableName . '.id_collection_image';

            $sql = 'SELECT ' . implode(', ', $select) . '
                        FROM ' . cb_sql_table(self::$tableName)
                . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
                . $order;

            $result = Clipbucket_db::getInstance()->_select($sql);
            if ($param_first_only) {
                return $result[0] ?? [];
            }
            return empty($result) ? [] : $result;
        } else {
            return [];
        }
    }

    /**
     * Get the first source image matching the supplied filters.
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public static function getOne(array $params): array
    {
        $params['first_only'] = true;
        return self::getAll($params);
    }

    /**
     * Get thumbnail renditions or their count using the supplied filters.
     *
     * @param array $params
     * @return array|int|string
     * @throws Exception
     */
    public static function getAllThumbs(array $params)
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $param_first_only = $params['first_only'] ?? false;
            $param_limit = $params['limit'] ?? false;
            $param_count = $params['count'] ?? false;
            $param_collection_id = $params['collection_id'] ?? false;
            $param_id_collection_image = $params['id_collection_image'] ?? false;
            $param_type = $params['type'] ?? false;
            $param_width = $params['width'] ?? false;
            $param_height = $params['height'] ?? false;

            $conditions = [];
            $join = [];

            //SELECTS
            if (!$param_count) {
                $select = self::getAllFieldsThumbs();
                $select[] = self::$tableName . '.collection_id';
                $select[] = self::$tableName . '.type';
                $select[] = self::$tableName . '.num';
                $select[] = self::$tableName . '.is_auto';
                $select[] = self::$tableNameThumb . '.extension AS ext';
            } else {
                $select[] = 'COUNT(DISTINCT ' . self::$tableNameThumb . '.id_collection_thumb) AS count';
            }

            //CONDITIONS
            if ($param_collection_id !== false) {
                $conditions[] = self::$tableName . '.collection_id = ' . (int)$param_collection_id;
            }
            if ($param_id_collection_image !== false) {
                $conditions[] = self::$tableNameThumb . '.id_collection_image = ' . (int)$param_id_collection_image;
            }
            if ($param_type !== false) {
                $conditions[] = self::$tableName . '.type = \'' . mysql_clean($param_type) . '\'';
            }

            if ($param_width === 'original' || $param_height === 'original') {
                $conditions[] = self::$tableNameThumb . '.is_original_size = 1';
            } else {
                if ($param_width) {
                    $conditions[] = self::$tableNameThumb . '.width = ' . (int)$param_width;
                }
                if ($param_height) {
                    $conditions[] = self::$tableNameThumb . '.height = ' . (int)$param_height;
                }
                if (!empty($param_width) || !empty($param_height)) {
                    $conditions[] = self::$tableNameThumb . '.is_original_size = 0';
                }
            }

            //JOINS
            $join[] = ' INNER JOIN ' . cb_sql_table(self::$tableName) . ' ON ' . self::$tableNameThumb . '.id_collection_image = ' . self::$tableName . '.id_collection_image';

            $limit = '';
            if ($param_limit) {
                $limit = ' LIMIT ' . (int)$param_limit;
            }

            $sql = 'SELECT ' . implode(', ', $select) . '
                        FROM ' . cb_sql_table(self::$tableNameThumb)
                . implode(' ', $join)
                . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
                . $limit;

            $result = Clipbucket_db::getInstance()->_select($sql);
            if ($param_count) {
                return $result[0]['count'] ?? 0;
            }
            if ($param_first_only) {
                return $result[0] ?? [];
            }
            return empty($result) ? [] : $result;
        } else {
            if (!empty($params['count'])) {
                return 0;
            }
            return [];
        }
    }

    /**
     * Get the first thumbnail rendition matching the supplied filters.
     *
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
     * Get the qualified source image fields.
     *
     * @return array
     */
    private static function getAllFields(): array
    {
        return array_map(function ($field) {
            return self::$tableName . '.' . $field;
        }, self::$fields);
    }

    /**
     * Get the qualified thumbnail rendition fields.
     *
     * @return array
     */
    private static function getAllFieldsThumbs(): array
    {
        return array_map(function ($field) {
            return self::$tableNameThumb . '.' . $field;
        }, self::$fieldsThumb);
    }

    /**
     * Get the custom thumbnail image reference for a collection.
     *
     * @param int $collection_id
     * @return int
     * @throws Exception
     */
    public static function getDefaultImageId(int $collection_id): int
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $result = Clipbucket_db::getInstance()->_select('SELECT default_thumbnail FROM ' . tbl('collections')
                . ' WHERE collection_id = ' . $collection_id);
            return (int)($result[0]['default_thumbnail'] ?? 0);
        } else {
            return 0;
        }
    }

    /**
     * Get the referenced custom thumbnail URL or filesystem path.
     *
     * @param int $collection_id
     * @param int|string $width
     * @param string $return_type
     * @return array|string
     * @throws Exception
     */
    public static function getThumbFile(int $collection_id, int|string $width = 150, string $return_type = 'url'): array|string
    {
        $image = self::getOne([
            'collection_id' => $collection_id,
            'id_collection_image' => self::getDefaultImageId($collection_id),
            'type' => 'thumbnail'
        ]);
        if (empty($image)) {
            return '';
        }
        return self::getImageFile($image, $width, $return_type);
    }

    /**
     * Get an image rendition, falling back to its nearest resolution.
     *
     * @param array $image
     * @param int|string $width
     * @param string $return_type
     * @return string
     * @throws Exception
     */
    public static function getImageFile(array $image, int|string $width = 150, string $return_type = 'url'): string
    {
        $params = [
            'id_collection_image' => $image['id_collection_image'],
            'width'               => $width
        ];
        $thumb = self::getOneThumb($params);
        if (empty($thumb)) {
            $resolution = self::getNearestImageResolution($image['id_collection_image'], $width);
            $params['width'] = $resolution['width'];
            $thumb = self::getOneThumb($params);
        }
        if (empty($thumb)) {
            return '';
        }
        $path = self::getImagePath($thumb);
        if (!file_exists(DirPath::get('thumbs') . 'collection' . DIRECTORY_SEPARATOR . $path)) {
            return '';
        }
        if ($return_type == 'filepath') {
            return DirPath::get('thumbs') . 'collection' . DIRECTORY_SEPARATOR . $path;
        }
        return DirPath::getUrl('thumbs') . 'collection/' . str_replace(DIRECTORY_SEPARATOR, '/', $path);
    }

    /**
     * Build a rendition path relative to the collection thumbnail directory.
     *
     * @param array $thumb
     * @return string
     */
    private static function getImagePath(array $thumb): string
    {
        return $thumb['collection_id'] . DIRECTORY_SEPARATOR . $thumb['type'] . DIRECTORY_SEPARATOR
            . $thumb['id_collection_image'] . DIRECTORY_SEPARATOR
            . self::getThumbName($thumb['id_collection_image'], $thumb['is_original_size'] ? 'original' : $thumb['width'], $thumb['extension']);
    }

    /**
     * Build a legacy collection thumbnail path.
     *
     * @param int|string $collection_collection_id
     * @param int|string $thumb_width
     * @param string $thumb_extension
     * @return string
     */
    public static function getThumbPath($collection_collection_id, $thumb_width, $thumb_extension): string
    {
        return $collection_collection_id . DIRECTORY_SEPARATOR . self::getThumbName($collection_collection_id, $thumb_width, $thumb_extension);
    }

    /**
     * Build a thumbnail filename for the requested rendition.
     *
     * @param int|string $collection_file_name
     * @param int|string $thumb_width
     * @param string $thumb_extension
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
     * Select a custom thumbnail belonging to the collection.
     *
     * @param int $collection_id
     * @param int $id_collection_image
     * @return void
     * @throws Exception
     */
    public static function setDefaultImage(int $collection_id, int $id_collection_image): void
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $image = self::getOne([
                'collection_id'       => $collection_id,
                'id_collection_image' => $id_collection_image,
                'type'                => 'thumbnail'
            ]);
            if (empty($image) || self::getImageFile($image) == '') {
                throw new Exception(lang('technical_error'));
            }
            Clipbucket_db::getInstance()->update(tbl('collections'), ['default_thumbnail', 'thumb_objectid'],
                [$id_collection_image, -1], 'collection_id = ' . $collection_id);
        } else {
            return;
        }
    }

    /**
     * Import a custom thumbnail and select it as the default.
     *
     * @param array $collection
     * @param array $file
     * @param bool|int $ignore Retained for compatibility with existing callers.
     * @return void
     * @throws Exception
     */
    public static function uploadThumb(array $collection, $file, $ignore = false): void
    {
        $id_collection_image = self::importImage($collection, $file);
        if ($id_collection_image) {
            self::setDefaultImage($collection['collection_id'], $id_collection_image);
        }
    }

    /**
     * Import a custom image and its renditions, cleaning up failed imports.
     *
     * @param array $collection
     * @param array $file
     * @param string $type
     * @return int Image identifier, or zero if the import failed.
     * @throws Exception
     */
    public static function importImage(array $collection, array $file, string $type = 'thumbnail'): int
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            if (!self::isTypeAllowed($collection, $type)) {
                e(lang('technical_error'));
                return 0;
            }
            if (($file['error'] ?? UPLOAD_ERR_OK) != UPLOAD_ERR_OK || empty($file['tmp_name'])
                || !is_file($file['tmp_name']) || !Photo::ValidateImage($file['tmp_name'])) {
                e(lang('error_uploading_thumb'));
                return 0;
            }
            $temp_file_path = tempnam(DirPath::get('temp'), 'collection_');
            $id_collection_image = 0;
            $paths = [];
            try {
                if (!$temp_file_path || !copy($file['tmp_name'], $temp_file_path)) {
                    throw new Exception(lang('error_uploading_thumb'));
                }
                $imageDetails = getimagesize($temp_file_path);
                $ext_original = strtolower(image_type_to_extension($imageDetails[2], false));
                $ext_destination = strtolower((string)config('video_thumbs_format'));
                if (!in_array($ext_destination, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    throw new Exception(lang('error_uploading_thumb'));
                }
                if ($type != 'thumbnail' && $ext_original == 'webp') {
                    self::convertImage($temp_file_path, 'png');
                    $ext_original = 'png';
                }
                $last = Clipbucket_db::getInstance()->_select('SELECT MAX(num) AS num FROM ' . tbl(self::$tableName)
                    . ' WHERE collection_id = ' . (int)$collection['collection_id'] . " AND type = '" . mysql_clean($type) . "' AND is_auto = 0");
                $id_collection_image = (int)Clipbucket_db::getInstance()->insert(tbl(self::$tableName), [
                    'collection_id',
                    'type',
                    'num',
                    'is_auto'
                ], [
                    $collection['collection_id'],
                    $type,
                    (int)($last[0]['num'] ?? 0) + 1,
                    0
                ]);
                if (!$id_collection_image) {
                    throw new Exception(lang('error_uploading_thumb'));
                }
                $settings = $type == 'thumbnail' ? self::$resolution_setting : self::$image_resolution_setting[$type];
                foreach ($settings as $key => $res) {
                    $original = $key === 'original';
                    $thumb = [
                        'collection_id' => $collection['collection_id'],
                        'id_collection_image' => $id_collection_image,
                        'type' => $type,
                        'width' => $original ? $imageDetails[0] : $res['width'],
                        'height' => $original ? $imageDetails[1] : $res['height'],
                        'extension' => $ext_destination,
                        'is_original_size' => (int)$original
                    ];
                    $path = DirPath::get('thumbs') . 'collection' . DIRECTORY_SEPARATOR . self::getImagePath($thumb);
                    $paths[] = $path;
                    if (!is_dir(dirname($path)) && !mkdir(dirname($path), 0755, true)) {
                        throw new Exception(lang('error_uploading_thumb'));
                    }
                    if ($type == 'thumbnail') {
                        self::CreateThumb($temp_file_path, $path, $original ? 'original' : $res['width'], $ext_destination, $imageDetails);
                    } else {
                        VideoThumbs::CreateThumb($temp_file_path, $path, $thumb['width'], $ext_original, $thumb['height'], false);
                    }
                    if (!is_file($path) || !getimagesize($path)) {
                        throw new Exception(lang('error_uploading_thumb'));
                    }
                    self::convertImage($path, $ext_destination);
                    if (!empty($res['should_watermark']) && config('watermark_collection')) {
                        self::watermark_image($path, $path);
                    }
                    // Width/height identify the configured rendition, including for small sources.
                    $id_thumb = Clipbucket_db::getInstance()->insert(tbl(self::$tableNameThumb), [
                        'id_collection_image',
                        'width',
                        'height',
                        'extension',
                        'version',
                        'is_original_size'
                    ], [
                        $id_collection_image,
                        $thumb['width'],
                        $thumb['height'],
                        $ext_destination,
                        Update::getInstance()->getCurrentCoreVersion(),
                        (int)$original
                    ]);
                    if (!$id_thumb) {
                        throw new Exception(lang('error_uploading_thumb'));
                    }
                }
                return $id_collection_image;
            } catch (Throwable $exception) {
                foreach ($paths as $path) {
                    if (is_file($path)) {
                        unlink($path);
                    }
                }
                if ($id_collection_image) {
                    self::deleteCollectionImage(['id_collection_image' => $id_collection_image, 'collection_id' => $collection['collection_id']]);
                }
                e(lang('error_uploading_thumb'));
                return 0;
            } finally {
                if ($temp_file_path && is_file($temp_file_path)) {
                    unlink($temp_file_path);
                }
            }
        } else {
            return 0;
        }
    }

    /**
     * Convert an image in place to the requested output format.
     *
     * @param string $path
     * @param string $extension
     * @return void
     * @throws Exception
     */
    private static function convertImage(string $path, string $extension): void
    {
        $info = getimagesize($path);
        $current_extension = image_type_to_extension($info[2], false);
        if ($current_extension == $extension || ($current_extension == 'jpeg' && $extension == 'jpg')) {
            return;
        }
        $image = imagecreatefromstring(file_get_contents($path));
        if (!$image) {
            throw new Exception(lang('error_uploading_thumb'));
        }
        try {
            imagepalettetotruecolor($image);
            imagesavealpha($image, true);
            $saved = match ($extension) {
                'jpg', 'jpeg' => imagejpeg($image, $path, 90),
                'png' => imagepng($image, $path, 9),
                'webp' => imagewebp($image, $path, 90),
                default => false
            };
            if (!$saved) {
                throw new Exception(lang('error_uploading_thumb'));
            }
        } finally {
            imagedestroy($image);
        }
    }

    /**
     * Estimate the memory required to process an image.
     *
     * @param string $filename
     * @return float|false
     */
    public static function getMemoryNeededForImage($filename): float|bool
    {
        if (!file_exists($filename)) {
            return false;
        }

        $imageInfo = getimagesize($filename);
        $current_memory_usage = memory_get_usage();
        return round(($imageInfo[0] * $imageInfo[1]
                * ($imageInfo['bits'] ?? 8)
                * (($imageInfo['channels'] ?? 4) / 8)
            ) * 1.5 + $current_memory_usage
        );
    }

    /**
     * Create a thumbnail while preserving the source aspect ratio.
     *
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
            if ($memory_limit != '-1' && $memory_needed > getBytesFromFileSize($memory_limit)) {
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
     * Delete all custom images and renditions belonging to a collection.
     *
     * @param int $collection_id
     * @param bool $msg
     * @return void
     * @throws Exception
     */
    public static function deleteThumbs(int $collection_id, bool $msg = true): void
    {
        foreach (self::getAll(['collection_id' => $collection_id]) as $image) {
            self::deleteCollectionImage($image);
        }
        if ($msg) {
            e(lang('collection_delete_successfully'), 'm');
        }
    }

    /**
     * Delete an image and its renditions, resetting its active default reference.
     *
     * @param array $image
     * @return void
     * @throws Exception
     */
    public static function deleteCollectionImage(array $image): void
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $image = self::getOne([
                'id_collection_image' => $image['id_collection_image'],
                'collection_id'       => $image['collection_id']
            ]);
            if (empty($image)) {
                return;
            }
            Clipbucket_db::getInstance()->update(tbl('collections'), ['default_thumbnail', 'thumb_objectid'],
                ['|f|NULL', '|f|NULL'], 'collection_id = ' . (int)$image['collection_id']
                . ' AND default_thumbnail = ' . (int)$image['id_collection_image'] . ' AND thumb_objectid = -1');
            foreach (self::getAllThumbs(['id_collection_image' => $image['id_collection_image']]) as $thumb) {
                self::deleteCollectionThumb($thumb);
            }
            Clipbucket_db::getInstance()->delete(tbl(self::$tableName), ['id_collection_image'], [$image['id_collection_image']]);
        } else {
            return;
        }
    }

    /**
     * Delete a thumbnail rendition and its file.
     *
     * @param array $thumb
     * @return void
     * @throws Exception
     */
    public static function deleteCollectionThumb(array $thumb): void
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
            $path = DirPath::get('thumbs') . 'collection' . DIRECTORY_SEPARATOR . self::getImagePath($thumb);
            if (is_file($path) && !unlink($path)) {
                throw new Exception(lang('technical_error'));
            }
            Clipbucket_db::getInstance()->delete(tbl(self::$tableNameThumb), ['id_collection_thumb'], [$thumb['id_collection_thumb']]);
        } else {
            return;
        }
    }

    /**
     * Build the HTML image tag for a custom collection thumbnail.
     *
     * @param int $collection_id
     * @param int|string $width
     * @param array $params_html
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
     * Get the collection watermark URL when the file exists.
     *
     * @return bool|string
     */
    public static function watermark_file(): bool|string
    {
        if (file_exists(DirPath::get('images') . 'collection_watermark.png')) {
            return DirPath::getUrl('images') . 'collection_watermark.png';
        }
        return false;
    }

    /**
     * Get the configured watermark position.
     *
     * @return bool|string
     */
    public static function get_watermark_position()
    {
        return config('watermark_placement');
    }

    /**
     * Calculate the watermark coordinates within an image.
     *
     * @param string $image_to_mark
     * @param string $watermark
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
     * Apply the collection watermark to an image.
     *
     * @param string $input
     * @param string $output
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

            case IMAGETYPE_WEBP:
                $source_image = imagecreatefromwebp($input);
                imagecopy($source_image, $watermark_image, $paddings[0], $paddings[1], 0, 0, $watermark_width, $watermark_height);
                imagewebp($source_image, $output, 90);
                break;

            case 3: //PNG
                $source_image = imagecreatefrompng($input);
                imagecopy($source_image, $watermark_image, $paddings[0], $paddings[1], 0, 0, $watermark_width, $watermark_height);
                imagepng($source_image, $input, 9);
                break;
        }
    }

    /**
     * Crop an image around its center to the requested dimensions.
     *
     * @param string $input
     * @param string $output
     * @param string $ext
     * @param int $width
     * @param int $height
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
     * Get the nearest rendition of the referenced custom thumbnail.
     *
     * @param int $id_collection
     * @param int|string $requested_width
     * @return array
     * @throws Exception
     */
    public static function getNearestResolutionThumb($id_collection, $requested_width): array
    {
        return self::getNearestImageResolution(self::getDefaultImageId((int)$id_collection), $requested_width);
    }

    /**
     * Get the nearest configured rendition within a single source image.
     *
     * @param int $id_collection_image
     * @param int|string $requested_width
     * @return array
     * @throws Exception
     */
    private static function getNearestImageResolution(int $id_collection_image, int|string $requested_width): array
    {
        $thumbs = self::getAllThumbs(['id_collection_image' => $id_collection_image]);
        $smaller = null;
        $larger = null;
        foreach ($thumbs as $thumb) {
            if ($thumb['is_original_size']) {
                continue;
            }
            if ($thumb['width'] <= (int)$requested_width && (!$smaller || $thumb['width'] > $smaller)) {
                $smaller = $thumb['width'];
            }
            if ($thumb['width'] > (int)$requested_width && (!$larger || $thumb['width'] < $larger)) {
                $larger = $thumb['width'];
            }
        }
        return ['width' => $smaller ?? $larger ?? 'original'];
    }
}
