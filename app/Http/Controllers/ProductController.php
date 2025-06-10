<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class ProductController extends Controller
{

    public function store(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {

            $isUpdate = !is_null($id);

            // ── 1. Validate
            $rules = [
                'name'     => ($id ? 'sometimes' : 'required') . '|string',
                'quantity' => ($id ? 'sometimes' : 'required') . '|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                DB::rollBack();

                $status = $id ? 422 : 400;

                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], $status);
            }

            $data = $validator->validated();
            $user = $request->user();

            // ── 2. Update flow
            if ($id) {

               $product = Product::find($id);

                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found.',
                    ], 404);
                }

                if ($product->user_id !== auth()->id()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Forbidden – you do not own this product.',
                    ], 403);
                }


                $product->update($data);
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully.',
                    'data'    => $product,
                ]);
            }

            // ── 3. Create flow
            $product = $user->products()->create($data);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully.',
                'data'    => $product,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function list(Request $request)
    {
            try {
                $user = Auth::user();
                $products = Product::where('user_id', $user->id)->get();

                return response()->json([
                    'success' => true,
                    'data' => [
                        'products' => $products
                    ]
                ], 200);

            } catch (\Exception $e) {
                return $this->sendErrorResponse($e->getMessage(), [], 500);
            }

    }



    public function delete(Request $request, int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.',
                ], 404);
            }

            if ($product->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden – you do not own this product.',
                ], 403);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                 'message' => 'Product Deleted Successfully',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage(),
            ], 500);

        }
    }

}
