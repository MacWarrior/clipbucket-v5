<?php
const THIS_PAGE = 'changelog';

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('advanced_settings',true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('changelog'), 'url' => DirPath::getUrl('admin_area') . 'changelog.php'];

$changelog_tab = [
    '552' => '5.5.2',
    '551' => '5.5.1',
    '550' => '5.5.0',
    '541' => '5.4.1',
    '540' => '5.4.0',
    '531' => '5.3.1',
    '530' => '5.3.0 - 5.0.0',
];

assign('changelog_tab', $changelog_tab);
template_files('changelog.html');
display_it();
