<?php
define('THIS_PAGE', 'upload');
define('PARENT_PAGE', 'upload');
require 'includes/config.inc.php';
global $pages, $Upload, $eh, $userquery, $Cbucket;
$pages->page_redir();
$userquery->logincheck('allow_video_upload', true);

subtitle('upload');

if( empty($Upload->get_upload_options()) ) {
    e('Video upload is disabled');
    $Cbucket->show_page = false;
    display_it();
    die();
}

$step = 1;
if (isset($_POST['submit_data'])) {
    $Upload->validate_video_upload_form();
    if (empty($eh->get_error())) {
        $step = 2;
    }
}

//Adding Uploading JS Files
add_js(['swfupload/swfupload.js' => 'uploadactive']);
add_js(['swfupload/plugins/swfupload.queue.js' => 'uploadactive']);
add_js(['swfupload/plugins/handlers.js' => 'uploadactive']);
add_js(['swfupload/plugins/fileprogress.js' => 'uploadactive']);

assign('step', $step);
assign('extensions', $Cbucket->get_extensions('video'));
subtitle(lang('upload'));

template_files('upload.html');
display_it();
