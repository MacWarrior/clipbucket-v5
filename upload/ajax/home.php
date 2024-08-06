<?php
define('THIS_PAGE', 'ajax');
require '../includes/config.inc.php';
$params = [];
if (isset($_POST['load_type'])) {
    $load_type = $_POST['load_type'];
    if (isset($_POST['load_mode'])) {
        $load_mode = $_POST['load_mode'];
        if ($load_mode == 'featured') {
            $params['featured'] = "yes";
            $params['order'] = 'featured_date DESC';
        } else {
            if ($load_mode == 'recent') {
                $params['order'] = 'date_added DESC';
            } else {
                $params['order'] = 'views';
            }
        }
    }

    if (isset($_POST['current_displayed'])) {
        $start = $_POST['current_displayed'];
    } else {
        $start = '0';
    }

    if (isset($_POST['wanted'])) {
        $end = $_POST['wanted'];
    } else {
        $end = '6';
    }

    $params['limit'] = "$start,$end";

    if (isset($_POST['first_launch']) && $_POST['first_launch'] = 'true') {
        $params['count_only'] = true;
        $total_vids = get_videos($params);
        assign("total_vids", $total_vids);
    } else {
        assign("total_vids", '');
    }

    switch ($load_type) {
        case 'video':
            $params['count_only'] = false;
            $data = Video::getInstance()->getAll($params);
            break;
        case 'users':
            $data = get_users($params);
            break;
        case 'photos':
            $data = get_photos($params);
            break;
        case 'collections':
            $data = get_collections($params);
            break;

        default:
            $data = Video::getInstance()->getAll($params);
            break;
    }

    if (!empty($data)) {
        $json_string['array_meta'] = $data;
        if ($load_mode == 'recent') {
            $display_type = 'ajaxHome';
        } else {
            $display_type = 'featuredHome';
        }
        $quicklists = $_COOKIE['fast_qlist'];
        $clean_cookies = str_replace(["[", "]"], "", $quicklists);
        $clean_cookies = explode(",", $clean_cookies);
        $clean_cookies = array_filter($clean_cookies);
        $anonymous_id = userquery::getInstance()->get_anonymous_user();
        assign('anonymous_id', $anonymous_id);
        assign("qlist_vids", $clean_cookies);
        foreach ($data as $key => $video) {
            assign("video", $video);
            assign("display_type", $display_type);
            Template('blocks/videos/video.html');
        }
    } else {
        $msg = [];
        $msg['notice'] = "You've reached end of list";
        echo json_encode($msg);
    }

} else {
    $msg = [];
    $msg['error'] = "Invalid request made";
    echo json_encode($msg);
}
