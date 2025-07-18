<?php
const THIS_PAGE = 'manage_videos';
const PARENT_PAGE = 'videos';
require 'includes/config.inc.php';

User::getInstance()->isUserConnectedOrRedirect();

if( config('videosSection') != 'yes' ){
    redirect_to(cblink(['name' => 'my_account']));
}

$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));

$mode = $_GET['mode'];

$page = (int)$_GET['page'];
$get_limit = create_query_limit($page, config('videos_list_per_page'));

$favorites = User::getInstance()->getFavoritesVideos();
assign('favorites', $favorites);

assign('queryString', queryString(null, ['type', 'vid_delete']));
switch ($mode) {
    case 'uploaded':
    default:
        if( !User::getInstance()->hasPermission('allow_video_upload') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        assign('mode', 'uploaded');

        //Deleting Video
        if (!empty($_GET['vid_delete'])) {
            $videoid = (int)$_GET['vid_delete'];
            if (CBvideo::getInstance()->is_video_owner($videoid, user_id())) {
                CBvideo::getInstance()->delete_video($videoid);
            }
        }

        //Getting Video List
        $params_video = [
            'userid' => $udetails['userid']
            ,'limit' => $get_limit
        ];
        if (get('query') != '') {
           $params_video['search'] = get('query');
        }

        $videos = Video::getInstance()->getAll($params_video);

        if( $page == 1 && is_array($videos) && count($videos) < config('videos_list_per_page') ){
            $total_rows = count($videos);
        } else {
            $params_video['count'] = true;
            unset($params_video['limit']);
            $total_rows = Video::getInstance()->getAll($params_video);
        }

        $total_pages = count_pages($total_rows, config('videos_list_per_page'));

        subtitle(lang("vdo_manage_vdeos"));
        break;


    case 'favorites':
        if( !User::getInstance()->hasPermission('view_video') ){
            redirect_to(cblink(['name' => 'my_account']));
        }

        assign('mode', 'favorites');

        //Removing video from favorites
        if (!empty($_GET['remove_fav_videoid']) && in_array($_GET['remove_fav_videoid'], $favorites) ) {
            $videoid = (int)$_GET['remove_fav_videoid'];
            CBvideo::getInstance()->action->remove_favorite($videoid);
        }
        $cond = '';
        if (get('query') != '') {
            $cond = " (video.title LIKE '%" . mysql_clean(get('query')) . "%' OR video.tags LIKE '%" . mysql_clean(get('query')) . "%' )";
        }
        $params = [
            'userid' => user_id()
            ,'limit' => $get_limit
            ,'cond' => $cond
        ];

        $videos = CBvideo::getInstance()->action->get_favorites($params);

        if( $page == 1 && is_array($videos) && count($videos) < config('videos_list_per_page') ){
            $favorites_count = count($videos);
        } else {
            $params['count_only'] = 'yes';
            unset($params['limit']);
            $favorites_count = CBvideo::getInstance()->action->get_favorites($params);
        }

        $total_pages = count_pages($favorites_count, config('videos_list_per_page'));
        subtitle(lang('com_manage_fav'));
        break;
}

$ids_to_check_progress = [];
if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279') ){
    foreach ($videos as $video) {
        if (in_array($video['status'], ['Processing', 'Waiting'])) {
            $ids_to_check_progress[] = $video['videoid'];
        }
    }
}
Assign('ids_to_check_progress', json_encode($ids_to_check_progress));
Assign('uservids', $videos);
pages::getInstance()->paginate($total_pages, $page);

template_files('manage_videos.html');
display_it();
