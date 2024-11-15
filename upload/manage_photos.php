<?php
define('THIS_PAGE', 'manage_photos');
define('PARENT_PAGE', 'photos');
require 'includes/config.inc.php';

if( !isSectionEnabled('photos') ){
    redirect_to(cblink(['name' => 'my_account']));
}

userquery::getInstance()->logincheck();
$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));

$mode = $_GET['mode'];

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, MAINPLIST);

assign(
    'queryString',
    queryString(null, [
            'type',
            'delete_photo']
    )
);

switch ($mode) {
    case 'uploaded':
    default:
        if( !has_access('allow_photo_upload') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        assign('mode', 'uploaded');
        if (isset($_GET['delete_photo'])) {
            $id = mysql_clean($_GET['delete_photo']);
            CBPhotos::getInstance()->delete_photo($id);
        }

        if (isset($_POST['delete_photos']) && is_array($_POST['check_photo'])) {
            $total = count($_POST['check_photo']);
            for ($i = 0; $i < $total; $i++) {
                CBPhotos::getInstance()->delete_photo($_POST['check_photo'][$i]);
            }
            errorhandler::getInstance()->flush();
            e(lang('total_photos_deleted', $total), 'm');
        }

        $params = [
            'limit' => $get_limit,
            'search'=> $_GET['query'],
            'order'=> 'photos.date_added DESC',
            'userid'=>user_id()
        ];
        $photos = Photo::getInstance()->getAll($params);
        assign('photos', $photos);

        //Collecting Data for Pagination
        $params['count'] = true;
        $total_rows = Photo::getInstance()->getAll($params);
        $total_pages = count_pages($total_rows, MAINPLIST);

        //Pagination
        pages::getInstance()->paginate($total_pages, $page);
        subtitle(lang('manage_photos'));
        break;

    case 'favorite':
        if( !has_access('view_photos') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        assign('mode', 'favorite');
        if ($_GET['remove_fav_photo']) {
            $photo = mysql_clean($_GET['remove_fav_photo']);
            CBPhotos::getInstance()->action->remove_favorite($photo);
            updateObjectStats('fav', 'photo', $photo, '-');
        }

        if ($_POST['remove_fav_photos'] && is_array($_POST['check_photo'])) {
            $total = count($_POST['check_photo']);
            for ($i = 0; $i < $total; $i++) {
                CBPhotos::getInstance()->action->remove_favorite($_POST['check_photo'][$i]);
                updateObjectStats('fav', 'photo', $_POST['check_photo'][$i], '-');
            }
            errorhandler::getInstance()->flush();
            e(lang('total_fav_photos_removed', $total), 'm');
        }

        if (get('query') != '') {
            $cond = ' (photos.photo_title LIKE \'%' . mysql_clean(get('query')) . '%\' OR photos.photo_tags LIKE \'%' . mysql_clean(get('query')) . '%\' )';
        }

        $photo_arr = ['user' => user_id(), 'limit' => $get_limit, 'cond' => $cond];
        $photos = CBPhotos::getInstance()->action->get_favorites($photo_arr);
        assign('photos', $photos);

        $photo_arr['count_only'] = true;
        $total_rows = CBPhotos::getInstance()->action->get_favorites($photo_arr);
        $total_pages = count_pages($total_rows, MAINPLIST);

        //Pagination
        pages::getInstance()->paginate($total_pages, $page);
        subtitle(lang('manage_favorite_photos'));
        break;

}
template_files('manage_photos.html');
display_it();
