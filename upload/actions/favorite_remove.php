<?php
const THIS_PAGE = 'favorite_add';
include('../includes/config.inc.php');

User::getInstance()->hasPermissionAjax('view_video');

$success = true;
try {
    if (!User::getInstance()->isUserConnected()) {
        throw new Exception(lang('please_login'));
    }
    if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.2', '999')) {
        throw new Exception(lang('cant_perform_action_until_app_fully_updated'));
    }
    if (empty($_POST['type']) || empty($_POST['id'])) {
        throw new Exception(lang('missing_params'));
    }
    $type = strtolower($_POST['type']);
    $id = $_POST['id'];
    switch ($type) {
        case 'v':
        case 'video':
        default:
            $success = Video::getInstance()->removeFromFavorites($id);
            updateObjectStats('fav', 'video', $id, '-'); // Increment in total favs
            $funcs = cb_get_functions('favorite_video');
            break;

        case 'p':
        case 'photo':
            $success = Photo::getInstance()->removeFromFavorites($id);
            updateObjectStats('fav', 'photo', $id, '-'); // Increment in total favs
            $funcs = cb_get_functions('favorite_photo');
            break;

        case 'cl':
        case 'collection':
            $success = Collection::getInstance()->removeFromFavorites($id);
            $funcs = cb_get_functions('favorite_collection');
            break;
    }
} catch (Exception $e) {
    e($e->getMessage());
    $success = false;
} finally {
    echo json_encode(['msg' => getTemplateMsg(), 'success' => $success]);
}
