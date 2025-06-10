<?php

namespace App\Services\Payments\Contracts;

use App\Models\Product;
use App\Models\User;

interface PaymentGatewayInterface
{
    public function charge(Product $product, User $user): array;
}
