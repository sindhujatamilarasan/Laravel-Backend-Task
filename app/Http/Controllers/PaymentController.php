<?php

// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Payments\PaymentGatewayFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    // NOTE: For production, use Stripe webhook or confirm status after client completes payment.

    public function initiate(Request $request, PaymentGatewayFactory $factory)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'payment_method' => 'required|string',
        ]);

        return DB::transaction(function () use ($data, $request, $factory) {
            $user = $request->user();

            $product = Product::where('id', $data['product_id'])
                              ->lockForUpdate()
                              ->first();

            if ($product->user_id !== $user->id) {
                return response()->json(['success' => false, 'message' => 'Forbidden – you do not own this product.'], 403);
            }

            if ($product->quantity < 1) {
                return response()->json(['success' => false, 'message' => 'Out of stock'], 409);
            }

            $product->decrement('quantity');

            $gateway = $factory->make($data['payment_method']);
            $paymentResponse = $gateway->charge($product, $user);

            return response()->json([
                'success' => true,
                'payment' => $paymentResponse,
            ], 201);
        });
    }
}
