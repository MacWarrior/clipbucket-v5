<?php
class Paypal extends \OxygenzSAS\Paypal\Paypal
{

    /** This method should return the amount for an order */
    protected function getAmountFromAttribute(string $attribute) :int
    {
        $data = json_decode($attribute, true);
        /** @todo recuperer ici le montant du paiement a partir des données de attributes */
        return '1234.00'; // return amount
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
}
