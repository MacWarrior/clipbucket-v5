<?php
define('THIS_PAGE', 'manage_social_networks');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('web_config_access');
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('configurations'), 'url'   => ''];
$breadcrumb[1] = ['title' => lang('manage_social_networks_links'), 'url'   => DirPath::getUrl('admin_area') . 'manage_social_networks.php'];

$limit = config('admin_pages');

$current_page = $_GET['page'];
$current_page = is_numeric($current_page) && $current_page > 0 ? $current_page : 1;

$curr_limit = ($current_page - 1) * $limit . ',' . $limit;

$cond = [];
if (!empty($_GET['search'])) {
    $cond[] = ' T.name LIKE \'%' . mysql_clean($_GET['search']) . '%\'';
}

if( isset($_POST['title']) && isset($_POST['url']) && isset($_POST['social_network_link_order']) && isset($_POST['id_fontawesome_icon']) ) {
    SocialNetworks::getInstance()->createSocialNetwork((int)$_POST['id_fontawesome_icon'], $_POST['title'], $_POST['url'], (int)$_POST['social_network_link_order']);
}

$params = [
    'limit' =>   $curr_limit
];

$social_network_links = SocialNetworks::getInstance()->getAll($params);
assign('social_network_links', $social_network_links);

if( empty($social_network_links) ){
    $count = 0;
} else if( count($social_network_links) < config('admin_pages') && $current_page == 1 ){
    $count = count($social_network_links);
} else {
    unset($params['limit']);
    $params['count'] = true;
    $count = SocialNetworks::getInstance()->getAll($params);
}

$total_pages = $count / $limit;
$total_pages = round($total_pages + 0.49, 0);
//Pagination
pages::getInstance()->paginate($total_pages, $current_page);

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/manage_social_networks/manage_social_networks'.$min_suffixe.'.js' => 'admin']);

$list_icons = SocialNetworks::getInstance()->getAllIcons() ?? [];
assign('list_icons', $list_icons);

subtitle(lang('manage_social_networks_links'));
template_files('manage_social_networks.html');
display_it();
