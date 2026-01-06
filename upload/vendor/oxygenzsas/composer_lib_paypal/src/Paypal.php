<?php

namespace OxygenzSAS\Paypal;

abstract class Paypal
{

    protected $clientID;
    protected $secretID;
    protected $api;
    public $active_ssl;
    /**
     * @var mixed
     */
    private $urlJsSdk;
    /**
     * @var mixed
     */
    private $url_back;
    /**
     * @var mixed
     */
    private $currency;
    
    private $table_name_paypal_transaction;
    private $table_name_paypal_transaction_logs;

    public function __construct($clientID, $secretID, $api, $currency, $urlJsSdk, $url_back, $active_ssl = true, $table_name_paypal_transaction = 'paypal_transactions', $table_name_paypal_transaction_logs = 'paypal_transactions_logs') {
        $this->clientID = $clientID;
        $this->secretID = $secretID;
        $this->api = $api;
        $this->active_ssl = $active_ssl;
        $this->url_back = $url_back;
        $this->urlJsSdk = $urlJsSdk;
        $this->currency= $currency;
        $this->table_name_paypal_transaction = $table_name_paypal_transaction;
        $this->table_name_paypal_transaction_logs = $table_name_paypal_transaction_logs;
    }

    // Crée une commande et renvoie la réponse en JSON.
    public function createOrder($amount, $devise, $name, $adress_line_1, $adress_line_2, $admin_area_2, $admin_area_1, $postal_code, $country_code )
    {
        try {
            $accessToken = $this->getAccessToken();

            // ✅ VERSION BACKEND 100% CORRECTE (AVEC TOKEN)
            $orderData = [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => $devise,
                        'value' => number_format($amount, 2, '.', '')
                    ]
                ]],
                "payment_source" => [
                    "card" => [
                        "name"=> $name,
                        "billing_address"=> [
                            "address_line_1"=> $adress_line_1,
                            "address_line_2"=> $adress_line_2,
                            "admin_area_2"=> $admin_area_2,
                            "admin_area_1"=> $admin_area_1,
                            "postal_code"=> $postal_code,
                            "country_code"=> $country_code
                        ],
                        "attributes" => [
                            "vault" => [
                                "store_in_vault" => "ON_SUCCESS"
                            ],
                            "verification" => [
                                "method" => "SCA_ALWAYS"
                            ]
                        ]
                    ]
                ]
            ];

            $orderDataJson = json_encode($orderData);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->api.'/v2/checkout/orders');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $orderDataJson);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->active_ssl);

            $response = curl_exec($ch);

            curl_close($ch);

            $json = json_decode($response, true);

            Database::getInstance()->query(/** @lang SQL */'
                INSERT INTO '.$this->table_name_paypal_transaction.' (type, paypal_order_id, status, amount, currency) 
                VALUES (\'payment\', :paypal_order_id, :status, :amount, :currency)
            ', [
                ':paypal_order_id' =>  $json['id'],
                ':status' => $json['status'],
                ':amount' => $amount,
                ':currency' => $devise,
            ]);

            $id_paypal_transaction = Database::getInstance()->getLastInsertId();
            $this->addLog($response, $id_paypal_transaction);

            echo json_encode(['id' => $json['id']]);

        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Crée une commande et renvoie la réponse en JSON.
    public function createOrderFromToken($paypal_vault_id, $amount, $devise, $paypal_customer_id = null)
    {
        try {
            $accessToken = $this->getAccessToken();

            $orderData = [
                'intent' => 'CAPTURE',

                "payment_source" => [
                    "token"=> [
                        "type" => 'PAYMENT_METHOD_TOKEN',
                        "id" => $paypal_vault_id
                    ]
                ],

                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $devise,
                            'value' => $amount
                        ]
                    ]
                ]
            ];

            $orderDataJson = json_encode($orderData);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->api.'/v2/checkout/orders');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $orderDataJson);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->active_ssl);

            $response = curl_exec($ch);

            curl_close($ch);

            $json = json_decode($response, true);

            Database::getInstance()->query(/** @lang SQL */'
                INSERT INTO '.$this->table_name_paypal_transaction.' (type, paypal_capture_id,status,amount,net_amount,paypal_fee,currency,paypal_customer_id,paypal_account_id,paypal_vault_id,update_time,paypal_order_id)
                VALUES(\'payment\', :paypal_capture_id,:status,:amount,:net_amount,:paypal_fee,:currency,:paypal_customer_id,:paypal_account_id,:paypal_vault_id,:update_time,:paypal_order_id)
            ', [
                ':paypal_order_id' =>  $json['id'],
                ':paypal_customer_id' => $paypal_customer_id ?? null,
                ':paypal_vault_id' =>  $paypal_vault_id,
                ':paypal_account_id' => $json['payer']['payer_id'],
                ':paypal_capture_id' =>  $json['purchase_units'][0]['payments']['captures'][0]['id'],
                ':status' => $json['status'],
                ':currency' => $json['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
                ':amount' => $json['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                ':net_amount' => $json['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'],
                ':paypal_fee' => $json['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'],
                ':update_time' => $this->convertPayPalDateToMySQL($json['purchase_units'][0]['payments']['captures'][0]['update_time'])
            ]);
            $id_paypal_transaction = Database::getInstance()->getLastInsertId();
            $this->addLog($response, $id_paypal_transaction);

            return $json['status'] == 'COMPLETED';

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }


    public function completeOrder($order_id) {
        try {
            $accessToken = $this->getAccessToken();
            $orderId = $order_id;
            $intent = strtolower('CAPTURE'); // Par exemple 'capture' ou 'CAPTURE'

            // URL de l'API pour compléter la commande
            $url = $this->api."/v2/checkout/orders/{$orderId}/{$intent}";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->active_ssl);

            $response = curl_exec($ch);
            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpStatus != 200 && $httpStatus != 201) {
                throw new \Exception("Erreur lors de la complétion de la commande: " . $response);
            }

            curl_close($ch);

            $json = json_decode($response, true);

            /** recup des donnéer issue d'un paiement de Paypal button */
            if(isset($json['payment_source']['paypal'])) {
                $vault_id = $json['payment_source']['paypal']['attributes']['vault']['id'] ?? null;
                $customer_id = $json['payment_source']['paypal']['attributes']['vault']['customer']['id'] ?? null;
            }
            /** recup des donnéer issue d'un paiement de CardFields */
            elseif(isset($json['payment_source']['card'])) {
                $vault_id = '';
                if($json['payment_source']['card']['attributes']['vault']['status'] == 'VAULTED') {
                    $vault_id = $json['payment_source']['card']['attributes']['vault']['id'] ?? null;
                }
                $customer_id = $json['payment_source']['card']['attributes']['vault']['customer']['id'] ?? null;
            }

            Database::getInstance()->query(/** @lang SQL */'
                UPDATE '.$this->table_name_paypal_transaction.' SET status = :status
                                , amount = :amount
                                , net_amount = :net_amount
                                , paypal_fee = :paypal_fee
                                , currency = :currency
                                , paypal_customer_id = :paypal_customer_id
                                , paypal_account_id = :paypal_account_id
                                , paypal_vault_id = :paypal_vault_id
                                , update_time = :update_time
                                ,paypal_capture_id = :paypal_capture_id
                WHERE paypal_order_id = :paypal_order_id
            ', [
                ':paypal_order_id' =>  $json['id'],
                ':paypal_customer_id' => $customer_id ?? '',
                ':paypal_vault_id' => $vault_id ?? '',
                ':paypal_capture_id' =>  $json['purchase_units'][0]['payments']['captures'][0]['id'],
                ':paypal_account_id' => $json['payer']['payer_id'],
                ':status' => $json['status'],
                ':currency' => $json['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
                ':amount' => $json['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                ':net_amount' => $json['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'],
                ':paypal_fee' => $json['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'],
                ':update_time' => $this->convertPayPalDateToMySQL($json['purchase_units'][0]['payments']['captures'][0]['update_time'])
            ]);

            // Requête SELECT pour récupérer la ligne mise à jour
            $updated_transaction = Database::getInstance()->query(/** @lang SQL */'
                SELECT id_paypal_transaction FROM '.$this->table_name_paypal_transaction.'  WHERE paypal_order_id = :order_id
            ', [
                ':order_id' => $order_id,
            ])->fetch(\PDO::FETCH_ASSOC);
            $this->addLog($response, $updated_transaction['id_paypal_transaction']);

            // Retourner la réponse à l'utilisateur
            echo json_encode($json['purchase_units'][0]['payments']['captures'][0]['amount']);

        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function refundCapture($capture_id, $amount, $currency, $note_to_payer = 'refund' ) {
        try {
            $accessToken = $this->getAccessToken();

            $orderData = [
                'note_to_payer' => $note_to_payer,

                "amount" => [
                    "value" => $amount,
                    "currency_code" => $currency
                ],

            ];

            $orderDataJson = json_encode($orderData);

            // URL de l'API pour compléter la commande
            $url = $this->api."/v2/payments/captures/{$capture_id}/refund";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->active_ssl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $orderDataJson);

            $response = curl_exec($ch);
            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpStatus != 200 && $httpStatus != 201) {
                throw new \Exception("Erreur lors de la complétion de la commande: " . $response);
            }

            curl_close($ch);

            $json = json_decode($response, true);

            Database::getInstance()->query(/** @lang SQL */'
                INSERT INTO '.$this->table_name_paypal_transaction.'  (type,paypal_capture_id,paypal_refund_id,status,amount,currency, comment)
                VALUES(\'refund\', :paypal_capture_id,:paypal_refund_id,:status,:amount,:currency, :comment)
            ', [
                ':paypal_capture_id' => $capture_id,
                ':paypal_refund_id' =>  $json['id'],
                ':comment' =>  $note_to_payer,
                ':status' => $json['status'],
                ':currency' => $currency,
                ':amount' => $amount,
            ]);
            $id_paypal_transaction = Database::getInstance()->getLastInsertId();
            $this->addLog($response, $id_paypal_transaction);

            // Retourner la réponse à l'utilisateur
            echo $response;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    protected function getAccessToken() {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->api.'/v1/oauth2/token'); // Sandbox, remplacez par l'URL live si nécessaire
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->clientID . ":" . $this->secretID); // Authentification avec client ID et secret
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Accept-Language: en_US'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials"); // Paramètre pour obtenir un token
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->active_ssl);

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpStatus != 200) {
            throw new \Exception("Erreur lors de la récupération du token: " . $response);
        }

        curl_close($ch);

        $jsonResponse = json_decode($response, true);

        if (!isset($jsonResponse['access_token'])) {
            throw new \Exception("Token d'accès non trouvé dans la réponse : " . $response);
        }

        return $jsonResponse['access_token']; // Renvoie le jeton d'accès
    }

    public function generateDynamicOrdersTable() {

        // Requête pour récupérer toutes les données de la table `orders`
        $stmt = Database::getInstance()->query(/** @lang SQL */'SELECT * FROM '.$this->table_name_paypal_transaction.' ');

        // Récupérer le nombre de colonnes et les informations des colonnes dynamiquement
        $columnCount = $stmt->columnCount();

        // Initialisation du tableau HTML
        $html = '<table border="1" cellpadding="5" cellspacing="0" style="width:80%">';
        $html .= '<thead>';
        $html .= '<tr>';

        // Boucler pour afficher les noms des colonnes
        for ($i = 0; $i < $columnCount; $i++) {
            $columnMeta = $stmt->getColumnMeta($i);
            $html .= '<th>' . htmlspecialchars($columnMeta['name']) . '</th>';
        }

        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Parcourir les résultats de la requête
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $html .= '<tr>';
            // Boucler pour afficher les valeurs de chaque colonne
            foreach ($row as $key => $value) {
                $html .= '<td>' . htmlspecialchars($value ?? '') . '</td>';
            }
            $html .= '</tr>';
        }

        // Fermer le tableau HTML
        $html .= '</tbody>';
        $html .= '</table>';

        // Retourner le tableau HTML
        return $html;
    }

    public function initDatabase()
    {

        /** Init de la BDD */
        $db = Database::getInstance();
        $db->query(/** @lang SQL */'CREATE TABLE IF NOT EXISTS  '.$this->table_name_paypal_transaction.'  (
            id_paypal_transaction '.$db->getAutoIncrementSyntax().',
            type VARCHAR(20) NOT NULL,
            paypal_order_id varchar(20),
            paypal_customer_id varchar(20),
            paypal_account_id varchar(20),
            paypal_vault_id varchar(20),
            paypal_capture_id varchar(20),
            paypal_refund_id varchar(20),
            comment text,
            status TEXT NOT NULL,
            amount REAL ,
            net_amount REAL ,
            paypal_fee REAL ,
            currency TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            update_time DATETIME,
            CHECK (type IN (\'payment\', \'refund\'))
        );');

        $db->query(/** @lang SQL */'CREATE TABLE IF NOT EXISTS  '.$this->table_name_paypal_transaction_logs.'  (
            id_paypal_transaction_log '.$db->getAutoIncrementSyntax().',
            id_paypal_transaction int,
            data text,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );');

    }

    public function addLog($response, $id_paypal_transaction) {
        Database::getInstance()->query(
            /** @lang SQL */'INSERT INTO '.$this->table_name_paypal_transaction_logs.' (data, id_paypal_transaction) VALUES(:data,:id_paypal_transaction) '
            , [
                ':data' => $response,
                ':id_paypal_transaction' =>  $id_paypal_transaction
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * @return mixed
     */
    public function getApi()
    {
        return $this->api;
    }

    public function initRoute()
    {
        /** Simulation des routes */
        switch($_POST['action'] ?? null) {
            case 'create_order':
                $amount = $this->getAmountFromAttribute($_POST['attributes']);
                $adress_facturation =  $this->getAdressFromAttribute($_POST['attributes']);
                call_user_func_array(array($this, 'createOrder'), [$amount, $this->currency, $adress_facturation['name'], $adress_facturation['adress_line_1'], $adress_facturation['adress_line_2'], $adress_facturation['admin_area_2'], $adress_facturation['admin_area_1'], $adress_facturation['postal_code'], $adress_facturation['country_code'] ]);
                die();
                /*
            case 'createOrderFromToken':
                if($this->createOrderFromToken('5em45740c0241244f', 100, 'EUR') === false){
                    throw new EXception('Echec de creation de la commande a partir du vault');
                }
                die();
            case 'refundCapture':
                $this->refundCapture('9PB5085723210951B', 5, 'EUR', 'remboursement test');
                die();
                */
            case 'complete_order':
                $this->completeOrder($_POST['order_id']);
                die();
        }
    }

    /**
     * @return mixed
     */
    public function getUrlJsSdk()
    {
        return $this->urlJsSdk;
    }

    /**
     * @return mixed
     */
    public function getUrlBack()
    {
        return $this->url_back;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    // Fonction pour convertir le format ISO 8601 de PayPal en format MySQL
    public function convertPayPalDateToMySQL($paypalDate) {
        if (empty($paypalDate)) {
            return null;
        }

        // Convertir "2026-01-05T15:47:54Z" en "2026-01-05 15:47:54"
        $timestamp = strtotime($paypalDate);
        return date('Y-m-d H:i:s', $timestamp);
    }

    public function getTableNamePaypalTransactionLogs() :mixed
    {
        return $this->table_name_paypal_transaction_logs;
    }

    public function getTableNamePaypalTransaction() :mixed
    {
        return $this->table_name_paypal_transaction;
    }

    /** doit retourner un montant */
    abstract protected function getAmountFromAttribute(string $attribute) :int ;

    /** doit retourner un tableau contenant l'adresse de facturation */
    abstract protected function getAdressFromAttribute(string $attribute) :array ;
}
