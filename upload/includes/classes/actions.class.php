<?php
class cbactions
{
    /**
     * Defines what is the type of content
     * v = video
     * p = pictures
     * g = groups etc
     */

    var $type = 'v';

    /**
     * Defines whats the name of the object
     * weather its 'video' , its 'picture' or its a 'group'
     */
    var $name = 'video';

    /**
     * Defines the database table name
     * that stores all information about these actions
     */
    var $fav_tbl = 'favorites';
    var $flag_tbl = 'flags';
    var $playlist_tbl = 'playlists';
    var $playlist_items_tbl = 'playlist_items';

    var $type_tbl = 'videos';
    var $type_id_field = 'videoid';
    /**
     * Class variable ie $somevar = SomeClass;
     * $obj_class = 'somevar';
     */
    var $obj_class = 'cbvideo';

    /**
     * Defines function name that is used to check
     * weather object exists or not
     * ie video_exists
     * it will be called as ${$this->obj_class}->{$this->check_func}($id);
     */
    var $check_func = 'video_exists';

    /**
     * This holds all options that are listed when user wants to report
     * a content ie - copyrighted content - voilance - sex or something alike
     * ARRAY = array('Copyrighted','Nudity','bla','another bla');
     */
    var $report_opts = [];

    /**
     * share email template name
     */
    var $share_template_name = 'video_share_template';

    /**
     * Var Array for replacing text of email templates
     * see docs.clip-bucket.com for more details
     */
    var $val_array = [];

    /**
     * initializing
     */
    function init()
    {
        global $cb_columns;

        $this->report_opts = [
            lang('inapp_content'),
            lang('copyright_infring'),
            lang('sexual_content'),
            lang('violence_replusive_content'),
            lang('spam'),
            lang('disturbing'),
            lang('other')
        ];

        $fields = ['playlist_id', 'playlist_name', 'userid', 'description', 'tags', 'category',
            'played', 'privacy', 'total_comments', 'total_items', 'runtime',
            'last_update', 'date_added', 'first_item', 'playlist_type', 'cover'];

        $cb_columns->object('playlists')->register_columns($fields);

        $fields = [
            'playlist_item_id', 'object_id', 'playlist_id', 'playlist_item_type', 'userid',
            'date_added'
        ];

        $cb_columns->object('playlist_items')->register_columns($fields);
    }

    /**
     * Function used to add content to favorites
     * @throws Exception
     */
    function add_to_fav($id)
    {
        global $db;
        $id = mysql_clean($id);
        //First checking weather object exists or not
        if ($this->exists($id)) {
            if (user_id()) {
                if (!$this->fav_check($id)) {
                    $db->insert(tbl($this->fav_tbl), ['type', 'id', 'userid', 'date_added'], [$this->type, $id, user_id(), NOW()]);
                    addFeed(['action' => 'add_favorite', 'object_id' => $id, 'object' => 'video']);

                    //Logging Favorite
                    $log_array = [
                        'success'        => 'yes',
                        'details'        => 'added ' . $this->name . ' to favorites',
                        'action_obj_id'  => $id,
                        'action_done_id' => $db->insert_id()
                    ];
                    insert_log($this->name . '_favorite', $log_array);

                    e('<div class="alert alert-success">' . sprintf(lang('add_fav_message'), lang($this->name)) . '</div>', 'm');
                } else {
                    e(sprintf(lang('already_fav_message'), lang($this->name)));
                }
            } else {
                e(lang('you_not_logged_in'));
            }
        } else {
            e(sprintf(lang('obj_not_exists'), $this->name));
        }
    }

    /**
     * Function used to check weather object already added to favorites or not
     *
     * @param      $id
     * @param null $uid
     *
     * @return bool
     * @throws Exception
     */
    function fav_check($id, $uid = null): bool
    {
        global $db;

        $id = mysql_clean($id);

        if (!$uid) {
            $uid = user_id();
        }
        $results = $db->select(tbl($this->fav_tbl), 'favorite_id', ' id=\'' . mysql_clean($id) . '\' AND userid=\'' . mysql_clean($uid) . '\' AND type=\'' . $this->type . '\'');
        if (count($results) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to check weather object exists or not
     *
     * @param $id
     *
     * @return mixed
     */
    function exists($id)
    {
        $id = mysql_clean($id);
        $obj = $this->obj_class;
        global ${$obj};
        $obj = ${$obj};
        $func = $this->check_func;
        return $obj->{$func}($id);
    }

    /**
     * Function used to report a content
     *
     * @param $id
     * @throws Exception
     */
    function report_it($id)
    {
        global $db;
        //First checking weather object exists or not
        if ($this->exists($id)) {
            if (user_id()) {
                if (!$this->report_check($id)) {
                    $db->insert(
                        tbl($this->flag_tbl),
                        ['type', 'id', 'userid', 'flag_type', 'date_added'],
                        [$this->type, $id, user_id(), post('flag_type'), NOW()]
                    );
                    e(sprintf(lang('obj_report_msg'), lang($this->name)), 'm');
                } else {
                    e(sprintf(lang('obj_report_err'), lang($this->name)));
                }
            } else {
                e(lang('you_not_logged_in'));
            }
        } else {
            e(sprintf(lang('obj_not_exists'), lang($this->name)));
        }
    }

    /**
     * Function used to delete flags
     *
     * @param $id
     * @throws Exception
     */
    function delete_flags($id)
    {
        global $db;
        $id = mysql_clean($id);
        $db->delete(tbl($this->flag_tbl), ['id', 'type'], [$id, $this->type]);
        e(sprintf(lang('type_flags_removed'), lang($this->name)), 'm');
    }

    /**
     * Function used to check weather user has already reported the object or not
     *
     * @param $id
     *
     * @return bool
     * @throws Exception
     */
    function report_check($id): bool
    {
        global $db;
        $id = mysql_clean($id);
        $results = $db->select(tbl($this->flag_tbl), 'flag_id', ' id=\'' . mysql_clean($id) . '\' AND type=\'' . $this->type . '\' AND userid=\'' . user_id() . '\'');
        if (count($results) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Function used to content
     *
     * @param $id
     *
     * @throws phpmailerException
     * @throws Exception
     */
    function share_content($id)
    {
        global $userquery;
        $ok = true;
        $tpl = $this->share_template_name;
        $var = $this->val_array;
        $id = mysql_clean($id);
        //First checking weather object exists or not
        if ($this->exists($id)) {
            if (user_id()) {
                $post_users = mysql_clean(post('users'));
                $users = explode(',', $post_users);
                if (is_array($users) && !empty($post_users)) {
                    foreach ($users as $user) {
                        if (!$userquery->user_exists($user) && !isValidEmail($user)) {
                            e(sprintf(lang('user_no_exist_wid_username'), $user));
                            $ok = false;
                            break;
                        }

                        $email = $user;
                        if (!isValidEmail($user)) {
                            $email = $userquery->get_user_field_only($user, 'email');
                        }
                        $emails_array[] = $email;
                    }

                    if ($ok) {
                        global $cbemail;
                        $tpl = $cbemail->get_template($tpl);
                        $more_var = ['{user_message}' => post('message')];
                        $var = array_merge($more_var, $var);
                        $subj = $cbemail->replace($tpl['email_template_subject'], $var);
                        $msg = $cbemail->replace($tpl['email_template'], $var);

                        //Now Finally Sending Email
                        $from = $userquery->get_user_field_only(user_name(), 'email');

                        cbmail(['to' => $emails_array, 'from' => $from, 'from_name' => user_name(), 'subject' => $subj, 'content' => $msg, 'use_boundary' => true]);
                        e(sprintf(lang('thnx_sharing_msg'), $this->name), 'm');
                    }
                } else {
                    e(sprintf(lang('share_video_no_user_err'), $this->name));
                }
            } else {
                e(lang('you_not_logged_in'));
            }
        } else {
            e(sprintf(lang('obj_not_exists'), $this->name));
        }
    }

    /**
     * Get Used Favorites
     *
     * @param $params
     *
     * @return array|bool
     * @throws Exception
     */
    function get_favorites($params)
    {
        global $db;

        $uid = $params['userid'];
        $limit = $params['limit'];
        $cond = $params['cond'];
        $order = $params['order'];

        if (!$uid) {
            $uid = user_id();
        }

        if ($cond) {
            $cond = ' AND ' . $cond;
        }

        if ($params['count_only']) {
            return $db->count(tbl($this->fav_tbl . ',' . $this->type_tbl), '*', ' ' . tbl($this->fav_tbl) . '.type=\'' . $this->type . '\' 
                AND ' . tbl($this->fav_tbl) . '.userid=\'' . $uid . '\' 
                AND ' . tbl($this->type_tbl) . '.' . $this->type_id_field . ' = ' . tbl($this->fav_tbl) . '.id' . $cond);
        }

        $results = $db->select(tbl($this->fav_tbl . ',' . $this->type_tbl), '*', ' ' . tbl($this->fav_tbl) . '.type=\'' . $this->type . '\' 
            AND ' . tbl($this->fav_tbl) . '.userid=\'' . $uid . '\' 
            AND ' . tbl($this->type_tbl) . '.' . $this->type_id_field . ' = ' . tbl($this->fav_tbl) . '.id' . $cond, $limit, $order);

        if (count($results) > 0) {
            return $results;
        }
        return false;
    }

    /**
     * Function used to count total favorites only
     * @throws Exception
     */
    function total_favorites()
    {
        global $db;
        return $db->count(tbl($this->fav_tbl), 'favorite_id', ' type=\'' . $this->type . '\'');
    }

    /**
     * Function used remove video from favorites
     *
     * @param      $fav_id
     * @param null $uid
     * @throws Exception
     */
    function remove_favorite($fav_id, $uid = null)
    {
        global $db;
        if (!$uid) {
            $uid = user_id();
        }
        if ($this->fav_check($fav_id, $uid)) {
            $db->delete(tbl($this->fav_tbl), ['userid', 'type', 'id'], [$uid, $this->type, $fav_id]);
            e(sprintf(lang('fav_remove_msg'), lang($this->name)), 'm');
        } else {
            e(sprintf(lang('unknown_favorite'), lang($this->name)));
        }
    }

    /**
     * Function used to get object flags
     *
     * @param null $limit
     *
     * @return array|bool
     * @throws Exception
     */
    function get_flagged_objects($limit = null)
    {
        global $db;

        $results = $db->select(tbl($this->flag_tbl . ',' . $this->type_tbl), '*', tbl($this->flag_tbl) . '.id = ' . tbl($this->type_tbl) . '.' . $this->type_id_field . ' 
            AND ' . tbl($this->flag_tbl) . '.type=\'' . $this->type . '\'', $limit);
        if (count($results) > 0) {
            return $results;
        }
        return false;
    }

    /**
     * Function used to get all flags of an object
     *
     * @param $id
     *
     * @return array|bool
     * @throws Exception
     */
    function get_flags($id)
    {
        global $db;
        $results = $db->select(tbl($this->flag_tbl), '*', 'id = \'' . mysql_clean($id) . '\' AND type=\'' . $this->type . '\'');
        if (count($results) > 0) {
            return $results;
        }
        return false;
    }

    /**
     * Function used to count object flags
     * @throws Exception
     */
    function count_flagged_objects(): int
    {
        global $db;
        $results = $db->select(tbl($this->flag_tbl . ',' . $this->type_tbl), 'id', tbl($this->flag_tbl) . '.id = ' . tbl($this->type_tbl) . '.' . $this->type_id_field . ' 
            AND ' . tbl($this->flag_tbl) . '.type=\'' . $this->type . '\' GROUP BY ' . tbl($this->flag_tbl) . '.id ,' . tbl($this->flag_tbl) . '.type');
        return count($results);
    }

    function load_basic_fields($array = null): array
    {
        if (is_null($array)) {
            $array = $_POST;
        }

        $title = $array['playlist_name'];
        $description = $array['description'];
        $tags = $array['tags'];
        $privacy = $array['privacy'];

        return [
            'title'       => [
                'title'       => lang('playlist_name'),
                'type'        => 'textfield',
                'name'        => 'playlist_name',
                'id'          => 'playlist_name',
                'db_field'    => 'playlist_name',
                'value'       => $title,
                'required'    => 'yes',
                'invalid_err' => lang('please_enter_playlist_name')
            ],
            'description' => [
                'title'    => lang('playlist_description'),
                'type'     => 'textarea',
                'name'     => 'description',
                'id'       => 'description',
                'db_field' => 'description',
                'value'    => $description
            ],
            'tags'        => [
                'title'    => lang('tags'),
                'type'     => 'textfield',
                'name'     => 'tags',
                'id'       => 'tags',
                'db_field' => 'tags',
                'value'    => $tags
            ],
            'privacy'     => [
                'title'         => lang('playlist_privacy'),
                'type'          => 'dropdown',
                'name'          => 'privacy',
                'id'            => 'privacy',
                'db_field'      => 'privacy',
                'value'         => [
                    'public'  => lang('public'),
                    'private' => lang('private')
                ],
                'default_value' => 'public',
                'checked'       => $privacy
            ]
        ];
    }

    function load_other_options($array = null): array
    {
        if (is_null($array)) {
            $array = $_POST;
        }

        $allow_comments = $array['allow_comments'];
        $allow_rating = $array['allow_rating'];

        return [
            'allow_comments' => [
                'title'         => lang('playlist_allow_comments'),
                'id'            => 'allow_comments',
                'type'          => 'radiobutton',
                'name'          => 'allow_comments',
                'db_field'      => 'allow_comments',
                'value'         => [
                    'no'  => lang('no'),
                    'yes' => lang('yes')
                ],
                'default_value' => 'yes',
                'checked'       => $allow_comments
            ],
            'allow_rating'   => [
                'title'         => lang('playlist_allow_rating'),
                'id'            => 'allow_rating',
                'type'          => 'radiobutton',
                'name'          => 'allow_rating',
                'db_field'      => 'allow_rating',
                'value'         => [
                    'no'  => lang('no'),
                    'yes' => lang('yes')
                ],
                'default_value' => 'yes',
                'checked'       => $allow_rating
            ]
        ];
    }

    function load_playlist_fields($array = null): array
    {
        if (is_null($array)) {
            $array = $_POST;
        }

        $basic = $this->load_basic_fields($array);
        $other = $this->load_other_options($array);

        return [
            'basic' => [
                'group_id'   => 'basic_fields',
                'group_name' => 'Basic Details',
                'fields'     => $basic
            ],
            'other' => [
                'group_id'   => 'other_fields',
                'group_name' => 'Other Options',
                'fields'     => $other
            ]
        ];
    }

    /**
     * @throws Exception
     */
    function create_playlist($params)
    {
        if (has_access('allow_create_playlist', false)) {
            global $db;
            $name = mysql_clean($params['name']);
            if (!user_id()) {
                e(lang('please_login_create_playlist'));
            } elseif (empty($name)) {
                e(lang('please_enter_playlist_name'));
            } elseif ($this->playlist_exists($name, user_id(), $this->type)) {
                e(sprintf(lang('play_list_with_this_name_arlready_exists'), $name));
            } else {
                $fields = ['playlist_name', 'userid', 'date_added', 'playlist_type', 'description', 'tags'];
                $values = [$name, user_id(), now(), $this->type, '', ''];

                $db->insert(tbl($this->playlist_tbl), $fields, $values);

                $pid = $db->insert_id();
                e(lang('new_playlist_created'), 'm');

                return $pid;
            }
        }
        return false;
    }

    /**
     * Function used to check weather playlist already exists or not
     * @throws Exception
     */
    function playlist_exists($name, $user, $type = null): bool
    {
        global $db;
        if ($type) {
            $type = $this->type;
        }
        $count = $db->count(tbl($this->playlist_tbl), 'playlist_id', ' userid=\'' . mysql_clean($user) . '\' AND playlist_name=\'' . mysql_clean($name) . '\' AND playlist_type=\'' . mysql_clean($type) . '\'');

        if ($count) {
            return true;
        }
        return false;
    }

    /**
     * Function used to get playlist
     * @throws Exception
     */
    function get_playlist($id, $user = null)
    {
        global $cb_columns;

        $fields = [
            'playlists' => $cb_columns->object('playlists')->temp_add('rated_by,voters,rating,allow_rating,allow_comments')->get_columns()
        ];

        $fields['users'] = $cb_columns->object('users')->temp_remove('usr_status,user_session_key')->get_columns();

        $query = 'SELECT ' . table_fields($fields) . ' FROM ' . table('playlists');
        $query .= ' LEFT JOIN ' . table('users') . ' ON playlists.userid = users.userid';

        $query .= ' WHERE playlists.playlist_id = \'' . mysql_clean($id) . '\'';

        if (!is_null($user) and is_numeric($user)) {
            $query .= ' AND playlists.userid = \'' . mysql_clean($user) . '\'';
        }

        $query .= ' LIMIT 1';

        $query_id = cb_query_id($query);

        $data = cb_do_action('select_playlist', ['query_id' => $query_id, 'object_id' => $id]);

        if ($data) {
            return $data;
        }

        $data = select($query);

        if (isset($data[0]) and !empty($data[0])) {
            $data = $data[0];

            if (!empty($data['first_item'])) {
                $first_item = json_decode($data['first_item'], true);
                if ($first_item) {
                    $data['first_item'] = $first_item;
                }
            }

            if (!empty($data['cover'])) {
                $cover = json_decode($data['cover'], true);
                if ($cover) {
                    $data['cover'] = $cover;
                }
            }

            cb_do_action('return_playlist', [
                'query_id'  => $query_id,
                'results'   => $data,
                'object_id' => $id
            ]);

            return $data;
        }

        return false;
    }

    /**
     * Function used to add new item in playlist
     * @throws Exception
     */
    function add_playlist_item($pid, $id)
    {
        global $db;

        $playlist = $this->get_playlist($pid);

        if (!$this->exists($id)) {
            e(sprintf(lang('obj_not_exists'), $this->name));
        } elseif (!$playlist) {
            e(lang('playlist_not_exist'));
        } elseif (!user_id()) {
            e(lang('you_not_logged_in'));
        } elseif ($this->playlist_item_with_obj($id, $pid)) {
            e(sprintf(lang('this_already_exist_in_pl'), $this->name));
        } else {
            $video = get_video_basic_details($id, true);

            cb_do_action('add_playlist_item', ['playlist' => $playlist, 'object' => $video, 'object_type' => $this->type]);

            if (!error()) {
                $fields = [
                    'object_id'          => $id,
                    'playlist_id'        => $pid,
                    'date_added'         => now(),
                    'playlist_item_type' => $this->type,
                    'userid'             => user_id()
                ];

                /* insert item */
                $db->insert(tbl($this->playlist_items_tbl), array_keys($fields), array_values($fields));

                /* update playlist */
                $fields = [
                    'last_update' => now(),
                    'runtime'     => '|f|runtime+' . $video['duration'],
                    'first_item'  => '|no_mc|' . mysql_clean(json_encode($video)),
                    'total_items' => '|f|total_items+1'
                ];

                $db->update(tbl('playlists'), array_keys($fields), array_values($fields), ' playlist_id = \'' . mysql_clean($pid) . '\'');

                e('<div class="alert alert-success">' . lang('video_added_to_playlist') . '</div>', 'm');
                return $video;
            }
        }
    }

    /**
     * Function use to delete playlist item
     * @throws Exception
     */
    function delete_playlist_item($id)
    {
        global $db;

        $item = $this->playlist_item($id, true);

        if (!$item) {
            e(lang('playlist_item_not_exist'));
        } elseif ($item['userid'] != user_id() && !has_access('admin_access')) {
            e(lang('you_dont_hv_permission_del_playlist'));
        } else {
            $video = get_video_basic_details($item['object_id']);

            if (!$video) {
                e(lang('playlist_item_not_exist'));
                return false;
            }

            cb_do_action('delete_playlist_item', ['playlist' => $item, 'object' => $video]);

            /* Remove item */
            $db->delete(tbl($this->playlist_items_tbl), ['playlist_item_id'], [$id]);


            /* Update playlist */
            $fields = [
                'last_update' => NOW(),
                'runtime'     => $item['runtime'] - $video['duration'],
                'total_items' => $item['total_items'] - 1
            ];

            if ($fields['runtime'] <= 0) {
                $fields['runtime'] = 0;
            }

            if ($fields['total_items'] <= 0) {
                $fields['total_items'] = 0;
            }

            if ($this->is_item_first($item, $item['object_id'])) {
                $fields['first_item'] = '|no_mc|' . json_encode([]);
            }


            $db->update(tbl('playlists'), array_keys($fields), array_values($fields), ' playlist_id = \'' . mysql_clean($item['playlist_id']) . '\'');

            e(lang('playlist_item_delete'), 'm');

            return true;
        }
    }

    function is_item_first($details, $check_id): bool
    {
        if (!isset($details['first_item'])) {
            return false;
        }

        $decode = json_decode($details['first_item'], true);

        if (!isset($decode['videoid'])) {
            return false;
        }

        if ($decode['videoid'] == $check_id) {
            return true;
        }

        return false;
    }

    /**
     * Function used to check weather playlist item exists or not
     * @throws Exception
     */
    function playlist_item($id, $join_playlist = false)
    {
        global $cb_columns;

        $fields = [
            'playlist_items' => $cb_columns->object('playlist_items')->get_columns()
        ];

        if ($join_playlist == true) {
            $fields['playlists'] = $cb_columns->object('playlists')->temp_change('date_added', 'playlist_added')->get_columns();
        }

        $query = 'SELECT ' . table_fields($fields) . ' FROM ' . table('playlist_items');

        if ($join_playlist == true) {
            $query .= ' LEFT JOIN ' . table('playlists') . ' ON playlist_items.playlist_id = playlists.playlist_id';
        }

        $query .= ' WHERE playlist_items.playlist_item_id = \'' . mysql_clean($id) . '\' LIMIT 1';

        $query_id = cb_query_id($query);

        $data = cb_do_action('select_playlist_item', ['playlist_item_id' => $id, 'query_id' => $query_id]);

        if ($data) {
            return $data;
        }

        $data = select($query);

        if ($data) {
            cb_do_action('return_playlist_item', [
                'query_id' => $query_id,
                'results'  => $data[0]
            ]);

            return $data[0];
        }
        return false;
    }

    /**
     * Function used to check weather playlist item exists or not
     *
     * @param      $id
     * @param null $pid
     *
     * @return bool|array
     * @throws Exception
     */
    function playlist_item_with_obj($id, $pid = null)
    {
        global $db;
        $pid_cond = '';
        if ($pid) {
            $pid_cond = ' AND playlist_id=\'' . mysql_clean($pid) . '\'';
        }
        $result = $db->select(tbl($this->playlist_items_tbl), '*', ' object_id=\'' . mysql_clean($id) . '\' ' . $pid_cond);
        if (count($result) > 0) {
            return $result[0];
        }
        return false;
    }

    /**
     * Function used to update playlist details
     *
     * @param null $array
     * @throws Exception
     */
    function edit_playlist($array = null)
    {
        global $db;

        if (is_null($array)) {
            $array = $_POST;
        }

        $name = mysql_clean($array['name']);
        $pdetails = $this->get_playlist($array['pid'] ? $array['pid'] : $array['list_id']);

        if (!$pdetails) {
            e(lang('playlist_not_exist'));
        } elseif (!user_id()) {
            e(lang('you_not_logged_in'));
        } elseif ($this->playlist_exists($name, user_id(), $this->type)) {
            e(sprintf(lang('play_list_with_this_name_arlready_exists'), $name));
        } else {
            $upload_fields = $this->load_playlist_fields($array);
            $fields = [];

            foreach ($upload_fields as $group) {
                $fields = array_merge($fields, $group['fields']);
            }

            validate_cb_form($fields, $array);

            if (!error()) {
                foreach ($fields as $field) {
                    $name = formObj::rmBrackets($field['name']);
                    $val = $array[$name];

                    if ($field['use_func_val']) {
                        $val = $field['validate_function']($val);
                    }

                    if (is_array($val)) {
                        $new_val = '';
                        foreach ($val as $v) {
                            $new_val .= '#' . $v . '# ';
                        }
                        $val = $new_val;
                    }
                    if (!$field['clean_func'] || (!function_exists($field['clean_func']) && !is_array($field['clean_func']))) {
                        $val = ($val);
                    } else {
                        $val = apply_func($field['clean_func'], mysql_clean('|no_mc|' . $val));
                    }

                    if (!empty($field['db_field'])) {
                        $query_values[$name] = $val;
                    }
                }

                if (has_access('admin_access')) {
                    if (isset($array['played']) and !empty($array['played'])) {
                        $query_values['played'] = $array['played'];
                    }
                }

                $query_values['last_update'] = NOW();

                $db->update(tbl('playlists'), array_keys($query_values), array_values($query_values), ' playlist_id = \'' . mysql_clean($pdetails['playlist_id']) . '\'');

                $array['playlist_id'] = $array['pid'] ? $array['pid'] : $array['list_id'];

                cb_do_action('update_playlist', [
                    'object_id' => $array['pid'] ? $array['pid'] : $array['list_id'],
                    'results'   => $array
                ]);
            }
            e(lang('play_list_updated'), 'm');
        }
    }

    /**
     * Function used to delete playlist
     * @throws Exception
     */
    function delete_playlist($id)
    {
        global $db;
        $playlist = $this->get_playlist($id);
        if (!$playlist) {
            e(lang('playlist_not_exist'));
        } elseif ($playlist['userid'] != user_id() && !has_access('admin_access', true)) {
            e(lang('you_dont_hv_permission_del_playlist'));
        } else {
            $id = mysql_clean($id);
            $db->delete(tbl($this->playlist_tbl), ['playlist_id'], [$id]);
            $db->delete(tbl($this->playlist_items_tbl), ['playlist_id'], [$id]);
            e(lang('playlist_delete_msg'), 'm');
        }
    }

    /**
     * Function used to get playlists
     * @throws Exception
     */
    function get_playlists($params = [])
    {
        global $cb_columns, $db;

        $fields = [
            'playlists' => $cb_columns->object('playlists')->get_columns()
        ];

        $order = $params['order'];
        $limit = $params['limit'];

        //changes made
        $playlist_name = $params['playlist_name'];
        $tags = $params['tags'];
        $userid = $params['userid'];

        $query = 'SELECT ' . table_fields($fields) . ' FROM ' . table('playlists');
        $condition = '';

        if (!has_access('admin_access')) {
            $condition .= 'playlists.privacy = \'public\'';
        } else {
            if (isset($params['privacy'])) {
                $condition .= ' playlists.privacy = \'' . mysql_clean($params['privacy']) . '\'';
            }
        }

        if (isset($params['category'])) {
            $condition .= $condition ? ' AND ' : '';
            $condition .= ' playlists.category = \'' . mysql_clean($params['category']) . '\'';
        }

        if (isset($params['include'])) {
            $ids = is_array($params['include']) ? $params['include'] : explode(',', $params['include']);

            if (is_array($ids) and !empty($ids)) {
                $condition .= $condition ? ' AND ' : '';
                $ids = implode(',', array_map('trim', $ids));
                $condition .= ' playlists.playlist_id IN (' . mysql_clean($ids) . ')';
            }
        }

        if (isset($params['exclude'])) {
            $ids = is_array($params['exclude']) ? $params['exclude'] : explode(',', $params['exclude']);

            if (is_array($ids) and !empty($ids)) {
                $condition .= $condition ? ' AND ' : '';
                $ids = implode(',', array_map('trim', $ids));
                $condition .= ' playlists.playlist_id NOT IN (' . mysql_clean($ids) . ')';
            }
        }

        if (isset($params['date_span'])) {
            $condition .= $condition ? ' AND ' : '';
            $column = $params['date_span_column'] ? trim($params['date_span_column']) : 'playlists.date_added';

            $condition .= cbsearch::date_margin($column, $params['date_span']);
        }

        if (isset($params['last_update'])) {
            $condition .= $condition ? ' AND ' : '';
            $condition .= cbsearch::date_margin('playlists.last_update', $params['last_update']);
        }

        if (isset($params['user'])) {
            $condition .= $condition ? ' AND ' : '';
            $condition .= ' playlists.userid = \'' . $params['user'] . '\'';
        }
        ////////////CHANGES/////////////

        if (isset($userid)) {
            $condition .= $condition ? ' AND ' : '';
            $condition .= ' playlists.userid = \'' . mysql_clean($userid) . '\'';
        }

        if (isset($tags)) {
            $condition .= $condition ? ' AND ' : '';
            $condition .= ' playlists.tags LIKE \'%' . mysql_clean($tags) . '%\' ';
        }

        if (isset($playlist_name)) {
            $condition .= $condition ? ' AND ' : '';
            $condition .= ' playlists.playlist_name LIKE \'%' . mysql_clean($playlist_name) . '%\' ';
        }

        ////////////CHANGES/////////////

        if (isset($params['has_items'])) {
            $condition .= $condition ? ' AND ' : '';
            $condition .= ' playlists.total_items > \'0\' ';
        }

        if (isset($params['count_only'])) {
            return $db->count(cb_sql_table('playlists'), 'playlist_id', $condition);
        }

        if ($condition) {
            $query .= ' WHERE ' . $condition;
        }

        $order = ' ORDER BY ' . ($order ? trim($order) : 'playlists.date_added DESC');
        $limit = ($limit) ? ' LIMIT ' . $limit : '';

        $query .= $order . $limit;

        $query_id = cb_query_id($query);

        $action_array = ['query_id' => $query_id];

        $data = cb_do_action('select_playlists', array_merge($action_array, $params));

        if ($data) {
            return $data;
        }

        $results = select($query);

        if (!empty($results)) {
            cb_do_action('return_playlists', [
                'query_id' => $query_id,
                'results'  => $results
            ]);
            return $results;
        }
        return false;
    }

    /**
     * this method has been deprecated
     * @throws Exception
     */
    function get_playlists_no_more_cb26()
    {
        global $db;
        $result = $db->select(tbl($this->playlist_tbl), '*', ' playlist_type=\'' . $this->type . '\' AND userid=\'' . user_id() . '\'');

        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Get playlist thumb
     *
     * return a group of playlist thumbs
     *
     * @param PID playlistid
     *
     * @return array Array
     * @throws Exception
     */
    function getPlaylistThumb($pid)
    {
        $pid = (int)$pid;
        $items = $this->get_playlist_items($pid, null, 3);
        $array = [];

        if ($items) {
            foreach ($items as $item) {
                $item['type'] = 'v';
                $array[] = get_thumb($item['object_id']);
            }
        } else {
            return [TEMPLATEURL . '/images/playlist-default.png'];
        }

        $array = array_unique($array);
        rsort($array);

        return $array;
    }

    /**
     * Function used to get playlist items
     *
     * @param      $playlist_id
     * @param null $order
     * @param int $limit
     *
     * @return array|bool
     * @throws Exception
     */
    function get_playlist_items($playlist_id, $order = null, $limit = -1)
    {
        global $db;

        $result = $db->select(tbl($this->playlist_items_tbl), '*', 'playlist_id=\'' . mysql_clean($playlist_id) . '\'');
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Function used to count playlist item
     *
     * @param $id
     *
     * @return bool
     * @throws Exception
     */
    function count_playlist_items($id)
    {
        global $db;
        return $db->count(tbl($this->playlist_items_tbl), 'playlist_item_id', 'playlist_id=\'' . mysql_clean($id) . '\'');
    }

    /**
     * Function used to count total playlist or items
     *
     * @param bool $item
     *
     * @return bool
     * @throws Exception
     */
    function count_total_playlist($item = false)
    {
        global $db;
        if (!$item) {
            return $db->count(tbl($this->playlist_tbl), '*', ' playlist_type=\'' . $this->type . '\'');
        }
        return $db->count(tbl($this->playlist_items_tbl), 'playlist_item_id', ' playlist_item_type=\'' . $this->type . '\'');
    }

}
