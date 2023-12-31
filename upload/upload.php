<?php
define('THIS_PAGE', 'upload');
define('PARENT_PAGE', 'upload');
require 'includes/config.inc.php';
global $pages, $Upload, $eh, $userquery;
$pages->page_redir();
$userquery->logincheck('allow_video_upload', true);

subtitle('upload');

if (empty($Upload->get_upload_options())) {
    e(lang('video_upload_disabled'));
    ClipBucket::getInstance()->show_page = false;
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

assign('step', $step);
assign('extensions', ClipBucket::getInstance()->get_extensions('video'));
subtitle(lang('upload'));

if (in_dev()) {
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/upload/upload' . $min_suffixe . '.js'               => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('video');
assign('available_tags',$available_tags);

template_files('upload.html');
display_it();
