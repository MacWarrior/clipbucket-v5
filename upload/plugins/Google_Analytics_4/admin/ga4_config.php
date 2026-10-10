<?php
const THIS_PAGE = 'ga4_config';
require_once dirname(__DIR__, 3) . '/includes/admin_config.php';

$breadcrumb[0] = ['title' => lang('configurations'), 'url' => ''];
$breadcrumb[1] = [
    'title' => 'Google Analytics 4',
    'url' => DirPath::getUrl('plugins') . 'Google_Analytics_4/admin/ga4_config.php'
];

pages::getInstance()->page_redir();

if (isset($_POST['update'])) {
    try {
        ga4::getInstance();
        ga4::updateConfig($_POST['enabled'] ?? 'no', $_POST['measurement_id'] ?? '');
        e('Google Analytics 4 settings have been updated.', 'm');
    } catch (Exception $e) {
        e($e->getMessage(), 'e');
    }
}

$config = ga4::getConfig();
assign('ga4_enabled', $config['enabled'] ?? 'no');
assign('ga4_measurement_id', $config['measurement_id'] ?? '');

subtitle('Google Analytics 4');
template_files('ga4_config.html', DirPath::get('plugins') . basename(dirname(__DIR__)) . '/admin/');
display_it();
