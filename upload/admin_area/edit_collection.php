<?php
define('THIS_PAGE','edit_collection');

require_once '../includes/admin_config.php';

global $userquery,$pages,$cbcollection,$cbvideo,$cbphoto,$cbvid;

$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

if( !isset($_GET['collection']) ){
    redirect_to('/collection_manager.php');
}

$id = $_GET['collection'];
$c = $cbcollection->get_collection($id);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = array('title' => lang('collections'), 'url' => '');
$breadcrumb[1] = array('title' => 'Manage Collections', 'url' => ADMIN_BASEURL.'/collection_manager.php');
$breadcrumb[2] = array('title' => 'Editing : '.display_clean($c['collection_name']), 'url' => ADMIN_BASEURL.'/edit_collection.php?collection='.display_clean($id));

if(isset($_POST['update_collection'])) {
    $cbcollection->update_collection();
}

if(isset($_POST['delete_preview'])) {
    $id = mysql_clean($_POST['delete_preview']);
    $cbcollection->delete_thumbs($id);
}

//Performing Actions
if($_GET['mode']!='') {
    $cbcollection->collection_actions($_GET['mode'],$id);
}

switch($c['type'])
{
    case 'videos':
    case 'v':
        $items = $cbvideo->collection->get_collection_items_with_details($c['collection_id'],NULL,4);
        break;

    case 'photos':
    case 'p':
        $items = $cbphoto->collection->get_collection_items_with_details($c['collection_id'],NULL,4);
        break;
}

if(!empty($items)){
    assign('objects',$items);
}
assign('data',$c);

$FlaggedPhotos = $cbvid->action->get_flagged_objects();
Assign('flaggedPhoto', $FlaggedPhotos);
$count_flagged_photos = $cbvid->action->count_flagged_objects();
Assign('count_flagged_photos', $FlaggedPhotos);

assign('randon_number', rand(-5000, 5000));
subtitle('Edit Collection');
template_files('edit_collection.html');
display_it();
