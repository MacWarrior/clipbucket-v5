<?php
class Paypal extends \OxygenzSAS\Paypal\Paypal
{
    private $fields = [];
    private $tablename = '';
    /**
     * @var array|false|int|mixed
     */
    private mixed $dataFromAttribute;

    public function __construct($clientID, $secretID, $api, $currency, $urlJsSdk, $url_back, $active_ssl = true, $table_name_paypal_transaction = 'paypal_transactions', $table_name_paypal_transaction_logs = 'paypal_transactions_logs', $table_name_paypal_vault = 'paypal_vault')
    {
        parent::__construct($clientID, $secretID, $api, $currency, $urlJsSdk, $url_back, $active_ssl, $table_name_paypal_transaction, $table_name_paypal_transaction_logs,$table_name_paypal_vault);

        $this->tablename = 'paypal_transactions';
        $this->fields = [
            'id_paypal_transaction'
            ,'type'
            ,'paypal_order_id'
            ,'paypal_customer_id'
            ,'paypal_account_id'
            ,'paypal_vault_id'
            ,'paypal_capture_id'
            ,'paypal_refund_id'
            ,'comment'
            ,'status'
            ,'amount'
            ,'net_amount'
            ,'paypal_fee'
            ,'currency'
            ,'created_at'
            ,'update_time'
            ,'billing_name'
            ,'billing_adress_line_1'
            ,'billing_adress_line_2'
            ,'billing_admin_area_2'
            ,'billing_admin_area_1'
            ,'billing_postal_code'
            ,'billing_country_code'
        ];
    }
    
    /**
     * @throws Exception
     */
    public function getAll(array $params)
    {
        $param_group = $params['group'] ?? false;
        $param_having = $params['having'] ?? false;
        $param_order = $params['order'] ?? false;
        $param_count = $params['count'] ?? false;
        $param_limit = $params['limit'] ?? false;
        $param_first_only = $params['first_only'] ?? false;

        $param_id_paypal_transaction = $params['id_paypal_transaction'] ?? false;
        $param_paypal_order_id = $params['paypal_order_id'] ?? false;
        $param_paypal_capture_id = $params['paypal_capture_id'] ?? false;
        $param_id_user_membership = $params['id_user_membership'] ?? false;

        //CONDITIONS
        $conditions = [];
        if ($param_id_paypal_transaction !== false) {
            $conditions[] = $this->tablename . '.id_paypal_transaction = ' . mysql_clean($param_id_paypal_transaction);
        }
        if ($param_paypal_order_id !== false) {
            $conditions[] = $this->tablename . '.paypal_order_id = \'' . mysql_clean($param_paypal_order_id).'\'';
        }
        if ($param_paypal_capture_id !== false) {
            $conditions[] = $this->tablename . '.paypal_capture_id = \'' . mysql_clean($param_paypal_capture_id).'\'';
        }
        if ($param_id_user_membership !== false) {
            $conditions[] = 'user_memberships_transactions.id_user_membership = ' . mysql_clean($param_id_user_membership);
        }

        if ($param_group) {
            $group[] = $param_group;
        }

        $having = '';
        if ($param_having) {
            $having = ' HAVING ' . $param_having;
        }

        $order = '';
        if ($param_order && !$param_count) {
            $order = ' ORDER BY ' . $param_order;
        }

        $limit = '';
        if ($param_limit) {
            $limit = ' LIMIT ' . $param_limit;
        }

        $join = [];
        $join[] = ' LEFT JOIN ' . cb_sql_table('user_memberships_transactions') . ' ON ' . $this->tablename . '.id_paypal_transaction = ' . 'user_memberships_transactions'. '.id_paypal_transaction';
        $join[] = ' LEFT JOIN ' . cb_sql_table('user_memberships') . ' ON ' . 'user_memberships_transactions' . '.id_user_membership = ' . 'user_memberships' . '.id_user_membership';

        //SELECT
        if ($param_count) {
            $select = ['COUNT(DISTINCT ' . $this->tablename . '.id_paypal_transaction) AS count'];
        } else {
            $select= [];
            foreach ($this->fields as $field) {
                $select[] = $this->tablename.'.'.$field;
            }
            $select[] = 'user_memberships.userid';
        }

        $sql = 'SELECT * FROM (SELECT ' . implode(', ', $select) . '
                FROM ' . cb_sql_table($this->tablename)
            . implode(' ', $join)
            . (empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . (empty($group) ? '' : ' GROUP BY ' . implode(',', $group))
            . $having . ') AS R'
            . $order
            . $limit;

        $result = Clipbucket_db::getInstance()->_select($sql);

        if ($param_count) {
            if (empty($result)) {
                return 0;
            }
            return $result[0]['count'];
        }

        if (!$result) {
            return [];
        }

        if ($param_first_only) {
            return $result[0];
        }

        return $result;
    }

    public function getDataFromAttribute(string $attribute) :array
    {
        if(empty($this->dataFromAttribute)) {
            $userid = user_id();
            $datas = json_decode($attribute, true);
            $this->dataFromAttribute = Membership::getInstance()->getAllHistoMembershipForUser([
                'userid' => $userid,
                'id_user_membership' => $datas['id_user_membership'],
            ]);
        }

        if(empty($this->dataFromAttribute)) {
            throw new Exception('unable to find user_membership from attribute');
        }

        return $this->dataFromAttribute;
    }

    /** This method should return the amount for an order */
    protected function getAmountFromAttribute(string $attribute) :int
    {
        $datas = $this->getDataFromAttribute($attribute);
        return $datas[0]['base_price']; // return amount
    }

    /** This method should return the billing address */
    protected function getAdressFromAttribute(string $attribute) :array
    {
        $datas = $this->getDataFromAttribute($attribute);
        return [
            'name' => $datas[0]['name']
            ,'adress_line_1' => $datas[0]['billing_address_line_1']
            ,'adress_line_2' => $datas[0]['billing_address_line_2']
            ,'admin_area_1' => $datas[0]['billing_admin_area_1']
            ,'admin_area_2' => $datas[0]['billing_admin_area_2']
            ,'postal_code' => $datas[0]['billing_postal_code']
            ,'country_code' => $datas[0]['billing_country_code']
        ];
    }

    /** This method should return true if the card must be saved */
    protected function isCardShouldBeSaved(string $attribute) :bool
    {
        $datas = json_decode($attribute, true);
        return ($datas['saveCard'] ?? false) == true ;
    }

    protected function createOrderSuccess($response, string $attribute) :void
    {
        /**@todo verifier que le success est reel a partir de la response !!!! */
        $response = json_decode($response, true);
        if($response['status'] != 'CREATED') {
            $this->completeOrderError('unable to create order', $attribute);
            throw new Exception('unable to create order');
        }

        $datas = $this->getDataFromAttribute($attribute);
        Membership::getInstance()->updateHistoMembership([
            'id_user_membership' => $datas[0]['id_user_membership']
            /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
            ,'id_user_memberships_status' => 6 /* authorized */
        ]);

        /** recuperer l'id_paypal_transaction pour le lier au user_membership */
        $transaction = $this->getAll([
            'paypal_order_id' => $response['id']
        ]);

        if(empty($transaction)) {
            throw new Exception('unable to find transaction from response');
        }

        /** le lier au user_membership */
        $this->insertTransactionOnUserMembership($datas[0]['id_user_membership'] , $transaction[0]['id_paypal_transaction']);
    }

    protected function createOrderError($error, string $attribute) :void
    {
        $datas = $this->getDataFromAttribute($attribute);
        Membership::getInstance()->updateHistoMembership([
            'id_user_membership' => $datas[0]['id_user_membership']
            /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
            ,'id_user_memberships_status' => 5 /* failed_authorized */
        ]);
    }

    /** @todo a refaire / nettoyer */
    public static function getNextDate(string $frequency, string $date): string
    {
        $timestamp = strtotime($date);

        switch (strtolower($frequency)) {
            case 'weekly':
                $next = strtotime('+1 week', $timestamp);
                break;

            case 'monthly':
                $next = strtotime('+1 month', $timestamp);
                break;

            case 'yearly':
                $next = strtotime('+1 year', $timestamp);
                break;

            default:
                return '';
        }

        return date('Y-m-d', $next);
    }

    protected function completeOrderSuccess($response, string $attribute, array $vaultData) :void
    {
        $user_id = user_id();
        $response = json_decode($response, true);

        if($response['status'] != 'COMPLETED') {
            $this->completeOrderError('unable to complete order', $attribute);
            throw new Exception('unable to complete order');
        }

        $datas = $this->getDataFromAttribute($attribute);
        Membership::getInstance()->updateHistoMembership([
            'id_user_membership' => $datas[0]['id_user_membership']
            /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
            ,'id_user_memberships_status' => 2 /* completed */
            ,'date_start' => date('Y-m-d H:i:s')
            ,'date_end' => self::getNextDate( $datas[0]['frequency'], date('Y-m-d H:i:s'))
        ]);

        /** set vault data and link them to user account */
        if(!empty($vaultData) && $vaultData['status'] == 'VAULTED') {
            $this->insertUserVault( $user_id, $vaultData['id']);
            $this->setVaultDefault(paypal_vault_id: $vaultData['id'], user_id: $user_id);
        }

        /** recuperer l'id_paypal_transaction pour le lier au user_membership */
        $transaction = $this->getAll([
            'paypal_order_id' => $response['id']
        ]);

        if(empty($transaction)) {
            throw new Exception('unable to find transaction from response');
        }

        /** le lier au user_membership */
        $this->insertTransactionOnUserMembership($datas[0]['id_user_membership'] , $transaction[0]['id_paypal_transaction']);
    }

    protected function completeOrderError($error, string $attribute) :void
    {
        $datas = $this->getDataFromAttribute($attribute);
        Membership::getInstance()->updateHistoMembership([
            'id_user_membership' => $datas[0]['id_user_membership']
            /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
            ,'id_user_memberships_status' => 7 /* failed_capture */
        ]);
    }

    protected function beforeCreateOrder(string $attribute) :void
    {
        $userid = user_id();

        $attributeOriginal= json_decode($attribute, true);
        $userMembership = Membership::getInstance()->getAllHistoMembershipForUser([
            'id_user_membership' => $attributeOriginal['id_user_membership'],
            'userid' => $userid,
        ]);

        if(empty($userMembership)) {
            throw new Exception('unable to find user_membership, or bad owner');
        }

        if($userMembership[0]['is_membership_disabled'] == true) {
            throw new Exception('This membership is disabled');
        }

        if((float)$attributeOriginal['amount'] != (float)$userMembership[0]['base_price']) {
            throw new Exception('bad amount for the membership');
        }

        /** if already authorized then return already existing order */
        if($userMembership[0]['language_key_title'] == 'authorized') {

            /** get current transaction authorized if she exist */
            $transactions = $this->getAll([
                'id_user_membership' => $userMembership[0]['id_user_membership']
                , 'type' => 'payment'
            ]);
            $foundTransaction = [];
            foreach ($transactions as $transaction) {
                if($transaction['status'] == 'COMPLETED') {
                    http_response_code(422);
                    echo json_encode(['status' => 'error','error' => 'Already payed']);
                    die();
                } elseif ($transaction['status'] == 'CREATED') {
                    $foundTransaction[] = $transaction;
                }
            }

            if(count($foundTransaction) == 0) {
                $msg = 'the status user_membership doesn\'t match with the transaction. Abort.';
                DiscordLog::sendDump($msg);
                throw new Exception($msg);
            }

            /** force user_membership to failed_capture  because this this probably the case for not passing to completed */
            Membership::getInstance()->updateHistoMembership([
                'id_user_membership' => $userMembership[0]['id_user_membership']
                /** @todo Clement a rendre dynamic en recuperant l'id a partir du language_key_title */
                ,'id_user_memberships_status' => 7 /* failed_capture */
            ]);

            http_response_code(422);
            echo json_encode(['status' => 'error','error' => 'Payment issue. No amount has been charged. Abort.']);
            die();

        }

        if(!in_array($userMembership[0]['language_key_title'], ['in_progress', 'failed_authorized'])) {
            http_response_code(422);
            echo json_encode(['status' => 'error','error' => 'Already payed or failed authorized or failed capture. Abort. ']);
            die();
        }

        Membership::getInstance()->updateHistoMembership([
            'id_user_membership' => $userMembership[0]['id_user_membership'],
            'is_auto_renew' => ($attributeOriginal['renewAuto'] === true ) ? 'yes' : 'no',
            'is_card_saved' => $this->isCardShouldBeSaved($attribute) ? 'yes' : 'no'
        ]);

    }

    protected function beforeCompleteOrder(string $attribute) :void
    {
        // TODO: Implement beforeCompleteOrder() method.
    }

    private function insertTransactionOnUserMembership(int $id_user_membership, int $id_paypal_transaction)
    {
        $sql = 'INSERT IGNORE INTO ' . tbl('user_memberships_transactions') ;
        $sql .= ' (id_user_membership, id_paypal_transaction) VALUES ('.(int)$id_user_membership.', '.(int)$id_paypal_transaction.') ';
        Clipbucket_db::getInstance()->execute($sql);
    }

    private function insertUserVault(int $user_id, string $vault_id)
    {
        $sql = 'INSERT IGNORE INTO ' . tbl('user_vault') ;
        $sql .= ' (paypal_vault_id, id_user) VALUES (\''.mysql_clean($vault_id).'\', '.(int)$user_id.') ';
        Clipbucket_db::getInstance()->execute($sql);

        /** remove duplicate vault, keep last created, and set default vault if not already defined */
        $this->removeDuplicateVault( $user_id);
    }

    public function getUserVault(int $user_id)
    {
        $sql = 'SELECT paypal_vault.paypal_vault_id, status, last_digits, expiry, brand, type, user_vault.is_default, user_vault.created_at
                FROM ' . cb_sql_table('paypal_vault').'
                INNER JOIN ' . cb_sql_table('user_vault').' ON user_vault.paypal_vault_id = paypal_vault.paypal_vault_id 
                INNER JOIN ' . cb_sql_table('users').' ON user_vault.id_user = users.userid
                WHERE id_user = '.(int)$user_id.' ';
        return Clipbucket_db::getInstance()->execute($sql);
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

    public function removeDuplicateVault(int $user_id)
    {
        $vaultDefaultUniqKey = null;
        $vaults = $this->getUserVault($user_id);
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

    public function deleteVault(string $paypal_vault_id)
    {
        $sql = 'DELETE FROM ' . tbl('user_vault').' WHERE paypal_vault_id = \''. mysql_clean($paypal_vault_id).'\'';
        Clipbucket_db::getInstance()->execute($sql);

        $sql = 'DELETE FROM ' . tbl('paypal_vault').' WHERE paypal_vault_id = \''. mysql_clean($paypal_vault_id).'\'';
        Clipbucket_db::getInstance()->execute($sql);

        // delete from paypal
        parent::deleteVault($paypal_vault_id);
    }

    protected function getPaypalVaultIdFromAttribute(string $attribute) :string
    {
        $vaults = $this->getUserVault(user_id: user_id());
        $datas = json_decode($attribute, true);
        foreach ($vaults as $vault) {
            if($vault['paypal_vault_id'] != $datas['vault_id']) {
                continue;
            }
            return $vault['paypal_vault_id'];
        }

        throw new Exception('paypal vault id not found for the current user');
    }
}
