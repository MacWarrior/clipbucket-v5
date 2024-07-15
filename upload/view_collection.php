<?php
define('THIS_PAGE', 'view_collection');
define('PARENT_PAGE', 'collections');

require 'includes/config.inc.php';

global $userquery, $pages, $cbcollection, $cbvideo, $cbphoto, $Cbucket;

$userquery->perm_check('view_video', true);
$pages->page_redir();

$c = (int)$_GET['cid'];

$page = $_GET['page'];

$order = 'collection_items.ci_id DESC';

if ($cbcollection->is_viewable($c)) {
    $params = [];
    $params['collection_id'] = $c;
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
            $params['collection_id_parent'] = $c;
            $params['limit'] = $get_limit;
            $collections = Collection::getInstance()->getAll($params);

            Assign('collections', $collections);
        }

        $params = [];
        $params['collection_id'] = $c;
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
                if (config('seo') == 'yes') {
                    $url = '/collection/' . $collection_parent['collection_id'] . '/' . $collection_parent['type'] . '/' . display_clean($collection_parent['collection_name']);
                } else {
                    $url = '/view_collection.php?cid=' . $collection_parent['collection_id'];
                }
                $breadcrum[] = [
                    'title' => $collection_parent['collection_name']
                    , 'url' => $url
                ];
                $collection_parent = $cbcollection->get_parent_collection($collection_parent);
            } while ($collection_parent);
            assign('breadcrum', array_reverse($breadcrum));
            assign('collection_baseurl', $cbcollection->get_base_url());
        }

        assign('objects', $items);
        assign('c', $cdetails);
        subtitle($cdetails['collection_name']);
    }
} else {
    $Cbucket->show_page = false;
}

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}

ClipBucket::getInstance()->addJS(['tag-it'.$min_suffixe.'.js' => 'admin']);
ClipBucket::getInstance()->addJS(['pages/view_collection/view_collection'.$min_suffixe.'.js' => 'admin']);
ClipBucket::getInstance()->addJS(['init_readonly_tag/init_readonly_tag'.$min_suffixe.'.js' => 'admin']);
ClipBucket::getInstance()->addCSS(['jquery.tagit'.$min_suffixe.'.css' => 'admin']);
ClipBucket::getInstance()->addCSS(['tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin']);
ClipBucket::getInstance()->addCSS(['readonly_tag'.$min_suffixe.'.css' => 'admin']);

template_files('view_collection.html');
display_it();
