<?php
define('THIS_PAGE', 'reindex_cb');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $cbindex;

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => 'ReIndexer', 'url' => DirPath::getUrl('admin_area') . 'reindex_cb.php'];

$vtbl = tbl('video');
$utbl = tbl('users');
$gtbl = tbl('groups');

$start_index = $_GET['start_index'] ? $_GET['start_index'] : 0;
$loop_size = $_GET['loop_size'];
$loop_size = $loop_size ? $loop_size : 5;
assign('loop_size', $loop_size);
$next_index = $start_index + $loop_size;
assign('next_index', $next_index);

//Reindex Videos
if (isset($_GET['index_vids'])) {
    $videos = get_videos(['active' => 'yes', 'status' => 'Successful', 'limit' => $start_index . ',' . $loop_size]);
    $total_videos = get_videos(['count_only' => true, 'active' => 'yes', 'status' => 'Successful']);
    $percent = number_format(50 * $total_videos / 100);
    $i = 0;

    assign('total', $total_videos);
    assign('from', $start_index + 1);
    $to = $start_index + $loop_size;
    if ($to > $total_videos) {
        $to = $total_videos;
        e($total_videos . ' videos have been reindexed successfully.', 'm');
        assign('stop_loop', 'yes');
    }
    assign('to', $to);

    while ($i < $total_videos) {
        if ($videos[$i]['videoid']) {
            $params = ['video_id' => $videos[$i]['videoid'], 'video_comments' => true, 'favs_count' => true, 'playlist_count' => true];
            $indexes = $cbindex->count_index('vid', $params);
            $fields = $cbindex->extract_fields('vid', $params);
            $msg[] = $videos[$i]['video'] . ': Updating <strong><em>' . $videos[$i]['title'] . '</em></strong>';
            $cbindex->update_index('vid', ['fields' => $fields, 'values' => $indexes, 'video_id' => $videos[$i]['videoid']]);
        }
        $i++;
    }
    e($start_index + 1 . ' - ' . $to . '  videos have been reindexed successfully.', 'm');
    assign('index_msgs', $msg);
    assign('indexing', 'yes');
    assign('mode', 'index_vids');
}

//Reindex Users
if (isset($_GET['index_usrs'])) {
    $msg = [];
    $users = get_users(['usr_status' => 'Ok', 'limit' => $start_index . ',' . $loop_size]);

    $total_users = get_users(['count_only' => true, 'usr_status' => 'Ok']);
    $percent = $cbindex->percent(50, $total_users);
    $i = 0;

    assign('total', $total_users);
    assign('from', $start_index + 1);
    $to = $start_index + $loop_size;
    if ($to > $total_users) {
        $to = $total_users;
        e($total_users . ' users have been reindexed successfully.', 'm');
        assign('stop_loop', 'yes');
    }
    assign('to', $to);

    while ($i < $total_users) {
        if ($users[$i]['userid']) {
            $params = ['user'        => $users[$i]['userid'], 'comment_added' => true, 'subscriptions_count' => true, 'subscribers_count' => true,
                       'video_count' => true, 'groups_count' => true, 'collections_count' => true, 'photos_count' => true];
            $indexes = $cbindex->count_index('user', $params);
            $fields = $cbindex->extract_fields('user', $params);
            $msg[] = $users[$i]['userid'] . ': Updating <strong><em>' . $users[$i]['username'] . '</em></strong>';
            $cbindex->update_index('user', ['fields' => $fields, 'values' => $indexes, 'user' => $users[$i]['userid']]);
        }
        $i++;
    }
    e($start_index + 1 . ' - ' . $to . ' users have been reindexed successfully.', 'm');
    assign('index_msgs', $msg);
    assign('indexing', 'yes');
    assign('mode', 'index_usrs');
}

if (isset($_GET['index_photos'])) {
    $photos = get_photos(['active' => 'yes', 'limit' => $start_index . ',' . $loop_size]);
    $total_photos = get_photos(['count_only' => true, 'active' => 'yes']);
    $percent = $cbindex->percent(50, $total_photos);
    $i = 0;

    assign('total', $total_photos);
    assign('from', $start_index + 1);
    $to = $start_index + $loop_size;
    if ($to > $total_photos) {
        $to = $total_photos;
        e($total_photos . ' photos have been reindexed successfully.', 'm');
        assign('stop_loop', 'yes');
    }
    assign('to', $to);

    while ($i < $total_photos) {
        if ($photos[$i]['photo_id']) {
            $params = ['photo_id' => $photos[$i]['photo_id'], 'favorite_count' => true, 'total_comments' => true];
            $indexes = $cbindex->count_index('photos', $params);
            $fields = $cbindex->extract_fields('photos', $params);
            $msg[] = $photos[$i]['photo_id'] . ': Updating <strong><em>' . $photos[$i]['photo_title'] . '</em></strong>';
            $cbindex->update_index('photos', ['fields' => $fields, 'values' => $indexes, 'photo_id' => $photos[$i]['photo_id']]);
        }
        $i++;
    }

    e($start_index + 1 . ' - ' . $to . ' photos have been reindexed successfully.', 'm');
    assign('index_msgs', $msg);
    assign('indexing', 'yes');
    assign('mode', 'index_photos');
}

if (isset($_GET['index_collections'])) {
    $collections = get_collections(['active' => 'yes', 'limit' => $start_index . ',' . $loop_size]);
    $total_collections = get_collections(['count_only' => true, 'active' => 'yes']);
    $percent = $cbindex->percent(50, $total_collections);
    $i = 0;

    assign('total', $total_collections);
    assign('from', $start_index + 1);
    $to = $start_index + $loop_size;
    if ($to > $total_collections) {
        $to = $total_collections;
        e($total_collections . ' collections have been reindexed successfully.', 'm');
        assign('stop_loop', 'yes');
    }
    assign('to', $to);

    while ($i < $total_collections) {
        if ($collections[$i]['collection_id']) {
            $params = ['collection_id' => $collections[$i]['collection_id'], 'total_items' => true, 'total_comments' => true];
            $indexes = $cbindex->count_index('collections', $params);
            $fields = $cbindex->extract_fields('collections', $params);
            $msg[] = $collections[$i]['collection_id'] . ': Updating <strong><em>' . $collections[$i]['collection_name'] . '</em></strong>';
            $cbindex->update_index('collections', ['fields' => $fields, 'values' => $indexes, 'photo_id' => $collections[$i]['collection_id']]);
        }
        $i++;
    }

    e($start_index + 1 . ' - ' . $to . ' collections have been reindexed successfully.', 'm');
    assign('index_msgs', $msg);
    assign('indexing', 'yes');
    assign('mode', 'index_collections');
}

subtitle('Re-index Clipbucket');
template_files('reindex_cb.html');
display_it();
