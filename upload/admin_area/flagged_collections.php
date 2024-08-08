<?php
define('THIS_PAGE', 'flagged_collections');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages, $cbcollection, $cbphoto, $eh;

userquery::getInstance()->admin_login_check();
$pages->page_redir();

$mode = $_GET['mode'];

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('collections'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Flagged Collections', 'url' => DirPath::getUrl('admin_area') . 'flagged_collections.php'];

//Delete Photo
if (isset($_GET['delete_collect'])) {
    $collect = mysql_clean($_GET['delete_collect']);
    $cbcollection->delete_collection($collect);
}

//Deleting Multiple Photos
if (isset($_POST['delete_selected']) && is_array($_POST['check_collect'])) {
    for ($id = 0; $id <= count($_POST['check_collect']); $id++) {
        $cbphoto->delete_photo($_POST['check_collect'][$id]);
    }
    $eh->flush();
    e('Selected collections have been deleted', 'm');
}

if (isset($_GET['delete_flags'])) {
    $collect = mysql_clean($_GET['delete_flags']);
    $cbcollection->action->delete_flags($collect);
}

//Deleting Multiple Videos
if (isset($_POST['delete_flags']) && is_array($_POST['check_collect'])) {
    for ($id = 0; $id <= count($_POST['check_collect']); $id++) {
        $eh->flush();
        $cbcollection->action->delete_flags($_POST['check_collect'][$id]);
    }
}

switch ($mode) {
    case 'view':
    default:
        assign('mode', 'view');
        //Getting Video List
        $page = mysql_clean($_GET['page']);
        $get_limit = create_query_limit($page, 5);
        $collects = $cbcollection->action->get_flagged_objects($get_limit);

        assign('cl', $collects);

        //Collecting Data for Pagination
        $total_rows = $cbcollection->action->count_flagged_objects();
        $total_pages = count_pages($total_rows, 5);

        //Pagination
        $pages->paginate($total_pages, $page);
        break;

    case 'view_flags':
        assign('mode', 'view_flags');
        $cid = mysql_clean($_GET['cid']);
        $cdetails = $cbcollection->get_collection($cid);
        if ($cdetails) {
            $flags = $cbcollection->action->get_flags($cid);
            assign('flags', $flags);
            assign('collection', $cdetails);
        } else {
            e(lang('collection_not_exist'));
        }
        break;
}

subtitle('Flagged Collections');
template_files('flagged_collections.html');
display_it();
