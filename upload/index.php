<?php
error_reporting(-1);
ini_set('display_errors', 1);

define('THIS_PAGE', 'index');
require 'includes/config.inc.php';
pages::getInstance()->page_redir();

$anonymous_id = userquery::getInstance()->get_anonymous_user();
assign('anonymous_id', $anonymous_id);

if (!userquery::getInstance()->perm_check('view_videos', false, false, true) && !user_id()) {
    template_files('signup_or_login.html');
} else {
    if( config('home_disable_sidebar') != 'yes' ){
        if( config('collectionsSection') == 'yes' && (config('videosSection') == 'yes' || config('photosSection') == 'yes') ) {
            $params = [
                'limit'  => config('collection_home_top_collections')
                ,'order' => 'COUNT(CASE WHEN collections.type = \'videos\' THEN video.videoid ELSE photos.photo_id END) DESC'
            ];

            assign('top_collections', Collection::getInstance()->getAll($params));
        }

        if( config('channelsSection') == 'yes' ){
            $params = [
                'featured' => 'yes'
                ,'limit'   => 5
            ];
            assign('featured_users', userquery::getInstance()->get_users($params));
        }

        if( config('videosSection') == 'yes' && config('playlistsSection') == 'yes' ){
            $params = [
                'limit'  => 4
                ,'order' => 'playlists.total_items DESC'
            ];
            $playlists = get_playlists([]);
            assign('playlists', activePlaylists($playlists));
        }
    }

    $min_suffixe = in_dev() ? '' : '.min';
    ClipBucket::getInstance()->addJS(['pages/index/index' . $min_suffixe . '.js'  => 'admin']);

    if( config('homepage_recent_videos_display') == 'slider' ){
        $params = Video::getInstance()->getFilterParams('most_recent', []);
        $params['limit'] = config('list_recent_videos') ?? 20;
        assign('recent_videos', Video::getInstance()->getAll($params));
    }

    if( config('home_display_featured_collections') == 'yes' ){
        $params = [
            'featured'               => 'yes'
            ,'type'                  => 'videos'
            ,'hide_empty_collection' => true
            ,'with_items'            => true
        ];
        assign('featured_collections', Collection::getInstance()->getAll($params));
    }

    template_files('index.html');
}
display_it();
