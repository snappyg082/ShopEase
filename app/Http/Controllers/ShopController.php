<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;


class ShopController extends Controller
{
    
    public function products()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }


    public function carts()
    {
       $cartItems = Cart::where('user_id', Auth::id())
       ->with('product') 
       ->get();
       return view('shop.carts', compact('cartItems'));
    }
    public function orders()
    {
        $orders = Order::where('user_id', auth::id())->get();
        return view('shop.orders', compact('orders'));
    }
    
}
