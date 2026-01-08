<?php

namespace App\Http\Controllers;
use Illuminate\View\view;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\RecentOrders;

class DashboardController extends Controller
{
    public function index(): View 
{
    $products = Product::paginate(10);
     $recentOrders = auth::check()
        ? Order::with('product')
            ->where('user_id', auth::id())
            ->latest()
            ->take(5)
            ->get()
        : collect();

    $cartItems = auth::check()
    ? Cart::where('user_id', auth::id())
        ->with('product')
        ->get()
    : collect();
    return view('dashboard', compact('products', 'cartItems','recentOrders'));
}


}
