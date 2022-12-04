<?php
define('THIS_PAGE','photo_manager');

require_once '../includes/admin_config.php';

global $userquery,$pages,$cbphoto,$eh,$cbcollection;

$userquery->admin_login_check();
$userquery->login_check('video_moderation');
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Photos', 'url' => ''];
if( isset($_GET['search']) && isset($_GET['active']) && $_GET['active'] == 'no'){
    $breadcrumb[1] = ['title' => 'Inactive Photos', 'url' => ADMIN_BASEURL.'/photo_manager.php?search=search&active=no'];
} else {
    $breadcrumb[1] = ['title' => 'Photo Manager', 'url' => ADMIN_BASEURL.'/photo_manager.php'];
}

//Photo Actions are following

//Feature
if(isset($_GET['make_feature'])) {
    $id = mysql_clean($_GET['make_feature']);
    $cbphoto->photo_actions('feature_photo',$id);
}

//Unfeature
if(isset($_GET['make_unfeature'])) {
    $id = mysql_clean($_GET['make_unfeature']);
    $cbphoto->photo_actions('unfeature_photo',$id);
}

//Activate
if(isset($_GET['activate'])) {
    $id = mysql_clean($_GET['activate']);
    $cbphoto->photo_actions('activation',$id);
}

//Deactivate
if(isset($_GET['deactivate'])) {
    $id = mysql_clean($_GET['deactivate']);
    $cbphoto->photo_actions('deactivation',$id);
}

//Delete
if(isset($_GET['delete_photo'])) {
    $id = mysql_clean($_GET['delete_photo']);
    $cbphoto->delete_photo($id);
}

//Multi-Active
if(isset($_POST['deactivate_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for($i=0;$i<$total;$i++) {
        $cbphoto->photo_actions('deactivation',$_POST['check_photo'][$i]);
    }
    $eh->flush();
    e($total.' photos has been deactivated','m');
}

//Multi-Deactive
if(isset($_POST['activate_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for($i=0;$i<$total;$i++) {
        $cbphoto->photo_actions('activation',$_POST['check_photo'][$i]);
    }
    $eh->flush();
    e($total.' photos has been activated','m');
}

//Multi-featured
if(isset($_POST['make_featured_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for($i=0;$i<$total;$i++) {
        $cbphoto->photo_actions('feature_photo',$_POST['check_photo'][$i]);
    }
    $eh->flush();
    e($total.' photos has been marked as <strong>'.lang('featured').'</strong>','m');
}

//Multi-unfeatured
if(isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for($i=0;$i<$total;$i++) {
        $cbphoto->photo_actions('unfeature_photo',$_POST['check_photo'][$i]);
    }
    $eh->flush();
    e($total.' photos has been marked as <strong>Unfeatured</strong>','m');
}

//Multi-delete
if(isset($_POST['delete_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for($i=0;$i<$total;$i++) {
        $cbphoto->delete_photo($_POST['check_photo'][$i]);
    }
    $eh->flush();
    e($total.' photos has been deleted successfully','m');
}

if(isset($_POST['move_to_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for($i=0;$i<$total;$i++) {
        $id_array[] = $_POST['check_photo'][$i];
    }
}

$parr = [];
if( isset($_GET['search']) ) {
    $parr = [
        'title' 	=> mysql_clean($_GET['title']),
        'pid' 		=> mysql_clean($_GET['photoid']),
        'key' 		=> mysql_clean($_GET['photokey']),
        'tags' 		=> mysql_clean($_GET['tags']),
        'featured' 	=> mysql_clean($_GET['featured']),
        'active' 	=> mysql_clean($_GET['active']),
        'user' 		=> mysql_clean($_GET['userid']),
        'extension' => mysql_clean($_GET['extension']),
        'order' 	=> mysql_clean($_GET['order'])
    ];
}

// Creating Limit
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page,RESULTS);

$parr['limit'] = $get_limit;
if(!$parr['order']){
    $parr['order'] = ' date_added DESC ';
} else {
    $parr['order'] = $parr['order'].' DESC';
}

$photos = $cbphoto->get_photos($parr);

Assign('photos', $photos);

$pcount = $parr;
$pcount['count_only'] = true;
$total_rows  = $cbphoto->get_photos($pcount);
$total_pages = count_pages($total_rows,RESULTS);
$pages->paginate($total_pages,$page);

subtitle('Photo Manager');
template_files('photo_manager.html');
display_it();
