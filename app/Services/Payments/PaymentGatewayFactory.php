<?php
namespace App\Services\Payments;

use App\Services\Payments\Contracts\PaymentGatewayInterface;
use App\Services\Payments\Drivers\StripeGateway;
use InvalidArgumentException;

class PaymentGatewayFactory
{
    protected array $map = [
        'stripe' => StripeGateway::class,
    ];

    public function make(string $method): PaymentGatewayInterface
    {
        $method = strtolower($method);

        if (!isset($this->map[$method])) {
            throw new InvalidArgumentException("Unsupported payment method: $method");
        }

        return app($this->map[$method]);
    }
}
