<?php
define('THIS_PAGE', 'photo_upload');
define('PARENT_PAGE', 'upload');

global $cbphoto, $Cbucket, $cbcollection;

require 'includes/config.inc.php';
userquery::getInstance()->logincheck();
subtitle(lang('photos_upload'));
if (isset($_GET['collection'])) {
    $selected_collection = $cbphoto->decode_key($_GET['collection']);
    assign('selected_collection', $cbphoto->collection->get_collection($selected_collection));
}

userquery::getInstance()->logincheck('allow_photo_upload', true);

$collections = Collection::getInstance()->getAllIndent([
    'type'   => 'photos',
    'userid' => user_id()
]);

assign('collections', $collections);
assign('reqFields', $cbcollection->load_required_fields(['type'=>'photos']));
subtitle(lang('photos_upload'));

//Displaying The Template
if (!isSectionEnabled('photos')) {
    e('Photos are disabled');
    $Cbucket->show_page = false;
} else {
    if (config('enable_photo_file_upload') == 'no') {
        e('Photo upload is disabled');
        $Cbucket->show_page = false;
    }
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                            => 'admin',
    'pages/photo_upload/photo_upload' . $min_suffixe . '.js'   => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js' => 'admin',
    'plupload/js/moxie' . $min_suffixe . '.js'                 => 'admin',
    'plupload/js/plupload' . $min_suffixe . '.js'              => 'admin'
]);

ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);

$available_tags = Tags::fill_auto_complete_tags('photo');
assign('available_tags', $available_tags);

$available_collection_tags = Tags::fill_auto_complete_tags('collection');
assign('available_collection_tags', $available_collection_tags);

template_files('photo_upload.html');
display_it();
