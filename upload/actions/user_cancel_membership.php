<?php

const THIS_PAGE = 'user_cancel_membership';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

/** import custom exception class destined to be catch and showed to client */
require_once dirname(__FILE__, 2) . '/includes/classes/clientvisibleexception.class.php';

try {

    $userid = user_id();
    if($userid == false) {
        throw new Exception('User is needed');
    }

    /** recupération du membership actuellement en "completed" si il existe */
    $histoMemberships = Membership::getInstance()->getAllHistoMembershipForUser([
        'userid'     => $userid,
        'date_between'        => date('Y-m-d H:i:s'),
        'language_key_title'   => 'completed',
        'order'      => 'date_start DESC',
        'limit'      => '1'
    ]);

    if(empty($histoMemberships)) {
        throw new ClientVisibleException(lang('no_membership_active_found'));
    }

    Membership::getInstance()->updateHistoMembership([
        'id_user_membership' => $histoMemberships[0]['id_user_membership']
        /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
        ,'id_user_memberships_status' => 3 /* canceled */
    ]);

    $response = ['success' => true];

} catch(\ClientVisibleException $e) {
    $response = ['success' => false , 'error' => $e->getMessage() ];
} catch(\Exception $e) {
    $response = ['success' => false /* , 'error' => $e->getMessage() */ ];
}

echo json_encode($response);