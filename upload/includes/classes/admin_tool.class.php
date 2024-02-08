<?php

class AdminTool
{
    private static $_instance = null;
    private static $temp;

    /**
     * @var $id_histo the most recent tools_histo
     */
    private $id_histo;
    private $id_tool;
    private $tool;
    private $array_loop;

    /**
     * @return AdminTool
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new AdminTool();
        }
        return self::$_instance;
    }

    /**
     * @param $id_tool
     * @return bool
     * @throws Exception
     */
    public function init($id_tool): bool
    {
        $this->id_tool = $id_tool;
        if (empty($id_tool)) {
            e(lang('class_error_occured'));
            return false;
        }
        $this->tool = self::getToolById($this->id_tool);
        if (empty($this->tool)) {
            e(lang('class_error_occured'));
            return false;
        }
        $this->id_histo = $this->tool['id_histo'];
        return true;
    }

    /**
     * Function used to get all tools
     *
     * @param array $condition
     * @return array
     * @throws Exception
     */
    public static function getTools(array $condition = []): array
    {
        $where = implode(' AND ', $condition);

        $sql = 'SELECT tools.id_tool, language_key_label, language_key_description, elements_total, elements_done, COALESCE(NULLIF(language_key_title, \'\'), \'ready\') as language_key_title, function_name, 
                   CASE WHEN elements_total IS NULL OR elements_total = 0 THEN 0 ELSE elements_done * 100 / elements_total END AS pourcentage_progress, tools_histo.id_histo
                FROM ' . cb_sql_table("tools") . '
                LEFT JOIN (
                    SELECT id_tool, MAX(date_start) AS max_date
                    FROM ' . tbl('tools_histo') . '
                    GROUP BY id_tool
                ) tools_histo_max_date ON tools.id_tool = tools_histo_max_date.id_tool
                LEFT JOIN ' . cb_sql_table("tools_histo") . ' ON tools.id_tool = tools_histo.id_tool AND tools_histo.date_start = tools_histo_max_date.max_date
                left JOIN ' . cb_sql_table("tools_histo_status") . '  ON tools_histo_status.id_tools_histo_status = tools_histo.id_tools_histo_status
                WHERE tools_histo.id_tool IS NOT NULL OR tools_histo_max_date.id_tool IS NULL
                '.(!empty($where) ? 'AND ' . $where : '').'
                ORDER BY tools.id_tool;';


        return Clipbucket_db::getInstance()->_select($sql);
    }

    /**
     * Change status of tool to 'in progress'
     * @return bool
     * @throws Exception
     */
    public function setToolInProgress(): bool
    {
        Clipbucket_db::getInstance()->insert(tbl('tools_histo'), ['id_tool', 'id_tools_histo_status', 'date_start'], [$this->id_tool, '|no_mc||f|(SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title like \'in_progress\')', '|no_mc||f|NOW()']);
        $this->id_histo = Clipbucket_db::getInstance()->insert_id();
        return true;
    }

    /**
     * check if tool exist and execute the function stored in database
     * @param $id
     * @return false|void
     * @throws Exception
     */
    public function launch()
    {
        if (empty($this->tool)) {
            e(lang('class_error_occured'));
            return false;
        }
        call_user_func_array([$this, $this->tool['function_name']], []);
    }

    /**
     * return all tools
     * @return array
     * @throws Exception
     */
    public static function getAllTools(): array
    {
        return self::getTools();
    }

    /**
     * Return an admin tool by his id
     * @param $id
     * @return array
     * @throws Exception
     */
    public static function getToolById($id): array
    {
        return self::getTools([' tools.id_tool = ' . mysql_clean($id)])[0];
    }

    /**
     * Find videos which don't have thumbs and generate them
     * @param $id_tool
     * @return void
     * @throws Exception
     */
    public function generateMissingThumbs()
    {
        //get list of video without thumbs
        $this->array_loop = Clipbucket_db::getInstance()->select(tbl('video') . ' AS V LEFT JOIN ' . tbl('video_thumbs') . ' AS VT ON V.videoid = VT.videoid', 'V.*', ' 1 GROUP by videoid HAVING COUNT(VT.videoid) = 0');
        $this->executeTool('generatingMoreThumbs');
    }

    /**
     * check videos to change to castable status if needed
     * @return void
     * @throws Exception
     */
    public function updateCastableStatus()
    {
        $this->array_loop = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        $this->executeTool('update_castable_status');
    }

    /**
     * check videos to change to castable status if needed
     * @return void
     * @throws Exception
     */
    public function updateBitsColor()
    {
        $this->array_loop = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        $this->executeTool('update_bits_color');
    }

    /**
     * check videos duration
     * @return void
     * @throws Exception
     */
    public function updateVideoDuration()
    {
        $this->array_loop = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        $this->executeTool('update_duration');
    }

    /**
     * check videos duration which have duration at 0
     * @param $id_tool
     * @return void
     * @throws Exception
     */
    public function repairVideoDuration()
    {
        $this->array_loop = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\' AND duration = 0');
        $this->executeTool('update_duration');
    }

    /**
     * check videos duration
     * @param $id_tool
     * @return void
     * @throws Exception
     */
    public function updateDataBaseVersion()
    {

        $update = Update::getInstance();
        $files = $update->getUpdateFiles();

        $installed_plugins = Clipbucket_db::getInstance()->select(tbl('plugins'), '*');
        $files = array_merge($files, get_plugins_files_to_upgrade($installed_plugins));
        if (empty($files)) {
            //update to current revision
            $sql = 'INSERT INTO ' . tbl('version') . ' SET version = \'' . mysql_clean(VERSION) . '\' , revision = ' . mysql_clean(REV) . ', id = 1 ON DUPLICATE KEY UPDATE version = \'' . mysql_clean(VERSION) . '\' , revision = ' . mysql_clean(REV);
            Clipbucket_db::getInstance()->mysqli->query($sql);
        }
        $this->array_loop = $files;
        $this->executeTool('execute_migration_SQL_file', true);
    }

    /**
     * @throws Exception
     */
    public function resetCache()
    {
        $this->array_loop = ['flush'];
        $this->executeTool('CacheRedis::flushAll');
    }

    /**
     * @param $id_tool
     * @return void
     * @throws Exception
     */
    public function resetVideoLog()
    {
        $logs = rglob(DirPath::get('logs') . '*.log');

        $logs_sql = array_map(function ($log) {
            return '\'' . mysql_clean(basename($log, '.log')) . '\'';
        }, $logs);
        $query = 'SELECT file_name, status, file_directory FROM ' . tbl('video') . ' WHERE file_name IN (' . implode(', ', $logs_sql) . ')';
        $result = Clipbucket_db::getInstance()->execute($query, 'select');
        $videos = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $videos[$row['file_name']] = $row;
            }
            $result->close();
        }
        self::$temp = $videos;
        $this->array_loop = $logs;
        $this->executeTool('reset_video_log');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function cleanOrphanFiles()
    {
        $video_file_name = [];
        $photo_file_name = [];
        $array_user_id = [];
        $logs = rglob(DirPath::get('logs') . '*.log');
        $videos_mp4 = rglob(DirPath::get('videos') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.mp4');
        $photos = rglob(DirPath::get('photos') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*');
        $videos_hls = glob(DirPath::get('videos') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        $thumbs = rglob(DirPath::get('thumbs') . '[0-9]*' . DIRECTORY_SEPARATOR . '*.jpg');
        $subtitles = rglob(DirPath::get('subtitles') . '[0-9]*' . DIRECTORY_SEPARATOR . '*.srt');
        $userfeeds = rglob(DirPath::getUrl('userfeeds') . '[0-9]*' . DIRECTORY_SEPARATOR . '*.feed');

        $files = array_merge(
            array_map(function ($log) use (&$video_file_name) {
                $vid_file_name = basename($log, '.log');
                $video_file_name[] = $vid_file_name;
                return [
                    'type'  => 'log',
                    'data'  => $log,
                    'video' => $vid_file_name
                ];
            }, $logs),
            array_map(function ($thumb) use (&$video_file_name) {
                $vid_file_name = explode('-', basename($thumb, '.jpg'))[0];
                $video_file_name[] = $vid_file_name;
                return [
                    'type'  => 'thumb',
                    'data'  => $thumb,
                    'video' => $vid_file_name
                ];
            }, $thumbs),
            array_map(function ($subtitle) use (&$video_file_name) {
                $vid_file_name = explode('-', basename($subtitle, '.srt'))[0];
                $video_file_name[] = $vid_file_name;
                return [
                    'type'  => 'subtitle',
                    'data'  => $subtitle,
                    'video' => $vid_file_name
                ];
            }, $subtitles),
            array_map(function ($video) use (&$video_file_name) {
                $vid_file_name = explode('-', basename($video, '.mp4'))[0];
                $video_file_name[] = $vid_file_name;
                return [
                    'type'  => 'video_mp',
                    'data'  => $video,
                    'video' => $vid_file_name
                ];
            }, $videos_mp4),
            array_map(function ($photo) use (&$photo_file_name) {
                $pic_file_name = explode('_', pathinfo($photo)['filename'])[0];
                $photo_file_name[] = $pic_file_name;
                return [
                    'type'  => 'photo',
                    'data'  => $photo,
                    'photo' => $pic_file_name
                ];
            }, $photos),
            array_map(function ($video) use (&$video_file_name) {
                $vid_file_name = basename($video);
                $video_file_name[] = $vid_file_name;
                return [
                    'type'  => 'video_hls',
                    'data'  => $video,
                    'video' => $vid_file_name
                ];
            }, $videos_hls),
            array_map(function ($userfeed) use (&$array_user_id) {
                $user_id = basename(dirname($userfeed));
                $array_user_id[] = $user_id;
                return [
                    'type' => 'userfeeds',
                    'data' => $userfeed,
                    'user' => $user_id
                ];
            }, $userfeeds)
        );


        $sql_video_file_name = array_map(function ($video_file_name) {
            return '\'' . mysql_clean($video_file_name) . '\'';
        }, array_unique($video_file_name));
        $sql_photo_file_name = array_map(function ($photo_file_name) {
            return '\'' . mysql_clean($photo_file_name) . '\'';
        }, array_unique($photo_file_name));
        $sql_user_id = array_map(function ($array_user_id) {
            return '\'' . mysql_clean($array_user_id) . '\'';
        }, array_unique($array_user_id));

        $data = [];
        $data['video'] = [];
        $data['photo'] = [];
        $data['user'] = [];

        if (!empty($sql_video_file_name)) {
            $query = 'SELECT file_name FROM ' . tbl('video') . ' WHERE file_name IN (' . implode(', ', $sql_video_file_name) . ')';
            $result = Clipbucket_db::getInstance()->_select($query);
            if ($result) {
                foreach ($result as $line) {
                    $data['video'][] = $line['file_name'];
                }
            }
        }

        if (!empty($sql_photo_file_name)) {
            $query = 'SELECT filename FROM ' . tbl('photos') . ' WHERE filename IN (' . implode(', ', $sql_photo_file_name) . ')';
            $result = Clipbucket_db::getInstance()->_select($query);
            if ($result) {
                foreach ($result as $line) {
                    $data['photo'][] = $line['filename'];
                }
            }
        }

        if (!empty($sql_user_id)) {
            $query = 'SELECT userid FROM ' . tbl('users') . ' WHERE userid IN (' . implode(', ', $sql_user_id) . ')';
            $result = Clipbucket_db::getInstance()->_select($query);
            if ($result) {
                foreach ($result as $line) {
                    $data['user'][] = $line['userid'];
                }
            }
        }

        self::$temp = $data;
        $this->array_loop = $files;
        $this->executeTool('clean_orphan_files');

        //remove already empty folders
        $empty_logs = glob(DirPath::get('logs') . '*', GLOB_ONLYDIR);
        $empty_subs = glob(DirPath::get('subtitles') . '*', GLOB_ONLYDIR);
        $empty_thumbs = glob(DirPath::get('thumbs') . '*', GLOB_ONLYDIR);
        $empty_vids = glob(DirPath::get('videos') . '*', GLOB_ONLYDIR);
        $empty_pics = glob(DirPath::get('photos') . '*', GLOB_ONLYDIR);
        $empty_userfeeds = glob(DirPath::get('cache') . '*', GLOB_ONLYDIR);
        $empty_folders = array_merge($empty_logs, $empty_subs, $empty_thumbs, $empty_vids, $empty_pics, $empty_userfeeds);
        foreach ($empty_folders as $folder) {
            delete_empty_directories($folder);
        }

    }

    /**
     * @return void
     * @throws Exception
     */
    private function cleanOrphanTags()
    {
        $query = '
            SELECT T.* FROM ' . tbl('tags') . ' T
            LEFT JOIN ' . tbl('video_tags') . ' VT ON T.id_tag = VT.id_tag
            LEFT JOIN ' . tbl('photo_tags') . ' PT ON T.id_tag = PT.id_tag
            LEFT JOIN ' . tbl('collection_tags') . ' CT ON T.id_tag = CT.id_tag
            LEFT JOIN ' . tbl('playlist_tags') . ' PLT ON T.id_tag = PLT.id_tag
            LEFT JOIN ' . tbl('user_tags') . ' UT ON T.id_tag = UT.id_tag
            WHERE 1
            GROUP BY T.id_tag
            HAVING COUNT(VT.id_tag) = 0 AND COUNT(PT.id_tag) = 0 AND COUNT(CT.id_tag) = 0 AND COUNT(PLT.id_tag) = 0 AND COUNT(UT.id_tag) = 0;';
        $tags = Clipbucket_db::getInstance()->_select($query);
        $tags = array_map(function ($tag) {
            return $tag['id_tag'];
        }, $tags);
        $this->array_loop = $tags;
        $this->executeTool('Tags::deleteTag');
    }

    /**
     * @param string $function
     * @param bool $stop_on_error
     * @return void
     * @throws Exception
     */
    private function executeTool(string $function, bool $stop_on_error = false)
    {
        //optimisation to call mysql_clean only once
        $secureIdTool = mysql_clean($this->id_tool);
        //get list of video
        if (!empty($this->array_loop)) {
            //update nb_elements of tools
            $this->updateToolHisto([
                'elements_total',
                'elements_done'
            ], [
                count($this->array_loop),
                0
            ]);
            $nb_done = 0;
            $this->addLog('tool started');
            foreach ($this->array_loop as $item) {
                //check if user request stop
                $has_to_stop = Clipbucket_db::getInstance()->select(tbl('tools') . ' AS T INNER JOIN ' . tbl('tools_histo_status') . ' AS TS ON T.id_tools_histo_status = TS.id_tools_histo_status', 'TS.id_tools_histo_status', 'T.id_tool = ' . $secureIdTool . ' AND TS.language_key_title like \'stopping\'');
                if (!empty($has_to_stop)) {
                    break;
                }
                //call function
                try {
                    call_user_func($function, $item);
                    sleep(2);
                } catch (\Exception $e) {
                    e(lang($e->getMessage()));
                    $this->addLog($e->getMessage());
                    if ($stop_on_error) {
                        $this->addLog('process_stopped');
                        break;
                    }
                }
                //update nb_done of tools
                $nb_done++;
                $this->updateToolHisto(['elements_done'], [$nb_done]);
            }
        }
        $this->updateToolHisto(['id_tools_histo_status', 'date_end'], ['|no_mc||f|(SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title like \'ready\')', '|f|NOW()']);
        $this->addLog('tool ended');
    }

    /**
     * Set status to false in order to stop function execution at the next iteration
     * @param $id_tool
     * @return false|void
     * @throws Exception
     */
    public function stop()
    {
        if ($this->tool['language_key_title'] != 'in_progress') {
            return false;
        }
        $this->updateToolHisto([
            'id_tools_histo_status',
            'date_end'
        ], [
            '|no_mc||f|(SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title like \'stopping\')',
            'NOW()'
        ]);
    }

    /**
     * @return mixed
     */
    public static function getTemp()
    {
        return self::$temp;
    }

    /**
     * @param string $msg
     * @return void
     * @throws Exception
     */
    public function addLog(string $msg)
    {
        Clipbucket_db::getInstance()->insert(tbl('tool_histo_log'), ['id_histo', 'datetime', 'message'], [mysql_clean($this->id_histo), '|f|NOW()', $msg]);
    }

    /**
     * @param int $max_id
     * @return array
     * @throws Exception
     */
    public function getLastLogs(int $max_id = 0)
    {
        $where = ' id_histo = ' . mysql_clean($this->id_histo) . ' AND id_log > ' . mysql_clean($max_id);
        $logs = Clipbucket_db::getInstance()->select(tbl('tool_histo_log'), 'datetime ,message', $where);
        $max_id_log = Clipbucket_db::getInstance()->select(tbl('tool_histo_log'), 'MAX(id_log) as max_id_log', $where);
        return [
            'logs' => $logs,
            'max_id_log' => $max_id_log[0]['max_id_log'] ?? 0
        ];
    }

    /**
     * @param array $fields
     * @param array $values
     * @return void
     * @throws Exception
     */
    private function updateToolHisto(array $fields, array $values)
    {
        Clipbucket_db::getInstance()->update(tbl('tools_histo'), $fields, $values, 'id_tool = ' . mysql_clean($this->id_tool) . ' AND id_histo = ' . mysql_clean($this->id_histo));
    }


}
