<?php
require_once '../../../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
$breadcrumb[0] = array('title' => 'Plugin Manager', 'url' => '');
$breadcrumb[1] = array('title' => 'Editor\'s Pick', 'url' =>  PLUG_URL.'/editors_pick/admin/editor_pick.php');

//Removing
if(isset($_GET['remove'])){
    $id = mysql_clean($_GET['remove']);
    remove_vid_editors_pick($id);
}

if(isset($_POST['delete_selected'])) {
    for($id=0;$id<=count($_POST['check_video']);$id++) {
        remove_vid_editors_pick($_POST['check_video'][$id]);
    }
    $eh->flush();
    e("Selected videos have been removed from editors pick","m");
}

$ep_videos = get_ep_videos();

if(isset($_POST['update_order'])) {
    if(is_array($ep_videos)) {
        foreach($ep_videos as $epvid) {
            $order = $_POST['ep_order_'.$epvid['pick_id']];
            move_epick($epvid['videoid'],$order);
        }
    }
    $ep_videos = get_ep_videos();
}

if (isset($_POST['upload_special'])) {
    pr($_POST,true);
    pr($_FILES,true);
}

assign('videos',$ep_videos);

subtitle("Editor's Pick");
template_files('../templates/admin/editor_pick.html');
display_it();
