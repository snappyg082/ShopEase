<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    public function add($product_id)
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product_id],
            ['quantity' => 0]
        );

        $cart->increment('quantity');

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart!');
    }

    public function remove($product_id)
    {
        Cart::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Product removed from cart!');
    }

    public function update(Request $request, $id)
    {
       Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->update(['quantity' => $request->input('quantity')]);

        return redirect()->route('cart.index');
          
    }
}
