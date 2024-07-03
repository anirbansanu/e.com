<?php
// app/Contracts/PaymentInterface.php

namespace App\Contracts;

interface PaymentInterface
{
    /**
     * Process a payment.
     *
     * @param float $amount The amount to be paid.
     * @return mixed
     */
    public function pay(float $amount);

    /**
     * Process a refund.
     *
     * @param string $transactionId The transaction ID to be refunded.
     * @return mixed
     */
    public function refund(string $transactionId);

    /**
     * Check the status of a transaction.
     *
     * @param string $transactionId The transaction ID to check.
     * @return mixed
     */
    public function getStatus(string $transactionId);

    /**
     * Retrieve payment details.
     *
     * @param string $transactionId The transaction ID for which details are retrieved.
     * @return mixed
     */
    public function getPaymentDetails(string $transactionId);

    /**
     * Process a pre-authorization.
     *
     * @param float $amount The amount to be pre-authorized.
     * @return mixed
     */
    public function preAuthorize(float $amount);

    /**
     * Capture a pre-authorized amount.
     *
     * @param string $authorizationId The authorization ID to capture.
     * @param float $amount The amount to be captured.
     * @return mixed
     */
    public function capture(string $authorizationId, float $amount);

    /**
     * Void a pre-authorization.
     *
     * @param string $authorizationId The authorization ID to void.
     * @return mixed
     */
    public function void(string $authorizationId);

    /**
     * Handle recurring payments.
     *
     * @param float $amount The amount for the recurring payment.
     * @param array $options Additional options like interval, duration, etc.
     * @return mixed
     */
    public function handleRecurring(float $amount, array $options);

    /**
     * Cancel a recurring payment.
     *
     * @param string $subscriptionId The subscription ID to cancel.
     * @return mixed
     */
    public function cancelRecurring(string $subscriptionId);

    /**
     * Update a recurring payment.
     *
     * @param string $subscriptionId The subscription ID to update.
     * @param array $options Updated options like interval, amount, etc.
     * @return mixed
     */
    public function updateRecurring(string $subscriptionId, array $options);

    // Add more methods as needed
}
