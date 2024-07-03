<?php
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
