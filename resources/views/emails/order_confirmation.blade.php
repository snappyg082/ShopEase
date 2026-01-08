<h1>Order Confirmation</h1>
<p>Hi {{ $order->user->name }},</p>
<p>Your order #{{ $order->id }} has been successfully placed.</p>
<p>Total Amount: ${{ $order->total }}</p>
<p>Thank you for shopping with us!</p>