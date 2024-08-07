<?php
define('THIS_PAGE', 'ads_add_placements');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();
userquery::getInstance()->perm_check('ad_manager_access', true);

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Advertisement', 'url' => ''];
$breadcrumb[1] = ['title' => 'Manage Placements', 'url' => DirPath::getUrl('admin_area') . 'ads_add_placements.php'];

//Removing Placement
if (isset($_GET['remove'])) {
    $placement = mysql_clean($_GET['remove']);
    $msg = $ads_query->RemovePlacement($placement);
}

//Adding Placement
if (isset($_POST['AddPlacement'])) {
    $placement_name = mysql_clean($_POST['placement_name']);
    $placement_code = mysql_clean($_POST['placement_code']);
    $array = [$placement_name, $placement_code];
    $msg = $ads_query->AddPlacement($array);
}

//Getting List Of Placement
$sql = "SELECT * FROM " . tbl("ads_placements");
$ads_placements = db_select($sql);
$total_placements = count($ads_placements);
//Getting total Ads in each placement
for ($id = 0; $id <= $total_placements; $id++) {
    $ads_placements[$id]['total_ads'] = $adsObj->count_ads_in_placement($ads_placements[$id]['placement']);
}

$placement_info = $ads_query->get_placement_xml();

Assign('ads_placements', $ads_placements);
Assign('placement_info', $placement_info);
subtitle("Add Advertisment Placement");
template_files('ads_add_placements.html');
display_it();
