<?php
define('THIS_PAGE','view_collection');
define('PARENT_PAGE','collections');

require 'includes/config.inc.php';

global $userquery,$pages,$cbcollection,$cbvideo,$cbphoto,$Cbucket;

$userquery->perm_check('view_video',true);
$pages->page_redir();

$c = (int)$_GET['cid'];

$page = $_GET['page'];
$get_limit = create_query_limit($page,COLLIP);
$order = tbl('collection_items').'.ci_id DESC';

if($cbcollection->is_viewable($c)) {
    $cdetails = $cbcollection->get_collection($c);

    if( !$cdetails || !isSectionEnabled($cdetails['type']) ){
        $Cbucket->show_page = false;
    }

    if( !$cdetails ){
        e(lang('collection_not_exists'));
    } else {
        switch($cdetails['type'])
        {
            default:
            case 'videos':
                $items = $cbvideo->collection->get_collection_items_with_details($c,$order,$get_limit);
                break;

            case 'photos':
                $items = $cbphoto->collection->get_collection_items_with_details($c,$order,$get_limit);
                break;
        }
        // Calling necessary function for view collection
        call_view_collection_functions($cdetails);

        $cond = [
            'parent_id' => $c
            ,'limit'     => $get_limit
        ];

        $collections = $cbcollection->get_collections($cond);
        Assign('collections', $collections);

        if( !$items ){
            $count = 0;
        } else {
            $count = count($items);
        }
        $total_pages = count_pages($count,COLLIP);
        //Pagination
        $tag='<li><a #params#>#page#</a><li>';
        $pages->paginate($total_pages,$page,null,null,$tag);

        assign('objects',$items);
        assign('c',$cdetails);
        subtitle($cdetails['collection_name']);
    }
} else {
    $Cbucket->show_page = false;
}

template_files('view_collection.html');
display_it();
