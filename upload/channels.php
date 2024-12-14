<?php
define('THIS_PAGE', 'channels');
require 'includes/config.inc.php';

User::getInstance()->hasPermissionOrRedirect('view_channels');
pages::getInstance()->page_redir();

if( !isSectionEnabled('channels') ){
    redirect_to(get_server_url());
}
$params = [
    'featured'       => 'yes',
    'channel_enable' => 'yes',
    'limit'          => 5
];
assign('featured_users', User::getInstance()->getAll($params));

$params = User::getInstance()->getFilterParams($_GET['sort'], []);
$params = User::getInstance()->getFilterParams($_GET['time'], $params);


if( config('enable_user_category') == 'yes' && !empty($_GET['cat']) ){
    $params['category'] = (int)$_GET['cat'];
}

$params['channel_enable'] = true;
$params['count'] = true;
$count = User::getInstance()->getAll($params);

unset($params['count']);
$page = $_GET['page'] ?? 0;
$params['limit'] = create_query_limit($page, config('channels_list_per_page'));
$users = User::getInstance()->getAll($params);

$total_pages = count_pages($count, config('channels_list_per_page'));
//Pagination
$extra_params = null;
$tag = '<li><a #params#>#page#</a><li>';
pages::getInstance()->paginate($total_pages, $page, null, $extra_params, $tag);
subtitle(lang('channels'));
assign('users', $users);

assign('sort_list', User::getInstance()->getSortList());
assign('time_list', time_links());

template_files('channels.html');
display_it();
