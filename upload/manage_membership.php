<?php
define('THIS_PAGE', 'manage_membership');

require 'includes/config.inc.php';

/** centralisation de la création de l'objet PAYPAL */
/** @var \OxygenzSAS\Paypal\Paypal $paypal */
$paypal = require_once 'includes/paypal_config.php';
assign('paypal', $paypal);

User::getInstance()->isUserConnectedOrRedirect();

if( config('enable_membership') != 'yes' ){
    redirect_to(cblink(['name' => 'my_account']));
}

assign('mode', 'membership');
if (!empty($_POST['page'])) {
    $sql_limit = create_query_limit($_POST['page'], config('video_list_view_video_history'));
}
$params['count'] = true;
unset($params['limit']);
$memberships = Membership::getInstance()->getAllHistoMembershipForUser($params);
assign('memberships', $memberships);
$totals_pages = count_pages(Membership::getInstance()->getAllHistoMembershipForUser($params), config('video_list_view_video_history')) ;

$available_memberships = Membership::getInstance()->getAll([
    'is_disabled'       => 0,
    'not_user_level_id' => UserLevel::getDefaultId()
]);
$can_renew_membership = false;
foreach ($available_memberships as $key => $available_membership) {
    if ($available_membership['user_level_id'] == User::getInstance()->getCurrentUserLevelID()) {
        $can_renew_membership = true;
        break;
    }
    if (!empty($available_membership['allowed_emails']) && $available_membership['only_visible_eligible']) {
        $allowed_emails = explode(',', strtolower($available_membership['allowed_emails']));
        if (!in_array(strtolower(User::getInstance()->get('email')), $allowed_emails)) {
            unset($available_memberships[$key]);
        }
    }
}

$min_suffixe = System::isInDev() ? '' : '.min';

/** load js from composer vendor */
ClipBucket::getInstance()->addJS(['oxygenzsas'.DIRECTORY_SEPARATOR.'composer_lib_paypal'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'script.js' => 'vendor']);

/** load js and css */
ClipBucket::getInstance()->addJS(['payment' . $min_suffixe . '.js'  => 'admin']);
ClipBucket::getInstance()->addCSS(['payment' . $min_suffixe . '.css'  => 'admin']);

subtitle(lang('user_manage_my_account'));
assign('available_memberships', $available_memberships);
assign('can_renew_membership', $can_renew_membership);
template_files('manage_membership.html');

display_it();
