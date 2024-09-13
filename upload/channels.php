<?php
define('THIS_PAGE', 'channels');
require 'includes/config.inc.php';

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_channels', true);

if( !isSectionEnabled('channels') ){
    redirect_to(BASEURL);
}

$params = User::getInstance()->getFilterParams($_GET['sort'], []);
$params = User::getInstance()->getFilterParams($_GET['time'], $params);


if( config('enable_user_category') == 'yes' && !empty($_GET['cat']) ){
    $params['category'] = (int)$_GET['cat'];
}

if (isset($_GET['no_user']) && $_GET['no_user'] == 1) {
    e(lang('usr_exist_err'));
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
