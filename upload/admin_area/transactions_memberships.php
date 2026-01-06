<?php
define('THIS_PAGE', 'membership_user_levels');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('admin_access');

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('memberships'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('transactions'),
    'url'   => DirPath::getUrl('admin_area') . 'transactions_memberships.php'
];


$sql = 'SELECT * FROM ' . cb_sql_table('paypal_transactions').' ORDER BY id_paypal_transaction DESC';
$transactions_memberships = Clipbucket_db::getInstance()->_select($sql);
assign('transactions_memberships', $transactions_memberships);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS([
    'pages/membership/transactions_memberships' . $min_suffixe . '.js' => 'admin',
]);

subtitle(lang('transactions'));
template_files('transactions_memberships.html');
display_it();
