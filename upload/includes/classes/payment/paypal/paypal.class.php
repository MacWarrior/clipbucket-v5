<?php

require_once DirPath::get('classes') . 'payment/payment.interface.php';

/**
 * PayPal Payment Processor
 * Implements PaymentSystemInterface for PayPal API integration
 */
class Paypal implements PaymentSystemInterface
{
    protected string $clientID;
    protected string $secretID;
    protected string $api;
    protected bool $activeSsl;
    protected string $urlJsSdk;
    protected string $urlBack;
    protected string $currency;

    protected string $tableTransaction;
    protected string $tableVault;
    protected string $tableLogs;

    public function __construct(array $options = [])
    {
        $this->clientID = $options['paypal_client_id'] ?? '';
        $this->secretID = $options['paypal_secret_id'] ?? '';
        $this->api = rtrim($options['url_api'] ?? '', ' ');
        $this->activeSsl = $options['active_ssl'] ?? true;
        $this->urlBack = $options['url_payment_page'] ?? '';
        $this->urlJsSdk = rtrim($options['url_sdk'] ?? '', ' ');
        $this->currency = $options['currency'] ?? 'EUR';
        $this->tableTransaction = $options['tablename_paypal_transactions'] ?? '';
        $this->tableLogs = $options['tablename_paypal_transactions_logs'] ?? '';
        $this->tableVault = $options['tablename_paypal_vault'] ?? '';
    }

    /**
     * Creates an order and returns JSON response
     */
    public function createOrder(
        float $amount,
        string $currency,
        string $name,
        string $addressLine1,
        string $addressLine2,
        string $adminArea2,
        string $adminArea1,
        string $postalCode,
        string $countryCode,
        bool $saveCard = false
    ) :void {
        try {
            $accessToken = $this->getAccessToken();

            $orderData = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => number_format($amount, 2, '.', '')
                        ]
                    ]
                ],
                'payment_source' => [
                    'card' => [
                        'name' => $name,
                        'billing_address' => [
                            'address_line_1' => $addressLine1,
                            'address_line_2' => $addressLine2,
                            'admin_area_2' => $adminArea2,
                            'admin_area_1' => $adminArea1,
                            'postal_code' => $postalCode,
                            'country_code' => $countryCode
                        ],
                        'attributes' => [
                            'verification' => ['method' => 'SCA_WHEN_REQUIRED']
                        ]
                    ]
                ]
            ];

            if ($saveCard) {
                $orderData['payment_source']['card']['attributes']['vault'] = [
                    'store_in_vault' => 'ON_SUCCESS'
                ];
            }

            $response = $this->makeApiRequest('/v2/checkout/orders', 'POST', $orderData, $accessToken);
            $data = json_decode($response, true);

            $this->insertTransaction([
                'type' => 'payment',
                'paypal_order_id' => $data['id'],
                'status' => $data['status'],
                'amount' => $amount,
                'currency' => $currency,
                'billing_name' => $name,
                'billing_address_line_1' => $addressLine1,
                'billing_address_line_2' => $addressLine2,
                'billing_admin_area_2' => $adminArea2,
                'billing_admin_area_1' => $adminArea1,
                'billing_postal_code' => $postalCode,
                'billing_country_code' => $countryCode
            ]);

            $transactionId = Database::getInstance()->getLastInsertId();
            $this->addLog($response, $transactionId);
            $this->handleOrderSuccess($response, $_POST['attributes'] ?? []);

            $this->jsonResponse(['status' => $data['status'], 'id' => $data['id']]);
        } catch (\Exception $e) {
            $this->handleOrderError($e, $_POST['attributes'] ?? []);
            $this->jsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Creates an order from stored vault token
     */
    public function createOrderFromToken(
        string $vaultId,
        float $amount,
        string $currency,
        string $name,
        string $addressLine1,
        string $addressLine2,
        string $adminArea2,
        string $adminArea1,
        string $postalCode,
        string $countryCode,
        ?string $customerId = null
    ) :bool {
        try {
            $accessToken = $this->getAccessToken();

            $orderData = [
                'intent' => 'CAPTURE',
                'payment_source' => [
                    'token' => [
                        'type' => 'PAYMENT_METHOD_TOKEN',
                        'id' => $vaultId,
                        'name' => $name,
                        'billing_address' => [
                            'address_line_1' => $addressLine1,
                            'address_line_2' => $addressLine2,
                            'admin_area_2' => $adminArea2,
                            'admin_area_1' => $adminArea1,
                            'postal_code' => $postalCode,
                            'country_code' => $countryCode
                        ]
                    ]
                ],
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => number_format($amount, 2, '.', '')
                        ]
                    ]
                ]
            ];

            $response = $this->makeApiRequest('/v2/checkout/orders', 'POST', $orderData, $accessToken);
            $data = json_decode($response, true);

            $capture = $data['purchase_units'][0]['payments']['captures'][0] ?? [];
            $breakdown = $capture['seller_receivable_breakdown'] ?? [];

            $this->insertTransaction([
                'type' => 'payment',
                'paypal_order_id' => $data['id'],
                'paypal_capture_id' => $capture['id'] ?? null,
                'status' => $data['status'],
                'amount' => $capture['amount']['value'] ?? $amount,
                'net_amount' => $breakdown['net_amount']['value'] ?? null,
                'paypal_fee' => $breakdown['paypal_fee']['value'] ?? null,
                'currency' => $capture['amount']['currency_code'] ?? $currency,
                'paypal_customer_id' => $customerId,
                'paypal_account_id' => $data['payer']['payer_id'] ?? null,
                'paypal_vault_id' => $vaultId,
                'update_time' => $this->convertPayPalDate($capture['update_time'] ?? null)
            ]);

            $transactionId = Database::getInstance()->getLastInsertId();
            $this->addLog($response, $transactionId);

            return ($data['status'] === 'COMPLETED');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Completes/captures an existing order
     */
    public function completeOrder(string $orderId) :void
    {
        try {
            $accessToken = $this->getAccessToken();
            $url = "{$this->api}/v2/checkout/orders/{$orderId}/capture";

            $response = $this->makeApiRequest($url, 'POST', [], $accessToken);
            $data = json_decode($response, true);

            $vaultData = [];
            $vaultId = null;
            $customerId = null;

            // Extract vault data from PayPal button payment
            if (isset($data['payment_source']['paypal'])) {
                $vault = $data['payment_source']['paypal']['attributes']['vault'] ?? [];
                $vaultId = $vault['id'] ?? null;
                $customerId = $vault['customer']['id'] ?? null;
            } // Extract vault data from CardFields payment
            elseif (isset($data['payment_source']['card'])) {
                $card = $data['payment_source']['card'];
                $vault = $card['attributes']['vault'] ?? [];

                if (($vault['status'] ?? '') === 'VAULTED') {
                    $vaultId = $vault['id'] ?? null;
                    $vaultData = [
                        'status' => $vault['status'],
                        'customer_id' => $vault['customer']['id'] ?? null,
                        'last_digits' => $card['last_digits'] ?? null,
                        'expiry' => $card['expiry'] ?? null,
                        'brand' => $card['brand'] ?? null,
                        'type' => $card['type'] ?? null
                    ];
                }
                $customerId = $vault['customer']['id'] ?? null;
            }

            $capture = $data['purchase_units'][0]['payments']['captures'][0] ?? [];
            $breakdown = $capture['seller_receivable_breakdown'] ?? [];

            $this->updateTransaction($orderId, [
                'status' => $data['status'],
                'paypal_customer_id' => $customerId,
                'paypal_vault_id' => $vaultId,
                'paypal_capture_id' => $capture['id'] ?? null,
                'paypal_account_id' => $data['payer']['payer_id'] ?? null,
                'amount' => $capture['amount']['value'] ?? null,
                'net_amount' => $breakdown['net_amount']['value'] ?? null,
                'paypal_fee' => $breakdown['paypal_fee']['value'] ?? null,
                'currency' => $capture['amount']['currency_code'] ?? null,
                'update_time' => $this->convertPayPalDate($capture['update_time'] ?? null)
            ]);

            $transaction = $this->getTransactionByOrderId($orderId);
            $this->addLog($response, $transaction['id_paypal_transaction'] ?? null);

            // Save vault if successful
            if (!empty($vaultData) && $vaultData['status'] === 'VAULTED') {
                $this->saveVault($vaultData);
            }

            $this->handleCompleteSuccess($response, $_POST['attributes'] ?? [], $vaultData);
            $this->jsonResponse(['status' => $data['status']]);
        } catch (\Exception $e) {
            $this->handleCompleteError($e, $_POST['attributes'] ?? []);
            $this->jsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Deletes a vault token
     */
    protected function deleteVault(string $vaultId) :bool
    {
        try {
            $accessToken = $this->getAccessToken();
            $url = "{$this->api}/v3/vault/payment-tokens/{$vaultId}";

            $this->makeApiRequest(endpoint: $url, method: 'DELETE', data: [], accessToken: $accessToken);
            return true;
        } catch (\Exception $e) {
            error_log("Vault deletion failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Gets all vault tokens for a customer
     */
    public function getAllVaultFromCustomer(string $customerId) :?array
    {
        try {
            $accessToken = $this->getAccessToken();
            $url = "{$this->api}/v3/vault/payment-tokens?customer_id=" . urlencode($customerId);

            $response = $this->makeApiRequest($url, 'GET', [], $accessToken);
            return json_decode($response, true);
        } catch (\Exception $e) {
            error_log("Failed to get vaults: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Refunds a captured payment
     */
    public function refundCapture(
        string $captureId,
        float $amount,
        string $currency,
        string $noteToPayer = 'Refund'
    ) :void {
        try {
            $accessToken = $this->getAccessToken();

            $refundData = [
                'note_to_payer' => $noteToPayer,
                'amount' => [
                    'value' => number_format($amount, 2, '.', ''),
                    'currency_code' => $currency
                ]
            ];

            $url = "{$this->api}/v2/payments/captures/{$captureId}/refund";
            $response = $this->makeApiRequest($url, 'POST', $refundData, $accessToken);
            $data = json_decode($response, true);

            $this->insertTransaction([
                'type' => 'refund',
                'paypal_capture_id' => $captureId,
                'paypal_refund_id' => $data['id'],
                'status' => $data['status'],
                'amount' => $amount,
                'currency' => $currency,
                'comment' => $noteToPayer
            ]);

            $transactionId = Database::getInstance()->getLastInsertId();
            $this->addLog($response, $transactionId);

            echo $response;
        } catch (\Exception $e) {
            error_log("Refund failed: " . $e->getMessage());
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Gets OAuth access token from PayPal
     */
    protected function getAccessToken() :string
    {
        $response = $this->makeApiRequest(
            '/v1/oauth2/token',
            'POST',
            ['grant_type' => 'client_credentials'],
            null,
            true,
        );

        $data = json_decode($response, true);

        if (empty($data['access_token'])) {
            throw new \Exception("Access token not found in response");
        }

        return $data['access_token'];
    }

    /**
     * Generic API request handler
     */
    protected function makeApiRequest(
        string $endpoint,
        string $method,
        array $data = [],
        ?string $accessToken = null,
        bool $isAuthRequest = false,
    ) :string {
        $ch = curl_init();

        $url = str_starts_with($endpoint, 'http') ? $endpoint : $this->api . $endpoint;

        $header = [
            'Accept: application/json',
            'Accept-Language: en_US'
        ];

        if(!empty($accessToken)) {
            $header[] = 'Content-Type: application/json';
            $header[] = "Authorization: Bearer {$accessToken}";
        } else if($isAuthRequest) {
            curl_setopt($ch, CURLOPT_USERPWD, "{$this->clientID}:{$this->secretID}");
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials"); // Paramètre pour obtenir un token
        }

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => $this->activeSsl,
            CURLOPT_HTTPHEADER => $header
        ]);

        if ($method !== 'GET' && !empty($data) && $isAuthRequest === false) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL Error: {$error}");
        }

        curl_close($ch);

        if (!in_array($httpCode, [200, 201, 204])) {
            throw new \Exception("API request failed (HTTP {$httpCode}): {$response}");
        }

        return $response;
    }

    /**
     * Inserts transaction record
     */
    protected function insertTransaction(array $data) :void
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($k) => ":{$k}", array_keys($data)));

        $sql = "INSERT INTO {$this->tableTransaction} ({$columns}) VALUES ({$placeholders})";
        Database::getInstance()->query($sql, $data);
    }

    /**
     * Updates transaction record
     */
    protected function updateTransaction(string $orderId, array $data) :void
    {
        $set = implode(', ', array_map(fn($k) => "{$k} = :{$k}", array_keys($data)));
        $data['paypal_order_id'] = $orderId;

        $sql = "UPDATE {$this->tableTransaction} SET {$set} WHERE paypal_order_id = :paypal_order_id";
        Database::getInstance()->query($sql, $data);
    }

    /**
     * Gets transaction by order ID
     */
    protected function getTransactionByOrderId(string $orderId) :?array
    {
        $sql = "SELECT * FROM {$this->tableTransaction} WHERE paypal_order_id = :order_id";
        $stmt = Database::getInstance()->query($sql, [':order_id' => $orderId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Saves vault data to database
     */
    protected function saveVault(array $vaultData) :void
    {
        $sql = "INSERT INTO {$this->tableVault} 
                (paypal_vault_id, status, paypal_customer_id, last_digits, expiry, brand, type) 
                VALUES (:vault_id, :status, :customer_id, :last_digits, :expiry, :brand, :type)";

        Database::getInstance()->query($sql, [
            ':vault_id' => $vaultData['id'] ?? null,
            ':status' => $vaultData['status'],
            ':customer_id' => $vaultData['customer_id'],
            ':last_digits' => $vaultData['last_digits'],
            ':expiry' => $vaultData['expiry'],
            ':brand' => $vaultData['brand'],
            ':type' => $vaultData['type']
        ]);
    }

    /**
     * Generates HTML table of transactions
     */
    public function generateTransactionTable() :string
    {
        $stmt = Database::getInstance()->query("SELECT * FROM {$this->tableTransaction}");
        $columns = [];

        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $meta = $stmt->getColumnMeta($i);
            $columns[] = $meta['name'];
        }

        $html = '<table class="paypal-transactions">';
        $html .= '<thead><tr>' . implode('', array_map(fn($col) => "<th>{$col}</th>", $columns)) . '</tr></thead>';
        $html .= '<tbody>';

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $html .= '<tr>' . implode('', array_map(fn($val) => '<td>' . htmlspecialchars($val ?? '') . '</td>', $row)) . '</tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    /**
     * Adds log entry
     */
    public function addLog(string $response, ?int $transactionId) :void
    {
        $sql = "INSERT INTO {$this->tableLogs} (data, id_paypal_transaction) VALUES (:data, :transaction_id)";
        Database::getInstance()->query($sql, [
            ':data' => $response,
            ':transaction_id' => $transactionId
        ]);
    }

    /**
     * Converts PayPal ISO 8601 date to MySQL format
     */
    public function convertPayPalDate(?string $paypalDate) :?string
    {
        if (empty($paypalDate)) {
            return null;
        }
        return date('Y-m-d H:i:s', strtotime($paypalDate));
    }

    /**
     * Returns JSON response
     */
    protected function jsonResponse(array $data, int $code = 200) :void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Getters
    public function getClientId() :string { return $this->clientID; }

    public function getApi() :string { return $this->api; }

    public function getUrlJsSdk() :string { return $this->urlJsSdk; }

    public function getUrlBack() :string { return $this->urlBack; }

    public function getCurrency() :string { return $this->currency; }

    public function getTableTransaction() :string { return $this->tableTransaction; }

    public function getTableLogs() :string { return $this->tableLogs; }

    // Interface implementations
    public function successPayment(string $transactionId, array $data = []) :bool { return true; }

    public function failedPayment(string $transactionId, string $reason, array $data = []) :bool { return true; }

    public function getPaymentData(string $transactionId) :array { return []; }

    public function createPaymentFromToken(string $token, float $amount, string $currency) :array { return []; }

    public function successPaymentFromToken(string $transactionId, string $token) :bool { return true; }

    public function failedPaymentFromToken(string $transactionId, string $token, string $reason) :bool { return true; }

    public function refundPayment(string $transactionId, ?float $amount = null) :array { return []; }

    public function successRefundPayment(string $refundId, string $originalTransactionId) :bool { return true; }

    public function failedRefundPayment(string $refundId, string $originalTransactionId, string $reason) :bool { return true; }

    public function getAllActiveTokensFromUser($userId) {
        $sql = 'SELECT paypal_vault.paypal_vault_id AS token_id
                 , last_digits AS last4
                 , expiry
                 , brand
                 , user_vault.is_default
                 ,null AS holder
                FROM ' . cb_sql_table('paypal_vault').'
                INNER JOIN ' . cb_sql_table('user_vault').' ON user_vault.paypal_vault_id = paypal_vault.paypal_vault_id 
                INNER JOIN ' . cb_sql_table('users').' ON user_vault.id_user = users.userid
                WHERE id_user = '.(int) $userId.' ';
        return Clipbucket_db::getInstance()->execute($sql);
    }

    public function deleteTokenFromUser($userId, string $token) {

        $this->deleteVault($token);

        /** clean vault if duplicate exist and reset default vault if necessary */
        $this->removeDuplicateVault($userId);
    }

    public function getHtmlForCrudToken() :string {
        global $Smarty;
        $Smarty->assign('paypal', $this);
        return $Smarty->fetch(LAYOUT."/blocks/payment/paypal/account_crud_cb.html");
    }

    public function getHtmlPayment() :string {
        global $Smarty;
        $Smarty->assign('paypal', $this);
        return $Smarty->fetch(LAYOUT."/blocks/payment/paypal/paypal_payment.html");
    }

    // Hook methods (to be overridden)
    protected function beforeCreateOrder(array $attributes) :void { }

    protected function handleOrderSuccess(string $response, array $attributes) :void { }

    protected function handleOrderError(\Exception $e, array $attributes) :void { }

    protected function beforeCompleteOrder(array $attributes) :void { }

    protected function handleCompleteSuccess(string $response, array $attributes, array $vaultData) :void { }

    protected function handleCompleteError(\Exception $e, array $attributes) :void { }

    protected function getAmountFromAttribute(array $attributes) :float { return 0.0; }

    protected function getAddressFromAttribute(array $attributes) :array { return []; }

    protected function isCardShouldBeSaved(array $attributes) :bool { return false; }

    protected function getPaypalVaultIdFromAttribute() :?string { return null; }

    public function getAllTransaction(int $idUserMembership) :array
    {
        $sql = 'SELECT paypal_transactions.*
                FROM '.cb_sql_table('user_memberships_transactions').'
                INNER JOIN '.cb_sql_table('paypal_transactions').' ON paypal_transactions.id_paypal_transaction = user_memberships_transactions.id_paypal_transaction
                WHERE id_user_membership = ' . (int) $idUserMembership ;
        return Clipbucket_db::getInstance()->_select($sql);
    }

    private function setVaultDefault(string $paypal_vault_id, int $user_id)
    {
        $sql = 'UPDATE ' . tbl('user_vault').' SET is_default = 0
        WHERE id_user = '.(int)$user_id.' ';
        Clipbucket_db::getInstance()->execute($sql);

        $sql = 'UPDATE ' . tbl('user_vault').' SET is_default = 1 
        WHERE id_user = '.(int)$user_id.' AND paypal_vault_id = \''.mysql_clean($paypal_vault_id).'\' ';
        Clipbucket_db::getInstance()->execute($sql);
    }

    protected function removeDuplicateVault(int $user_id)
    {
        $vaultDefaultUniqKey = null;
        $vaults = $this->getAllActiveTokensFromUser($user_id);
        $vaultsToDelete = [];
        $vaultsToKeep = [];
        $vaultMostRecent = null;
        foreach ($vaults as $vault) {
            $uniq_key = $vault['last_digits'].'_'.$vault['expiry'].'_'.$vault['brand'].'_'.$vault['type'];
            if($vault['is_default'] == 1) {
                $vaultDefaultUniqKey = $uniq_key;
            }
            if(!empty($vaultsToKeep[$uniq_key])) {
                if($vault['created_at'] <= $vaultsToKeep[$uniq_key]['created_at']) {
                    $vaultsToDelete[] = $vault;
                    continue;
                }
                $vaultsToDelete[] = $vaultsToKeep[$uniq_key];
            }

            if($vault['created_at'] >= $vaultMostRecent['created_at']) {
                $vaultMostRecent = $vault;
                $vaultMostRecent['uniq_key'] = $uniq_key;
            }

            $vaultsToKeep[$uniq_key] = $vault;
        }

        foreach ($vaultsToDelete as $vault) {
            $this->deleteVault($vault['paypal_vault_id']);
        }

        if(empty($vaultDefaultUniqKey)) {
            $vaultDefaultUniqKey = $vaultMostRecent['uniq_key'];
        }

        if(empty($vaultsToKeep[$vaultDefaultUniqKey]['paypal_vault_id'])) {
            return;
        }

        $this->setVaultDefault(paypal_vault_id: $vaultsToKeep[$vaultDefaultUniqKey]['paypal_vault_id'], user_id: $user_id);
    }

    public function callAction(string $action, int $userId) :array
    {
        if(empty($userId)) {
            throw new Exception('User is needed');
        }

        switch($action) {
            default:
                throw new \ClientVisibleException('Unknown payment action : '.$action);
        }

    }

    public function getJsFile():string
    {
        $cache_key = ClipBucket::getInstance()->getCacheKey();
        $min_suffixe = System::isInDev() ? '' : '.min';
        return DirPath::getUrl('theme_js').'/payment/paypal' . $min_suffixe . '.js?v=' . $cache_key;
    }

    public function getCssFile():string
    {
        $cache_key = ClipBucket::getInstance()->getCacheKey();
        $min_suffixe = System::isInDev() ? '' : '.min';
        return DirPath::getUrl('theme_css').'/payment/paypal' . $min_suffixe . '.css?v=' . $cache_key;
    }

}