<?php
define('THIS_PAGE', 'upload');
define('PARENT_PAGE', 'upload');
require 'includes/config.inc.php';
global $eh;
Pages::getInstance()->page_redir();
userquery::getInstance()->logincheck('allow_video_upload', true);

subtitle('upload');

if (isset($_GET['collection'])) {
    $selected_collection = unserialize(base64_decode($_GET['collection']));
    assign('selected_collection', Collection::getInstance()->getOne(['collection_id'=>$selected_collection]));
}

if (empty(Upload::getInstance()->get_upload_options())) {
    e(lang('video_upload_disabled'));
    ClipBucket::getInstance()->show_page = false;
    display_it();
    die();
}

$step = 1;
if (isset($_POST['submit_data'])) {
    Upload::getInstance()->validate_video_upload_form();
    if (empty($eh->get_error())) {
        $step = 2;
    }
}

assign('step', $step);
assign('extensions', ClipBucket::getInstance()->get_extensions('video'));
assign('cancel_uploading', lang('cancel_uploading'));
assign('pourcent_completed', lang('pourcent_completed'));
subtitle(lang('upload'));

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/upload/upload' . $min_suffixe . '.js'               => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin',
    'plupload/js/moxie' . $min_suffixe . '.js'                 => 'admin',
    'plupload/js/plupload' . $min_suffixe . '.js'              => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);
$available_tags = Tags::fill_auto_complete_tags('video');
assign('available_tags', $available_tags);

$version = Update::getInstance()->getDBVersion();
if ($version['version'] > '5.5.0' || ($version['version'] == '5.5.0' && $version['revision'] >= 331)) {
    $default_category_id = Category::getInstance()->getDefaultByType('video')['category_id'];
} else {
    $default_category_id = 0;
}
assign('default_category_id', $default_category_id);

template_files('upload.html');
display_it();
