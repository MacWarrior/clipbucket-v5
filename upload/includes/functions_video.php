<?php
function get_video_fields($extra = null)
{
    global $cb_columns;
    return $cb_columns->set_object('videos')->get_columns($extra);
}

/**
 * Function used to check video is playlable or not
 *
 *
 * @param array|string $id contain video info or video id
 * @return bool : { boolean } { true if playable, else false }
 * @throws Exception
 */
function video_playable($id): bool
{
    global $cbvideo, $userquery;

    if (isset($_POST['watch_protected_video'])) {
        $video_password = mysql_clean(post('video_password'));
    } else {
        $video_password = '';
    }

    if (!is_array($id)) {
        $vdo = $cbvideo->get_video($id);
    } else {
        $vdo = $id;
    }
    $uid = user_id();
    if (!$vdo) {
        e(lang('class_vdo_del_err'));
        return false;
    }
    if ($vdo['status'] != 'Successful') {
        e(lang('this_vdo_not_working'));
        if (!has_access('admin_access', true)) {
            return false;
        }
        return true;
    }
    if ($vdo['broadcast'] == 'private'
        && !userquery::getInstance()->is_confirmed_friend($vdo['userid'], user_id())
        && !is_video_user($vdo)
        && !has_access('video_moderation', true)
        && $vdo['userid'] != $uid) {
        e(lang('private_video_error'));
        return false;
    }

    if ($vdo['broadcast'] == 'logged'
        && !user_id()
        && !has_access('video_moderation', true)
        && $vdo['userid'] != $uid) {
        e(lang('not_logged_video_error'));
        return false;
    }
    if ($vdo['active'] == 'no' && $vdo['userid'] != user_id()) {
        e(lang('vdo_iac_msg'));
        if (!has_access('admin_access', true)) {
            return false;
        }
        return true;
    }

    if ($vdo['video_password']
        && $vdo['broadcast'] == 'unlisted'
        && $vdo['video_password'] != $video_password
        && !has_access('video_moderation', true)
        && $vdo['userid'] != $uid) {
        if (!$video_password) {
            e(lang("video_pass_protected"));
        } else {
            e(lang("invalid_video_password"));
        }
        template_files("blocks/watch_video/video_password.html", false, false);
    } else {
        $funcs = cb_get_functions('watch_video');

        if ($funcs) {
            foreach ($funcs as $func) {
                $data = $func['func']($vdo);
                if ($data) {
                    return $data;
                }
            }
        }
    }

    if( !has_access('video_moderation', true)
        && config('enable_age_restriction') == 'yes'
        && Video::getInstance()->isCurrentUserRestricted($vdo['videoid'])
    ){
        e(lang('error_age_restriction'));
        return false;
    }

    return true;
}

/**
 * FUNCTION USED TO GET THUMBNAIL
 *
 * @param array $vdetails video_details, or videoid will also work
 * @param bool $multi
 * @param bool $size
 *
 * @return array|string
 * @throws Exception
 */
function get_thumb($vdetails, $multi = false, $size = false, $type = false, $max_id = null)
{
    if (is_array($vdetails)) {
        if (empty($vdetails['videoid']) && empty($vdetails['vid'])) {
            e(lang('technical_error'));
            error_log('get_thumb - called on empty vdetails');
            return $multi ? [default_thumb()] : default_thumb();
        }
        if (!empty($vdetails['videoid'])) {
            $vid = $vdetails['videoid'];
        } elseif (!empty($vdetails['vid'])) {
            $vid = $vdetails['vid'];
        }
    } else {
        if (is_numeric($vdetails)) {
            $vid = $vdetails;
            $vdetails = Video::getInstance()->getOne(['videoid'=>$vid]);
        } else {
            e(lang('technical_error'));
            error_log('get_thumb - called on empty vdetails');
            return $multi ? [default_thumb()] : default_thumb();
        }
    }

    $fields = ['V.videoid', 'V.file_name', 'V.file_directory', 'VT.num', 'V.default_thumb', 'V.status'];
    $version = Update::getInstance()->getDBVersion();
    if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 366)) {
        $fields[] = 'V.default_poster';
        $fields[] = 'V.default_backdrop';
    }

    //get current video from db
    if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 163)) {
        $resVideo = Clipbucket_db::getInstance()->select(tbl('video') . ' AS V LEFT JOIN ' . tbl('video_thumbs') . ' AS VT ON VT.videoid = V.videoid ', implode(',', $fields), 'V.videoid = ' . mysql_clean($vid));
    } else {
        return $multi ? [default_thumb()] : default_thumb();
    }
    if (empty($resVideo)) {
        error_log('get_thumb - called on missing videoid ' . $vid);
        e(lang('technical_error'));
        return $multi ? [default_thumb()] : default_thumb();
    }
    $resVideo = $resVideo[0];

    //get thumbs for current video from db
    $where[] = 'videoid = ' . mysql_clean($vid);
    if (!$multi) {
        switch ($type) {
            default:
                $default = $resVideo['default_thumb'];
                break;
            case 'poster':
                $default = $resVideo['default_poster'];
                break;
            case 'backdrop':
                $default = $resVideo['default_backdrop'];
                break;
        }
        $where[] = ' num = ' . mysql_clean($default);
    }
    if (!empty($size)) {
        $where[] = ' resolution LIKE \'' . mysql_clean($size) . '\'';
    }

    if ($type) {
        $where[] = ' type = \'' . $type . '\'';
    }

    if (!empty($max_id)) {
        $where[] = ' id > ' . mysql_clean($max_id);
    }

    $resThumb = Clipbucket_db::getInstance()->select(tbl('video_thumbs'), '*', implode(' AND ', $where));

    if (empty($resThumb) && $type =='custom') {
        return $multi ? [] : '';
    }

    if (empty($resThumb) && $resVideo['num'] === null && $vdetails['status'] == 'Successful') {
        //if no thumbs, we put some in db see \create_thumb()
        return create_thumb($resThumb, $multi, $size);
    }
    if (empty($resThumb)) {
        return $multi ? [default_thumb()] : default_thumb();
    }
    if ($multi) {
        $thumb = [];
        foreach ($resThumb as $re) {
            if ($re['size'] === '') {
                return [default_thumb()];
            }
            $filepath = $resVideo['file_directory'] . DIRECTORY_SEPARATOR . $resVideo['file_name'] . '-' . $re['resolution'] . '-' . $re['num'] . ($re['type'] != 'auto' ? '-'.array_search($re['type'], Upload::getInstance()->types_thumb) : '') .'.' . $re['extension'];
            if (file_exists(DirPath::get('thumbs') . $filepath)) {
                $thumb[] = DirPath::getUrl('thumbs') . $filepath;
            } else {
                error_log('get_thumb - missing file : ' . $filepath);
                $thumb[] = default_thumb();
            }
        }
        return $thumb;
    }
    $filepath = $resVideo['file_directory'] . DIRECTORY_SEPARATOR . $resVideo['file_name'] . '-' . $resThumb[0]['resolution'] . '-' . $resThumb[0]['num'] . ($resThumb[0]['type'] != 'auto' ? '-'. array_search($resThumb[0]['type'], Upload::getInstance()->types_thumb) : '') .'.' . $resThumb[0]['extension'];
    if (!file_exists(DirPath::get('thumbs') . $filepath)) {
        error_log('get_thumb - missing file : ' . $filepath);
        return default_thumb();
    }
    return DirPath::getUrl('thumbs') . $filepath;
}

/**
 * @throws Exception
 */
function get_count_thumb($videoid)
{
    $resVideo = Clipbucket_db::getInstance()->select(tbl('video') . ' AS V INNER JOIN ' . tbl('video_thumbs') . ' AS VT ON VT.videoid = V.videoid ', 'COUNT(V.videoid) as nb_thumbs', 'V.videoid = ' . mysql_clean($videoid));
    if (empty($resVideo)) {
        error_log('get_count_thumb - no thumbnails for videoid : ' . $videoid);
        return 0;
    }
    return $resVideo[0]['nb_thumbs'];
}

/**
 * @param $video_db
 * @param $multi
 * @param $size
 * @return array|string
 * @throws Exception
 */
function create_thumb($video_db, $multi, $size)
{
    if(empty($video_db)){
        return default_thumb();
    }

    //check files
    $glob = DirPath::get('thumbs') . $video_db['file_directory'] . DIRECTORY_SEPARATOR . $video_db['file_name'] . '*';
    $vid_thumbs = glob($glob);
    if (!empty($vid_thumbs) && !empty($video_db['file_directory']) && !empty($video_db['file_name'])) {
        foreach ($vid_thumbs as $thumb) {
            $files_info = [];
            //pattern must match :  /`file_name`-`size`-`num`.`extension`
            preg_match('/\/\w*-(\w{1,16})-(\d{1,3})\.(\w{2,4})$/', $thumb, $files_info);
            if (!empty($files_info)) {
                Clipbucket_db::getInstance()->insert(tbl('video_thumbs'), ['videoid', 'resolution', 'num', 'extension', 'version'], [$video_db['videoid'], $files_info[1], $files_info[2], $files_info[3], VERSION]);
            }
        }
    }
    return get_thumb($video_db['videoid'], $multi, $size);
}

/**
 * @throws Exception
 */
function get_player_thumbs_json($data)
{
    $thumbs = get_thumb($data, true, '168x105', 'auto');
    $duration = (int)$data['duration'];
    $json = '';
    if (is_array($thumbs)) {
        $nb_thumbs = count($thumbs);
        $division = $duration / $nb_thumbs;
        $count = 0;
        foreach ($thumbs as $url) {
            $time = (int)($count * $division);
            if ($json != '') {
                $json .= ',';
            }
            $json .= $time . ': {
                    src: \'' . $url . '\'
                }';
            $count++;
        }
    }

    echo '{' . $json . '}';
}

/**
 * @param $vdetails
 * @return array|false
 * @throws Exception
 */
function get_video_subtitles($vdetails)
{
    if (empty($vdetails)) {
        return false;
    }

    $results = Clipbucket_db::getInstance()->select(tbl('video_subtitle'), 'videoid,number,title', ' videoid=' . $vdetails['videoid']);

    if (count($results) == 0) {
        return false;
    }

    $subtitles = [];
    foreach ($results as $line) {
        $subtitles[] = [
            'url'      => DirPath::getUrl('subtitles') . $vdetails['file_directory'] . '/' . $vdetails['file_name'] . '-' . $line['number'] . '.srt'
            , 'title'  => $line['title']
            , 'number' => $line['number']
        ];
    }

    return $subtitles;
}

/**
 * function used to get default thumb of ClipBucket
 */
function default_thumb(): string
{
    if (file_exists(TEMPLATEDIR . '/images/thumbs/processing.png')) {
        return TEMPLATEURL . '/images/thumbs/processing.png';
    }

    return DirPath::getUrl('thumbs') . 'processing.jpg';
}

/**
 * Function used to get video link
 *
 * @param      $vdetails
 * @param null $type
 *
 * @return string
 * @throws Exception
 * @internal param video $ARRAY details
 */
function video_link($vdetails, $type = null): string
{
    #checking what kind of input we have
    if (is_array($vdetails)) {
        if (empty($vdetails['title'])) {
            #check for videoid
            if (empty($vdetails['videoid']) && empty($vdetails['vid']) && empty($vdetails['videokey'])) {
                return '/';
            } else {
                if (!empty($vdetails['videoid'])) {
                    $vid = $vdetails['videoid'];
                } else {
                    if (!empty($vdetails['vid'])) {
                        $vid = $vdetails['vid'];
                    } else {
                        if (!empty($vdetails['videokey'])) {
                            $vid = $vdetails['videokey'];
                        } else {
                            return '/';
                        }
                    }
                }
            }
        }
    } else {
        if (is_numeric($vdetails)) {
            $vid = $vdetails;
        } else {
            return '/';
        }
    }
    #checking if we have vid , so fetch the details
    if (!empty($vid)) {
        $vdetails = get_video_details($vid);
    }

    //calling for custom video link functions
    $functions = cb_get_functions('video_link');
    if ($functions) {
        foreach ($functions as $func) {
            $array = ['vdetails' => $vdetails, 'type' => $type];
            if (function_exists($func['func'])) {
                $returned = $func['func']($array);
                if ($returned) {
                    return $returned;
                }
            }
        }
    }

    $plist = '';
    if (SEO == 'yes') {
        if ($vdetails['playlist_id']) {
            $plist = '?play_list=' . $vdetails['playlist_id'];
        }

        $vdetails['title'] = strtolower($vdetails['title']);

        switch (config('seo_vido_url')) {
            default:
                $link = BASEURL . '/video/' . $vdetails['videokey'] . '/' . SEO(display_clean(str_replace(' ', '-', $vdetails['title']))) . $plist;
                break;
            case 1:
                $link = BASEURL . '/' . SEO(display_clean(str_replace(' ', '-', $vdetails['title']))) . '_v' . $vdetails['videoid'] . $plist;
                break;
            case 2:
                $link = BASEURL . '/video/' . $vdetails['videoid'] . '/' . SEO(display_clean(str_replace(' ', '-', $vdetails['title']))) . $plist;
                break;
            case 3:
                $link = BASEURL . '/video/' . $vdetails['videoid'] . '_' . SEO(display_clean(str_replace(' ', '-', $vdetails['title']))) . $plist;
                break;
        }
    } else {
        if ($vdetails['playlist_id']) {
            $plist = '&play_list=' . $vdetails['playlist_id'];
        }
        $link = BASEURL . '/watch_video.php?v=' . $vdetails['videokey'] . $plist;
    }
    if (!$type || $type == 'link') {
        return $link;
    }
    if ($type == 'download') {
        return '/download.php?v=' . $vdetails['videokey'];
    }
}

/**
 * Function Used to format video duration
 *
 * @param : array(videoKey or ID, video TITLE)
 *
 * @return string|void
 * @throws Exception
 */
function videoSmartyLink($params)
{
    $link = video_link($params['vdetails'], $params['type']);
    if (!$params['assign']) {
        return $link;
    }
    assign($params['assign'], $link);
}


/**
 * Function used to check videokey exists or not
 * key_exists
 *
 * @param $key
 *
 * @return bool
 * @throws Exception
 */
function vkey_exists($key): bool
{
    $results = Clipbucket_db::getInstance()->select(tbl('video'), 'videokey', " videokey='$key'");
    if (count($results) > 0) {
        return true;
    }
    return false;
}

/**
 * Function used to check file_name exists or not
 * as its a unique name so it will not let repost the data
 *
 * @param $name
 *
 * @return bool|int
 * @throws Exception
 */
function file_name_exists($name)
{
    $results = Clipbucket_db::getInstance()->select(tbl('video'), 'videoid,file_name', " file_name='$name'");

    if (count($results) > 0) {
        return $results[0]['videoid'];
    }
    return false;
}

/**
 * Function used to get video from conversion queue
 *
 * @param string $fileName
 *
 * @return array
 * @throws Exception
 */
function get_queued_video(string $fileName): array
{
    $queueName = getName($fileName);
    $ext = getExt($fileName);

    $results = Clipbucket_db::getInstance()->select(tbl('conversion_queue'), '*', "cqueue_conversion='no' AND cqueue_name ='$queueName' AND cqueue_ext ='$ext'", 1);
    if( empty($results) ){
        return [];
    }

    $result = $results[0];
    Clipbucket_db::getInstance()->update(tbl('conversion_queue'), ['cqueue_conversion', 'time_started'], ['p', time()], " cqueue_id = '" . $result['cqueue_id'] . "'");
    return $result;
}

/**
 * Function used to get video being processed
 *
 * @param null $queueName
 *
 * @return array|bool
 * @throws Exception
 */
function get_video_being_processed($queueName = null)
{
    $query = 'SELECT * FROM ' . tbl('conversion_queue');
    $query .= " WHERE cqueue_conversion='p' AND cqueue_name = '" . $queueName . "'";

    $results = db_select($query);

    if ($results) {
        return $results;
    }
    return false;
}

/**
 * @throws Exception
 */
function get_video_details($vid = null, $basic = false)
{
    if ($vid === null) {
        return false;
    }

    global $cbvid;
    return $cbvid->get_video($vid, false, $basic);
}

/**
 * @throws Exception
 */
function get_video_basic_details($vid)
{
    global $cbvid;
    return $cbvid->get_video($vid, false, true);
}

/**
 * @throws Exception
 */
function get_basic_video_details_from_filename($filename)
{
    global $cbvid;
    return $cbvid->get_video($filename, true, true);
}

/**
 * Function used to get all video files
 *
 * @param $vdetails
 * @param $count_only
 * @param $with_path
 *
 * @return int|mixed
 */
function get_all_video_files($vdetails, $count_only = false, $with_path = false)
{
    $details = get_video_file($vdetails, true, $with_path, true, $count_only);
    if ($count_only) {
        if (!is_array($details)) {
            return 0;
        }
        return count($details);
    }
    return $details;
}

function get_all_video_files_smarty($params)
{
    $vdetails = $params['vdetails'];
    $count_only = $params['count_only'];
    $with_path = $params['with_path'];
    return get_all_video_files($vdetails, $count_only, $with_path);
}

/**
 * Function use to get video files
 *
 * @param      $vdetails
 * @param bool $return_default
 * @param bool $with_path
 * @param bool $multi
 * @param bool $count_only
 * @param bool $hq
 *
 * @return int|mixed
 */
function get_video_file($vdetails, $return_default = true, $with_path = true, $multi = false, $count_only = false, $hq = false)
{
    $custom_video_file_funcs_retun = exec_custom_video_file_funcs($vdetails, $hq);
    if ($custom_video_file_funcs_retun) {
        return $custom_video_file_funcs_retun;
    }

    $fileDirectory = '';
    if (!empty($vdetails['file_directory'])) {
        $fileDirectory = $vdetails['file_directory'] . DIRECTORY_SEPARATOR;
    }

    #Now there is no function so let's continue as
    if (empty($vdetails['file_name'])) {
        return false;
    }

    $vid_files = glob(DirPath::get('videos') . $fileDirectory . $vdetails['file_name'] . '*');

    #replace Dir with URL
    if (is_array($vid_files)) {
        foreach ($vid_files as $file) {
            if (filesize($file) < 100) {
                continue;
            }
            $files_part = explode('/', $file);
            $video_file = $files_part[count($files_part) - 1];

            if ($with_path) {
                $files[] = DirPath::getUrl('videos') . $fileDirectory . $video_file;
            } else {
                $files[] = $video_file;
            }
        }
    }

    if ((!is_array($files) || count($files) == 0) && !$multi && !$count_only) {
        if ($return_default) {
            if ($with_path) {
                return DirPath::getUrl('videos') . 'no_video.mp4';
            }
            return 'no_video.mp4';
        }
        return false;
    }

    if ($multi) {
        return $files;
    }
    if ($count_only) {
        return count($files);
    }

    foreach ($files as $file) {
        if ($hq) {
            if (getext($file) == 'mp4') {
                return $file;
            }
        } else {
            return $file;
        }
    }
    return $files[0];
}

/**
 * Function used to update processed video
 *
 * @param array $file_array
 * @param string $status
 * @throws Exception
 */
function update_processed_video($file_array, string $status = 'Successful')
{
    $file_name = $file_array['cqueue_name'];

    $result = db_select('SELECT * FROM ' . tbl('video') . " WHERE file_name = '$file_name'");
    if ($result) {
        Clipbucket_db::getInstance()->update(tbl('video'), ['status'], [$status], " file_name='" . display_clean($file_name) . "'");
    }
}

/**
 * @throws Exception
 */
function update_video_status($file_name, $status = 'Successful')
{
    Clipbucket_db::getInstance()->update(tbl('video'), ['status'], [$status], " file_name='" . display_clean($file_name) . "'");
}

/**
 * This function will activate the video if file exists
 *
 * @param $vid
 * @throws Exception
 */
function activate_video_with_file($vid)
{
    $vdetails = get_video_basic_details($vid);
    $file_name = $vdetails['file_name'];
    $results = Clipbucket_db::getInstance()->select(tbl('conversion_queue'), '*', " cqueue_name='$file_name' AND cqueue_conversion='yes'");
    $result = $results[0];

    update_processed_video($result);
}

/**
 * Function Used to get video file stats from database
 *
 * @param string $file_name
 * @param bool $get_jsoned
 *
 * @return bool|string|array
 * @throws Exception
 */
function get_file_details($file_name, $get_jsoned = false)
{
    $file_name = mysql_clean($file_name);
    //Reading Log File
    $result = db_select('SELECT * FROM ' . tbl('video') . " WHERE file_name = '" . display_clean($file_name) . "'");

    if ($result) {
        $video = $result[0];
        if ($video['file_server_path']) {
            $file = $video['file_server_path'] . '/logs/' . $video['file_directory'] . $file_name . '.log';
        } else {
            $str = $video['file_directory'] . DIRECTORY_SEPARATOR;
            $file = DirPath::get('logs') . $str . $file_name . '.log';
        }
    }

    //saving log in a variable
    $data = file_get_contents($file);

    if (empty($data)) {
        $file = $file_name;
        $data = file_get_contents($file);
    }
    if (!empty($data)) {
        if (!$get_jsoned) {
            return $data;
        }

        preg_match_all('/(.*) : (.*)/', trim($data), $matches);

        $matches_1 = ($matches[1]);
        $matches_2 = ($matches[2]);

        for ($i = 0; $i < count($matches_1); $i++) {
            $statistics[trim($matches_1[$i])] = trim($matches_2[$i]);
        }
        if (count($matches_1) == 0) {
            return false;
        }
        $statistics['conversion_log'] = $data;
        return $statistics;
    }
    return false;
}

/**
 * use regex to get thumb's num
 *
 * @param $name
 *
 * @return string
 */
function get_thumb_num($name): string
{
    $regex = '`.*-.*-(\d+)(?:-[cbp])?.\w+`';
    $match = [];
    preg_match($regex, $name, $match);
    return $match[1] ?? '' ;
}

/**
 * Function used to remove specific thumbs number
 *
 * @param $videoDetails
 * @param $num
 * @throws Exception
 */
function delete_video_thumb($videoDetails, $num, $type)
{
    $db = Clipbucket_db::getInstance();
    $type_file = array_search($type,Upload::getInstance()->types_thumb);
    if (!empty($type_file) && in_array($type_file,['p','b']) ) {
        $type_search = '-' . $type_file . '.*';
        $lang_key = $type;
    } else {
        $type_search = '[-.]*';
        $lang_key = 'thumbs';
    }
    $files = glob(DirPath::get('thumbs') . $videoDetails['file_directory'] . DIRECTORY_SEPARATOR . $videoDetails['file_name'] . '*-' . $num .$type_search);
    if ($files) {
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
        e(lang($lang_key . '_delete_successfully'), 'm');
    } else {
        e(lang('video_thumb_delete_err'));
    }

    Clipbucket_db::getInstance()->delete(tbl('video_thumbs'), ['videoid', 'num'], [$videoDetails['videoid'], $num]);

    //check if there are thumbs left
    $thumbs = Clipbucket_db::getInstance()->select(tbl('video_thumbs'), '*', ' videoid = ' . mysql_clean($videoDetails['videoid']));
    if (count($thumbs) == 0) {
        create_thumb($videoDetails, '', '');
    }
    switch ($type_file) {
        case 'p':
            if ($videoDetails['default_poster'] == $num) {
                Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('video') . ' SET `default_poster` = IFNULL((SELECT MIN( CASE WHEN num = \'\' THEN 0 ELSE CAST(num AS INTEGER) END)  FROM ' . tbl('video_thumbs') . ' WHERE videoid = ' . mysql_clean($videoDetails['videoid']) . ' AND type = \'poster\' ), 0) WHERE videoid = ' . mysql_clean($videoDetails['videoid']), 'update');
            }
            break;
        case 'b':
            if ($videoDetails['default_backdrop'] == $num) {
                Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('video') . ' SET `default_backdrop` = IFNULL((SELECT MIN( CASE WHEN num = \'\' THEN 0 ELSE CAST(num AS INTEGER) END)  FROM ' . tbl('video_thumbs') . ' WHERE videoid = ' . mysql_clean($videoDetails['videoid']) . ' AND type = \'backdrop\' ), 0) WHERE videoid = ' . mysql_clean($videoDetails['videoid']), 'update');
            }
            break;
        default:
            if ($videoDetails['default_thumb'] == $num) {
                Clipbucket_db::getInstance()->execute('UPDATE ' . tbl('video') . ' SET `default_thumb` = IFNULL((SELECT MIN( CASE WHEN num = \'\' THEN 0 ELSE cast(num AS INTEGER) END)  FROM ' . tbl('video_thumbs') . ' WHERE videoid = ' . mysql_clean($videoDetails['videoid']) . ' AND type IN (\'auto\', \'custom\')) , 0) WHERE videoid = ' . mysql_clean($videoDetails['videoid']), 'update');
            }
            break;
    }
}

/**
 * function used to remove video thumbs
 *
 * @param $vdetails
 * @throws Exception
 */
function remove_video_thumbs($vdetails)
{
    global $cbvid;
    $cbvid->remove_thumbs($vdetails);
}

/**
 * function used to remove video log
 *
 * @param $vdetails
 * @throws Exception
 */
function remove_video_log($vdetails)
{
    global $cbvid;
    $cbvid->remove_log($vdetails);
}

/**
 * function used to remove video files
 *
 * @param $vdetails
 *
 * @return bool|void
 * @throws Exception
 */
function remove_video_files($vdetails)
{
    global $cbvid;
    return $cbvid->remove_files($vdetails);
}

/**
 * @throws Exception
 */
function remove_video_subtitles($vdetails)
{
    global $cbvid;
    $cbvid->remove_subtitles($vdetails);
}

/**
 * Function used to call functions
 * when video is going to watched
 * ie in watch_video.php
 *
 * @param $vdo
 * @throws Exception
 */
function call_watch_video_function($vdo)
{
    $funcs = get_functions('watch_video_functions');

    if (is_array($funcs) && count($funcs) > 0) {
        foreach ($funcs as $func) {
            if (function_exists($func)) {
                $func($vdo);
            }
        }
    }

    increment_views_new($vdo['videokey'], 'video');

    $userid = user_id();
    if ($userid) {
        userquery::getInstance()->increment_watched_videos($userid);
    }
}

/**
 * Function used to call functions
 * when video is going
 * on CBvideo::remove_files
 *
 * @param $vdo
 */
function call_delete_video_function($vdo)
{
    $funcs = get_functions('on_delete_video');
    if (is_array($funcs) && count($funcs) > 0) {
        foreach ($funcs as $func) {
            if (function_exists($func)) {
                $func($vdo);
            }
        }
    }
}

/**
 * Function used to call functions
 * when video is going to download
 * ie in download.php
 *
 * @param $vdo
 * @throws Exception
 */
function call_download_video_function($vdo)
{
    $funcs = get_functions('download_video_functions');
    if (is_array($funcs) && count($funcs) > 0) {
        foreach ($funcs as $func) {
            if (function_exists($func)) {
                $func($vdo);
            }
        }
    }

    //Updating Video Downloads
    Clipbucket_db::getInstance()->update(tbl('video'), ['downloads'], ['|f|downloads+1'], "videoid = '" . $vdo['videoid'] . "'");
    //Updating User Download
    if (user_id()) {
        Clipbucket_db::getInstance()->update(tbl('users'), ['total_downloads'], ['|f|total_downloads+1'], "userid = '" . user_id() . "'");
    }
}

/**
 * function used to get videos
 *
 * @param $param
 *
 * @return bool|array|void|int
 * @throws Exception
 */
function get_videos($param)
{
    global $cbvideo;
    return $cbvideo->get_videos($param);
}

/**
 * Function used to check
 * input users are valid or not
 * so that only register usernames can be set
 *
 * @param $users
 *
 * @return string
 * @throws Exception
 */
function video_users($users)
{
    if (!empty($users)) {
        $users_array = explode(',', $users);
    }
    $new_users = [];
    foreach ($users_array as $user) {
        if ($user != user_name() && !is_numeric($user) && userquery::getInstance()->user_exists($user)) {
            $new_users[] = $user;
        }
    }

    $new_users = array_unique($new_users);

    if (count($new_users) > 0) {
        return implode(',', $new_users);
    }
    return " ";
}

/**
 * function used to check weather logged in user is
 * is in video users or not
 *
 * @param      $vdo
 * @param null $user
 *
 * @return bool
 */
function is_video_user($vdo, $user = null): bool
{
    if (!$user) {
        $user = user_name();
    }

    if (is_array($vdo)) {
        $video_users = $vdo['video_users'];
    } else {
        $video_users = $vdo;
    }

    $users_array = explode(',', $video_users);
    $users_array = array_filter(array_map('trim', $users_array));
    if (in_array($user, $users_array)) {
        return true;
    }
    return false;
}

/**
 * function used to get allowed extension as in array
 */
function get_vid_extensions(): array
{
    $exts = config('allowed_video_types');
    $exts = preg_replace('/ /', '', $exts);
    return explode(',', $exts);
}

function register_custom_video_file_func($method, $class = null): bool
{
    if (empty($method)) {
        return false;
    }

    global $Cbucket;
    if (empty($class)) {
        $Cbucket->custom_video_file_funcs[] = $method;
    } else {
        $Cbucket->custom_video_file_funcs[] = [
            'class'    => $class
            , 'method' => $method
        ];
    }
    return true;
}

function get_custom_video_file_funcs()
{
    global $Cbucket;
    return $Cbucket->custom_video_file_funcs;
}

function exec_custom_video_file_funcs($vdetails, $hq = false)
{
    $custom_video_file_funcs = get_custom_video_file_funcs();
    if (!empty($custom_video_file_funcs)) {
        foreach ($custom_video_file_funcs as $func) {
            if (is_array($func)) {
                $class = $func['class'];
                $method = $func['method'];
                if (method_exists($class, $method)) {
                    $func_return = $class::$method($vdetails, $hq);
                    if ($func_return) {
                        return $func_return;
                    }
                }
            } else {
                if (function_exists($func)) {
                    $func_return = $func($vdetails, $hq);
                    if ($func_return) {
                        return $func_return;
                    }
                }
            }
        }
    }
    return false;
}

/**
 * Function used to get list of videos files
 * @param      $vdetails
 * @param bool $with_path
 * @param bool $multi
 * @param bool $count_only
 * @param bool $hq
 *
 * @return array|bool|string
 *
 * @throws Exception
 */
function get_video_files($vdetails, $with_path = true, $multi = false, $count_only = false, $hq = false)
{
    if( $vdetails['status'] != 'Successful' || empty($vdetails['file_directory']) || empty($vdetails['file_name']) || empty($vdetails['file_type']) ){
        if ($with_path) {
            return [DirPath::getUrl('videos') . 'no_video.mp4'];
        }
        return ['no_video.mp4'];
    }

    $custom_video_file_funcs_retun = exec_custom_video_file_funcs($vdetails, $hq);
    if ($custom_video_file_funcs_retun) {
        return $custom_video_file_funcs_retun;
    }

    if( empty($vdetails['video_files']) ){
        update_video_files($vdetails);
        $vdetails = get_video_details($vdetails['videoid']);
    }

    if( empty($vdetails['video_files']) || empty(json_decode($vdetails['video_files'])) ){
        if ($with_path) {
            return [DirPath::getUrl('videos') . 'no_video.mp4'];
        }
        return ['no_video.mp4'];
    }

    $vid_files = [];
    switch($vdetails['file_type']){
        default:
        case 'mp4':
            $video_qualities = json_decode($vdetails['video_files']);
            foreach($video_qualities as $quality){
                if (empty($quality)) {
                    $file_name = $vdetails['file_name'] . '.mp4';
                } else {
                    $file_name = $vdetails['file_name'] . '-' . $quality . '.mp4';
                }
                if( !$with_path ) {
                    $vid_files[] = $file_name;
                } else {
                    if ($vdetails['video_version'] == 'COMMERCIAL') {
                        $vid_files[] = DirPath::getUrl('videos') . $vdetails['file_directory'] . '/' . $vdetails['file_name'] . '/' . $file_name;
                    } else {
                        if ($vdetails['video_version'] >= '2.7') {
                            $vid_files[] = DirPath::getUrl('videos') . $vdetails['file_directory'] . '/' . $file_name;
                        } else {
                            $vid_files[] = DirPath::getUrl('videos') . $file_name;
                        }
                    }
                }
            }
            break;

        case 'hls':
            $file_name = 'index.m3u8';
            if( !$with_path ) {
                $vid_files[] = $file_name;
            } else {
                $vid_files[] = DirPath::getUrl('videos') . $vdetails['file_directory'] . '/' . $vdetails['file_name'] . '/' . $file_name;
            }
            break;
    }
    return $vid_files;
}

function thumbs_res_settings_28(): array
{
    return [
        'original' => 'original',
        '105'      => ['168', '105'],
        '260'      => ['416', '260'],
        '320'      => ['632', '395'],
        '480'      => ['768', '432']
    ];
}

/**
 * @throws Exception
 */
function get_high_res_file($vdetails): string
{
    $custom_video_file_funcs_retun = exec_custom_video_file_funcs($vdetails);
    if ($custom_video_file_funcs_retun) {
        return $custom_video_file_funcs_retun;
    }

    $video_qualities = json_decode($vdetails['video_files']);

    if( empty($video_qualities) ){
        return false;
    }

    if (is_int($video_qualities[0])) {
        $max_quality = max($video_qualities);
    } else {
        if (in_array('hd', $video_qualities)) {
            $max_quality = 'hd';
        } else {
            $max_quality = 'sd';
        }
    }

    $filepath = DirPath::get('videos') . $vdetails['file_directory'] . DIRECTORY_SEPARATOR;
    switch ($vdetails['file_type']) {
        default:
        case 'mp4':
            return $filepath . $vdetails['file_name'] . '-' . $max_quality . '.mp4';

        case 'hls':
            global $myquery;
            $video_quality_title = $myquery->getVideoResolutionTitleFromHeight($max_quality);
            return $filepath . $vdetails['file_name'] . DIRECTORY_SEPARATOR . 'video_' . $video_quality_title . '.m3u8';
    }
}

/**
 * Fetches quicklists stored in cookies
 *
 * @param bool $cookie_name
 *
 * @return array : { array } { $vid_dets } { an array with all details of videos in quicklists }
 *
 * @throws Exception
 * @since : 18th March, 2016 ClipBucket 2.8.1
 * @author : Saqib Razzaq <saqi.cb@gmail.com>
 * @internal param $ : { string } { $cookie_name } { false by default, read from certain cookie }
 */
function get_fast_qlist($cookie_name = false): array
{
    global $cbvid;
    if ($cookie_name) {
        $cookie = $cookie_name;
    } else {
        $cookie = 'fast_qlist';
    }

    $raw_cookies = $_COOKIE[$cookie] ?? false;
    $clean_cookies = str_replace(['[', ']'], '', $raw_cookies);
    $vids = explode(',', $clean_cookies);
    assign('qlist_vids', $vids);
    $vid_dets = [];

    foreach ($vids as $vid) {
        if( !empty($vid) ){
            $vid_dets[] = $cbvid->get_video($vid);
        }
    }

    return array_filter($vid_dets);
}

/**
 * @throws Exception
 */
function must_check_age(): bool
{
    $min_age_reg = config('min_age_reg');
    if( config('enable_global_age_restriction') != 'yes' || $min_age_reg > 99 || $min_age_reg < 0 ){
        return false;
    }

    $user = User::getInstance();
    if( $user->isUserConnected() && $user->getCurrentUserAge() >= $min_age_reg ){
        return false;
    }

    return ((empty($_COOKIE['age_restrict']) || $_COOKIE['age_restrict']!='checked')  );
}

function dateNow(): string
{
    return date('Y-m-d H:i:s');
}

/**
 * Set status or reconversion status for any given video
 *
 * @param      $video
 * @param      $status
 * @param bool $reconv
 * @param bool $byFilename
 *
 * @throws Exception
 * @internal param $ : { mixed } { $video } { videoid, videokey or filename }
 * @internal param $ : { string } { $status } { new status to be set } { $status } { new status to be set }
 * @internal param $ : { boolean } { $reconv } { if you are setting reconversion status, pass this true }
 * @internal param $ : { boolean } { $byFileName } { if you passed file_name in first parameter, you will need to pass this true as well }
 * @since : 31st October, 2016
 * @author : Saqib Razzaq
 *
 * @action : Updates database
 */
function setVideoStatus($video, $status, $reconv = false, $byFilename = false)
{
    if ($byFilename) {
        $type = 'file_name';
    } else {
        if (is_numeric($video)) {
            $type = 'videoid';
        } else {
            $type = 'videokey';
        }
    }

    if ($reconv) {
        $field = 're_conv_status';
    } else {
        $field = 'status';
    }

    Clipbucket_db::getInstance()->update(tbl('video'), [$field], [$status], "$type='$video'");
}


/**
 * Checks current reconversion status of any given video : default is empty
 * @param : { integer } { $vid } { id of video that we need to check status for }
 * @return string|void : { reconversion status of video }
 * @throws Exception
 */
function checkReConvStatus($vid)
{
    $data = Clipbucket_db::getInstance()->select(tbl('video'), 're_conv_status', 'videoid=' . $vid);
    if (isset($data[0]['re_conv_status'])) {
        return $data[0]['re_conv_status'];
    }
}

function get_audio_channels($filepath): int
{
    $cmd = System::get_binaries('ffprobe') . ' -show_entries stream=channels -of compact=p=0:nk=1 -v 0 ' . $filepath . ' | grep .';
    return (int)shell_exec($cmd) ?? 0;
}

/**
 * @throws Exception
 */
function update_castable_status($vdetails)
{
    if (is_null($vdetails) || $vdetails['status'] != 'Successful' || empty($vdetails['video_files']) ) {
        return;
    }

    $filepath = get_high_res_file($vdetails);
    $data = get_audio_channels($filepath);

    if ($data <= 2 && $vdetails['is_castable'] == 0) {
        Clipbucket_db::getInstance()->update(tbl('video'), ['is_castable'], [true], 'videoid=' . $vdetails['videoid']);
        e(lang('castable_status_fixed', $vdetails['title']), 'm');
    } else {
        if ($data > 2) {
            e(lang('castable_status_failed', $vdetails['title'], $data), 'w');
        }
    }
}

/**
 * @throws Exception
 */
function update_video_files($vdetails)
{
    $fileDirectory = $vdetails['file_directory'] . DIRECTORY_SEPARATOR;
    $video_qualities = [];
    switch ($vdetails['file_type'])
    {
        default:
        case 'mp4':
            if ($vdetails['video_version'] == 'COMMERCIAL') {
                $list_videos = glob(DirPath::get('videos') . $fileDirectory . $vdetails['file_name'] . DIRECTORY_SEPARATOR . $vdetails['file_name'] . '*.' . $vdetails['file_type']);
            } else {
                if ($vdetails['video_version'] >= '2.7') {
                    $list_videos = glob(DirPath::get('videos') . $fileDirectory . $vdetails['file_name'] . '*.' . $vdetails['file_type']);
                } else {
                    $list_videos = glob(DirPath::get('videos') . $vdetails['file_name'] . '*.' . $vdetails['file_type']);
                }
            }

            foreach ($list_videos as  $path) {
                $filename = basename($path);

                if( strpos($filename, '-') === false ) {
                    $video_qualities[] = '';
                } else {
                    $quality = explode('-', $filename);
                    $quality = explode('.', end($quality));
                    if( is_numeric($quality[0]) ){
                        $video_qualities[] = (int)$quality[0];
                    } else {
                        $video_qualities[] = $quality[0];
                    }
                }
            }
            break;

        case 'hls':
            $list_videos = glob(DirPath::get('videos') . $fileDirectory . $vdetails['file_name'] . DIRECTORY_SEPARATOR . 'video_*.m3u8');
            foreach ($list_videos as  $path) {
                $quality = explode('video_', $path);
                $quality = explode('p.',end($quality));
                $quality = reset($quality);
                $video_qualities[] = (int)$quality;
            }
            break;
    }

    sort($video_qualities, SORT_NUMERIC);

    Clipbucket_db::getInstance()->update(tbl('video'), ['video_files'], [json_encode($video_qualities)], ' videoid = '.display_clean($vdetails['videoid']));
}

/**
 * @throws Exception
 */
function update_bits_color($vdetails)
{
    if (is_null($vdetails) || $vdetails['status'] != 'Successful' || empty($vdetails['video_files']) ) {
        return;
    }

    $filepath = get_high_res_file($vdetails);
    $cmd = System::get_binaries('ffprobe') . ' -show_streams ' . $filepath . ' 2>/dev/null | grep "bits_per_raw_sample" | grep -v "N/A" | awk -v FS="=" \'{print $2}\'';
    $data = shell_exec($cmd);

    Clipbucket_db::getInstance()->update(tbl('video'), ['bits_color'], [(int)$data], 'videoid=' . $vdetails['videoid']);
}

/**
 * Checks if given video is reconvertable or not
 *
 * @param : { array } { $vdetails } { an array with all details regarding video }
 *
 * @return bool : { boolean } { returns true or false depending on matched case }
 *
 * @since : 14th November October, 2016
 * @author : Fahad Abbas
 *
 */
function isReconvertAble($vdetails): bool
{
    try {
        if (is_array($vdetails) && !empty($vdetails)) {
            $fileName = $vdetails['file_name'];
            $fileDirectory = $vdetails['file_directory'];

            $is_convertable = false;
            if (empty($vdetails['file_server_path'])) {
                if (!empty($fileDirectory)) {
                    $path = DirPath::get('videos') . $fileDirectory . DIRECTORY_SEPARATOR . $fileName . '*';
                } else {
                    $path = DirPath::get('videos') . $fileName . '*';
                }
                $vid_files = glob($path);
                if (!empty($vid_files) && is_array($vid_files)) {
                    $is_convertable = true;
                }
            } else {
                $is_convertable = true;
            }
            if ($is_convertable) {
                return true;
            }
            return false;
        }
        return false;
    } catch (\Exception $e) {
        echo 'Caught exception : ', $e->getMessage(), "\n";
        return false;
    }
}

/**
 * Reconvert any given video in ClipBucket. It will work fine with flv as well as other older files
 * as well. You must have at least one video quality available in system for this to work
 *
 * @param string $data
 *
 * @throws Exception
 * @author : { Saqib Razzaq }
 * @since : October 28th, 2016
 */
function reConvertVideos($data = '')
{
    global $cbvid, $Upload, $myquery;
    $toConvert = 0;
    // if nothing is passed in data array, read from $_POST
    if (!is_array($data)) {
        $data = $_POST;
    }

    // a list of videos to be reconverted
    $videos = $data['check_video'];

    if (isset($_GET['reconvert_video'])) {
        $videos[] = $_GET['reconvert_video'];
    }

    // Loop through all video ids
    foreach ($videos as $daVideo) {
        // get details of single video
        $vdetails = $cbvid->get_video($daVideo);

        if (!empty($vdetails['file_server_path'])) {
            if (empty($vdetails['file_directory'])) {
                $vdetails['file_directory'] = str_replace('-', '/', $vdetails['datecreated']);
            }
            setVideoStatus($daVideo, 'Processing');

            $encoded['file_directory'] = $vdetails['file_directory'];
            $encoded['file_name'] = $vdetails['file_name'];
            $encoded['re-encode'] = true;

            $api_path = str_replace('/files', '', $vdetails['file_server_path']);
            $api_path .= '/actions/re_encode.php';

            $request = curl_init($api_path);
            curl_setopt($request, CURLOPT_POST, true);
            curl_setopt($request, CURLOPT_POSTFIELDS, $encoded);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            $results_curl = curl_exec($request);
            $results_curl_arr = json_decode($results_curl, true);
            $returnCode = (int)curl_getinfo($request, CURLINFO_HTTP_CODE);
            curl_close($request);

            if (isset($results_curl_arr['success']) && $results_curl_arr['success'] == 'yes') {
                e(lang('Your request for re-encoding ' . $vdetails['title'] . ' has been queued.'), 'm');
            }

            if (isset($results_curl_arr['error']) && $results_curl_arr['error'] == 'yes') {
                e(lang($results_curl_arr['msg']));
            }
        } else {
            if (!isReconvertAble($vdetails)) {
                e('Video with id ' . $vdetails['videoid'] . ' is not re-convertable');
                continue;
            }
            if (checkReConvStatus($vdetails['videoid']) == 'started') {
                e('Video with id : ' . $vdetails['videoid'] . ' is already processing');
                continue;
            }

            $toConvert++;
            e('Started re-conversion process for id ' . $vdetails['videoid'], 'm');

            setVideoStatus($daVideo, 'Processing');

            switch ($vdetails['file_type']) {
                default:
                case 'mp4':
                    $max_quality_file = get_high_res_file($vdetails);
                    $conversion_filepath = DirPath::get('temp') . $vdetails['file_name'] . '.mp4';
                    copy($max_quality_file, $conversion_filepath);
                    $Upload->add_conversion_queue($vdetails['file_name'] . '.mp4');
                    break;
                case 'hls':
                    $conversion_dir = DirPath::get('temp') . $vdetails['file_name'] . DIRECTORY_SEPARATOR;
                    mkdir($conversion_dir);
                    $max_quality = max(json_decode($vdetails['video_files']));
                    $conversion_filepath = $conversion_dir . $max_quality . '.m3u8';
                    $original_files_path = DirPath::get('videos') . $vdetails['file_directory'] . DIRECTORY_SEPARATOR . $vdetails['file_name'] . DIRECTORY_SEPARATOR . $max_quality . '*';
                    foreach (glob($original_files_path) as $file) {
                        $files_part = explode('/', $file);
                        $video_file = $files_part[count($files_part) - 1];
                        if ($video_file == $max_quality . '.m3u8') {
                            $video_file = $vdetails['file_name'] . '.m3u8';
                        }
                        copy($file, $conversion_dir . $video_file);
                    }
                    $Upload->add_conversion_queue($vdetails['file_name'] . '.m3u8', $vdetails['file_name'] . DIRECTORY_SEPARATOR, $vdetails['file_name']);
                    break;
            }

            remove_video_files($vdetails);

            $logFile = DirPath::get('logs') . $vdetails['file_directory'] . DIRECTORY_SEPARATOR . $vdetails['file_name'] . '.log';
            exec(System::get_binaries('php') . ' -q ' . DirPath::get('actions')  . "video_convert.php {$conversion_filepath} {$vdetails['file_name']} {$vdetails['file_directory']} {$logFile} '' 'reconvert' > /dev/null &");

            setVideoStatus($daVideo, 'started', true);
        }

    }
    if ($toConvert >= 1) {
        e("Reconversion is underway. Kindly don't run reconversion on videos that are already reconverting. Doing so may cause things to become lunatic fringes :P", "w");
    }
}

/**
 * @param $data
 * @param bool $regenerate
 * @return void
 * @throws Exception
 */
function generatingMoreThumbs($data, bool $regenerate = false)
{
    $vid_file = get_high_res_file($data);
    require_once DirPath::get('classes') . 'sLog.php';
    $log = new SLog();
    require_once DirPath::get('classes') . 'conversion/ffmpeg.class.php';
    $ffmpeg = new FFMpeg($log);
    $ffmpeg->input_details['duration'] = $data['duration'];
    $ffmpeg->input_file = $vid_file;
    $ffmpeg->file_directory = $data['file_directory'];
    $ffmpeg->file_name = $data['file_name'];
    if ($regenerate) {
        $ffmpeg->generateAllThumbs();
    } else {
        $ffmpeg->generateAllMissingThumbs();
    }

    if( !error() && !warning() ) {
        errorhandler::getInstance()->flush();
        e(lang('video_thumbs_regenerated'), 'm');
    }

    Clipbucket_db::getInstance()->update(tbl('video'), ['thumbs_version'], [VERSION], ' file_name = \'' . $data['file_name'] . '\'');
}

/**
 * @param $vdetails
 * @return void
 * @throws Exception
 */
function update_duration($vdetails)
{
    if (is_null($vdetails)) {
        return;
    }

    $filepath = get_high_res_file($vdetails);
    require_once DirPath::get('classes') . 'conversion/ffmpeg.class.php';
    $data = FFMpeg::get_video_basic_infos($filepath);

    if (isset($data['duration'])) {
        Clipbucket_db::getInstance()->update(tbl('video'), ['duration'], [(int)$data['duration']], 'videoid=' . $vdetails['videoid']);
    }
}

/**
 * @param $data
 * @return array
 */
function getResolution_list($data): array
{
    $resolution_list = [];
    foreach (json_decode($data['video_files']) as $video_file) {
        switch ($data['file_type']) {
            default:
            case 'mp4':
                $path = DirPath::get('videos') . $data['file_directory'] . DIRECTORY_SEPARATOR . $data['file_name'] . '-' . $video_file . '.' . $data['file_type'];
                if (file_exists($path)) {
                    $nb_file = 1;
                    $size = filesize($path);
                } else {
                    $nb_file = 0;
                    $size = 0;
                }
                break;
            case 'hls':
                $info = getHlsFilesInfo($video_file, $data);
                $size = $info['files_size'];
                $nb_file = $info['nb_file'];
                break;
        }
        if ($nb_file > 0) {
            $resolution_list[] = [
                'resolution' => $video_file,
                'size'       => formatfilesize($size),
                'nb_files'   => $nb_file
            ];
        }
    }
    return $resolution_list;
}

/**
 * @param $resolution
 * @param $data
 * @return array
 */
function getHlsFilesInfo($resolution, $data): array
{
    //get list nb files + size hls
    $path = DirPath::get('videos') . $data['file_directory'] . DIRECTORY_SEPARATOR . $data['file_name'] . DIRECTORY_SEPARATOR;
    $files = glob($path . 'video_' . $resolution . '*');
    $nb = 0;
    $size = 0;
    foreach ($files as $file) {
        $nb++;
        $size += filesize($file);
    }
    return ['nb_file' => $nb, 'files_size' => $size];
}

/**
 * @param $log_file
 * @return void
 */
function reset_video_log($log_file)
{
    $file_to_delete = '';
    $base = basename($log_file, '.log');
    if (!array_key_exists($base, AdminTool::getTemp())) {
        $file_to_delete = $log_file;
    } elseif (AdminTool::getTemp()[$base]['status'] == 'Successful') {
        $file_to_delete = $log_file;
    }

    if ($file_to_delete != '') {
        unlink($log_file);
        remove_empty_directory_log(dirname($log_file));
    }
}

/**
 * delete empty parent until log root folder
 * @param $path
 * @return void
 */
function remove_empty_directory_log($path)
{
    remove_empty_directory($path, DirPath::get('logs'));
}

/**
 * delete empty parent until $stop_path from files to root
 * @param $path
 * @param string $stop_path path where function has to stop
 * @return void
 */
function remove_empty_directory($path, string $stop_path)
{
    if ($path == $stop_path) {
        return;
    }
    $current_dir_content = array_diff(scandir($path), ['..', '.']);
    if (count($current_dir_content) <= 0) {
        rmdir($path);
        remove_empty_directory(dirname($path), $stop_path);
    }
}

/**
 * @param $file
 * @return void
 */
function clean_orphan_files($file)
{
    if (($file['type'] == 'photo' && in_array($file['photo'], AdminTool::getTemp()['photo']))
    || ( in_array($file['type'], ['video_mp','video_hls','thumb','log','subtitle']) && in_array($file['video'], AdminTool::getTemp()['video']))
    || ( $file['type'] == 'userfeeds' && in_array($file['user'], AdminTool::getTemp()['user']))
    ) {
        return;
    }

    $stop_path = null;
    switch ($file['type']) {
        case 'log':
            unlink($file['data']);
            $stop_path = DirPath::get('logs');
            break;
        case 'video_mp':
            unlink($file['data']);
            $stop_path = DirPath::get('videos');
            break;
        case 'video_hls':
            $files_hls = array_diff(scandir($file['data']), ['.', '..']);
            foreach ($files_hls as $file_hls) {
                unlink($file['data'] . DIRECTORY_SEPARATOR . $file_hls);
            }
            rmdir($file['data']);
            $stop_path = DirPath::get('videos');
            break;
        case 'thumb':
            unlink($file['data']);
            $stop_path = DirPath::get('thumbs');
            break;
        case 'subtitle':
            unlink($file['data']);
            $stop_path = DirPath::get('subtitles');
            break;
        case 'photo':
            unlink($file['data']);
            $stop_path = DirPath::get('photos');
            break;
        case 'userfeeds':
            unlink($file['data']);
            $stop_path = DirPath::getUrl('userfeeds');
            break;
    }
    remove_empty_directory(dirname($file['data']), $stop_path);
}

/**
 * @throws Exception
 */
function age_restriction_check ($user_id, $video_id, $obj_type = 'video', $id_field= 'videoid')
{
    $sql = ' SELECT 
    TIMESTAMPDIFF(YEAR, U.dob, now()),
    CASE
        WHEN O.age_restriction IS NULL THEN 1
        WHEN TIMESTAMPDIFF(YEAR, U.dob, now()) < O.age_restriction THEN 0
            ELSE 1
        END AS can_access
    FROM '.tbl('users') . ' AS U , '.tbl($obj_type) .' AS O
    WHERE O.'.$id_field.' = '.mysql_clean($video_id).' AND U.userid = '.($user_id ? mysql_clean($user_id) :  '0').'
    ' ;
    $rs = select($sql);
    if (!empty($rs)) {
        return $rs[0]['can_access'];
    } else {
        return 0;
    }
}


