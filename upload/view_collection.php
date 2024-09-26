<?php
define('THIS_PAGE', 'view_collection');
define('PARENT_PAGE', 'collections');

require 'includes/config.inc.php';

global $pages, $cbcollection, $cbvideo, $cbphoto, $Cbucket;

userquery::getInstance()->perm_check('view_video', true);
$pages->page_redir();

$collection_id = (int)$_GET['cid'];

$page = $_GET['page'];

$order = 'collection_items.ci_id DESC';

if ($cbcollection->is_viewable($collection_id)) {
    $params = [];
    $params['collection_id'] = $collection_id;
    $cdetails = Collection::getInstance()->getOne($params);

    if (!$cdetails || (!isSectionEnabled($cdetails['type']) && !has_access('admin_access', true)) ){
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

        assign('objects', $items);
        assign('c', $cdetails);
        subtitle($cdetails['collection_name']);
        if ($cdetails['type'] == 'photos') {
            if (SEO == 'yes') {
                $link = '/photo_upload/' . base64_encode(serialize($cdetails['collection_id']));
            }
            $link = '/photo_upload.php?collection=' . base64_encode(serialize($cdetails['collection_id']));
        } elseif ($cdetails['type'] == 'videos') {
            if (SEO == 'yes') {
                $link = '/upload/' . base64_encode(serialize($cdetails['collection_id']));
            }
            $link = '/upload.php?collection=' . base64_encode(serialize($cdetails['collection_id']));
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
    ,'init_readonly_tag/init_readonly_tag'.$min_suffixe.'.js' => 'admin'
]);

ClipBucket::getInstance()->addCSS([
    'jquery.tagit'.$min_suffixe.'.css'      => 'admin'
    ,'tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin'
    ,'readonly_tag'.$min_suffixe.'.css'     => 'admin'
]);

template_files('view_collection.html');
display_it();
