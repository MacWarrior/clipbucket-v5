<?php
define('THIS_PAGE', 'refund_transaction');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

/** centralisation de la création de l'objet PAYPAL */
/** @var \OxygenzSAS\Paypal\Paypal $paypal */
$paypal = require_once dirname(__FILE__, 2) . '/includes/paypal_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

/** @todo test brut sans securité SQL, a corriger absolument !!!! */
$sql = 'SELECT * FROM ' . $paypal->getTableNamePaypalTransaction().' WHERE id_paypal_transaction = '.$_POST['id_paypal_transaction'];
$transaction = Clipbucket_db::getInstance()->_select($sql);

$paypal->refundCapture($transaction[0]['paypal_capture_id'], $_POST['montant'], 'EUR', 'remboursement test auto');