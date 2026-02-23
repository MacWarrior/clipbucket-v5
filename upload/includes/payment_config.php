<?php

/** CONFIG PAYPAL */
global $PAYPAL_CLIENT_ID, $PAYPAL_SECRET_ID; /** @todo actuellement dans config.php, a deplacer dans une config bdd */

require_once DirPath::get('classes') . 'payment/paypal/paypal.class.php';
$paypal = new Paypal([
    'paypal_client_id' => $PAYPAL_CLIENT_ID /* clientID */
    ,'paypal_secret_id' => $PAYPAL_SECRET_ID /* SecretID */
    ,'url_api' => 'https://api-m.sandbox.paypal.com' /* url API sandox vs prod */
    ,'currency' => 'EUR' /* devise */
    ,'url_sdk' => 'https://sandbox.paypal.com/sdk/js' /* url sdk js */
    ,'url_payment_page' => DirPath::getUrl('root').'/manage_membership.php' /* url de la page unique de paiement */
    ,'active_ssl' =>  true /* active SSL */
    ,'tablename_paypal_transactions' => tbl('paypal_transactions') /*  table name for transaction */
    ,'tablename_paypal_transactions_logs' => tbl('paypal_transactions_logs') /* table name for log of transaction */
    ,'tablename_paypal_vault' => tbl('paypal_vault') /* table name for vault card */
]);

return new Payment(instance_payment: $paypal);

/*
global $DBHOST, $DBNAME, $DBUSER, $DBPASS, $DBPORT;
\OxygenzSAS\Paypal\Database::setDsn('mysql:host='.$DBHOST.';dbname='.$DBNAME.';port='.($DBPORT ?? '3306').';charset=utf8mb4');
\OxygenzSAS\Paypal\Database::setUsername($DBUSER);
\OxygenzSAS\Paypal\Database::setPassword($DBPASS);
\OxygenzSAS\Paypal\Database::setOptions([]);
$paypal->initRoute();
*/