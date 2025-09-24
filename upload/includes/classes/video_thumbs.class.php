<?php

class VideoThumbs
{
    private static $tableName = 'video_image';

    private static string $tableNameThumb = 'video_thumb';

    private FFMpeg $ffmpeg_instance;
    private array $video;

    private int $last_thumb_num = 0;

    private string $thumb_dir = '';

    private static array $resolution_setting = [
        'original' => ['size_tag' => 'original'],
        '105'      => ['width'  => '168', 'height' => '105'],
        '260'      => ['width'  => '416', 'height' => '260'],
        '320'      => ['width'  => '632', 'height' => '395'],
        '480'      => ['width'  => '768', 'height' => '432']
    ];

    private static array $fields = [
        'id_video_image',
        'videoid',
        'type',
        'num'
    ];

    private static array $fieldsThumb = [
        'id_video_thumb',
        'id_video_image',
        'width',
        'height',
        'extension',
        'version',
        'is_original_size'
    ];

    /**
     * @param array $params
     * @return array|int|mixed
     * @throws Exception
     */
    public static function getAll(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_videoid = $params['videoid'] ?? false;
        $param_type = $params['type'] ?? false;
        $param_max_num = $params['max_num'] ?? false;
        $param_default = $params['default'] ?? false;
        $param_is_auto = $params['is_auto'] ?? null;
        $param_id_video_image = $params['id_video_image'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        if ($param_videoid) {
            $conditions[] = self::$tableName . '.videoid = ' . mysql_clean($param_videoid);
        }
        if ($param_type) {
            $conditions[] = self::$tableName .'.type = \'' . mysql_clean($param_type) . '\'';
        }
        if ($param_id_video_image) {
            $conditions[] = self::$tableName .'.id_video_image = \'' . mysql_clean($param_id_video_image) . '\'';
        }

        if ($param_is_auto!=null) {
            $conditions[] = self::$tableName . '.is_auto = ' . mysql_clean($param_is_auto);
        }
        if ($param_default) {
            $conditions[] = Video::getInstance()->getTableName() . '.default_'. $param_default .' = ' . self::$tableName .'.id_video_image';
            $join[] = ' LEFT JOIN ' . cb_sql_table(Video::getInstance()->getTableName()) . ' ON ' . Video::getInstance()->getTableName() . '.videoid = ' . self::$tableName . '.videoid';
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }
        $order = '';
        if ($param_order) {
            $order = ' ORDER BY  ' . $param_order;
        }

        if ($param_count) {
            $select[] = 'COUNT(DISTINCT ' . self::$tableName . '.id_video_image) AS count';
        } elseif ($param_max_num) {
            $select[] = 'MAX(num) AS max_num';
            $group[] = self::$tableName . '.videoid';
        } else {
            $select = self::getAllFields();
        }

        $sql = 'SELECT ' . implode(', ', $select) . '
                    FROM ' . cb_sql_table(self::$tableName)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(', ', $group))
            . $order
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($param_first_only) {
            return $result[0] ?? [];
        }
        if ($param_count) {
            return $result[0]['count'] ?? 0;
        }
        return empty($result) ? [] : $result;
    }

    /**
     * @param array $params
     * @return array
     * @throws Exception
     */
    public static function getOne(array $params): array
    {
        $params['first_only'] = true;
        return self::getAll($params);
    }

    public static function getAllThumbs(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_id_video_image = $params['id_video_image'] ?? false;
        $param_type = $params['type'] ?? false;
        $param_get_num = $params['get_num'] ?? false;
        $param_get_is_auto = $params['get_is_auto'] ?? false;
        $param_video_id = $params['videoid'] ?? false;
        $param_width = $params['width'] ?? false;
        $param_height = $params['height'] ?? false;
        $param_is_auto = $params['is_auto'] ?? null;
        $param_default = $params['default'] ?? null;
        $param_get_is_default = $params['get_is_default'] ?? null;
        $param_get_video_directory = $params['get_video_directory'] ?? false;
        $param_get_video_file_name = $params['get_video_file_name'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        if (!$param_count) {
            $select = self::getAllFieldsThumbs();
            if ($param_get_num) {
                $select[] = self::$tableName.'.num';
            }
            if ($param_get_is_auto) {
                $select[] = self::$tableName.'.is_auto';
            }
            if ($param_get_is_default) {
                $select[] = self::$tableNameThumb . '.id_video_image = ' . self::$tableName . '.id_video_image AS is_default';
            }
            if ($param_get_video_directory) {
                $select[] = Video::getInstance()->getTableName() . '.file_directory';
            }
            if ($param_get_video_file_name) {
                $select[] = Video::getInstance()->getTableName() . '.file_name';
            }
        } else {
            $select[] = 'COUNT(DISTINCT ' . self::$tableNameThumb . '.id_video_image) AS count';
        }

        if ($param_id_video_image) {
            $conditions[] = self::$tableNameThumb . '.id_video_image = ' . mysql_clean($param_id_video_image);
        }
        if ($param_video_id) {
            $conditions[] = self::$tableName . '.videoid = ' . mysql_clean($param_video_id);
        }
        if ($param_type) {
            $conditions[] = self::$tableName . '.type = \'' . mysql_clean($param_type) . '\'';
            $select[] = self::$tableName . '.type';
        }

        if ($param_width == 'original' || $param_height == 'original') {
            $conditions[] = self::$tableNameThumb . '.is_original_size = ' . (mysql_clean($param_width) ? 1 : 0);
        } else {
            if ($param_width) {
                $conditions[] = self::$tableNameThumb . '.width = ' . $param_width !='original' ? mysql_clean($param_width) : '';
            }
            if ($param_height) {
                $conditions[] = self::$tableNameThumb . '.height = ' . mysql_clean($param_height);
            }
        }

        if ($param_is_auto !== null) {
            $conditions[] = self::$tableName . '.is_auto = ' .( mysql_clean($param_is_auto) ? : 'false');
        }
        if ($param_default !== null) {
            $conditions[] = Video::getInstance()->getTableName() . '.default_'. $param_default .' = ' . self::$tableName .'.id_video_image';
        }

        if ($param_type || $param_get_num || $param_video_id || $param_is_auto || $param_get_is_auto || $param_default || $param_get_is_default || $param_get_video_directory || $param_get_video_file_name) {
            $join[] = ' LEFT JOIN ' . cb_sql_table(self::$tableName) . ' ON ' . self::$tableNameThumb . '.id_video_image = ' . self::$tableName . '.id_video_image';
        }

        if ($param_default || $param_get_is_default || $param_get_video_directory || $param_get_video_file_name) {
            $join[] = ' LEFT JOIN ' . cb_sql_table(Video::getInstance()->getTableName()) . ' ON ' . Video::getInstance()->getTableName() . '.videoid = ' . self::$tableName . '.videoid';
        }

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
    private static function getAllFields(): array
    {
        return array_map(function ($field) {
            return self::$tableName . '.' . $field;
        }, self::$fields);
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

    /**
     * @param $videoid
     * @return int
     * @throws Exception
     */
    public static function getMaxNumThumb($videoid): int
    {
        return (self::getOne([
            'videoid' => $videoid,
            'max_num' => true
        ])['max_num'] ?? 0);
    }

    /**
     * @param int $videoid
     * @param FFMpeg|null $ffmpeg_instance
     * @throws Exception
     */
    public function __construct(int $videoid, FFMpeg $ffmpeg_instance = null)
    {
        $this->video = Video::getInstance()->getOne([
            'videoid'                     => $videoid,
            'disable_generic_constraints' => true
        ]);
        if (empty($ffmpeg_instance)) {
            $this->init_FFMPEG();
        } else {
            $this->ffmpeg_instance = $ffmpeg_instance;
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function init_FFMPEG(): void
    {
        $logFile = DirPath::get('logs') . $this->video['file_directory'] . DIRECTORY_SEPARATOR . $this->video['file_name'] . '.log';
        $log = new SLog($logFile);
        $this->ffmpeg_instance = new FFMpeg($log);
        $vid_file = get_high_res_file($this->video);
        $this->ffmpeg_instance->input_details['duration'] = $this->video['duration'];
        $this->ffmpeg_instance->input_file = $vid_file;
        $this->ffmpeg_instance->file_directory = $this->video['file_directory'] . DIRECTORY_SEPARATOR;
        $this->ffmpeg_instance->file_name = $this->video['file_name'];
    }

    private static function getLastNum(int $videoid, string $type, bool $is_auto = false): int
    {
        $res = Clipbucket_db::getInstance()->_select('SELECT MAX(num) as num FROM ' . tbl('video_image') . ' WHERE videoid = ' . mysql_clean($videoid) . ' AND type = \'' . mysql_clean($type) . '\' AND is_auto = ' . (mysql_clean($is_auto) ? 1 : 0));
        return $res[0]['num'] ?? 0;
    }

    public static function getTableNameThumb(): string
    {
        return self::$tableNameThumb;
    }

    public static function getTableName(): string
    {
        return self::$tableName;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function generateAutomaticThumbs(): void
    {
        $this->ffmpeg_instance->log->newSection('Generating thumbnails');
        $this->removeGeneratedThumbs();
        $duration = (int)$this->ffmpeg_instance->input_details['duration'];
        $max_num = (config('num_thumbs') ?: 1);
        if ($max_num > $duration) {
            $max_num = $duration;
        }
        $this->thumb_dir = DirPath::get('thumbs') . 'video' . DIRECTORY_SEPARATOR . $this->ffmpeg_instance->file_directory . $this->ffmpeg_instance->file_name ;
        if (!is_dir($this->thumb_dir)) {
            mkdir($this->thumb_dir, 0755, true);
        }

        for ($i = 1; $i <= $max_num; $i++) {
            $num = self::generateThumbNum($i);
            $id_video_image = Clipbucket_db::getInstance()->insert(tbl('video_image'), [
                'videoid',
                'type',
                'num'
            ], [
                $this->video['videoid'],
                'thumbnail',
                $num
            ]);
            $quotient_video_time = $duration / $max_num;
            $this->generateThumb($id_video_image, $num, (int)$quotient_video_time * $i);
            if ($i == 1) {
                //if video already has default thumb, don't update value
                $res = self::getOne([
                    'videoid' => $this->video['videoid'],
                    'default'=> 'thumb',
                    'is_auto' => false,
                ]);
                if (empty($res)) {
                    Clipbucket_db::getInstance()->update(tbl('video'), ['default_thumb'], [$id_video_image], ' videoid = ' . mysql_clean($this->video['videoid']));
                }
            }
        }
    }


    /**
     * @param int $id_video_image
     * @param string $num
     * @param $video_time
     * @return void
     * @throws Exception
     */
    public function generateThumb(int $id_video_image, string $num, $video_time): void
    {
        $extension = 'jpg';
        foreach (self::$resolution_setting as $key => $res) {
            if ($key == 'original') {
                $size_tag = 'original';
                $res['width'] = $this->ffmpeg_instance->input_details['video_width'] ??'';
                $res['height'] = $this->ffmpeg_instance->input_details['video_height'] ??'';
            } else {
                $size_tag = $res['width'] . 'x' . $res['height'];
            }
            $file_name = self::getThumbName('thumbnail', $this->ffmpeg_instance->file_name, 1, $num, $size_tag, $res['width'], $res['height'], $extension, Update::getInstance()->getCurrentCoreVersion());
            $file_path = $this->thumb_dir .DIRECTORY_SEPARATOR . $file_name;
            $this->ffmpeg_instance->log->writeLine(date('Y-m-d H:i:s') . ' => Generating ' . $file_name . '...');
            $return = FFMpeg::extractVideoThumbnail([
                'timecode'    => $video_time,
                'input_path'  => $this->ffmpeg_instance->input_file,
                'size_tag'    => $size_tag,
                'width'       => $res['width'] ?? null,
                'height'      => $res['height'] ?? null,
                'output_path' => $file_path
            ]);


            if (System::isInDev()) {
                $this->ffmpeg_instance->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Command : </p><p class="content">' . $return['command'] . '</p></div>', false, true);
                $this->ffmpeg_instance->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Output : </p><p class="content">' . $return['output'] . '</p></div>', false, true);
            }
            if (file_exists($file_path)) {
                if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
                    Clipbucket_db::getInstance()->insert(tbl('video_thumb'), [
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
                        $extension,
                        Update::getInstance()->getCurrentCoreVersion(),
                        (int)($key == 'original')
                    ]);
                } else {
                    Clipbucket_db::getInstance()->insert(tbl('video_thumbs'), [
                        'videoid',
                        'resolution',
                        'num',
                        'extension',
                        'version',
                        'type'
                    ], [
                        $this->video['videoid'],
                        $size_tag,
                        $num,
                        $extension,
                        Update::getInstance()->getCurrentCoreVersion(),
                        'auto'
                    ]);
                }
            } else {
                $this->ffmpeg_instance->log->writeLine(date('Y-m-d H:i:s') . ' => Error generating ' . $file_name . '...');
            }
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function removeGeneratedThumbs(): void
    {
        $this->ffmpeg_instance->log->newSection('Removing thumbnails');
        $this->ffmpeg_instance->log->writeLine(date('Y-m-d H:i:s') . ' - Deleting thumbs...');
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
            $video_images = self::getAll([
                'videoid' => $this->video['videoid'],
                'type'    => 'auto'
            ]);
            foreach ($video_images as $video_image) {
                $this->deleteImageAndThumbs($video_image);
            }
        } else {
            Clipbucket_db::getInstance()->delete(tbl('video_thumbs'), [
                'videoid',
                'type'
            ], [
                $this->video['videoid'],
                'auto'
            ]);
            $pattern = DirPath::get('thumbs') . $this->ffmpeg_instance->file_directory . DIRECTORY_SEPARATOR . $this->ffmpeg_instance->file_name . '*[!-cpb].*';
            $glob = glob($pattern);
            foreach ($glob as $thumb) {
                unlink($thumb);
            }
        }
    }

    /**
     * @param $video_image
     * @return void
     * @throws Exception
     */
    public function deleteImageAndThumbs($video_image): void
    {
        if ($video_image['version'] > '5.5.2') {
            $pattern = DirPath::get('thumbs') . $this->ffmpeg_instance->file_directory . DIRECTORY_SEPARATOR
                . $this->ffmpeg_instance->file_name . '-'
                . $video_image['type'] . '-'
                . '*[!-cpb]-'
                . $video_image['num']
                . '.*';
            $glob = glob($pattern);
            foreach ($glob as $thumb) {
                unlink($thumb);
            }
            Clipbucket_db::getInstance()->delete(tbl('video_thumb'), ['id_video_image'], [$video_image['id_video_image']]);
            Clipbucket_db::getInstance()->delete(tbl('video_image'), ['id_video_image'], [$video_image['id_video_image']]);
        } else {
            Clipbucket_db::getInstance()->delete(tbl('video_thumb'), ['videoid'], [$video_image['videoid']]);
            $pattern = DirPath::get('thumbs') . $this->ffmpeg_instance->file_directory . DIRECTORY_SEPARATOR . $this->ffmpeg_instance->file_name . '*[!-cpb].*';
            $glob = glob($pattern);
            foreach ($glob as $thumb) {
                unlink($thumb);
            }
        }
    }

    /**
     * @param bool $is_multi
     * @param int $videoid
     * @param int $width
     * @param int $height
     * @param string $type
     * @param bool|null $is_auto
     * @param bool|null $is_default
     * @param string $return_type
     * @param bool $return_with_num
     * @return array|string
     * @throws Exception
     */
    private static function getThumbsFile(bool $is_multi, int $videoid, int $width, int $height, string $type = 'thumbnail', bool $is_auto = null, bool $is_default = null, string $return_type = 'url', bool $return_with_num = false): array|string
    {
        $thumb_video_directory_path = DirPath::get('thumbs') . 'video' . DIRECTORY_SEPARATOR;
        switch ($return_type) {
            default:
            case 'url':
                $thumb_video_directory = DirPath::getUrl('thumbs') . 'video' . DIRECTORY_SEPARATOR;
                break;
            case 'filepath':
                $thumb_video_directory = $thumb_video_directory_path;
                break;
        }
        if (!in_array($type, [
            'thumbnail',
            'poster',
            'backdrop'
        ])) {
            e(lang('technical_error'));
            error_log('getThumb - unknown type : ' . $type);
            return $is_multi ? [self::getDefaultMissingThumb($return_type, $return_with_num)] : self::getDefaultMissingThumb($return_type, $return_with_num);
        }

        $video = Video::getInstance()->getOne(['videoid' => $videoid]);
        if (empty($video)) {
            e(lang('technical_error'));
            error_log('getDefaultThumbFile - called on empty vdetails');
            return $is_multi ? [self::getDefaultMissingThumb($return_type, $return_with_num)] : self::getDefaultMissingThumb($return_type, $return_with_num);
        }

        $params = [
            'videoid'        => $videoid,
            'width'          => $width,
            'height'         => $height,
            'get_num'        => true,
            'get_is_default' => true,
            'get_is_auto'    => true,
            'default'        => $is_default ? $type : null,
            'is_auto'        => $is_auto
        ];
        //param old
        $conditions_old = [];
        switch ($type) {
            default:
                $default = $video['default_thumb'];
                $old_type = $is_auto ? 'auto' : 'custom';
                break;
            case 'poster':
                $default = $video['default_poster'];
                $old_type = $type;
                break;
            case 'backdrop':
                $default = $video['default_backdrop'];
                $old_type = $type;
                break;
        }
        if ($is_default) {
            $conditions_old[] = ' num = '. mysql_clean($default);
        }
        if ($width == 'original' || $height == 'original') {
            $conditions_old[] = 'resolution = \'original\'';
        } else if ($width && $height) {
            $conditions_old[] = 'resolution = \''.mysql_clean($width) . 'x' . mysql_clean($height).'\'';
        }
        //TODO change select to get new val (is_default, is_auto)
        $sql = 'SELECT * FROM ' . tbl('video_thumbs') . ' WHERE videoid = ' . mysql_clean($videoid) . ' AND type = \'' . mysql_clean($old_type) . '\' ' . implode(' AND ', $conditions_old);
        if ($is_multi) {

            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
                $thumbs = self::getAllThumbs($params);
            } else {
                $thumbs= '';
            }
            $thumbs_files = [];
            foreach ($thumbs as $thumb) {
                $thumb_path = self::getThumbPath($type, $video['file_directory'], $video['file_name'], $thumb['is_auto'], $thumb['num'], $thumb['resolution'], $thumb['width'], $thumb['height'], $thumb['extension'], $thumb['version']);
                $filepath = $thumb_video_directory . $thumb_path;
                if (!file_exists($thumb_video_directory_path . $thumb_path)) {
                    $filepath = self::getDefaultMissingThumb($return_type, $return_with_num);
                }
                $thumbs_files[] = $return_with_num ? ['thumb'=>$filepath, 'thumb_id'=>$thumb['id_video_image'], 'thumb_num'=>$thumb['num']] : $filepath;
            }
            return $thumbs_files;
        } else {
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
                $thumb = self::getOneThumb($params);
            } else {
                $thumb = '';
            }
            $thumb_path = self::getThumbPath($type, $video['file_directory'], $video['file_name'], $thumb['is_auto'], $thumb['num'], $thumb['resolution'], $thumb['width'], $thumb['height'], $thumb['extension'], $thumb['version']);
            if (!file_exists($thumb_video_directory_path . $thumb_path)) {
                return self::getDefaultMissingThumb($return_type, $return_with_num);
            }
            $return = $thumb_video_directory . $thumb_path;
            return $return_with_num ? ['thumb'=>$return, 'thumb_id'=>$thumb['id_video_image'], 'thumb_num'=>$thumb['num']] : $return;
        }
    }

    /**
     * @param int $videoid
     * @param int $width
     * @param int $height
     * @param string $type
     * @param bool|null $is_auto
     * @param string $return_type
     * @param bool $return_with_num
     * @return string
     * @throws Exception
     */
    public static function getDefaultThumbFile(int $videoid, int $width, int $height, string $type = 'thumbnail', bool $is_auto = null, string $return_type = 'url', bool $return_with_num = false): string
    {
        return self::getThumbsFile(false, $videoid, $width, $height, $type, $is_auto, true, $return_type, $return_with_num);
    }

    /**
     * @param int $videoid
     * @param int $width
     * @param int $height
     * @param string $type
     * @param bool|null $is_auto
     * @param bool|null $is_default
     * @param string $return_type
     * @param bool $return_with_num
     * @return array
     * @throws Exception
     */
    public static function getAllThumbFiles(int $videoid, int $width, int $height, string $type, bool $is_auto = null, bool $is_default = null, string $return_type = 'url', bool $return_with_num = false): array
    {
        return self::getThumbsFile(true, $videoid, $width, $height, $type, $is_auto, $is_default, $return_type, $return_with_num);
    }

    /**
     * @param $type
     * @param $video_file_directory
     * @param $video_file_name
     * @param $thumb_is_auto
     * @param $thumb_num
     * @param $thumb_resolution
     * @param $thumb_width
     * @param $thumb_height
     * @param $thumb_extension
     * @param $thumb_version
     * @return string
     */
    private static function getThumbPath($type, $video_file_directory, $video_file_name, $thumb_is_auto, $thumb_num, $thumb_resolution, $thumb_width, $thumb_height, $thumb_extension, $thumb_version): string
    {
        if ($thumb_version >= '5.5.2') {
            $filepath = $video_file_directory . DIRECTORY_SEPARATOR . $video_file_name .DIRECTORY_SEPARATOR;
        } else {
            $filepath = $video_file_directory . DIRECTORY_SEPARATOR;
        }
        return $filepath . self::getThumbName($type, $video_file_name, $thumb_is_auto, $thumb_num, $thumb_resolution, $thumb_width, $thumb_height, $thumb_extension, $thumb_version);
    }

    /**
     * @param $type
     * @param $video_file_name
     * @param $thumb_is_auto
     * @param $thumb_num
     * @param $thumb_resolution
     * @param $thumb_width
     * @param $thumb_height
     * @param $thumb_extension
     * @param $thumb_version
     * @return string
     */
    private static function getThumbName($type, $video_file_name, $thumb_is_auto, $thumb_num, $thumb_resolution, $thumb_width, $thumb_height, $thumb_extension, $thumb_version): string
    {
        if ($thumb_version >= '5.5.2') {
            $filename =  $video_file_name . '-'
                . $type . (!$thumb_is_auto ? '-c' : '') . '-'
                . self::generateThumbNum($thumb_num) . '-'
                . (empty($thumb_resolution) ? $thumb_width . 'x' . $thumb_height : $thumb_resolution)
                . '.' . $thumb_extension;
        } else {
            if ($type == 'thumbnail') {
                if ($thumb_is_auto) {
                    $old_type = 'auto';
                } else {
                    $old_type = 'custom';
                }
            } else {
                $old_type = $type;
            }
            $filename = $video_file_name . '-'
                . $thumb_resolution . '-'
                . $thumb_num
                . ($old_type != 'auto' ? '-' . array_search($old_type, Upload::getInstance()->types_thumb) : '')
                . '.' . $thumb_extension;
        }
        return $filename;
    }

    /**
     * @param int $num
     * @return string
     */
    private static function generateThumbNum(int $num): string
    {
        return str_pad((string)$num, 5, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $return_type
     * @param bool $return_with_num
     * @return array|string
     */
    public static function getDefaultMissingThumb(string $return_type = 'url', bool $return_with_num = false): array|string
    {
        return $return_with_num ? ['thumb'=>default_thumb($return_type), 'thumb_id'=>0, 'thumb_num'=>0] : default_thumb($return_type);
    }

    /**
     * @param $id_video
     * @param $file_array
     * @param string $type
     * @param bool $is_auto
     * @return void
     * @throws Exception
     */
    public static function uploadThumbs($id_video, $file_array, string $type = 'thumbnail', bool $is_auto = false): void
    {
        $video = Video::getInstance()->getOne(['videoid' => $id_video]);
        if (empty($video)) {
            e(lang('video_not_found'));
            return;
        }
        if (count($file_array['name']) > 1) {
            for ($i = 0; $i < count($file_array['name']); $i++) {
                self::uploadThumb($video, $file_array, $i, $type, $is_auto);
            }
            e(lang('upload_vid_thumbs_msg'), 'm');
        } else {
            $file = $file_array;
            self::uploadThumb($video, $file, $key = 0, $type, $is_auto);
        }
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
            $num = self::getLastNum($video['videoid'], $type, $is_auto) + 1;
            $temp_file_path = $thumb_video_directory . $video['file_name'] . '-' . $num . '-' . $type . '.' . $ext_destination;

            if (self::ValidateImage($file['tmp_name'][$file_array_key], $ext_original)) {
                $id_video_image = Clipbucket_db::getInstance()->insert(tbl('video_image'), [
                    'videoid',
                    'type',
                    'num',
                    'is_auto'
                ], [
                    $video['videoid'],
                    $type,
                    $num,
                    (int)$is_auto
                ]);
                foreach (self::$resolution_setting as $resolution_key => $res) {
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
                    $new_thumb_path = $thumb_video_directory . self::getThumbPath($type, $video['file_directory'], $video['file_name'], false, $num, $size_tag, $res['width'], $res['height'], $ext_destination, Update::getInstance()->getCurrentCoreVersion());
                    VideoThumbs::CreateThumb($temp_file_path, $new_thumb_path, $res['width'], $ext_original, $res['height'], false);
                    if (file_exists($new_thumb_path)) {
                        Clipbucket_db::getInstance()->insert(tbl('video_thumb'), [
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
     * @param int $id_video_image
     * @return void
     * @throws Exception
     */
    public static function deleteVideoImage(int $id_video_image)
    {
        $thumbs = self::getAllThumbs(['id_video_image' => $id_video_image, 'get_video_directory'=>true, 'get_video_file_name'=>true]);
        foreach ($thumbs as $thumb) {
            self::deleteVideoThumb($thumb);
        }
        $image = self::getOne(['id_video_image' => $id_video_image, 'get_is_default'=>true]);
        $lang_key = ($image['type']=='thumbnail' ? 'thumbs' : $image['type']);
        Clipbucket_db::getInstance()->delete(tbl('video_image'), ['id_video_image'], [$id_video_image]);
        if ($image['is_default']) {
            Video::getInstance()->resetDefaultPicture($image['videoid'], $image['type']);
        }
        e(lang($lang_key . '_delete_successfully'), 'm');
    }

    public static function deleteVideoThumb(array $thumb)
    {
        $thumb_path = DirPath::get('thumbs') . self::getThumbPath($thumb['type'], $thumb['video_directory'], $thumb['file_name'], $thumb['is_auto'], $thumb['num'], ($thumb['is_original_size'] ? 'original' : ''), $thumb['width'], $thumb['height'], $thumb['extension'], $thumb['version']);
        if (file_exists($thumb_path)) {
            unlink($thumb_path);
        }
        Clipbucket_db::getInstance()->delete(tbl('video_thumb'), ['id_video_thumb'],[$thumb['id_video_thumb']]);
    }

    /**
     * @param int $id_video_thumb
     * @return void
     * @throws Exception
     */
    public static function deleteVideoThumbById(int $id_video_thumb)
    {
        $thumb = self::getOneThumb(['id_video_thumb' => $id_video_thumb,'get_video_directory'=>true, 'get_video_file_name'=>true]);
        self::deleteVideoThumb($thumb);
    }

}