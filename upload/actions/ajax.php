<?php
const THIS_PAGE = 'ajax';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
} else {
    header('location:' . DirPath::getUrl('root'));
    die();
}

if (!empty($mode)) {
    switch ($mode) {
        case 'most_viewed':
            if (!isSectionEnabled('videos') || !User::getInstance()->hasPermission('view_videos')) {
                exit();
            }

            $videos = get_videos(['limit' => config('videos_items_hme_page'), 'order' => 'views DESC']);
            if ($videos) {
                foreach ($videos as $video) {
                    assign('video', $video);
                    Template('blocks/videos/video.html');
                }
            }
            break;

        case 'load_more':
            $limit = $_POST['limit'];
            $total = $_POST['total'];

            $inner_mode = $_POST['inner_mode'];
            switch ($inner_mode) {
                case 'load_more_playlist':
                    $userid = $_POST['cat_id'];
                    $play_arr = ['userid' => $userid, 'order' => 'date_added DESC', 'limit' => '' . $limit . ',' . $limit];
                    $results = Playlist::getInstance()->getAll($play_arr);
                    $next_limit = $limit + $limit;
                    $play_arr_next = ['userid' => $userid, 'order' => 'date_added DESC', 'limit' => '' . $next_limit . ',' . $next_limit];
                    $playlist_next = Playlist::getInstance()->getAll($play_arr_next);
                    if ($total == $next_limit || $total < $next_limit) {
                        $count_next = 0;
                    } else {
                        $count_next = count($playlist_next);
                    }
                    $count_next = (int)$count_next;
                    $total_results = $total;
                    $template_path = 'blocks/playlist/playlist.html';
                    $assigned_variable_smarty = 'playlist';
                    break;
            }
            $arr = template_assign($results, $limit, $total_results, $template_path, $assigned_variable_smarty);

            if ($count_next > 0) {
                $arr['limit_exceeds'] = false;
                echo json_encode($arr);
            } else {
                if ($count_next == 0) {
                    $arr['limit_exceeds'] = true;
                    echo json_encode($arr);
                } else {
                    if (isset($arr['limit_exceeds'])) {
                        $arr['limit_exceeds'] = true;
                    }
                    echo json_encode($arr);
                }
            }
            break;

        case 'rating':
            switch ($_POST['type']) {
                case 'video':
                    $rating = mysql_clean($_POST['rating']) * 2;
                    $id = mysql_clean($_POST['id']);
                    $result = CBvideo::getInstance()->rate_video($id, $rating);
                    $result['is_rating'] = true;
                    CBvideo::getInstance()->show_video_rating($result);

                    $funcs = cb_get_functions('rate_video');
                    if ($funcs) {
                        foreach ($funcs as $func) {
                            $func['func']($id);
                        }
                    }
                    break;

                case 'photo':
                    $rating = mysql_clean($_POST['rating']) * 2;
                    $id = mysql_clean($_POST['id']);
                    $result = CBPhotos::getInstance()->rate_photo($id, $rating);
                    $result['is_rating'] = true;
                    CBvideo::getInstance()->show_video_rating($result);

                    $funcs = cb_get_functions('rate_photo');
                    if ($funcs) {
                        foreach ($funcs as $func) {
                            $func['func']($id);
                        }
                    }
                    break;

                case 'collection':
                    $rating = mysql_clean($_POST['rating']) * 2;
                    $id = mysql_clean($_POST['id']);
                    $result = Collections::getInstance()->rate_collection($id, $rating);
                    $result['is_rating'] = true;
                    CBvideo::getInstance()->show_video_rating($result);

                    $funcs = cb_get_functions('rate_collection');
                    if ($funcs) {
                        foreach ($funcs as $func) {
                            $func['func']($id);
                        }
                    }
                    break;

                case 'user':
                    $rating = mysql_clean($_POST['rating']) * 2;
                    $id = mysql_clean($_POST['id']);
                    $result = userquery::getInstance()->rate_user($id, $rating);
                    $result['is_rating'] = true;
                    CBvideo::getInstance()->show_video_rating($result);

                    $funcs = cb_get_functions('rate_user');
                    if ($funcs) {
                        foreach ($funcs as $func) {
                            $func['func']($id);
                        }
                    }
                    break;
            }
            break;

        case 'share_object':
            $type = strtolower($_POST['type']);
            switch ($type) {
                case 'v':
                case 'video':
                default:
                    $id = mysql_clean($_POST['id']);
                    $vdo = CBvideo::getInstance()->get_video($id);
                    CBvideo::getInstance()->set_share_email($vdo);
                    CBvideo::getInstance()->action->share_content($vdo['videoid']);
                    break;

                case 'p':
                case 'photo':
                    $ph = CBPhotos::getInstance()->get_photo($_POST['id']);
                    CBPhotos::getInstance()->set_share_email($ph);
                    CBPhotos::getInstance()->action->share_content($ph['photo_id']);
                    break;

                case 'cl':
                case 'collection':
                    $cl = Collections::getInstance()->get_collection($_POST['id']);
                    Collections::getInstance()->set_share_mail($cl);
                    Collections::getInstance()->action->share_content($cl['collection_id']);
                    break;
            }

            $error = errorhandler::getInstance()->get_error();
            $warning = errorhandler::getInstance()->get_warning();
            $message = errorhandler::getInstance()->get_message();

            if ($error) {
                echo '<div class="error">' . $error[0]['val'] . '</div>';
            } else {
                if ($warning) {
                    echo '<div class="warning">' . $warning[0]['val'] . '</div>';
                } else {
                    if ($message) {
                        echo '<div class="msg">' . $message[0]['val'] . '</div>';
                    }
                }
            }
            break;

        case 'add_to_fav':
            $type = strtolower($_POST['type']);
            $id = $_POST['id'];
            switch ($type) {
                case 'v':
                case 'video':
                default:
                    CBvideo::getInstance()->action->add_to_fav($id);
                    updateObjectStats('fav', 'video', $id); // Increment in total favs
                    $funcs = cb_get_functions('favorite_video');
                    break;

                case 'p':
                case 'photo':
                    CBPhotos::getInstance()->action->add_to_fav($id);
                    updateObjectStats('fav', 'photo', $id); // Increment in total favs
                    $funcs = cb_get_functions('favorite_photo');
                    break;

                case 'cl':
                case 'collection':
                    Collections::getInstance()->action->add_to_fav($id);
                    $funcs = cb_get_functions('favorite_collection');
                    break;
            }

            if ($funcs) {
                foreach ($funcs as $func) {
                    $func['func']($id);
                }
            }

            $error = errorhandler::getInstance()->get_error();
            $warning = errorhandler::getInstance()->get_warning();
            $message = errorhandler::getInstance()->get_message();

            if ($error) {
                echo '<div class="error">' . $error[0]['val'] . '</div>';
            } else {
                if ($warning) {
                    echo '<div class="warning">' . $warning[0]['val'] . '</div>';
                } else {
                    if ($message) {
                        echo '<div class="msg">' . $message[0]['val'] . '</div>';
                    }
                }
            }
            break;

        case 'flag_object':
            $type = strtolower($_POST['type']);
            $id = $_POST['id'];
            if (empty($_POST['flag_type'])) {
                e(lang('missing_category_report'));
            } else {
                if (Flag::flagItem($id, $type, $_POST['flag_type'])) {
                    e(lang('report_successful'), 'm');
                }
            }

            $error = errorhandler::getInstance()->get_error();
            $warning = errorhandler::getInstance()->get_warning();
            $message = errorhandler::getInstance()->get_message();

            if ($error) {
                echo '<div class="error">' . $error[0]['val'] . '</div>';
            } else {
                if ($warning) {
                    echo '<div class="warning">' . $warning[0]['val'] . '</div>';
                } else {
                    if ($message) {
                        echo '<div class="msg">' . $message[0]['val'] . '</div>';
                    }
                }
            }
            break;

        case 'subscribe_user':
            $subscribe_to = mysql_clean($_POST['subscribe_to']);
            $mailId = userquery::getInstance()->get_user_details($subscribe_to, false, true);
            userquery::getInstance()->subscribe_user($subscribe_to);

            $error = errorhandler::getInstance()->get_error();
            $warning = errorhandler::getInstance()->get_warning();
            $message = errorhandler::getInstance()->get_message();

            if ($error) {
                $msg['msg'] = $error[0]['val'];
                $msg['typ'] = 'err';
            } else {
                if ($warning) {
                    $msg['msg'] = $warning[0]['val'];
                    $msg['typ'] = 'err';
                } else {
                    if ($message) {
                        $msg['msg'] = $message[0]['val'];
                        $msg['typ'] = 'msg';
                    }
                }
            }

            $msg['severity'] = user_id() ? 1 : 2;
            $msg = json_encode($msg);
            echo $msg;
            break;

        case 'unsubscribe_user':
            $subscribe_to = mysql_clean($_POST['subscribe_to']);
            userquery::getInstance()->unsubscribe_user($subscribe_to);

            $error = errorhandler::getInstance()->get_error();
            $warning = errorhandler::getInstance()->get_warning();
            $message = errorhandler::getInstance()->get_message();

            if ($error) {
                $msg['msg'] = $error[0]['val'];
                $msg['typ'] = 'err';
            } else {
                if ($warning) {
                    $msg['msg'] = $warning[0]['val'];
                    $msg['typ'] = 'err';
                } else {
                    if ($message) {
                        $msg['msg'] = $message[0]['val'];
                        $msg['typ'] = 'msg';
                    }
                }
            }

            $msg['severity'] = user_id() ? 1 : 2;
            $msg = json_encode($msg);

            echo $msg;
            break;

        case 'get_subscribers_count':
            $userid = $_POST['userid'];
            if (isset($userid)) {
                $sub_count = userquery::getInstance()->get_user_subscribers($userid, true);
                echo json_encode(['subscriber_count' => $sub_count]);
            } else {
                echo json_encode(['msg' => 'Userid is empty']);
            }
            break;

        case 'ban_user':
            $user = $_POST['user'];
            userquery::getInstance()->ban_user($user);
            $error = errorhandler::getInstance()->get_error();
            $warning = errorhandler::getInstance()->get_warning();
            $message = errorhandler::getInstance()->get_message();

            if ($error) {
                echo '<div class="error">' . $error[0]['val'] . '</div>';
            } else {
                if ($warning) {
                    echo '<div class="warning">' . $warning[0]['val'] . '</div>';
                } else {
                    if ($message) {
                        echo '<div class="msg">' . $message[0]['val'] . '</div>';
                    }
                }
            }
            break;

        case 'spam_comment':
            $rating = Comments::setSpam($_POST['cid']);

            if (msg()) {
                $msg = errorhandler::getInstance()->get_message();
                $msg = $msg[0]['val'];
            }
            if (error()) {
                $err = errorhandler::getInstance()->get_error();
                $err = $err[0]['val'];
            }
            $ajax['msg'] = $msg;
            $ajax['err'] = $err;

            $type = $_POST['type'];
            $typeid = $_POST['typeid'];

            if ($_POST['type'] != 't') {
                update_last_commented($type, $typeid);
            }

            echo json_encode($ajax);
            break;

        case 'add_comment';
            $type = $_POST['type'];
            $comment = $_POST['comment'];
            $reply_to = $_POST['reply_to'];
            $id = $_POST['obj_id'];
            if ($comment == 'undefined') {
                $comment = '';
            }

            $comment_id = Comments::add($comment, $id, $type, $reply_to);

            if (msg()) {
                $msg = errorhandler::getInstance()->get_message();
                $msg = $msg[0]['val'];
                $ajax['msg'] = $msg ? $msg : '';
                $ajax['err'] = "";
                $is_msg = true;
            }
            if (error()) {
                $err = errorhandler::getInstance()->get_error();
                $err = $err[0]['val'];
                $ajax['err'] = $err;
            }

            //Getting Comment
            if ($comment_id) {
                $ajax['cid'] = $comment_id;
                $ajax['type_id'] = $id;
            }

            echo json_encode($ajax);
            break;

        case 'get_comment';
            $id = mysql_clean($_POST['cid']);
            $type_id = mysql_clean($_POST['type_id']);

            $params = [];
            $params['comment_id'] = $id;
            $params['first_only'] = true;
            $new_com = Comments::getAll($params);

            //getting parent id if it is a reply comment
            $parent_id = $new_com['parent_id'];
            assign('type_id', $type_id);
            assign('comment', $new_com);

            if ($parent_id) {
                assign('rep_mode', true);
                echo json_encode(['parent_id' => $parent_id, 'li_data' => Fetch('blocks/comments/comment.html')]);
            } else {
                echo json_encode(['li_data' => Fetch('blocks/comments/comment.html')]);
            }
            break;

        /**
         * Function used to add item in playlist
         */
        case 'add_playlist';
            $id = mysql_clean($_POST['id']);
            $pid = mysql_clean($_POST['pid']);

            $type = post('objtype');

            if ($type == 'video') {
                CBvideo::getInstance()->action->add_playlist_item($pid, $id);
                updateObjectStats('plist', 'video', $id);

                $error = errorhandler::getInstance()->get_error();
                $warning = errorhandler::getInstance()->get_warning();
                $message = errorhandler::getInstance()->get_message();

                if ($error) {
                    $err = '<div class="error">' . $error[0]['val'] . '</div>';
                } else {
                    if ($warning) {
                        $err = '<div class="warning">' . $warning[0]['val'] . '</div>';
                    }
                }
                if ($message) {
                    $msg = '<div class="msg">' . $message[0]['val'] . '</div>';
                }

                $ajax['msg'] = $msg ? $msg : '';
                $ajax['err'] = $err ? $err : '';

                echo json_encode($ajax);
            }
            break;

        case 'add_new_playlist';
            if (post('objtype') == 'video') {
                $vid = mysql_clean($_POST['id']);

                $params = ['name' => mysql_clean($_POST['plname'])];
                $pid = CBvideo::getInstance()->action->create_playlist($params);

                if ($pid) {
                    errorhandler::getInstance()->flush();
                    CBvideo::getInstance()->action->add_playlist_item($pid, $vid);
                }

                $error = errorhandler::getInstance()->get_error();
                $warning = errorhandler::getInstance()->get_warning();
                $message = errorhandler::getInstance()->get_message();

                if ($error) {
                    $err = '<div class="error">' . $error[0]['val'] . '</div>';
                } else {
                    if ($warning) {
                        $err = '<div class="warning">' . $warning[0]['val'] . '</div>';
                    }
                }
                if ($message) {
                    $msg = '<div class="msg">' . $message[0]['val'] . '</div>';
                }
                $ajax['msg'] = $msg ? $msg : '';
                $ajax['err'] = $err ? $err : '';

                echo json_encode($ajax);
            }
            break;

        case 'delete_comment':
            $nb_affected = Comments::delete(['comment_id' => $_POST['cid']]);
            $error = errorhandler::getInstance()->get_error();
            $warning = errorhandler::getInstance()->get_warning();
            $message = errorhandler::getInstance()->get_message();

            if ($error) {
                $err = $error[0]['val'];
            } else {
                if ($warning) {
                    $err = $warning[0]['val'];
                }
            }
            if ($message) {
                $msg = $message[0]['val'];
            }
            $ajax['msg'] = $msg;
            $ajax['err'] = $err;
            $ajax['nb'] = $nb_affected;

            echo json_encode($ajax);
            break;

        case "remove_collection_item":
            $type = $_POST['type'];
            $obj_id = $_POST['obj_id'];
            $cid = $_POST['cid'];

            CBvideo::getInstance()->collection->remove_item($obj_id, $cid);
            if ($type == 'photos') {
                CBPhotos::getInstance()->make_photo_orphan($cid, $obj_id);
            }

            $error = errorhandler::getInstance()->get_error();
            $warning = errorhandler::getInstance()->get_warning();
            $message = errorhandler::getInstance()->get_message();

            if ($error) {
                $err = '<div class="error">' . $error[0]['val'] . '</div>';
            } else {
                if ($warning) {
                    $err = '<div class="warning">' . $warning[0]['val'] . '</div>';
                }
            }
            if ($message) {
                $msg = '<div class="msg">' . $message[0]['val'] . '</div>';
            }
            $ajax['msg'] = $msg;
            $ajax['err'] = $err;

            echo json_encode($ajax);
            break;

        case "get_item":
            $item_id = mysql_clean($_POST['ci_id']);
            $cid = mysql_clean($_POST['cid']);
            $direc = mysql_clean($_POST['direction']);
            $t = $_POST['type'];

            switch ($t) {
                case "videos":
                case "video":
                case "v":
                default:
                    $N_item = CBvideo::getInstance()->collection->get_next_prev_item($item_id, $cid, $direc);
                    break;

                case "photos":
                case "photo":
                case "p":
                    $N_item = CBPhotos::getInstance()->collection->get_next_prev_item($item_id, $cid, $direc);
                    increment_views($N_item[0]['photo_id'], 'photo');
                    break;
            }
            if ($N_item) {
                $ajax['key'] = $N_item[0]['videokey'];
                $ajax['cid'] = $N_item[0]['collection_id'];
                assign('user', userquery::getInstance()->get_user_details($N_item[0]['userid']));
                assign('photo', $N_item[0]);
                $ajax['content'] = Fetch('view_photo.html');
                echo json_encode($ajax);
            } else {
                return false;
            }
            break;

        case "more_items":
        case "moreItems":
            $cid = mysql_clean($_POST['cid']);
            $page = mysql_clean($_POST['page']);
            $newPage = $page + 1;
            $type = $_POST['type'];
            $limit = create_query_limit($page, COLLIP);
            $order = 'collection_items.ci_id DESC';

            switch ($type) {
                case "videos":
                case "video":
                case "v":
                    $items = CBvideo::getInstance()->collection->get_collection_items_with_details($cid, $order, $limit);
                    break;

                case "photos":
                case "photo":
                case "p":
                    $items = CBPhotos::getInstance()->collection->get_collection_items_with_details($cid, $order, $limit);
                    break;
            }
            if ($items) {
                assign('page_no', $newPage);
                assign('type', $type);
                assign('cid', $cid);
                assign('display_type', 'view_collection');
                $itemsArray['pagination'] = Fetch("blocks/new_pagination.html");

                foreach ($items as $item) {
                    assign('object', $item);
                    $itemsArray['content'] .= Fetch("blocks/collection.html");
                }
                echo json_encode($itemsArray);
            } else {
                echo json_encode(["error" => true]);
            }
            break;

        case 'add_collection':
            $name = $_POST['collection_name'];
            $desc = $_POST['collection_description'];
            $tags = genTags($_POST['collection_tags']);
            $cat = $_POST['category'];
            $type = 'photos';
            $CollectParams = [
                'collection_name'        => $name,
                'collection_description' => $desc,
                'collection_tags'        => $tags,
                'category'               => $cat,
                'type'                   => $type,
                'allow_comments'         => $_POST['allow_comments'],
                'broadcast'              => $_POST['broadcast'],
                'public_upload'          => $_POST['public_upload'],
                'sort_type'              => $_POST['sort_type'],
            ];
            if (config('enable_sub_collection') == 'yes') {
                $CollectParams['collection_id_parent'] = $_POST['collection_id_parent'];
            }
            $insert_id = Collections::getInstance()->create_collection($CollectParams);

            $ajax['id'] = $insert_id;
            $collections = Collection::getInstance()->getAllIndent([
                'type'       => 'photos',
                'can_upload' => true
            ], display_group: true);
            assign('collections', $collections);
            assign('selected', $insert_id);
            $response = templateWithMsgJson('blocks/collection_select_upload.html', false);
            $response['photoForm'] = getTemplate('blocks/upload/photo_form.html');
            $response['success'] = (bool)$insert_id;
            echo json_encode($response);
            break;

        case "ajaxPhotos":
            CBPhotos::getInstance()->insert_photo();
            $ajax = [];

            if (msg()) {
                $msg = errorhandler::getInstance()->get_message();
                $msg = '<div id="photoUploadingMessages" class="ajaxMessages msg">' . $msg[0]['val'] . '</div>';
                $ajax['msg'] = $msg;
            }
            if (error()) {
                $err = errorhandler::getInstance()->get_error();
                $err = '<div id="photoUploadingMessages" class="ajaxMessages err">' . $err[0]['val'] . '</div>';
                $ajax['err'] = $err;
            }

            echo json_encode($ajax);
            break;

        case "viewPhotoRating":
            $pid = mysql_clean($_POST['photoid']);
            $returnedArray = CBPhotos::getInstance()->photo_voters($pid);
            echo $returnedArray;
            break;

        case "channelFeatured":
            $contentType = $_POST['contentType'];
            if (!$contentType) {
                echo json_encode(["error" => lang("content_type_empty")]);
            } else {
                switch ($contentType) {
                    case "videos":
                    case "video":
                    case "vid":
                    case "v":
                    case "vdo":
                        $video = CBvideo::getInstance()->get_video(mysql_clean($_POST['objID']));
                        if ($video) {
                            assign('object', $video);
                            $content = Fetch('/blocks/view_channel/channel_item.html');
                        }
                        break;

                    case "photo":
                    case "photos":
                    case "foto":
                    case "p":
                        $photo = CBPhotos::getInstance()->get_photo(mysql_clean($_POST['objID']));
                        if ($photo) {
                            assign('object', $photo);
                            $content = Fetch('/blocks/view_channel/channel_item.html');
                        }
                        break;
                }

                if ($content) {
                    echo json_encode(["data" => $content]);
                } else {
                    echo json_encode(["error" => "Nothing Found"]);
                }
            }
            break;

        case 'loadAjaxPhotos':
            $photosType = $_POST['photosType'];
            $cond = ['limit' => config('photo_home_tabs')];
            switch ($photosType) {
                case 'last_viewed':
                default:
                    $cond['order'] = " last_viewed DESC";
                    break;

                case "most_recent":
                    $cond['order'] = " date_added DESC";
                    break;

                case "featured":
                    $cond['featured'] = "yes";
                    break;

                case "most_favorited":
                    $cond['order'] = " total_favorites DESC";
                    break;

                case "most_commented":
                    $cond['order'] = " total_comments DESC";
                    break;

                case "highest_rated":
                    $cond['order'] = " rating DESC, rated_by DESC";
                    break;

                case "most_viewed":
                    $cond['order'] = " views DESC";
                    break;

                case "most_downloaded":
                    $cond['order'] = " downloaded DESC";
                    break;
            }

            $photos = get_photos($cond);
            if ($photos) {
                foreach ($photos as $photo) {
                    assign("photo", $photo);
                    $cond['photoBlocks'] .= Fetch("/blocks/photo.html");
                }
                $cond['completed'] = "successfull";
            } else {
                $cond['failed'] = "successfully";
            }

            echo json_encode($cond);
            break;

        /**
         * Getting comments along with template
         */
        case 'getComments':
            $limit = config('comment_per_page') ? config('comment_per_page') : 10;
            $page = $_POST['page'];

            $params = [];
            $params['type'] = $_POST['type'];
            $params['type_id'] = $_POST['type_id'];
            $params['limit'] = create_query_limit($page, $limit);
            $params['hierarchy'] = true;
            $comments = Comments::getAll($params);

            $admin = '';
            if ($_POST['admin'] == 'yes' && User::getInstance()->hasAdminAccess()) {
                $admin = 'yes';
            }

            //Adding Pagination
            $total_pages = count_pages($_POST['total_comments'], $limit);
            assign('object_type', $_POST['object_type']);

            //Pagination
            pages::getInstance()->paginate($total_pages, $page, null, null, '<li><a href="javascript:void(0);"
            onClick="_cb.getAllComments(\'' . display_clean($_POST['type']) . '\',\'' . display_clean($_POST['type_id']) . '\',\'' .display_clean($_POST['last_update']) . '\',
            \'#page#\',\'' . $_POST['total_comments'] . '\',\'' . display_clean($_POST['object_type']) . '\',\'' . $admin . '\')">#page#</a></li>');

            assign('comments', $comments);
            assign('type', $_POST['type']);
            assign('type_id', $_POST['type_id']);
            assign('last_update', $_POST['last_update']);
            assign('total', $_POST['total_comments']);
            assign('total_pages', $total_pages);
            assign('comments_voting', $_POST['comments_voting']);
            assign('commentPagination', 'yes');

            Template('blocks/comments/comments.html');
            Template('blocks/pagination.html');
            break;

        case 'getCommentsNew':
            $limit = config('comment_per_page') ? config('comment_per_page') : 10;
            $page = $_POST['page'];

            $params = [];
            $params['type'] = $_POST['type'];
            $params['type_id'] = $_POST['type_id'];
            $params['limit'] = create_query_limit($page, $limit);
            $params['hierarchy'] = true;
            $comments = Comments::getAll($params);

            $admin = '';
            if ($_POST['admin'] == 'yes' && User::getInstance()->hasAdminAccess()) {
                $admin = 'yes';
            }

            //Adding Pagination
            $total_pages = count_pages($_POST['total_comments'], $limit);
            assign('object_type', mysql_clean($_POST['object_type']));

            assign('comments', $comments);
            assign('type', $_POST['type']);
            assign('type_id', $_POST['type_id']);
            assign('last_update', $_POST['last_update']);
            assign('total', $_POST['total_comments']);
            assign('total_pages', $total_pages);
            assign('comments_voting', $_POST['comments_voting']);
            assign('commentPagination', 'yes');
            if ($comments) {
                Template('blocks/comments/comments.html');
            } else {
                echo '';
            }
            break;

        case 'photo_ajax':
            try {
                if (isset($_POST['photo_pre'])) {
                    $photo = $_POST['photo_pre'];
                    $user = $_POST['user'];
                    $items = $_POST['item'];
                    $ci_id = $photo['ci_id'];
                    $collection = $photo['collection_id'];    // collection id.
                    $link = Collections::getInstance()->get_next_prev_item($ci_id, $collection, $item = $items, $limit = 1, $check_only = false); // getting Previous item
                    $srcString = '/files/photos/' . $link[0]['file_directory'] . '/' . $link[0]['filename'] . '.' . $link[0]['ext']; // Image Source...
                    $photo_key = $link[0]['photo_key']; // Image Key.
                    $response['photo'] = $link;
                    $response['photo_key'] = $photo_key;
                    $response['src_string'] = $srcString; // Image source.
                    $response['collection_id'] = $collection;
                    echo json_encode($response);
                }
            } catch (Exception $e) {
                $response["error_ex"] = true;
                $response["msg"] = 'Message: ' . $e->getMessage();
                echo(json_encode($response));
            }
            break;

        case 'user_suggest':
            $typed = mysql_clean($_POST['typed']);
            if (empty($typed)) {
                return 'none';
            }
            $raw_users = Clipbucket_db::getInstance()->select(tbl('users'), 'username', "username LIKE '%$typed%' LIMIT 0,5");
            $matching_users['matching_users'] = [];
            foreach ($raw_users as $key => $userdata) {
                $matching_users['matching_users'][] = $userdata['username'];
            }
            if (empty($matching_users)) {
                return 'none';
            }

            echo json_encode($matching_users);
            break;

        default:
            header('location:' . DirPath::getUrl('root'));
            break;
    }
} else {
    header('location:' . DirPath::getUrl('root'));
    die();
}

