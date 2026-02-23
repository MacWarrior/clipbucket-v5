<?php

const THIS_PAGE = 'user_reenable_membership';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

/** import custom exception class destined to be catch and showed to client */
require_once dirname(__FILE__, 2) . '/includes/classes/clientvisibleexception.class.php';

try {

    $userid = user_id();
    if($userid == false) {
        throw new Exception('User is needed');
    }

    /** recupération du membership actuellement en "completed" si il existe */
    $histoMemberships = Membership::getInstance()->getCurrentMembershipForUser($userid);

    if(empty($histoMemberships)) {
        throw new ClientVisibleException(lang('no_membership_active_found'));
    }

    /** verifier que l'histo recuperer a bien été completed dans le passé ( check transaction ) */
    if(Membership::getInstance()->isUserMembershipHasAlreadyHaveCompletedTransactionInHisHistory($histoMemberships['id_user_membership'])) {
        throw new ClientVisibleException(lang('this_membership_has_never_been_completed'));
    }

    Membership::getInstance()->updateHistoMembership([
        'id_user_membership' => $histoMemberships['id_user_membership']
        /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
        ,'id_user_memberships_status' => 2 /* completed */
    ]);

    $response = ['success' => true];

} catch(\ClientVisibleException $e) {
    $response = ['success' => false , 'error' => $e->getMessage() ];
} catch(\Exception $e) {
    $response = ['success' => false /* , 'error' => $e->getMessage() */ ];
}

echo json_encode($response);