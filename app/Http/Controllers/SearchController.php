<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Sms;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {


        $query = trim($request->search);

        // If search is empty, just go back
        if ($query === '') {
            return redirect()->back();
        }

        // -------------------------------
        // Products search
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        // Sms search
        $sms = Sms::where('type', 'LIKE', "%{$query}%")
            ->orWhere('subject', 'LIKE', "%{$query}%")
            ->get();

        //Chatbot,Sms,Products and orders search link controllers
        $isChatbotSearch = str_contains(strtolower($query), 'chatbot');
        $isMessageSearch = str_contains(strtolower($query), 'message');
        $isOrderSearch = str_contains(strtolower($query), 'order');
        $isProductSearch = str_contains(strtolower($query), 'product');
        $isCartSearch = str_contains(strtolower($query), 'cart');


        // -------------------------------
        // Cart items (logged-in user)
        $carts = Cart::where('user_id', Auth::id())
            ->whereHas('product', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->get();

        // Orders (search by USER NAME)
        $orders = Order::whereHas('user', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })
            ->with('user') // eager load user
            ->get();

        // -------------------------------
        // Return search results view
        return view('search.results', compact(
            'query',
            'products',
            'carts',
            'orders',
            'isChatbotSearch',
            'isMessageSearch',
            'isProductSearch',
            'isCartSearch',
            'isOrderSearch'


        ));
    }
}
