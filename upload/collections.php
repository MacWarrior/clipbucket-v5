<?php
define('THIS_PAGE', 'collections');
define('PARENT_PAGE', 'collections');

require 'includes/config.inc.php';

if( !isSectionEnabled('collections') ){
    redirect_to(BASEURL);
}

pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('view_collections', true);
$sort = $_GET['sort'];

$cond = ['date_span' => mysql_clean($_GET['time'])];
if (config('enable_sub_collection')) {
    $cond['parents_only'] = true;
}

switch ($sort) {
    case 'most_recent':
    default:
        $cond['order'] = ' date_added DESC';
        break;

    case 'featured':
        $cond['featured'] = 'yes';
        break;

    case 'most_viewed':
        $cond['order'] = ' views DESC';
        break;

    case 'most_commented':
        $cond['order'] = ' total_comments DESC';
        break;

    case 'most_items':
        $cond['order'] = ' total_objects DESC';
        break;
}

//Getting Collection List
$page = $_GET['page'];
$get_limit = create_query_limit($page, config('collection_per_page'));

if (!isSectionEnabled('photos') && !isSectionEnabled('videos')) {
    $cond['type'] = 'none';
} else {
    if (!isSectionEnabled('photos')) {
        $cond['type'] = 'videos';
    } else {
        if (!isSectionEnabled('videos')) {
            $cond['type'] = 'photos';
        }
    }
}

$collection_count = $cond;
$collection_count['count_only'] = true;

$cond['limit'] = $get_limit;
if (config('hide_empty_collection') == 'yes') {
    $cond['has_items'] = true;
    $cond['show_own'] = true;
}
$collections = Collections::getInstance()->get_collections($cond);

Assign('collections', $collections);

//Collecting Data for Pagination
$total_rows = Collections::getInstance()->get_collections($collection_count);
$total_pages = count_pages($total_rows, config('collection_per_page'));

//Pagination
pages::getInstance()->paginate($total_pages, $page);

subtitle(lang('collections'));
//Displaying The Template
template_files('collections.html');
display_it();
