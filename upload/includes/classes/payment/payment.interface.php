<?php

/**
 * Payment System Interface
 * Defines the contract for all payment processors
 */
interface PaymentSystemInterface
{

    /**
     * Handles successful payment
     * @param string $transactionId Transaction identifier
     * @param array $data Additional data
     * @return bool
     */
    public function successPayment(string $transactionId, array $data = []): bool;

    /**
     * Handles failed payment
     * @param string $transactionId Transaction identifier
     * @param string $reason Failure reason
     * @param array $data Additional data
     * @return bool
     */
    public function failedPayment(string $transactionId, string $reason, array $data = []): bool;

    /**
     * Retrieves payment data
     * @param string $transactionId Transaction identifier
     * @return array Contains: date, amount, currency, totalRefundAmount,
     *               status (completed, cancelled, failed), billingAddress, attributes
     */
    public function getPaymentData(string $transactionId): array;

    /**
     * Creates payment from stored token
     * @param string $token Stored payment token
     * @param float $amount Amount to charge
     * @param string $currency Currency code
     * @return array Payment response with transaction details
     */
    public function createPaymentFromToken(string $token, float $amount, string $currency): array;

    /**
     * Confirms successful token-based payment
     * @param string $transactionId Transaction identifier
     * @param string $token Token used
     * @return bool
     */
    public function successPaymentFromToken(string $transactionId, string $token): bool;

    /**
     * Handles failed token-based payment
     * @param string $transactionId Transaction identifier
     * @param string $token Token used
     * @param string $reason Failure reason
     * @return bool
     */
    public function failedPaymentFromToken(string $transactionId, string $token, string $reason): bool;

    /**
     * Initiates refund
     * @param string $transactionId Original transaction identifier
     * @param float|null $amount Amount to refund (null = full)
     * @return array Refund response with refund details
     */
    public function refundPayment(string $transactionId, ?float $amount = null): array;

    /**
     * Confirms successful refund
     * @param string $refundId Refund identifier
     * @param string $originalTransactionId Original transaction
     * @return bool
     */
    public function successRefundPayment(string $refundId, string $originalTransactionId): bool;

    /**
     * Handles failed refund
     * @param string $refundId Refund identifier
     * @param string $originalTransactionId Original transaction
     * @param string $reason Failure reason
     * @return bool
     */
    public function failedRefundPayment(string $refundId, string $originalTransactionId, string $reason): bool;

    /**
     * Retrieves all active tokens for a user
     * @param int $userId User identifier
     */
    public function getAllActiveTokensFromUser($userId);

    /**
     * Retrieves all transaction for a $idUserMembership
     * @param int $idUserMembership
     * @return array List of transactions
     */
    public function getAllTransaction(int $idUserMembership): array;

    /**
     * Deletes user token
     * @param int $userId User identifier
     * @param string $token Token to delete
     */
    public function deleteTokenFromUser($userId, string $token);

    /**
     * Generates HTML for token CRUD management
     * @return string Generated HTML
     */
    public function getHtmlForCrudToken(): string;

    /**
     * Generates payment display HTML
     * @return string Generated HTML
     */
    public function getHtmlPayment(): string;

    /**
     * Call action for ajax request
     * @param string $action
     * @param int $userId User identifier
     * @return array array for response with json_encode
     */
    public function callAction(string $action, int $userId) :array;

    public function getJsFile() :string;

    public function getCssFile() :string;
}