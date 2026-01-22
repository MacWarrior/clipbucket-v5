<?php

const THIS_PAGE = 'rating_update';
include('../includes/config.inc.php');

$success = true;
try {
    if (!User::getInstance()->isUserConnected()) {
        throw new Exception(lang('please_login'));
    }
    if (empty($_POST['type']) || empty($_POST['id']) || empty($_POST['rating'])) {
        throw new Exception(lang('missing_params'));
    }
    $rating = mysql_clean($_POST['rating']) * 2;
    if (!is_numeric($rating) || $rating <= 9) {
        $rating = 0;
    }
    $type = strtolower($_POST['type']);
    $id = $_POST['id'];
    switch ($type) {
        case 'v':
        case 'video':
        default:
            User::getInstance()->hasPermissionAjax('view_video');
            Video::ratingUpdate($id, $rating);
            break;

        case 'p':
        case 'photo':
            User::getInstance()->hasPermissionAjax('view_photos');
            Photo::ratingUpdate($id, $rating);
            break;

        case 'cl':
        case 'collection':
            User::getInstance()->hasPermissionAjax('view_collections');
            Collection::ratingUpdate($id, $rating);
            break;

        case 'user':
            User::getInstance()->hasPermissionAjax('view_channel');
            User::ratingUpdate($id, $rating);
            break;
    }
    update_user_voted([
        'object_id' => $id,
        'type'      => $type,
        'time'      => now(),
        'rating'    => $rating,
        'userid'    => User::getInstance()->getCurrentUserID(),
        'username'  => User::getInstance()->get('username')
    ]);
    e(lang('thnx_for_voting'), 'm');

} catch (Exception $e) {
    e($e->getMessage());
    $success = false;
} finally {
    echo json_encode(['msg' => getTemplateMsg(), 'success' => $success]);
}
