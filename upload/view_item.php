<?php
define('THIS_PAGE', 'view_item');
define('PARENT_PAGE', 'collections');

require 'includes/config.inc.php';

$item = (string)($_GET['item']);
$cid = (int)($_GET['collection']);
$order = tbl('collection_items') . '.ci_id DESC';

if (empty($item) || !isSectionEnabled('photos')) {
    redirect_to(Network::get_server_url());
}

$param = [
    'type'          => 'photos',
    'collection_id' => $cid
];
$collect =  Collection::getInstance()->getOne($param);

$photo = Photo::getInstance()->getOne(['photo_key'=>$item]);
if ($photo) {
    //if photo is orphan and isn't own by current user or user isn't an admin then redirect
    if (empty($photo)
        || (
            empty($photo['collection_id'])
            && (!User::getInstance()->hasAdminAccess() && ($photo['userid'] != user_id()))
        )
    ) {
        redirect_to(Network::get_server_url());
    }
    if (!empty($photo['collection_id']) && !Collections::getInstance()->is_viewable($cid)) {
        ClipBucket::getInstance()->show_page = false;
    } else {

        if (!Photo::getInstance()->isCurrentUserRestricted($photo['photo_id'])) {
            $info = CBPhotos::getInstance()->collection->get_collection_item_fields($cid, $photo['photo_id'], 'ci_id');
            if ($info) {
                $photo = array_merge($photo, $info[0]);
            }
            $breadcrum = [];
            $breadcrum[] = [
                'title' => $photo['photo_title'],
                'url'   => '#'
            ];
            if (!empty($collect)) {
                $collection_parent = $collect;
                do {
                    $breadcrum[] = [
                        'title' => $collection_parent['collection_name']
                        , 'url' => Collections::getInstance()->collection_links($collection_parent,'view')
                    ];
                    $collection_parent = Collections::getInstance()->get_parent_collection($collection_parent);
                } while ($collection_parent);
                assign('breadcrum', array_reverse($breadcrum));
                assign('collection_baseurl', Collections::getInstance()->get_base_url());
                subtitle($collect['collection_name'] . ' > ' . $photo['photo_title']);
            } else {
                assign('breadcrum', $breadcrum);
                assign('collection_baseurl', '');
                if (User::getInstance()->hasAdminAccess()) {
                    $param = ['type'=>'photos'];
                } else {
                    $param = ['userid' => user_id(),'type'=>'photos'];
                }
                $collections = Collection::getInstance()->getAll($param) ? : [];
                assign('collections', $collections);
                assign('restore_collection', true);
                assign('item_id', $photo['photo_id']);
                subtitle($photo['photo_title']);
            }

            increment_views($photo['photo_id'], 'photo');

            assign('photo', $photo);
            assign('user', userquery::getInstance()->get_user_details($photo['userid']));

            Assign('c', $collect);
        } else {
            e(lang('error_age_restriction'));
            ClipBucket::getInstance()->show_page = false;
        }
    }
    //link edit
    assign('link_edit_bo', DirPath::get('admin_area', true) . 'edit_photo.php?photo=' . $photo['photo_id']);
    assign('link_edit_fo', '/edit_photo.php?photo=' . $photo['photo_id']);

    // Top collections
    $params = [
        'limit'        => 5,
        'type'         => 'photos',
        'parents_only' => true
    ];
    $top_collections = Collection::getInstance()->getAll($params);
    assign('top_collections', $top_collections);

    // Top collections
    $related_photos = Photo::getInstance()->getPhotoRelated($photo['photo_id'], config('limit_photo_related') != 0 ? config('limit_photo_related') : 8);
    assign('related_photos', $related_photos);

} else {
    e(lang('item_not_exist'));
    ClipBucket::getInstance()->show_page = false;
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                              => 'admin',
    'photos' . $min_suffixe . '.js'                              => 'admin',
    'init_readonly_tag/init_readonly_tag' . $min_suffixe . '.js' => 'admin'
]);
if( config('enable_comments_photo') == 'yes' ){
    ClipBucket::getInstance()->addJS([
        'pages/add_comment/add_comment' . $min_suffixe . '.js'  => 'admin'
    ]);

    if( config('enable_visual_editor_comments') == 'yes' ){
        ClipBucket::getInstance()->addJS(['toastui/toastui-editor-all' . $min_suffixe . '.js' => 'libs']);
        ClipBucket::getInstance()->addCSS(['toastui/toastui-editor' . $min_suffixe . '.css' => 'libs']);

        $filepath = DirPath::get('libs') . 'toastui' . DIRECTORY_SEPARATOR . 'toastui-editor-' . config('default_theme') . $min_suffixe . '.css';
        if( config('default_theme') != '' && file_exists($filepath) ){
            ClipBucket::getInstance()->addCSS([
                'toastui/toastui-editor-' . config('default_theme') . $min_suffixe . '.css' => 'libs'
            ]);
        }

        $filepath = DirPath::get('libs') . 'toastui' . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR . strtolower(Language::getInstance()->getLang()) . $min_suffixe . '.js';
        if( file_exists($filepath) ){
            ClipBucket::getInstance()->addJS([
                'toastui/i18n/' . strtolower(Language::getInstance()->getLang()) . $min_suffixe . '.js' => 'libs'
            ]);
        }
    }
}

if (config('enable_photo_categories')=='yes') {
    $category_links = [];
    foreach (json_decode($photo['category_list'],true) as $photo_category) {
        $category_links[] = '<a href="' . cblink(['name' => 'category', 'data' => ['category_id' => $photo_category['id'], 'category_name' => $photo_category['name']], 'type' => 'photos']) . '">' . display_clean($photo_category['name']) . '</a>';
    }
    assign('category_links', implode(',', $category_links));
}

ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin',
    'readonly_tag' . $min_suffixe . '.css'     => 'admin'
]);
assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
template_files('view_photo.html');
display_it();