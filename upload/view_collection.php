<?php
define('THIS_PAGE', 'view_collection');
define('PARENT_PAGE', 'collections');

require 'includes/config.inc.php';

global $pages, $cbcollection, $cbvideo, $cbphoto, $Cbucket;

User::getInstance()->hasPermissionOrRedirect('view_video');
$pages->page_redir();

$collection_id = (int)$_GET['cid'];

$page = $_GET['page'];

$order = 'collection_items.ci_id DESC';

if ($cbcollection->is_viewable($collection_id)) {
    $params = [];
    $params['collection_id'] = $collection_id;
    $cdetails = Collection::getInstance()->getOne($params);

    if (!$cdetails || (!isSectionEnabled($cdetails['type']) && !User::getInstance()->hasAdminAccess()) ){
        $Cbucket->show_page = false;
    }

    if (!$cdetails) {
        e(lang('collection_not_exists'));
    } else {
        $get_limit = create_query_limit($page, config('collection_items_page'));
        if (config('enable_sub_collection') == 'yes') {
            $params = [];
            $params['collection_id_parent'] = $collection_id;
            $params['limit'] = $get_limit;
            $collections = Collection::getInstance()->getAll($params);

            Assign('collections', $collections);
        }

        $params = [];
        $params['collection_id'] = $collection_id;
        $params['limit'] = $get_limit;
        $sort_id = $_GET['sort_id']?? $cdetails['sort_type'];
        assign('sort_id', $sort_id);
        $sort_label = SortType::getSortLabelById($sort_id) ?? '';
        $params['order_item'] = $sort_id;
        $items = Collection::getInstance()->getItems($params);

        if( empty($items) ){
            $total_items = 0;
        } else if( count($items) < config('collection_items_page') ){
            $total_items = count($items);
        } else {
            unset($params['limit']);
            $params['count'] = true;
            $total_items = Collection::getInstance()->getItems($params);
        }

        // Calling necessary function for view collection
        call_view_collection_functions($cdetails);

        $total_pages = count_pages($total_items, config('collection_items_page'));
        //Pagination
        $pages->paginate($total_pages, $page);

        if (config('enable_sub_collection') == 'yes') {
            $breadcrum = [];
            $collection_parent = $cdetails;
            do {
                $breadcrum[] = [
                    'title' => $collection_parent['collection_name']
                    , 'url' => Collections::getInstance()->collection_links($collection_parent,'view')
                ];
                $collection_parent = $cbcollection->get_parent_collection($collection_parent);
            } while ($collection_parent);
            assign('breadcrum', array_reverse($breadcrum));
            assign('collection_baseurl', $cbcollection->get_base_url());
        }

        $ids_to_check_progress = [];
        if ($cdetails['type'] == 'videos' && Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279')) {
            foreach ($items as $video) {
                if (in_array($video['status'], ['Processing', 'Waiting'])) {
                    $ids_to_check_progress[] = $video['videoid'];
                }
            }
        }
        Assign('ids_to_check_progress', json_encode($ids_to_check_progress));
        assign('objects', $items);
        assign('c', $cdetails);
        subtitle($cdetails['collection_name']);
        if ($cdetails['type'] == 'photos') {
            assign('sort_list', display_sort_lang_array(Photo::getInstance()->getSortList()));

            if (SEO == 'yes') {
                $link = '/photo_upload/' . base64_encode(json_encode($cdetails['collection_id']));
            }
            $link = '/photo_upload.php?collection=' . base64_encode(json_encode($cdetails['collection_id']));
        } elseif ($cdetails['type'] == 'videos') {
            assign('sort_list', display_sort_lang_array(Video::getInstance()->getSortList()));
            if (SEO == 'yes') {
                $link = '/upload/' . base64_encode(json_encode($cdetails['collection_id']));
            }
            $link = '/upload.php?collection=' . base64_encode(json_encode($cdetails['collection_id']));
        }
        assign('link_add_more',  $link);
    }
} else {
    $Cbucket->show_page = false;
}

assign('featured', Photo::getInstance()->getAll(['featured'=>true, 'limit'=>6]));

assign('link_edit_bo', DirPath::get('admin_area',true) . 'edit_collection.php?collection=' .$collection_id);
assign('link_edit_fo',  '/manage_collections.php?mode=edit_collection&cid=' . $collection_id);

assign('anonymous_id', userquery::getInstance()->get_anonymous_user());
$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it'.$min_suffixe.'.js'                                 => 'admin'
    ,'pages/view_collection/view_collection'.$min_suffixe.'.js' => 'admin'
    ,'init_readonly_tag/init_readonly_tag'.$min_suffixe.'.js'   => 'admin'
]);

if( config('enable_comments_collection') == 'yes' ){
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

ClipBucket::getInstance()->addCSS([
    'jquery.tagit'.$min_suffixe.'.css'      => 'admin'
    ,'tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin'
    ,'readonly_tag'.$min_suffixe.'.css'     => 'admin'
]);

assign('sort_link', $sort_id??0);
assign('current_link', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
assign('default_sort', SortType::getDefaultByType('videos'));

template_files('view_collection.html');
display_it();
