<?php
const THIS_PAGE = 'progress';
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'SSE.class.php';
userquery::getInstance()->admin_login_check();

SSE::processSSE(function (){
    $data = get_video_details($_GET['id_video']);
     if (config('num_thumbs') > $data['duration']) {
         $max_thumb = (int)$data['duration'];
     } else {
         $max_thumb = config('num_thumbs');
     }
    $thumbs = display_thumb_list_regenerate($data);
    $results['is_max_thumb'] = $thumbs['nb_thumbs'] == $max_thumb;
    if ($results['is_max_thumb'] ) {
        e(lang('thumb_regen_end'), 'message');
    }
    $results['html'] = $thumbs['html']['template'];
    $results['msg'] = $thumbs['html']['msg'];
    $output = 'data: ' . json_encode($results);
    return['output'=> $output];
}, 2);
