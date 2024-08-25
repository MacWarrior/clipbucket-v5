<?php
define('THIS_PAGE', 'photo_manager');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Photos', 'url' => ''];
if (isset($_GET['search']) && isset($_GET['active']) && $_GET['active'] == 'no') {
    $breadcrumb[1] = ['title' => 'Inactive Photos', 'url' => DirPath::getUrl('admin_area') . 'photo_manager.php?search=search&active=no'];
} else {
    $breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('photos'))), 'url' => DirPath::getUrl('admin_area') . 'photo_manager.php'];
}

if (!empty($_GET['missing_photo'])) {
    if ($_GET['missing_photo'] == '2') {
        e(lang('photo_success_deleted'), 'message');
    } else {
        e(lang('no_photos_found'));
    }
}

//Photo Actions are following
//Feature
if (isset($_GET['make_feature'])) {
    $id = mysql_clean($_GET['make_feature']);
    CBPhotos::getInstance()->photo_actions('feature_photo', $id);
}

//Unfeature
if (isset($_GET['make_unfeature'])) {
    $id = mysql_clean($_GET['make_unfeature']);
    CBPhotos::getInstance()->photo_actions('unfeature_photo', $id);
}

//Activate
if (isset($_GET['activate'])) {
    $id = mysql_clean($_GET['activate']);
    CBPhotos::getInstance()->photo_actions('activation', $id);
}

//Deactivate
if (isset($_GET['deactivate'])) {
    $id = mysql_clean($_GET['deactivate']);
    CBPhotos::getInstance()->photo_actions('deactivation', $id);
}

//Delete
if (isset($_GET['delete_photo'])) {
    $id = mysql_clean($_GET['delete_photo']);
    CBPhotos::getInstance()->delete_photo($id);
}

//Multi-Active
if (isset($_POST['deactivate_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        CBPhotos::getInstance()->photo_actions('deactivation', $_POST['check_photo'][$i]);
    }
    errorhandler::getInstance()->flush();
    e($total . ' photos has been deactivated', 'm');
}

//Multi-Deactive
if (isset($_POST['activate_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        CBPhotos::getInstance()->photo_actions('activation', $_POST['check_photo'][$i]);
    }
    errorhandler::getInstance()->flush();
    e($total . ' photos has been activated', 'm');
}

//Multi-featured
if (isset($_POST['make_featured_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        CBPhotos::getInstance()->photo_actions('feature_photo', $_POST['check_photo'][$i]);
    }
    errorhandler::getInstance()->flush();
    e($total . ' photos has been marked as <strong>' . lang('featured') . '</strong>', 'm');
}

//Multi-unfeatured
if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        CBPhotos::getInstance()->photo_actions('unfeature_photo', $_POST['check_photo'][$i]);
    }
    errorhandler::getInstance()->flush();
    e($total . ' photos has been marked as <strong>Unfeatured</strong>', 'm');
}

//Multi-delete
if (isset($_POST['delete_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        CBPhotos::getInstance()->delete_photo($_POST['check_photo'][$i]);
    }
    errorhandler::getInstance()->flush();
    e($total . ' photos has been deleted successfully', 'm');
}

if (isset($_POST['move_to_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        $id_array[] = $_POST['check_photo'][$i];
    }
}

$params = [];
if (isset($_GET['search'])) {
    $params['title'] = $_GET['title'] ?? false;
    $params['photo_id'] = $_GET['photoid'] ?? false;
    $params['photo_key'] = $_GET['photokey'] ?? false;
    $params['tags'] = $_GET['tags'] ?? false;
    $params['featured'] = $_GET['featured'] ?? false;
    $params['userid'] = $_GET['userid'] ?? false;
    $params['extension'] = $_GET['extension'] ?? false;
    $params['active'] = $_GET['active'] ?? false;

    switch($_GET['order']) {
        default:
            break;

        case 'photo_id':
        case 'photo_title':
        case 'views':
            $params['order'] = 'photos. ' . $_GET['order'] . ' DESC';
            break;
    }
}

if( !empty($params['order']) ){
    $params['order'] = 'photos.date_added DESC';
}

// Creating Limit
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

$params['limit'] = $get_limit;

$photos = Photo::getInstance()->getAll($params);
assign('photos', $photos);

if( empty($photos) ){
    $total_rows = 0;
} else if( count($photos) < config('admin_pages') && ($page == 1 || empty($page)) ){
    $total_rows = count($photos);
} else {
    $params['count'] = true;
    unset($params['limit']);
    unset($params['order']);
    $total_rows = Photo::getInstance()->getAll($params);
}

$total_pages = count_pages($total_rows, config('admin_pages'));
pages::getInstance()->paginate($total_pages, $page);

assign('anonymous_id', userquery::getInstance()->get_anonymous_user());

subtitle(lang('manage_x', strtolower(lang('photos'))));
template_files('photo_manager.html');
display_it();
