<?php
require_once '../includes/admin_config.php';
require_once('../includes/classes/admin_tool.class.php');
/* Generating breadcrumb */
global $breadcrumb, $pages, $userquery, $Cbucket;

$userquery->admin_login_check();
$userquery->login_check('web_config_access');
$pages->page_redir();

$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('admin_tool'), 'url' => DirPath::getUrl('admin_area') . 'admin_tool.php'];
sendClientResponseAndContinue(function () use ($Cbucket) {
    if (!empty($_GET['id_tool'])) {
        AdminTool::setToolInProgress($_GET['id_tool']);
    }
    $admin_tool_list = AdminTool::getAllTools();
    assign('admin_tool_list', $admin_tool_list);

    if (in_dev()) {
        $min_suffixe = '';
    } else {
        $min_suffixe = '.min';
    }
    ClipBucket::getInstance()->addAdminJS(['pages/admin_tool/admin_tool' . $min_suffixe . '.js' => 'admin']);

    subtitle(lang('admin_tool'));
    template_files('admin_tool.html');
    display_it();
});

if (!empty($_GET['id_tool'])) {
    //execute tool
    AdminTool::launch($_GET['id_tool']);
}
