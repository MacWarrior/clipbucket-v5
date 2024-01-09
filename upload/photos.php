<?php
define('THIS_PAGE', 'photos');
define('PARENT_PAGE', 'photos');

require 'includes/config.inc.php';

if( !isSectionEnabled('photos') ){
    redirect_to(BASEURL);
}

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_photos', true);

$sort = $_GET['sort'];
$cond = ['category' => mysql_clean($_GET['cat']), 'date_span' => $_GET['time']];
if (!has_access('admin_access',true)) {
    $cond[] = ['active' => 'yes'];
}
$table_name = 'photos';
$cond = build_sort_photos($sort, $cond);
$page = mysql_clean($_GET['page']);

$clist = $cond;
$clist['limit'] = create_query_limit($page, MAINPLIST);
$photos = get_photos($clist);

//Collecting Data for Pagination
$ccount = $cond;
$ccount['count_only'] = true;
$total_rows = get_photos($ccount);
$total_pages = count_pages($total_rows, MAINPLIST);
//Pagination
pages::getInstance()->paginate($total_pages, $page);

assign('photos', $photos);
subtitle(lang('photos'));
//Displaying The Template
template_files('photos.html');
display_it();
