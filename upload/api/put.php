<?php
/**
 * Api Put method to add/upload/insert stuff
 * on ClipBucket website
 */
include('../includes/config.inc.php');
include('global.php');

$request = $_REQUEST;
$mode = $request['mode'];

$api_keys = $Cbucket->api_keys;
if ($api_keys) {
    if (!in_array($request['api_key'], $api_keys)) {
        exit(json_encode(['err' => 'App authentication error']));
    }
}

switch ($mode) {
    case "upload_video":
        echo json_encode($_POST, $_FILES);
        break;

    case "addComment":
        $type = $request['type'];
        switch ($type) {
            case 'v':
            case 'video':
                $id = mysql_clean($request['obj_id']);
                $comment = $request['comment'];
                if ($comment == 'undefined') {
                    $comment = '';
                }
                $reply_to = $request['reply_to'];

                $cid = $cbvid->add_comment($comment, $id, $reply_to);
                break;

            case 'u':
            case 'c':
                $id = mysql_clean($request['obj_id']);
                $comment = $request['comment'];
                if ($comment == 'undefined') {
                    $comment = '';
                }
                $reply_to = $request['reply_to'];

                $cid = $userquery->add_comment($comment, $id, $reply_to);
                break;

            case 'cl':
            case 'collection':
                $id = mysql_clean($request['obj_id']);
                $comment = $request['comment'];
                if ($comment == 'undefined') {
                    $comment = '';
                }
                $reply_to = $request['reply_to'];

                $cid = $cbcollection->add_comment($comment, $id, $reply_to);
                break;

            case "p":
            case "photo":
                $id = mysql_clean($request['obj_id']);
                $comment = $request['comment'];
                if ($comment == 'undefined') {
                    $comment = '';
                }
                $reply_to = $request['reply_to'];
                $cid = $cbphoto->add_comment($comment, $id, $reply_to);
                break;

            case 'f':
            case 'feed':
                $id = mysql_clean($request['obj_id']);
                $comment = $request['comment'];
                if ($comment == 'undefined') {
                    $comment = '';
                }
                $reply_to = $request['reply_to'];

                $cid = $cbfeeds->add_comment($comment, $id, $reply_to);
                break;

            default:
                echo json_encode(['err' => 'Invalid Type']);
                exit();
        }

        if (error()) {
            exit(json_encode(['err' => error(), 'session' => $_COOKIE['PHPSESSID']]));
        }

        $comment = $myquery->get_comment($cid);
        $array = [
            'msg'     => msg(),
            'comment' => $comment,
            'success' => 'ok',
            'cid'     => $cid
        ];
        echo json_encode($array);
        break;

    case "create_playlist":
    case "addPlaylist":
    case "add_playlist":
        $array = [
            'name',
            'description',
            'tags',
            'playlist_type',
            'privacy',
            'allow_comments',
            'allow_rating',
            'type',
        ];

        $type = $request['type'];

        $input = [];
        foreach ($array as $ar) {
            $input[$ar] = mysql_clean($request[$ar]);
        }

        if ($type == 'v' || !isset($type)) {
            $pid = $cbvid->action->create_playlist($input);
        }

        if (!$type) {
            e(lang("Invalid playlist type"));
        }

        if (VERSION > 2.7) {
            $rel = get_rel_list();
        }

        if (error()) {
            $rel = [];
            echo json_encode(['err' => error(), 'rel' => $rel]);
        } else {
            $playlist = $cbvid->action->get_playlist($pid);

            echo json_encode(['success' => 'yes', 'rel' => $rel,
                              'pid'     => $pid, 'playlist' => $playlist,
                              'msg'     => msg()]);
        }
        break;

    case "delete_playlist":
        $cbvid->action->delete_playlist($request['playlist_id']);

        if (error()) {
            echo json_encode(['err' => error()]);
        } else {
            echo json_encode(['msg' => [lang('Playlist has been removed')]]);
        }
        break;


    case "add_playlist_item":
        $type = $request['type'];
        $pid = mysql_clean($request['playlist_id']);
        $id = mysql_clean($request['object_id']);

        switch ($type) {
            case 'v':
            default:
                $item_id = $cbvid->action->add_playlist_item($pid, $id);

                if (!error()) {
                    updateObjectStats('plist', 'video', $id);
                    echo json_encode(['status' => 'ok',
                                      'msg'    => msg(), 'item_id' => $item_id, 'updated' => nicetime(now())]);
                } else {
                    echo json_encode(['err' => error()]);
                }
        }
        break;

    case "remove_playlist_item":
        $item_id = mysql_clean($request['item_id']);
        $cbvid->action->delete_playlist_item($item_id);
        if (error()) {
            echo json_encode(['err' => error()]);
        } else {
            echo json_encode(['success' => 'ok']);
        }
        break;

    case "delete_favorite":
        $video_id = mysql_clean($request['videoid']);
        $cbvid->action->remove_favorite($video_id);
        if (error()) {
            echo json_encode(['err' => error()]);
        } else {
            echo json_encode(['success' => 'ok', 'msg' => lang('Video has been removed')]);
        }
        break;

    case "add_favorite":
        $video_id = mysql_clean($request['videoid']);
        $cbvid->action->add_to_fav($video_id);
        if (error()) {
            echo json_encode(['err' => error()]);
        } else {
            echo json_encode(['success' => 'ok', 'msg' => lang('Video has been added')]);
        }
        break;

    case "insert_video":
        $title = $request['title'];
        $file_name = time() . RandomString(5);

        $file_directory = create_dated_folder();

        $vidDetails = [
            'title'          => $title,
            'description'    => $title,
            'tags'           => genTags(str_replace(' ', ', ', $title)),
            'category'       => [$cbvid->get_default_cid()],
            'file_name'      => $file_name,
            'file_directory' => $file_directory,
            'userid'         => user_id(),
        ];

        $vid = $Upload->submit_upload($vidDetails);

        echo json_encode(['success'   => 'yes',
                          'vid'       => $vid, 'file_directory' => $file_directory,
                          'file_name' => $file_name]);
        break;

    case "update_video":
        //Setting up the categories..
        $request['category'] = explode(',', $request['category']);
        $request['videoid'] = trim($request['videoid']);

        $_POST = $request;

        $Upload->validate_video_upload_form();

        if (empty($eh->get_error())) {
            $cbvid->update_video();
        }

        if (error()) {
            echo json_encode(['error' => error('single')]);
        } else {
            echo json_encode(['msg' => msg('single')]);
        }
        break;

    case "rating":
        $type = mysql_clean($request['type']);
        $id = mysql_clean($request['id']);
        $rating = mysql_clean($request['rating']);

        switch ($type) {
            case "video":
            case "v":
                $result = $cbvid->rate_video($id, $rating);
                echo json_encode(['success' => 'ok']);
                break;

            case "photo":
                $rating = $_POST['rating'] * 2;
                $id = $_POST['id'];
                $result = $cbphoto->rate_photo($id, $rating);
                $result['is_rating'] = true;
                $cbvid->show_video_rating($result);

                $funcs = cb_get_functions('rate_photo');
                if ($funcs) {
                    foreach ($funcs as $func)
                        $func['func']($id);
                }
                break;

            case "collection":
                $rating = $_POST['rating'] * 2;
                $id = $_POST['id'];
                $result = $cbcollection->rate_collection($id, $rating);
                $result['is_rating'] = true;
                $cbvid->show_video_rating($result);

                $funcs = cb_get_functions('rate_collection');
                if ($funcs) {
                    foreach ($funcs as $func)
                        $func['func']($id);
                }
                break;

            case "user":
                $rating = $_POST['rating'] * 2;
                $id = $_POST['id'];
                $result = $userquery->rate_user($id, $rating);
                $result['is_rating'] = true;
                $cbvid->show_video_rating($result);

                $funcs = cb_get_functions('rate_user');
                if ($funcs) {
                    foreach ($funcs as $func)
                        $func['func']($id);
                }
                break;
        }
        break;

    case 'flag_object':
        $type = strtolower($request['type']);
        $id = $request['id'];
        switch ($type) {
            case 'v':
            case 'video':
            default:
                $reported = $cbvideo->action->report_it($id);
                break;

            case 'u':
            case 'user':
                $userquery->action->report_it($id);
                break;

            case 'p':
            case 'photo':
                $cbphoto->action->report_it($id);
                break;

            case "cl":
            case "collection":
                $cbcollection->action->report_it($id);
                break;
        }

        $error = $eh->get_error();
        $warning = $eh->get_warning();
        $message = $eh->get_message();

        $msg = [];
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
                    $msg['success'] = 'yes';
                }
            }
        }

        echo json_encode($msg);
        break;


    case "removeVideo":
    case "remove_video":
    case "deleteVideo":
    case "delete_video":
        $vid = $request['vid'];
        $vid = mysql_clean($vid);
        $cbvideo->delete_video($vid);

        $error = $eh->get_error();
        $warning = $eh->get_warning();
        $message = $eh->get_message();

        $msg = [];
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
                    $msg['success'] = 'yes';
                }
            }
        }

        echo json_encode($msg);
        break;

    case "subscribe":
        $to = $request['to'];
        $to = mysql_clean($to);
        $subscribe_to = $to;
        $userquery->subscribe_user($subscribe_to);

        $msg = [];
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
                    $msg['success'] = 'yes';
                }
            }
        }

        echo json_encode($msg);
        break;

    case "unsubscribe":
        $to = $request['to'];
        $to = mysql_clean($to);
        $subscribe_to = $to;
        $userquery->unsubscribe_user($subscribe_to);

        $msg = [];
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
                    $msg['success'] = 'yes';
                }
            }
        }

        echo json_encode($msg);
        break;

    case "edit_video":
    case "editVideo":
        $vid = mysql_clean($request['videoid']);
        $Upload->validate_video_upload_form();
        if (empty($eh->get_error())) {
            $_POST = $request;
            $cbvid->update_video();

            $vdetails = $cbvid->get_video($vid);
            echo json_encode(['success' => 'yes', 'vdetails' => $vdetails]);
        } else {
            echo json_encode(['err' => error()]);
        }
        break;

    case 'addFriend':
    case 'add_friend':
        $uid = mysql_clean($request['userid']);
        $fid = mysql_clean($request['fid']);
        $message = mysql_clean($request['message']);

        if (!$uid) {
            $uid = user_id();
        }

        if (!$uid) {
            exit(json_encode(['err' => lang('Please Login')]));
        }
        if (!$fid) {
            exit(json_encode(['err' => lang('Please Select a User')]));
        }

        $params = ['userid' => $uid, 'friend_id' => $fid, 'message' => $message];

        $request_id = $userquery->add_friend_request($params);
        if ($request_id) {
            echo json_encode(['success' => 'yes', 'request_id' => $request_id]);
        } else {
            echo json_encode(['err' => lang(error('single'))]);
        }
        break;

    case 'removeFriend':
    case 'remove_friend':
    case 'unFriend':
    case 'unfriend':
        $uid = mysql_clean($request['userid']);
        $fid = mysql_clean($request['fid']);

        if (!$uid) {
            $uid = user_id();
        }

        if (!$uid) {
            exit(json_encode(['err' => lang('Please Login')]));
        }
        if (!$fid) {
            exit(json_encode(['err' => lang('Please Select a User')]));
        }
        if ($fid == $uid) {
            exit(json_encode(['err' => lang('Invalid User')]));
        }

        $response = $userquery->unfriend($fid, $uid);
        if ($response) {
            echo json_encode(['success' => 'yes', 'msg' => 'Removed from Friends']);
        } else {
            echo json_encode(['err' => lang(error('single'))]);
        }
        break;

    case "like_feed":
    case "addLike":
        $liked = mysql_clean($request['liked']);
        $feed_id = mysql_clean($request['feed_id']);

        $response = $cbfeeds->like_feed(['feed_id' => $feed_id, 'liked' => $liked]);
        if ($response) {
            echo json_encode(['success' => 'yes', 'msg' => 'Like/Unlike saved']);
        } else {
            echo json_encode(['err' => lang(error('single'))]);
        }
        break;

    default:
        exit(json_encode(['err' => lang('Invalid request')]));
}
