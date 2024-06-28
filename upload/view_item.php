<?php
define('THIS_PAGE', 'view_item');
define('PARENT_PAGE', 'collections');

require 'includes/config.inc.php';

global $cbcollection, $userquery, $cbphoto;

$item = (string)($_GET['item']);
$cid = (int)($_GET['collection']);
$order = tbl('collection_items') . '.ci_id DESC';

if (empty($item) || empty($cid) || !isSectionEnabled('photos')) {
    redirect_to(BASEURL);
}

if (!$cbcollection->is_viewable($cid)) {
    ClipBucket::getInstance()->show_page = false;
} else {
    $param = ['type' => 'photos', 'cid' => $cid];
    $cdetails = $cbcollection->get_collections($param);
    $collect = $cdetails[0];

    $photo = $cbphoto->get_photo($item);
    if ($photo) {
        if (!Photo::getInstance()->isCurrentUserRestricted($photo['photo_id'])) {
            $info = $cbphoto->collection->get_collection_item_fields($cid, $photo['photo_id'], 'ci_id');
            if ($info) {
                $breadcrum = [];
                $breadcrum[] = [
                    'title' => $photo['photo_title']
                    ,
                    'url'   => '#'
                ];
                $collection_parent = $collect;
                do {
                    if (config('seo') == 'yes') {
                        $url = '/collection/' . $collection_parent['collection_id'] . '/' . $collection_parent['type'] . '/' . display_clean($collection_parent['collection_name']);
                    } else {
                        $url = '/view_collection.php?cid=' . $collection_parent['collection_id'];
                    }
                    $breadcrum[] = [
                        'title' => $collection_parent['collection_name']
                        ,
                        'url'   => $url
                    ];
                    $collection_parent = $cbcollection->get_parent_collection($collection_parent);
                } while ($collection_parent);
                assign('breadcrum', array_reverse($breadcrum));
                assign('collection_baseurl', $cbcollection->get_base_url());

                $photo = array_merge($photo, $info[0]);
                increment_views($photo['photo_id'], 'photo');

                assign('photo', $photo);
                assign('user', $userquery->get_user_details($photo['userid']));

                subtitle($collect['collection_name'] . ' > ' . $photo['photo_title']);
                Assign('c', $collect);
            } else {
                e(lang('item_not_exist'));
                ClipBucket::getInstance()->show_page = false;
            }
        } else {
            e(lang('error_age_restriction'));
            ClipBucket::getInstance()->show_page = false;
        }

        //link edit
        assign('link_edit_bo', DirPath::get('admin_area',true) . 'edit_photo.php?photo=' . $photo['photo_id']);
        assign('link_edit_fo',  '/edit_photo.php?photo=' . $photo['photo_id']);
    } else {
        e(lang('item_not_exist'));
        ClipBucket::getInstance()->show_page = false;
    }
}

$eeb = config('enable_edit_button');
$haa =  has_access('admin_access', true);
$ui = user_id();
$photo_user_id =  $photo['userid'];
//Getting Collection Lists
$page = $_GET['page'];
$get_limit = create_query_limit($page, COLLPP);
$clist['active'] = 'yes';
$clist['limit'] = $get_limit;
$collections = $cbcollection->get_collections($clist);

Assign('collections', $collections);

//Getting Photo List
$get_limit = create_query_limit($page, MAINPLIST);
$photos = get_photos(['pid' => $photo['photo_id']]);

Assign('photos', $photos);

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}

ClipBucket::getInstance()->addJS(['tag-it'.$min_suffixe.'.js' => 'admin']);
ClipBucket::getInstance()->addJS(['init_readonly_tag/init_readonly_tag'.$min_suffixe.'.js' => 'admin']);
ClipBucket::getInstance()->addCSS(['jquery.tagit'.$min_suffixe.'.css' => 'admin']);
ClipBucket::getInstance()->addCSS(['tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin']);
ClipBucket::getInstance()->addCSS(['readonly_tag'.$min_suffixe.'.css' => 'admin']);

template_files('view_photo.html');
display_it();
