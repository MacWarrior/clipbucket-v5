<?php
class Paypal extends \OxygenzSAS\Paypal\Paypal
{

    /** This method should return the amount for an order */
    protected function getAmountFromAttribute(string $attribute) :int
    {
        $data = json_decode($attribute, true);
        /** @todo recuperer ici le montant du paiement a partir des données de attributes */
        return 1234; // return amount
    }



}
