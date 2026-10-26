<?php
const THIS_PAGE = 'manage_thumb_collection';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('collection_moderation', true);
pages::getInstance()->page_redir();

$collection_id = (int)filter_var($_GET['collection'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$data = [];
if ($collection_id) {
    $data = Collection::getInstance()->getOne([
        'collection_id'         => $collection_id,
        'hide_empty_collection' => 'no'
    ]) ?: [];
}

$allowed_types = [
    'thumbs'    => 'thumbnail',
    'posters'   => 'poster',
    'backdrops' => 'backdrop'
];
$type = $_GET['type'] ?? '';
$translation_type = array_search($type, $allowed_types, true);
if (!$translation_type || !CollectionThumbs::isTypeAllowed($data, $type)) {
    http_response_code(403);
    e(lang('technical_error'));
    ClipBucket::getInstance()->show_page = false;
    display_it();
    die();
}

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('collections'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('collections'))), 'url' => DirPath::getUrl('admin_area') . 'collection_manager.php'];
$breadcrumb[2] = ['title' => 'Editing : ' . display_clean($data['collection_name']), 'url' => DirPath::getUrl('admin_area') . 'edit_collection.php?collection=' . $collection_id];
$breadcrumb[3] = ['title' => lang('manage_x', strtolower(lang($translation_type))), 'url' => DirPath::getUrl('admin_area') . 'manage_thumb_collection.php?collection=' . $collection_id . '&type=' . $type];

assign('type', $type);
assign('translation_type', $translation_type);


if (isset($_POST['upload_thumbs'])) {
    if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '999')) {
        e('Sorry, you cannot perform this action until the application has been fully updated by an administrator');
    } else {
        $files = $_FILES['collection_thumb'] ?? [];
        if (empty($files['name']) || !is_array($files['name'])) {
            e(lang('error_uploading_thumb'));
        } else {
            $uploaded = false;
            foreach ($files['name'] as $key => $name) {
                if (!is_uploaded_file($files['tmp_name'][$key] ?? '')) {
                    e(lang('error_uploading_thumb'));
                    continue;
                }
                $image_id = CollectionThumbs::importImage($data, [
                    'name'     => $name,
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key]
                ], $type);
                if ($image_id) {
                    $uploaded = true;
                }
            }
            if ($uploaded) {
                e(lang('collection_updated'), 'm');
            }
        }
    }
}

assign('data', $data);
assign('images', CollectionThumbs::getAll([
    'collection_id' => $collection_id,
    'type'          => $type
]));

ClipBucket::getInstance()->addAdminJS(['pages/manage_thumb_collection/manage_thumb_collection.js' => 'admin']);

subtitle(lang('manage_x', strtolower(lang($translation_type))));
template_files('manage_thumb_collection.html');
display_it();
