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

        case 'comment':
            $comment = Comments::getAll(['comment_id' => $id]);
            if (!empty($comment)) {
                switch ($comment[0]['type']) {
                    default:
                        error_log('type : '.$type);
                    case 'v':
                        $permission = 'view_video';
                        break;
                    case 'p':
                        $permission = 'view_photos';
                        break;
                    case 'cl':
                        $permission = 'view_collections';
                        break;
                    case Comments::$libelle_type_channel:
                        $permission = 'view_channel';
                        break;
                }
                User::getInstance()->hasPermissionAjax($permission);
                Comments::ratingUpdate($id, $rating);
            }
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
