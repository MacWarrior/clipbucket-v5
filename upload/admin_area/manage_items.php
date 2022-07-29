<?php
require_once '../includes/admin_config.php';

global $userquery, $pages, $cbcollection, $cbphoto, $eh, $cbvideo, $db;

$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

$id = mysql_clean($_GET['collection']);
$c = $cbcollection->get_collection($id);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('collections'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_collections'), 'url' => ADMIN_BASEURL.'/flagged_collections.php'];
$breadcrumb[2] = ['title' => 'Editing : '.display_clean($c['collection_name']), 'url' => ADMIN_BASEURL.'/edit_collection.php?collection='.display_clean($id)];
$breadcrumb[3] = ['title' => lang('manage_collection_items'), 'url' => ADMIN_BASEURL.'/manage_items.php?collection='.display_clean($id).'&type=videos'];

$type = mysql_clean($_GET['type']);
$data = $cbcollection->get_collection_items($id);

switch($type)
{
    case 'photos':
        if(isset($_POST['remove_selected']) && is_array($_POST['check_obj'])) {
            $total = count($_POST['check_obj']);
            for($i=0;$i<$total;$i++) {
                $cbphoto->collection->remove_item($_POST['check_obj'][$i],$id);
                $cbphoto->make_photo_orphan($id,$_POST['check_obj'][$i]);
            }
            $eh->flush();
            e($total.' photos have been removed.','m');
        }

        if(isset($_POST['move_selected']) && is_array($_POST['check_obj'])) {
            $total = count($_POST['check_obj']);
            $new = mysql_clean($_POST['collection_id']);
            for($i=0;$i<$total;$i++) {
                $cbphoto->collection->change_collection($new,$_POST['check_obj'][$i],$id);
                $db->update(tbl('photos'),['collection_id'],[$new],' collection_id = '.$id.' AND photo_id = '.$_POST['check_obj'][$i]);
            }
            $eh->flush();
            e($total.' photo(s) have been moved to \'<strong>'.display_clean(get_collection_field($new,'collection_name')).'</strong>\'','m', false);
        }

        $items = $cbphoto->collection->get_collection_items_with_details($id);
        break;

    default:
    case 'videos':
        if(isset($_POST['remove_selected']) && is_array($_POST['check_obj'])) {
            $total = count($_POST['check_obj']);
            for($i=0;$i<$total;$i++) {
                $cbvideo->collection->remove_item($_POST['check_obj'][$i],$id);
            }
        }

        if(isset($_POST['move_selected']) && is_array($_POST['check_obj'])) {
            $total = count($_POST['check_obj']);
            $new = mysql_clean($_POST['collection_id']);
            for($i=0;$i<$total;$i++) {
                $cbvideo->collection->change_collection($new,$_POST['check_obj'][$i],$id);
            }
            $eh->flush();
            e($total.' video(s) have been moved to \'<strong>'.display_clean(get_collection_field($new,'collection_name')).'</strong>\'','m', false);
        }

        $items = $cbvideo->collection->get_collection_items_with_details($id);
        break;
}

if( config('enable_sub_collection') ){
    $collections = $cbcollection->get_collections_hierarchy(0, null, null, $type, userid());
    assign('collections',$collections);
}

assign('data',$data);
assign('obj',$items);
assign('type',$type);
assign('collection',$c);

subtitle(lang('manage_items'));
template_files('manage_items.html');
display_it();
