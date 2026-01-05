<?php
define('THIS_PAGE', 'get_membership_history');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

if (!empty($_POST['page'])) {
    $sql_limit = create_query_limit($_POST['page'], config('video_list_view_video_history'));
}
$params = [
    'userid' => $_POST['userid'],
    'limit'   => $sql_limit ?? '',
    'order'  => ' date_start DESC '
];
$results = Membership::getInstance()->getAllHistoMembershipForUser($params);
$params['count'] = true;
unset($params['limit']);
$totals_pages = count_pages(Membership::getInstance()->getAllHistoMembershipForUser($params), config('video_list_view_video_history')) ;
pages::getInstance()->paginate($totals_pages, $_POST['page'], 'javascript:pageViewHistory(#page#, ' . $_POST['userid'] . ');');

display_user_membership_history([
    'results' => $results,
    'modal'   => ($_POST['modal'] ?? true)
], $_POST['userid']);
