<?php
const THIS_PAGE = 'photo_upload';
const PARENT_PAGE = 'upload';
require 'includes/config.inc.php';

User::getInstance()->hasPermissionOrRedirect('allow_photo_upload', true);
if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
    sessionMessageHandler::add_message('Sorry, you cannot upload new photos until the application has been fully updated by an administrator', 'e', User::getInstance()->getDefaultHomepageFromUserLevel());
}

subtitle(lang('photos_upload'));
if (isset($_GET['collection'])) {
    $selected_collection = CBPhotos::getInstance()->decode_key($_GET['collection']);
    assign('selected_collection', CBPhotos::getInstance()->collection->get_collection($selected_collection));
}

$collections = Collection::getInstance()->getAllIndent([
    'type'       => 'photos',
    'can_upload' => true,
], display_group: true);

assign('collections', $collections);
assign('reqFields', Collections::getInstance()->load_required_fields(['type'=>'photos']));
subtitle(lang('photos_upload'));

//Displaying The Template
if (!isSectionEnabled('photos')) {
    e('Photos are disabled');
    ClipBucket::getInstance()->show_page = false;
} else {
    if (config('enable_photo_file_upload') == 'no') {
        e('Photo upload is disabled');
        ClipBucket::getInstance()->show_page = false;
    }
}

$min_suffixe = System::isInDev() ? '' : '.min';
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
