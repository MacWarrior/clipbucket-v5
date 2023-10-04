<?php

class AdminTool
{
    private static $_instance = null;
    private static $temp;

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
     * Function used to get all phrases of particular language
     *
     * @param array $condition
     * @return array
     * @throws \Exception
     */
    private static function getTools($condition = []): array
    {
        global $db;

        $where = implode(' AND ', $condition);
        $select = tbl("tools") . ' AS T
        LEFT JOIN ' . tbl("tools_status") . ' AS TT ON TT.id_tools_status = T.id_tools_status';

        return $db->select($select, 'id_tool, language_key_label, language_key_description, elements_total, elements_done, language_key_title, function_name, 
               CASE WHEN elements_total IS NULL OR elements_total = 0 THEN 0 ELSE elements_done * 100 / elements_total END AS pourcentage_progress'
            , $where
        );
    }

    /**
     * Change status of tool to 'in progress'
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public static function setToolInProgress($id): bool
    {
        global $db;
        if (empty($id)) {
            e(lang('class_error_occured'));
            return false;
        }
        $tool = self::getToolById($id);
        if (empty($tool) || $tool['language_key_title'] != 'ready') {
            e(lang('class_error_occured'));
            return false;
        }
        $db->update(tbl('tools'), ['id_tools_status'], ['|no_mc||f|(SELECT id_tools_status FROM ' . tbl('tools_status') . ' WHERE language_key_title like \'in_progress\')'], 'id_tool = ' . mysql_clean($id));
        return true;
    }

    /**
     * check if tool exist and execute the function stored in database
     * @param $id
     * @return false|void
     * @throws \Exception
     */
    public static function launch($id)
    {
        if (empty($id)) {
            e(lang('class_error_occured'));
            return false;
        }
        $tool = self::getToolById($id);
        if (empty($tool)) {
            e(lang('class_error_occured'));
            return false;
        }
        call_user_func($tool['function_name'], $id);
    }

    /**
     * return all tools
     * @return array
     * @throws \Exception
     */
    public static function getAllTools(): array
    {
        return self::getTools();
    }

    /**
     * Return an admin tool by his id
     * @param $id
     * @return array
     * @throws \Exception
     */
    public static function getToolById($id): array
    {
        return self::getTools([' id_tool = ' . mysql_clean($id)])[0];
    }

    /**
     * Find videos which don't have thumbs and generate them
     * @param $id_tool
     * @return void
     * @throws \Exception
     */
    public static function generateMissingThumbs($id_tool)
    {
        global $db;
        //get list of video without thumbs
        $videos = $db->select(tbl('video') . ' AS V LEFT JOIN ' . tbl('video_thumbs') . ' AS VT ON V.videoid = VT.videoid', 'V.*', ' 1 GROUP by videoid HAVING COUNT(VT.videoid) = 0');
        self::executeTool($id_tool, $videos, 'generatingMoreThumbs');
    }

    /**
     * check videos to change to castable status if needed
     * @param $id_tool
     * @return void
     * @throws \Exception
     */
    public static function updateCastableStatus($id_tool)
    {
        global $db;
        $videos = $db->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        self::executeTool($id_tool, $videos, 'update_castable_status');
    }

    /**
     * check videos to change to castable status if needed
     * @param $id_tool
     * @return void
     * @throws \Exception
     */
    public static function updateBitsColor($id_tool)
    {
        global $db;
        $videos = $db->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        self::executeTool($id_tool, $videos, 'update_bits_color');
    }

    /**
     * check videos duration
     * @param $id_tool
     * @return void
     * @throws \Exception
     */
    public static function updateVideoDuration($id_tool)
    {
        global $db;
        $videos = $db->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        self::executeTool($id_tool, $videos, 'update_duration');
    }
    /**
     * check videos duration which have duration at 0
     * @param $id_tool
     * @return void
     * @throws \Exception
     */
    public static function repairVideoDuration($id_tool)
    {
        global $db;
        $videos = $db->select(tbl('video'), '*', ' status LIKE \'Successful\' AND duration = 0');
        self::executeTool($id_tool, $videos, 'update_duration');
    }

    /**
     * check videos duration
     * @param $id_tool
     * @return void
     * @throws \Exception
     */
    public static function updateDataBaseVersion($id_tool)
    {
        global $db;
        $version = $db->select(tbl('version'), '*')[0];
        $folder_version = $version['version'];
        $revision = $version['revision'];

        $files = get_files_to_upgrade($folder_version, $revision);
        $installed_plugins = $db->select(tbl('plugins'), '*');
        $files = array_merge($files, get_plugins_files_to_upgrade($installed_plugins));
        if (empty($files)) {
            //update to current revision
            $sql = 'INSERT INTO ' . tbl('version') . ' SET version = \'' . mysql_clean(VERSION) . '\' , revision = ' . mysql_clean(REV) . ', id = 1 ON DUPLICATE KEY UPDATE version = \'' . mysql_clean(VERSION) . '\' , revision = ' . mysql_clean(REV);
            $db->mysqli->query($sql);
        }
        self::executeTool($id_tool, $files, 'execute_migration_SQL_file', true);
    }

    /**
     * @throws \Exception
     */
    public static function resetCache($id_tool)
    {
        self::executeTool($id_tool, ['flush'], 'CacheRedis::flushAll');
    }

    /**
     * @param $id_tool
     * @return void
     * @throws \Exception
     */
    public static function resetVideoLog($id_tool)
    {
        $logs = rglob(LOGS_DIR . DIRECTORY_SEPARATOR . '*.log');

        global $db;
        $logs_sql = array_map(function ($log) {
            return '\'' . mysql_clean(basename($log, '.log')) . '\'';
        }, $logs);
        $query = 'SELECT file_name, status, file_directory FROM ' . tbl('video') . ' WHERE file_name IN (' . implode(', ', $logs_sql) . ')';
        $result = $db->execute($query, 'select');
        $videos = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $videos[$row['file_name']] = $row;
            }
            $result->close();
        }
        self::$temp = $videos;
        self::executeTool($id_tool, $logs, 'reset_video_log');
    }

    /**
     * @param $id_tool
     * @return void
     * @throws \Exception
     */
    public static function cleanOrphanFiles($id_tool)
    {
        global $db;
        $video_file_name = [];
        $photo_file_name = [];
        $logs = rglob(LOGS_DIR . DIRECTORY_SEPARATOR . '*.log');
        $videos_mp4 = rglob(VIDEOS_DIR . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.mp4');
        $photos = rglob(PHOTOS_DIR . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*');
        $videos_hls = glob(VIDEOS_DIR . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        $thumbs = rglob(THUMBS_DIR . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.jpg');
        $subtitles = rglob(SUBTITLES_DIR . DIRECTORY_SEPARATOR . '[0-9]*' . DIRECTORY_SEPARATOR . '*.srt');

        $files = array_merge(
            array_map(function ($log) use (&$video_file_name) {
                $vid_file_name = basename($log, '.log');
                $video_file_name[] = $vid_file_name;
                return ['type' => 'log', 'data' => $log, 'video' => $vid_file_name];
            }, $logs),
            array_map(function ($thumb) use (&$video_file_name) {
                $vid_file_name = explode('-', basename($thumb, '.jpg'))[0];
                $video_file_name[] = $vid_file_name;
                return ['type' => 'thumb', 'data' => $thumb, 'video' => $vid_file_name];
            }, $thumbs),
            array_map(function ($subtitle) use (&$video_file_name) {
                $vid_file_name = explode('-', basename($subtitle, '.srt'))[0];
                $video_file_name[] = $vid_file_name;
                return ['type' => 'subtitle', 'data' => $subtitle, 'video' => $vid_file_name];
            }, $subtitles),
            array_map(function ($video) use (&$video_file_name) {
                $vid_file_name = explode('-', basename($video, '.mp4'))[0];
                $video_file_name[] = $vid_file_name;
                return ['type' => 'video_mp', 'data' => $video, 'video' => $vid_file_name];
            }, $videos_mp4),
            array_map(function ($photo) use (&$photo_file_name) {
                $pic_file_name = explode('_', pathinfo($photo)['filename'])[0];
                $photo_file_name[] = $pic_file_name;
                return ['type' => 'photo', 'data' => $photo, 'photo' => $pic_file_name];
            }, $photos),
            array_map(function ($video) use (&$video_file_name) {
                $vid_file_name = basename($video);
                $video_file_name[] = $vid_file_name;
                return ['type' => 'video_hls', 'data' => $video, 'video' => $vid_file_name];
            }, $videos_hls)
        );
        $sql_video_file_name = array_map(function ($video_file_name) {
            return '\'' . mysql_clean($video_file_name) . '\'';
        }, array_unique($video_file_name));
        $sql_photo_file_name = array_map(function ($photo_file_name) {
            return '\'' . mysql_clean($photo_file_name) . '\'';
        }, array_unique($photo_file_name));

        $query = 'SELECT file_name FROM ' . tbl('video') . ' WHERE file_name IN (' . implode(', ', $sql_video_file_name) . ')';
        $result = $db->execute($query, 'select');
        $data['video'] = [];
        $data['photo'] = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data['video'][] = $row['file_name'];
            }
            $result->close();
        }
        $query = 'SELECT filename FROM ' . tbl('photos') . ' WHERE filename IN (' . implode(', ', $sql_photo_file_name) . ')';
        $result = $db->execute($query, 'select');
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data['photo'][] = $row['filename'];
            }
            $result->close();
        }
        self::$temp = $data;
        self::executeTool($id_tool, $files, 'clean_orphan_files');
        //remove already empty folders
        $empty_logs = glob(LOGS_DIR . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        $empty_subs = glob(SUBTITLES_DIR . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        $empty_thumbs = glob(THUMBS_DIR . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        $empty_vids = glob(VIDEOS_DIR . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        $empty_pics = glob(PHOTOS_DIR . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        $empty_folders = array_merge($empty_logs, $empty_subs, $empty_thumbs, $empty_vids, $empty_pics);
        foreach ($empty_folders as $folder) {
            delete_empty_directories($folder);
        }

    }

    /**
     * @param $id_tool
     * @return void
     * @throws Exception
     */
    private static function cleanOrphanTags($id_tool)
    {
        global $db;
        $query = '
            SELECT T.* FROM '.tbl('tags').' T
            LEFT JOIN '.tbl('video_tags').' VT ON T.id_tag = VT.id_tag
            LEFT JOIN '.tbl('photo_tags').' PT ON T.id_tag = PT.id_tag
            LEFT JOIN '.tbl('collection_tags').' CT ON T.id_tag = CT.id_tag
            LEFT JOIN '.tbl('playlist_tags').' PLT ON T.id_tag = PLT.id_tag
            LEFT JOIN '.tbl('user_tags').' UT ON T.id_tag = UT.id_tag
            WHERE 1
            GROUP BY T.id_tag
            HAVING COUNT(VT.id_tag) = 0 AND COUNT(PT.id_tag) = 0 AND COUNT(CT.id_tag) = 0 AND COUNT(PLT.id_tag) = 0 AND COUNT(UT.id_tag) = 0;';
        $tags = $db->_select($query);
        $tags = array_map(function ($tag) {
            return $tag['id_tag'];
        }, $tags);
        self::executeTool($id_tool, $tags, 'Tags::deleteTag');
    }

    /**
     * @param $id_tool
     * @param $array
     * @param $function
     * @param $stop_on_error
     * @return void
     * @throws \Exception
     */
    private static function executeTool($id_tool, $array, $function, $stop_on_error = false)
    {
        global $db;
        //optimisation to call mysql_clean only once
        $secureIdTool = mysql_clean($id_tool);
        //get list of video
        if (!empty($array)) {
            //update nb_elements of tools
            $db->update(tbl('tools'), ['elements_total', 'elements_done'], [count($array), 0], ' id_tool = ' . $secureIdTool);
            $nb_done = 0;
            foreach ($array as $item) {
                //check if user request stop
                $has_to_stop = $db->select(tbl('tools') . ' AS T INNER JOIN ' . tbl('tools_status') . ' AS TS ON T.id_tools_status = TS.id_tools_status', 'TS.id_tools_status', 'T.id_tool = ' . $secureIdTool . ' AND TS.language_key_title like \'stopping\'');
                if (!empty($has_to_stop)) {
                    break;
                }
                //call function
                try {
                    call_user_func($function, $item);
                } catch (\Exception $e) {
                    e(lang($e->getMessage()));
                    if ($stop_on_error) {
                        break;
                    }
                }
                //update nb_done of tools
                $nb_done++;
                $db->update(tbl('tools'), ['elements_done'], [$nb_done], ' id_tool = ' . $secureIdTool);
            }
        }
        $db->update(tbl('tools'), ['id_tools_status', 'elements_total', 'elements_done'], [1, '|f|null', '|f|null'], 'id_tool = ' . $secureIdTool);
    }

    /**
     * Set status to false in order to stop function execution at the next iteration
     * @param $id_tool
     * @return false|void
     * @throws \Exception
     */
    public static function stop($id_tool)
    {
        global $db;
        if (empty($id_tool)) {
            e(lang('class_error_occured'));
            return false;
        }
        $tool = self::getToolById($id_tool);
        if (empty($tool)) {
            e(lang('class_error_occured'));
            return false;
        }
        if ($tool['language_key_title'] != 'in_progress') {
            return false;
        }
        $db->update(tbl('tools'), ['id_tools_status'], ['|no_mc||f|(SELECT id_tools_status FROM ' . tbl('tools_status') . ' WHERE language_key_title like \'stopping\')'], ' id_tool = ' . mysql_clean($id_tool));
    }

    /**
     * @return mixed
     */
    public static function getTemp()
    {
        return self::$temp;
    }

}
