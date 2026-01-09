<?php
class Paypal extends \OxygenzSAS\Paypal\Paypal
{

    public function getAttribute(string $attribute) {
        return json_decode($attribute, true);
    }

    /** This method should return the amount for an order */
    protected function getAmountFromAttribute(string $attribute) :int
    {
        $attribute = $this->getAttribute($attribute);

        /** @todo recuperer ici le montant du paiement a partir des données de attributes */
        return '1234.00'; // return amount
    }

    /** This method should return the billing address */
    protected function getAdressFromAttribute(string $attribute) :array
    {
        $attribute = $this->getAttribute($attribute);

        /** @todo recuperer ici l'adresse de facturation a partir des données de attributes */
        return [
            'name' => 'Dupond Thomas',
            'adress_line_1' => '15 rue des oliviers',
            'adress_line_2' => 'Batiment 3',
            'admin_area_1' => 'Vire',
            'admin_area_2' => 'Calvados',
            'postal_code' => '14500',
            'country_code' => 'FR'
        ];
    }

    /** This method should return true if the card must be saved */
    protected function isCardShouldBeSaved(string $attribute) :bool
    {
        $attribute = $this->getAttribute($attribute);
        return $attribute['saveCard'] ?? false;
    }

    protected function createOrderSuccess($response, string $attribute) :void
    {
        $attribute = $this->getAttribute($attribute);

        /** @todo lier la transaction paypal a une commande clipbucket */

        /** @todo mettre a jour le statut de renewAuto present dans les attributes */

        /** @todo enregistrer la carte en bdd si besoin. verif dans l'attribute le besoin et dans le response les datas  */
/*
        cb_user_memberships :: in_progress
         cb_user_memberships_transactions :: lier transaction a clipbucket (id_user_membership :: id_paypal_transaction)
*/
    }

    protected function createOrderError($error, string $attribute) :void
    {
        // TODO: Implement createOrderError() method.

        /** @todo lier la transaction paypal a une commande clipbucket */
/*
        cb_user_memberships :: failed
         cb_user_memberships_transactions :: lier transaction a clipbucket (id_user_membership :: id_paypal_transaction)
*/
    }

    protected function completeOrderSuccess($response, string $attribute) :void
    {
        // TODO: Implement completeOrderSuccess() method.

        /** @todo lier la transaction paypal a une commande clipbucket */
/*
        cb_user_memberships :: completed
         cb_user_memberships_transactions :: lier transaction a clipbucket (id_user_membership :: id_paypal_transaction)
*/
    }

    protected function completeOrderError($error, string $attribute) :void
    {
        // TODO: Implement completeOrderError() method.
/*
        cb_user_memberships :: failed
         cb_user_memberships_transactions :: lier transaction a clipbucket (id_user_membership :: id_paypal_transaction)
*/
    }

    protected function beforeCreateOrder(string $attribute) :void
    {
        // TODO: Implement isTransactionAlreadyPayed() method.
        /** @todo verifier a partir des attributes si la transaction a deja été payé */

        /** @todo verifier si le user est bien le proprietaire de la commande par securité
         * pour eviter qu'un hackeur lance des payement de commande/ capture sur plein d'id
         */

        /** @todo verifier que le montant n'a pas changé !!!!!  entre le id_membership et les attributes */

        if(false) {
            http_response_code(422);
            echo json_encode(['status' => 'error','error' => 'Already payed']);
            die();
        }

    }

    protected function beforeCompleteOrder(string $attribute) :void
    {
        // TODO: Implement beforeCompleteOrder() method.
    }
}
