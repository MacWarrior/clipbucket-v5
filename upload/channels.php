<?php
define('THIS_PAGE', 'channels');

require 'includes/config.inc.php';

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_channels', true);

if( !isSectionEnabled('channels') ){
    redirect_to(BASEURL);
}

$params = [];

$conditions = [];
if( !empty($_GET['cat']) ){
    $conditions[] = 'categories.category_id = ' . (int)$_GET['cat'];
}

if( !empty($_GET['time']) ){
    $conditions[] = Search::date_margin('users.doj', $_GET['time']);
}

$sort = $_GET['sort'] ?? '';
switch ($sort) {
    case 'most_recent':
    default:
        $params['order'] = 'users.doj DESC';
        break;
    case 'most_viewed':
        $params['order'] = 'users.profile_hits DESC';
        break;
    case 'featured':
        $conditions[] = 'users.featured = \'yes\'';
        break;
    case 'top_rated':
        $params['order'] = 'user_profile.rating DESC';
        break;
    case 'most_commented':
        $params['order'] = 'users.total_comments DESC';
        break;
}

$params['condition'] = implode(' AND ', $conditions);

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
Assign('users', $users);
template_files('channels.html');
display_it();
