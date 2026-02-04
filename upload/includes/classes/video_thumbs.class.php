<?php

class VideoThumbs
{
    private static string $tableName = 'video_image';

    private static string $tableNameThumb = 'video_thumb';

    private FFMpeg $ffmpeg_instance;
    private array $video;

    private string $thumb_dir = '';

    /**
     * @var array
     * resolutions are in 16:10 ratio
     */
    private static array $resolution_setting = [
        'thumbnail' => [
            'original' => ['size_tag' => 'original'],
            '105'      => ['width'  => '168', 'height' => '105'],
            '260'      => ['width'  => '416', 'height' => '260'],
            '320'      => ['width'  => '512', 'height' => '320'],
            '480'      => ['width'  => '768', 'height' => '480']
        ],
        'poster'    => [
            'original' => ['size_tag' => 'original'],
            '140'      => ['width'  => '90', 'height' => '140'],
            '300'      => ['width'  => '200', 'height' => '300'],
        ],
        'backdrop'  => [
            'original' => ['size_tag' => 'original'],
            '105'      => ['width'  => '168', 'height' => '105'],
            '260'      => ['width'  => '416', 'height' => '260'],
            '320'      => ['width'  => '512', 'height' => '320'],
            '480'      => ['width'  => '768', 'height' => '480'],
            '560'      => ['width'  => '896', 'height' => '560']
        ]
    ];

    private static array $fields = [
        'id_video_image',
        'videoid',
        'type',
        'num',
        'is_auto'
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
    public static function getAll(array $params): mixed
    {
        $param_first_only = $params['first_only'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_videoid = $params['videoid'] ?? false;
        $param_type = $params['type'] ?? false;
        $param_max_num = $params['max_num'] ?? false;
        $param_default = $params['default'] ?? false;
        $param_get_is_default = $params['get_is_default'] ?? false;
        $param_is_auto = $params['is_auto'] ?? null;
        $param_id_video_image = $params['id_video_image'] ?? false;
        $param_num = $params['num'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        if ($param_count) {
            $select[] = 'COUNT(DISTINCT ' . self::$tableName . '.id_video_image) AS count';
        } elseif ($param_max_num) {
            $select[] = 'MAX(num) AS max_num';
            $group[] = self::$tableName . '.videoid';
        } else {
            $select = self::getAllFields();
        }

        if ($param_get_is_default) {
            $select[] = '('
                .Video::getInstance()->getTableName() . '.default_thumbnail = '.self::$tableName.'.id_video_image'
                .' OR ' .Video::getInstance()->getTableName() . '.default_poster =  '.self::$tableName.'.id_video_image'
                .' OR ' .Video::getInstance()->getTableName() . '.default_backdrop = '.self::$tableName.'.id_video_image'
                .' ) AS is_default';
        }

        if ($param_videoid) {
            $conditions[] = self::$tableName . '.videoid = ' . mysql_clean($param_videoid);
        }
        if ($param_num) {
            $conditions[] = self::$tableName . '.num = ' . mysql_clean($param_num);
        }
        if ($param_type) {
            $conditions[] = self::$tableName .'.type = \'' . mysql_clean($param_type) . '\'';
        }
        if ($param_id_video_image) {
            $conditions[] = self::$tableName .'.id_video_image = \'' . mysql_clean($param_id_video_image) . '\'';
        }

        if ( $param_is_auto !== null ) {
            $conditions[] = self::$tableName . '.is_auto = ' . mysql_clean((int)$param_is_auto);
        }
        if ($param_default) {
            $conditions[] = Video::getInstance()->getTableName() . '.default_'. $param_default .' = ' . self::$tableName .'.id_video_image';
        }
        if ($param_get_is_default || $param_default) {
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
        $params['limit'] = ' 0, 1 ';
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
        $param_get_type = $params['get_type'] ?? false;
        $param_video_id = $params['videoid'] ?? false;
        $param_width = $params['width'] ?? false;
        $param_height = $params['height'] ?? false;
        $param_is_auto = $params['is_auto'] ?? null;
        $param_default = $params['default'] ?? null;
        $param_get_is_default = $params['get_is_default'] ?? null;
        $param_get_video_directory = $params['get_video_directory'] ?? false;
        $param_get_video_file_name = $params['get_video_file_name'] ?? false;
        $param_version = $params['version'] ?? false;
        $param_version_inf_or_eq = $params['param_version_inf_or_eq'] ?? false;

        $conditions = [];
        $join = [];
        $group = [];

        //SELECTS
        if (!$param_count) {
            $select = self::getAllFieldsThumbs();
            if ($param_get_num) {
                $select[] = self::$tableName.'.num';
            }
            if ($param_get_is_auto) {
                $select[] = self::$tableName.'.is_auto';
            }
            if ($param_get_type) {
                $select[] = self::$tableName.'.type';
            }
            if ($param_get_is_default) {
                $select[] = '('
                    .Video::getInstance()->getTableName() . '.default_thumbnail = '.self::$tableName.'.id_video_image'
                    .' OR ' .Video::getInstance()->getTableName() . '.default_poster = '.self::$tableName.'.id_video_image'
                    .' OR ' .Video::getInstance()->getTableName() . '.default_backdrop = '.self::$tableName.'.id_video_image'
                    .' ) AS is_default';
            }
            if ($param_get_video_directory) {
                $select[] = Video::getInstance()->getTableName() . '.file_directory ';
            }
            if ($param_get_video_file_name) {
                $select[] = Video::getInstance()->getTableName() . '.file_name ';
            }
        } else {
            $select[] = 'COUNT(DISTINCT ' . self::$tableNameThumb . '.id_video_thumb) AS count';
        }

        //CONDITIONS
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
            $conditions[] = self::$tableNameThumb . '.is_original_size = 1';
        } else {
            if ($param_width) {
                $conditions[] = self::$tableNameThumb . '.width = ' .  mysql_clean($param_width);
            }
            if ($param_height) {
                $conditions[] = self::$tableNameThumb . '.height = ' . mysql_clean($param_height);
            }
            if (!empty($param_width) || !empty($param_height)) {
                $conditions[] = self::$tableNameThumb . '.is_original_size = 0';
            }
        }

        if ($param_is_auto !== null) {
            $conditions[] = self::$tableName . '.is_auto = ' . (mysql_clean($param_is_auto) ?: 'false');
        }
        if ($param_default !== null) {
            $conditions[] = Video::getInstance()->getTableName() . '.default_' . $param_default . ' = ' . self::$tableName . '.id_video_image';
        }
        if ($param_version) {
            $conditions[] = self::$tableNameThumb . '.version = \'' . mysql_clean($param_version) . '\'';
        }
        if ($param_version_inf_or_eq) {
            $conditions[] = self::$tableNameThumb . '.version <= \'' . mysql_clean($param_version_inf_or_eq) . '\'';
        }

        //JOINS
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
     * @param int $videoid
     * @param FFMpeg|null $ffmpeg_instance
     * @throws Exception
     */
    public function __construct(int $videoid, $ffmpeg_instance = null)
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
    private function init_FFMPEG(): void
    {
        require_once DirPath::get('classes') . 'sLog.php';
        $logFile = DirPath::get('logs') . $this->video['file_directory'] . DIRECTORY_SEPARATOR . $this->video['file_name'] . '.log';
        $log = new \SLog($logFile);
        $this->ffmpeg_instance = new FFMpeg($log);
        $vid_file = get_high_res_file($this->video);
        $this->ffmpeg_instance->input_details['duration'] = $this->video['duration'];
        $this->ffmpeg_instance->input_file = $vid_file;
        $this->ffmpeg_instance->file_directory = $this->video['file_directory'] . DIRECTORY_SEPARATOR;
        $this->ffmpeg_instance->file_name = $this->video['file_name'];
    }

    /**
     * @return void
     */
    public function prepareFFmpeg(): void
    {
        $this->ffmpeg_instance->prepare();
    }

    /**
     * @param int $videoid
     * @param string $type
     * @param bool $is_auto
     * @return int
     * @throws Exception
     */
    private static function getLastNum(int $videoid, string $type, bool $is_auto = false): int
    {
        $res = self::getOne(['videoid' => $videoid, 'type' => $type, 'is_auto' => $is_auto, 'max_num'=>true]);
        return $res['max_num'] ?? 0;
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
     * @param bool $regenerate
     * @return void
     * @throws Exception
     */
    public function generateAutomaticThumbs(bool $regenerate = true): void
    {
        if ($regenerate) {
            $this->removeGeneratedThumbs();
        }

        $this->ffmpeg_instance->log->newSection('Generating thumbnails');

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
            $id_video_image = Clipbucket_db::getInstance()->insert(tbl(self::$tableName), [
                'videoid',
                'type',
                'num'
            ], [
                $this->video['videoid'],
                'thumbnail',
                $num
            ]);
            if (!empty($id_video_image)) {
                $quotient_video_time = $duration / $max_num;
                $this->generateThumb($id_video_image, $num, (int)$quotient_video_time * $i);
                if ($i == 1) {
                    //if video already has default thumb, don't update value
                    $res = self::getOne([
                        'videoid' => $this->video['videoid'],
                        'default'=> 'thumbnail',
                        'is_auto' => false,
                    ]);
                    if (empty($res)) {
                        Clipbucket_db::getInstance()->update(tbl('video'), ['default_thumbnail'], [$id_video_image], ' videoid = ' . mysql_clean($this->video['videoid']));
                    }
                }
            } else {
                $this->ffmpeg_instance->log->writeLine(date('Y-m-d H:i:s') . ' => Error generating thumbnail for ' . $this->video['file_name'] . ' num ' . $num . ' ...');
            }
        }
    }

    /**
     * @param int $id_video_image
     * @param string $num
     * @param $video_time
     * @param string $type
     * @return void
     * @throws Exception
     */
    public function generateThumb(int $id_video_image, string $num, $video_time, string $type = 'thumbnail'): void
    {
        $extension = config('video_thumbs_format');
        if( empty($extension) ){
            $extension = 'webp';
        }
        foreach (self::$resolution_setting[$type] as $key => $res) {
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
                'timecode'       => $video_time
                ,'input_path'    => $this->ffmpeg_instance->input_file
                ,'size_tag'      => $size_tag
                ,'width'         => $res['width'] ?? null
                ,'height'        => $res['height'] ?? null
                ,'output_path'   => $file_path
                ,'output_format' => $extension
            ]);

            if (System::isInDev()) {
                $this->ffmpeg_instance->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Command : </p><p class="content">' . $return['command'] . '</p></div>', false, true);
                $this->ffmpeg_instance->log->writeLine('<div class="showHide"><p class="title glyphicon-chevron-right">Output : </p><p class="content">' . $return['output'] . '</p></div>', false, true);
            }
            if (file_exists($file_path)) {
                if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
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
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
            $video_images = self::getAll([
                'videoid' => $this->video['videoid'],
                'type'    => 'thumbnail',
                'is_auto' => true
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
     * @return array
     */
    public function getVideoDimension(): array
    {
        return [
            'width'  => $this->ffmpeg_instance->input_details['video_width'] ?? '',
            'height' => $this->ffmpeg_instance->input_details['video_height'] ?? ''
        ];
    }

    /**
     * @param bool $ignore
     * @return void
     * @throws Exception
     */
    public function importOldThumbFromDisk(bool $ignore = false): void
    {
        //check files
        $glob = DirPath::get('thumbs') . $this->ffmpeg_instance->file_directory . DIRECTORY_SEPARATOR . $this->ffmpeg_instance->file_name . '*';
        $vid_thumbs = glob($glob);
        if (!empty($vid_thumbs) && !empty($this->ffmpeg_instance->file_directory) && !empty($this->ffmpeg_instance->file_name)) {
            foreach ($vid_thumbs as $thumb) {
                $files_info = [];
                //pattern must match :  /`file_name`-`size`-`num`.`extension`
                preg_match('/\/\w*-(\w{1,16})-(\d{1,3})\.(\w{2,4})$/', $thumb, $files_info);
                if (!empty($files_info)) {
                    if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
                        $video_image = self::getOne([
                            'videoid' => $this->video['videoid'],
                            'type'    => 'thumbnail',
                            'num'     => (int)$files_info[2]
                        ]);
                        if (empty($video_image)) {
                            $id_video_image = Clipbucket_db::getInstance()->insert(tbl(self::$tableName), [
                                'videoid',
                                'type',
                                'num'
                            ], [
                                $this->video['videoid'],
                                'thumbnail',
                                (int)$files_info[2]
                            ]);
                        } else {
                            $id_video_image = $video_image['id_video_image'];
                        }
                        if ($files_info[1] == 'original') {
                            $sizes['width'] = $this->ffmpeg_instance->input_details['video_width'] ?? '';
                            $sizes['height'] = $this->ffmpeg_instance->input_details['video_height'] ?? '';
                        } else {
                            $sizes = self::getWidthHeightFromSize($files_info[1]);
                        }
                        Clipbucket_db::getInstance()->insert(tbl(self::$tableNameThumb), [
                            'id_video_image',
                            'width',
                            'height',
                            'extension',
                            'version',
                            'is_original_size'
                        ], [
                            $id_video_image,
                            $sizes['width'] ?? null,
                            $sizes['height'] ?? null,
                            $files_info[3],
                            $this->video['video_version'],
                            (int)($files_info[1] == 'original')
                        ], ignore: $ignore);

                    } else {
                        Clipbucket_db::getInstance()->insert(tbl('video_thumbs'), [
                            'videoid',
                            'resolution',
                            'num',
                            'extension',
                            'version'
                        ], [
                            $this->video['videoid'],
                            $files_info[1],
                            $files_info[2],
                            $files_info[3],
                            $this->video['video_version']
                        ], ignore: $ignore);
                    }
                }
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
        } else {
            $pattern = DirPath::get('thumbs') . $this->ffmpeg_instance->file_directory . DIRECTORY_SEPARATOR . $this->ffmpeg_instance->file_name . '*[!-cpb].*';
        }
        $glob = glob($pattern);
        foreach ($glob as $thumb) {
            unlink($thumb);
        }
        Clipbucket_db::getInstance()->delete(tbl(self::$tableNameThumb), ['id_video_image'], [$video_image['id_video_image']]);
        Clipbucket_db::getInstance()->delete(tbl(self::$tableName), ['id_video_image'], [$video_image['id_video_image']]);
    }

    /**
     * @param bool $is_multi
     * @param int $videoid
     * @param int|string $width
     * @param int|string $height
     * @param string $type
     * @param bool|null $is_auto
     * @param bool|null $is_default
     * @param string $return_type
     * @param bool $return_with_num
     * @return array|string
     * @throws Exception
     */
    private static function getThumbsFile(bool $is_multi, int $videoid, int|string $width, int|string $height, string $type = 'thumbnail', $is_auto = null, $is_default = null, string $return_type = 'url', bool $return_with_num = false): array|string
    {
        if (!in_array($type, [
            'thumbnail',
            'poster',
            'backdrop'
        ])) {
            e(lang('technical_error'));
            $msg = 'getThumb - unknown type : ' . $type;
            error_log($msg);
            if (System::isInDev()) {
                DiscordLog::sendDump($msg);
            }
            return $is_multi ? [self::getDefaultMissingThumb($return_type, $return_with_num)] : self::getDefaultMissingThumb($return_type, $return_with_num);
        }
        if (empty($videoid)) {
            return $is_multi ? [self::getDefaultMissingThumb($return_type, $return_with_num)] : self::getDefaultMissingThumb($return_type, $return_with_num);
        }

        $video = Video::getInstance()->getOne(['videoid' => $videoid]);
        if (empty($video)) {
            e(lang('technical_error'));
            $msg ='getDefaultThumbFile - called on empty vdetails';
            error_log($msg);
            if (System::isInDev()) {
                DiscordLog::sendDump($msg);
            }
            return $is_multi ? [self::getDefaultMissingThumb($return_type, $return_with_num)] : self::getDefaultMissingThumb($return_type, $return_with_num);
        }

        $thumb_video_directory_path = DirPath::get('thumbs') ;
        switch ($return_type) {
            default:
            case 'url':
                $thumb_video_directory = DirPath::getUrl('thumbs') ;
                break;

            case 'filepath':
                $thumb_video_directory = $thumb_video_directory_path;
                break;
        }

        $params = [];
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
            $params = [
                'videoid'        => $videoid,
                'width'          => $width,
                'height'         => $height,
                'get_num'        => true,
                'get_is_default' => true,
                'get_is_auto'    => true,
                'default'        => $is_default ? $type : null,
                'is_auto'        => $is_auto,
                'limit'          => !$is_multi ? '1' : null,
                'type'           => $type,
            ];
            $thumbs = self::getAllThumbs($params);
        } else {
            //param old
            $conditions_old = [];
            switch ($type) {
                default:
                    $default = $video['default_thumb'];
                    $default_field = 'default_thumb';
                    $old_type = $is_auto ? 'auto' : 'custom';
                    if ($is_auto === null) {
                        $old_type = '\'auto\',\'custom\'';
                    } elseif ($is_auto === false) {
                        $old_type = '\'custom\'';
                    } elseif ($is_auto === true) {
                        $old_type = '\'auto\'';
                    }
                    break;

                case 'poster':
                    $default = $video['default_poster'];
                    $default_field = 'default_poster';
                    $old_type = '\'' . mysql_clean($type) . '\'';
                    break;

                case 'backdrop':
                    $default = $video['default_backdrop'];
                    $default_field = 'default_backdrop';
                    $old_type = '\'' . mysql_clean($type) . '\'';
                    break;
            }
            if ($is_default) {
                $conditions_old[] = ' num = ' . mysql_clean($default);
            }
            if ($width == 'original' || $height == 'original') {
                $conditions_old[] = 'resolution = \'original\'';
            } else if ($width && $height) {
                $conditions_old[] = 'resolution = \'' . mysql_clean($width) . 'x' . mysql_clean($height) . '\'';
            }
            $sql = 'SELECT *, CASE WHEN num = ' . mysql_clean($video[$default_field] ?? 0) . ' THEN 1 ELSE 0 END AS is_default, CASE WHEN type != \'custom\' THEN 1 ELSE 0 END AS is_auto
            FROM ' . tbl('video_thumbs') . ' 
            WHERE videoid = ' . $videoid . ' 
            AND type IN ( ' . $old_type . ' ) '
            . (!empty($conditions_old) ? ' AND ' : '') . implode(' AND ', $conditions_old)
            . (!$is_multi ? ' LIMIT 1 ' : '');
            $thumbs = Clipbucket_db::getInstance()->_select($sql);
        }
        $thumbs_files = [];
        if (empty($thumbs)) {
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14') ) {
                $all_thumbs = self::getAllThumbs(['videoid' => $videoid, 'type' => $type, 'is_auto' => true]);
            } else {
                $all_thumbs = Clipbucket_db::getInstance()->_select('SELECT * FROM ' . tbl('video_thumbs') . ' WHERE videoid = ' . $videoid . ' AND type = \'' . mysql_clean($type) . '\' AND type != \'custom\'');
            }
            //generation of missing thumbs if no automatic thumbs are found
            if (empty($all_thumbs)) {
                if ($type == 'thumbnail' && $is_auto && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '18')) {
                    $instance = new VideoThumbs($videoid);
                    $instance->ffmpeg_instance->prepare();
                    $instance->importOldThumbFromDisk();
                    $params['limit'] = '1';
                    $thumbs = self::getAllThumbs($params);
                }
                if (!empty($thumbs)) {
                    return self::getThumbsFile($is_multi, $videoid, $width, $height, $type, $is_auto, $is_default, $return_type, $return_with_num);
                }
                return $is_multi ? [] : self::getDefaultMissingThumb($return_type, $return_with_num);
            }
            //try to get olds thumbs with only width (only after migrations)
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
                $params_for_old = $params;
                unset($params_for_old['height']);
                $params_for_old['param_version_inf_or_eq'] = '5.5.2';
                $thumbs = self::getAllThumbs($params_for_old);
                if (empty($thumbs)) {
                    $params_for_video_image = $params;
                    unset($params_for_video_image['height']);
                    unset($params_for_video_image['width']);
                    $video_image = self::getOne($params_for_video_image);
                    if (empty($video_image)) {
                        return $is_multi ? [] : self::getDefaultMissingThumb($return_type, $return_with_num);
                    }
                    $resolutions = self::getNearestResolutionThumb($video_image['id_video_image'], $width, $height);
                    if (empty($resolutions)) {
                        return $is_multi ? [] : self::getDefaultMissingThumb($return_type, $return_with_num);
                    }
                    $thumbs_files = self::getThumbsFile($is_multi, $videoid, $resolutions['width'], $resolutions['height'], $type, $is_auto, $is_default, $return_type, $return_with_num);
                    if (!empty($thumbs_files)) {
                        return $thumbs_files;
                    }
                }
            }

        }
        foreach ($thumbs as $thumb) {
            $resolution = $thumb['resolution'] ?? ($thumb['is_original_size'] ? 'original' : false);
            $thumb_path = self::getThumbPath($type, $video['file_directory'], $video['file_name'], $thumb['is_auto'], $thumb['num'], $resolution, $thumb['width'], $thumb['height'], $thumb['extension'], $thumb['version']);
            $thumb_suffix = $thumb['version'] > '5.5.2' ? 'video' . DIRECTORY_SEPARATOR : '';
            $filepath = $thumb_video_directory . $thumb_suffix . $thumb_path;
            if (!file_exists($thumb_video_directory_path . $thumb_suffix . $thumb_path)) {
                if ($thumb['version'] <= '5.5.0') {
                    $old_thumb_path = self::getThumbPath($type, $video['file_directory'], $video['file_name'], $thumb['is_auto'], $thumb['num'], $resolution, $thumb['width'], $thumb['height'], $thumb['extension'], 0);
                    if (!file_exists($thumb_video_directory_path . $thumb_suffix . $old_thumb_path)) {
                        $filepath = self::getDefaultMissingThumb($return_type);
                    } else {
                        $filepath = $thumb_video_directory . $thumb_suffix . $old_thumb_path;
                    }
                } else {
                    $filepath = self::getDefaultMissingThumb($return_type);
                }
            }
            $thumbs_files[] = $return_with_num ? [
                'thumb'     => $filepath,
                'thumb_id'  => $thumb['id_video_image'],
                'thumb_num' => $thumb['num']
            ] : $filepath;
        }
        return $is_multi ? $thumbs_files : ($thumbs_files[0] ?? self::getDefaultMissingThumb($return_type, $return_with_num));
    }

    /**
     * @param int $videoid
     * @param int|string $width
     * @param int|string $height
     * @param string $type
     * @param bool|null $is_auto
     * @param string $return_type
     * @param bool $return_with_num
     * @return string
     * @throws Exception
     */
    public static function getDefaultThumbFile(int $videoid, int|string $width = 168, int|string $height = 105, string $type = 'thumbnail', $is_auto = null, string $return_type = 'url', bool $return_with_num = false): string
    {
        return self::getThumbsFile(false, $videoid, $width, $height, $type, $is_auto, true, $return_type, $return_with_num);
    }

    /**
     * @param int $videoid
     * @param int|string $width
     * @param int|string $height
     * @param string $type
     * @param bool|null $is_auto
     * @param bool|null $is_default
     * @param string $return_type
     * @param bool $return_with_num
     * @return array
     * @throws Exception
     */
    public static function getAllThumbFiles(int $videoid, int|string $width = 168, int|string $height = 105, string $type = 'thumbnail', $is_auto = null, $is_default = null, string $return_type = 'url', bool $return_with_num = false): array
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
        if ($thumb_version > '5.5.2') {
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
        if ($thumb_version > '5.5.2') {
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
                . (empty($thumb_resolution) ? $thumb_width . 'x' . $thumb_height : $thumb_resolution) . '-'
                . self::generateThumbNum($thumb_num, $thumb_version)
                . ($old_type != 'auto' ? '-' . array_search($old_type, Upload::getInstance()->types_thumb) : '')
                . '.' . $thumb_extension;
        }
        return $filename;
    }

    /**
     * @param int $num
     * @param string|null $version
     * @return string
     */
    private static function generateThumbNum(int $num, $version = null): string
    {
        if ($version >= '5.5.3' || $version === null) {
            $pad = 5;
        } elseif ($version >= '5.5.1') {
            $pad = 4;
        } elseif ($version == '0')  {
            $pad = 0;
        } else {
            $pad = 2;
        }
        return str_pad((string)$num, $pad, '0', STR_PAD_LEFT);
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
            self::uploadThumb($video, $file, 0, $type, $is_auto);
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
        $temp_directory = DirPath::get('temp' );
        $thumb_video_directory = DirPath::get('thumbs' ) . 'video' . DIRECTORY_SEPARATOR;
        if (!empty($file['name'])) {
            $ext_original = getExt($file['name'][$file_array_key]);
            $ext_destination = 'jpg';
            $num = self::getLastNum($video['videoid'], $type, $is_auto) + 1;
            $temp_file_path = $temp_directory . $video['file_name'] . '-' . $num . '-' . $type . '.' . $ext_destination;

            if (self::ValidateImage($file['tmp_name'][$file_array_key], $ext_original)) {
                $id_video_image = Clipbucket_db::getInstance()->insert(tbl(self::$tableName), [
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
                    $new_thumb_path = $thumb_video_directory . self::getThumbPath($type, $video['file_directory'], $video['file_name'], $is_auto, $num, $size_tag, $res['width'], $res['height'], $ext_destination, Update::getInstance()->getCurrentCoreVersion());
                    if (!file_exists(dirname($new_thumb_path))) {
                        //needed if upload on old version
                        mkdir(dirname($new_thumb_path), 0755, true);
                    }
                    VideoThumbs::CreateThumb($temp_file_path, $new_thumb_path, $res['width'], $ext_original, $res['height'], false);
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
    public static function CreateThumb(string $file, string $des, int $dim, string $ext, $dim_h = null, bool $aspect_ratio = true): void
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
    public static function deleteVideoImage(array $image, bool $msg = true): void
    {
        if (empty($image)) {
            return;
        }
        if ($image['is_default']) {
            Video::getInstance()->resetDefaultPicture($image['videoid'], $image['type']);

            $image_temp = self::getOne(['id_video_image' => $image['id_video_image'], 'get_is_default'=>true]);
            if (empty($image_temp)) {
                Clipbucket_db::getInstance()->update(tbl(Video::getInstance()->getTableName()), ['default_'. $image['type']], ['|f|null'], ' videoid = ' . $image['videoid']);
            }
        }
        $thumbs = self::getAllThumbs(['id_video_image' => $image['id_video_image'], 'get_video_directory'=>true, 'get_video_file_name'=>true, 'get_is_auto'=>true, 'get_num'=>true , 'get_type'=>true]);
        foreach ($thumbs as $thumb) {
            self::deleteVideoThumb($thumb);
        }
        $lang_key = ($image['type']=='thumbnail' ? 'thumbs' : $image['type']);
        Clipbucket_db::getInstance()->delete(tbl(self::$tableName), ['id_video_image'], [$image['id_video_image']]);
        if ($msg) {
            e(lang($lang_key . '_delete_successfully'), 'm');
        }
    }

    /**
     * @throws Exception
     */
    public static function deleteVideoThumb(array $thumb): void
    {
        $thumb_path = DirPath::get('thumbs') . 'video' . DIRECTORY_SEPARATOR . self::getThumbPath($thumb['type'], $thumb['file_directory'], $thumb['file_name'], $thumb['is_auto'], $thumb['num'], ($thumb['is_original_size'] ? 'original' : ''), $thumb['width'], $thumb['height'], $thumb['extension'], $thumb['version']);
        if (file_exists($thumb_path)) {
            unlink($thumb_path);
        }
        Clipbucket_db::getInstance()->delete(tbl(self::$tableNameThumb), ['id_video_thumb'],[$thumb['id_video_thumb']]);
    }

    /**
     * @param $size
     * @return array|string[]
     */
    public static function getWidthHeightFromSize($size): array
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
     * @throws Exception
     */
    public function generateAllMissingThumbs(): void
    {
        if (empty(self::getAll(['videoid' => $this->video['videoid']]))) {
            $this->generateAutomaticThumbs();
        }
    }

    /**
     * @param $videoid
     * @return array|int|mixed
     * @throws Exception
     */
    public static function getAllThumbCountByVideoId($videoid): mixed
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
            return VideoThumbs::getAllThumbs(['count'=>true, 'videoid'=>$videoid]);
        } else {
            $resVideo = Clipbucket_db::getInstance()->select(tbl('video') . ' AS V INNER JOIN ' . tbl('video_thumbs') . ' AS VT ON VT.videoid = V.videoid ', 'COUNT(V.videoid) as nb_thumbs', 'V.videoid = ' . mysql_clean($videoid));
            if (empty($resVideo)) {
                error_log('get_count_thumb - no thumbnails for videoid : ' . $videoid);
                return 0;
            }
            return $resVideo[0]['nb_thumbs'];
        }
    }

    /**
     * @param $id_video_image
     * @param $requested_width
     * @param $requested_height
     * @return array
     * @throws Exception
     */
    public static function getNearestResolutionThumb($id_video_image, $requested_width, $requested_height): array
    {
        if(empty($id_video_image) ) {
            return [];
        }
        //search for a resolution that exists
        //the biggest resolution that is smaller than the requested one
        $sql = 'SELECT width, height FROM ' . tbl(self::$tableNameThumb) . ' WHERE id_video_image = ' . $id_video_image . ' AND width < '.mysql_clean($requested_width).' AND height < '.mysql_clean($requested_height).' ORDER BY width DESC LIMIT 1';
        $resolutions = Clipbucket_db::getInstance()->_select($sql);
        if (!empty($resolutions[0]) && !empty($resolutions[0]['width'])) {
            return $resolutions[0];
        }
        //if no resolution is found, return the smaller resolution that is bigger than the requested one
        $sql = 'SELECT width, height FROM ' . tbl(self::$tableNameThumb) . ' WHERE id_video_image = ' . $id_video_image . ' AND width > '.mysql_clean($requested_width).' AND height > '.mysql_clean($requested_height).' ORDER BY width ASC LIMIT 1';
        $resolutions = Clipbucket_db::getInstance()->_select($sql);
        if (!empty($resolutions[0]) && !empty($resolutions[0]['width'])) {
            return $resolutions[0];
        }
        //if nothing is found return original
        return ['width' => 'original', 'height' => 'original'];
    }
}