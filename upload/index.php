<?php
error_reporting(-1);
ini_set('display_errors', 1);

const THIS_PAGE = 'index';
require 'includes/config.inc.php';
pages::getInstance()->page_redir();

$anonymous_id = userquery::getInstance()->get_anonymous_user();
assign('anonymous_id', $anonymous_id);

if (!User::getInstance()->hasPermission('view_videos') && !user_id()) {
    template_files('signup_or_login.html');
} else {
    if( config('home_disable_sidebar') != 'yes' ){
        if( config('collectionsSection') == 'yes' && (config('videosSection') == 'yes' || config('photosSection') == 'yes') && User::getInstance()->hasPermission('view_collections') ) {
            $params = [
                'limit'  => config('collection_home_top_collections')
                ,'order' => 'COUNT(CASE WHEN collections.type = \'videos\' THEN video.videoid ELSE photos.photo_id END) DESC'
            ];

            assign('top_collections', Collection::getInstance()->getAll($params));
        }

        if( config('channelsSection') == 'yes' ){
            $params = [
                'featured'       => 'yes',
                'channel_enable' => 'yes',
                'limit'          => 5
            ];
            assign('featured_users', User::getInstance()->getAll($params));
        }

        if( config('videosSection') == 'yes' && config('playlistsSection') == 'yes' ){
            $params = [
                'limit'  => 4
                ,'order' => 'playlists.total_items DESC'
            ];
            $playlists = Playlist::getInstance()->getAll($params);
            assign('playlists', activePlaylists($playlists));
        }
    }

    $min_suffixe = System::isInDev() ? '' : '.min';
    ClipBucket::getInstance()->addJS(['pages/index/index' . $min_suffixe . '.js'  => 'admin']);

    $ids_to_check_progress = [];
    if( config('home_display_recent_videos') == 'yes' && config('homepage_recent_videos_display') == 'slider' ){
        $params = Video::getInstance()->getFilterParams('most_recent', []);
        $params['limit'] = config('list_recent_videos');
        $recent_videos = Video::getInstance()->getAll($params);
        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '273') ) {
            foreach ($recent_videos as $video) {
                if (in_array($video['status'], ['Processing', 'Waiting'])) {
                    $ids_to_check_progress[] = $video['videoid'];
                }
            }
        }
        assign('recent_videos', $recent_videos);
        if( empty($recent_videos) || count($recent_videos) < config('list_recent_videos') ) {
            $view_more = false;
        } else {
            unset($params['limit']);
            $params['count'] = true;
            $count_videos = Video::getInstance()->getAll($params);
            if( $count_videos > count($recent_videos) ){
                assign('view_more_recent', true);
            }
        }
    }
    Assign('ids_to_check_progress_recent', json_encode($ids_to_check_progress));

    $ids_to_check_progress = [];
    if( config('home_display_featured_collections') == 'yes' ){
        $params = [
            'featured'               => 'yes'
            ,'type'                  => 'videos'
            ,'hide_empty_collection' => true
            ,'with_items'            => true
        ];
        $featured_collections = Collection::getInstance()->getAll($params);
        assign('featured_collections', $featured_collections);
    }
    foreach ($featured_collections as $featured_collection) {
        foreach ($featured_collection['items'] as $item) {
            if (in_array($item['status'], ['Processing', 'Waiting'])) {
                $ids_to_check_progress[] = $item['videoid'];
            }
        }
    }
    Assign('ids_to_check_progress_collection', json_encode($ids_to_check_progress));

    $ids_to_check_progress = [];
    if( config('display_featured_video') == 'yes' ){
        $params = Video::getInstance()->getFilterParams('featured', []);
        $params['limit'] = config('list_featured_videos');
        $featured_videos = Video::getInstance()->getAll($params);
        if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '273') ) {
            foreach ($featured_videos as $video) {
                if (in_array($video['status'], ['Processing', 'Waiting'])) {
                    $ids_to_check_progress[] = $video['videoid'];
                }
            }
        }
        assign('featured_videos', $featured_videos);
    }
    Assign('ids_to_check_progress_featured', json_encode($ids_to_check_progress));

    assign('popup_video', config('popup_video') == 'yes');
    template_files('index.html');
}
display_it();
