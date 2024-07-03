<?php
// app/Services/PaymentMethods/PayPalPayment.php

namespace App\Services\PaymentMethods;

use App\Contracts\PaymentInterface;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Api\Transaction;
use PayPal\Api\Capture;
use PayPal\Api\Authorization;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PayPalPayment extends BasePayment
{
    protected $apiContext;

    public function __construct()
    {
        $paypalConfig = config('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );

        $this->apiContext->setConfig($paypalConfig['settings']);
    }

    public function pay(float $amount)
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amountInstance = new Amount();
        $amountInstance->setCurrency("USD")
                       ->setTotal($amount);

        $transaction = new Transaction();
        $transaction->setAmount($amountInstance)
                    ->setDescription("Payment description");

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.success'))
                     ->setCancelUrl(route('payment.cancel'));

        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            $this->storePaymentDetails(
                $payment->getId(),
                'paypal',
                $amount,
                'USD',
                'created',
                $payment->toArray()
            );
            return $payment->getApprovalLink();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

    public function refund(string $transactionId)
    {
        try {
            $sale = Sale::get($transactionId, $this->apiContext);
            $refund = new Refund();
            $sale->refund($refund, $this->apiContext);
            $this->storePaymentDetails(
                $transactionId,
                'paypal',
                $sale->getAmount()->getTotal(),
                $sale->getAmount()->getCurrency(),
                'refunded',
                $refund->toArray()
            );
            return "Refund processed successfully.";
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

    public function getStatus(string $transactionId)
    {
        try {
            $payment = Payment::get($transactionId, $this->apiContext);
            return $payment->getState();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

    public function getPaymentDetails(string $transactionId)
    {
        try {
            $payment = Payment::get($transactionId, $this->apiContext);
            return $payment->toArray();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

    public function preAuthorize(float $amount)
    {
        // Pre-authorization logic
        // Implementing similar to the pay method but with "authorize" intent
    }

    public function capture(string $authorizationId, float $amount)
    {
        try {
            $authorization = Authorization::get($authorizationId, $this->apiContext);
            $amountInstance = new Amount();
            $amountInstance->setCurrency("USD")
                           ->setTotal($amount);

            $capture = new Capture();
            $capture->setAmount($amountInstance);

            $authorization->capture($capture, $this->apiContext);
            return "Capture processed successfully.";
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

    public function void(string $authorizationId)
    {
        try {
            $authorization = Authorization::get($authorizationId, $this->apiContext);
            $authorization->void($this->apiContext);
            return "Authorization voided successfully.";
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

    public function handleRecurring(float $amount, array $options)
    {
        $plan = new Plan();
        $plan->setName($options['plan_name'])
            ->setDescription($options['plan_description'])
            ->setType('INFINITE');

        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName($options['payment_definition_name'])
            ->setType('REGULAR')
            ->setFrequency($options['frequency']) // E.g., 'Month'
            ->setFrequencyInterval($options['frequency_interval']) // E.g., '1'
            ->setCycles($options['cycles']) // E.g., '12'
            ->setAmount(new Amount(['value' => $amount, 'currency' => 'USD']));

        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(route('payment.success'))
            ->setCancelUrl(route('payment.cancel'))
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('0')
            ->setSetupFee(new Amount(['value' => $options['setup_fee'], 'currency' => 'USD']));

        $plan->setPaymentDefinitions([$paymentDefinition]);
        $plan->setMerchantPreferences($merchantPreferences);

        try {
            $createdPlan = $plan->create($this->apiContext);

            $patch = new \PayPal\Api\Patch();
            $value = new \PayPal\Common\PayPalModel('{"state":"ACTIVE"}');
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);

            $patchRequest = new \PayPal\Api\PatchRequest();
            $patchRequest->addPatch($patch);

            $createdPlan->update($patchRequest, $this->apiContext);
            $activatedPlan = Plan::get($createdPlan->getId(), $this->apiContext);

            $agreement = new Agreement();
            $agreement->setName($options['agreement_name'])
                ->setDescription($options['agreement_description'])
                ->setStartDate(gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 month", time())));

            $plan = new Plan();
            $plan->setId($activatedPlan->getId());
            $agreement->setPlan($plan);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $agreement->setPayer($payer);

            $shippingAddress = new ShippingAddress();
            $shippingAddress->setLine1($options['shipping_address']['line1'])
                ->setCity($options['shipping_address']['city'])
                ->setState($options['shipping_address']['state'])
                ->setPostalCode($options['shipping_address']['postal_code'])
                ->setCountryCode($options['shipping_address']['country_code']);
            $agreement->setShippingAddress($shippingAddress);

            $agreement = $agreement->create($this->apiContext);

            return $agreement->getApprovalLink();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

    public function cancelRecurring(string $subscriptionId)
    {
        try {
            $agreement = Agreement::get($subscriptionId, $this->apiContext);
            $agreementStateDescriptor = new AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Cancelling the agreement");

            $agreement->cancel($agreementStateDescriptor, $this->apiContext);
            $cancelAgreementDetails = Agreement::get($subscriptionId, $this->apiContext);

            return $cancelAgreementDetails;
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

    public function updateRecurring(string $subscriptionId, array $options)
    {
        try {
            $agreement = Agreement::get($subscriptionId, $this->apiContext);

            $patch = new \PayPal\Api\Patch();
            $value = new \PayPal\Common\PayPalModel(json_encode([
                'plan' => [
                    'id' => $options['new_plan_id']
                ]
            ]));
            $patch->setOp('replace')
                ->setPath('/plan')
                ->setValue($value);

            $patchRequest = new \PayPal\Api\PatchRequest();
            $patchRequest->addPatch($patch);

            $agreement->update($patchRequest, $this->apiContext);
            $updatedAgreement = Agreement::get($subscriptionId, $this->apiContext);

            return $updatedAgreement;
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return "Exception: " . $ex->getMessage();
        }
    }

}

