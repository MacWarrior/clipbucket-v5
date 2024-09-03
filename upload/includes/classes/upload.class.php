<?php
class Upload
{
    var $custom_form_fields = [];  //Step 1 of Uploading
    var $custom_form_fields_groups = []; //Groups of custom fields
    var $custom_upload_fields = []; //Step 2 of Uploading
    var $actions_after_video_upload = ['activate_video_with_file'];

    var $types_thumb = [
        'c' => 'custom',
        'p' => 'poster',
        'b' => 'backdrop',
        'a' => 'auto'
    ];

    public static function getInstance(){
        global $Upload;
        return $Upload;
    }

    /**
     * Function used to validate upload form fields
     *
     * @param null $array
     * @param bool $is_upload
     * @throws \PHPMailer\PHPMailer\Exception|Exception
     */
    function validate_video_upload_form($array = null, $is_upload = false)
    {
        //First Load All Fields in an array
        $required_fields = $this->loadRequiredFields($array);
        $location_fields = $this->loadLocationFields($array);
        $option_fields = $this->loadOptionFields($array);

        $date_recorded = DateTime::createFromFormat(DATE_FORMAT, $location_fields['date_recorded']['value']);
        if ($date_recorded) {
            $location_fields['date_recorded']['value'] = $date_recorded->format('Y-m-d');
        }

        if ($array == null) {
            $array = $_POST;
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        //Merging Array
        $upload_fields = array_merge($required_fields, $location_fields, $option_fields);

        //Adding Custom Upload Fields
        if (count($this->custom_upload_fields) > 0 && $is_upload) {
            $upload_fields = array_merge($upload_fields, $this->custom_upload_fields);
        }
        //Adding Custom Form Fields
        if (count($this->custom_form_fields) > 0) {
            $upload_fields = array_merge($upload_fields, $this->custom_form_fields);
        }

        validate_cb_form($upload_fields, $array);
    }

    /**
     * @throws Exception
     */
    function submit_upload($array = null)
    {
        global $eh;

        if (!$array) {
            $array = $_POST;
        }

        $this->validate_video_upload_form($array, true);

        $errors = $eh->get_error();
        if( !empty($errors) ){
            return false;
        }

        $userid = user_id();
        if (!$userid) {
            if (has_access('allow_video_upload', true, false)) {
                $userid = userquery::getInstance()->get_anonymous_user();
            } else {
                e(lang('you_not_logged_in'));
                return false;
            }
        } else if (!has_access('allow_video_upload', true, true)) {
            e(lang('insufficient_privileges'));
            return false;
        }

        $required_fields = $this->loadRequiredFields($array);
        $location_fields = $this->loadLocationFields($array);
        $option_fields = $this->loadOptionFields($array);
        $empty_fields = [
            'voter_ids'
        ];

        $upload_fields = array_merge($required_fields, $location_fields, $option_fields);
        //Adding Custom Upload Fields
        if (count($this->custom_upload_fields) > 0) {
            $upload_fields = array_merge($upload_fields, $this->custom_upload_fields);
        }
        //Adding Custom Form Fields
        if (count($this->custom_form_fields) > 0) {
            $upload_fields = array_merge($upload_fields, $this->custom_form_fields);
        }

        if (is_array($_FILES)) {
            $array = array_merge($array, $_FILES);
        }

        foreach ($upload_fields as $field) {
            $name = formObj::rmBrackets($field['name']);
            $val = $array[$name];

            if (empty($val) && !empty($field['default_value'])) {
                $val = $field['default_value'];
            }

            if( empty($val) && $field['required'] == 'no'){
                continue;
            }

            if ($field['use_func_val']) {
                $val = $field['validate_function']($val);
            }

            if (!empty($field['db_field'])) {
                $query_field[] = $field['db_field'];
            }

            if( !empty($field['clean_func']) && !apply_func($field['clean_func'], $val) ){
                $val = apply_func($field['clean_func'], $val);
            }

            if (!empty($field['db_field'])) {
                $query_val[] = $val;
            }
        }

        //Adding Video Code
        $query_field[] = 'file_name';
        $file_name = mysql_clean($array['file_name']);
        $query_val[] = $file_name;

        if (!isset($array['file_directory']) && isset($array['time_stamp'])) {
            $query_field[] = 'file_directory';
            $file_directory = create_dated_folder(null, $array['time_stamp']);
            $query_val[] = $file_directory;
        } else {
            if (isset($array['file_directory'])) {
                $query_field[] = 'file_directory';
                $file_directory = mysql_clean($array['file_directory']);
                $query_val[] = $file_directory;
            }
        }

        //Userid
        $query_field[] = 'userid';

        if (!$array['userid']) {
            $query_val[] = $userid;
        } else {
            $query_val[] = $array['userid'];
        }

        if (isset($array['serverUrl'])) {
            $query_field[] = 'file_thumbs_path';
            $query_val[] = $array['thumbsUrl'];
        }

        //video_version
        $query_field[] = 'video_version';
        $query_val[] = VERSION;

        //thumbs_version
        $query_field[] = 'thumbs_version';
        $query_val[] = VERSION;

        //Upload Ip
        $query_field[] = 'uploader_ip';
        $query_val[] = Network::get_remote_ip();

        //Setting Activation Option
        $query_field[] = 'active';
        $query_val[] = config('activation') == 0 ? 'yes' : 'no';

        $query_field[] = 'date_added';
        $query_val[] = dateNow();

        foreach ($empty_fields as $field) {
            $query_field[] = $field;
            $query_val[] = '';
        }

        $insert_id = file_name_exists($file_name);
        if (!$insert_id) {
            //Adding Video Key
            $query_field[] = 'videokey';
            $query_val[] = $this->video_keygen();

            if (config('stay_mp4') == 'yes') {
                $query_field[] = 'status';
                $query_val[] = 'Successful';
            }
            $version = Update::getInstance()->getDBVersion();
            if ($version['version'] < '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] < 264)) {
                $query_field[] = 'tags';
                $query_val[] = '';
            }
            Clipbucket_db::getInstance()->insert(tbl('video'),$query_field, $query_val);
            $insert_id = Clipbucket_db::getInstance()->insert_id();

            Tags::saveTags($array['tags'] ?? '', 'video', $insert_id);
            $version = Update::getInstance()->getDBVersion();
            if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
                Category::getInstance()->saveLinks('video', $insert_id, $array['category']);
            }

            //logging Upload
            $log_array = [
                'success'       => 'yes',
                'action_obj_id' => $insert_id,
                'userid'        => $userid,
                'details'       => $array['title']
            ];
            insert_log('Uploaded a video', $log_array);

            Clipbucket_db::getInstance()->update(tbl('users'), ['total_videos'], ['|f|total_videos+1'], ' userid=\'' . $userid . '\'');

            update_video_status($file_name, 'Waiting');

            //Adding Video Feed
            addFeed([
                'action'    => 'upload_video',
                'object_id' => $insert_id,
                'object'    => 'video'
            ]);
            return $insert_id;
        }

        // Case when video already exists
        Clipbucket_db::getInstance()->update(tbl('video'), $query_field, $query_val, 'file_name = \''.mysql_clean($file_name).'\'');
        return true;
    }

    /**
     * Function used to get available name for video thumb
     *
     * @param $file_name
     * @return string
     * @throws Exception
     */
    function get_next_available_num($file_name): string
    {
        $res = Clipbucket_db::getInstance()->select(tbl('video_thumbs'), 'MAX(CAST(num AS UNSIGNED)) + 1 as num_max', ' videoid = (SELECT videoid FROM ' . tbl('video') . ' WHERE file_name LIKE \'' . mysql_clean($file_name) . '\')');
        if (empty($res)) {
            $code = 0;
        } else {
            $code = $res[0]['num_max'];
        }
        return str_pad((string)$code, 4, '0', STR_PAD_LEFT);
    }

    /**
     * @throws Exception
     */
    function upload_thumb($video_file_name, $file_array, $key = 0, $files_dir = null, $type = 'c')
    {
        global $imgObj;
        $file = $file_array;
        if (!empty($file['name'][$key])) {
            define('dir', $files_dir);

            $file_num = $this->get_next_available_num($video_file_name);
            $ext_original = getExt($file['name'][$key]);
            $ext = 'jpg';
            if ($imgObj->ValidateImage($file['tmp_name'][$key], $ext_original)) {
                $thumbs_settings_28 = thumbs_res_settings_28();
                $temp_file_path = DirPath::get('thumbs') . $files_dir . DIRECTORY_SEPARATOR . $video_file_name . '-' . $file_num . '-'.$type.'.' . $ext;

                $imageDetails = getimagesize($file['tmp_name'][$key]);
                if (is_uploaded_file($file['tmp_name'][$key])) {
                    move_uploaded_file($file['tmp_name'][$key], $temp_file_path);
                } else {
                    rename($file['tmp_name'][$key], $temp_file_path);
                }

                foreach ($thumbs_settings_28 as $key => $thumbs_size) {
                    $height_setting = $thumbs_size[1];
                    $width_setting = $thumbs_size[0];
                    if ($key != 'original') {
                        if ($type != 'c') {
                            continue;
                        }
                        $dimensions = implode('x', $thumbs_size);
                    } else {
                        $dimensions = 'original';
                        $width_setting = $imageDetails[0];
                        $height_setting = $imageDetails[1];
                    }
                    $file_name_final =  $video_file_name . '-' . $dimensions . '-' . $file_num . '-'.$type.'.' . $ext;
                    $outputFilePath = DirPath::get('thumbs') . $files_dir . DIRECTORY_SEPARATOR . $file_name_final;
                    $imgObj->CreateThumb($temp_file_path, $outputFilePath, $width_setting, $ext_original, $height_setting, false);

                    $rs = Clipbucket_db::getInstance()->select(tbl('video'), 'videoid, default_poster, default_backdrop', 'file_name LIKE \'' . $video_file_name . '\'');
                    if (!empty($rs)) {
                        $videoid = $rs[0]['videoid'];
                    } else {
                        e(lang('technical_error'));
                        $videoid = 0;
                    }
                    Clipbucket_db::getInstance()->insert(tbl('video_thumbs'), ['videoid', 'resolution', 'num', 'extension', 'version', 'type'], [$videoid, $dimensions, $file_num, $ext, VERSION, $this->types_thumb[$type]]);
                    if ($type != 'c' && $videoid && $rs[0]['default_' . $this->types_thumb[$type]] == null) {
                        Video::getInstance()->setDefaultPicture($videoid, $file_name_final, $this->types_thumb[$type]);
                    }
                }

                unlink($temp_file_path);
                e(lang($this->types_thumb[$type] . '_upload_successfully'),'m');
            }
        }
    }

    /**
     * Function used to upload video thumbs
     *
     * @param      $file_name
     * @param      $file_array
     * @param null $files_dir
     * @param string $type
     * @throws Exception
     * @internal param $FILE_NAME
     * @internal param array $_FILES name
     */
    function upload_thumbs($file_name, $file_array, $files_dir = null, string $type = 'c')
    {
        if (count($file_array['name']) > 1) {
            for ($i = 0; $i < count($file_array['name']); $i++) {
                $this->upload_thumb($file_name, $file_array, $i, $files_dir, $type);
            }
            e(lang('upload_vid_thumbs_msg'), 'm');
        } else {
            $file = $file_array;
            $this->upload_thumb($file_name, $file, $key = 0, $files_dir, $type);
        }
    }

    /**
     * FUNCTION USED TO LOAD UPLOAD FORM REQUIRED FIELDS
     * title [Text Field]
     * description [Text Area]
     * tags [Text Field]
     * categories [Check Box]
     *
     * @param null $default
     *
     * @return array
     * @throws Exception
     */
    function loadRequiredFields($default = null): array
    {
        if ($default == null) {
            $default = $_POST;
        }

        $title = $default['title'];
        $desc = $default['description'];

        if (is_array($default['category'])) {
            $cat_array = $default['category'];
        } else {
            $cat_array = explode(',', $default['category']);
        }


        $uploadFormRequiredFieldsArray = [
            /**
             * this function will create initial array for fields
             * this will tell
             * array(
             *       title [text that will represents the field]
             *       type [type of field, either radio button, textfield or text area]
             *       name [name of the fields, input NAME attribute]
             *       id [id of the fields, input ID attribute]
             *       value [value of the fields, input VALUE attribute]
             *       id [name of the fields, input NAME attribute]
             *       size
             *       class
             *       label
             *       extra_params
             *       hint_1 [hint before field]
             *       hint_2 [hint after field]
             *       anchor_before [before after field]
             *       anchor_after [anchor after field]
             *      )
             */

            'title' => [
                'title'      => lang('vdo_title'),
                'type'       => 'textfield',
                'name'       => 'title',
                'id'         => 'title',
                'value'      => $title,
                'size'       => '45',
                'db_field'   => 'title',
                'required'   => 'yes',
                'min_length' => config('min_video_title'),
                'max_length' => config('max_video_title')
            ],
            'desc'  => [
                'title'        => lang('vdo_desc'),
                'type'         => 'textarea',
                'name'         => 'description',
                'class'        => 'desc',
                'value'        => $desc,
                'size'         => '35',
                'extra_params' => ' rows="4"',
                'db_field'     => 'description',
                'required'     => 'yes',
                'anchor_after' => 'after_desc_compose_box'
            ],
            'cat'   => [
                'title'             => lang('vdo_cat'),
                'type'              => 'checkbox',
                'name'              => 'category[]',
                'id'                => 'category',
                'value'             => $cat_array,
                'hint_1'            => lang('vdo_cat_msg', config('video_categories')),
                'required'          => 'yes',
                'validate_function' => 'Category::validate',
                'invalid_err'       => lang('vdo_cat_err3'),
                'display_function'  => 'convert_to_categories'
            ],
            'tags_video'  => [
                'title'             => lang('tag_title'),
                'type'              => 'hidden',
                'name'              => 'tags_video',
                'id'                => 'tags_video',
                'value'             => genTags($default['tags_video']),
                'hint_1'            => '',
                'required'          => 'no',
                'validate_function' => 'genTags'
            ]
        ];

        if( config('enable_video_genre') == 'yes' ){
            $uploadFormRequiredFieldsArray['tags_genre'] = [
                'title'             => lang('genre'),
                'type'              => 'hidden',
                'name'              => 'tags_genre',
                'id'                => 'tags_genre',
                'value'             => genTags($default['tags_genre']),
                'hint_1'            => '',
                'required'          => 'no',
                'validate_function' => 'genTags'
            ];
        }

        if( config('enable_video_actor') == 'yes' ){
            $uploadFormRequiredFieldsArray['tags_actors'] = [
                'title'             => lang('actors'),
                'type'              => 'hidden',
                'name'              => 'tags_actors',
                'id'                => 'tags_actors',
                'value'             => genTags($default['tags_actors']),
                'hint_1'            => '',
                'required'          => 'no',
                'validate_function' => 'genTags'
            ];
        }

        if( config('enable_video_producer') == 'yes' ){
            $uploadFormRequiredFieldsArray['tags_producer'] = [
                'title'             => lang('producer'),
                'type'              => 'hidden',
                'name'              => 'tags_producer',
                'id'                => 'tags_producer',
                'value'             => genTags($default['tags_producer']),
                'hint_1'            => '',
                'required'          => 'no',
                'validate_function' => 'genTags'
            ];
        }

        if( config('enable_video_executive_producer') == 'yes' ){
            $uploadFormRequiredFieldsArray['tags_executive_producer'] = [
                'title'             => lang('executive_producer'),
                'type'              => 'hidden',
                'name'              => 'tags_executive_producer',
                'id'                => 'tags_executive_producer',
                'value'             => genTags($default['tags_executive_producer']),
                'hint_1'            => '',
                'required'          => 'no',
                'validate_function' => 'genTags'
            ];
        }

        if( config('enable_video_director') == 'yes' ){
            $uploadFormRequiredFieldsArray['tags_director'] = [
                'title'             => lang('director'),
                'type'              => 'hidden',
                'name'              => 'tags_director',
                'id'                => 'tags_director',
                'value'             => genTags($default['tags_director']),
                'hint_1'            => '',
                'required'          => 'no',
                'validate_function' => 'genTags'
            ];
        }

        if( config('enable_video_crew') == 'yes' ){
            $uploadFormRequiredFieldsArray['tags_crew'] = [
                'title'             => lang('crew'),
                'type'              => 'hidden',
                'name'              => 'tags_crew',
                'id'                => 'tags_crew',
                'value'             => genTags($default['tags_crew']),
                'hint_1'            => '',
                'required'          => 'no',
                'validate_function' => 'genTags'
            ];
        }

        $tracks = $default['tracks'];
        if (!empty($tracks)) {
            $uploadFormRequiredFieldsArray['audio_track'] = [
                'title'    => lang('track_title'),
                'type'     => 'dropdown',
                'name'     => 'track',
                'id'       => 'track',
                'value'    => $tracks,
                'required' => 'no'
            ];
        }

        //Setting Anchors
        $uploadFormRequiredFieldsArray['desc']['anchor_before'] = 'before_desc_compose_box';

        //Setting Sizes
        return $uploadFormRequiredFieldsArray;
    }

    /**
     * FUNCTION USED TO LOAD FORM OPTION FIELDS
     * broadacast [Radio Button]
     * embedding [Radio Button]
     * rating [Radio Button]
     * comments [Radio Button]
     * comments rating [Radio Button]
     *
     * @param null $default
     *
     * @return array
     * @throws Exception
     */
    function loadOptionFields($default = null): array
    {
        if ($default == null) {
            $default = $_POST;
        }

        $broadcast = $default['broadcast'] ?? 'public';

        //Checking weather to enabled or disable password field
        $video_pass_disable = 'disabled="disabled" ';
        $video_user_disable = 'disabled="disabled" ';

        if ($broadcast == 'unlisted') {
            $video_pass_disable = '';
        } else {
            if ($broadcast == 'private') {
                $video_user_disable = '';
            }
        }

        $fields = [];
        if( config('enable_age_restriction') == 'yes' ) {
            $fields['age_restriction'] = [
                'title'             => lang('age_restriction'),
                'type'              => 'textfield',
                'name'              => 'age_restriction',
                'id'                => 'age_restriction',
                'value'             => $default['age_restriction'],
                'db_field'          => 'age_restriction',
                'required'          => 'no',
                'hint_2'            => lang('info_age_restriction'),
                'validate_function' => 'ageRestriction',
                'use_func_val'      => true
            ];
        }

        $fields['broadcast'] = [
            'title'             => lang('vdo_br_opt'),
            'type'              => 'radiobutton',
            'name'              => 'broadcast',
            'value'             => ['public' => lang('vdo_br_opt1'), 'private' => lang('vdo_br_opt2'), 'unlisted' => lang('vdo_broadcast_unlisted'), 'logged' => lang('logged_users_only')],
            'checked'           => $broadcast,
            'db_field'          => 'broadcast',
            'required'          => 'no',
            'validate_function' => 'yes_or_no',
            'display_function'  => 'display_sharing_opt',
            'default_value'     => 'public',
            'extra_tags'        => ' onClick="
				    $(this).closest(\'form\').find(\'#video_password\').attr(\'disabled\',\'disabled\');
                    $(this).closest(\'form\').find(\'#video_users\').attr(\'disabled\',\'disabled\');
					if($(this).val()==\'unlisted\'){
					    $(this).closest(\'form\').find(\'#video_password\').attr(\'disabled\',false);
					} else if($(this).val()==\'private\') {
					    $(this).closest(\'form\').find(\'#video_users\').attr(\'disabled\',false);
                    }"'
        ];

        $fields['video_password'] = [
            'title'      => lang('video_password'),
            'type'       => 'password',
            'name'       => 'video_password',
            'id'         => 'video_password',
            'value'      => $default['video_password'],
            'db_field'   => 'video_password',
            'required'   => 'no',
            'extra_tags' => " $video_pass_disable ",
            'hint_2'     => lang('set_video_password')
        ];

        $fields['video_users'] =[
            'title'             => lang('video_users'),
            'type'              => 'textarea',
            'name'              => 'video_users',
            'id'                => 'video_users',
            'value'             => $default['video_users'],
            'db_field'          => 'video_users',
            'required'          => 'no',
            'extra_tags'        => " $video_user_disable ",
            'hint_2'            => lang('specify_video_users'),
            'validate_function' => 'video_users',
            'use_func_val'      => true
        ];

        if( config('enable_comments_video') == 'yes' ){
            $fields['comments'] = [
                'type'              => 'checkboxv2',
                'name'              => 'allow_comments',
                'value'             => 'yes',
                'label'             => lang('vdo_allow_comm'),
                'checked'           => $default['allow_comments'] ?? 'yes',
                'db_field'          => 'allow_comments',
                'required'          => 'no',
                'validate_function' => 'yes_or_no'
            ];

            $fields['commentsvote'] = [
                'type'              => 'checkboxv2',
                'name'              => 'comment_voting',
                'value'             => 'yes',
                'label'             => lang('video_allow_comment_vote'),
                'checked'           => $default['comment_voting'] ?? 'yes',
                'db_field'          => 'comment_voting',
                'required'          => 'no',
                'validate_function' => 'yes_or_no'
            ];
        }

        $fields['rating'] = [
            'type'              => 'checkboxv2',
            'name'              => 'allow_rating',
            'value'             => 'yes',
            'label'             => lang('vdo_allow_rating'),
            'checked'           => $default['allow_rating'] ?? 'yes',
            'db_field'          => 'allow_rating',
            'required'          => 'no',
            'validate_function' => 'yes_or_no'
        ];

        $fields['embedding'] = [
            'type'              => 'checkboxv2',
            'name'              => 'allow_embedding',
            'value'             => 'yes',
            'label'             => lang('vdo_embed_opt1'),
            'checked'           => $default['allow_embedding'] ?? 'yes',
            'db_field'          => 'allow_embedding',
            'required'          => 'no',
            'validate_function' => 'yes_or_no'
        ];

        return $fields;
    }

    /**
     * FUNCTION USED TO LOAD DATE AND LOCATION OPTION OF UPLOAD FORM
     * - day - month - year
     * - country
     * - city
     *
     * @param null $default
     *
     * @return array
     * @throws Exception
     */
    function loadLocationFields($default = null): array
    {
        if ($default == null) {
            $default = $_POST;
        }

        $date_recorded = date(config('date_format'), time());
        if (isset($default['datecreated'])) {
            $date_recorded = $default['datecreated'];
        }

        return [
            'country'       => [
                'title'         => lang('country'),
                'type'          => 'dropdown',
                'name'          => 'country',
                'id'            => 'country',
                'value'         => ClipBucket::getInstance()->get_countries(),
                'checked'       => $default['country'],
                'db_field'      => 'country',
                'required'      => 'no',
                'default_value' => ''
            ],
            'location'      => [
                'title'         => lang('location'),
                'type'          => 'textfield',
                'name'          => 'location',
                'id'            => 'location',
                'value'         => $default['location'],
                'hint_2'        => lang('vdo_add_eg'),
                'db_field'      => 'location',
                'required'      => 'no',
                'default_value' => ''
            ],
            'date_recorded' => [
                'title'             => 'Date Recorded',
                'type'              => 'textfield',
                'name'              => 'datecreated',
                'id'                => 'datecreated',
                'class'             => 'date_field',
                'anchor_after'      => 'date_picker',
                'value'             => $date_recorded,
                'db_field'          => 'datecreated',
                'required'          => 'no',
                'default_value'     => '',
                'use_func_val'      => true,
                'validate_function' => 'datecreated',
                'hint_2'            => config('date_format')
            ]
        ];
    }

    /**
     * Function used to add files in conversion queue
     *
     * @param $file
     * @param string $sub_directory
     * @param string $cqueue_name
     * @return bool|int
     * @throws Exception
     */
    function add_conversion_queue($file, $sub_directory = '', $cqueue_name = '')
    {
        $ext = getExt($file);
        $name = getName($file);
        if (!$name) {
            return false;
        }

        if (empty($cqueue_name)) {
            $cqueue_name = $name;
        }

        $tmp_filepath = DirPath::get('temp') . $sub_directory . $file;
        //Checking file exists or not
        if (!file_exists($tmp_filepath)) {
            return false;
        }

        switch ($ext) {
            default:
            case 'mp4':
                global $Cbucket;
                //Get Temp Ext
                $tmp_ext = $Cbucket->temp_exts;
                $tmp_ext = $tmp_ext[rand(0, count($tmp_ext) - 1)];
                //Creating New File Name
                $dest_filepath = DirPath::get('temp') . $sub_directory . $name . '.' . $tmp_ext;

                //Renaming File for security purpose
                rename($tmp_filepath, $dest_filepath);
                break;

            case 'm3u8':
                $tmp_ext = '';
                break;
        }

        //Adding Details to database
        Clipbucket_db::getInstance()->execute('INSERT INTO ' . tbl('conversion_queue') . " (cqueue_name,cqueue_ext,cqueue_tmp_ext,date_added)
							VALUES ('" . mysql_clean($cqueue_name) . "','" . mysql_clean($ext) . "','" . mysql_clean($tmp_ext) . "','" . NOW() . "') ");
        return Clipbucket_db::getInstance()->insert_id();
    }

    /**
     * Video Key Gen
     * * it is use to generate video key
     */
    function video_keygen(): string
    {
        $char_list = 'ABDGHKMNORSUXWY';
        $char_list .= '123456789';
        while (1) {
            $vkey = '';
            srand((double)microtime() * 1000000);
            for ($i = 0; $i < 12; $i++) {
                $vkey .= substr($char_list, (rand() % (strlen($char_list))), 1);
            }

            if (!vkey_exists($vkey)) {
                break;
            }
        }

        return $vkey;
    }

    /**
     * Function used to load upload form
     */
    function get_upload_options(): array
    {
        global $Cbucket;
        return $Cbucket->upload_opt_list;
    }

    /**
     * Function used to perform some actions , after video is upload
     * @param int Videoid
     */
    function do_after_video_upload($vid)
    {
        foreach ($this->actions_after_video_upload as $funcs) {
            if (function_exists($funcs)) {
                $funcs($vid);
            }
        }
    }

    /**
     * Function used to load custom upload fields
     *
     * @param      $data
     * @param bool $ck_display_admin
     *
     * @return array
     */
    function load_custom_upload_fields($data, bool $ck_display_admin): array
    {
        $array = $this->custom_upload_fields;
        $new_array = [];
        foreach ($array as $key => $fields) {
            $ok = 'yes';
            if ($ck_display_admin && $fields['display_admin'] == 'no_display') {
                $ok = 'no';
            }

            if ($ok == 'yes') {
                if (!$fields['value']) {
                    $fields['value'] = $data[$fields['db_field']];
                }
                $new_array[$key] = $fields;
            }
        }

        return $new_array;
    }

    /**
     * Function used to load custom form fields
     *
     * @param      $data
     * @param bool $insertion
     * @param bool $group_based
     * @param bool $user
     *
     * @return array : { array } { $new_array } { an array with all custom fields }
     * { $new_array } { an array with all custom fields }
     */
    function load_custom_form_fields($data, $insertion = false, $group_based = false, $user = false)
    {
        if (!$group_based) {
            if (function_exists('pull_custom_fields')) {
                if ($user) {
                    $array = pull_custom_fields('signup');
                } else {
                    $array = pull_custom_fields('video');
                }
            }
            $cleaned = [];

            if (!$insertion) {
                foreach ($array as $key => $field) {
                    $cleaned[$key]['title'] = $field['custom_field_title'];
                    $cleaned[$key]['type'] = $field['custom_field_type'];
                    $cleaned[$key]['name'] = 'cfld_' . $field['custom_field_name'];
                    $cleaned[$key]['value'] = $field['custom_field_value'];
                    $cleaned[$key]['db_field'] = 'cfld_' . $field['custom_field_name'];
                }
            } else {
                foreach ($array as $key => $field) {
                    $cleaned[$field['custom_field_name']]['title'] = $field['custom_field_title'];
                    $cleaned[$field['custom_field_name']]['type'] = $field['custom_field_type'];
                    $cleaned[$field['custom_field_name']]['name'] = 'cfld_' . $field['custom_field_name'];
                    $cleaned[$field['custom_field_name']]['value'] = $field['custom_field_value'];
                    $cleaned[$field['custom_field_name']]['db_field'] = 'cfld_' . $field['custom_field_name'];
                }
            }
            foreach ($cleaned as $key => $fields) {
                if ($data[$fields['db_field']]) {
                    $value = $data[$fields['db_field']];
                } elseif ($data[$fields['name']]) {
                    $value = $data[$fields['name']];
                }
                if ($fields['type'] == 'radiobutton' || $fields['type'] == 'checkbox' || $fields['type'] == 'dropdown') {
                    $fields['checked'] = $value;
                }

                $new_array[$key] = $fields;
            }
            return $new_array;
        }
        return $this->custom_form_fields_groups;
    }


    /**
     * function used to upload user avatar and or background
     *
     * @param string $type
     * @param        $file
     * @param        $uid
     *
     * @return string|bool
     * @throws Exception
     */
    function upload_user_file(string $type, $file, $uid)
    {
        global $userquery, $cbphoto, $imgObj;
        if (empty($file['tmp_name'])) {
            e(lang('please_select_img_file'));
            return false;
        }
        $av_details = getimagesize($file['tmp_name']);

        if (!$userquery->user_exists($uid)) {
            e(lang('user_doesnt_exist'));
            return false;
        }

        switch ($type) {
            case 'a':
            case 'avatar':
                if ($file['size'] / 1024 > config('max_profile_pic_size')) {
                    e(lang('file_size_exceeds', config('max_profile_pic_size')));
                    return false;
                }

                if ($av_details[0] > config('max_profile_pic_width')) {
                    e(lang('File width exeeds') . ' ' . config('max_profile_pic_width') . 'px');
                    return false;
                }

                if (!file_exists($file['tmp_name'])) {
                    e(lang('class_error_occured'));
                    return false;
                }

                $ext = getext($file['name']);
                $file_name = $uid . '.' . $ext;
                $file_path = DirPath::get('avatars') . $file_name;
                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    if (!$imgObj->ValidateImage($file_path, $ext)) {
                        e(lang('Invalid file type'));
                        @unlink($file_path);
                        return false;
                    }
                    $small_size = DirPath::get('avatars') . $uid . '-small.' . $ext;
                    $cbphoto->CreateThumb($file_path, $file_path, $ext, AVATAR_SIZE, AVATAR_SIZE);
                    $cbphoto->CreateThumb($file_path, $small_size, $ext, AVATAR_SMALL_SIZE, AVATAR_SMALL_SIZE);
                    return $file_name;
                }
                e(lang('class_error_occured'));
                return false;

            case 'b':
            case 'background':
                if ($file['size'] / 1024 > config('max_bg_size')) {
                    e(lang('file_size_exceeds', config('max_bg_size')));
                    return false;
                }

                if ($av_details[0] > config('max_bg_width')) {
                    e(lang('File width exeeds') . ' ' . config('max_bg_width') . 'px');
                    return false;
                }

                if (!file_exists($file['tmp_name'])) {
                    e(lang('class_error_occured'));
                    return false;
                }

                $ext = getext($file['name']);
                $file_name = $uid . '.' . $ext;
                $file_path = DirPath::get('backgrounds') . $file_name;
                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    if (!$imgObj->ValidateImage($file_path, $ext)) {
                        e(lang('Invalid file type'));
                        @unlink($file_path);
                        return false;
                    }
                    return $file_name;
                }
                e(lang('class_error_occured'));
                return false;

        }
        return false;
    }


    /**
     * Function used to upload website logo
     * @param $file
     * @return string|bool;
     */
    function upload_website_logo($file)
    {
        global $imgObj;

        if (!empty($file['name'])) {
            $ext = getExt($file['name']);
            $file_name = 'plaery-logo';
            if ($imgObj->ValidateImage($file['tmp_name'], $ext)) {
                $file_path = DirPath::get('images') . $file_name . '.' . $ext;
                if (file_exists($file_path)) {
                    if (!unlink($file_path)) {
                        e("Unable to remove '$file_path', please chmod it to 0777");
                        return false;
                    }
                }

                move_uploaded_file($file['tmp_name'], $file_path);
                e('Logo has been uploaded', 'm');
                return $file_name . '.' . $ext;
            } else {
                e('Invalid Image file');
            }
        }
        return false;
    }

    /**
     * load_video_fields
     *
     * @param array $input default values for all videos
     * @return array of video fields
     *
     * Function used to load Video fields
     * in clipbucket v2.5 , video fields are loaded in form of groups arrays
     * each group has it name and fields wrapped in array
     * and that array will be part of video fields
     * @throws Exception
     */
    function load_video_fields($input): array
    {
        $fields = [
            [
                'group_id'   => 'required_fields',
                'fields'     => $this->loadRequiredFields($input)
            ],
            [
                'group_name' => lang('vdo_share_opt'),
                'group_id'   => 'sharing_fields',
                'fields'     => $this->loadOptionFields($input)
            ],
            [
                'group_name' => lang('date_recorded_location'),
                'group_id'   => 'date_location_fields',
                'fields'     => $this->loadLocationFields($input)
            ]
        ];

        //Adding Custom Fields
        $custom_fields = $this->load_custom_form_fields($input, false);

        if ($custom_fields) {
            $more_fields_group = [
                'group_name' => lang('more_fields'),
                'group_id'   => 'custom_fields',
                'fields'     => $custom_fields
            ];
        }

        //Adding Custom Fields With Groups
        $custom_fields_with_group = $this->load_custom_form_fields($input, true);

        //Finally putting them together in their main array called $fields
        if ($custom_fields_with_group) {
            $custFieldGroups = $custom_fields_with_group;

            foreach ($custFieldGroups as $gKey => $fieldGroup) {
                foreach ($fieldGroup['fields'] as $mainKey => $nField) {
                    $updatedNewFields[$mainKey] = $nField;
                    if ($input[$nField['db_field']]) {
                        $value = $input[$nField['db_field']];
                    } elseif ($input[$nField['name']]) {
                        $value = $input[$nField['name']];
                    }

                    if ($nField['type'] == 'radiobutton' || $nField['type'] == 'checkbox' || $nField['type'] == 'dropdown') {
                        $updatedNewFields[$mainKey]['checked'] = $value;
                    } else {
                        $updatedNewFields[$mainKey]['value'] = $value;
                    }
                }

                $fieldGroup['fields'] = $updatedNewFields;
                $group_id = $fieldGroup['group_id'];

                foreach ($fields as $key => $field) {
                    if ($field['group_id'] == $group_id) {
                        $inputFields = $field['fields'];
                        //Setting field values
                        $newFields = $fieldGroup['fields'];
                        $mergeField = array_merge($inputFields, $newFields);

                        //Finally Updating array
                        $newGroupArray = [
                            'group_name' => $field['group_name'],
                            'group_id'   => $field['group_id'],
                            'fields'     => $mergeField
                        ];

                        $fields[$key] = $newGroupArray;

                        $matched = true;
                        break;
                    }
                    $matched = false;
                }

                if (!$matched) {
                    $fields[] = $fieldGroup;
                }
            }
        }

        if ($more_fields_group) {
            $fields[] = $more_fields_group;
        }

        return $fields;
    }


}	
