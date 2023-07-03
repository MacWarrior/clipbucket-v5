<?php
define('THIS_PAGE', 'ajax');
require 'includes/config.inc.php';

global $userquery, $cbvid, $cbphoto, $cbcollection, $eh, $cbvideo, $myquery, $cbfeeds;

if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
} else {
    header('location:' . BASEURL);
    die();
}

if (!empty($mode)) {
    switch ($mode) {
        case 'recent_viewed_vids':
            if (!isSectionEnabled('videos') || !$userquery->perm_check('view_videos', false, true)) {
                exit();
            }

            $videos = get_videos(['limit' => config('videos_items_hme_page'), 'order' => 'last_viewed DESC']);
            if ($videos) {
                foreach ($videos as $video) {
                    assign('video', $video);
                    Template('blocks/video.html');
                }
            }
            break;

        case 'most_viewed':
            if (!isSectionEnabled('videos') || !$userquery->perm_check('view_videos', false, true)) {
                exit();
            }

            $videos = get_videos(['limit' => config('videos_items_hme_page'), 'order' => 'views DESC']);
            if ($videos) {
                foreach ($videos as $video) {
                    assign('video', $video);
                    Template('blocks/video.html');
                }
            }
            break;

        case 'recently_added':
            if (!isSectionEnabled('videos') || !$userquery->perm_check('view_videos', false, true)) {
                exit();
            }

            $videos = get_videos(['limit' => config('videos_items_hme_page'), 'order' => 'date_added DESC']);
            if ($videos) {
                foreach ($videos as $video) {
                    assign('video', $video);
                    Template('blocks/video.html');
                }
            }
            break;

        case 'featured_videos':
            if (!isSectionEnabled('videos') || !$userquery->perm_check('view_videos', false, true)) {
                exit();
            }

            $videos = get_videos(['limit' => config('videos_items_hme_page'), 'featured' => 'yes', 'order' => 'featured_date DESC']);
            if ($videos) {
                foreach ($videos as $video) {
                    assign('video', $video);
                    Template('blocks/video.html');
                }
            }
            break;

        case 'load_more':
            $limit = $_POST['limit'];
            $total = $_POST['total'];

            $inner_mode = $_POST['inner_mode'];
            switch ($inner_mode) {
                case 'load_more_videos':
                    $videos_arr = ['order' => 'date_added DESC', 'limit' => '' . $limit . ',' . $limit];
                    $results = get_videos($videos_arr);
                    $next_limit = $limit + $limit;
                    $videos_arr_next = ['order' => 'date_added DESC', 'limit' => '' . $next_limit . ',' . $next_limit];
                    $videos_next = get_videos($videos_arr_next);
                    if ($total == $next_limit || $total < $next_limit) {
                        $count_next = 0;
                    } else {
                        $count_next = count($videos_next);
                    }
                    $total_results = $total;
                    $template_path = 'blocks/videos/video.html';
                    $assigned_variable_smarty = 'video';
                    break;

                case 'load_more_users':
                    $users_arr = ['limit' => '' . $limit . ',' . $limit];
                    $results = get_users($users_arr);
                    $next_limit = $limit + $limit;
                    $users_arr_next = ['limit' => '' . $next_limit . ',' . $next_limit];
                    $users_next = get_videos($users_arr_next);
                    if ($total == $next_limit || $total < $next_limit) {
                        $count_next = 0;
                    } else {
                        $count_next = count($users_next);
                    }
                    $count_next = (int)$count_next;
                    $total_results = $total;
                    $template_path = 'blocks/channels.html';
                    $assigned_variable_smarty = 'user';
                    break;

                case 'load_more_playlist':
                    $userid = $_POST['cat_id'];
                    $play_arr = ['user' => $userid, 'order' => 'date_added DESC', 'limit' => '' . $limit . ',' . $limit];
                    $results = $cbvid->action->get_playlists($play_arr);
                    $next_limit = $limit + $limit;
                    $play_arr_next = ['user' => $userid, 'order' => 'date_added DESC', 'limit' => '' . $next_limit . ',' . $next_limit];
                    $playlist_next = $cbvid->action->get_playlists($play_arr_next);
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
                    $result = $cbvid->rate_video($id, $rating);
                    $result['is_rating'] = true;
                    $cbvid->show_video_rating($result);

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
                    $result = $cbphoto->rate_photo($id, $rating);
                    $result['is_rating'] = true;
                    $cbvid->show_video_rating($result);

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
                    $result = $cbcollection->rate_collection($id, $rating);
                    $result['is_rating'] = true;
                    $cbvid->show_video_rating($result);

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
                    $result = $userquery->rate_user($id, $rating);
                    $result['is_rating'] = true;
                    $cbvid->show_video_rating($result);

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
                    $vdo = $cbvid->get_video($id);
                    $cbvid->set_share_email($vdo);
                    $cbvid->action->share_content($vdo['videoid']);
                    break;

                case 'p':
                case 'photo':
                    $ph = $cbphoto->get_photo($_POST['id']);
                    $cbphoto->set_share_email($ph);
                    $cbphoto->action->share_content($ph['photo_id']);
                    break;

                case 'cl':
                case 'collection':
                    $cl = $cbcollection->get_collection($_POST['id']);
                    $cbcollection->set_share_mail($cl);
                    $cbcollection->action->share_content($cl['collection_id']);
                    break;
            }

            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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
                    $cbvideo->action->add_to_fav($id);
                    updateObjectStats('fav', 'video', $id); // Increment in total favs
                    $funcs = cb_get_functions('favorite_video');
                    break;

                case 'p':
                case 'photo':
                    $cbphoto->action->add_to_fav($id);
                    updateObjectStats('fav', 'photo', $id); // Increment in total favs
                    $funcs = cb_get_functions('favorite_photo');
                    break;

                case 'cl':
                case 'collection':
                    $cbcollection->action->add_to_fav($id);
                    $funcs = cb_get_functions('favorite_collection');
                    break;
            }

            if ($funcs) {
                foreach ($funcs as $func) {
                    $func['func']($id);
                }
            }

            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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
            switch ($type) {
                case 'v':
                case 'video':
                default:
                    $cbvideo->action->report_it($id);
                    break;

                case 'u':
                case 'user':
                    $userquery->action->report_it($id);
                    break;

                case 'p':
                case 'photo':
                    $cbphoto->action->report_it($id);
                    break;

                case 'cl':
                case 'collection':
                    $cbcollection->action->report_it($id);
                    break;
            }

            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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
            $mailId = $userquery->get_user_details($subscribe_to, false, true);
            $userquery->subscribe_user($subscribe_to);

            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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

            $msg['severity'] = userid() ? 1 : 2;
            $msg = json_encode($msg);
            echo $msg;
            break;

        case 'unsubscribe_user':
            $subscribe_to = mysql_clean($_POST['subscribe_to']);
            $userquery->unsubscribe_user($subscribe_to);

            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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

            $msg['severity'] = userid() ? 1 : 2;
            $msg = json_encode($msg);

            echo $msg;
            break;

        case 'get_subscribers_count':
            $userid = $_POST['userid'];
            if (isset($userid)) {
                $sub_count = $userquery->get_user_subscribers($userid, true);
                echo json_encode(['subscriber_count' => $sub_count]);
            } else {
                echo json_encode(['msg' => 'Userid is empty']);
            }
            break;

        case 'add_friend':
            global $cbemail;
            $friend = mysql_clean($_POST['uid']);
            $userid = userid();
            $username = user_name();
            $mailId = $userquery->get_user_details($friend, false, true);
            $cbemail->friend_request_email($mailId['email'], $username);

            if ($userid) {
                $userquery->add_contact($userid, $friend);
                $error = $eh->get_error();
                $warning = $eh->get_warning();
                $message = $eh->get_message();

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
            } else {
                echo '<div class="error">' . lang('you_not_logged_in') . '</div>';
            }
            break;

        case 'ban_user':
            $user = $_POST['user'];
            $userquery->ban_user($user);
            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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
            echo $msg;
            break;

        case 'rate_comment':
            $thumb = $_POST['thumb'];
            $cid = mysql_clean($_POST['cid']);
            $rate = ($thumb == 'down') ? -1 : 1;
            $rating = $myquery->rate_comment($rate, $cid);

            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

            if ($error) {
                $msg = $error[0]['val'];
            } else {
                if ($warning) {
                    $msg = $warning[0]['val'];
                } else {
                    if ($message) {
                        $msg = $message[0]['val'];
                    }
                }
            }
            $ajax['msg'] = $msg;
            $ajax['rate'] = comment_rating($rating);

            //updating last update...
            $type = $_POST['type'];
            $typeid = $_POST['typeid'];
            update_last_commented($type, $typeid);

            echo json_encode($ajax);
            break;

        case 'spam_comment':
            $cid = mysql_clean($_POST['cid']);

            $rating = $myquery->spam_comment($cid);

            if (msg()) {
                $msg = msg_list();
                $msg = $msg[0]['val'];
            }
            if (error()) {
                $err = error_list();
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

            switch ($type) {
                case 'v':
                case 'video':
                default:
                    $cid = $cbvid->add_comment($comment, $id, $reply_to);
                    break;

                case 'u':
                case 'c':
                    $cid = $userquery->add_comment($comment, $id, $reply_to);
                    break;

                case 'cl':
                case 'collection':
                    $cid = $cbcollection->add_comment($comment, $id, $reply_to);
                    break;

                case 'p':
                case 'photo':
                    $cid = $cbphoto->add_comment($comment, $id, $reply_to);
                    break;
            }

            if (msg()) {
                $msg = msg_list();
                $msg = $msg[0]['val'];
                $ajax['msg'] = $msg ? $msg : '';
                $ajax['err'] = "";
                $is_msg = true;
            }
            if (error()) {
                $err = error_list();
                $err = $err[0]['val'];
                $ajax['err'] = $err;
            }

            //Getting Comment
            if ($cid) {
                $ajax['cid'] = $cid;
                $ajax['type_id'] = $id;
            }

            echo json_encode($ajax);
            break;

        case 'get_comment';
            $id = mysql_clean($_POST['cid']);
            $type_id = mysql_clean($_POST['type_id']);
            $new_com = $myquery->get_comment($id);

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
                $cbvid->action->add_playlist_item($pid, $id);
                updateObjectStats('plist', 'video', $id);

                $error = $eh->get_error();
                $warning = $eh->get_warning();
                $message = $eh->get_message();

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
                $pid = $cbvid->action->create_playlist($params);

                if ($pid) {
                    $eh->flush();
                    $cbvid->action->add_playlist_item($pid, $vid);
                }

                $error = $eh->get_error();
                $warning = $eh->get_warning();
                $message = $eh->get_message();

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


        case 'quicklist':
            $todo = $_POST['todo'];
            $id = mysql_clean($_POST['vid']);

            if ($todo == 'add') {
                echo $cbvid->add_to_quicklist($id);
            } else {
                echo $cbvid->remove_from_quicklist($id);
            }

            break;

        case 'getquicklistbox';
            if ($cbvid->total_quicklist() > 0) {
                TEMPLATE('blocks/quicklist/block.html');
            }
            break;

        case 'clear_quicklist':
            $cbvid->clear_quicklist();
            return 'removed';

        case 'delete_comment':
            $type = $_POST['type'];
            $cid = mysql_clean($_POST['cid']);
            $type_id = $myquery->delete_comment($cid);
            switch ($type) {
                case 'v':
                case 'video':
                default:
                    $cbvid->update_comments_count($type_id);
                    break;

                case 'u':
                case 'c':
                    $userquery->update_comments_count($type_id);
                    break;

                case 'photo':
                case 'p':
                    $cbphoto->update_total_comments($type_id);
                    break;

                case 'cl':
                case 'collection':
                    $cbcollection->update_total_comments($type_id);
                    break;
            }
            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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

            echo json_encode($ajax);
            break;

        case "add_new_item":
            $type = $_POST['type'];
            $cid = $_POST['cid'];
            $id = $_POST['obj_id'];

            switch ($type) {
                case "videos":
                case "video":
                case "v":
                    $cbvideo->collection->add_collection_item($id, $cid);
                    break;

                case "photos":
                case "photo":
                case "p":
                    $cbphoto->collection->add_collection_item($id, $cid);
                    break;
            }

            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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

        case "remove_collection_item":
            $type = $_POST['type'];
            $obj_id = $_POST['obj_id'];
            $cid = $_POST['cid'];

            $cbvideo->collection->remove_item($obj_id, $cid);
            if ($type == 'photos') {
                $cbphoto->make_photo_orphan($cid, $obj_id);
            }

            $error = $eh->get_error();
            $warning = $eh->get_warning();
            $message = $eh->get_message();

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
                    $N_item = $cbvideo->collection->get_next_prev_item($item_id, $cid, $direc);
                    break;

                case "photos":
                case "photo":
                case "p":
                    $N_item = $cbphoto->collection->get_next_prev_item($item_id, $cid, $direc);
                    increment_views($N_item[0]['photo_id'], 'photo');
                    break;
            }
            if ($N_item) {
                $ajax['key'] = $N_item[0]['videokey'];
                $ajax['cid'] = $N_item[0]['collection_id'];
                assign('type', $t);
                assign('user', $userquery->get_user_details($N_item[0]['userid']));
                assign('object', $N_item[0]);
                $ajax['content'] = Fetch('view_item.html');
                echo json_encode($ajax);
            } else {
                return false;
            }
            break;

        case "load_more_items":
        case "more_items":
        case "moreItems":
            $cid = mysql_clean($_POST['cid']);
            $page = mysql_clean($_POST['page']);
            $newPage = $page + 1;
            $type = $_POST['type'];
            $limit = create_query_limit($page, COLLIP);
            $order = tbl("collection_items") . ".ci_id DESC";

            switch ($type) {
                case "videos":
                case "video":
                case "v":
                    $items = $cbvideo->collection->get_collection_items_with_details($cid, $order, $limit);
                    break;

                case "photos":
                case "photo":
                case "p":
                    $items = $cbphoto->collection->get_collection_items_with_details($cid, $order, $limit);
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
                'allow_comments'         => 'yes',
                'broadcast'              => 'public',
                'public_upload'          => 'yes'
            ];
            if (config('enable_sub_collection')) {
                $CollectParams['collection_id_parent'] = $_POST['collection_id_parent'];
            }
            $insert_id = $cbcollection->create_collection($CollectParams);

            if (msg()) {
                $msg = msg_list();
                $msg = $msg[0]['val'];
                $ajax['msg'] = $msg;
            }
            if (error()) {
                $err = error_list();
                $err = $err[0]['val'];
                $ajax['err'] = $err;
            }

            $ajax['id'] = $insert_id;

            echo json_encode($ajax);
            break;

        case "ajaxPhotos":
            $cbphoto->insert_photo();
            $ajax = [];

            if (msg()) {
                $msg = msg_list();
                $msg = '<div id="photoUploadingMessages" class="ajaxMessages msg">' . $msg[0]['val'] . '</div>';
                $ajax['msg'] = $msg;
            }
            if (error()) {
                $err = error_list();
                $err = '<div id="photoUploadingMessages" class="ajaxMessages err">' . $err[0]['val'] . '</div>';
                $ajax['err'] = $err;
            }

            echo json_encode($ajax);
            break;

        case "viewPhotoRating":
            $pid = mysql_clean($_POST['photoid']);
            $returnedArray = $cbphoto->photo_voters($pid);
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
                        $video = $cbvideo->get_video_details(mysql_clean($_POST['objID']));
                        if ($video) {
                            assign('object', $video);
                            $content = Fetch('/blocks/view_channel/channel_item.html');
                        }
                        break;

                    case "photo":
                    case "photos":
                    case "foto":
                    case "p":
                        $photo = $cbphoto->get_photo(mysql_clean($_POST['objID']));
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

        case "viewCollectionRating":
            $cid = mysql_clean($_POST['cid']);
            $returnedArray = $cbcollection->collection_voters($cid);
            echo($returnedArray);
            break;

        case "loadAjaxPhotos":
            $photosType = $_POST['photosType'];
            $cond = ['limit' => config("photo_home_tabs")];
            switch ($photosType) {
                case "last_viewed":
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
        case "getComments":
            $params = [];

            $limit = config('comment_per_page') ? config('comment_per_page') : 10;
            $page = $_POST['page'];
            $params['type'] = mysql_clean($_POST['type']);
            $params['type_id'] = mysql_clean($_POST['type_id']);
            $params['last_update'] = mysql_clean($_POST['last_update']);
            $params['limit'] = create_query_limit($page, $limit);
            $params['cache'] = 'no';

            $admin = "";
            if ($_POST['admin'] == 'yes' && has_access('admin_access', true)) {
                $params['cache'] = 'no';
                $admin = "yes";
            }
            $comments = $myquery->getComments($params);
            //Adding Pagination
            $total_pages = count_pages($_POST['total_comments'], $limit);
            assign('object_type', $_POST['object_type']);
            //Pagination
            $pages->paginate($total_pages, $page, null, null, '<li><a href="javascript:void(0);"
            onClick="_cb.getAllComments(\'' . $params['type'] . '\',\'' . $params['type_id'] . '\',\'' . $params['last_update'] . '\',
            \'#page#\',\'' . $_POST['total_comments'] . '\',\'' . mysql_clean($_POST['object_type']) . '\',\'' . $admin . '\')">#page#</a></li>');

            assign('comments', $comments);
            assign('type', $params['type']);
            assign('type_id', $params['type_id']);
            assign('last_update', $params['last_update']);
            assign('total', $_POST['total_comments']);
            assign('total_pages', $total_pages);
            assign('comments_voting', $_POST['comments_voting']);
            assign('commentPagination', 'yes');
            assign('commentPagination', 'yes');

            Template('blocks/comments/comments.html');
            Template('blocks/pagination.html');
            break;

        case "getCommentsNew":
            $params = [];

            $limit = config('comment_per_page') ? config('comment_per_page') : 10;
            $page = $_POST['page'];
            $params['type'] = mysql_clean($_POST['type']);
            $params['type_id'] = mysql_clean($_POST['type_id']);
            $params['last_update'] = mysql_clean($_POST['last_update']);
            $params['limit'] = create_query_limit($page, $limit);
            $params['cache'] = 'no';

            $admin = "";
            if ($_POST['admin'] == 'yes' && has_access('admin_access', true)) {
                $params['cache'] = 'no';
                $admin = "yes";
            }
            $comments = $myquery->getComments($params);
            //Adding Pagination
            $total_pages = count_pages($_POST['total_comments'], $limit);
            assign('object_type', mysql_clean($_POST['object_type']));

            assign('comments', $comments);
            assign('type', $params['type']);
            assign('type_id', $params['type_id']);
            assign('last_update', $params['last_update']);
            assign('total', $_POST['total_comments']);
            assign('total_pages', $total_pages);
            assign('comments_voting', $_POST['comments_voting']);
            assign('commentPagination', 'yes');
            if ($comments) {
                Template('blocks/comments/comments.html');
            } else {
                echo "";
            }
            break;

        case "delete_feed":
            $uid = mysql_clean($_POST['uid']);
            $file = mysql_clean($_POST['file']) . '.feed';
            if ($uid && $file) {
                if ($uid == userid() || has_access("admin_access", true)) {
                    $cbfeeds->deleteFeed($uid, $file);
                    $array['msg'] = lang("feed_has_been_deleted");
                } else {
                    $array['err'] = lang("you_cant_del_this_feed");
                }
            }
            echo json_encode($array);
            break;

        case "become_contributor" :
            $uid = userid();
            $cid = $_POST['cid'];
            $array = [];

            if ($cbcollection->add_contributor($cid, $uid)) {
                $array['msg'] = 'Successfully added as contributor';
            } else {
                $array['err'] = error('single');
            }

            echo json_encode($array);
            break;

        case "remove_contributor" :
            $uid = userid();
            $cid = $_POST['cid'];
            $array = [];

            if ($cbcollection->remove_contributor($cid, $uid)) {
                $array['msg'] = 'Successfully removed from contributors';
            } else {
                $array['err'] = error('single');
            }

            echo json_encode($array);
            break;

        case 'photo_ajax':
            try {
                if (isset($_POST['photo_pre'])) {
                    $photo = $_POST['photo_pre'];
                    $user = $_POST['user'];
                    $items = $_POST['item'];
                    $ci_id = $photo['ci_id'];
                    $collection = $photo['collection_id'];    // collection id.
                    $link = $cbcollection->get_next_prev_item($ci_id, $collection, $item = $items, $limit = 1, $check_only = false); // getting Previous item
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
            global $db;
            $typed = mysql_clean($_POST['typed']);
            if (empty($typed)) {
                return "none";
            }
            $raw_users = $db->select(tbl("users"), "username", "username LIKE '%$typed%' LIMIT 0,5");
            $matching_users['matching_users'] = [];
            foreach ($raw_users as $key => $userdata) {
                $matching_users['matching_users'][] = $userdata['username'];
            }
            if (empty($matching_users)) {
                return "none";
            } else {
                echo json_encode($matching_users);
            }
            break;

        default:
            header('location:' . BASEURL);
            break;
    }
} else {
    header('location:' . BASEURL);
    die();
}

