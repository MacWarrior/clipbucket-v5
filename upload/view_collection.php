<?php
define('THIS_PAGE','view_collection');
define('PARENT_PAGE','collections');

require 'includes/config.inc.php';

global $userquery,$pages,$cbcollection,$cbvideo,$cbphoto,$Cbucket;

$userquery->perm_check('view_video',true);
$pages->page_redir();

$c = mysql_clean((int)$_GET['cid']);
$type = mysql_clean($_GET['type']);

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page,COLLIP);
$order = tbl('collection_items').'.ci_id DESC';


if($cbcollection->is_viewable($c))
{
    $param = ['cid'=>$c];
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
                $count = $cbvideo->collection->get_collection_items_with_details($c,NULL,NULL,TRUE);
                break;

            case 'photos':
                $items = $cbphoto->collection->get_collection_items_with_details($c,$order,$get_limit);
                $count = $cbphoto->collection->get_collection_items_with_details($c,NULL,NULL,TRUE);
                break;
        }
        // Calling necessary function for view collection
        call_view_collection_functions($cdetails);

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

//Getting Collection List
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page,COLLPP);
$clist['limit'] = $get_limit;
$collections = $cbcollection->get_collections($clist);

assign('collections', $collections);
template_files('view_collection.html');
display_it();
