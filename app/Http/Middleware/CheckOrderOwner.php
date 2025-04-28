<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $orderId = $request->route('id');
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
