<?php
define('THIS_PAGE', 'orphan_photos');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages, $cbphoto, $eh;

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Photos', 'url' => ''];
$breadcrumb[1] = ['title' => 'Orphan Photos', 'url' => DirPath::getUrl('admin_area') . 'orphan_photos.php'];

if (isset($_GET['delete_photo'])) {
    $id = mysql_clean($_GET['delete_photo']);
    $cbphoto->delete_photo($id);
}

//Thanks to didier.saintes
if (isset($_POST['delete_selected']) && is_array($_POST['check_photo'])) {   //HACK : delete_selected in place of deleted_selected
    $total = count($_POST['check_photo']);  //HACK Add count
    for ($i = 0; $i < $total; $i++) {
        $cbphoto->delete_photo($_POST['check_photo'][$i], true); //HACK : Add true
    }
    $eh->flush();
    e($total . ' photos have been deleted successfully.', 'm');
}

//Multi-featured
if (isset($_POST['make_featured_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        $cbphoto->photo_actions('feature_photo', $_POST['check_photo'][$i]);
    }
    $eh->flush();
    e($total . ' photos have been marked as <strong>' . lang('featured') . '</strong>', 'm');
}

//Multi-unfeatured
if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    for ($i = 0; $i < $total; $i++) {
        $cbphoto->photo_actions('unfeature_photo', $_POST['check_photo'][$i]);
    }
    $eh->flush();
    e($total . ' photos have been marked as <strong>Unfeatured</strong>', 'm');
}

if (isset($_POST['move_selected']) && is_array($_POST['check_photo'])) {
    $total = count($_POST['check_photo']);
    $new = mysql_clean($_POST['collection_id']);
    for ($i = 0; $i < $total; $i++) {
        $cbphoto->collection->change_collection($new, $_POST['check_photo'][$i]);
        Clipbucket_db::getInstance()->update(tbl('photos'), ['collection_id'], [$new], ' photo_id = ' . $_POST['check_photo'][$i]);
    }
    $eh->flush();
    e($total . ' photo(s) have been moved to \'<strong>' . get_collection_field($new, 'collection_name') . '</strong>\'', 'm');
}

$photos = $cbphoto->get_photos(['get_orphans' => true]);
$collection = $cbphoto->collection->get_collections(['type' => 'photos']);
assign('photos', $photos);
assign('c', $collection);

subtitle('Orphan Photos');
template_files('orphan_photos.html');
display_it();
