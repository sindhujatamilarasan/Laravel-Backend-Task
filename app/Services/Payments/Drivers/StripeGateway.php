<?php

namespace App\Services\Payments\Drivers;

use App\Models\Product;
use App\Models\User;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeGateway implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function charge(Product $product, User $user): array
    {
        $intent = PaymentIntent::create([
            'amount' => 10000, // Fixed ₹100 for testing
            'currency' => 'inr',
            'metadata' => [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
        ]);

        return [
            'provider' => 'stripe',
            'status' => $intent->status,
            'reference' => $intent->id,
            'client_secret' => $intent->client_secret,
        ];
    }
}
