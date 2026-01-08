<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RecentOrders;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use App\Models\OrderNotification;

class OrderController extends Controller
{

    public function placeOrder(Request $request)
    {
        // 1️⃣ Validate request (optional but recommended)
        $request->validate([
            'total_price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        // 2️⃣ Create the order
        $order = Order::create([
            'user_id' => $request->user_id,
            'total_price' => $request->total_price,
            'status' => 'pending', // default order status
            'created_at' => now(),
            'updated_at' => now(),
        ]);



        // 3️⃣ Send confirmation email
        try {
            Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
        } catch (\Exception $e) {
            Log::error('Email failed: ' . $e->getMessage());
        }

        // 4️⃣ Send SMS via Twilio
        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            $twilio->messages->create($order->user->phone, [
                'from' => env('TWILIO_NUMBER'),
                'body' => "Hi {$order->user->name}, your order #{$order->id} has been placed successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('SMS failed: ' . $e->getMessage());
        }
        // After sending email
        OrderNotification::create([
            'order_id' => $order->id,
            'type' => 'email',
            'recipient' => $order->user->email,
            'message' => "Order confirmation email sent for order #{$order->id}"
        ]);

        // After sending SMS
        OrderNotification::create([
            'order_id' => $order->id,
            'type' => 'sms',
            'recipient' => $order->user->phone,
            'message' => "Order confirmation SMS sent for order #{$order->id}"
        ]);

        // 5️⃣ Redirect to success page
        return redirect()->route('order.success')->with('message', 'Order placed successfully!');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth::id())->with('product')->get();
        return view('orders.index', compact('orders'));
    }

    public function store()
    {
        $cartItems = Cart::where('user_id', auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty.');
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Create order with all cart items combined
        $order = Order::create([
            'user_id' => auth::id(),
            'product_id' => $cartItems->first()->product->id,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // Create recent orders entries for tracking
        foreach ($cartItems as $item) {
            RecentOrders::create([
                'user_id' => auth::id(),
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'total_price' => $item->product->price * $item->quantity,
                'status' => 'pending'
            ]);
        }

        // Clear the cart
        Cart::where('user_id', auth::id())->delete();

        return redirect('/orders')->with('success', 'Order placed successfully!');
    }
    public function viewNotifications($orderId)
    {
        $order = Order::with('notifications')->findOrFail($orderId);

        return view('orders.notifications', compact('order'));
    }
}
