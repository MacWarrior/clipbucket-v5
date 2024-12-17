<?php
define('THIS_PAGE', 'flagged_photos');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages, $cbphoto, $eh;

User::getInstance()->hasPermissionOrRedirect('admin_access', true);
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Photos', 'url' => ''];
$breadcrumb[1] = ['title' => 'Flagged Photos', 'url' => DirPath::getUrl('admin_area') . 'flagged_photos.php'];

//Delete Photo
if (isset($_GET['delete_photo'])) {
    $photo = mysql_clean($_GET['delete_photo']);
    $cbphoto->delete_photo($photo);
}

//Deleting Multiple Photos
if (isset($_POST['delete_selected']) && is_array($_POST['check_photo'])) {
    for ($id = 0; $id <= count($_POST['check_photo']); $id++) {
        $cbphoto->delete_photo($_POST['check_photo'][$id]);
    }
    $eh->flush();
    e('Selected photos have been deleted', 'm');
}

if (isset($_REQUEST['delete_flags'])) {
    $photo = mysql_clean($_GET['delete_flags']);
    $cbphoto->action->delete_flags($photo);
}

//Deleting Multiple Videos
if (isset($_POST['delete_flags']) && is_array($_POST['check_photo'])) {
    for ($id = 0; $id <= count($_POST['check_photo']); $id++) {
        $eh->flush();
        $cbphoto->action->delete_flags($_POST['check_photo'][$id]);
    }
}

//Getting Video List
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, 5);
$photos = $cbphoto->action->get_flagged_objects($get_limit);
assign('photos', $photos);

//Collecting Data for Pagination
$total_rows = $cbphoto->action->count_flagged_objects();
$total_pages = count_pages($total_rows, 5);

//Pagination
$pages->paginate($total_pages, $page);

subtitle('Flagged Photos');
template_files('flagged_photos.html');
display_it();
