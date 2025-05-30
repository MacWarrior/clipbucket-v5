<?php
define('THIS_PAGE', 'admin_tool');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('advanced_settings',true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('admin_tool'), 'url' => DirPath::getUrl('admin_area') . 'admin_tool.php'];
$tool = null;
if (Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.0', '367')) {
    $can_sse = System::can_sse() ? 'true' : 'false';
    if (!empty($_GET['code_tool'])) {
        $tool = new AdminTool();
        $tool->initByCode($_GET['code_tool']);
    }
} else {
    $can_sse = 'false';
    if (!empty($_GET['id_tool'])) {
        $tool = new AdminTool();
        $tool->initById($_GET['id_tool']);
    }
}
assign('can_sse', $can_sse);
sendClientResponseAndContinue(function () use ($tool){
    if ($tool && $tool->isAlreadyLaunch() === false) {
        $tool->setToolInProgress();
    }
    $admin_tool_list = AdminTool::getAllTools();
    assign('admin_tool_list', $admin_tool_list);

    $min_suffixe = System::isInDev() ? '' : '.min';
    ClipBucket::getInstance()->addAdminJS(['pages/admin_tool/admin_tool' . $min_suffixe . '.js' => 'admin']);

    subtitle(lang('admin_tool'));
    template_files('admin_tool.html');
    display_it();
});

if ($tool && $tool->isAlreadyLaunch() === false) {
    //execute tool
    $tool->launch();
}
