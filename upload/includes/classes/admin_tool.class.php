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
     * @param null $language_id
     * @param string $fields
     * @param null $limit
     * @param null $extra_param
     *
     * @return array
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
     */
    public static function setToolInProgress($id)
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
     */
    public static function getAllTools(): array
    {
        return self::getTools();
    }

    /**
     * Return an admin tool by his id
     * @param $id
     * @return array
     */
    public static function getToolById($id): array
    {
        return self::getTools([' id_tool = ' . mysql_clean($id)])[0];
    }

    /**
     * Send respond to execute ajax return and continue execution
     * @param $callback
     */
    public static function sendClientResponseAndContinue($callback, $ajax = true)
    {
        ob_end_clean();
        ignore_user_abort(true);

        ob_start();

        header("Connection: close\r\n");
        header("Content-Encoding: none\r\n");

        $callback();

        $size = ob_get_length();
        header("Content-Length: $size");

        // Flush all output.
        ob_end_flush();
        ob_flush();
        flush();

        // Close current session (if it exists).
        if (session_id()) {
            session_write_close();
        }
        if ($ajax) {
            fastcgi_finish_request();
        }
    }

    /**
     * Find videos which don't have thumbs and generate them
     * @param $id_tool
     * @return void
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
     */
    public static function updateVideoDuration($id_tool)
    {
        global $db;
        $videos = $db->select(tbl('video'), '*', ' status LIKE \'Successful\'');
        self::executeTool($id_tool, $videos, 'update_duration');
    }

    /**
     * check videos duration
     * @param $id_tool
     * @return void
     */
    public static function updateDataBaseVersion($id_tool)
    {
        global $db;
        $version = $db->select(tbl('version'), '*')[0];
        $folder_version = $version['version'];
        $revision = $version['revision'];

        $files = get_files_to_upgrade($folder_version, $revision);
        if (empty($files)) {
            //update to current revision
            $sql = 'INSERT INTO ' . tbl('version') . ' SET version = \'' . mysql_clean(VERSION) . '\' , revision = ' . mysql_clean(REV) . ', id = 1 ON DUPLICATE KEY UPDATE version = \'' . mysql_clean(VERSION) . '\' , revision = ' . mysql_clean(REV);
            $db->mysqli->query($sql);
        }
        self::executeTool($id_tool, $files, 'execute_migration_SQL_file', true);
    }

    public static function resetCache($id_tool)
    {
        self::executeTool($id_tool, ['flush'], 'CacheRedis::flushAll');
    }

    /**
     * @param $id_tool
     * @return void
     */
    public static function resetVideoLog($id_tool)
    {
        $logs = rglob(LOGS_DIR . DIRECTORY_SEPARATOR . '*.log');
        global $db;
        $logs_sql = array_map(function ($log) {
            return  '\''. mysql_clean(basename($log, '.log')).'\'' ;
        },$logs);
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
     * @param $array
     * @param $function
     * @param $stop_on_error
     * @return void
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
                } catch (Exception $e) {
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
