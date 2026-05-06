<?php
const THIS_PAGE = 'import_tmdb';
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

if (config('tmdb_enable_on_front_end') != 'yes' || config('enable_tmdb') != 'yes' || config('tmdb_token') == '') {
    return false;
}

Tmdb::getInstance()->importDataFromTmdb($_POST['videoid'] ?? 0, $_POST['tmdb_video_id'] ?? 0, $_POST['type']);

if (errorhandler::getInstance()->get_error()) {
    echo json_encode([
        'success' => false,
        'msg'     => getTemplateMsg()
    ]);
} else {
    $video = Video::getInstance()->getOne(['videoid' => $_POST['videoid']]);
    $return = [
        'success'      => true,
        'video_detail' => $video
    ];
    if ($_POST['from']== 'upload') {
        if ($video['status'] == 'Successful') {
            assign('data', $video);
            ob_start();
            show_player(['vdetails' => $video]);
            $return['player'] = ob_get_clean();
        }
        $return['id'] =  $video['videoid'];
        $return['html'] = Upload::displayVideoThumbsForm($video);
        $return['msg'] = lang('video_detail_saved');
    }
    echo json_encode($return);
}
