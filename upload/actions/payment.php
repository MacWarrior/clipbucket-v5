<?php

const THIS_PAGE = 'payment';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

/** import custom exception class destined to be catch and showed to client */
require_once dirname(__FILE__, 2) . '/includes/classes/clientvisibleexception.class.php';

/** centralisation de la création de l'objet payment */
/** @var PaymentSystemInterface $payment */
$payment = require_once dirname(__FILE__, 2).'/includes/payment_config.php';

try {

    if(empty($_REQUEST['action'] ?? '')) {
        throw new \ClientVisibleException('no action found');
    }

    $response = $payment->callAction(action: $_REQUEST['action'], userId: user_id());
} catch(\ClientVisibleException $e) {
    $response = ['success' => false , 'error' => $e->getMessage() ];
} catch(\Exception $e) {
    $response = ['success' => false /* , 'error' => $e->getMessage() */ ];
}

echo json_encode($response);