<?php

class videoThumbs
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
        'version'
    ];

    public static function getAll(array $params)
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_videoid = $params['videoid'] ?? false;
        $param_type = $params['type'] ?? false;
        $param_max_num = $params['max_num'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        if ($param_videoid) {
            $conditions[] = self::$tableName . '.videoid = ' . mysql_clean($param_videoid);
        }
        if ($param_type) {
            $conditions[] = 'type = \'' . mysql_clean($param_type) . '\'';
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
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
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($param_first_only) {
            return $result[0];
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
        } else {
            $select[] = 'COUNT(DISTINCT ' . self::$tableNameThumb . '.id_video_image) AS count';
        }

        if ($param_id_video_image) {
            $conditions[] = self::$tableNameThumb . '.id_video_image = ' . mysql_clean($param_id_video_image);
        }
        if ($param_type) {
            $conditions[] = self::$tableName . '.type = \'' . mysql_clean($param_type) . '\'';
            $select[] = self::$tableName . '.type';
        }

        if ($param_type || $param_get_num) {
            $join[] = 'LEFT JOIN ' . cb_sql_table(self::$tableName) . ' ON ' . self::$tableNameThumb . '.id_video_image = ' . self::$tableName . '.id_video_image';
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }


        $sql = 'SELECT ' . implode(', ', $select) . '
                    FROM ' . cb_sql_table(self::$tableName)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(', ', $group))
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);
        if ($param_first_only) {
            return $result[0];
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
     * @throws Exception
     */
    public function __construct(int $videoid)
    {
        $this->video = Video::getInstance()->getOne([
            'videoid'                     => $videoid,
            'disable_generic_constraints' => true
        ]);
        $this->init_FFMPEG();
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

    /**
     * @return void
     * @throws Exception
     */
    public function generateAutomaticThumbs(): void
    {
        $this->ffmpeg_instance->log->newSection('Generating thumbnails');
        $this->removeGeneratedThumbs();
        $max_num = (config('num_thumbs') ?: 1);
        if ($max_num > $this->video['duration']) {
            $max_num = (int)$this->video['duration'];
        }
        $this->thumb_dir = DirPath::get('thumbs') . DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR . $this->ffmpeg_instance->file_directory . DIRECTORY_SEPARATOR . $this->ffmpeg_instance->file_name ;
        if (!is_dir($this->thumb_dir)) {
            mkdir($this->thumb_dir, 0755, true);
        }
        for ($i = 1; $i <= $max_num; $i++) {
            $num = str_pad((string)$i, 5, '0', STR_PAD_LEFT);
            $id_video_image = Clipbucket_db::getInstance()->insert(tbl('video_image'), [
                'videoid',
                'type',
                'num'
            ], [
                $this->video['videoid'],
                'thumbnail',
                $num
            ]);
            $quotient_video_time = $this->video['duration'] / $max_num;
            $this->generateThumb($id_video_image, $num, $quotient_video_time * $i);
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
            } else {
                $size_tag = $res['width'] . 'x' . $res['height'];
            }
            $file_name = $this->ffmpeg_instance->file_name . '-' . $this->video['type'] . '-' . $size_tag . '-' . $num . '.' . $extension;
            $file_path = $this->thumb_dir . $file_name;
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
                        'version'
                    ], [
                        $id_video_image,
                        $res['width'] ?? null,
                        $res['height'] ?? null,
                        $extension,
                        Update::getInstance()->getCurrentCoreVersion()
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

    public static function getDefaultThumb(int $videoid, int $width, int $height, string $type, $return_type = 'url'): string
    {
        if (!in_array($type, [
            'thumbnail',
            'poster',
            'backdrop'
        ])) {
            e(lang('technical_error'));
            error_log('getDefaultThumb - unknown type : ' . $type);
            return default_thumb($return_type);
        }
        $video = Video::getInstance()->getOne(['videoid' => $videoid]);
        if (empty($video)) {
            e(lang('technical_error'));
            error_log('getDefaultThumb - called on empty vdetails');
            return default_thumb($return_type);
        }
        $thumb = self::getOneThumb([
            'id_video_image' => $video['default_' . $type],
            'width'          => $width,
            'height'         => $height,
            'get_num'        => true,
        ]);
        if (empty($thumb)) {
            return default_thumb($return_type);
        }
        if ($thumb['version'] > '5.5.2') {
            $filepath = $video['file_directory'] . DIRECTORY_SEPARATOR
                . $video['file_name'] . '-'
                . $type . (!$thumb['is_auto'] ? '-c' : '') . '-'
                . $thumb['num'] . '-'
                . $thumb['width'] . 'x' . $thumb['height'] . '-'
                . '.' . $thumb['extension'];
        } else {
            if ( $type == 'thumbnail') {
                if ($thumb['is_auto'] ) {
                    $old_type = 'auto';
                } else {
                    $old_type = 'custom';
                }
            } else {
                $old_type = $thumb['type'];
            }
            $filepath = $video['file_directory'] . DIRECTORY_SEPARATOR
                . $video['file_name'] . '-'
                . $thumb['resolution'] . '-'
                . $thumb['num']
                . ($old_type!= 'auto' ? '-'.array_search($old_type, Upload::getInstance()->types_thumb) : '')
                .'.' . $thumb['extension'];
        }
        if (!file_exists(DirPath::get('thumbs') . $filepath)) {
            return default_thumb($return_type);
        }

        switch($return_type) {
            default:
            case 'url':
                return DirPath::getUrl('thumbs') . $filepath;
            case 'filepath':
                return DirPath::get('thumbs') . $filepath;
        }
    }

}