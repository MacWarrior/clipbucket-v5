<?php
define('THIS_PAGE', 'renew_transaction');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

/** centralisation de la création de l'objet PAYPAL */
/** @var \OxygenzSAS\Paypal\Paypal $paypal */
$paypal = require_once dirname(__FILE__, 2) . '/includes/payment_config.php';

User::getInstance()->hasPermissionAjax('admin_access');

$sql = 'SELECT * FROM ' . $paypal->getTableNamePaypalTransaction().' WHERE id_paypal_transaction = \''.mysql_clean($_POST['id_paypal_transaction']).'\'';
$transaction = Clipbucket_db::getInstance()->_select($sql);

if($paypal->createOrderFromToken($transaction[0]['paypal_vault_id'], $_POST['montant'], 'EUR', $transaction[0]['paypal_customer_id']) === false){
    throw new EXception('Echec de creation de la commande a partir du paypal_vault_id');
}
