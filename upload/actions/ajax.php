<?php
const THIS_PAGE = 'ajax';
CONST IS_AJAX = true;
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

            if (empty($limit) || empty($total)) {
                e(lang('missing_params'));
                echo json_encode(getTemplateMsg());
                break;
            }
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
            if (empty($_POST['type']) || empty($_POST['rating']) || empty($_POST['id'])) {
                e(lang('missing_params'));
                echo (getTemplateMsg());
                break;
            }
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

            if (empty($_POST['type']) || empty($_POST['id'])) {
                e(lang('missing_params'));
                echo json_encode(getTemplateMsg());
                break;
            }
            $type = strtolower($_POST['type']);
            switch ($type) {
                case 'v':
                case 'video':
                default:
                    if (config('enable_video_internal_sharing') != 'yes' ) {
                        e(lang('technical_error'));
                        echo json_encode(getTemplateMsg());
                        break;
                    }
                    $id = mysql_clean($_POST['id']);
                    $vdo = CBvideo::getInstance()->get_video($id);
                    CBvideo::getInstance()->set_share_email($vdo);
                    CBvideo::getInstance()->action->share_content($vdo['videoid']);
                    break;

                case 'p':
                case 'photo':
                    if (config('enable_video_internal_sharing') != 'yes' ) {
                        e(lang('technical_error'));
                        echo json_encode(getTemplateMsg());
                        break;
                    }
                    $ph = CBPhotos::getInstance()->get_photo($_POST['id']);
                    CBPhotos::getInstance()->set_share_email($ph);
                    CBPhotos::getInstance()->action->share_content($ph['photo_id']);
                    break;

                case 'cl':
                case 'collection':
                    if (config('enable_collection_internal_sharing') != 'yes' ) {
                        e(lang('technical_error'));
                        echo json_encode(getTemplateMsg());
                        break;
                    }
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
            if (!User::getInstance()->isUserConnected()) {
                e(lang('please_login'));
            }elseif (empty($_POST['type']) || empty($_POST['id'])) {
                e(lang('missing_params'));
            } else {

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
            if (!User::getInstance()->isUserConnected()) {
                e(lang('please_login_to_flag'));
            } elseif (empty($_POST['flag_type'])) {
                e(lang('missing_category_report'));
            } else {
                //get flag reports
                if (!empty(Flag::getOne(['flag_id' => user_id(), 'element_type' => $type, 'id_element' => $id, 'id_flag_type' => $_POST['flag_type']]))) {
                    e(lang('obj_report_err',strtolower(lang($type))));
                } elseif (Flag::flagItem($id, $type, $_POST['flag_type'])) {
                    e(lang('report_successful'), 'm');
                } else {
                    e(lang('report_failed'));
                }
            }

            if (errorhandler::getInstance()->get_error()) {
                echo '<div class="error">' . errorhandler::getInstance()->get_error()[0]['val'] . '</div>';
            } else {
                if (errorhandler::getInstance()->get_warning()) {
                    echo '<div class="warning">' . errorhandler::getInstance()->get_warning()[0]['val'] . '</div>';
                } else {
                    if (errorhandler::getInstance()->get_message()) {
                        echo '<div class="msg">' . errorhandler::getInstance()->get_message()[0]['val'] . '</div>';
                    }
                }
            }
            break;

        case 'subscribe_user':

            if (!User::getInstance()->isUserConnected()) {
                e(lang('please_login'));
            } else if (empty($_POST['subscribe_to']) ) {
                e(lang('missing_params'));
            } else {
                $subscribe_to = mysql_clean($_POST['subscribe_to']);
                $mailId = userquery::getInstance()->get_user_details($subscribe_to, false, true);
                userquery::getInstance()->subscribe_user($subscribe_to);
            }

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
            if (!User::getInstance()->isUserConnected()) {
                e(lang('please_login'));
            } else if (empty($_POST['subscribe_to']) ) {
                e(lang('missing_params'));
            } else {
                $subscribe_to = mysql_clean($_POST['subscribe_to']);
                userquery::getInstance()->unsubscribe_user($subscribe_to);
            }
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
            if (!User::getInstance()->isUserConnected()) {
                e(lang('please_login'));
                echo json_encode(['msg'=>getTemplateMsg()]);
                break;
            } elseif (empty($_POST['userid']) ) {
                e(lang('missing_params'));
                echo json_encode(['msg'=>getTemplateMsg()]);
                break;
            }
            $userid = $_POST['userid'];
            $sub_count = userquery::getInstance()->get_user_subscribers($userid, true);
            echo json_encode(['subscriber_count' => $sub_count]);
            break;

        case 'ban_user':
            //params checked in the function
           if (empty($_POST['user']) ) {
                e(lang('missing_params'));
            } else {
                $user = $_POST['user'];
                userquery::getInstance()->ban_user($user);
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

        case 'spam_comment':
            //params checked in the function
            if (empty($_POST['cid'])) {
                e(lang('missing_params'));
            } else {
                $rating = Comments::setSpam($_POST['cid']);
            }
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

            echo json_encode($ajax);
            break;

        case 'add_comment';
            //params checked in the function
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
            } else {
                if ($_POST['type'] != 't') {
                    update_last_commented($type, $id);
                }
            }

            //Getting Comment
            if ($comment_id) {
                $ajax['cid'] = $comment_id;
                $ajax['type_id'] = $id;
            }

            echo json_encode($ajax);
            break;

        case 'get_comment';
            if (empty($_POST['cid']) || empty($_POST['type_id']) ) {
                e(lang('missing_params'));
                echo json_encode(['msg'=>getTemplateMsg()]);
                break;
            }
            $id = mysql_clean($_POST['cid']);
            $type_id = mysql_clean($_POST['type_id']);

            $params = [];
            $params['comment_id'] = $id;
            $params['first_only'] = true;
            $new_com = Comments::getAll($params);
            if ($new_com['type'] == 'v' && config('enable_comments_video') != 'yes') {
                return false;
            }
            if ($new_com['type'] == 'p' && config('enable_comments_photo') != 'yes') {
                return false;
            }
            if ($new_com['type'] == 'channel' && config('enable_comments_channel') != 'yes') {
                return false;
            }
            if ($new_com['type'] == 'cl' && config('enable_comments_collection') != 'yes') {
                return false;
            }
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
            //params checked in the function
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
            //params checked in the function
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
                ob_start();
                show_playlist_form(['user'=> User::getInstance()->getCurrentUserID(), 'type'=>'video', 'id'=>$vid]);
                $ajax['html']= ob_get_clean();
                $ajax['msg'] = $msg ?: '';
                $ajax['err'] = $err ?: '';

                echo json_encode($ajax);
            }
            break;

        case 'delete_comment':
            //connexion checked in the function
            if (empty($_POST['cid']) ) {
                e(lang('missing_params'));
                $nb_affected = 0;
            } else {
                $nb_affected = Comments::delete(['comment_id' => $_POST['cid']]);
            }
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
            if (empty($_POST['obj_id']) || empty($_POST['cid']) || empty($_POST['type']) ) {
                e(lang('missing_params'));
            } else {
                Collection::removeItemFromCollection($cid, $obj_id, $type);
                if ($type == 'photos') {
                    CBPhotos::getInstance()->make_photo_orphan($cid, $obj_id);
                }
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

        case "more_items":
            if (empty($_POST['type']) || empty($_POST['cid']) ) {
                e(lang('missing_params'));
                echo json_encode(["error" => true, 'msg'=>getTemplateMsg()]);
                break;
            }
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
                    User::getInstance()->hasPermissionAjax('view_video');
                    $items = CBvideo::getInstance()->collection->get_collection_items_with_details($cid, $order, $limit);
                    break;

                case "photos":
                case "photo":
                case "p":
                    User::getInstance()->hasPermissionAjax('view_photo');
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
            if (empty($_POST['collection_name']) || empty($_POST['collection_description']) || empty($_POST['category']) ) {
                e(lang('missing_params'));
                $insert_id = 0;
            } else {
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
            }
            $response = templateWithMsgJson('blocks/collection_select_upload.html', false);
            //empty $_POST to prevent bad value in photo form
            unset($_POST);
            $response['photoForm'] = getTemplate('blocks/upload/photo_form.html');
            $response['success'] = (bool)$insert_id;
            echo json_encode($response);
            break;

        case "viewPhotoRating":
            if (empty($_POST['photoid']) ) {
                e(lang('missing_params'));
                echo getTemplateMsg();
                break;
            }
            if (!User::getInstance()->isUserConnected()) {
                e(lang('please_login'));
                echo getTemplateMsg();
                break;
            }
            $pid = mysql_clean($_POST['photoid']);
            $returnedArray = CBPhotos::getInstance()->photo_voters($pid);
            echo $returnedArray;
            break;

        /**
         * Getting comments along with template
         */
        case 'getComments':
            $limit = config('comment_per_page') ? config('comment_per_page') : 10;
            $page = $_POST['page'];
            if (empty($_POST['type']) || empty($_POST['type_id']) ) {
                e(lang('missing_params'));
                echo getTemplateMsg();
                break;
            }
            $params = [];
            $params['type'] = $_POST['type'];
            $params['type_id'] = $_POST['type_id'];
            $params['limit'] = create_query_limit($page, $limit);
            $params['hierarchy'] = true;

            if ($_POST['type'] == 'v' && (config('enable_comments_video') != 'yes' || !User::getInstance()->hasPermission('view_video'))) {
                e(lang('insufficient_privileges'));
                echo getTemplateMsg();
                break;
            } elseif ($_POST['type'] == 'p' && (config('enable_comments_photo') != 'yes' || !User::getInstance()->hasPermission('view_photos'))) {
                e(lang('insufficient_privileges'));
                echo getTemplateMsg();
                break;
            } elseif ($_POST['type'] == 'channel' && (config('enable_comments_channel') != 'yes' || !User::getInstance()->hasPermission('view_channel'))) {
                e(lang('insufficient_privileges'));
                echo getTemplateMsg();
                break;
            } elseif ($_POST['type'] == 'cl' && (config('enable_comments_collection') != 'yes' || !User::getInstance()->hasPermission('view_collections'))) {
                e(lang('insufficient_privileges'));
                echo getTemplateMsg();
                break;
            } else {
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
                onClick="_cb.getAllComments(\'' . display_clean($_POST['type']) . '\',\'' . display_clean($_POST['type_id']) . '\',\'' . display_clean($_POST['last_update']) . '\',
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
            }
            break;

        case 'photo_ajax':
            try {
                if (!User::getInstance()->hasPermission('view_photo')) {
                    throw new Exception(lang('insufficient_privileges'));
                }
                if (!empty($_POST['photo_pre']) && !empty($_POST['item'])) {
                    $photo = $_POST['photo_pre'];
                    $items = $_POST['item'];
                    $ci_id = $photo['ci_id'];
                    $collection = $photo['collection_id'];    // collection id.
                    $link = Collections::getInstance()->get_next_prev_item($ci_id, $collection, $items, $limit = 1, $check_only = false); // getting Previous item
                    $srcString = '/files/photos/' . $link[0]['file_directory'] . '/' . $link[0]['filename'] . '.' . $link[0]['ext']; // Image Source...
                    $response['photo'] = $link;
                    $response['photo_key'] = $link[0]['photo_key'];
                    $response['src_string'] = $srcString; // Image source.
                    $response['collection_id'] = $collection;
                    echo json_encode($response);
                } else {
                    throw new Exception(lang('missing_params'));
                }
            } catch (Exception $e) {
                $response["error_ex"] = true;
                $response["msg"] = 'Message: ' . $e->getMessage();
                echo(json_encode($response));
            }
            break;

        case 'user_suggest':
            if (!User::getInstance()->hasPermission('private_msg_access')) {
                return 'none';
            }
            if (empty($_POST['typed'])) {
                return 'none';
            }
            $typed = mysql_clean($_POST['typed']);
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

