## Payment Method Integration Documentation

### Overview

This documentation explains the structure and implementation of the payment methods in the project. The project is designed to support multiple payment gateways such as PayPal and Razorpay, following a consistent and reusable pattern.

### Directory Structure

The payment methods are located in the `App\Services\PaymentMethods` directory, and the payment interface is located in the `App\Contracts` directory. The `PaymentService` and `PaymentController` are located in their respective directories.

```
app/
|-- Contracts/
|   |-- PaymentInterface.php
|
|-- Services/
|   |-- PaymentMethods/
|       |-- BasePayment.php
|       |-- PayPalPayment.php
|       |-- RazorpayPayment.php
|       |-- PaymentService.php
|
|-- Http/
    |-- Controllers/
        |-- PaymentController.php
```

### Contracts

#### PaymentInterface.php

The `PaymentInterface` defines the methods that all payment classes must implement. This ensures a consistent interface for all payment methods.

```php
namespace App\Contracts;

interface PaymentInterface
{
    public function pay(float $amount);
    public function refund(string $transactionId);
}
```

### Base Class

#### BasePayment.php

The `BasePayment` class is an abstract class that implements the `PaymentInterface`. It provides a common method for storing payment details in the database.

```php
namespace App\Services\PaymentMethods;

use App\Contracts\PaymentInterface;
use App\Models\Payment;

abstract class BasePayment implements PaymentInterface
{
    protected function storePaymentDetails($transactionId, $method, $amount, $currency, $status, $response)
    {
        Payment::create([
            'transaction_id' => $transactionId,
            'payment_method' => $method,
            'amount' => $amount,
            'currency' => $currency,
            'status' => $status,
            'response' => json_encode($response),
        ]);
    }
}
```

### Payment Methods

#### PayPalPayment.php

The `PayPalPayment` class extends the `BasePayment` class and implements the `pay` and `refund` methods for PayPal.

```php
namespace App\Services\PaymentMethods;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Api\Transaction;
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
}
```

#### RazorpayPayment.php

The `RazorpayPayment` class extends the `BasePayment` class and implements the `pay` and `refund` methods for Razorpay.

```php
namespace App\Services\PaymentMethods;

use Razorpay\Api\Api;
use Exception;

class RazorpayPayment extends BasePayment
{
    protected $api;

    public function __construct()
    {
        $config = config('payments.gateways.razorpay');
        $this->api = new Api($config['key_id'], $config['key_secret']);
    }

    public function pay(float $amount)
    {
        try {
            $order = $this->api->order->create([
                'receipt' => uniqid(),
                'amount' => $amount * 100, // amount in paise
                'currency' => 'INR',
                'payment_capture' => 1 // auto capture
            ]);

            $this->storePaymentDetails(
                $order->id,
                'razorpay',
                $amount,
                'INR',
                'created',
                $order->toArray()
            );

            return $order;
        } catch (Exception $e) {
            throw new Exception("Error Processing Razorpay Payment: " . $e->getMessage());
        }
    }

    public function refund(string $transactionId)
    {
        try {
            $refund = $this->api->payment->fetch($transactionId)->refund();
            $this->storePaymentDetails(
                $transactionId,
                'razorpay',
                $refund->amount / 100,
                'INR',
                'refunded',
                $refund->toArray()
            );
            return $refund;
        } catch (Exception $e) {
            throw new Exception("Error Processing Razorpay Refund: " . $e->getMessage());
        }
    }
}
```

### Services

#### PaymentService.php

The `PaymentService` class is responsible for creating instances of the payment methods based on the configuration.

```php
namespace App\Services\PaymentMethods;

use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\App;
use InvalidArgumentException;

class PaymentService
{
    public static function create(string $method): PaymentInterface
    {
        $gateways = config('payments.gateways');

        if (!isset($gateways[$method])) {
            throw new InvalidArgumentException("Payment method [$method] not supported.");
        }

        $class = $gateways[$method]['class'];

        return App::make($class);
    }
}
```

### Controllers

#### PaymentController.php

The `PaymentController` handles the payment processing requests. It validates the input and uses the `PaymentService` to process the payment.

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentMethods\PaymentService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $paymentMethod = $request->input('payment_method');
        $amount = $request->input('amount');

        try {
            $payment = PaymentService::create($paymentMethod);
            $response = $payment->pay($amount);

            return response()->json([
                'success' => true,
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed. Please try again.',
            ], 500);
        }
    }
}
```

### Database

#### Migration: create_payments_table.php

Ensure the `payments` table has the required columns to store the payment details.

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->string('payment_method');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('status');
            $table->json('response');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
```

#### Model: Payment.php

The `Payment` model interacts with the `payments` table.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'payment_method',
        'amount',
        'currency',
        'status',
        'response',
    ];
}
```

