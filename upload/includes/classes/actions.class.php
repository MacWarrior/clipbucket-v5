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
    var $obj_class = '';

    /**
     * Defines function name that is used to check
     * weather object exists or not
     * ie video_exists
     * it will be called as ${$this->obj_class}->{$this->check_func}($id);
     */
    var $check_func = 'video_exists';

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
     * @throws Exception
     */
    function init(): void
    {
        global $cb_columns;

        $fields = ['playlist_id', 'playlist_name', 'userid', 'description',
            'played', 'privacy', 'total_comments', 'runtime',
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
    function add_to_fav($id): void
    {
        $id = mysql_clean($id);
        //First checking weather object exists or not
        if ($this->exists($id)) {
            if (user_id()) {
                if (!$this->fav_check($id)) {
                    Clipbucket_db::getInstance()->insert(tbl($this->fav_tbl), ['type', 'id', 'userid', 'date_added'], [$this->type, $id, user_id(), NOW()]);
                    addFeed(['action' => 'add_favorite', 'object_id' => $id, 'object' => 'video']);

                    //Logging Favorite
                    $log_array = [
                        'success'        => 'yes',
                        'details'        => 'added ' . $this->name . ' to favorites',
                        'action_obj_id'  => $id,
                        'action_done_id' => Clipbucket_db::getInstance()->insert_id()
                    ];
                    insert_log($this->name . '_favorite', $log_array);

                    e('<div class="alert alert-success">' . lang('add_fav_message', lang($this->name)) . '</div>', 'm');
                } else {
                    e(lang('already_fav_message', lang($this->name)));
                }
            } else {
                e(lang('you_not_logged_in'));
            }
        } else {
            e(lang('obj_not_exists', $this->name));
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
        $id = mysql_clean($id);

        if (!$uid) {
            $uid = user_id();
        }
        $results = Clipbucket_db::getInstance()->select(tbl($this->fav_tbl), 'favorite_id', ' id=\'' . mysql_clean($id) . '\' AND userid=\'' . mysql_clean($uid) . '\' AND type=\'' . $this->type . '\'');
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
    public function exists($id)
    {
        $id = mysql_clean($id);
        $obj = $this->obj_class::getInstance();
        $func = $this->check_func;
        return $obj->{$func}($id);
    }

    /**
     * Function used to content
     *
     * @param $id
     *
     * @throws Exception
     */
    function share_content($id)
    {
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
                    foreach ($users as $username) {
                        $user = User::getInstance()->getOne(['username' => $username]);
                        if (!userquery::getInstance()->user_exists($user['username']) && !isValidEmail($user['email'])) {
                            e(lang('user_no_exist_wid_username', $username));
                            $ok = false;
                            break;
                        }
                        if (userquery::getInstance()->is_user_banned(User::getInstance()->get('username'), $user['username'])) {
                            e(lang('this_user_blocked_you', $user['username']));
                            $ok = false;
                            break;
                        }
                        if ($user['ban_status'] == 'yes') {
                            e(lang('user_is_banned',$user['username']));
                            $ok = false;
                            break;
                        }
                        if ($user['username'] == User::getInstance()->get('username')) {
                            e(lang('you_cant_share_to_yourself'));
                            $ok = false;
                            break;
                        }

                        $emails_array[] = $user['email'];
                    }

                    if ($ok) {
                        $more_var = [
                            'sender_username' => user_name(),
                            'sender_message'  => display_clean(post('message')),
                        ];
                        $var = array_merge($more_var, $var);

                        //Now Finally Sending Email
                        $from = userquery::getInstance()->get_user_field_only(user_name(), 'email');
                        EmailTemplate::sendMail($tpl, $emails_array, $var, $from, user_name());
                        e(lang('thnx_sharing_msg', $this->name), 'm');
                    }
                } else {
                    e(lang('share_video_no_user_err', $this->name));
                }
            } else {
                e(lang('you_not_logged_in'));
            }
        } else {
            e(lang('obj_not_exists', $this->name));
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
            return Clipbucket_db::getInstance()->count(tbl($this->fav_tbl . ',' . $this->type_tbl), '*', ' ' . tbl($this->fav_tbl) . '.type=\'' . $this->type . '\' 
                AND ' . tbl($this->fav_tbl) . '.userid=\'' . $uid . '\' 
                AND ' . tbl($this->type_tbl) . '.' . $this->type_id_field . ' = ' . tbl($this->fav_tbl) . '.id' . $cond);
        }

        $results = Clipbucket_db::getInstance()->select(tbl($this->fav_tbl . ',' . $this->type_tbl), '*', ' ' . tbl($this->fav_tbl) . '.type=\'' . $this->type . '\' 
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
        return Clipbucket_db::getInstance()->count(tbl($this->fav_tbl), 'favorite_id', ' type=\'' . $this->type . '\'');
    }

    /**
     * Function used remove video from favorites
     *
     * @param      $fav_id
     * @param null $uid
     * @throws Exception
     */
    function remove_favorite($fav_id, $uid = null): void
    {
        if (!$uid) {
            $uid = user_id();
        }
        if ($this->fav_check($fav_id, $uid)) {
            Clipbucket_db::getInstance()->delete(tbl($this->fav_tbl), ['userid', 'type', 'id'], [$uid, $this->type, $fav_id]);
            e(lang('fav_remove_msg', ucfirst(lang($this->name))), 'm');
        } else {
            e(lang('unknown_favorite', lang($this->name)));
        }
    }

    /**
     * @throws Exception
     */
    function load_basic_fields($array = null): array
    {
        if (is_null($array)) {
            $array = $_POST;
        }

        $hint_tags = config('allow_tag_space') =='yes' ? '<span class="fa fa-question-circle tips" style="margin-left: 5px;" title=\''.lang('use_tab_tag').'\'></span>' : '';

        return [
            'title'       => [
                'title'       => lang('playlist_name'),
                'type'        => 'textfield',
                'name'        => 'playlist_name',
                'id'          => 'playlist_name',
                'db_field'    => 'playlist_name',
                'value'       => $array['playlist_name'],
                'required'    => 'yes',
                'invalid_err' => lang('please_enter_playlist_name')
            ],
            'description' => [
                'title'    => lang('playlist_description'),
                'type'     => 'textarea',
                'name'     => 'description',
                'id'       => 'description',
                'db_field' => 'description',
                'value'    => $array['description']
            ],
            'playlists_tags' => [
                'title'             => lang('tags'),
                'type'              => 'hidden',
                'name'              => 'playlists_tags',
                'id'                => 'playlists_tags',
                'value'             => genTags($array['playlists_tags']),
                'hint_1'            => $hint_tags,
                'required'          => 'no',
                'validate_function' => 'genTags'
            ],
            'privacy' => [
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
                'checked'       => $array['privacy']
            ]
        ];
    }

    /**
     * @throws Exception
     */
    function load_playlist_fields($array = null): array
    {
        if (is_null($array)) {
            $array = $_POST;
        }

        $basic = $this->load_basic_fields($array);

        return [
            'basic' => [
                'group_id'   => 'basic_fields',
                'group_name' => 'Basic Details',
                'fields'     => $basic
            ]
        ];
    }

    /**
     * @throws Exception
     */
    function create_playlist($params)
    {
        if( !User::getInstance()->hasPermission('allow_create_playlist') ){
            e(lang('insufficient_privileges'));
            return false;
        }

        if (!user_id()) {
            e(lang('please_login_create_playlist'));
            return false;
        }
        if (empty($params['name'])) {
            e(lang('please_enter_playlist_name'));
            return false;
        }
        if ($this->playlist_exists($params['name'], user_id(), $this->type)) {
            e(lang('play_list_with_this_name_arlready_exists', display_clean($params['name'])));
            return false;
        }

        $fields = ['playlist_name', 'userid', 'date_added', 'playlist_type', 'description'];
        $values = [$params['name'], user_id(), now(), $this->type, ''];

        Clipbucket_db::getInstance()->insert(tbl($this->playlist_tbl), $fields, $values);

        $pid = Clipbucket_db::getInstance()->insert_id();
        e(lang('new_playlist_created'), 'm');

        return $pid;
    }

    /**
     * Function used to check weather playlist already exists or not
     * @throws Exception
     */
    function playlist_exists($name, $user, $type = null, int $playlist_id = 0): bool
    {
        if ($type) {
            $type = $this->type;
        }
        $cond = ' userid=' . (int)$user . ' AND playlist_name=\'' . mysql_clean($name) . '\' AND playlist_type=\'' . mysql_clean($type) . '\'';
        if( !empty($playlist_id) ) {
            $cond .= ' AND playlist_id !=' . (int)$playlist_id;
        }
        $count = Clipbucket_db::getInstance()->count(tbl($this->playlist_tbl), 'playlist_id', $cond);

        if ($count) {
            return true;
        }
        return false;
    }

    /**
     * Function used to add new item in playlist
     * @throws Exception
     */
    function add_playlist_item($pid, $id)
    {
        $playlist = Playlist::getInstance()->getOne($pid);

        if (!$this->exists($id)) {
            e(lang('obj_not_exists', $this->name));
        } elseif (!$playlist) {
            e(lang('playlist_not_exist'));
        } elseif (!user_id()) {
            e(lang('you_not_logged_in'));
        } elseif ($this->playlist_item_with_obj($id, $pid)) {
            e(lang('this_already_exist_in_pl', $this->name));
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
                Clipbucket_db::getInstance()->insert(tbl($this->playlist_items_tbl), array_keys($fields), array_values($fields));

                /* update playlist */
                $fields = [
                    'last_update' => now(),
                    'runtime'     => '|f|runtime+' . $video['duration'],
                    'first_item'  => '|no_mc|' . mysql_clean(json_encode($video)),
                    'total_items' => '|f|total_items+1'
                ];

                Clipbucket_db::getInstance()->update(tbl('playlists'), array_keys($fields), array_values($fields), ' playlist_id = \'' . mysql_clean($pid) . '\'');

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
        $item = $this->playlist_item($id);

        if (!$item) {
            e(lang('playlist_item_not_exist'));
        } elseif ($item['userid'] != user_id() && !User::getInstance()->hasAdminAccess()) {
            e(lang('you_dont_hv_permission_del_playlist'));
        } else {
            $video = get_video_basic_details($item['object_id']);

            if (!$video) {
                e(lang('playlist_item_not_exist'));
                return false;
            }

            /* Remove item */
            Clipbucket_db::getInstance()->delete(tbl($this->playlist_items_tbl), ['playlist_item_id'], [$id]);

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

            Clipbucket_db::getInstance()->update(tbl('playlists'), array_keys($fields), array_values($fields), ' playlist_id = \'' . mysql_clean($item['playlist_id']) . '\'');

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

        if ($join_playlist) {
            $fields['playlists'] = $cb_columns->object('playlists')->temp_change('date_added', 'playlist_added')->get_columns();
        }

        $query = 'SELECT ' . table_fields($fields) . ' FROM ' . cb_sql_table('playlist_items');

        if ($join_playlist) {
            $query .= ' LEFT JOIN ' . cb_sql_table('playlists') . ' ON playlist_items.playlist_id = playlists.playlist_id';
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
        $pid_cond = '';
        if ($pid) {
            $pid_cond = ' AND playlist_id=\'' . mysql_clean($pid) . '\'';
        }
        $result = Clipbucket_db::getInstance()->select(tbl($this->playlist_items_tbl), '*', ' object_id=\'' . mysql_clean($id) . '\' ' . $pid_cond);
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
    function edit_playlist($array = null): void
    {
        if (is_null($array)) {
            $array = $_POST;
        }

        $pdetails = Playlist::getInstance()->getOne($array['playlist_id']);

        if (!$pdetails) {
            e(lang('playlist_not_exist'));
        } elseif (!user_id()) {
            e(lang('you_not_logged_in'));
        } elseif ($this->playlist_exists($array['playlist_name'], user_id(), $this->type, $array['playlist_id'])) {
            e(lang('play_list_with_this_name_arlready_exists', display_clean($array['playlist_name'])));
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

                    if (!empty($field['validate_function'])) {
                        if (isset($field['second_parameter_validate'])) {
                            $val = $field['validate_function']($val,$field['second_parameter_validate']);
                        } else {
                            $val = $field['validate_function']($val);
                        }
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

                if (User::getInstance()->hasAdminAccess()) {
                    if (isset($array['played']) and !empty($array['played'])) {
                        $query_values['played'] = $array['played'];
                    }
                }

                $query_values['last_update'] = NOW();

                Clipbucket_db::getInstance()->update(tbl('playlists'), array_keys($query_values), array_values($query_values), ' playlist_id = \'' . mysql_clean($pdetails['playlist_id']) . '\'');

                Tags::saveTags($array['playlists_tags'], 'playlist', $pdetails['playlist_id']);

            }
            e(lang('play_list_updated'), 'm');
        }
    }

    /**
     * Function used to delete playlist
     * @throws Exception
     */
    function delete_playlist($id): void
    {
        $playlist = Playlist::getInstance()->getOne($id);
        if (!$playlist) {
            e(lang('playlist_not_exist'));
        } elseif ($playlist['userid'] != user_id() && !User::getInstance()->hasAdminAccess()) {
            e(lang('you_dont_hv_permission_del_playlist'));
        } else {
            $id = mysql_clean($id);
            //delete reports for this playlist
            Flag::unFlagByElementId($id, 'playlist');

            Clipbucket_db::getInstance()->delete(tbl($this->playlist_tbl), ['playlist_id'], [mysql_clean($id)]);
            Clipbucket_db::getInstance()->delete(tbl($this->playlist_items_tbl), ['playlist_id'], [$id]);
            e(lang('playlist_delete_msg'), 'm');
        }
    }

    /**
     * Function used to count playlist item
     *
     * @param $id
     *
     * @return bool|int
     * @throws Exception
     */
    function count_playlist_items($id)
    {
        $left_join_video = '';
        $where_video = '';
        if( !User::getInstance()->hasAdminAccess() ){
            $left_join_video = ' LEFT JOIN '.cb_sql_table('video').' ON playlist_items.object_id = video.videoid';
            $where_video = 'AND ' . Video::getInstance()->getGenericConstraints(['show_unlisted' => true]);
        }

        return Clipbucket_db::getInstance()->count(cb_sql_table($this->playlist_items_tbl) . $left_join_video, 'playlist_items.object_id', 'playlist_id=\'' . mysql_clean($id) . '\'' . $where_video);
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
        if (!$item) {
            return Clipbucket_db::getInstance()->count(tbl($this->playlist_tbl), '*', ' playlist_type=\'' . $this->type . '\'');
        }
        return Clipbucket_db::getInstance()->count(tbl($this->playlist_items_tbl), 'playlist_item_id', ' playlist_item_type=\'' . $this->type . '\'');
    }

}
