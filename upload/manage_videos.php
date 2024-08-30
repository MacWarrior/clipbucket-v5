<?php
define('THIS_PAGE', 'manage_videos');
define('PARENT_PAGE', "videos");

require 'includes/config.inc.php';

if( config('videosSection') != 'yes' ){
    redirect_to(BASEURL);
}

global $cbvideo, $eh, $pages, $cbvid;

userquery::getInstance()->logincheck();
$udetails = userquery::getInstance()->get_user_details(user_id());
assign('user', $udetails);
assign('p', userquery::getInstance()->get_user_profile($udetails['userid']));

$mode = $_GET['mode'];

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('videos_list_per_page'));
$favorites = User::getInstance()->getFavoritesVideos(user_id());
assign('favorites', $favorites);
assign('queryString', queryString(null, ['type',
    'vid_delete']));
switch ($mode) {
    case 'uploaded':
    default:
        assign('mode', 'uploaded');

        //Deleting Video
        if (!empty($_GET['vid_delete'])) {
            $videoid = mysql_clean($_GET['vid_delete']);
            if ($cbvid->is_video_owner($videoid, user_id())) {
                $cbvideo->delete_video($videoid);
            }
        }

        //Deleting Videos
        if (isset($_POST['delete_videos'])) {
            for ($id = 0; $id <= config('videos_list_per_page'); $id++) {
                if ($cbvid->is_video_owner($_POST['check_vid'][$id], user_id())) {
                    $cbvideo->delete_video($_POST['check_vid'][$id]);
                }
            }
            $eh->flush();
            e(lang('vdo_multi_del_erro'), 'm');
        }

        //Getting Video List
        $vid_array = ['user' => $udetails['userid'], 'limit' => $get_limit];
        if (get('query') != '') {
            $vid_array['title'] = mysql_clean(get('query'));
            $vid_array['tags'] = mysql_clean(get('query'));
        }

        $videos = get_videos($vid_array);

        Assign('uservids', $videos);

        //Collecting Data for Pagination
        $vid_array['count_only'] = true;
        $total_rows = get_videos($vid_array);

        $total_pages = count_pages($total_rows, config('videos_list_per_page'));

        //Pagination
        $pages->paginate($total_pages, $page);

        subtitle(lang("vdo_manage_vdeos"));
        break;


    case 'favorites':
        assign('mode', 'favorites');
        //Removing video from favorites
        if (!empty($_GET['remove_fav_videoid']) && in_array($_GET['remove_fav_videoid'], $favorites) ) {
            $videoid = mysql_clean($_GET['remove_fav_videoid']);
            $cbvideo->action->remove_favorite($videoid);
        }
        if (get('query') != '') {
            $cond = " (video.title LIKE '%" . mysql_clean(get('query')) . "%' OR video.tags LIKE '%" . mysql_clean(get('query')) . "%' )";
        }
        $params = ['userid' => user_id(), 'limit' => $get_limit, 'cond' => $cond];

        $videos = $cbvid->action->get_favorites($params);

        Assign('uservids', $videos);

        //Collecting Data for Pagination
        $params['count_only'] = 'yes';
        $favorites_count = $cbvid->action->get_favorites($params);
        $total_pages = count_pages($favorites_count, config('videos_list_per_page'));
        //Pagination
        $pages->paginate($total_pages, $page);

        subtitle(lang('com_manage_fav'));
        break;
}

template_files('manage_videos.html');
display_it();
