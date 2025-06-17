<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Display checkout page
    public function checkout()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        return view('checkout.index', compact('cartItems'));
    }

    // Process the order
    public function placeOrder(Request $request)
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Here you could create order items if you want to track individual products per order

            // Clear the cart
            CartItem::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Failed to place order.');
        }
    }
}
