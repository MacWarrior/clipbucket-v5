<?php
define('THIS_PAGE', 'video_view_history');
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (config('enable_access_view_video_history') != 'yes' && config('enable_video_view_history') != 'yes') {
    return false;
}

$results = Video::getInstance()->getVideoViewHistory($_POST['videoid'], $_POST['page']);

pages::getInstance()->paginate($results['total_pages'], $_POST['page'], 'javascript:pageViewHistory(#page#, ' . $_POST['videoid'] . ');');

display_video_view_history([
    'results'    => $results['final_results'],
    'modal' => ($_POST['modal'] ?? true)
], $_POST['videoid']);
