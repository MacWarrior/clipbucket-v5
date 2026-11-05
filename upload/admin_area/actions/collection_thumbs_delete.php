<?php
const THIS_PAGE = 'delete_collection_thumbs';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('collection_moderation');

if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
    e('Sorry, you cannot perform this action until the application has been fully updated by an administrator');
    echo json_encode(['success' => false, 'msg' => getTemplateMsg()]);
    die();
}

try {
    $collection_id = (int)filter_var($_POST['collection_id'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $id_collection_image = (int)filter_var($_POST['id_collection_image'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $type = $_POST['type'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$collection_id || !$id_collection_image || !is_string($type)) {
        throw new Exception(lang('technical_error'));
    }
    $data = Collection::getInstance()->getOne([
        'collection_id'         => $collection_id,
        'hide_empty_collection' => 'no'
    ]) ?: [];
    if (!CollectionThumbs::isTypeAllowed($data, $type)) {
        throw new Exception(lang('technical_error'));
    }
    $image = CollectionThumbs::getOne([
        'collection_id'       => $collection_id,
        'id_collection_image' => $id_collection_image,
        'type'                => $type
    ]);
    if (empty($image)) {
        throw new Exception(lang('technical_error'));
    }
    CollectionThumbs::deleteCollectionImage($image);

    assign('data', $data);
    assign('type', $type);
    assign('images', CollectionThumbs::getAll([
        'collection_id' => $collection_id,
        'type'          => $type
    ]));
    e(lang('collection_updated'), 'm');
    $response = templateWithMsgJson('blocks/collection_thumb_list.html', false);
    $response['success'] = true;
    echo json_encode($response);
} catch (Exception $exception) {
    e($exception->getMessage());
    echo json_encode(['success' => false, 'msg' => getTemplateMsg()]);
}
