<?php

const THIS_PAGE = 'set_membership';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

/** import custom exception class destined to be catch and showed to client */
require_once dirname(__FILE__, 2) . '/includes/classes/clientvisibleexception.class.php';

/** centralisation de la création de l'objet payment */
/** @var PaymentSystemInterface $payment */
$payment = require_once dirname(__FILE__, 2).'/includes/payment_config.php';

try {

    $userid = user_id();
    if($userid == false) {
        throw new Exception('User is needed');
    }

    /** verifier si un abonnement actif existe deja */
    if(User::getInstance()->isUserHasActiveMembership($userid)){
        throw new ClientVisibleException(lang('user_has_already_membership_active'));
    }

    /** recupération du membership actuellement en "in_progress" si il existe */
    $histoMemberships = Membership::getInstance()->getAllHistoMembershipForUser([
        'userid'     => $userid,
        'language_key_title'   => 'in_progress',
        'limit'      => '1'
    ]);

    $nb_transaction = 0;
    if(!empty($histoMemberships)) {
        $nb_transaction = count($payment->getAllTransaction(
            idUserMembership: $histoMemberships[0]['id_user_membership']
        ));
    }

    if(
        !empty($histoMemberships)
        && $histoMemberships[0]['id_membership'] != $_POST['id_membership']
        && $nb_transaction >= 1
    ) {
        /** set old histoMembership to "canceled" */
        Membership::getInstance()->updateHistoMembership([
            'id_user_membership' => $histoMemberships[0]['id_user_membership'],
            /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
            'id_user_memberships_status' => 3 /* canceled */
        ]);

        $histoMemberships = null;
    }

    if(empty($histoMemberships)) {
        $id_user_membership = Membership::getInstance()->insertHistoMembership([
            'userid' => $userid,
            'id_membership' => (int) $_POST['id_membership'],
            /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
            'id_user_memberships_status' => 1 /* in_progress */
        ]);
    }
    elseif($nb_transaction == 0)
    {
        /** set old histoMembership to "canceled" */
        Membership::getInstance()->updateHistoMembership([
            'id_user_membership' => $histoMemberships[0]['id_user_membership'],
            'id_membership' => (int) $_POST['id_membership'],
            /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
            'id_user_memberships_status' => 1 /* in_progress */
        ]);

        $id_user_membership = $histoMemberships[0]['id_user_membership'];
    } else {
        throw new Exception('impossible case reach, but forbidden cause there is already some transaction for this userMembership');
    }

    if($id_user_membership === false) {
        throw new Exception('Insert failed');
    }

    $histoMemberships = Membership::getInstance()->getAllHistoMembershipForUser([
        'userid'     => $userid,
        'id_user_membership'   => $id_user_membership,
        'limit'      => '1'
    ]);
    $amount = $histoMemberships[0]['base_price'];
    $currency = $histoMemberships[0]['code_currency'];
    $symbol = $histoMemberships[0]['symbol'];

    $response = ['success' => true
        ,'id_user_membership' => $id_user_membership
        , 'amount' => $amount
        , 'currency' => $currency
        , 'symbol' => $symbol
    ];

} catch(\ClientVisibleException $e) {
    $response = ['success' => false , 'error' => $e->getMessage() ];
} catch(\Exception $e) {
    $response = ['success' => false /* , 'error' => $e->getMessage() */ ];
}

echo json_encode($response);