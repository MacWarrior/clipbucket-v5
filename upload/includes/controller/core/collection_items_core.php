<?php

$response['success'] = true;
User::getInstance()->hasPermissionAjax('collection_moderation');
$collection_id = (int)$_POST['collection_id'];
$collection = $collection_id ? Collection::getInstance()->getOne([
    'collection_id'         => $collection_id,
    'hide_empty_collection' => 'no'
]) : false;
if (!$collection) {
    e(lang('collection_not_exist'));
    $response['success'] = false;
}
$type = $collection['type'];
if (!Collection::getInstance()->isValidType($type)) {
    e(lang('unknown_type'));
    $response['success'] = false;
}
if ($response['success']) {
    User::getInstance()->hasPermissionAjax('view_' . $type);
    $object = $type == 'videos' ? Video::getInstance() : Photo::getInstance();
    $id_field = $type == 'videos' ? 'videoid' : 'photo_id';
    $action = $_POST['action'] ?? 'search';
    if ($action == 'add') {
        foreach (array_unique($_POST['ids']) as $id) {
            $id = (int)$id;
            if (!$object->getOne([$id_field => $id])) {
                e(lang('obj_not_exists', lang($type)));
                continue;
            }
            if (Collection::getInstance()->collectionHasItem($collection_id, $id, $type) ||
                Collection::getInstance()->addCollectionItem($id, $collection_id, $type)) {
                $added[] = $id;
            }
        }
        $added = [];
    } elseif ($action == 'search') {
        $page = max(1, (int)($_POST['page'] ?? 1));
        $limit = max(1, $object->getSearchLimit());
        $params = ['search' => trim($_POST['query'] ?? '')];
        $params['limit'] = create_query_limit($page, $limit);
        $results = $object->getAll($params);
        unset($params['limit']);
        $params['count'] = true;
        $total = $object->getAll($params);
        $existing = array_column(Collection::getInstance()->getItems(['collection_id' => $collection_id]) ?: [], $id_field);
        $items = [];
        foreach ($results as $result) {
            $id = (int)$result[$id_field];
            $items[] = [
                'id'          => $id,
                'title'       => display_clean($type == 'videos' ? $result['title'] : $result['photo_title']),
                'description' => display_clean($type == 'videos' ? $result['description'] : $result['photo_description']),
                'date'        => $result['date_added'],
                'thumb'       => Collection::getInstance()->getItemThumb($result, $type),
                'blur'        => $object->isToBlur($id),
                'exists'      => in_array($id, $existing)
            ];
        }

        assign('items', $items);
        $response['template'] = getTemplate('blocks/collection_items_results.html');
    }
}
echo json_encode([
    'success' => $response['success'],
    'html'    => $response['template'],
    'msg'     => getTemplateMsg(),
    'page'    => $page ?? 0,
    'pages'   => (int)count_pages($total, $limit)
]);
exit();