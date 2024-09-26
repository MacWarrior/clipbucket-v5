<?php
define('THIS_PAGE', 'manage_items');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages, $cbcollection, $cbphoto, $eh, $cbvideo;

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('video_moderation');
$pages->page_redir();

$id = mysql_clean($_GET['collection']);
$c = $cbcollection->get_collection($id);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('collections'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('manage_x', strtolower(lang('collections'))),
    'url'   => DirPath::getUrl('admin_area') . 'collection_manager.php'
];
$breadcrumb[2] = [
    'title' => 'Editing : ' . display_clean($c['collection_name']),
    'url'   => DirPath::getUrl('admin_area') . 'edit_collection.php?collection=' . display_clean($id)
];
$breadcrumb[3] = [
    'title' => lang('manage_collection_items'),
    'url'   => DirPath::getUrl('admin_area') . 'manage_items.php?collection=' . display_clean($id) . '&type=videos'
];

$type = mysql_clean($_GET['type']);
$items = [];
switch ($type) {
    case 'photos':
        if (isset($_POST['remove_selected']) && is_array($_POST['check_obj'])) {
            $total = count($_POST['check_obj']);
            for ($i = 0; $i < $total; $i++) {
                $cbphoto->collection->remove_item($_POST['check_obj'][$i], $id);
                $cbphoto->make_photo_orphan($id, $_POST['check_obj'][$i]);
            }
            $eh->flush();
            e($total . ' photos have been removed.', 'm');
        }

        if (isset($_POST['move_selected']) && is_array($_POST['check_obj'])) {
            $total = count($_POST['check_obj']);
            $new = mysql_clean($_POST['collection_id']);
            for ($i = 0; $i < $total; $i++) {
                $cbphoto->collection->change_collection($new, $_POST['check_obj'][$i], $id);
                Clipbucket_db::getInstance()->update(tbl('photos'), ['collection_id'], [$new], ' collection_id = ' . $id . ' AND photo_id = ' . $_POST['check_obj'][$i]);
            }
            $eh->flush();
            e($total . ' photo(s) have been moved to \'<strong>' . display_clean(get_collection_field($new, 'collection_name')) . '</strong>\'', 'm', false);
        }

        $items = $cbphoto->collection->get_collection_items_with_details($id);
        break;

    default:
    case 'videos':
        if (isset($_POST['remove_selected']) && is_array($_POST['check_obj'])) {
            $total = count($_POST['check_obj']);
            for ($i = 0; $i < $total; $i++) {
                $cbvideo->collection->remove_item($_POST['check_obj'][$i], $id);
            }
        }

        if (isset($_POST['move_selected']) && is_array($_POST['check_obj'])) {
            $total = count($_POST['check_obj']);
            $new = mysql_clean($_POST['collection_id']);
            for ($i = 0; $i < $total; $i++) {
                $cbvideo->collection->change_collection($new, $_POST['check_obj'][$i], $id);
            }
            $eh->flush();
            e($total . ' video(s) have been moved to \'<strong>' . display_clean(get_collection_field($new, 'collection_name')) . '</strong>\'', 'm', false);
        }

        $items = $cbvideo->collection->get_collection_items_with_details($id);
        break;
}

if (config('enable_sub_collection') == 'yes') {
    if (isset($_POST['remove_selected']) && is_array($_POST['check_collection'])) {
        $count = 0;
        foreach ($_POST['check_collection'] as $collection_id) {
            $count++;
            Collections::getInstance()->delete_collection($collection_id);
        }
        e(lang(''), 'm');
    }
    if (isset($_POST['move_selected']) && is_array($_POST['check_collection']) && !empty($_POST['collection_id'])) {
        $count = 0;
        foreach ($_POST['check_collection'] as $collection_id) {
            $count++;
            Collection::getInstance()->changeParent($collection_id, $_POST['collection_id']);
        }
        e(lang(''), 'm');
    }

    $childs = Collection::getInstance()->getChildCollection($id);
    if (!empty($childs)) {
        foreach ($childs as $child) {
            $items[] = $child;
        }
    }
}
if (!empty($items)) {
    assign('objects', $items);
}

$collections = $cbcollection->get_collections_list(0, null, null, $type, user_id());
assign('collections', $collections);

assign('obj', $items);
assign('type', $type);
assign('collection', $c);

subtitle(lang('manage_items'));
template_files('manage_items.html');
display_it();
