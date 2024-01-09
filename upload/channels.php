<?php
define('THIS_PAGE', 'channels');

require 'includes/config.inc.php';

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_channels', true);

if( !isSectionEnabled('channels') ){
    redirect_to(BASEURL);
}

$assign_arry = [];
$sort = $_GET['sort'];
$u_cond = ['category' => mysql_clean($_GET['cat']), 'date_span' => mysql_clean($_GET['time'])];
switch ($sort) {
    case 'most_recent':
    default:
        $u_cond['order'] = ' doj DESC';
        break;
    case 'most_viewed':
        $u_cond['order'] = ' profile_hits DESC';
        break;
    case 'featured':
        $u_cond['featured'] = 'yes';
        break;
    case 'top_rated':
        $u_cond['order'] = ' rating DESC';
        break;
    case 'most_commented':
        $u_cond['order'] = ' total_comments DESC';
        break;
}
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, CLISTPP);
$count_query = $ulist = $u_cond;
$ulist['limit'] = $get_limit;
$users = get_users($ulist);
$counter = get_counter('channel', $count_query);

if (!$counter) {
    //Collecting Data for Pagination
    $ucount = $u_cond;
    $ucount['count_only'] = true;
    $total_rows = get_users($ucount);
    $counter = $total_rows ?: 0;
    update_counter('channel', $count_query, $counter);
}

$total_pages = count_pages($counter, CLISTPP);
//Pagination
$extra_params = null;
$tag = '<li><a #params#>#page#</a><li>';
pages::getInstance()->paginate($total_pages, $page, null, $extra_params, $tag);
subtitle(lang('channels'));
Assign('users', $users);
template_files('channels.html');
display_it();
