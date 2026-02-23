<?php

require_once DirPath::get('classes') . 'payment/payment.interface.php';

class Payment implements PaymentSystemInterface
{

    private PaymentSystemInterface $instance_payment;

    public function __construct(PaymentSystemInterface $instance_payment)
    {
        $this->instance_payment = $instance_payment;
    }

    public function getInstancePayment() :PaymentSystemInterface
    {
        return $this->instance_payment;
    }

    public function successPayment(string $transactionId, array $data = []): bool
    {
        return $this->getInstancePayment()->successPayment($transactionId, $data);
    }

    public function failedPayment(string $transactionId, string $reason, array $data = []): bool
    {
        return $this->getInstancePayment()->failedPayment($transactionId, $reason, $data);
    }

    public function getPaymentData(string $transactionId): array
    {
        return $this->getInstancePayment()->getPaymentData($transactionId);
    }

    public function createPaymentFromToken(string $token, float $amount, string $currency): array
    {
        return $this->getInstancePayment()->createPaymentFromToken($token, $amount, $currency);
    }

    public function successPaymentFromToken(string $transactionId, string $token): bool
    {
        return $this->getInstancePayment()->successPaymentFromToken($transactionId, $token);
    }

    public function failedPaymentFromToken(string $transactionId, string $token, string $reason): bool
    {
        return $this->getInstancePayment()->failedPaymentFromToken($transactionId, $token, $reason);
    }

    public function refundPayment(string $transactionId, ?float $amount = null): array
    {
        return $this->getInstancePayment()->refundPayment($transactionId, $amount);
    }

    public function successRefundPayment(string $refundId, string $originalTransactionId): bool
    {
        return $this->getInstancePayment()->successRefundPayment($refundId, $originalTransactionId);
    }

    public function failedRefundPayment(string $refundId, string $originalTransactionId, string $reason): bool
    {
        return $this->getInstancePayment()->failedRefundPayment($refundId, $originalTransactionId, $reason);
    }

    public function getAllActiveTokensFromUser($userId)
    {
        return $this->getInstancePayment()->getAllActiveTokensFromUser($userId);
    }

    public function deleteTokenFromUser($userId, string $token)
    {
        return $this->getInstancePayment()->deleteTokenFromUser($userId, $token);
    }

    public function getHtmlForCrudToken(): string
    {
        return $this->getInstancePayment()->getHtmlForCrudToken();
    }

    public function getHtmlPayment(): string
    {
        return $this->getInstancePayment()->getHtmlPayment();
    }

    public function getAllTransaction(int $idUserMembership) :array
    {
        return $this->getInstancePayment()->getAllTransaction($idUserMembership);
    }

    protected function ajaxUserGetToken(int $userId) {
        $vaults = $this->getAllActiveTokensFromUser($userId);
        $cleanVault = [];
        foreach($vaults as $vault) {
            $cleanVault[] = [
                'id' => $vault['token_id'],
                'brand' => strtolower($vault['brand']),
                'last4' => $vault['last4'],
                'expiry' => $vault['expiry'],
                'holder' => $vault['holder'] ?? '',
                'is_default' => $vault['is_default'],
            ];
        }
        return ['success' => true, 'vaults' => $cleanVault];
    }

    protected function ajaxUserRemoveToken(int $userId, string $tokenId) {
        /** check if user has right to delete this vault */
        $vaults = $this->getAllActiveTokensFromUser($userId);
        $found = false;
        foreach ($vaults as $vault) {
            if($vault['token_id'] != $tokenId) {
                continue;
            }
            $found = true;
        }
        if($found == false) {
            throw new Exception('This token is link to another user or not exist. you can\'t delete it.');
        }

        /** delete vault */
        $this->deleteTokenFromUser($userId, $tokenId);

        return ['success' => true];
    }

    public function callAction(string $action, int $userId) :array
    {
        if(empty($userId)) {
            throw new Exception('User is needed');
        }

        switch($action) {

            case 'user_get_token':
                return $this->ajaxUserGetToken(userId: $userId);

            case 'user_remove_token':
                return $this->ajaxUserRemoveToken(userId: $userId, tokenId: $_POST['token_id']);

            case 'js_files':
                $urlJsFile = $this->getJsFile();
                header('Location: '.$urlJsFile);
                die();

            case 'css_files':
                $urlCssFile = $this->getCssFile();
                header('Location: '.$urlCssFile);
                die();

            default:
                return $this->getInstancePayment()->callAction($action, $userId);
        }

    }

    public function getJsFile():string
    {
        return $this->getInstancePayment()->getJsFile();
    }

    public function getCssFile():string
    {
        return $this->getInstancePayment()->getCssFile();
    }

}