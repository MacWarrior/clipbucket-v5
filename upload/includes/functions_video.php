<?php
	/**
	 * File: Video Functions
	 * Description: Various functions to perform operations on VIDEOS section
	 * @license: Attribution Assurance License
	 * @since: ClipBucket 1.0
	 * @author[s]: Arslan Hassan, Fawaz Tahir, Fahad Abbass, Saqib Razzaq
	 * @copyright: (c) 2008 - 2017 ClipBucket / PHPBucket
	 * @notice: Please maintain this section
	 * @modified: { January 10th, 2017 } { Saqib Razzaq } { Updated copyright date }
	 *
	 * @param null $extra
	 */
    function get_video_fields($extra = null) {
        global $cb_columns;
        return $cb_columns->set_object('videos')->get_columns($extra);
    }

	/**
	 * Function used to check video is playlable or not
	 *
	 * @param : { string / id } { $id } { id of key of video }
	 *
	 * @return bool : { boolean } { true if playable, else false }
	 */
    function video_playable($id) {
        global $cbvideo,$userquery;

        if(isset($_POST['watch_protected_video'])) {
            $video_password = mysql_clean(post('video_password'));
        } else {
            $video_password = '';
        }

        if(!is_array($id)) {
            $vdo = $cbvideo->get_video($id);
        } else {
            $vdo = $id;
        }
        $uid = userid();
        if (!$vdo) {
            e(lang("class_vdo_del_err"));
            return false;
        }
        if ($vdo['status']!='Successful') {
            e(lang("this_vdo_not_working"));
            if(!has_access('admin_access',TRUE)) {
                return false;
            }
			return true;
        }
        if ($vdo['broadcast']=='private'
            && !$userquery->is_confirmed_friend($vdo['userid'],userid())
            && !is_video_user($vdo)
            && !has_access('video_moderation',true)
            && $vdo['userid']!=$uid){
            e(lang('private_video_error'));
            return false;
        }
        if ($vdo['active'] == 'pen') {
            e(lang("video_in_pending_list"));
            if (has_access('admin_access',TRUE) || $vdo['userid'] == userid()) {
                return true;
            }
			return false;
        }
        if ($vdo['broadcast']=='logged'
            && !userid()
            && !has_access('video_moderation',true)
            && $vdo['userid']!=$uid) {
            e(lang('not_logged_video_error'));
            return false;
        }
        if ($vdo['active']=='no' && $vdo['userid'] != userid() ) {
            e(lang("vdo_iac_msg"));
            if(!has_access('admin_access',TRUE)) {
                return false;
            }
			return true;
        }
        if ($vdo['video_password']
            && $vdo['broadcast']=='unlisted'
            && $vdo['video_password']!=$video_password
            && !has_access('video_moderation',true)
            && $vdo['userid']!=$uid) {
            if(!$video_password) {
                e(lang("video_pass_protected"));
            } else {
                e(lang("invalid_video_password"));
            }
            template_files("blocks/watch_video/video_password.html",false,false);
        } else {
            $funcs = cb_get_functions('watch_video');

            if ($funcs) {
                foreach($funcs as $func) {
                    $data = $func['func']($vdo);
                    if ($data) {
                        return $data;
                    }
                }
            }
            return true;
        }
    }

	/**
	 * FUNCTION USED TO GET THUMBNAIL
	 *
	 * @param array  $vdetails video_details, or videoid will also work
	 * @param string $num
	 * @param bool   $multi
	 * @param bool   $count
	 * @param bool   $return_full_path
	 * @param bool   $return_big
	 * @param bool   $size
	 *
	 * @return mixed
	 */
    function get_thumb($vdetails,$num='default',$multi=false,$count=false,$return_full_path=true,$return_big=true,$size=false)
	{
        $num = $num ? $num : 'default';
        #checking what kind of input we have
        if(is_array($vdetails))
        {
            if(empty($vdetails['title']))
            {
                #check for videoid
                if(empty($vdetails['videoid']) && empty($vdetails['vid']) && empty($vdetails['videokey'])) {
                    if($multi){
                        return $dthumb[0] = default_thumb();
					}
                    return default_thumb();
                }
                if(!empty($vdetails['videoid'])) {
                    $vid = $vdetails['videoid'];
                } else if(!empty($vdetails['vid'])) {
                    $vid = $vdetails['vid'];
                } else if(!empty($vdetails['videokey'])) {
                    $vid = $vdetails['videokey'];
                } else {
                    if($multi){
                        return $dthumb[0] = default_thumb();
                    }
                    return default_thumb();
                }
            }
        } else {
            if(is_numeric($vdetails)){
                $vid = $vdetails;
			} else {
                if($multi){
                    return $dthumb[0] = default_thumb();
				}
                return default_thumb();
            }
        }

        #checking if we have vid , so fetch the details
        if(!empty($vid)){
            $vdetails = get_video_details($vid);
		}

        #get all possible thumbs of video
        $thumbDir = (isset($vdetails['file_directory']) && $vdetails['file_directory']) ? $vdetails['file_directory'] : '';
        if(!isset($vdetails['file_directory'])){
            $justDate = explode(' ', $vdetails['date_added']);
            $thumbDir = implode('/', explode('-', array_shift($justDate)));
        }
        if(substr($thumbDir, (strlen($thumbDir) - 1)) !== '/'){
            $thumbDir .= DIRECTORY_SEPARATOR;
        }

        $file_dir = '';
        if(isset($vdetails['file_name']) && $thumbDir) {
           $file_dir = DIRECTORY_SEPARATOR.$thumbDir;
        }

        if( !$multi && !$count && $size && isset($vdetails['default_thumb']) ){
            $thumb_file_number = str_pad($vdetails['default_thumb'], strlen(config('num_thumbs')), '0', STR_PAD_LEFT);
            $filepath = $file_dir.$vdetails['file_name'].'-'.$size.'-'.$thumb_file_number.'.jpg';

            if( file_exists(THUMBS_DIR.$filepath) ){
                return THUMBS_URL.$filepath;
            }

            $filepath = $file_dir.$vdetails['file_name'].'-'.$size.'-'.$vdetails['default_thumb'].'.jpg';
            if( file_exists(THUMBS_DIR.$filepath) ){
			    return THUMBS_URL.$filepath;
            }
		}

        $glob = THUMBS_DIR.DIRECTORY_SEPARATOR.$file_dir.$vdetails['file_name'].'*';
        if( $size ){
            $glob .= $size.'*';
        }

        $vid_thumbs = glob($glob);
        #replace Dir with URL
        if(is_array($vid_thumbs)) {
            foreach($vid_thumbs as $thumb){
                if(file_exists($thumb) && filesize($thumb)>0) {
                    $thumb_parts = explode('/',$thumb);
                    $thumb_file = $thumb_parts[count($thumb_parts)-1];

                    //Saving All Thumbs
                    if(!is_big($thumb_file) || $return_big){
                        if($return_full_path){
                            $thumbs[] = THUMBS_URL.'/'.$thumbDir.$thumb_file;
						} else {
                            $thumbs[] = $thumb_file;
						}
                    }
                    //Saving Original Thumbs
                    if (is_original($thumb_file)){
                        if($return_full_path){
                            $original_thumbs[] = THUMBS_URL.'/'.$thumbDir.$thumb_file;
						} else {
                            $original_thumbs[] = $thumb_file;
						}
                    }
                } else if(file_exists($thumb)) {
                    unlink($thumb);
				}
            }
		}

        if(!is_array($thumbs) || count($thumbs) == 0) {
            if($count){
                return 0;
			}
            if($multi){
                return $dthumb[0] = default_thumb();
			}
            return default_thumb();
        }

		//Initializing thumbs settings
		$thumbs_res_settings = thumbs_res_settings_28();

		if($multi){
			if (!empty($original_thumbs) && $size == 'original'){
				return $original_thumbs;
			}
			return $thumbs;
		}

		if($count){
			return count($thumbs);
		}

		//Now checking for thumb
		if($num=='default'){
			$num = $vdetails['default_thumb'];
		}

		if($num=='big' || $size=='big'){
			$num = 'big-'.$vdetails['default_thumb'];
			$num_big_28 = implode('x', $thumbs_res_settings['320']).'-'.$vdetails['default_thumb'];

			$big_thumb_cb26 = THUMBS_DIR.'/'.$vdetails['file_name'].'-'.$num.'.jpg';
			$big_thumb_cb27 = THUMBS_DIR.'/'.$thumbDir.$vdetails['file_name'].'-'.$num.'.jpg';
			$big_thumb_cb28 = THUMBS_DIR.'/'.$thumbDir.$vdetails['file_name'].'-'.$num_big_28.'.jpg';

			if(file_exists($big_thumb_cb26)){
				return THUMBS_URL.'/'.$vdetails['file_name'].'-'.$num.'.jpg';
			}

			if (file_exists($big_thumb_cb27)){
				return THUMBS_URL.'/'.$thumbDir.$vdetails['file_name'].'-'.$num.'.jpg';
			}

			if (file_exists($big_thumb_cb28)){
				return THUMBS_URL.'/'.$thumbDir.$vdetails['file_name'].'-'.$num_big_28.'.jpg';
			}
		}

	   $default_thumb = array_find($vdetails['file_name'].'-'.$size.'-'.$num,$thumbs);

		if(!empty($default_thumb)){
			return $default_thumb;
		} else {
			$default_thumb = array_find($vdetails['file_name'].'-'.$num,$thumbs);
			if (!empty($default_thumb)){
				return $default_thumb;
			}
			return $thumbs[0];
		}
    }

    function get_player_thumbs_json($data){
        $thumbs = get_thumb($data,1,TRUE,FALSE,TRUE,FALSE,'168x105');
        $duration = $data['duration'];
        $json = '';
        if( is_array($thumbs) ){
            $nb_thumbs = count($thumbs);
            $division = $duration / $nb_thumbs;
            $count = 0;
            foreach($thumbs as $url){
                $time = (int)($count*$division);
                if( $json != '' ){
                    $json .= ',';
                }
                $json .= $time.': {
                    src: \''.$url.'\'
                }';
                $count++;
            }
        }

        echo '{'.$json.'}';
    }

    function get_video_subtitles($vdetails)
    {
        global $db;
        $results = $db->select(tbl('video_subtitle'),'videoid,number,title',' videoid='.$vdetails['videoid']);

        if( count($results) == 0 ){
            return false;
        }

        $subtitles = [];
        foreach($results as $line){
            $subtitles[] = [
                'url'=> SUBTITLES_URL.'/'.$vdetails['file_directory'].'/'.$vdetails['file_name'].'-'.$line['number'].'.srt'
                ,'title' => $line['title']
            ];
        }

        return $subtitles;
    }

	/**
	 * Function used to check if given thumb is big or not
	 *
	 * @param : { string } { $thumb_file } { the file to be checked for size }
	 *
	 * @return bool : { boolean } { true if thumb is big, false }
	 */
    function is_big($thumb_file): bool
    {
        if(strstr($thumb_file,'big')) {
            return true;
        }
		return false;
    }

	/**
	 * Function used to check if given thumb is original or not
	 *
	 * @param $thumb_file
	 *
	 * @return bool
	 */
    function is_original($thumb_file): bool
    {
        if(strstr($thumb_file,'original')){
            return true;
		}
		return false;
    }

    function GetThumb($vdetails,$num='default',$multi=false,$count=false)
    {
        return get_thumb($vdetails,$num,$multi,$count);
    }

    /**
     * function used to get default thumb of ClipBucket
     */
    function default_thumb(): string
    {
        if(file_exists(TEMPLATEDIR.'/images/thumbs/processing.png')) {
            return TEMPLATEURL.'/images/thumbs/processing.png';
        }
        if(file_exists(TEMPLATEDIR.'/images/thumbs/processing.jpg')) {
            return TEMPLATEURL.'/images/thumbs/processing.jpg';
        }
		return '/files/thumbs/processing.jpg';
    }

    /**
     * Function used to check weather give thumb is default or not
     */
    function is_default_thumb($i): bool
    {
        if(getname($i)=='processing.jpg'){
            return true;
		}
	   	return false;
    }

	/**
	 * Function used to get video link
	 *
	 * @param      $vdetails
	 * @param null $type
	 *
	 * @return string
	 * @internal param video $ARRAY details
	 */
    function video_link($vdetails,$type=NULL): string
    {
        #checking what kind of input we have
        if(is_array($vdetails)){
            if(empty($vdetails['title'])) {
                #check for videoid
                if(empty($vdetails['videoid']) && empty($vdetails['vid']) && empty($vdetails['videokey'])) {
                    return '/';
                } else {
                    if(!empty($vdetails['videoid'])){
                        $vid = $vdetails['videoid'];
					} else if(!empty($vdetails['vid'])) {
                        $vid = $vdetails['vid'];
					} else if(!empty($vdetails['videokey'])) {
                        $vid = $vdetails['videokey'];
					} else {
                        return '/';
					}
                }
            }
        } else {
            if(is_numeric($vdetails)){
                $vid = $vdetails;
			} else {
                return '/';
			}
        }
        #checking if we have vid , so fetch the details
        if(!empty($vid)){
            $vdetails = get_video_details($vid);
		}

        //calling for custom video link functions
        $functions = cb_get_functions('video_link');
        if($functions) {
            foreach($functions as $func) {
                $array = ['vdetails'=>$vdetails,'type'=>$type];
                if(function_exists($func['func'])) {
                    $returned = $func['func']($array);
                    if($returned) {
                        return $returned;
                    }
                }
            }
        }

        $plist = '';
        if(SEO == 'yes') {
            if($vdetails['playlist_id']){
                $plist = '?play_list='.$vdetails['playlist_id'];
			}

            $vdetails['title'] = strtolower($vdetails['title']);

            switch(config('seo_vido_url'))
            {
                default:
                    $link = BASEURL.'/video/'.$vdetails['videokey'].'/'.SEO(clean(str_replace(' ','-',$vdetails['title']))).$plist;
                    break;
                case 1:
                    $link = BASEURL.'/'.SEO(clean(str_replace(' ','-',$vdetails['title']))).'_v'.$vdetails['videoid'].$plist;
                    break;
                case 2:
                    $link = BASEURL.'/video/'.$vdetails['videoid'].'/'.SEO(clean(str_replace(' ','-',$vdetails['title']))).$plist;
                    break;
                case 3:
                    $link = BASEURL.'/video/'.$vdetails['videoid'].'_'.SEO(clean(str_replace(' ','-',$vdetails['title']))).$plist;
                    break;
            }
        } else {
            if($vdetails['playlist_id']){
                $plist = '&play_list='.$vdetails['playlist_id'];
			}
            $link = BASEURL.'/watch_video.php?v='.$vdetails['videokey'].$plist;
        }
        if(!$type || $type=='link'){
            return $link;
		}
        if($type=='download') {
            return '/download.php?v='.$vdetails['videokey'];
		}
    }

    //Function That will use in creating SEO urls
    function VideoLink($vdetails,$type=NULL): string
    {
        return video_link($vdetails,$type);
    }

	/**
	 * Function Used to format video duration
	 *
	 * @param : array(videoKey or ID, video TITLE)
	 *
	 * @return string|void
	 */
    function videoSmartyLink($params)
    {
        $link = VideoLink($params['vdetails'],$params['type']);
        if(!$params['assign']){
            return $link;
		}
		assign($params['assign'],$link);
    }

	/**
	 * Function used to validate category
	 * INPUT $cat array
	 *
	 * @param null $array
	 *
	 * @return bool
	 */
    function validate_vid_category($array=NULL): bool
    {
        global $cbvid;
        if($array==NULL){
            $array = $_POST['category'];
		}

        if( !is_array($array) ){
            return false;
        }

        if(count($array)==0){
            return false;
		}

		$new_array = [];
		foreach($array as $arr) {
			if($cbvid->category_exists($arr)){
				$new_array[] = $arr;
			}
		}

        if(count($new_array)==0){
            e(lang('vdo_cat_err3'));
            return false;
        }

        if(count($new_array)>ALLOWED_VDO_CATS) {
            e(sprintf(lang('vdo_cat_err2'),ALLOWED_VDO_CATS));
            return false;
        }

        return true;
    }

	/**
	 * Function used to check videokey exists or not
	 * key_exists
	 *
	 * @param $key
	 *
	 * @return bool
	 */
    function vkey_exists($key): bool
    {
        global $db;
        $results = $db->select(tbl('video'),'videokey'," videokey='$key'");
        if(count($results)>0){
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
	 */
    function file_name_exists($name)
    {
        global $db;
        $results = $db->select(tbl('video'),'videoid,file_name'," file_name='$name'");

        if(count($results) > 0){
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
	 */
    function get_queued_video(string $fileName): array
    {
        global $db;

        $queueName = getName($fileName);
        $ext = getExt($fileName);

		$results = $db->select(tbl('conversion_queue'),'*',"cqueue_conversion='no' AND cqueue_name ='$queueName' AND cqueue_ext ='$ext'",1);

		$result = $results[0];
        $db->update(tbl('conversion_queue'),['cqueue_conversion','time_started'],['p',time()]," cqueue_id = '".$result['cqueue_id']."'");
		return $result;
    }

	/**
	 * Function used to get video being processed
	 *
	 * @param null $queueName
	 *
	 * @return array
	 */
    function get_video_being_processed($queueName=NULL): array
    {
        $query = 'SELECT * FROM '.tbl('conversion_queue');
        $query .= " WHERE cqueue_conversion='p' AND cqueue_name = '".$queueName."'";

        $results = db_select($query);

        if($results){
            return $results;
		}
    }

    function get_video_details( $vid = null, $basic = false )
	{
        if( $vid === null ) {
            return false;
        }

		global $cbvid;
        return $cbvid->get_video( $vid, false, $basic );
    }

    function get_video_basic_details( $vid ) {
        global $cbvid;
        return $cbvid->get_video( $vid, false, true );
    }

    function get_video_details_from_filename( $filename, $basic = false ) {
        global $cbvid;
        return $cbvid->get_video( $filename, true, $basic );
    }

    function get_basic_video_details_from_filename( $filename ) {
        global $cbvid;
        return $cbvid->get_video( $filename, true, true );
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
    function get_all_video_files($vdetails,$count_only=false,$with_path=false)
    {
        $details = get_video_file($vdetails,true,$with_path,true,$count_only);
        if($count_only){
            if( !is_array($details) ){
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
        return get_all_video_files($vdetails,$count_only,$with_path);
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
    function get_video_file($vdetails,$return_default=true,$with_path=true,$multi=false,$count_only=false,$hq=false)
    {
        global $Cbucket;
        # checking if there is any other functions
        # available
        if(is_array($Cbucket->custom_video_file_funcs)) {
            foreach($Cbucket->custom_video_file_funcs as $func) {
                if(function_exists($func)) {
                    $func_returned = $func($vdetails, $hq);
                    if($func_returned){
                        return $func_returned;
					}
                }
			}
		}

		$fileDirectory = '';
		if(isset($vdetails['file_directory']) && !empty($vdetails['file_directory'])){
			$fileDirectory = $vdetails['file_directory'].DIRECTORY_SEPARATOR;
		}

        #Now there is no function so let's continue as
        if(isset($vdetails['file_name'])  && !empty($vdetails['file_name'])) {
            $vid_files = glob(VIDEOS_DIR.DIRECTORY_SEPARATOR.$fileDirectory.$vdetails['file_name'].'*');
        } else {
            return false;
        }

        #replace Dir with URL
        if(is_array($vid_files)) {
            foreach($vid_files as $file) {
                if(filesize($file) < 100){
                	continue;
				}
                $files_part = explode('/',$file);
                $video_file = $files_part[count($files_part)-1];

                if($with_path){
                    $files[] = VIDEOS_URL.'/'.$fileDirectory.$video_file;
				} else {
                    $files[] = $video_file;
				}
            }
		}

        if((!is_array($files) || count($files)==0) && !$multi && !$count_only) {
            if($return_default) {
                if($with_path) {
                    return VIDEOS_URL.'/no_video.mp4';
				}
				return 'no_video.mp4';
            }
			return false;
        } else {
            if($multi){
                return $files;
			}
            if($count_only){
                return count($files);
			}

            foreach($files as $file) {
                if($hq) {
                    if(getext($file)=='mp4'){
                        return $file;
					}
                } else {
                    return $file;
                }
            }
            return $files[0];
        }
    }

	/**
	 * Function used to get HQ ie mp4 video
	 *
	 * @param      $vdetails
	 * @param bool $return_default
	 *
	 * @return int|mixed
	 */
    function get_hq_video_file($vdetails,$return_default=true)
    {
        return get_video_file($vdetails,$return_default,true,false,false,true);
    }

	/**
	 * Function used to update processed video
	 *
	 * @param        Files details
	 * @param string $status
	 */
    function update_processed_video($file_array,$status='Successful')
    {
        global $db;
        $file_name = $file_array['cqueue_name'];

		$result = db_select('SELECT * FROM '.tbl('video')." WHERE file_name = '$file_name'");
		if($result) {
			$duration = 0;
			foreach($result as $result1) {
				$str = DIRECTORY_SEPARATOR.$result1['file_directory'].DIRECTORY_SEPARATOR;
				$duration = parse_duration(LOGS_DIR.$str.$file_array['cqueue_name'].'.log');
				if( $duration != 0 ){
					break;
                }
			}

			$db->update(tbl('video'),['status','duration','failed_reason'], [$status, $duration, 'none']," file_name='".$file_name."'");
		}
    }

	/**
	 * This function will activate the video if file exists
	 *
	 * @param $vid
	 */
    function activate_video_with_file($vid)
    {
        global $db;
        $vdetails = get_video_basic_details( $vid );
        $file_name = $vdetails['file_name'];
        $results = $db->select(tbl("conversion_queue"),"*"," cqueue_name='$file_name' AND cqueue_conversion='yes'");
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
	 */
    function get_file_details($file_name,$get_jsoned=false)
    {
    	$file_name = mysql_clean($file_name);
        //Reading Log File
        $result = db_select('SELECT * FROM '.tbl('video')." WHERE file_name = '".$file_name."'");
        
        if($result) {
            $video = $result[0];
            if ($video['file_server_path']){
                $file = $video['file_server_path'].'/logs/'.$video['file_directory'].$file_name.'.log';
            } else {
                $str = DIRECTORY_SEPARATOR.$video['file_directory'].DIRECTORY_SEPARATOR;
                $file = LOGS_DIR.$str.$file_name.'.log';
            }
        }

        //saving log in a variable 
        $data = file_get_contents($file);

        if(empty($data)){
            $file = $file_name;
            $data = file_get_contents($file);
		}
        if(!empty($data)) {
            if(!$get_jsoned){
                return $data;
			}

            preg_match_all('/(.*) : (.*)/',trim($data),$matches);

            $matches_1 = ($matches[1]);
            $matches_2 = ($matches[2]);

            for($i=0;$i<count($matches_1);$i++) {
                $statistics[trim($matches_1[$i])] = trim($matches_2[$i]);
            }
            if(count($matches_1)==0){
                return false;
			}
            $statistics['conversion_log'] = $data;
            return $statistics;
        }
		return false;
    }

    function parse_duration($log)
    {
        $duration = false;

        if(isset($log['output_duration'])){
        	$duration = $log['output_duration'];
		}

        if((!$duration || !is_numeric($duration)) && isset($log['duration'])){
            $duration = $log['duration'];
		}

        if( (!$duration || !is_numeric($duration)) && file_exists($log)) {
        	$log_content = file_get_contents($log);

            preg_match_all('/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9.]{1,5})/i',$log_content,$matches);
            if( isset($matches[1][0]) && isset($matches[2][0]) && isset($matches[3][0]) ) {
				//Now we will multiple hours, minutes accordingly and then add up with seconds to
				//make a single variable of duration
				$hours = $matches[1][0];
				$minutes = $matches[2][0];
				$seconds = $matches[3][0];

				$hours = $hours * 60 * 60;
				$minutes = $minutes * 60;
				$duration = $hours+$minutes+$seconds;
			} else {
				preg_match_all('/<strong>duration<\/strong> : ([0-9.]*)/i',$log_content,$matches);
				if( isset($matches[1][0]) ){
					$duration = $matches[1][0];
				}
			}

        }
        return $duration;
    }

	/**
	 * Function used to get thumbnail number from its name
	 * Updated: If we provide full path for some reason and
	 * web-address has '-' in it, this means our result is messed.
	 * But we know our number will always be in last index
	 * So wrap it with end() and problem solved.
	 *
	 * @param $name
	 *
	 * @return string
	 */
    function get_thumb_num($name): string
    {
        $list = explode( '-', $name);
        $list = end( $list );
        $list = explode('.',$list);
        return  $list[0];
    }

	/**
	 * Function used to remove specific thumbs number
	 *
	 * @param $file_dir
	 * @param $file_name
	 * @param $num
	 */
    function delete_video_thumb($file_dir,$file_name,$num)
    {
        if(!empty($file_dir)){
            $files = glob(THUMBS_DIR.DIRECTORY_SEPARATOR.$file_dir.DIRECTORY_SEPARATOR.$file_name.'*'.$num.'.*');
        } else {
            $files = glob(THUMBS_DIR.DIRECTORY_SEPARATOR.$file_name.'*'.$num.'.*');
        }

        if ($files) {
            foreach ($files as $key => $file) {
                if (file_exists($file)){
                    unlink($file);
                }
            }
            e(lang('video_thumb_delete_msg'),'m');
        } else {
        	e(lang('video_thumb_delete_err'));
        }
    }

	/**
	 * function used to remove video thumbs
	 *
	 * @param $vdetails
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
	 * @return bool
	 */
    function remove_video_files($vdetails)
    {
        global $cbvid;
        return $cbvid->remove_files($vdetails);
    }

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
	 */
    function call_watch_video_function($vdo)
    {
        global $userquery;
        $funcs = get_functions('watch_video_functions');

        if(is_array($funcs) && count($funcs)>0) {
            foreach($funcs as $func){
                if(function_exists($func)) {
                    $func($vdo);
                }
            }
        }

        increment_views_new($vdo['videokey'],'video');

        $userid = userid();
        if($userid){
            $userquery->increment_watched_vides($userid);
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
        if(is_array($funcs) && count($funcs) > 0){
            foreach($funcs as $func) {
                if(function_exists($func)) {
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
	 */
    function call_download_video_function($vdo)
    {
        global $db;
        $funcs = get_functions('download_video_functions');
        if(is_array($funcs) && count($funcs)>0) {
            foreach($funcs as $func) {
                if(function_exists($func)) {
                    $func($vdo);
                }
            }
        }

        //Updating Video Downloads
        $db->update(tbl('video'),['downloads'],['|f|downloads+1'],"videoid = '".$vdo['videoid']."'");
        //Updating User Download
        if(userid()){
            $db->update(tbl('users'),['total_downloads'],['|f|total_downloads+1'],"userid = '".userid()."'");
		}
    }

	/**
	 * function used to get videos
	 *
	 * @param $param
	 *
	 * @return array
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
	 */
    function video_users($users)
    {
        global $userquery;
        if (!empty($users)){
            $users_array = explode(',',$users);
        }
        $new_users = array();
        foreach($users_array as $user) {
            if($user!=user_name() && !is_numeric($user) && $userquery->user_exists($user)) {
                $new_users[] = $user;
            }
        }

        $new_users = array_unique($new_users);

        if(count($new_users)>0){
            return implode(',',$new_users);
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
    function is_video_user($vdo,$user=NULL): bool
    {
        if(!$user){
            $user = user_name();
		}

        if(is_array($vdo)){
            $video_users = $vdo['video_users'];
		} else {
            $video_users = $vdo;
		}

        $users_array = explode(',',$video_users);
        $users_array = array_filter(array_map('trim', $users_array));
        if(in_array($user,$users_array)){
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
        $exts = preg_replace('/ /','',$exts);
        return explode(',',$exts);
    }

	/**
	 * Function used to get list of videos files
	 * ..
	 * ..
	 * @since 2.7
	 *
	 * @param      $vdetails
	 * @param bool $return_default
	 * @param bool $with_path
	 * @param bool $multi
	 * @param bool $count_only
	 * @param bool $hq
	 *
	 * @return array|bool|string
	 */
    function get_video_files($vdetails,$return_default=true,$with_path=true,$multi=false,$count_only=false,$hq=false)
	{
       global $Cbucket;
        # checking if there is any other functions
        # available
        define('VIDEO_VERSION',$vdetails['video_version']);

        if(is_array($Cbucket->custom_video_file_funcs)) {
            foreach($Cbucket->custom_video_file_funcs as $func) {
                if(function_exists($func)) {
                    $func_returned = $func($vdetails, $hq);
                    if($func_returned){
                        return $func_returned;
					}
                }
			}
		}

		$fileDirectory = '';
		if(!empty($vdetails['file_directory'])){
			$fileDirectory = $vdetails['file_directory'].DIRECTORY_SEPARATOR;
		}

        if(isset($vdetails['file_name'])) {
            switch( $vdetails['file_type'] )
            {
                default:
                case 'mp4':
                    if(VIDEO_VERSION >= '2.7'){
                        $vid_files = glob(VIDEOS_DIR.DIRECTORY_SEPARATOR.$fileDirectory.$vdetails['file_name'].'*.'.$vdetails['file_type']);
                    } else {
                        $vid_files = glob(VIDEOS_DIR.DIRECTORY_SEPARATOR.$vdetails['file_name'].'*.'.$vdetails['file_type']);
                    }
                    break;

                case 'hls':
                    $vid_files = glob(VIDEOS_DIR.DIRECTORY_SEPARATOR.$fileDirectory.$vdetails['file_name'].DIRECTORY_SEPARATOR.'*.m3u8');
                    foreach($vid_files as $index => $path){
                        // Only index.m3u8 is kept, this is the only format yet working with audio
                        if(strpos(basename($path), 'audio_') === 0 || strpos(basename($path), 'video_') === 0){
                            unset($vid_files[$index]);
                        }
                    }
                    break;
            }
        }

        #replace Dir with URL
        if(is_array($vid_files)) {
            foreach($vid_files as $file) {

                if(filesize($file) < 100){
                    continue;
                }
                $files_part = explode('/',$file);
                $video_file = $files_part[count($files_part)-1];

                if($with_path){
                    switch( $vdetails['file_type'] )
                    {
                        default:
                        case 'mp4':
                            if(VIDEO_VERSION >= '2.7'){
                                $files[] = VIDEOS_URL.'/'.$fileDirectory.$video_file;
                            } else if(VIDEO_VERSION == '2.6') {
                                $files[] = VIDEOS_URL.'/'.$video_file;
                            }
                            break;

                        case 'hls':
                            if( strpos($video_file, '_vtt') === false ){
                                $files[] = VIDEOS_URL.'/'.$fileDirectory.$vdetails['file_name'].DIRECTORY_SEPARATOR.$video_file;
                            }
                            break;
                    }
                } else {
                    $files[] = $video_file;
				}
            }
		}

        if(!is_array($files) || (count($files) == 0 && !$multi && !$count_only) ){
            if($return_default){
                if($with_path){
                    return VIDEOS_URL.'/no_video.mp4';
				}
				return 'no_video.mp4';
            }
			return false;
        }
		return $files;
    }

    function thumbs_res_settings_28(): array
    {
        return [
            'original' => 'original',
            '105' => ['168','105'],
            '260' => ['416','260'],
            '320' => ['632','395'],
            '480' => ['768','432']
        ];
    }

    function get_high_res_file($vdetails): string
	{
        $video_qualities = json_decode($vdetails['video_files']);
        if (is_int($video_qualities[0])){
            $max_quality = max($video_qualities);
        } else {
            if (in_array('hd', $video_qualities)) {
                $max_quality = 'hd';
            } else {
                $max_quality = 'sd';
            }
        }

        $filepath = VIDEOS_DIR.DIRECTORY_SEPARATOR.$vdetails['file_directory'].DIRECTORY_SEPARATOR;
        switch( $vdetails['file_type'] )
        {
            default:
            case 'mp4':
                return $filepath.$vdetails['file_name'].'-'.$max_quality.'.mp4';

            case 'hls':
                global $myquery;
                $video_quality_title = $myquery->getVideoResolutionTitleFromHeight($max_quality);
                return $filepath.$vdetails['file_name'].DIRECTORY_SEPARATOR.'video_'.$video_quality_title.'.m3u8';
        }
    }

	/**
	 * @author : Fahad Abbas
	 *
	 * @param : { Var } { quality of input file }
	 *
	 * @return string : { Variable } { resolution of a file }
	 *
	 * @since : 03-03-2016
	 */
    function get_video_file_quality($file): string
    {
        $quality = explode('-',$file);
        $quality = end($quality);
        $quality = explode('.',$quality);
        return $quality[0];
    }

	/**
	 * Fetches quicklists stored in cookies
	 *
	 * @param bool $cookie_name
	 *
	 * @return array : { array } { $vid_dets } { an array with all details of videos in quicklists }
	 *
	 * @internal param $ : { string } { $cookie_name } { false by default, read from certain cookie }
	 * @since : 18th March, 2016 ClipBucket 2.8.1
	 * @author : Saqib Razzaq <saqi.cb@gmail.com>
	 */
    function get_fast_qlist($cookie_name = false)
	{
        global $cbvid;
        if ($cookie_name) {
            $cookie = $cookie_name;
        } else {
            $cookie = 'fast_qlist';
        }

        $raw_cookies = $_COOKIE[ $cookie ] ?? false;
        $clean_cookies = str_replace(['[',']'], '', $raw_cookies);
        $vids = explode(',', $clean_cookies);
        assign('qlist_vids', $vids);
        $vid_dets = [];
        foreach ($vids as $vid) {
            $vid_dets[] = $cbvid->get_video_details($vid);
        }

        return array_filter($vid_dets);
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
        global $db;
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

        $db->update(tbl('video'),[$field],[$status],"$type='$video'");
    }


	/**
	 * Checks current reconversion status of any given video : default is empty
	 * @param : { integer } { $vid } { id of video that we need to check status for }
	 * @return string|void : { reconversion status of video }
	 */
	function checkReConvStatus($vid)
	{
		global $db;
		$data = $db->select(tbl('video'),'re_conv_status','videoid='.$vid);
		if (isset($data[0]['re_conv_status'])) {
			return $data[0]['re_conv_status'];
		}
	}

    function get_audio_channels($filepath): int
    {
        if( !file_exists($filepath) ){
            return 0;
        }
        $cmd = get_binaries('ffprobe').' -show_entries stream=channels -of compact=p=0:nk=1 -v 0 '.$filepath.' | grep .';
        return (int)shell_exec( $cmd );
    }

	function update_castable_status($vdetails)
    {
		if( is_null($vdetails) ){
			return;
		}

		global $db;
        $filepath = get_high_res_file($vdetails);
		$data = get_audio_channels($filepath);

		if( $data <= 2 && $vdetails['is_castable'] == 0 ) {
            $db->update( tbl( 'video' ), ['is_castable'], [true], 'videoid='.$vdetails['videoid']);
            e( sprintf( lang( 'castable_status_fixed' ), $vdetails['title'] ), 'm' );
		} else if( $data > 2) {
			e(sprintf( lang('castable_status_failed'), $vdetails['title'], $data),'w');
		}
	}

    function update_bits_color($vdetails)
    {
        if( is_null($vdetails) ){
            return;
        }

        global $db;
        $filepath = get_high_res_file($vdetails);
        $cmd = get_binaries('ffprobe').' -show_streams '.$filepath.' 2>/dev/null | grep "bits_per_raw_sample" | grep -v "N/A" | awk -v FS="=" \'{print $2}\'';
        $data = shell_exec($cmd);

        $db->update(tbl('video'),['bits_color'],[(int)$data],'videoid='.$vdetails['videoid']);
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
        try
		{
            if (is_array($vdetails) && !empty($vdetails))
            {
                $fileName = $vdetails['file_name'];
                $fileDirectory = $vdetails['file_directory'];

				$is_convertable = false;
                if(empty($vdetails['file_server_path'])) {
                    if(!empty($fileDirectory) ){
                        $path = VIDEOS_DIR.DIRECTORY_SEPARATOR.$fileDirectory.DIRECTORY_SEPARATOR. $fileName.'*';
                    } else {
                        $path = VIDEOS_DIR.DIRECTORY_SEPARATOR.$fileName.'*';
                    }
                    $vid_files = glob($path);
                    if (!empty($vid_files) && is_array($vid_files)){
                        $is_convertable = true;
                    }
                } else {
                     $is_convertable = true;
                }
                if ($is_convertable){
                    return true;
				}
				return false;
            }
			return false;
        } catch (Exception $e) {
            echo 'Caught exception : ',  $e->getMessage(), "\n";
            return false;
        }
    }

	/**
	 * Reconvert any given video in ClipBucket. It will work fine with flv as well as other older files
	 * as well. You must have at least one video quality available in system for this to work
	 *
	 * @param string $data
	 *
	 * @since : October 28th, 2016
	 * @author : { Saqib Razzaq }
	 */
    function reConvertVideos($data = '')
	{
        global $cbvid,$Upload,$myquery;
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
        foreach ($videos as $daVideo)
        {
            // get details of single video
            $vdetails = $cbvid->get_video($daVideo);

            if (!empty($vdetails['file_server_path'])) {
                if(empty($vdetails['file_directory'])){
                    $vdetails['file_directory'] = str_replace('-', '/', $vdetails['datecreated']);
                }
                setVideoStatus($daVideo, 'Processing');

                $encoded['file_directory'] = $vdetails['file_directory'];
                $encoded['file_name'] = $vdetails['file_name'];
                $encoded['re-encode'] = true;

                $api_path = str_replace('/files', '', $vdetails['file_server_path']);
                $api_path.= '/actions/re_encode.php';

                $request = curl_init($api_path);
                curl_setopt($request, CURLOPT_POST, true);
                curl_setopt($request,CURLOPT_POSTFIELDS,$encoded);
                curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
                $results_curl = curl_exec($request);
                $results_curl_arr = json_decode($results_curl,true);
                $returnCode = (int)curl_getinfo($request, CURLINFO_HTTP_CODE);
                curl_close($request);

                if(isset($results_curl_arr['success'])&&$results_curl_arr['success']=='yes'){
                    e( lang( 'Your request for re-encoding '.$vdetails[ 'title' ].' has been queued.' ), 'm'  );
                }

                if(isset($results_curl_arr['error'])&&$results_curl_arr['error']=='yes'){
                    e( lang( $results_curl_arr['msg'] ) );
                }
            } else {
                if (!isReconvertAble($vdetails)) {
                    e('Video with id '.$vdetails['videoid'].' is not re-convertable');
                    continue;
                }
                if (checkReConvStatus($vdetails['videoid']) == 'started') {
                    e('Video with id : '.$vdetails['videoid'].' is already processing');
                    continue;
                }

				$toConvert++;
				e('Started re-conversion process for id '.$vdetails['videoid'],'m');

                setVideoStatus($daVideo, 'Processing');

                switch($vdetails['file_type'])
                {
                    default:
                    case 'mp4':
                        $max_quality_file = get_high_res_file($vdetails);
                        $conversion_filepath = TEMP_DIR.DIRECTORY_SEPARATOR.$vdetails['file_name'].'.mp4';
                        copy($max_quality_file,$conversion_filepath);
                        $Upload->add_conversion_queue($vdetails['file_name'].'.mp4');
                        break;
                    case 'hls':
                        $conversion_dir = TEMP_DIR.DIRECTORY_SEPARATOR.$vdetails['file_name'].DIRECTORY_SEPARATOR;
                        mkdir($conversion_dir);
                        $max_quality = max(json_decode($vdetails['video_files']));
                        $conversion_filepath = $conversion_dir.$max_quality.'.m3u8';
                        $original_files_path = VIDEOS_DIR.DIRECTORY_SEPARATOR.$vdetails['file_directory'].DIRECTORY_SEPARATOR.$vdetails['file_name'].DIRECTORY_SEPARATOR.$max_quality.'*';
                        foreach(glob($original_files_path) as $file){
                            $files_part = explode('/',$file);
                            $video_file = $files_part[count($files_part)-1];
                            if( $video_file == $max_quality.'.m3u8' ){
                                $video_file = $vdetails['file_name'].'.m3u8';
                            }
                            copy($file, $conversion_dir.$video_file);
                        }
                        $Upload->add_conversion_queue($vdetails['file_name'].'.m3u8', $vdetails['file_name'].DIRECTORY_SEPARATOR, $vdetails['file_name']);
                        break;
                }

                remove_video_files($vdetails);

                $logFile = LOGS_DIR.DIRECTORY_SEPARATOR.$vdetails['file_directory'].DIRECTORY_SEPARATOR.$vdetails['file_name'].'.log';
                exec(php_path().' -q '.BASEDIR."/actions/video_convert.php {$conversion_filepath} {$vdetails['file_name']} {$vdetails['file_directory']} {$logFile} '' 'reconvert' > /dev/null &");

                setVideoStatus($daVideo, 'started',true);
            }

        }
        if ($toConvert >= 1) {
            e("Reconversion is underway. Kindly don't run reconversion on videos that are already reconverting. Doing so may cause things to become lunatic fringes :P","w");
        }
    }

	/**
	 * Returns cleaned string containing video qualities
	 * @since : 2nd December, 2016
	 *
	 * @param $res
	 *
	 * @return mixed
	 */
    function resString($res) {
        $qual = preg_replace("/[^a-zA-Z0-9-,]+/", "", html_entity_decode($res, ENT_QUOTES));
        if (!empty($qual)) {
            return $qual;
        }
    }

