<?php
define('THIS_PAGE', 'search_result');
require_once 'includes/config.inc.php';

pages::getInstance()->page_redir();

$page = $_GET['page'];
$type = strtolower($_GET['type']);
if (!in_array($type, ['videos', 'photos', 'collections', 'channels'])) {
    $type = 'videos';
}
switch($type){
    case 'videos':
        $access_public_video = (User::getInstance()->hasPermission('allow_public_video_page') && config('enable_public_video_page') == 'yes');
        $access_video = (User::getInstance()->hasPermission('view_' . $type) && isSectionEnabled($type));
        if (!$access_video && !$access_public_video) {
            redirect_to(BASEURL);
        }
        break;
    case 'photos':
    case 'collections':
    case 'channels':
        break;
}

if (!User::getInstance()->hasPermission('view_' . $type) || !isSectionEnabled($type)) {
    redirect_to(DirPath::getUrl('root'));
}

$params = [];
$params['search'] = $_GET['query'];
$params['ban_status'] = 'no';

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
        $params['channel_enable'] = true;
        $params['not_userid'] =  userquery::getInstance()->get_anonymous_user();
        break;
}

$params = [];
if ($access_public_video && !$access_video) {
    $params['public'] = true;
}
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

template_files('search.html');
display_it();
