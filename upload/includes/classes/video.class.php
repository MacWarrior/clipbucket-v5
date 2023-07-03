<?php
define('QUICK_LIST_SESS', 'quick_list');

class CBvideo extends CBCategory
{
    var $embed_func_list = []; //Function list that are applied while asking for video embed code
    var $action = ''; // variable used to call action class
    var $collection = '';
    var $email_template_vars = [];

    var $dbtbl = ['video' => 'video'];

    var $video_manager_funcs = [];

    var $video_delete_functions = []; //Holds all delete functions of video

    private $basic_fields = [];
    private $extra_fields = [];

    /**
     * __Constructor of CBVideo
     */
    function init()
    {
        global $Cbucket, $cb_columns;
        $this->cat_tbl = 'video_categories';
        $this->section_tbl = 'video';
        $this->use_sub_cats = true;
        $this->init_actions();
        $this->init_collections();
        $this->init_admin_menu();

        if (config('vid_cat_height')) {
            $this->cat_thumb_height = config('vid_cat_height');
        }
        if (config('vid_cat_width')) {
            $this->cat_thumb_width = config('vid_cat_width');
        }

        if (isSectionEnabled('videos')) {
            $Cbucket->search_types['videos'] = 'cbvid';
        }

        $this->video_delete_functions[] = 'delete_video_from_collection';

        $basic_fields = $this->basic_fields_setup();

        $cb_columns->object('videos')->register_columns($basic_fields);
    }

    function init_admin_menu()
    {
        global $Cbucket, $userquery;
        $per = $userquery->get_user_level(userid());

        if ($per['video_moderation'] == 'yes' && isSectionEnabled('videos')) {
            $menu_video = [
                'title'   => lang('videos')
                , 'class' => 'glyphicon glyphicon-facetime-video'
                , 'sub'   => [
                    [
                        'title' => lang('videos_manager')
                        , 'url' => ADMIN_BASEURL . '/video_manager.php'
                    ]
                    , [
                        'title' => lang('manage_playlists')
                        , 'url' => ADMIN_BASEURL . '/manage_playlist.php'
                    ]
                    , [
                        'title' => lang('manage_categories')
                        , 'url' => ADMIN_BASEURL . '/category.php'
                    ]
                    , [
                        'title' => 'List Flagged Videos'
                        , 'url' => ADMIN_BASEURL . '/flagged_videos.php'
                    ]
                    , [
                        'title' => 'Mass Upload Videos'
                        , 'url' => ADMIN_BASEURL . '/mass_uploader.php'
                    ]
                    , [
                        'title' => 'List Inactive Videos'
                        , 'url' => ADMIN_BASEURL . '/video_manager.php?search=search&active=no'
                    ]
                    , [
                        'title' => 'Notification settings'
                        , 'url' => ADMIN_BASEURL . '/notification_settings.php'
                    ]
                ]
            ];

            $Cbucket->addMenuAdmin($menu_video, 70);
        }
    }

    /**
     * @return array
     */
    function get_basic_fields()
    {
        return $this->basic_fields;
    }

    function set_basic_fields($fields = [])
    {
        return $this->basic_fields = $fields;
    }

    function basic_fields_setup(): array
    {
        # Set basic video fields
        $basic_fields = [
            'videoid', 'videokey', 'userid', 'title', 'server_ip', 'description', 'tags', 'category', 'file_directory',
            'active', 'date_added', 'broadcast', 'rating', 'file_server_path', 'files_thumbs_path',
            'duration', 'views', 'file_name', 'rated_by', 'file_type', 'bits_color', 'is_castable',
            'default_thumb', 'comments_count', 'last_viewed', 'featured', 'featured_date', 'status', 're_conv_status', 'embed_code'
        ];

        return $this->set_basic_fields($basic_fields);
    }

    function get_extra_fields()
    {
        return $this->extra_fields;
    }

    /**
     * Initiating Collections
     */
    function init_collections()
    {
        $this->collection = new Collections();
        $this->collection->objType = 'v';
        $this->collection->objClass = 'cbvideo';
        $this->collection->objTable = 'video';
        $this->collection->objName = 'Video';
        $this->collection->objFunction = 'video_exists';
        $this->collection->objFieldID = 'videoid';
    }

    /**
     * Function used to check weather video exists or not
     *
     * @param int|string VID or VKEY
     *
     * @return bool
     */
    function video_exists($vid)
    {
        global $db;
        if (is_numeric($vid)) {
            return $db->count(tbl('video'), 'videoid', ' videoid=\'' . $vid . '\' ');
        }
        return $db->count(tbl('video'), 'videoid', ' videokey=\'' . mysql_clean($vid) . '\' ');
    }

    function exists($vid)
    {
        return $this->video_exists($vid);
    }

    /**
     * Function used to get video data
     *
     * @param      $vid
     * @param bool $file
     * @param bool $basic
     *
     * @return bool|mixed|STRING
     */
    function get_video($vid, $file = false, $basic = false)
    {
        $vid = mysql_clean($vid);

        $userFields = get_user_fields();
        $videoFields = ['video' => '*'];

        if ($basic === true) {
            $videoFields = get_video_fields();
        }

        $fields = [
            'video' => $videoFields,
            'users' => $userFields
        ];

        $cond = (($file) ? 'video.file_name' : (is_numeric($vid) ? 'video.videoid' : 'video.videokey')) . ' = \'%s\' ';

        $query = 'SELECT ' . tbl_fields($fields) . ' FROM ' . cb_sql_table('video');
        $query .= ' LEFT JOIN ' . cb_sql_table('users') . ' ON video.userid = users.userid';

        if ($cond) {
            $query .= ' WHERE ' . sprintf($cond, $vid);
        }

        $query .= 'LIMIT 1';
        $query_id = cb_query_id($query);

        $data = cb_do_action('select_video', ['query_id' => $query_id, 'videoid' => $vid]);

        if ($data) {
            return $data;
        }

        $result = select($query);

        if ($result) {
            $result = apply_filters($result[0], 'get_video');

            cb_do_action('return_video', [
                'query_id'  => $query_id,
                'results'   => $result,
                'object_id' => $vid,
                'videoid'   => $vid
            ]);

            return $result;
        }
        return false;
    }

    function getvideo($vid)
    {
        return $this->get_video($vid);
    }

    function get_video_details($vid)
    {
        return $this->get_video($vid);
    }

    /**
     * Function used to perform several actions with a video
     *
     * @param $case
     * @param $vid
     *
     * @return bool|string|void
     * @throws phpmailerException
     */
    function action($case, $vid)
    {
        global $db;

        $video = $this->get_video_details($vid);

        if (!$video) {
            return false;
        }

        //Let's just check weather video exists or not
        switch ($case) {
            //Activating a video
            case 'activate':
            case 'av':
            case 'a':
                $db->update(tbl('video'), ['active'], ['yes'], ' videoid=\'' . mysql_clean($vid) . '\' OR videokey = \'' . mysql_clean($vid) . '\' ');
                e(lang('class_vdo_act_msg'), 'm');

                if (SEND_VID_APPROVE_EMAIL == 'yes') {
                    //Sending Email
                    global $cbemail;
                    $tpl = $cbemail->get_template('video_activation_email');
                    $var = [
                        '{username}'   => $video['username'],
                        '{video_link}' => videoLink($video)
                    ];
                    $subj = $cbemail->replace($tpl['email_template_subject'], $var);
                    $msg = nl2br($cbemail->replace($tpl['email_template'], $var));

                    if ($video['email'] != 'admin@thiswebsite.com') {
                        //Now Finally Sending Email
                        cbmail([
                            'to'        => $video['email']
                            , 'from'    => WEBSITE_EMAIL
                            , 'subject' => $subj
                            , 'content' => $msg
                        ]);
                    }
                }

                if (($video['broadcast'] == 'public' || $video['broadcast'] == 'logged') && $video['subscription_email'] == 'pending') {
                    //Sending Subscription email in background
                    if (stristr(PHP_OS, 'WIN')) {
                        exec(php_path() . ' -q ' . BASEDIR . '/actions/send_subscription_email.php ' . $vid);
                    } else {
                        exec(php_path() . ' -q ' . BASEDIR . '/actions/send_subscription_email.php ' . $vid . ' &> /dev/null &');
                    }
                }
                break;

            //Deactivating a video
            case 'deactivate':
            case 'dav':
            case 'd':
                $db->update(tbl('video'), ['active'], ['no'], ' videoid=\'' . mysql_clean($vid) . '\' OR videokey = \'' . mysql_clean($vid) . '\' ');
                e(lang('class_vdo_act_msg1'), 'm');
                break;

            //Featuring Video
            case 'feature':
            case 'featured':
            case 'f':
                $db->update(tbl('video'), ['featured', 'featured_date'], ['yes', now()], ' videoid=\'' . mysql_clean($vid) . '\' OR videokey = \'' . mysql_clean($vid) . '\' ');
                e(lang('class_vdo_fr_msg'), 'm');
                return 'featured';

            // Unfeatured video
            case 'unfeature':
            case 'unfeatured':
            case 'uf':
                $db->update(tbl('video'), ['featured'], ['no'], ' videoid=\'' . mysql_clean($vid) . '\' OR videokey = \'' . mysql_clean($vid) . '\' ');
                e(lang('class_fr_msg1'), 'm');
                break;

            case 'check_castable':
                update_castable_status($video);
                break;

            case 'update_bits_color':
                update_bits_color($video);
                break;
        }
    }

    /**
     * Function used to update video
     *
     * @param null $array
     */
    function update_video($array = null)
    {
        global $eh, $db, $Upload;

        $Upload->validate_video_upload_form(null, true);

        if (empty($eh->get_error())) {
            $required_fields = $Upload->loadRequiredFields($array);
            $location_fields = $Upload->loadLocationFields($array);
            $option_fields = $Upload->loadOptionFields($array);

            $upload_fields = array_merge($required_fields, $location_fields, $option_fields);

            //Adding Custom Upload Fields
            if (function_exists('custom_fields_list')) {
                $custom_flds = $Upload->load_custom_form_fields($array, true);
                $upload_fields = array_merge($upload_fields, $custom_flds);
            }

            if (!$array) {
                $array = $_POST;
            }

            if (isset($array['videoid'])) {
                $vid = $array['videoid'];
            } else {
                if (isset($array['file_name'])) {
                    $params = [
                        'filename' => $array['file_name']
                        , 'user'   => userid()
                    ];
                    $video = get_videos($params);
                    if (isset($video[0])) {
                        $vid = $video[0]['videoid'];
                    } else {
                        $vid = null;
                    }
                }
            }

            if (is_array($_FILES)) {
                $array = array_merge($array, $_FILES);
            }

            foreach ($upload_fields as $field) {
                $name = formObj::rmBrackets($field['name']);
                $val = $array[$name];

                if (!empty($val) || !$field['use_if_value']) {
                    if ($field['use_func_val']) {
                        $val = $field['validate_function']($val);
                    }

                    if (!empty($field['db_field'])) {
                        $query_field[] = $field['db_field'];
                    }

                    if (is_array($val)) {
                        $new_val = '';
                        foreach ($val as $v) {
                            $new_val .= '#' . $v . '# ';
                        }
                        $val = $new_val;
                    }
                    if (!$field['clean_func'] || (!apply_func($field['clean_func'], $val) && !is_array($field['clean_func']))) {
                        $val = ($val);
                    } else {
                        $val = apply_func($field['clean_func'], mysql_clean('|no_mc|' . $val));
                    }

                    if (!empty($field['db_field'])) {
                        $query_val[] = $val;
                    }
                }
            }

            if (has_access('admin_access', true)) {
                if (!empty($array['status'])) {
                    $query_field[] = 'status';
                    $query_val[] = $array['status'];
                }

                if (!empty($array['duration']) && is_numeric($array['duration']) && $array['duration'] > 0) {
                    $query_field[] = 'duration';
                    $query_val[] = $array['duration'];
                }

                if (!empty($array['views'])) {
                    $query_field[] = 'views';
                    $query_val[] = $array['views'];
                }

                if (!empty($array['video_users'])) {
                    $query_field[] = 'video_users';
                    $query_val[] = $array['video_users'];
                }

                if (!empty($array['rating'])) {
                    $query_field[] = 'rating';
                    $rating = $array['rating'];
                    if (!is_numeric($rating) || $rating < 0 || $rating > 10) {
                        $rating = 1;
                    }
                    $query_val[] = $rating;
                }

                if (!empty($array['rated_by'])) {
                    $query_field[] = 'rated_by';
                    $query_val[] = $array['rated_by'];
                }

                if (!empty($array['embed_code'])) {
                    $query_field[] = 'embed_code';
                    $query_val[] = $array['embed_code'];
                }
            }
            //changes made
            //title index
            $query_val[0] = str_replace('&lt;!--', '', $query_val[0]);
            $query_val[0] = str_replace('\'', '’', $query_val[0]);
            //description index
            $query_val[1] = str_replace('&lt;!--', '', $query_val[1]);
            $query_val[1] = str_replace('\'', '’', $query_val[1]);
            //Tag index
            $query_val[3] = strtolower($query_val[3]);

            if (!userid()) {
                e(lang('you_dont_have_permission_to_update_this_video'));
            } elseif (!$this->video_exists($vid)) {
                e(lang('class_vdo_del_err'));
            } elseif (!$this->is_video_owner($vid, userid()) && !has_access('admin_access', true)) {
                e(lang('no_edit_video'));
            } elseif (strlen($array['title']) > 100) {
                e(lang('Title exceeds max length of 100 characters')); // TODO : Translation
            } else {
                $db->update(tbl('video'), $query_field, $query_val, ' videoid=\'' . $vid . '\'');

                cb_do_action('update_video', [
                    'object_id' => $vid,
                    'results'   => $array
                ]);

                e(lang('class_vdo_update_msg'), 'm');

                // condition for Clip press plugin
                if (function_exists('post_to_wp_upload_culr')) {
                    post_to_wp_upload_culr($vid);
                }
            }

        }
    }

    /**
     * Function used to delete a video
     *
     * @param $vid
     */
    function delete_video($vid)
    {
        global $db;

        if ($this->video_exists($vid)) {
            $vdetails = $this->get_video($vid);

            if ($this->is_video_owner($vid, userid()) || has_access('admin_access', true)) {
                #THIS SHOULD NOT BE REMOVED :O
                //list of functions to perform while deleting a video
                $del_vid_funcs = $this->video_delete_functions;

                if (is_array($del_vid_funcs)) {
                    foreach ($del_vid_funcs as $func) {
                        if (function_exists($func)) {
                            $func($vdetails);
                        }
                    }
                }

                //Finally Removing Database entry of video
                $db->execute('DELETE FROM ' . tbl('video') . ' WHERE videoid=\'' . mysql_clean($vid) . '\'');
                //Removing Video From Playlist
                $db->execute('DELETE FROM ' . tbl('playlist_items') . ' WHERE object_id=\'' . mysql_clean($vid) . '\' AND playlist_item_type=\'v\'');

                $db->update(tbl('users'), ['total_videos'], ['|f|total_videos-1'], ' userid=\'' . $vdetails['userid'] . '\'');

                //Removing video Comments
                $db->delete(tbl('comments'), ['type', 'type_id'], ['v', $vdetails['videoid']]);
                //Removing video From Favorites
                $db->delete(tbl('favorites'), ['type', 'id'], ['v', $vdetails['videoid']]);

                e(lang('class_vdo_del_msg'), 'm');
            } else {
                e(lang('You cannot delete this video'));
            }
        } else {
            e(lang('class_vdo_del_err'));
        }
    }

    /**
     * Function used to remove video thumbs
     *
     * @param $vdetails
     */
    function remove_thumbs($vdetails)
    {
        global $db;
        //delete olds thumbs from db and on disk
        $db->delete(tbl('video_thumbs'), ['videoid'], [$vdetails['videoid']]);
        $pattern = THUMBS_DIR . DIRECTORY_SEPARATOR . $vdetails['file_directory'] . DIRECTORY_SEPARATOR . $vdetails['file_name'] . '*';
        $glob = glob($pattern);
        foreach ($glob as $thumb) {
            unlink($thumb);
        }

        //reset default thumb
        $db->update(tbl('video'), ['default_thumb'], [1], ' videoid = ' . mysql_clean($vdetails['videoid']));
        e(lang('vid_thumb_removed_msg'), 'm');
    }

    /**
     * Function used to remove video log
     *
     * @param $vdetails
     */
    function remove_log($vdetails)
    {
        global $db;
        $src = $vdetails['videoid'];
        $file = LOGS_DIR . DIRECTORY_SEPARATOR . $vdetails['file_name'] . '.log';
        $db->execute('DELETE FROM ' . tbl('video_files') . ' WHERE src_name = \'' . mysql_clean($src) . '\'');
        if (file_exists($file)) {
            unlink($file);
        }
        $fn = $vdetails['file_name'];
        $result = db_select('SELECT * FROM ' . tbl('video') . ' WHERE file_name = \'' . mysql_clean($fn) . '\'');
        if ($result) {
            foreach ($result as $result1) {
                $str = DIRECTORY_SEPARATOR . $result1['file_directory'] . DIRECTORY_SEPARATOR;
                $file1 = LOGS_DIR . $str . $vdetails['file_name'] . '.log';
                if (file_exists($file1) && is_file($file1)) {
                    unlink($file1);
                }
            }
        }
        e(lang('vid_log_delete_msg'), 'm');
    }

    function remove_subtitles($vdetails)
    {
        global $db;
        $directory = SUBTITLES_DIR . DIRECTORY_SEPARATOR . $vdetails['file_directory'] . DIRECTORY_SEPARATOR;
        $result = db_select('SELECT * FROM ' . tbl('video_subtitle') . ' WHERE videoid = ' . $vdetails['videoid']);
        if ($result) {
            foreach ($result as $row) {
                $filepath = $directory . $vdetails['file_name'] . '-' . $row['number'] . '.srt';
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            $db->execute('DELETE FROM ' . tbl('video_subtitle') . ' WHERE videoid = ' . $vdetails['videoid']);
        }

        e(lang('video_subtitles_deleted'), 'm');
    }

    /**
     * Function used to remove video files
     *
     * @param $vdetails
     *
     * @return bool|void
     */
    function remove_files($vdetails)
    {
        //Return nothing in case there is no input
        if (!$vdetails) {
            e('No input details specified');
            return false;
        }
        //Calling Video Delete Functions
        call_delete_video_function($vdetails);

        $directory_path = VIDEOS_DIR . DIRECTORY_SEPARATOR . $vdetails['file_directory'] . DIRECTORY_SEPARATOR;
        switch ($vdetails['file_type']) {
            default:
            case 'mp4':
                $files = json_decode($vdetails['video_files']);
                foreach ($files as $quality) {
                    $file = $vdetails['file_name'] . '-' . $quality . '.mp4';

                    if ($vdetails['video_version'] >= 2.7) {
                        if (file_exists($directory_path . $file) && is_file($directory_path . $file)) {
                            unlink($directory_path . $file);
                        }
                    } else {
                        if (file_exists(DIRECTORY_SEPARATOR . $file) && is_file(DIRECTORY_SEPARATOR . $file)) {
                            unlink(DIRECTORY_SEPARATOR . $file);
                        }
                    }
                }
                break;
            case 'hls':
                $directory_path .= $vdetails['file_name'] . DIRECTORY_SEPARATOR;
                $vid_files = glob($directory_path . '*');
                foreach ($vid_files as $file) {
                    unlink($file);
                }
                rmdir($directory_path);
                break;
        }

        e(lang('vid_files_removed_msg'), 'm');
    }

    /**
     * Function used to get videos
     * this function has all options
     * that you need to fetch videos
     * please see docs.clip-bucket.com for more details
     *
     * @param $params
     *
     * @return bool|array
     */
    function get_videos($params)
    {
        global $db, $cb_columns;

        $limit = $params['limit'];
        $order = $params['order'];

        $cond = '';
        $superCond = '';
        if (!has_access('admin_access', true)) {

            $superCond = ' ( video.status =\'Successful\' AND video.active = \'yes\' AND video.broadcast !=\'unlisted\') ';

            if (isset($params['filename'], $params['user'])) {
                $superCond = '( video.userid = ' . $params['user'] . ' OR' . $superCond . ')';
            }
        } else {
            if ($params['active']) {
                $cond .= ' ' . ('video.active') . '=\'' . $params['active'] . '\'';
            }

            if ($params['status']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.status') . '=\'' . $params['status'] . '\'';
            }

            if ($params['broadcast']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.broadcast') . '=\'' . $params['broadcast'] . '\'';
            }
        }

        //Setting Category Condition
        $all = false;
        if (!is_array($params['category'])) {
            if (strtolower($params['category']) == 'all') {
                $all = true;
            }
        }

        if ($params['category'] && !$all) {
            if ($cond != '') {
                $cond .= ' AND ';
            }

            $cond .= ' (';

            if (!is_array($params['category'])) {
                $cats = explode(',', $params['category']);
            } else {
                $cats = $params['category'];
            }

            $count = 0;

            foreach ($cats as $cat_params) {
                $count++;
                if ($count > 1) {
                    $cond .= ' OR ';
                }
                $cond .= ' ' . ('video.category') . ' LIKE \'%#' . $cat_params . '#%\' ';
            }

            $cond .= ')';
        }

        //date span
        if ($params['date_span']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }

            if ($params['date_span_column']) {
                $column = $params['date_span_column'];
            } else {
                $column = 'date_added';
            }

            $cond .= ' ' . cbsearch::date_margin($column, $params['date_span']);
        }

        //uid 
        if ($params['user']) {
            if (!is_array($params['user'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.userid') . '=\'' . $params['user'] . '\'';
            } else {
                if ($cond != '') {
                    $cond .= ' AND (';
                }

                $uQu = 0;
                foreach ($params['user'] as $user) {
                    if ($uQu > 0) {
                        $cond .= ' OR ';
                    }
                    $cond .= ' ' . ('video.userid') . '=\'' . $user . '\'';
                    $uQu++;
                }

                $cond .= ' ) ';
            }
        }

        //non-uid to exclude user videos from related
        if ($params['nonuser']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('video.userid') . ' <> \'' . $params['nonuser'] . '\' ';
        }

        if ($params['editor_pick']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('in_editor_pick') . ' = \'' . $params['editor_pick'] . '\' ';
        }

        $tag_n_title = '';
        //Tags
        if ($params['tags']) {
            //checking for commas ;)
            $tags = explode(',', $params['tags']);
            if ($tag_n_title != '') {
                $tag_n_title .= ' OR ';
            }
            if (count($tags) > 0) {
                $total = count($tags);
                $loop = 1;
                foreach ($tags as $tag) {
                    $tag_n_title .= ' ' . ('video.tags') . ' LIKE \'%' . $tag . '%\'';
                    if ($loop < $total) {
                        $tag_n_title .= ' OR ';
                    }
                    $loop++;
                }
            } else {
                $tag_n_title .= ' ' . ('video.tags') . ' LIKE \'%' . $params['tags'] . '%\'';
            }
        }
        //TITLE
        if ($params['title']) {
            if ($tag_n_title != '') {
                $tag_n_title .= ' OR ';
            }
            $tag_n_title .= ' ' . ('video.title') . ' LIKE \'%' . $params['title'] . '%\'';
        }

        if ($tag_n_title) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' (' . $tag_n_title . ') ';
        }

        //FEATURED
        if ($params['featured']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('video.featured') . ' = \'' . $params['featured'] . '\' ';
        }

        //VIDEO ID
        if ($params['videoid']) {
            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('video.videoid') . ' = \'' . $params['videoid'] . '\' ';
        }

        //VIDEO ID
        if ($params['videoids']) {
            if (is_array($params['videoids'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ( ';
                $curVid = 0;
                foreach ($params['videoids'] as $vid) {
                    if (is_numeric($vid)) {
                        if ($curVid > 0) {
                            $cond .= ' OR ';
                        }
                        $cond .= ' ' . ('video.videoid') . ' = \'' . $vid . '\' ';
                    }
                    $curVid++;
                }
                $cond .= ' ) ';
            }
        }

        //VIDEO KEY
        if ($params['videokey']) {
            if (!is_array($params['videokey'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.videokey') . ' = \'' . $params['videokey'] . '\' ';
            } else {
                if ($cond != '') {
                    $cond .= ' AND (';
                }

                $vkeyQue = 0;
                foreach ($params['videokey'] as $videokey) {
                    if ($vkeyQue > 0) {
                        $cond .= ' OR ';
                    }
                    $cond .= ' ' . ('video.videokey') . ' = \'' . $videokey . '\' ';
                    $vkeyQue++;
                }

                $cond .= ' ) ';
            }
        }

        //Exclude Vids
        if ($params['exclude']) {
            if (!is_array($params['exclude'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.videoid') . ' <> \'' . $params['exclude'] . '\' ';
            } else {
                foreach ($params['exclude'] as $exclude) {
                    if ($cond != '') {
                        $cond .= ' AND ';
                    }
                    $cond .= ' ' . ('video.videoid') . ' <> \'' . $exclude . '\' ';
                }
            }
        }

        //Duration
        if ($params['duration']) {
            $duration_op = $params['duration_op'];
            if (!$duration_op) {
                $duration_op = '=';
            }

            if ($cond != '') {
                $cond .= ' AND ';
            }
            $cond .= ' ' . ('video.duration') . ' ' . $duration_op . ' \'' . $params['duration'] . '\' ';
        }

        //Filename
        if ($params['filename']) {
            if (!is_array($params['filename'])) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.file_name') . ' = \'' . $params['filename'] . '\' ';
            } else {
                if ($cond != '') {
                    $cond .= ' AND (';
                }

                $fileNameQue = 0;
                foreach ($params['filename'] as $filename) {
                    if ($fileNameQue > 0) {
                        $cond .= ' OR ';
                    }
                    $cond .= ' ' . ('video.file_name') . ' = \'' . $filename . '\' ';
                    $fileNameQue++;
                }

                $cond .= ' ) ';
            }
        }

        if ($params['cond']) {
            if ($params['cond_and']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
            }
            $cond .= ' ' . $params['cond'];
        }

        $functions = cb_get_functions('get_videos');
        if ($functions) {
            foreach ($functions as $func) {
                $array = ['params' => $params, 'cond' => $cond];
                if (function_exists($func['func'])) {
                    $returned = $func['func']($array);
                    if ($returned) {
                        $cond = $returned;
                    }
                }
            }
        }

        $fields = [
            'video' => get_video_fields(),
            'users' => $cb_columns->object('users')->temp_change('featured', 'user_featured')->get_columns()
        ];

        if (!isset($fields['video_users'])) {
            $fields[] = 'video_users';
        }

        $fields = tbl_fields($fields);

        if (!$params['count_only'] && !$params['show_related']) {
            $query = 'SELECT ' . $fields . ' FROM ' . cb_sql_table('video');
            $query .= ' LEFT JOIN ' . cb_sql_table('users') . ' ON video.userid = users.userid';

            if (!empty($superCond)) {
                if ($cond !== '') {
                    $cond .= ' AND ' . $superCond;
                } else {
                    $cond .= $superCond;
                }
            }

            if ($cond) {
                $query .= ' WHERE ' . $cond;
            }

            $query .= $order ? ' ORDER BY ' . $order : false;
            $query .= $limit ? ' LIMIT ' . $limit : false;

            $result = select($query);
        }

        if ($params['show_related']) {
            $cond = '';
            if ($superCond) {
                $cond = $superCond . ' AND ';
            }

            $cond .= 'MATCH(' . ('video.title,video.tags') . ')
            AGAINST (\'' . mysql_clean($params['title']) . '\' IN NATURAL LANGUAGE MODE) ';

            if ($params['exclude']) {
                if ($cond != '') {
                    $cond .= ' AND ';
                }
                $cond .= ' ' . ('video.videoid') . ' <> \'' . $params['exclude'] . '\' ';
            }

            $query = ' SELECT ' . $fields . ' FROM ' . cb_sql_table('video');
            $query .= ' LEFT JOIN ' . cb_sql_table('users');
            $query .= ' ON video.userid = users.userid ';

            if ($cond) {
                $query .= ' WHERE ' . $cond;
            }

            $query .= $order ? ' ORDER BY ' . $order : false;
            $query .= $limit ? ' LIMIT ' . $limit : false;

            $result = select($query);
            if (count($result) == 0) {
                $cond = '';
                if ($superCond) {
                    $cond = $superCond . ' AND ';
                }
                //Try Finding videos via tags
                $cond .= 'MATCH(' . ('video.title,video.tags') . ')
                AGAINST (\'' . mysql_clean($params['tags']) . '\' IN NATURAL LANGUAGE MODE) ';
                if ($params['exclude']) {
                    if ($cond != '') {
                        $cond .= ' AND ';
                    }
                    $cond .= ' ' . ('video.videoid') . ' <> \'' . $params['exclude'] . '\' ';
                }

                $query = ' SELECT ' . $fields . ' FROM ' . cb_sql_table('video');
                $query .= ' LEFT JOIN ' . cb_sql_table('users');
                $query .= ' ON video.userid = users.userid ';

                if ($cond) {
                    $query .= ' WHERE ' . $cond;
                }

                $query .= $order ? ' ORDER BY ' . $order : false;
                $query .= $limit ? ' LIMIT ' . $limit : false;

                $result = select($query);
            }

            assign($params['assign'], $result);
        }

        if ($params['pr']) {
            pr($result, true);
        }

        if ($params['count_only']) {
            if (!empty($superCond)) {
                if (!empty($cond)) {
                    $cond .= ' AND ';
                }
                $cond .= $superCond;
            }
            return $db->count(cb_sql_table('video'), 'videoid', $cond);
        }
        if ($params['assign']) {
            assign($params['assign'], apply_filters($result, 'get_video'));
        } else {
            return apply_filters($result, 'get_video');
        }
    }

    /**
     * Function used to count total video comments
     *
     * @param $id
     *
     * @return bool
     */
    function count_video_comments($id)
    {
        global $db;
        return $db->count(tbl('comments'), 'comment_id', 'type=\'v\' AND type_id=\'' . $id . '\' AND parent_id=\'0\'');
    }

    /**
     * Function used to update video comments count
     *
     * @param $id
     */
    function update_comments_count($id)
    {
        global $db;
        $total_comments = $this->count_video_comments($id);
        $db->update(tbl('video'), ['comments_count', 'last_commented'], [$total_comments, now()], ' videoid=\'' . $id . '\'');
    }

    /**
     * Function used to add video comment
     *
     * @param      $comment
     * @param      $obj_id
     * @param null $reply_to
     * @param bool $force_name_email
     *
     * @return bool|mixed
     * @throws phpmailerException
     */
    function add_comment($comment, $obj_id, $reply_to = null, $force_name_email = false)
    {
        global $myquery;

        $video = $this->get_video_details($obj_id);

        if (!$video) {
            e(lang('class_vdo_del_err'));
        } else {
            //Getting Owner Id
            $owner_id = $this->get_video_owner($obj_id, true);
            $add_comment = $myquery->add_comment($comment, $obj_id, $reply_to, 'v', $owner_id, videoLink($video), $force_name_email);
            if ($add_comment) {
                //Logging Comment
                $log_array = [
                    'success'        => 'yes',
                    'details'        => 'comment on a video',
                    'action_obj_id'  => $obj_id,
                    'action_done_id' => $add_comment
                ];
                insert_log('video_comment', $log_array);

                //Updating Number of comments of video if comment is not a reply
                if ($reply_to < 1) {
                    $this->update_comments_count($obj_id);
                }
            }
            return $add_comment;
        }
    }

    /**
     * Function used to remove video comment
     *
     * @param      $cid
     * @param bool $is_reply
     *
     * @return bool|mixed
     */
    function delete_comment($cid, $is_reply = false)
    {
        global $myquery;
        $remove_comment = $myquery->delete_comment($cid, 'v', $is_reply);
        if ($remove_comment) {
            //Updating Number of comments of video
            $this->update_comments_count($cid);
        }
        return $remove_comment;
    }

    /**
     * Function used to generate Embed Code
     *
     * @param        $vdetails
     * @param string $type
     *
     * @return bool|string
     */
    function embed_code($vdetails, $type = 'embed_object')
    {
        //Checking for video details
        if (!is_array($vdetails)) {
            $vdetails = $this->get_video($vdetails);
        }

        $embed_code = false;

        $funcs = $this->embed_func_list;

        if (is_array($funcs)) {
            foreach ($funcs as $func) {
                if (@function_exists($func)) {
                    $embed_code = $func($vdetails);
                }

                if ($embed_code) {
                    break;
                }
            }
        }

        if ($type == 'iframe') {
            $embed_code = '<iframe width="' . config('embed_player_width') . '" height="' . config('embed_player_height') . '" ';
            $embed_code .= 'src="' . BASEURL . '/player/embed_player.php?vid=' . $vdetails['videokey'] . '&width=' .
                config('embed_player_width') . '&height=' . config('embed_player_height');

            if (config('autoplay_embed') == 'yes') {
                $embed_code .= '&autoplay=yes';
            }

            $embed_code .= '" frameborder="0" allowfullscreen></iframe>';
        }

        if (!$embed_code) {
            //Default ClipBucket Embed Code
            if (function_exists('default_embed_code')) {
                $embed_code = default_embed_code($vdetails);
            } else {
                //return new Embed Code
                $vid_file = get_video_file($vdetails, false, false);
                if ($vid_file) {
                    $code = '<object width="' . EMBED_VDO_WIDTH . '" height="' . EMBED_VDO_HEIGHT . '">';
                    $code .= '<param name="movie" value="' . BASEURL . '/embed_player.php?vid=' . $vdetails['videoid'] . '"></param>';
                    $code .= '<param name="allowFullScreen" value="true"></param>';
                    $code .= '<param name="allowscriptaccess" value="always"></param>';
                    $code .= '<embed src="' . BASEURL . '/embed_player.php?vid=' . $vdetails['videoid'] . '"';
                    $code .= 'type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="300" height="250"></embed>';
                    $code .= '</object>';
                    return $code;
                }
                return embeded_code($vdetails);
            }
        }
        return $embed_code;
    }

    /**
     * Function used to initialize action class
     * in order to call actions.class.php to
     * work with Video section, this function will be called first
     */
    function init_actions()
    {
        $this->action = new cbactions();
        $this->action->init();
        $this->action->type = 'v';
        $this->action->name = 'video';
        $this->action->obj_class = 'cbvideo';
        $this->action->check_func = 'video_exists';
        $this->action->type_tbl = $this->dbtbl['video'];
        $this->action->type_id_field = 'videoid';
    }

    /**
     * Function used to create value array for email templates
     * @param array video_details ARRAY
     */
    function set_share_email($details)
    {
        $this->email_template_vars = [
            '{video_title}'       => $details['title'],
            '{video_description}' => $details['description'],
            '{video_tags}'        => $details['tags'],
            '{video_date}'        => cbdate(DATE_FORMAT, $details['date_added']),
            '{video_link}'        => video_link($details),
            '{video_thumb}'       => GetThumb($details)
        ];

        $this->action->share_template_name = 'share_video_template';
        $this->action->val_array = $this->email_template_vars;
    }

    /**
     * Function used to use to initialize search object for video section
     * op=>operator (AND OR)
     */
    function init_search()
    {
        $this->search = new cbsearch;
        $this->search->db_tbl = 'video';
        $this->search->columns = [
            ['field' => 'title', 'type' => 'LIKE', 'var' => '%{KEY}%'],
            ['field' => 'tags', 'type' => 'LIKE', 'var' => '%{KEY}%', 'op' => 'OR'],
            ['field' => 'broadcast', 'type' => '!=', 'var' => 'unlisted', 'op' => 'AND', 'value' => 'static'],
            ['field' => 'status', 'type' => '=', 'var' => 'Successful', 'op' => 'AND', 'value' => 'static']
        ];
        //commit this line so that videos search can be applied to %like% instead of whole word search
        //$this->search->use_match_method = true;
        $this->search->match_fields = ['title', 'tags'];

        $this->search->cat_tbl = $this->cat_tbl;

        $this->search->display_template = LAYOUT . '/blocks/video.html';
        $this->search->template_var = 'video';
        $this->search->has_user_id = true;

        /**
         * Setting up the sorting thing
         */

        $sorting = [
            'date_added' => lang('date_added'),
            'views'      => lang('views'),
            'comments'   => lang('comments'),
            'rating'     => lang('rating'),
            'favorites'  => lang('favorites')
        ];

        $this->search->sorting = [
            'date_added' => ' date_added DESC',
            'views'      => ' views DESC',
            'comments'   => ' comments_count DESC',
            'rating'     => ' rating DESC',
            'favorites'  => ' favorites DeSC'
        ];
        /**
         * Setting Up The Search Fields
         */

        $default = $_GET;
        if (is_array($default['category'])) {
            $cat_array = [$default['category']];
        }
        $uploaded = $default['datemargin'];
        $sort = $default['sort'];

        $this->search->search_type['videos'] = ['title' => lang('videos')];
        $this->search->results_per_page = config('videos_items_search_page');

        $fields = [
            'query'    => [
                'title' => lang('keywords'),
                'type'  => 'textfield',
                'name'  => 'query',
                'id'    => 'query',
                'value' => mysql_clean($default['query'])
            ],
            'category' => [
                'title' => lang('vdo_cat'),
                'type'  => 'checkbox',
                'name'  => 'category[]',
                'id'    => 'category',
                'value' => ['category', $cat_array]
            ],
            'uploaded' => [
                'title'   => lang('uploaded'),
                'type'    => 'dropdown',
                'name'    => 'datemargin',
                'id'      => 'datemargin',
                'value'   => $this->search->date_margins(),
                'checked' => $uploaded
            ],
            'sort'     => [
                'title'   => lang('sort_by'),
                'type'    => 'dropdown',
                'name'    => 'sort',
                'value'   => $sorting,
                'checked' => $sort
            ]
        ];

        $this->search->search_type['videos']['fields'] = $fields;
    }

    /*
     * Function used to update video and set a thumb as default
     * @param VID
     * @param THUMB NUM
     */
    function set_default_thumb($vid, $thumb)
    {
        global $db;
        if (is_null($thumb)) {
            return;
        }
        $num = get_thumb_num($thumb);
        $db->update(tbl('video'), ['default_thumb'], [$num], ' videoid=\'' . mysql_clean($vid) . '\'');
        e(lang('vid_thumb_changed'), 'm');
    }

    /**
     * Function used to get video owner
     *
     * @param      $vid
     * @param bool $idonly
     *
     * @return bool|array
     */
    function get_video_owner($vid, $idonly = false)
    {
        global $db;
        if ($idonly) {
            $results = $db->select(tbl('video'), 'userid', ' videoid=\'' . mysql_clean($vid) . '\'', 1);
            if (count($results) > 0) {
                return $results[0]['userid'];
            }
            return false;
        }

        $results = $db->select(tbl('video'), '*', ' videoid=\'' . mysql_clean($vid) . '\'', 1);
        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to check weather current user is video owner or not
     *
     * @param $vid
     * @param $uid
     *
     * @return bool
     */
    function is_video_owner($vid, $uid): bool
    {
        global $db;

        $result = $db->count(tbl($this->dbtbl['video']), 'videoid', 'videoid=\'' . mysql_clean($vid) . '\' AND userid=\'' . mysql_clean($uid) . '\' ');
        if ($result > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to display video manger link
     *
     * @param $link
     * @param $vid
     *
     * @return string
     */
    function video_manager_link($link, $vid)
    {
        if (function_exists($link) && !is_array($link)) {
            return $link($vid);
        }

        if (!empty($link['title']) && !empty($link['link'])) {
            return '<a href="' . $link['link'] . '">' . $link['title'] . '</a>';
        }
    }

    /**
     * Function used to display video manger link temporary
     *
     * @param $link
     * @param $vid
     *
     * @return string
     */
    function video_manager_link_new($link, $vid)
    {
        if (function_exists($link) && !is_array($link)) {
            return $link($vid);
        }

        if (!empty($link['title']) && !empty($link['link'])) {
            return '<a href="' . $link['link'] . '">' . $link['title'] . '</a>';
        }
    }

    /**
     * Function used to display video categories manger link temporary
     *
     * @param $link
     * @param $vid
     *
     * @return string
     */
    function video_categories_manager_link($link, $vid)
    {
        if (function_exists($link) && !is_array($link)) {
            return $link($vid);
        }

        if (!empty($link['title']) && !empty($link['link'])) {
            return '<a href="' . $link['link'] . '">' . $link['title'] . '</a>';
        }
    }

    /**
     * Function used to get video rating details
     *
     * @param $id
     *
     * @return bool|array
     */
    function get_video_rating($id)
    {
        global $db;
        if (is_numeric($id)) {
            $cond = ' videoid=\'' . mysql_clean($id) . '\'';
        } else {
            $cond = ' videokey=\'' . mysql_clean($id) . '\'';
        }
        $results = $db->select(tbl('video'), 'userid,allow_rating,rating,rated_by,voter_ids', $cond);

        if (count($results) > 0) {
            return $results[0];
        }
        return false;
    }

    /**
     * Function used to display rating option for videos
     * this is an OLD TYPICAL RATING SYSTEM
     * and yes, still with AJAX
     *
     * @param $params
     *
     * @return array|void
     */
    function show_video_rating($params)
    {
        $rating = $params['rating'];
        $ratings = $params['ratings'];
        $total = $params['total'];
        $id = $params['id'];
        $type = $params['type'];
        $data_only = $params['data_only'];

        if (empty($ratings)) {
            $ratings = $params['rated_by'];
        }
        //Checking Percent
        if ($total <= 10) {
            $total = 10;
        }
        $perc = $rating * 100 / $total;
        $perc = round($perc);
        $disperc = 100 - $perc;
        if ($ratings <= 0 && $disperc == 100) {
            $disperc = 0;
        }

        $perc = $perc . '%';
        $disperc = $disperc . '%';
        $likes = round($ratings * $perc / 100); // get lowest integer

        if ($params['is_rating']) {
            if (error()) {
                $rating_msg = error();
                $rating_msg = '<span class="error">' . $rating_msg[0]['val'] . '</span>';
            }
            if (msg()) {
                $rating_msg = msg();
                $rating_msg = '<span class="msg">' . $rating_msg[0]['val'] . '</span>';
            }
        }

        if ($data_only) {
            return [
                'perc'       => $perc,
                'disperc'    => $disperc,
                'id'         => $id,
                'type'       => $type,
                'rating_msg' => $rating_msg,
                'likes'      => $likes,
                'dislikes'   => ($ratings - $likes),
                'disable'    => $params['disable']
            ];
        }
        assign('perc', $perc);
        assign('disperc', $disperc);
        assign('id', $id);
        assign('type', $type);
        assign('id', $id);
        assign('rating_msg', $rating_msg);
        assign('likes', $likes);
        assign('dislikes', ($ratings - $likes));
        assign('disable', $params['disable']);

        Template('blocks/common/rating.html');
    }

    /**
     * Function used to rate video
     *
     * @param $id
     * @param $rating
     *
     * @return array
     */
    function rate_video($id, $rating): array
    {
        global $db;

        if (!is_numeric($rating) || $rating <= 9) {
            $rating = 0;
        }
        if ($rating >= 10) {
            $rating = 10;
        }

        $rating_details = $this->get_video_rating($id);
        $voter_id = $rating_details['voter_ids'];

        $new_by = $rating_details['rated_by'];
        $newrate = $rating_details['rating'];

        $Oldvoters = explode('|', $voter_id);

        if (is_array($Oldvoters) && count($Oldvoters) > 2) {
            foreach ($Oldvoters as $voter) {
                if ($voter) {
                    $voters[$voter] = [
                        'userid' => $voter,
                        'time'   => now(),
                        'method' => 'old'
                    ];
                }
            }
        } else {
            if (!empty($js)) {
                $voters = $js->json_decode($voter_id, true);
            } else {
                $voters = json_decode($voter_id, true);
            }
        }

        if (!empty($voters)) {
            $already_voted = array_key_exists(userid(), $voters);
        }

        if (!userid()) {
            e(lang('please_login_to_rate'));
        } elseif (userid() == $rating_details['userid'] && !config('own_video_rating')) {
            e(lang('you_cant_rate_own_video'));
        } elseif (!empty($already_voted)) {
            e(lang('you_hv_already_rated_vdo'));
        } elseif (!config('video_rating') || $rating_details['allow_rating'] != 'yes') {
            e(lang('vid_rate_disabled'));
        } else {
            $voters[userid()] = [
                'userid'   => userid(),
                'username' => user_name(),
                'time'     => now(),
                'rating'   => $rating
            ];

            $total_voters = count($voters);

            if (!empty($js)) {
                $voters = $js->json_encode($voters);
            } else {
                $voters = json_encode($voters);
            }

            $t = $rating_details['rated_by'] * $rating_details['rating'];
            $new_by = $total_voters;

            $newrate = ($t + $rating) / $new_by;
            if ($newrate > 10) {
                $newrate = 10;
            }
            $db->update(tbl($this->dbtbl['video']), ['rating', 'rated_by', 'voter_ids'], [$newrate, $new_by, '|no_mc|' . $voters], ' videoid=\'' . mysql_clean($id) . '\'');
            $userDetails = [
                'object_id' => $id,
                'type'      => 'video',
                'time'      => now(),
                'rating'    => $rating,
                'userid'    => userid(),
                'username'  => user_name()
            ];
            /* Updating user details */
            update_user_voted($userDetails);
            e(lang('thnx_for_voting'), 'm');
        }

        return [
            'rating'    => $newrate
            , 'ratings' => $new_by
            , 'total'   => 10
            , 'id'      => $id
            , 'type'    => 'video'
            , 'disable' => 'disabled'
        ];
    }

    /**
     * Function used to get playlist items
     *
     * @param      $playlist_id
     * @param null $order
     * @param int $limit
     *
     * @return bool|mixed
     */
    function get_playlist_items($playlist_id, $order = null, $limit = 10)
    {
        global $cb_columns;

        $fields = [
            'playlist_items' => $cb_columns->object('playlist_items')->temp_change('date_added', 'item_added')->get_columns(),
            'playlists'      => $cb_columns->object('playlists')->temp_remove('first_item,cover')->temp_change('date_added,description,tags,category', 'playlist_added,playlist_description,playlist_tags,playlist_category')->get_columns(),
            'video'          => $cb_columns->object('videos')->get_columns()
        ];

        $query = 'SELECT ' . table_fields($fields) . ' FROM ' . table('playlist_items');
        $query .= ' LEFT JOIN ' . table('playlists') . ' ON playlist_items.playlist_id = playlists.playlist_id';
        $query .= ' LEFT JOIN ' . table('video') . ' ON playlist_items.object_id = video.videoid';
        $query .= ' WHERE playlist_items.playlist_id = \'' . $playlist_id . '\'';

        if (!is_null($order)) {
            $query .= ' ORDER BY ' . $order;
        }

        if ($limit > 0) {
            $query .= ' LIMIT ' . $limit;
        }

        $query_id = cb_query_id($query);

        $data = cb_do_action('select_playlist_items', ['query_id' => $query_id, 'playlist_id' => $playlist_id]);

        if ($data) {
            return $data;
        }

        $data = select($query);

        if ($data) {
            cb_do_action('return_playlist_items', [
                    'query_id' => $query_id,
                    'results'  => $data
                ]
            );

            return $data;
        }

        return false;
    }

    /**
     * Function used to add video in quicklist
     *
     * @param $id
     *
     * @return bool
     */
    function add_to_quicklist($id): bool
    {
        global $sess;

        if ($this->exists($id)) {
            $list = json_decode($sess->get_cookie(QUICK_LIST_SESS), true);

            $list[] = $id;
            $new_list = array_unique($list);

            $sess->set_cookie(QUICK_LIST_SESS, json_encode($new_list));
            return true;
        }
        return false;
    }

    /**
     * Removing video from quicklist
     *
     * @param $id
     *
     * @return bool
     */
    function remove_from_quicklist($id): bool
    {
        global $sess;

        $list = json_decode($sess->get_cookie(QUICK_LIST_SESS), true);

        $key = array_search($id, $list);
        unset($list[$key]);

        $sess->set_cookie(QUICK_LIST_SESS, json_encode($list));
        return true;
    }

    /**
     * function used to count num of quicklist
     */
    function total_quicklist(): int
    {
        global $sess;

        $total = $sess->get_cookie(QUICK_LIST_SESS);
        $total = json_decode($total, true);

        if (is_null($total)) {
            return 0;
        }

        return count($total);
    }

    /**
     * Function used to get quicklist
     */
    function get_quicklist()
    {
        global $sess;
        return json_decode($sess->get_cookie(QUICK_LIST_SESS), true);
    }

    /**
     * Function used to remove all items of quicklist
     */
    function clear_quicklist()
    {
        global $sess;
        $sess->set_cookie(QUICK_LIST_SESS, '');
    }

    /**
     * Function used to check weather video is downloadable or not
     *
     * @param $vdo
     *
     * @return bool
     */
    function downloadable($vdo): bool
    {
        if ($vdo['file_type'] == 'hls') {
            return false;
        }
        $file = get_video_file($vdo, false);
        if ($file) {
            return true;
        }
        return false;
    }

    /**
     * Function used get comments of videos
     *
     * @param null $params
     *
     * @return array|bool
     */
    function get_comments($params = null)
    {
        global $db;
        $comtbl = tbl('comments');
        $limit = $params['limit'];
        $order = $params['order'];
        $type = $params['type'];

        if ($type) {
            $cond = ' ' . $comtbl . '.type = \'' . $type . '\'';
        } else {
            $cond = '';
        }

        switch ($type) {
            case 'c':
                $sectbl = tbl('users');
                $sectblName = 'users';
                $secfields = $sectbl . '.username,' . $sectbl . '.userid';
                if ($cond) {
                    $cond .= ' AND';
                }
                $cond .= ' ' . $comtbl . '.type_id = ' . $sectbl . '.userid';
                break;

            case 'v':
            default:
                $sectbl = tbl('video');
                $sectblName = 'video';
                $secfields = $sectbl . '.videokey,' . $sectbl . '.videoid,' . $sectbl . '.file_name,' . $sectbl . '.title';
                if ($cond) {
                    $cond .= ' AND';
                }
                $cond .= ' ' . $comtbl . '.type_id = ' . $sectbl . '.videoid';
                break;
        }

        if ($params['cond']) {
            $cond .= ' ' . $params['cond'];
        }

        if (!$params['count_only']) {
            $result = $db->select(
                tbl('comments,' . $sectblName),
                $comtbl . '.*,' . $secfields,
                $cond, $limit, $order);
        } else {
            $result = $db->count(tbl('comments,video'), '*', $cond);
        }
        return $result;
    }

    /**
     * Function used get single comment
     *
     * @param $cid
     *
     * @return bool|array
     */
    function get_comment($cid)
    {
        global $db;
        $result = $db->select(tbl('comments'), '*', ' comment_id = ' . $cid);
        if ($result) {
            return $result[0];
        }
        return false;
    }

    /**
     * Function used to convert timthumb url to filename and file
     *
     * @param  : url, flag
     * @param bool $file_name
     *
     * @date   : 6/2/2015
     * @return string
     * @author : Fahad Abbas
     * @reason : to delete the thumb from server forcefully
     */
    function convert_tim_thumb_url_to_file($url, bool $file_name): string
    {
        $thumb = explode('src=', $url);
        if ($file_name) {
            $thumb = explode('-', $thumb[1]);
        } else {
            $thumb = explode('&', $thumb[1]);
        }

        return $thumb[0];
    }

}
