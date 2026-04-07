# Paypal librairie
Une librairie paypal pour une integration rapide des paiements en utilisant les CardFields du SDK javascript v5 de paypal

## Installation

Via composer
```shell
composer require oxygenzsas/composer_lib_paypal
```

## Exemple d'utilisation

### Controller PHP
```php
<?php 
require __DIR__ . '/vendor/autoload.php';

/** Paypal config et création de classe anonyme pour l'heritage */
$client = new class(
    'xxxxxxxxxxx' /* clientID */
    ,'xxxxxxxxxxxxx' /* SecretID */
    , 'https://api-m.sandbox.paypal.com' /* url API sandox vs prod */
    , 'EUR' /* devise */
    , 'https://sandbox.paypal.com/sdk/js' /* url sdk js */
    ,'http://localhost:8080' /* url de la page unique de paiement */
    , true /* active SSL */
) extends \OxygenzSAS\Paypal\Paypal {
    protected function getAmountFromAttribute(string $attribute) :int
    {
        $data = json_decode($attribute, true);
        /** @todo recuperer ici le montant du paiement a partir des données de attributes */
        return 1234; // return amount
    }
    
    protected function getAdressFromAttribute(string $attribute) :array
    {
        /** @todo recuperer ici l'adresse de facturation a partir des données de attributes */
        return [
            'name' => 'Dupond Thomas',
            'adress_line_1' => '15 rue des oliviers',
            'adress_line_2' => 'Batiment 3',
            'admin_area_2' => 'Vire',
            'admin_area_1' => 'Calvados',
            'postal_code' => '14500',
            'country_code' => 'FR'
        ];
    }
};

/** Database config (PDO) */
\OxygenzSAS\Paypal\Database::setDsn('sqlite:'.__DIR__.'/database.db');
\OxygenzSAS\Paypal\Database::setUsername(null);
\OxygenzSAS\Paypal\Database::setPassword(null);
\OxygenzSAS\Paypal\Database::setOptions([]);

/** init database if necessary */
$client->initDatabase();

/** doi etre appelé sur la page de paiement car il creer les routes sur cette meme page */
$client->initRoute();
```

### Template HTML
```HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Paypal test</title>
    <script src="/vendor/oxygenzsas/composer_lib_paypal/js/script.js"></script> <!-- @todo utiliser le script js depuis les sources composer -->
</head>
<body>

<div id="paypal-card-form">
    <div id="card-name"></div>
    <div id="card-number"></div>
    <div id="card-expiry"></div>
    <div id="card-cvv"></div>

    <button id="card-submit">Payer</button>
</div>

<script type="text/javascript">
    new PaypalCustom( {
        paypal_sdk_url: "<?php echo $client->getUrlJsSdk(); ?>"
        ,client_id: "<?php echo $client->getClientID(); ?>"
        ,currency: "<?php echo $client->getCurrency(); ?>"
        ,attributes: {id_commande: 45623} /** donnée pour identifier le paiement dans la classe paypal */
        ,url_paiement: "<?php echo $client->getUrlBack(); ?>"
    });

    document.addEventListener('paypalOrderCreated', (event) => {
        console.log('Order created:', event.detail.order);
    });

    document.addEventListener('paypalOrderCompleted', (event) => {
        console.log(`Thank you for your payment of ${event.detail.amount.value} ${event.detail.amount.currency_code}`);
    });

    document.addEventListener('paypalOrderCancelled', (event) => {
        console.log('Order cancelled!');
    });

    document.addEventListener('paypalError', (event) => {
        console.error('PayPal Error:', event.detail.message);
    });

    document.addEventListener('paypalButtonsInitialized', () => {
        console.log('PayPal buttons have been initialized and are ready for interaction.');
    });

</script>

</body>
</html>
```

### Faire un remboursement d'un paypal_capture_id
Le 4ieme paramètreest le text qui apparaitra sur les relevé bancaire des deux parties
```php
<?php 
    $client->refundCapture('xxxxxx', 5, 'EUR', 'remboursement test');
```

### Faire une nouveau paiement a partir d'un paypal_vault_id
```php
<?php 
    if($client->createOrderFromToken('xxxxx', 100, 'EUR') === false){
        throw new EXception('Echec de creation de la commande a partir du paypal_vault_id');
    }
```

## Ressources

### Documentation API REST
```
https://developer.paypal.com/docs/api/payments/v2/
```

### Documentation Standard Checkout
```
https://developer.paypal.com/docs/checkout/standard/customize/
```

### Documentation SDK JS
```
https://developer.paypal.com/sdk/js/reference/
```

### Dashboard Paypal
```
https://developer.paypal.com/dashboard/
```
#### Get client ID and client secret 
Here's how to get your client ID and client secret:

- Select Log in to Dashboard and log in or sign up.
- Select Apps & Credentials.
- New accounts come with a Default Application in the REST API apps section. To create a new project, select Create App.
- Copy the client ID and client secret for your app.



