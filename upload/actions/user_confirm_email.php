<?php
const THIS_PAGE = 'user_confirm_email';
const IS_AJAX = true;
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

User::getInstance()->isUserConnectedOrRedirect();

$sql = 'SELECT * FROM ' . tbl('email_histo') . ' WHERE userid = ' . user_id() . ' AND id_email IN (SELECT id_email FROM '.tbl('email').' WHERE code = \'verify_email\') ORDER BY send_date DESC LIMIT 1';
$res = Clipbucket_db::getInstance()->_select($sql);
if (!empty($res) && (time() - strtotime($res[0]['send_date'])) < 900) {
    e(lang('email_confirm_last_sent_under_15_min'));
} elseif ((empty(trim(config('base_url'))) || !filter_var(config('base_url'), FILTER_VALIDATE_URL))) {
    e(lang('cant_perform_action_until_app_fully_updated'));
} else {
    EmailTemplate::sendMail('verify_email', User::getInstance()->getCurrentUserID(), ['avcode'=>User::getInstance()->get('avcode')]);
    e(lang('email_confirm_sent'), 'm');
}
echo json_encode(['msg' => getTemplateMsg()]);
