<?php
const THIS_PAGE = 'manage_collections';
const PARENT_PAGE = 'collections';
require 'includes/config.inc.php';

User::getInstance()->isUserConnectedOrRedirect();

if( !isSectionEnabled('collections') || !(isSectionEnabled('videos') && isSectionEnabled('photos')) ){
    redirect_to(cblink(['name' => 'my_account']));
}

$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
$order = 'collection_items.date_added DESC';

$mode = $_GET['mode'];
$collection_id = mysql_clean($_GET['cid']);

assign('mode', $mode);
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('collection_per_page'));

switch ($mode) {
    case 'manage':
    default:
        if( !User::getInstance()->hasPermission('allow_create_collection') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        if (!empty($_GET['missing_collection'])) {
            e(lang('collection_not_exist'));
        }
        if (!empty($_GET['new_collection'])) {
            e(lang('collect_added_msg'), 'm');
        }

        if (isset($_GET['delete_collection'])) {
            $collection_id = $_GET['delete_collection'];
            Collections::getInstance()->delete_collection($collection_id);
        }

        if ($_POST['delete_selected'] && is_array($_POST['check_col'])) {
            $count = count($_POST['check_col']);
            for ($i = 0; $i < $count; $i++) {
                Collections::getInstance()->delete_collection($_POST['check_col'][$i]);
            }
            errorhandler::getInstance()->flush();
            e('selected_collects_del', 'm');
        }
        $collectArray = [
            'userid'  => user_id(),
            'limit' => $get_limit,
            'allow_children'=>true
        ];
        $usr_collections = Collection::getInstance()->getAll($collectArray);

        assign('usr_collects', $usr_collections);

        $collectArray['count'] = true;
        $total_rows = Collection::getInstance()->getAll($collectArray);
        $total_pages = count_pages($total_rows, config('collection_per_page'));

        //Pagination
        pages::getInstance()->paginate($total_pages, $page);
        subtitle(lang('manage_x', strtolower(lang('collections'))));
        break;

    case 'add_new':
        if( !User::getInstance()->hasPermission('allow_create_collection') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        $reqFields = Collections::getInstance()->load_required_fields();
        $otherFields = Collections::getInstance()->load_other_fields();

        assign('fields', $reqFields);
        assign('other_fields', $otherFields);

        if (!empty($_POST)) {
            Collections::getInstance()->create_collection($_POST);
            if (!error()) {
                $_POST = '';
                redirect_to(DirPath::getUrl('root') . 'manage_collections.php?new_collection=1');
            }
        }
        break;

    case 'edit':
    case 'edit_collection':
    case 'edit_collect':
        if( !User::getInstance()->hasPermission('allow_create_collection') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        if (isset($_POST['update_collection'])) {
            Collections::getInstance()->update_collection($_POST);
            if (isset($_POST['default_thumb'])) {
                Collection::getInstance()->setDefautThumb($_POST['default_thumb'], $collection_id);
            }
        }

        $collection = Collection::getInstance()->getOne(['collection_id' => $collection_id]);
        if (empty($collection)) {
            redirect_to(DirPath::getUrl('root') . 'manage_collections.php?missing_collection=1');
        }
        $items = Collection::getInstance()->getItemRecursivly(['collection_id' => $collection['collection_id']]);
        if ($collection['type'] == 'videos') {
            foreach ($items as &$item) {
                $item['id'] = $item['videoid'];
            }
        } else {
            foreach ($items as &$item) {
                $item['id'] = $item['photo_id'];
            }
        }
        assign('items', $items);

        $reqFields = Collections::getInstance()->load_required_fields($collection);
        $otherFields = Collections::getInstance()->load_other_fields($collection);

        assign('fields', $reqFields);
        assign('other_fields', $otherFields);
        assign('c', $collection);

        subtitle(lang('edit_collection'));
        break;

    case 'collection_items':
    case 'items':
    case 'manage_items':
        if( !User::getInstance()->hasPermission('allow_create_collection') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        $type = $_GET['type'];
        assign('type', $type);
        $get_limit = create_query_limit($page, config('collection_items_page'));

        $params = [
            'collection_id' => $collection_id
            ,'with_items'   => true
            ,'limit' => $get_limit
        ];
        $objs = Collection::getInstance()->getOne($params);

        if( $objs['total_objects'] < config('collection_items_page') && $page == 1 ){
            $total_rows = $objs['total_objects'];
        } else {
            unset($params['limit']);
            unset($params['with_items']);
            $total_rows = Collection::getInstance()->getOne($params)['total_objects'];
        }

        switch ($type) {
            default:
            case 'videos':
                if (isset($_POST['delete_selected'])) {
                    $count = count($_POST['check_item']);
                    for ($i = 0; $i < $count; $i++) {
                        CBvideo::getInstance()->collection->remove_item($_POST['check_item'][$i], $collection_id);
                    }
                    errorhandler::getInstance()->flush();
                    e(lang('selected_items_removed', 'videos'), 'm');
                }
                break;

            case 'photos':
                if (isset($_POST['delete_selected'])) {
                    $count = count($_POST['check_item']);
                    for ($i = 0; $i < $count; $i++) {
                        CBPhotos::getInstance()->collection->remove_item($_POST['check_item'][$i], $collection_id);
                        CBPhotos::getInstance()->make_photo_orphan($collection_id, $_POST['check_item'][$i]);
                    }
                    errorhandler::getInstance()->flush();
                    e(lang('selected_items_removed', 'photos'), 'm');
                }
                break;
        }

        //Pagination
        $total_pages = count_pages($total_rows, COLLIP);
        pages::getInstance()->paginate($total_pages, $page);
        $collection = Collection::getInstance()->getOne(['collection_id'=>$collection_id]);

        assign('c', $collection);
        assign('objs', $objs);

        subtitle(lang('manage_collection_items'));
        break;

    case 'favorite':
    case 'favorites':
    case 'fav':
        if( !User::getInstance()->hasPermission('view_collections') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        if (isset($_GET['remove_fav_collection'])) {
            $collection_id = mysql_clean($_GET['remove_fav_collection']);
            Collections::getInstance()->action->remove_favorite($collection_id);
        }

        if (isset($_POST['remove_selected_favs']) && is_array($_POST['check_col'])) {
            $total = count($_POST['check_col']);
            for ($i = 0; $i < $total; $i++) {
                Collections::getInstance()->action->remove_favorite($_POST['check_col'][$i]);
            }
            errorhandler::getInstance()->flush();
            e(lang('total_fav_collection_removed', $total), 'm');
        }

        $cond = '';
        if (get('query') != '') {
            $cond = ' (collection.collection_name LIKE \'%' . mysql_clean(get('query')) . '%\' OR collection.collection_tags LIKE \'%' . mysql_clean(get('query')) . '%\' )';
        }

        $col_arr = [
            'user'  => user_id(),
            'limit' => $get_limit,
            'order' => tbl('favorites.date_added DESC'),
            'cond'  => $cond
        ];
        $collections = Collections::getInstance()->action->get_favorites($col_arr);
        assign('collections', $collections);

        $col_arr['count_only'] = true;
        $total_rows = Collections::getInstance()->action->get_favorites($col_arr);
        $total_pages = count_pages($total_rows, COLLPP);

        //Pagination
        pages::getInstance()->paginate($total_pages, $page);
        subtitle(lang('manage_favorite_collections'));
}

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addJS([
    'tag-it' . $min_suffixe . '.js'                                      => 'admin',
    'pages/manage_collections/manage_collections' . $min_suffixe . '.js' => 'admin',
    'init_default_tag/init_default_tag' . $min_suffixe . '.js'           => 'admin'
]);
ClipBucket::getInstance()->addCSS([
    'jquery.tagit' . $min_suffixe . '.css'     => 'admin',
    'tagit.ui-zendesk' . $min_suffixe . '.css' => 'admin'
]);

$available_tags = Tags::fill_auto_complete_tags('collection');
assign('available_tags', $available_tags);

template_files('manage_collections.html');
display_it();
