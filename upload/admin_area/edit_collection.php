<?php
const THIS_PAGE = 'edit_collection';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('collection_moderation', true);
pages::getInstance()->page_redir();

$id = $_GET['collection'];
if (isset($_POST['update_collection'])) {
    unset($_FILES['collection_thumb'], $_POST['collection_thumb']);
    Collections::getInstance()->update_collection();
}

//Performing Actions
if ($_GET['mode'] != '') {
    Collections::getInstance()->collection_actions($_GET['mode'], $id);
}

$collection = Collection::getInstance()->getOne([
    'collection_id'         => $id,
    'hide_empty_collection' => 'no',
    'with_items'            => true
]);
if (empty($collection)) {
    redirect_to(DirPath::getUrl('admin_area') . 'collection_manager.php?missing_collection=1');
}

$items = Collection::getInstance()->getItemRecursivly(['collection_id' => $collection['collection_id']]);
if ($collection['type'] == 'videos') {
    foreach ($items as &$item) {
        $item['id'] = $item['videoid'];
    }
} else {
    foreach ($items as &$item) {
        $item['id'] = $item['photo_id'];
    }
}
unset($item);

if (isset($_POST['update_collection'], $_POST['default_thumb']) && !error()) {
    try {
        $default_thumb = $_POST['default_thumb'];
        if (!is_string($default_thumb)) {
            throw new Exception(lang('technical_error'));
        }
        if (preg_match('/^custom_([1-9][0-9]*)$/', $default_thumb, $matches)) {
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '227')) {
                CollectionThumbs::setDefaultImage((int)$id, (int)$matches[1]);
            } else {
                e('Sorry, you cannot perform this action until the application has been fully updated by an administrator');
            }
        } elseif (ctype_digit($default_thumb) && in_array((int)$default_thumb, array_column($items, 'id'))) {
            Collection::getInstance()->setDefautThumb((int)$default_thumb, (int)$id);
        } else {
            throw new Exception(lang('technical_error'));
        }
    } catch (Exception $exception) {
        e($exception->getMessage());
    }
    $collection = Collection::getInstance()->getOne([
        'collection_id'         => $id,
        'hide_empty_collection' => 'no',
        'with_items'            => true
    ]);
}

if (CollectionThumbs::isTypeAllowed($collection, 'poster')) {
    if (isset($_POST['update_collection'], $_POST['default_poster']) && !error()) {
        try {
            $default_poster = filter_var($_POST['default_poster'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if (!$default_poster) {
                throw new Exception(lang('technical_error'));
            }
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '227')) {
                CollectionThumbs::setDefaultImage((int)$id, $default_poster, 'poster');
            } else {
                e('Sorry, you cannot perform this action until the application has been fully updated by an administrator');
            }
        } catch (Exception $exception) {
            e($exception->getMessage());
        }
    }
    $collection['default_poster'] = CollectionThumbs::getDefaultImageId((int)$id, 'poster');
    $posters = [];
    foreach (CollectionThumbs::getAll(['collection_id' => $id, 'type' => 'poster']) as $image) {
        $posters[] = [
            'thumb_id' => $image['id_collection_image'],
            'thumb'    => CollectionThumbs::getImageFile($image, 90)
        ];
    }
    assign('vidthumbs_poster', $posters);
}

if (CollectionThumbs::isTypeAllowed($collection, 'backdrop')) {
    if (isset($_POST['update_collection'], $_POST['default_backdrop']) && !error()) {
        try {
            $default_backdrop = filter_var($_POST['default_backdrop'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if (!$default_backdrop) {
                throw new Exception(lang('technical_error'));
            }
            if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '227')) {
                CollectionThumbs::setDefaultImage((int)$id, $default_backdrop, 'backdrop');
            } else {
                e('Sorry, you cannot perform this action until the application has been fully updated by an administrator');
            }
        } catch (Exception $exception) {
            e($exception->getMessage());
        }
    }
    $collection['default_backdrop'] = CollectionThumbs::getDefaultImageId((int)$id, 'backdrop');
    $backdrops = [];
    foreach (CollectionThumbs::getAll(['collection_id' => $id, 'type' => 'backdrop']) as $image) {
        $backdrops[] = [
            'thumb_id' => $image['id_collection_image'],
            'thumb'    => CollectionThumbs::getImageFile($image, 168)
        ];
    }
    assign('vidthumbs_backdrop', $backdrops);
}

$custom_thumbs = CollectionThumbs::getAll([
    'collection_id' => $collection['collection_id'],
    'type'          => 'thumbnail'
]);
if (empty($collection['thumb_objectid'])) {
    $collection['thumb_objectid'] = Collection::getDefaultThumb($collection['collection_id']);
}
assign('items', $items);
assign('custom_thumbs', $custom_thumbs);
assign('selected_image', CollectionThumbs::getDefaultImageId($collection['collection_id']));

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('collections'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('manage_x', strtolower(lang('collections'))),
    'url'   => DirPath::getUrl('admin_area') . 'collection_manager.php'
];
$breadcrumb[2] = [
    'title' => 'Editing : ' . display_clean($collection['collection_name']),
    'url'   => DirPath::getUrl('admin_area') . 'edit_collection.php?collection=' . display_clean($id)
];

assign('data', $collection);
assign('preview_collection', Collection::getInstance()->getOne([
    'collection_id'         => $collection['collection_id'],
    'hide_empty_collection' => 'no',
    'with_items'            => true,
    'with_sub_items'        => true,
    'count_items_only'      => true
]));
assign('collection_preview_template', SITETEMPLATEDIR . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . 'collection-item.html');
assign('collection_preview_theme', DirPath::getUrl('styles') . config('template_dir') . '/theme');
assign('link_user', DirPath::getUrl('admin_area') . 'view_user.php?uid=' . $collection['userid']);

$params = [];
$params['type'] = 'cl';
$params['type_id'] = $collection['collection_id'];
$params['order'] = ' comment_id DESC';
$comments = Comments::getAll($params);
assign('comments', $comments);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'tmdb' . $min_suffixe . '.js'                                  => 'global',
    'tag-it' . $min_suffixe . '.js'                                => 'admin',
    'pages/edit_collection/edit_collection' . $min_suffixe . '.js' => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js'     => 'admin'
]);

ClipBucket::getInstance()->addAdminCSS([
    'jquery.tagit' . $min_suffixe . '.css'                  => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css'              => 'admin'
]);

if (config('enable_visual_editor_comments') == 'yes') {
    ClipBucket::getInstance()->addAdminJS(['toastui/toastui-editor-all' . $min_suffixe . '.js' => 'libs']);
    ClipBucket::getInstance()->addAdminCSS(['/toastui/toastui-editor' . $min_suffixe . '.css' => 'libs']);
}

$available_tags = Tags::fill_auto_complete_tags('collection');
assign('available_tags', $available_tags);
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
assign('randon_number', rand(-5000, 5000));
subtitle('Edit Collection');
template_files('edit_collection.html');
display_it();
