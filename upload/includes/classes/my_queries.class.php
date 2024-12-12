<?php
class myquery
{
    static $website_details = [];
    static $video_resolutions = [];

    public static function getInstance(){
        global $myquery;
        return $myquery;
    }

    /**
     * @throws Exception
     */
    function Set_Website_Details($name, $value)
    {
        Clipbucket_db::getInstance()->update(tbl('config'), ['value'], [$value], " name = '" . $name . "'");
        ClipBucket::getInstance()->configs[$name] = $value;
        static::$website_details[$name] = $value;
    }

    /**
     * @throws Exception
     */
    function Get_Website_Details(): array
    {
        if (!empty(static::$website_details)) {
            return static::$website_details;
        }

        $query = 'SELECT * FROM ' . tbl('config');
        $data = db_select($query);

        if ($data) {
            global $config_overwrite;
            foreach ($data as $row) {
                $name = $row['name'];
                if (isset($config_overwrite, $config_overwrite[$name])) {
                    $data[$name] = $config_overwrite[$name];
                } else {
                    $data[$name] = $row['value'];
                }
            }
        }
        static::$website_details = $data;
        return $data;
    }

    /**
     * @throws Exception
     */
    public function getVideoResolutions(): array
    {
        if (!empty(static::$video_resolutions)) {
            return static::$video_resolutions;
        }

        $sql_select = 'SELECT title, ratio, enabled, width, height, video_bitrate FROM ' . tbl('video_resolution') . ' ORDER BY ratio, height DESC';
        $results = db_select($sql_select);

        static::$video_resolutions = [];
        foreach ($results as $line) {
            if (!isset(static::$video_resolutions[$line['ratio']])) {
                static::$video_resolutions[$line['ratio']] = [];
            }
            static::$video_resolutions[$line['ratio']][] = $line;
        }

        return static::$video_resolutions;
    }

    /**
     * @throws Exception
     */
    public function saveVideoResolutions($post)
    {
        $video_resolutions = self::getVideoResolutions();
        foreach ($video_resolutions as $ratio) {
            foreach ($ratio as $resolution) {

                if (isset($post['gen_' . $resolution['title']])) {
                    $post_value = $post['gen_' . $resolution['title']];
                    $enabled = $post_value == 'yes' ? 1 : 0;
                } else {
                    $enabled = 0;
                }

                if (isset($post['vbrate_' . $resolution['title']])) {
                    $vbrate = $post['vbrate_' . $resolution['title']];
                } else {
                    $vbrate = 0;
                }

                Clipbucket_db::getInstance()->update(tbl('video_resolution'), ['enabled', 'video_bitrate'], [$enabled, $vbrate], ' title = \'' . mysql_clean($resolution['title']) . '\'');
            }
        }
        static::$video_resolutions = [];
    }

    /**
     * @throws Exception
     */
    public function getEnabledVideoResolutions(string $orderby = ''): array
    {
        $sql_select = 'SELECT height, width FROM ' . tbl('video_resolution') . ' WHERE enabled = 1';
        if ($orderby != '') {
            $sql_select .= ' ORDER BY ' . $orderby;
        }
        $results = db_select($sql_select);

        $data = [];
        foreach ($results as $line) {
            $data[$line['height']] = $line['width'];
        }
        return $data;
    }

    /**
     * @throws Exception
     */
    public function getVideoResolutionBitrateFromHeight($height): int
    {
        $sql_select = 'SELECT video_bitrate FROM ' . tbl('video_resolution') . ' WHERE height = \'' . mysql_clean($height) . '\'';
        $results = db_select($sql_select);

        if (empty($results)) {
            return 0;
        }
        return $results[0]['video_bitrate'];
    }

    /**
     * @throws Exception
     */
    public function getVideoResolutionTitleFromHeight($height): string
    {
        if ($height == 'index') {
            return lang('video_resolution_auto');
        }

        if( !is_numeric($height) ){
            return strtoupper($height);
        }

        $sql_select = 'SELECT title FROM ' . tbl('video_resolution') . ' WHERE height = \'' . mysql_clean($height) . '\'';
        $results = db_select($sql_select);

        if (empty($results)) {
            return 0;
        }

        return $results[0]['title'];
    }

    /**
     * @throws Exception
     */
    function video_exists($videoid)
    {
        global $cbvid;
        return $cbvid->video_exists($videoid);
    }

    /**
     * Function used to get video details
     * from video table
     *
     * @param INPUT vid or videokey
     *
     * @return bool|mixed|STRING
     * @throws Exception
     */
    function get_video_details($vid)
    {
        global $cbvid;
        return $cbvid->get_video($vid);
    }

    /**
     * Function used to check weather username exists not
     * @throws Exception
     */
    function check_user($username)
    {
        return userquery::getInstance()->username_exists($username);
    }

    /**
     * Function used to check weather email exists not
     * @throws Exception
     */
    function check_email($email)
    {
        return userquery::getInstance()->email_exists($email);
    }

    /**
     * Function used to  get file details from database
     * @throws Exception
     */
    function file_details($file_name)
    {
        return get_file_details($file_name);
    }

    /**
     * Function used to update video and set a thumb as default
     *
     * @param $vid
     * @param $thumb
     *
     * @return void
     * @throws Exception
     */
    function set_default_thumb($vid, $thumb)
    {
        global $cbvid;
        $cbvid->set_default_thumb($vid, $thumb);
    }

    /**
     * Function used to update video
     */
    function update_video()
    {
        global $cbvid;
        return $cbvid->update_video();
    }

    /**
     * Function used to set website template
     * @throws Exception
     */
    function set_template($template)
    {
        global $myquery;
        if (is_dir(DirPath::get('styles') . $template) && $template) {
            $myquery->Set_Website_Details('template_dir', $template);
            e(lang('template_activated'), 'm');
        } else {
            e(lang('error_occured_changing_template'));
        }
    }

    /**
     * @throws Exception
     * @used-by index.html
     */
    function get_todos(): array
    {
        return Clipbucket_db::getInstance()->select(tbl('admin_todo'), '*', ' userid=\'' . user_id() . '\'', null, ' date_added DESC ');
    }

    /**
     * @throws Exception
     */
    function insert_todo($text)
    {
        Clipbucket_db::getInstance()->insert(tbl('admin_todo'), ['todo,date_added,userid'], [mysql_clean($text), NOW(), user_id()]);
    }

    /**
     * @throws Exception
     */
    function delete_todo($id)
    {
        Clipbucket_db::getInstance()->delete(tbl('admin_todo'), ['todo_id'], [$id]);
    }

    /**
     * Function used to insert note in data base for admin referance
     * @throws Exception
     */
    function insert_note($note)
    {
        Clipbucket_db::getInstance()->insert(tbl('admin_notes'), ['note,date_added,userid'], [$note, now(), user_id()]);
    }

    /**
     * Function used to get notes
     * @throws Exception
     */
    function get_notes(): array
    {
        return Clipbucket_db::getInstance()->select(tbl('admin_notes'), '*', ' userid=\'' . user_id() . '\'', null, ' date_added DESC ');
    }

    /**
     * Function usde to delete note
     * @throws Exception
     */
    function delete_note($id)
    {
        Clipbucket_db::getInstance()->delete(tbl('admin_notes'), ['note_id'], [$id]);
    }

    /**
     * Function used to check weather object is commentable or not
     */
    function is_commentable($obj, $type)
    {
        switch ($type) {
            case 'video':
            case 'v':
            case 'vdo':
            case 'videos':
            case 'vid':
                if ($obj['allow_comments'] == 'yes' && config('enable_comments_video') == 'yes') {
                    return true;
                }
                break;

            case 'channel':
            case 'user':
            case 'users':
            case 'u':
            case 'c':
                if ($obj['allow_comments'] == 'yes' && config('enable_comments_channel') == 'yes') {
                    return true;
                }
                break;

            case 'collection':
            case 'collect':
            case 'cl':
                if ($obj['allow_comments'] == 'yes') {
                    return true;
                }
                break;

            case 'photo':
            case 'p':
            case 'photos':
                if ($obj['allow_comments'] == 'yes' && config('enable_comments_photo') == 'yes') {
                    return true;
                }
        }
        return false;
    }

    /**
     * Function used to get list of items in conversion queue
     * @params $Cond, $limit,$order
     *
     * @param null $cond
     * @param null $limit
     * @param string $order
     *
     * @return array|bool
     * @throws Exception
     */
    function get_conversion_queue($cond = null, $limit = null, $order = 'date_added DESC')
    {
        $result = Clipbucket_db::getInstance()->select(tbl('conversion_queue'), '*', $cond, $limit, $order);
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * function used to remove queue
     *
     * @param $action
     * @param $id
     * @throws Exception
     */
    function queue_action($action, $id)
    {
        switch ($action) {
            case 'delete':
                Clipbucket_db::getInstance()->execute('DELETE FROM ' . tbl('conversion_queue') . ' WHERE cqueue_id =\'' . mysql_clean($id) . '\'');
                break;
            case 'processed':
                Clipbucket_db::getInstance()->update(tbl('conversion_queue'), ['cqueue_conversion'], ['yes'], 'cqueue_id =\'' . mysql_clean($id) . '\'');
                break;
            case 'pending':
                Clipbucket_db::getInstance()->update(tbl('conversion_queue'), ['cqueue_conversion'], ['no'], 'cqueue_id =\'' . mysql_clean($id) . '\'');
                break;
        }
    }
}
