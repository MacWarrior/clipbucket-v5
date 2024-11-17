<?php
define('THIS_PAGE', 'orphan_photos');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('photos_moderation', true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Photos', 'url' => ''];
$breadcrumb[1] = ['title' => 'Orphan Photos', 'url' => DirPath::getUrl('admin_area') . 'orphan_photos.php'];

if (isset($_GET['delete_photo'])) {
    $id = mysql_clean($_GET['delete_photo']);
    CBPhotos::getInstance()->delete_photo($id);
}

//Thanks to didier.saintes
if (isset($_POST['delete_selected']) && is_array($_POST['check_photo'])) {   //HACK : delete_selected in place of deleted_selected
    $total = count($_POST['check_photo']);  //HACK Add count
    for ($i = 0; $i < $total; $i++) {
        CBPhotos::getInstance()->delete_photo($_POST['check_photo'][$i], true); //HACK : Add true
    }
    errorhandler::getInstance()->flush();
    e($total . ' photos have been deleted successfully.', 'm');
}

//Multi-featured
if (isset($_POST['make_featured_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        CBPhotos::getInstance()->photo_actions('feature_photo', $_POST['check_photo'][$i]);
    }
    errorhandler::getInstance()->flush();
    e($total . ' photos have been marked as <strong>' . lang('featured') . '</strong>', 'm');
}

//Multi-unfeatured
if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        CBPhotos::getInstance()->photo_actions('unfeature_photo', $_POST['check_photo'][$i]);
    }
    errorhandler::getInstance()->flush();
    e($total . ' photos have been marked as <strong>Unfeatured</strong>', 'm');
}

$params = ['orphan' => true];
$photos = Photo::getInstance()->getAll($params);
assign('photos', $photos);

subtitle('Orphan Photos');
template_files('orphan_photos.html');
display_it();
