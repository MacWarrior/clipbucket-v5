<?php

const THIS_PAGE = 'photo_display';

require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

$success = true;
$redirect = "";
try {

    if (!isSectionEnabled('photos') || !User::getInstance()->hasPermission('view_photos')) {
        throw new Exception(cblink(['name' => 'error_403']));
    }

    $current_photo = Photo::getInstance()->getOne([
        'photo_id' => empty($_POST['photo_id']) ? 0 : $_POST['photo_id']
    ]);

    if (empty($current_photo)) {
        sessionMessageHandler::add_message(lang('item_not_exist'), 'e');
        throw new Exception(DirPath::getUrl('root'));
    }

    //manage orphan photo access permission
    if (empty($current_photo['collection_id']) && !User::getInstance()->hasAdminAccess() && $current_photo['userid'] != User::getInstance()->getCurrentUserID()) {
        throw new Exception(DirPath::getUrl('root'));
    }

    $cid = $current_photo['collection_id'] ?? 0;
    $param = [
        'type'          => 'photos',
        'collection_id' => $cid
    ];
    $collection = Collection::getInstance()->getOne($param);

    if ((empty($collection) || !Collections::getInstance()->is_viewable($cid)) && !User::getInstance()->hasAdminAccess() && $current_photo['userid'] != user_id()) {
        ClipBucket::getInstance()->show_page = false;
        display_it();
        die();
    }

    //getting ci_id for collection item
    if (!empty($collection['collection_id'])) {
        $info = CBPhotos::getInstance()->collection->get_collection_item_fields($collection['collection_id'], $current_photo['photo_id'], 'ci_id');
        if (!empty($info)) {
            $current_photo = array_merge($current_photo, $info[0]);
        }
    }

    $link = Collections::getInstance()->get_next_prev_item($current_photo['ci_id'], $collection['collection_id'], $_POST['direction']); // getting Previous item

    if (Photo::getInstance()->isCurrentUserRestricted($current_photo['photo_id'])) {
        sessionMessageHandler::add_message(lang('error_age_restriction'), 'e');
        throw new Exception(DirPath::getUrl('root'));
    }

    ob_start();
    Photo::displayCollectionItem($link[0], $collection, !empty($_POST['fullscreen']));
    $html = ob_get_clean();
} catch (Exception $e) {
    $redirect = $e->getMessage();
    $success = false;
} finally {
    echo json_encode(['html' => $html ?? '', 'success' => $success, 'redirect' => $redirect, 'photo' => $link[0] ?? [], 'original_thumb' => PhotoThumbs::getThumbFile($link[0]['photo_id'] ?? 0, 'original')]);
}