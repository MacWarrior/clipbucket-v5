<?php
/** CONFIG PAYPAL */
global $PAYPAL_CLIENT_ID, $PAYPAL_SECRET_ID; /** @todo actuellement dans config.php, a deplacer dans une config bdd */
$paypal = new Paypal(
    $PAYPAL_CLIENT_ID /* clientID */
    ,$PAYPAL_SECRET_ID /* SecretID */
    , 'https://api-m.sandbox.paypal.com' /* url API sandox vs prod */
    , 'EUR' /* devise */
    , 'https://sandbox.paypal.com/sdk/js' /* url sdk js */
    ,DirPath::getUrl('root').'/manage_membership.php' /* url de la page unique de paiement */
    , true /* active SSL */
    , tbl('paypal_transactions') /*  table name for transaction */
    , tbl('paypal_transactions_logs') /* table name for log of transaction */
);

/**
 * @todo init bdd si necessaire, a nettoyer et deplacer au bon endroit
 */
global $DBHOST, $DBNAME, $DBUSER, $DBPASS, $DBPORT;
\OxygenzSAS\Paypal\Database::setDsn('mysql:host='.$DBHOST.';dbname='.$DBNAME.';port='.($DBPORT ?? '3306').';charset=utf8mb4');
\OxygenzSAS\Paypal\Database::setUsername($DBUSER);
\OxygenzSAS\Paypal\Database::setPassword($DBPASS);
\OxygenzSAS\Paypal\Database::setOptions([]);
$paypal->initRoute();


return $paypal;