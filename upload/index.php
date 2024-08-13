<?php
error_reporting(-1);
ini_set('display_errors', 1);

define('THIS_PAGE', 'index');
require 'includes/config.inc.php';
global $pages, $userquery;
$pages->page_redir();
$anonymous_id = $userquery->get_anonymous_user();
assign('anonymous_id', $anonymous_id);
if (!$userquery->perm_check('view_videos', false, false, true) && !user_id()) {
    template_files('signup_or_login.html');
} else {
    if( config('collectionsSection') == 'yes' && (config('videosSection') == 'yes' || config('photosSection') == 'yes') ) {
        $params = [
            'limit'   => config('collection_home_top_collections')
            , 'order' => 'COUNT(CASE WHEN collections.type = \'videos\' THEN video.videoid ELSE photos.photo_id END) DESC'
        ];

        assign('top_collections', Collection::getInstance()->getAll($params));
    }

    $min_suffixe = in_dev() ? '' : '.min';
    ClipBucket::getInstance()->addJS(['pages/index/index' . $min_suffixe . '.js'  => 'admin']);


    $page = mysql_clean($_GET['page']);
    $get_limit = create_query_limit($page, config('videos_list_per_page'));
    $params = Video::getInstance()->getFilterParams($_GET['sort'], []);
    $params = Video::getInstance()->getFilterParams($_GET['time'], $params);
    $params['limit'] = $get_limit;
    $videos = Video::getInstance()->getAll($params);
    assign('videos', $videos);

    template_files('index.html');
}
display_it();
