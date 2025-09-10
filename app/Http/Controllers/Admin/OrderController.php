<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'table' => 'required|string',
        ]);

        $cart = $request->cart;
        $table = $request->table;

        // Create the order
        $order = Order::create([
            'table_number' => $table,
            'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['qty']),
            'cart_data' => $cart,
        ]);

        // Create order items
        foreach ($cart as $foodId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $foodId,
                'food_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['qty'],
            ]);
        }

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }
    public function destroy(Order $order)
    {
        $order->items()->delete(); // remove related items first
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }
}
