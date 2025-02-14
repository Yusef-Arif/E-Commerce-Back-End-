<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $request->user_id]);

        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return ['message' => 'Product added to cart', 'cartItem' => $cartItem];
    }

    public function getCart($user_id)
    {
        $cart = Cart::where('user_id', $user_id)->with('products.product')->first();

        if (!$cart) {
            return ['message' => 'Cart is empty'];
        }

        return ['cart' => $cart];
    }

    public function removeFromCart($cart_item_id)
    {
        $cartItem = CartItem::find($cart_item_id);

        if (!$cartItem) {
            return ['message' => 'Cart item not found'];
        }

        $cartItem->delete();

        return ['message' => 'Product removed from cart'];
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $cart = Cart::where('user_id', $request->user_id)->with('products')->first();

        if (!$cart || $cart->products->isEmpty()) {
            return ['message' => 'Cart is empty'];
        }

        $cart->products()->delete();

        return ['message' => 'Checkout successful'];
    }
}
