<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id',$user->id)->get();

        return view('home',compact('products'));
    }

    public function create()
    {
        return view('products.form');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.form', compact('product'));
    }

    public function store(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        Product::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'user_id'=> $user->id
        ]);

        return redirect()->route('home')->with('success', 'Product created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
        ]);

        $product = Product::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->first();

        if (!$product) {
            return redirect()->route('home')->with('error', 'Unauthorized or product not found.');
        }

        $product->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('home')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->first();

        if (!$product) {
            return redirect()->route('home')->with('error', 'Unauthorized or product not found.');
        }

        $product->delete();

        return redirect()->route('home')->with('success', 'Product deleted successfully.');
    }


}
