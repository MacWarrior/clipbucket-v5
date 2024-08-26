<?php
define('THIS_PAGE', 'search_result');
require_once 'includes/config.inc.php';

pages::getInstance()->page_redir();

$page = $_GET['page'];
$type = strtolower($_GET['type']);

switch($type){
    default:
        $type = 'videos';
        break;
    case 'videos':
    case 'photos':
    case 'collections':
    case 'channels':
        break;
}

if (!userquery::getInstance()->perm_check('view_' . $type, true) || !isSectionEnabled($type)) {
    redirect_to(BASEURL);
}

switch($type) {
    case 'videos':
        $obj = Video::getInstance();

        break;
    case 'photos':
        $obj = Photo::getInstance();
        break;

    case 'collections':
        $obj = Collection::getInstance();
        break;

    case 'channels':
        $obj = User::getInstance();
        break;
}

$params = [];
$params['search'] = $_GET['query'];
$params['limit'] = create_query_limit($page, $obj->getSearchLimit());
$results = $obj->getAll($params);

unset($params['limit']);
$params['count'] = true;
$total_rows = $obj->getAll($params);
$total_pages = count_pages($total_rows, $obj->getSearchLimit());

assign('template_var', $obj->getDisplayVarName());
assign('display_template', $obj->getDisplayBlock());

//Pagination
pages::getInstance()->paginate($total_pages, $page);

assign('type', $type);
assign('results', $results);
assign('search_type_title', lang('searching_keyword_in_obj', [display_clean($_GET['query']), strtolower(lang($type))]));

if (get('query')) {
    $squery = get('query');
    if ($squery == 'clipbucket') {
        subtitle('Awesomeness...!!');
    } else {
        subtitle(lang($type) . ' : ' . display_clean($_GET['query']));
    }
}

//Displaying The Template
template_files('search.html');
display_it();

