<?php

const THIS_PAGE = 'user_set_billing_adress';
require_once dirname(__FILE__, 2) . '/includes/config.inc.php';

try {

    $userid = user_id();
    if($userid == false) {
        throw new Exception('User is needed');
    }

    $id_user_billing_address = (User::getInstance())->setBillingAdress(
        [
            'userid'=> $userid
            ,'billing_name'=> $_POST['billing_name']
            ,'billing_address_line_1'=> $_POST['billing_address_line_1']
            ,'billing_address_line_2'=> $_POST['billing_address_line_2']
            ,'billing_admin_area_1'=> $_POST['billing_admin_area_1']
            ,'billing_admin_area_2'=> $_POST['billing_admin_area_2']
            ,'billing_postal_code'=> $_POST['billing_postal_code']
            ,'billing_country_code'=> $_POST['billing_country_code']
        ]
    );

    if($id_user_billing_address === false) {
        $error = errorhandler::getInstance()->get_error();
        $response = ['success' => false , 'error' => $error[0]['val'] ?? null ];
    } else {

        /** save chosen billing address if necessary */
        if(!empty($_POST['id_user_membership'] ?? null)) {
            Membership::getInstance()->updateHistoMembership([
                'id_user_billing_address' => $id_user_billing_address
                ,'id_user_membership' => $_POST['id_user_membership']
                ,'userid' => $userid
            ]);
        }

        $response = ['success' => true];
    }

} catch(\Exception $e) {
    $response = ['success' => false /*, 'error' => $e->getMessage() */];
}

echo json_encode($response);