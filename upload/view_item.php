<?php
const THIS_PAGE = 'view_item';
const PARENT_PAGE = 'collections';

require 'includes/config.inc.php';

if( !isSectionEnabled('photos') || !User::getInstance()->hasPermission('view_photos') ){
    redirect_to(cblink(['name' => 'error_403']));
}

$item = (string)$_GET['item'];
if( empty($item) ){
    sessionMessageHandler::add_message(lang('item_not_exist'), 'e', DirPath::getUrl('root'));
}

$photo = Photo::getInstance()->getOne([
    'photo_key' => $item
]);

if( empty($photo) ){
    sessionMessageHandler::add_message(lang('item_not_exist'), 'e', DirPath::getUrl('root'));
}

if( empty($photo['collection_id']) && !User::getInstance()->hasAdminAccess() && $photo['userid'] != User::getInstance()->getCurrentUserID() ){
    redirect_to(DirPath::getUrl('root'));
}

$cid = $photo['collection_id'] ?? 0;
$param = [
    'type'          => 'photos',
    'collection_id' => $cid
];
$collect = Collection::getInstance()->getOne($param);

if( (empty($collect) || !Collections::getInstance()->is_viewable($cid)) && !User::getInstance()->hasAdminAccess() && $photo['userid'] != user_id() ){
    ClipBucket::getInstance()->show_page = false;
    display_it();
    die();
}

if( Photo::getInstance()->isCurrentUserRestricted($photo['photo_id']) ){
    sessionMessageHandler::add_message(lang('error_age_restriction'), 'e', DirPath::getUrl('root'));
}

// Top collections
$params = [
    'limit'        => 5,
    'type'         => 'photos',
    'parents_only' => true
];
$top_collections = Collection::getInstance()->getAll($params);
assign('top_collections', $top_collections);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                              => 'admin',
    'photos' . $min_suffixe . '.js'                              => 'admin',
    'init_readonly_tag/init_readonly_tag' . $min_suffixe . '.js' => 'admin'
]);

if( config('enable_comments_photo') == 'yes' ){
    ClipBucket::getInstance()->addJS([
        'pages/add_comment/add_comment' . $min_suffixe . '.js'  => 'admin'
    ]);
    Comments::initVisualComments();
}

ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin',
    'readonly_tag' . $min_suffixe . '.css'     => 'admin'
]);

Photo::displayCollectionItem( $photo, $collect,ajax: false);