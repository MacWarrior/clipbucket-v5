<?php

require_once DirPath::get('classes') . 'cron_expression.class.php';

class AdminTool
{
    private static $_instance = null;
    private static $temp;

    const CODE_UPDATE_DATABASE_VERSION = 'update_database_version';

    private $id_histo;
    private $id_tool;
    private $tool;
    private $tasks;

    private $tasks_index;

    private $tasks_processed;
    private $tasks_total;

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
     * @param int $id_tool
     * @return bool
     * @throws Exception
     */
    public function initById(int $id_tool): bool
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
     * @param string $code
     * @return bool
     * @throws Exception
     */
    public function initByCode(string $code): bool
    {
        if (empty($code)) {
            e(lang('class_error_occured'));
            return false;
        }
        $this->tool = self::getToolByCode($code);
        if (empty($this->tool)) {
            e(lang('class_error_occured'));
            return false;
        }
        $this->id_tool = $this->tool['id_tool'];
        $this->id_histo = $this->tool['id_histo'];
        return true;
    }

    /**
     * Function used to get all tools
     *
     * @param array $condition
     * @return mixed
     * @throws Exception
     */
    public static function getTools(array $condition = [])
    {
        $where = implode(' AND ', $condition);
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {

            $complement_select = '';
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '99')) {
                $complement_select = ',tools.is_automatable, tools.is_disabled, tools.frequency';
            }

            $sql = /** @lang MySQL */
                'SELECT tools.id_tool, language_key_label, language_key_description, elements_total, elements_done, COALESCE(NULLIF(language_key_title, \'\'), \'ready\') as language_key_title, function_name, code,
                   CASE WHEN elements_total IS NULL OR elements_total = 0 THEN 0 ELSE elements_done * 100 / elements_total END AS pourcentage_progress, tools_histo.id_histo
                    ' . $complement_select . '
                FROM ' . cb_sql_table('tools') . '
                LEFT JOIN (
                    SELECT id_tool, MAX(date_start) AS max_date
                    FROM ' . tbl('tools_histo') . '
                    GROUP BY id_tool
                ) tools_histo_max_date ON tools.id_tool = tools_histo_max_date.id_tool
                LEFT JOIN ' . cb_sql_table('tools_histo') . ' ON tools.id_tool = tools_histo.id_tool AND tools_histo.date_start = tools_histo_max_date.max_date
                left JOIN ' . cb_sql_table('tools_histo_status') . '  ON tools_histo_status.id_tools_histo_status = tools_histo.id_tools_histo_status
                WHERE (tools_histo.id_tool IS NOT NULL OR tools_histo_max_date.id_tool IS NULL)
                ' . (!empty($where) ? 'AND ' . $where : '') . '
                ORDER BY tools.id_tool;';

            return Clipbucket_db::getInstance()->_select($sql);
        }

        $select = cb_sql_table('tools') . ' 
            LEFT JOIN ' . cb_sql_table('tools_status') . ' ON tools_status.id_tools_status = tools.id_tools_status';

        return Clipbucket_db::getInstance()->select($select, 'id_tool, language_key_label, language_key_description, elements_total, elements_done, language_key_title, function_name, 
           CASE WHEN elements_total IS NULL OR elements_total = 0 THEN 0 ELSE elements_done * 100 / elements_total END AS pourcentage_progress'
            , $where
        );
    }

    /**
     * Change status of tool to 'in progress'
     * @return bool
     * @throws Exception
     */
    public function setToolInProgress(): bool
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
            return $this->setToolInProgressNew();
        } else {
            Clipbucket_db::getInstance()->update(tbl('tools'), ['id_tools_status'], ['|no_mc||f|(SELECT id_tools_status FROM ' . tbl('tools_status') . ' WHERE language_key_title like \'in_progress\')'], 'id_tool = ' . mysql_clean($this->id_tool));
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function setToolInProgressNew(): bool
    {
        Clipbucket_db::getInstance()->insert(tbl('tools_histo'), ['id_tool', 'id_tools_histo_status', 'date_start'], [$this->id_tool, '|no_mc||f|(SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title like \'in_progress\')', '|no_mc||f|NOW()']);
        $this->id_histo = Clipbucket_db::getInstance()->insert_id();
        return true;
    }

    /**
     * Change is_disabled of tool
     * @param bool $value
     * @return void
     * @throws Exception
     */
    public function updateIsDisabled(bool $value): void
    {
        Clipbucket_db::getInstance()->update(tbl('tools'), ['is_disabled'], [(int)$value], 'id_tool = ' . mysql_clean($this->id_tool));
    }

    /**
     * @param string $frequency
     * @return void
     * @throws Exception
     */
    public function updateFrequency(string $frequency): void
    {
        /** check si le format cron is ok */
        $expression = new \CronExpression($frequency);
        if ($expression->isValid() === false && !empty($frequency)) {
            throw new Exception('Format cron invalid');
        }

        Clipbucket_db::getInstance()->update(tbl('tools'), ['frequency', 'previous_calculated_datetime'], [$frequency, date('Y-m-d H:i:s')], 'id_tool = ' . mysql_clean($this->id_tool));
    }

    /**
     * @throws Exception
     */
    public function toolErrorHandler($e): bool
    {
        $this->addLog('Error : ' . $e->getMessage());
        $this->setToolError($this->id_tool);
        return false;
    }

    /**
     * check if tool exist and execute the function stored in database
     * @return false|void
     * @throws Exception
     */
    public function launch()
    {
        $whoops = WhoopsManager::getInstance();
        $whoops->pushHandler([$this, 'toolErrorHandler']);

        $whoops->register();
        if (empty($this->tool)) {
            e(lang('class_error_occured'));
            return false;
        }
        $this->tasks_index = 0;
        //setting total if exist
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279')) {
            $info = $this->getLastHistoNotEndedNotRunning();
            if (!empty($info)) {
                $this->tasks_total = $info[0]['elements_total'];
                $this->tasks_index = $info[0]['loop_index'];
                $this->changeDataHisto();
            }
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
            $this->addLog(lang('tool_started'));
        }
        call_user_func_array([$this, $this->tool['function_name']], []);
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
            $this->addLog(lang('tool_ended'));
        }
    }

    /**
     * start a tool on another process with CLI
     * @param int $id_tool
     * @return void
     */
    public static function launchCli(int $id_tool): void
    {
        $cmd = System::get_binaries('php_cli').' -q '.DirPath::get('admin_actions') . 'tool_launch.php id_tool='.$id_tool;
        if (stristr(PHP_OS, 'WIN')) {
            $complement = '';
        } elseif (stristr(PHP_OS, 'darwin')) {
            $complement = ' </dev/null >/dev/null &';
        } else { // for ubuntu or linux
            $complement = ' > /dev/null &';
        }
        exec($cmd . $complement);
    }

    /**
     * return all tools
     * @return mixed
     * @throws Exception
     */
    public static function getAllTools()
    {
        return self::getTools();
    }

    /**
     * Return an admin tool by his id
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public static function getToolById($id)
    {
        return self::getTools([' tools.id_tool = ' . mysql_clean($id)])[0];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public static function getToolByCode($code)
    {
        return self::getTools([' tools.code = \'' . mysql_clean($code) . '\''])[0];
    }

    /**
     * Find videos which don't have thumbs and generate them
     * @return void
     * @throws Exception
     */
    public function generateMissingThumbs(): void
    {
        //get list of video without thumbs
        $this->tasks = Clipbucket_db::getInstance()->select(tbl('video') . ' AS V LEFT JOIN ' . tbl('video_thumbs') . ' AS VT ON V.videoid = VT.videoid', 'V.*', ' 1 GROUP by videoid HAVING COUNT(VT.videoid) = 0');
        $this->executeTool('generatingMoreThumbs');
    }

    /**
     * check videos to change to castable status if needed
     * @return void
     * @throws Exception
     */
    public function updateCastableStatus(): void
    {
        $this->tasks = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        $this->executeTool('update_castable_status');
    }

    /**
     * check videos to change to castable status if needed
     * @return void
     * @throws Exception
     */
    public function updateBitsColor(): void
    {
        $this->tasks = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        $this->executeTool('update_bits_color');
    }

    /**
     * check videos to change to castable status if needed
     * @return void
     * @throws Exception
     */
    public function updateAspectRatio(): void
    {
        $this->tasks = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\' AND aspect_ratio IS NULL');
        $this->executeTool('update_aspect_ratio');
    }

    /**
     * check videos duration
     * @return void
     * @throws Exception
     */
    public function updateVideoDuration(): void
    {
        $this->tasks = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        $this->executeTool('update_duration');
    }

    /**
     * check videos duration which have duration at 0
     * @return void
     * @throws Exception
     */
    public function repairVideoDuration(): void
    {
        $this->tasks = Clipbucket_db::getInstance()->select(tbl('video'), '*', ' status LIKE \'Successful\' AND duration = 0');
        $this->executeTool('update_duration');
    }

    /**
     * check videos duration
     * @return void
     * @throws Exception
     */
    public function updateDataBaseVersion(): void
    {
        $update = Update::getInstance();
        $files = $update->getUpdateFiles();

        $installed_plugins = Clipbucket_db::getInstance()->select(tbl('plugins'), '*');
        $files = array_merge($files, get_plugins_files_to_upgrade($installed_plugins));

        if (empty($files)) {
            $version = $update->getCurrentCoreVersion();
            $revision = $update->getCurrentCoreRevision();
            //update to current revision
            $sql = 'INSERT INTO ' . tbl('version') . ' SET version = \'' . mysql_clean($version) . '\' , revision = ' . mysql_clean($revision) . ', id = 1 ON DUPLICATE KEY UPDATE version = \'' . mysql_clean($version) . '\' , revision = ' . mysql_clean($revision);
            Clipbucket_db::getInstance()->execute($sql);
            CacheRedis::flushAll();
            Update::getInstance()->flush();
        }
        $this->tasks = $files;
        $this->executeTool('execute_migration_file', true);
        Update::getInstance()->flush();
    }

    /**
     * @throws Exception
     */
    public function resetCache(): void
    {
        $this->tasks = ['flush'];
        $this->executeTool('CacheRedis::flushAll');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function resetVideoLog(): void
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
        $this->tasks = $logs;
        $this->executeTool('reset_video_log');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function cleanOrphanFiles(): void
    {
        if (empty($this->tasks_total)) {
            $this->tasks_total = 0;
            $this->tasks_processed = 0;
            $this->tasks = [];

            $this->addLog(lang('loading_file_list'));

            //LOGS
            $logs = new GlobIterator(DirPath::get('logs') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.log');
            foreach ($logs as $log) {
                $vid_file_name = basename($log, '.log');
                $insert_values = [
                    'type'  => 'log',
                    'data'  => DirPath::getFromProjectRoot($log->getPathname()),
                    'video' => $vid_file_name
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($logs);

            //VIDEO MP4
            $videos_mp4 = new GlobIterator(DirPath::get('videos') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.mp4');

            foreach ($videos_mp4 as $video) {
                $vid_file_name = explode('-', basename($video, '.mp4'))[0];
                $insert_values = [
                    'type'  => 'video_mp4',
                    'data'  => DirPath::getFromProjectRoot($video->getPathname()),
                    'video' => $vid_file_name
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($videos_mp4);

            //photos
            $photos = new GlobIterator(DirPath::get('photos') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*');
            foreach ($photos as $photo) {
                $pic_file_name = explode('_', pathinfo($photo)['filename'])[0];
                $insert_values = [
                    'type'  => 'photo',
                    'data'  => DirPath::getFromProjectRoot($photo->getPathname()),
                    'photo' => $pic_file_name
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($photos);

            //VIDEO HLS
            $videos_hls = new GlobIterator(DirPath::get('videos') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*', FilesystemIterator::KEY_AS_FILENAME);
            foreach ($videos_hls as $video) {
                if ($video->isDir()) {
                    $vid_file_name = basename($video);
                    $insert_values = [
                        'type'  => 'video_hls',
                        'data'  => DirPath::getFromProjectRoot($video->getPathname()),
                        'video' => $vid_file_name
                    ];
                    $this->insertTaskData([$insert_values]);
                }
            }
            unset($videos_hls);

            //THUMBS
            $thumbs = new GlobIterator(DirPath::get('thumbs') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.jpg');
            foreach ($thumbs as $thumb) {
                $vid_file_name = explode('-', basename($thumb, '.jpg'))[0];
                $insert_values = [
                    'type'  => 'thumb',
                    'data'  => DirPath::getFromProjectRoot($thumb->getPathname()),
                    'video' => $vid_file_name
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($thumbs);

            //SUBTITLES
            $subtitles = new GlobIterator(DirPath::get('subtitles') . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.srt');
            foreach ($subtitles as $subtitle) {
                $vid_file_name = explode('-', basename($subtitle, '.srt'))[0];
                $insert_values = [
                    'type'  => 'subtitle',
                    'data'  => DirPath::getFromProjectRoot($subtitle->getPathname()),
                    'video' => $vid_file_name
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($subtitles);

            //USERFEED
            $userfeeds = new GlobIterator(DirPath::get('userfeeds') . '[0-9]*' . DIRECTORY_SEPARATOR . '*.feed');
            foreach ($userfeeds as $userfeed) {
                $user_id = basename(dirname($userfeed));
                $insert_values = [
                    'type' => 'userfeeds',
                    'data' => DirPath::getFromProjectRoot($userfeed->getPathname()),
                    'user' => $user_id
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($userfeeds);

            //AVATARS
            $avatars = new GlobIterator(DirPath::get('avatars') . '*.*');
            foreach ($avatars as $avatar) {
                $insert_values = [
                    'type'   => 'avatar',
                    'data'   => DirPath::getFromProjectRoot($avatar->getPathname()),
                    'avatar' => basename($avatar)
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($avatars);

            //BACKGROUNDS
            $backgrounds = new GlobIterator(DirPath::get('backgrounds') . '*.*');
            foreach ($backgrounds as $background) {
                $insert_values = [
                    'type'       => 'background',
                    'data'       => DirPath::getFromProjectRoot($background->getPathname()),
                    'background' => basename($background)
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($backgrounds);

            //FAVICON - LOGO
            $logos = new GlobIterator(DirPath::get('logos') . '*.*');
            foreach ($logos as $logo) {
                $insert_values = [
                    'type' => 'logos',
                    'data' => DirPath::getFromProjectRoot($logo->getPathname()),
                    'logo' => basename($logo)
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($logos);

            //CATEGORY THUMBS
            $category_thumbs = new GlobIterator(DirPath::get('category_thumbs') . '*' . DIRECTORY_SEPARATOR . '[0-9]*.*');
            foreach ($category_thumbs as $category_thumb) {
                $insert_values = [
                    'type'  => 'category_thumbs',
                    'data'  => DirPath::getFromProjectRoot($category_thumb->getPathname()),
                    'thumb' => basename($category_thumb)
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($category_thumbs);

            //VIDEO PARTS
            $video_parts = new GlobIterator(DirPath::get('temp') . '*.part');
            foreach ($video_parts as $video_part) {
                $insert_values = [
                    'type' => 'video_parts',
                    'data' => DirPath::getFromProjectRoot($video_part->getPathname()),
                    'part' => basename($video_part)
                ];
                $this->insertTaskData([$insert_values]);
            }
            unset($video_parts);
        }

        $this->addLog(lang('processing_x_files', $this->tasks_total ?? 0));
        $this->executeTool('clean_orphan_files');

        CacheRedis::flushKeyStart('clean_orphan_files');
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
        $this->addLog(lang('x_orphan_files_have_been_deleted', $this->tasks_processed ?? 0));

    }

    /**
     * @return void
     * @throws Exception
     */
    private function cleanOrphanTags(): void
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
        $this->tasks = $tags;
        $this->executeTool('Tags::deleteTag');
    }

    /**
     * @throws Exception
     */
    private function updateCore(): void
    {
        $this->tasks = ['updateGit'];
        $this->executeTool('Update::updateGitSources', true);
    }

    /**
     * @param string $function
     * @param bool $stop_on_error
     * @return void
     * @throws Exception
     */
    private function executeTool(string $function, bool $stop_on_error = false): void
    {
        //optimisation to call mysql_clean only once
        $secureIdTool = mysql_clean($this->id_tool);
        //get list of video
        if (!empty($this->tasks) || !empty($this->tasks_total)) {
            $element_totals = empty($this->tasks) ? $this->tasks_total : count($this->tasks);
            //update nb_elements of tools
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
                $this->updateToolHisto(['elements_total', 'elements_done'], [$element_totals, 0]);
            } else {
                Clipbucket_db::getInstance()->update(tbl('tools'), ['elements_total', 'elements_done'], [$element_totals, 0], ' id_tool = ' . $secureIdTool);
            }
            $break = false;
            //if db
            do {
                $tasks = (empty($this->tasks) ? $this->getTaskData(10) : $this->tasks);
                foreach ($tasks as $item) {
                    //check if user request stop
                    if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
                        $has_to_stop = Clipbucket_db::getInstance()->select(tbl('tools') . ' AS T 
                        INNER JOIN ' . tbl('tools_histo') . ' AS TH ON T.id_tool = TH.id_tool
                        INNER JOIN ' . tbl('tools_histo_status') . ' AS TS ON TH.id_tools_histo_status = TS.id_tools_histo_status'
                            , 'TS.id_tools_histo_status', 'T.id_tool = ' . $secureIdTool . ' AND TS.language_key_title like \'stopping\'');
                    } else {
                        $has_to_stop = Clipbucket_db::getInstance()->select(tbl('tools') . ' AS T INNER JOIN ' . tbl('tools_status') . ' AS TS ON T.id_tools_status = TS.id_tools_status', 'TS.id_tools_status', 'T.id_tool = ' . $secureIdTool . ' AND TS.language_key_title like \'stopping\'');
                    }
                    if (!empty($has_to_stop)) {
                        break;
                    }
                    //call function
                    try {
                        $result = call_user_func($function, $item);
                        if (!empty($result) && is_string($result)) {
                            $this->tasks_processed++;
                            $this->addLog($result);
                        }
                    } catch (\Exception $e) {
                        e($e->getMessage());
                        if ($stop_on_error) {
//                        $this->addLog(lang('tool_stopped'));
                            //trigger error handler
                            throw new Exception($e->getMessage());
                        }
                        $this->addLog($e->getMessage());
                    }
                    //update nb_done of tools
                    if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '271')) {
                        $this->cleanTaskData();
                    }
                    $this->tasks_index++;
                    if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
                        $this->updateToolHisto(['elements_done'], [$this->tasks_index]);
                    } else {
                        Clipbucket_db::getInstance()->update(tbl('tools'), ['elements_done'], [$this->tasks_index], ' id_tool = ' . $secureIdTool);
                    }
                }
            } while (empty($has_to_stop) && !empty($tasks) && $this->tasks_index < $element_totals);
        }
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
            $this->updateToolHisto(['id_tools_histo_status', 'date_end'], ['|no_mc||f|(SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title like \'ready\')', '|f|NOW()']);
        } else {
            Clipbucket_db::getInstance()->update(tbl('tools'), ['id_tools_status', 'elements_total', 'elements_done'], [1, '|f|null', '|f|null'], 'id_tool = ' . $secureIdTool);
        }
    }

    /**
     * Set status to false in order to stop function execution at the next iteration
     * @return false|void
     * @throws Exception
     */
    public function stop()
    {
        if ($this->tool['language_key_title'] != 'in_progress') {
            return false;
        }

        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
            $this->updateToolHisto(['id_tools_histo_status', 'date_end'], ['|no_mc||f|(SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title like \'stopping\')', '|f|NOW()']);
        } else {
            Clipbucket_db::getInstance()->update(tbl('tools'), ['id_tools_status'], ['|no_mc||f|(SELECT id_tools_status FROM ' . tbl('tools_status') . ' WHERE language_key_title like \'stopping\')'], ' id_tool = ' . mysql_clean($this->id_tool));
        }
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
    public function addLog(string $msg): void
    {
        if (!empty($this->id_histo)) {
            Clipbucket_db::getInstance()->insert(tbl('tools_histo_log'), ['id_histo', 'datetime', 'message'], [mysql_clean($this->id_histo), '|f|NOW()', $msg]);
        }
    }

    /**
     * @param int $max_id
     * @return array
     * @throws Exception
     */
    public function getLastLogs(int $max_id = 0): array
    {
        $logs = Clipbucket_db::getInstance()->select(tbl('tools_histo_log'), 'datetime ,message', ' id_histo = ' . (!empty($this->id_histo) ? mysql_clean($this->id_histo) : '0') . ' AND id_log > ' . mysql_clean($max_id));
        $max_id_log = Clipbucket_db::getInstance()->select(tbl('tools_histo_log'), 'MAX(id_log) as max_id_log', ' id_histo = ' . (!empty($this->id_histo) ? mysql_clean($this->id_histo) : '0'));
        return [
            'logs'       => $logs,
            'max_id_log' => $max_id_log[0]['max_id_log'] ?? 0
        ];
    }

    /**
     * @param array $fields
     * @param array $values
     * @return void
     * @throws Exception
     */
    public function updateToolHisto(array $fields, array $values): void
    {
        if (!empty($this->id_histo)) {
            Clipbucket_db::getInstance()->update(tbl('tools_histo'), $fields, $values, 'id_tool = ' . mysql_clean($this->id_tool) . ' AND id_histo = ' . mysql_clean($this->id_histo));
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function recalculVideoFile(): void
    {
        $videos = Video::getInstance()->getAll();
        $this->tasks = $videos;
        $this->executeTool('update_video_files');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function cleanSessionTable(): void
    {
        $res = Clipbucket_db::getInstance()->select(tbl('sessions'), 'session_id', 'session_date < DATE_SUB(NOW(), INTERVAL 1 MONTH);');
        $this->tasks = array_column($res, 'session_id');
        $this->executeTool('Session::deleteById');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function recreateThumb(): void
    {
        $photos = Photo::getInstance()->getAll();
        if (empty($photos)) {
            $photos = [];
        }
        $this->tasks = array_column($photos, 'photo_id');
        $this->executeTool('Photo::generatePhoto');
    }

    /**
     * @throws Exception
     */
    public function correctVideoCategorie(): void
    {
        $videos = Video::getInstance()->getAll([
            'condition'   => 'videos_categories.id_video IS NULL'
            ,'get_detail' => true
        ]);

        if (!empty($videos)) {
            $this->tasks = array_column($videos, 'videoid');
        }

        $this->executeTool('Video::correctVideoCategorie');
    }

    /**
     * @throws Exception
     */
    public function deleteUnusedResolutionFile(): void
    {
        Clipbucket_db::getInstance()->execute('SET @disabled_res = (SELECT CONCAT(\'[\', GROUP_CONCAT(height),\']\') FROM ' . tbl('video_resolution') . ' WHERE enabled = false);');
        $sql = 'SELECT V.videoid
                    FROM ' . tbl('video') . ' V
                    WHERE  JSON_CONTAINS_PATH(
                        CONCAT(\'{"a":\',video_files,\', "b":\', @disabled_res,\'}\')
                        ,\'one\', \'$.a\', \'$.b\'
                    );';
        $videos = Clipbucket_db::getInstance()->_select($sql);
        if (!empty($videos)) {
            $this->tasks = array_column($videos, 'videoid');
        }
        $this->executeTool('Video::deleteUnusedVideoFiles');
    }

    /**
     * @throws Exception
     */
    public function setToolError($id_tool, $force = false): void
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
            $this->updateToolHisto(['id_tools_histo_status', 'date_end'], ['|no_mc||f|(SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title like \'on_error\')', '|f|NOW()']);
            if ($force) {
                $this->addLog(lang('tool_forced_to_error'));
            } else {
                $this->addLog(lang('tool_ended'));
            }
        } else {
            Clipbucket_db::getInstance()->update(tbl('tools'), ['id_tools_status', 'elements_total', 'elements_done'], [1, '|f|null', '|f|null'], 'id_tool = ' . mysql_clean($id_tool));
        }
    }

    /**
     * @throws Exception
     */
    public function calcUserStorage(): void
    {
        if (config('enable_storage_history') == 'yes') {
            $users = User::getInstance()->getAll([
                'condition' => ' users.userid != ' . mysql_clean(userquery::getInstance()->get_anonymous_user()) . ' AND usr_status like \'ok\''
            ]) ?: [];
            $this->tasks = array_column($users, 'userid');
            $this->executeTool('User::calcUserStorage');
        }
    }

    /**
     * @param int|null $id_tool
     * @return array
     * @throws Exception
     */
    public static function getToolsReadyForLaunch($id_tool = null): array
    {
        $where = '';
        if (!empty($id_tool)) {
            $where = ' AND tools.id_tool = ' . $id_tool;
        }

        /** get all tools with frequency */
        $query = /** @lang MySQL */
            'SELECT 
                        tools.*
                        , tools_histo.date_start AS last_date_start
                    FROM ' . cb_sql_table('tools') . ' 

                    -- exclude tools already running and get date_start
                    INNER JOIN (
                        SELECT MAX(tools_histo.date_start) AS date_start, tools.id_tool
                        FROM ' . cb_sql_table('tools') . '
                        LEFT JOIN ' . cb_sql_table('tools_histo') . ' ON tools_histo.id_tool = tools.id_tool
                        WHERE tools.id_tool NOT IN (
                            SELECT DISTINCT tools.id_tool
                            FROM ' . cb_sql_table('tools') . '
                            INNER JOIN ' . cb_sql_table('tools_histo') . ' ON tools_histo.id_tool = tools.id_tool
                            INNER JOIN ' . cb_sql_table('tools_histo_status') . ' ON tools_histo_status.id_tools_histo_status = tools_histo.id_tools_histo_status
                            WHERE tools_histo_status.language_key_title IN (\'in_progress\',\'stopping\') ' . $where . '
                        ) ' . $where . '
                        GROUP BY tools.id_tool
                    ) tools_histo ON tools.id_tool = tools_histo.id_tool
                    
                    WHERE COALESCE(tools.frequency, \'\') != \'\' 
                      AND COALESCE(tools.previous_calculated_datetime, \'\') != \'\'
                      AND tools.is_automatable = true
                      AND tools.is_disabled = false
                      ' . $where . ';';
        $array_tools = Clipbucket_db::getInstance()->_select($query);
        $array_tools_ready = [];

        foreach ($array_tools as $tool) {

            if (empty($tool['previous_calculated_datetime'])) {
                continue;
            }

            /** check if a tool should be launch */
            if (self::shouldCronBeExecuted($tool['frequency'], $tool['last_date_start'], $tool['previous_calculated_datetime'], $tool['id_tool'])) {
                $array_tools_ready[] = $tool;
            }
        }

        return $array_tools_ready;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function checkAndStartToolsByFrequency(): void
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '99')) {
            $this->setToolError($this->id_tool);
            return;
        }

        $details = [];

        if (config('automate_launch_mode') == 'disabled') {
            $this->addLog(lang('automate_launch_disabled_in_config'));
            $this->setToolError($this->id_tool);
            return;
        } elseif (System::isDateTimeSynchro($details) === false) {
            $error = lang('datetime_synchro_error');
            e($error);
            $this->addLog($error);
            DiscordLog::sendDump($error . ' ' . print_r($details, true));
            $this->setToolError($this->id_tool);
            return;
        }

        $this->tasks = self::getToolsReadyForLaunch();
        $this->executeTool('AdminTool::automate');
    }

    /**
     * Tools for start automate if necessary
     * @param array $tool
     * @return void
     * @throws Exception
     */
    public function automate(array $tool): void
    {
        /** start tools from CLI */
        $this->addLog(lang('launch_tool', lang($tool['language_key_label'])));
        self::launchCli($tool['id_tool']);
    }

    /**
     * @param string $cron
     * @param $last_date_start
     * @param string $previous_calculated_datetime
     * @param int|null $id_tool
     * @return bool
     * @throws Exception
     */
    public static function shouldCronBeExecuted(string $cron, $last_date_start, string $previous_calculated_datetime, $id_tool = null): bool
    {
        if (!empty($last_date_start) && $last_date_start < $previous_calculated_datetime) {
            if ($previous_calculated_datetime > date('Y-m-d H:i:s')) {
                /* should not run because next_date is futur */
                return false;
            }

            /* should run because last run is before previous_calculated_date */
            return true;
        }

        $data_task_date = self::getDateStat($cron, $last_date_start, $previous_calculated_datetime, $id_tool);
        return (empty($last_date_start) || $last_date_start < $data_task_date['next_date']) && $data_task_date['next_date'] <= date('Y-m-d H:i:s');
    }

    /**
     * @param string $cron
     * @param $last_date_start
     * @param string $date_previsionnel_precedente_source
     * @param int|null $id_tool
     * @return array
     * @throws Exception
     */
    public static function getDateStat(string $cron, $last_date_start, string $date_previsionnel_precedente_source, $id_tool = null): array
    {
        $next_date = null;
        $date_previsionnel_precedente = null;
        do {

            if (is_null($last_date_start)) {
                $last_date_start = '2000-01-01 01:00:00';
            }

            $timestamp = self::getNextDate($cron, MAX($last_date_start, $next_date), MAX($date_previsionnel_precedente, $date_previsionnel_precedente_source, $next_date), $date_previsionnel_precedente);
            $date = new \DateTime();
            $date->setTimeStamp($timestamp);
            $continue = $date->format('Y-m-d H:i:s') < date('Y-m-d H:i:s');
            if ($continue || empty($next_date)) {
                $next_date = $date->format('Y-m-d H:i:s');
            }
        } while ($continue);

        if (
            !empty($id_tool)
            && (empty($date_previsionnel_precedente_source) || $date_previsionnel_precedente_source < $last_date_start)
            && !empty($date_previsionnel_precedente)
        ) {
            Clipbucket_db::getInstance()->update(tbl('tools'), ['previous_calculated_datetime'], [$date_previsionnel_precedente], 'id_tool = ' . $id_tool);
        }

        return [
            'date_execution_precedente' => $last_date_start
            ,'date_previsionnel_precedente' => $date_previsionnel_precedente
            ,'next_date' => $next_date
        ];
    }

    /**
     * @param string $cron
     * @param string $date
     * @param string $date_previsionnel
     * @param string|null $last_previsionnel_date
     * @return bool|int
     */
    public static function getNextDate(string $cron, string $date, string $date_previsionnel, &$last_previsionnel_date = null)
    {
        /**
         * replace the L of the month with the last day of the current month if it is at least the 28th of the month, otherwise use the notation 28-31
         */
        $cron = trim($cron);
        $e = explode(' ', $cron ?? '');
        if ($e[2] == 'L') {
            $last_day_of_month = date('t');
            $current_day = date('j');
            if ($current_day < 28) {
                $e[2] = '28-31';
            } else {
                $e[2] = $last_day_of_month;
            }
            $cron = implode(' ', $e);
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);

        try {
            $expression = new \CronExpression($cron);
            $next_date = \DateTime::createFromFormat('Y-m-d H:i:s', $date_previsionnel);

            do {
                $next_date = $expression->getNext($next_date);
                if ($next_date < $date->getTimestamp()) {
                    $date_pre = new \DateTime();
                    $date_pre->setTimeStamp($next_date);
                    $last_previsionnel_date = $date_pre->format('Y-m-d H:i:s');
                }

            } while ($next_date < $date->getTimestamp());

            return $next_date;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * return true if tool not already running and frequency ready for next run
     * @return bool
     * @throws Exception
     */
    public function isReadyForAutomaticLaunch(): bool
    {
        /** check if tool should be launch in cli mode */
        $found = false;
        foreach (self::getToolsReadyForLaunch($this->id_tool) as $tool) {
            if ($found === false && $tool['id_tool'] == $this->id_tool) {
                $found = true;
            }
        }

        return $found;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isAlreadyLaunch(): bool
    {
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {

            /** get all running tools */
            $query = /** @lang MySQL */
                'SELECT DISTINCT tools_histo.id_tool
                            FROM ' . cb_sql_table('tools_histo') . '
                            INNER JOIN ' . cb_sql_table('tools_histo_status') . ' ON tools_histo_status.id_tools_histo_status = tools_histo.id_tools_histo_status
                            WHERE tools_histo_status.language_key_title IN (\'in_progress\',\'stopping\') AND tools_histo.id_tool = ' . ((int)$this->id_tool) . '
                            AND tools_histo.date_start = (select max(date_start) from ' . cb_sql_table('tools_histo') . ' where id_tool = ' . ((int)$this->id_tool) . ' )';
        } else {
            $query = /** @lang MySQL */
                'SELECT DISTINCT tools.id_tool
                            FROM ' . cb_sql_table('tools') . '
                            INNER JOIN ' . cb_sql_table('tools_status') . ' ON tools_status.id_tools_status = tools.id_tools_status
                            WHERE tools_status.language_key_title IN (\'in_progress\',\'stopping\') AND tools.id_tool = ' . ((int)$this->id_tool);
        }
        $rs = Clipbucket_db::getInstance()->_select($query);
        return !empty($rs);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getLastStart(): string
    {
        /** get all running tools */
        $query = /** @lang MySQL */
            'SELECT tools_histo.date_start
                            FROM ' . cb_sql_table('tools_histo') . '
                            WHERE tools_histo.id_tool = ' . ((int)$this->id_tool) . '
                            ORDER BY tools_histo.date_start DESC LIMIT 1';
        $rs = Clipbucket_db::getInstance()->_select($query);
        return $rs[0]['date_start'] ?? '2000-01-01 00:00:01';
    }

    public function getId()
    {
        return $this->id_tool;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function assignDefaultThumbForCollections(): void
    {
        $collections = Collection::getInstance()->getAll([
            'thumb_objectid' => true,
            'allow_children' => true
        ]);
        if (!empty($videos)) {
            $this->tasks = array_column($collections, 'collection_id');
        }
        $this->executeTool('Collection::assignDefaultThumb');
    }

    /**
     * @throws Exception
     */
    public function getTaskData($step): array
    {
        $results = Clipbucket_db::getInstance()->_select('SELECT * FROM ' . tbl('tools_tasks') . ' WHERE id_histo =' . mysql_clean($this->id_histo) . ' AND loop_index >= ' . mysql_clean($this->tasks_index) . ' LIMIT ' . $step);
        $data = [];
        foreach (array_column($results, 'data') as $result) {
            $data[] = json_decode($result, true);
        }
        return $data;
    }

    /**
     * @throws Exception
     */
    public function insertTaskData($datas)
    {
        if (empty($datas)) {
            return false;
        }
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '271')) {
            $sql_insert = 'INSERT INTO ' . tbl('tools_tasks') . ' (id_histo, loop_index, data) VALUES ';
            $inserted_values = [];
            foreach ($datas as $data) {
                $inserted_values[] = '(' . $this->id_histo . ', ' . ($this->tasks_total++) . ', \'' . json_encode($data) . '\')';
            }
            return Clipbucket_db::getInstance()->execute($sql_insert . implode(', ', $inserted_values));
        } else {
            $this->tasks = array_merge($this->tasks, $datas);
            $this->tasks_total++;
            return true;
        }
    }

    /**
     * @throws Exception
     */
    public function cleanTaskData(): void
    {
        Clipbucket_db::getInstance()->delete(tbl('tools_tasks'), ['id_histo', 'loop_index'], [$this->id_histo, $this->tasks_index]);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getLastHistoNotEndedNotRunning(): array
    {
        return Clipbucket_db::getInstance()->_select('SELECT count( DISTINCT CTLD.loop_index) as elements_total, MIN(CTLD.loop_index) as loop_index
            FROM ' . tbl('tools_histo') . ' th
            inner join ' . tbl('tools_tasks') . ' CTLD ON th.id_histo = CTLD.id_histo
            where id_tool = ' . mysql_clean($this->id_tool) . '
                and id_tools_histo_status != (SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title = \'in_progress\')
            GROUP BY (th.id_histo)'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    private function changeDataHisto(): void
    {
        Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('tools_tasks') . ' SET id_histo = ' . $this->id_histo . ' WHERE id_histo = (
        SELECT A.id_histo FROM (SELECT th.id_histo FROM ' . tbl('tools_histo') . ' th
         inner join ' . tbl('tools_tasks') . ' CTLD ON th.id_histo = CTLD.id_histo
         WHERE id_tool = ' . mysql_clean($this->id_tool) . '
                AND id_tools_histo_status != (SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title = \'in_progress\')
                AND CTLD.id_histo IS NOT NULL 
                   GROUP BY th.id_histo
        ) A )');
    }

    /**
     * @return AdminTool
     * @throws Exception
     */
    public static function getUpdateDbTool()
    {
        $db_tool = new AdminTool();
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
            $db_tool->initByCode(AdminTool::CODE_UPDATE_DATABASE_VERSION);
        } else {
            $db_tool->initById('5');
        }
        return $db_tool;
    }

    /**
     * @return AdminTool
     * @throws Exception
     */
    public static function getUpdateCoreTool()
    {
        $core_tool = new AdminTool();
        if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
            $core_tool->initByCode('update_core');
        } else {
            $core_tool->initById('11');
        }
        return $core_tool;
    }

    /**
     * @return AdminTool
     * @throws Exception
     */
    public static function getLastestToolUpdate()
    {
        $core_tool = self::getUpdateCoreTool();
        $db_toool = self::getUpdateDbTool();
        if ( $core_tool->getLastStart() > $db_toool->getLastStart() ) {
            return $core_tool;
        }
        return $db_toool;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isToolInError()
    {
        return !empty(Clipbucket_db::getInstance()->_select(
            'SELECT id_tool FROM ' . tbl('tools_histo') . ' 
        WHERE id_tools_histo_status = (SELECT id_tools_histo_status FROM ' . tbl('tools_histo_status') . ' WHERE language_key_title like \'on_error\') 
        AND id_tool = ' .mysql_clean($this->id_tool)));
    }

    /**
     * @throws Exception
     */
    public function anonymousStats()
    {
        if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '100') || config('enable_anonymous_stats') != 'yes') {
            $this->executeTool('');
            return true;
        }
        if (empty($this->tasks_total)) {
            Clipbucket_db::getInstance()->execute('TRUNCATE TABLE '.  tbl('temp_stats_data') );
            $this->tasks_total = 0;
            $this->tasks_processed = 0;
            $this->tasks = [];
            //Toutes les configurations allow_stat TRUE
            $this->insertTaskData([
                'configs',
                'count_videos',
                'count_photos',
                'count_users',
                'count_collections',
                'count_playlists',
                'count_thumbs_auto',
                'count_thumbs_manual',
                'count_posters',
                'count_backdrop',
                'count_subtitles',
                'sum_duration',
                'average_duration',
                'sum_videos_views',
                'average_videos_views',
                'sum_photos_views',
                'average_photos_views',
                'sum_channel_views',
                'average_channel_views',
                'max_video_duration',
                'max_video_views',
                'max_photo_views',
                'max_channel_views',
                'count_uploaders',
                'average_uploaders_uploads',
                'count_3d_videos',
                'count_age_restricted_videos',
                'count_age_restricted_photos',
                'count_active_plugins',
                'get_php_mysql_version',
                'get_CB_version',
                'actives_tools',
                'count_not_default_pages',
                'count_not_default_user_profil',
                'count_users_per_user_profil',
                'count_categories_per_types',
                'count_comments',
                'count_comments_per_type',
                'average_comments_per_type',
                'count_social_networks',
                'count_private_messages'
            ]);

        }
        $this->executeTool('AdminTool::fill_json_stats');

        //send json
        try {
            $curl = new \Classes\Curl('https://stats.clipbucket.fr', '');
            //get data from table
            $data =  Clipbucket_db::getInstance()->_select('SELECT value FROM '.  tbl('temp_stats_data') ) ?? [];
            $content = '';
            foreach ($data as $key => $value) {
                $is_first = ($key == 0);
                $is_last  = (($key + 1) == count($data));;


                if ($is_first) {
                    // Start the JSON object
                    $content .= '{' . substr($value['value'], 1, -1);
                } else {
                    // Prefix with comma for subsequent items
                    $content .= ',' . substr($value['value'], 1, -1);
                }

                if ($is_last) {
                    // Close the JSON object on last item
                    $content .= '}';
                }
            }
            $response = $curl->execPost('', $content );
            if (!empty($response['error'])) {
                throw new Exception($response['error']);
            }
        } catch (Exception $e) {
            $this->addLog($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function fill_json_stats($task)
    {
        switch ($task) {
            case 'configs':
                //all configs with allow_stat TRUE
                $sql = 'SELECT name, value FROM ' . tbl('config') . ' WHERE allow_stat = 1';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $flatConfig = [];
                foreach ($res ?: [] as $row) {
                    if (isset($row['name'], $row['value'])) {
                        $flatConfig[$row['name']] = $row['value'];
                    }
                }

                $value = [$task => $flatConfig];
                break;
            case 'count_videos':
                $total = Video::getInstance()->getAll(['count' => true]);
                $value = [$task => $total];
                break;
            case 'count_photos':
                $total = Photo::getInstance()->getAll(['count' => true]);
                $value = [$task => $total];
                break;
            case 'count_users':
                $total = User::getInstance()->getAll(['count' => true]);
                $value = [$task => $total];
                break;
            case 'count_collections':
                $total = Collection::getInstance()->getAll(['count' => true]);
                $value = [$task => $total];
                break;
            case 'count_playlists':
                $total = Playlist::getInstance()->getAll(['count' => true]);
                $value = [$task => $total];
                break;
            case 'count_thumbs_auto':
                $sql = 'SELECT count(DISTINCT(CONCAT( videoid, \'-\', num))) as count FROM ' . tbl('video_thumbs') . ' WHERE type = \'auto\' AND resolution = \'original\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_thumbs_manual':
                $sql = 'SELECT count(DISTINCT(CONCAT( videoid, \'-\', num))) as count FROM ' . tbl('video_thumbs') . ' WHERE type = \'custom\' AND resolution = \'original\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_posters':
                $sql = 'SELECT count(DISTINCT(CONCAT( videoid, \'-\', num))) as count FROM ' . tbl('video_thumbs') . ' WHERE type = \'poster\' AND resolution = \'original\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_backdrop':
                $sql = 'SELECT count(DISTINCT(CONCAT( videoid, \'-\', num))) as count FROM ' . tbl('video_thumbs') . ' WHERE type = \'backdrop\' AND resolution = \'original\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_subtitles':
                $sql = 'SELECT count(*) as count FROM ' . tbl('video_subtitle') . ' ';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'sum_duration':
                //Sum video duration
                $sql = 'SELECT SUM(duration) as sum FROM ' . tbl('video') . ' WHERE status = \'Successful\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['sum'] ?? 0;
                $value = [$task => $total];
                break;
            case 'average_duration':
                //average video duration (Sum duration / nb videos)
                $sql = 'SELECT SUM(duration) / count(videoid) as average FROM ' . tbl('video') . ' WHERE status = \'Successful\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['average'] ?? 0;
                $value = [$task => $total];
                break;
            case 'sum_videos_views':
                //total video views
                $sql = 'SELECT SUM(views) as sum FROM ' . tbl('video') . ' WHERE status = \'Successful\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['sum'] ?? 0;
                $value = [$task => $total];
                break;
            case 'average_videos_views':
                //average views per video
                $sql = 'SELECT SUM(views) / count(videoid) as average FROM ' . tbl('video') . ' WHERE status = \'Successful\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['average'] ?? 0;
                $value = [$task => $total];
                break;
            case 'sum_photos_views':
                //total photo views
                $sql = 'SELECT SUM(views) as sum FROM ' . tbl('photos');
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['sum'] ?? 0;
                $value = [$task => $total];
                break;
            case 'average_photos_views':
                //average views per photo
                $sql = 'SELECT SUM(views) / count(photo_id) as average FROM ' . tbl('photos');
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['average'] ?? 0;
                $value = [$task => $total];
                break;
            case 'sum_channel_views':
                //total channel views
                $sql = 'SELECT SUM(profile_hits ) as sum FROM ' . tbl('users');
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['sum'] ?? 0;
                $value = [$task => $total];
                break;
            case 'average_channel_views':
                //average views per channel
                $sql = 'SELECT SUM(profile_hits) / count(userid) as average FROM ' . tbl('users');
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['average'] ?? 0;
                $value = [$task => $total];
                break;
            case 'max_video_duration':
                //Max video duration
                $sql = 'SELECT MAX(duration) as max FROM ' . tbl('video') . ' WHERE status = \'Successful\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['max'] ?? 0;
                $value = [$task => $total];
                break;
            case 'max_video_views':
                //Max views for a video
                $sql = 'SELECT MAX(views) as max FROM ' . tbl('video') . ' WHERE status = \'Successful\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['max'] ?? 0;
                $value = [$task => $total];
                break;
            case 'max_photo_views':
                //Max views for a photo
                $sql = 'SELECT MAX(views) as max FROM ' . tbl('photos');
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['max'] ?? 0;
                $value = [$task => $total];
                break;
            case 'max_channel_views':
                //Max views for a channel
                $sql = 'SELECT MAX(profile_hits ) as max FROM ' . tbl('users');
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['max'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_uploaders':
                //number of user with at least one uploaded video
                $sql = 'SELECT count(DISTINCT (U.userid)) as count FROM  ' . tbl('video') . ' V
                INNER JOIN ' . tbl('users') . ' U ON U.userid = V.userid';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'average_uploaders_uploads':
                //average number of user with at least one uploaded video
                $sql = 'SELECT count(DISTINCT (V.videoid)) / count(DISTINCT (U.userid)) as average FROM  ' . tbl('video') . ' V
                INNER JOIN ' . tbl('users') . ' U ON U.userid = V.userid';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['average'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_3d_videos':
                //number 3D videos
                $value = [$task => Video::getInstance()->getAll(['count'=>true, 'condition'=>' fov IS NOT NULL'])];
                break;
            case 'count_age_restricted_videos':
                //count age restricted videos
                $sql = 'SELECT count(DISTINCT (videoid)) as count FROM  ' . tbl('video') . ' where age_restriction IS NOT NULL OR age_restriction != \'\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_age_restricted_photos':
                //count age restricted photos
                $sql = 'SELECT count(DISTINCT (photo_id)) as count FROM  ' . tbl('photos') . ' where age_restriction IS NOT NULL OR age_restriction != \'\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_active_plugins':
                //count acitves plugins
                $sql = 'SELECT count(DISTINCT (plugin_id)) as count FROM  ' . tbl('plugins') . ' where plugin_active = \'yes\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'get_php_mysql_version':
                //version of PHP web, PHP CLI, MySQL
                $serverMySqlVersion = getMysqlServerVersion()[0]['@@version'];
                $regex_version = '(\d+\.\d+\.\d+)';
                preg_match($regex_version, $serverMySqlVersion, $match_mysql);
                $serverMySqlVersion = $match_mysql[0] ?? false;
                $value = [
                    $task => [
                        'php_web'       => System::get_software_version('php_web', false, null, true),
                        'php_cli'       => System::get_software_version('php_cli'),
                        'mysql_version' => $serverMySqlVersion
                    ]
                ];
                break;
            case 'get_CB_version':
                //CB version & revision
                $value = [$task => Update::getInstance()->getDBVersion()];
                break;
            case 'actives_tools':
                //list of active tools with their frequency
                $sql = 'SELECT code, frequency FROM ' . tbl('tools') . ' WHERE is_disabled != TRUE';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $value = [$task => $res ?: []];
                break;
            case 'count_not_default_pages':
                //count not default pages
                $sql = 'SELECT count(DISTINCT (page_id)) as count FROM  ' . tbl('pages') . ' where delete_able != \'no\'';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $total = $res[0]['count'] ?? 0;
                $value = [$task => $total];
                break;
            case 'count_not_default_user_profil':
                //Le nombre de profils utilisateurs qui ne sont pas par défaut (hors anonyme quoi)
                $value = [
                    $task => UserLevel::getAll([
                        'count'        => true,
                        'is_origine'   => 'no',
                        'no_anonymous' => true
                    ])
                ];
                break;
            case 'count_users_per_user_profil':
                //count users per user profil
                $sql = 'SELECT ul.user_level_name, COUNT(u.userid) AS count
                    FROM ' . tbl('user_levels') . ' ul
                             LEFT JOIN ' . tbl('users') . ' u ON u.level = ul.user_level_id
                             where ul.user_level_name not like \'%Anonymous%\'
                    GROUP BY ul.user_level_id';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $value = [$task => $res ?: []];
                break;
            case 'count_categories_per_types':
                //count categories per types
                $sql = 'SELECT ct.name, COUNT(c.category_id) AS count
                    FROM ' . tbl('categories_type') . ' ct
                             LEFT JOIN ' . tbl('categories') . ' c ON ct.id_category_type = c.id_category_type
                    GROUP BY c.id_category_type';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $value = [$task => $res ?: []];
                break;
            case 'count_comments':
                //count comments
                $value = [$task => Comments::getAll(['count'=>true])];
                break;
            case 'count_comments_per_type':
                //count comments per type
                $sql = 'SELECT case 
                            when type = \'v\' then \'video\'
                            when type = \'p\' then \'photo\'
                            when type = \'cl\' then \'collection\'
                            ELSE type
                        END as type
                        , count(DISTINCT comment_id) FROM ' . tbl('comments') . ' as count
                        GROUP BY type';
                $res = Clipbucket_db::getInstance()->_select($sql);
                $value = [$task => $res ?: []];
                break;
            case 'average_comments_per_type':
                //average comments per type
                $sql = 'SELECT count(DISTINCT comment_id)/count( distinct(type)) AS average FROM ' . tbl('comments') ;
                $res = Clipbucket_db::getInstance()->_select($sql);
                $value = [$task => $res[0]['average'] ?? 0];
                break;
            case 'count_social_networks':
                //count social networks links
                $sql = 'SELECT count(DISTINCT(id_social_networks_link )) as count FROM ' . tbl('social_networks_links') ;
                $res = Clipbucket_db::getInstance()->_select($sql);
                $value = [$task => $res[0]['count'] ?? 0];
                break;
            case 'count_private_messages':
                $sql = 'SELECT count(DISTINCT(message_id )) as count FROM ' . tbl('messages') . ' WHERE message_box = \'out\'' ;
                $res = Clipbucket_db::getInstance()->_select($sql);
                $value = [$task => $res[0]['count'] ?? 0];
                break;
            default:
                throw new Exception(lang('unknown_task_x', [$task]));
        }
        $encoded = json_encode($value);
        $this->addLog($encoded);
        $sql = 'INSERT INTO ' . tbl('temp_stats_data') . ' (key_name, value) VALUES (\''.$task.'\',\''.$encoded.'\' )';
        Clipbucket_db::getInstance()->execute($sql);
    }
}

