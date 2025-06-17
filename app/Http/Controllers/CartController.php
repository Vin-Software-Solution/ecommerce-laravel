<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Display the user's cart
    public function index()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    // Add a product to the cart
    public function add(Request $request, $productId)
    {
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->input('quantity', 1);
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->input('quantity', 1),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    // Remove an item from the cart
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        if ($cartItem->user_id == Auth::id()) {
            $cartItem->delete();
        }
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
