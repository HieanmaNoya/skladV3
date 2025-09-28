<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{

    public function getUserCart(int $userId): Collection
    {
        return Cart::with('product')
            ->where('user_id', $userId)
            ->get();
    }

    public function addToCart(int $userId, int $productId, int $quantity): Cart
    {
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            $cartItem->refresh();
        } else {
            $cartItem = Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        $cartItem->load('product');
        return $cartItem;
    }

    public function updateQuantity(Cart $cart, int $quantity): Cart
    {
        $cart->update(['quantity' => $quantity]);
        $cart->load('product');

        return $cart;
    }

    public function removeFromCart(Cart $cart): void
    {
        $cart->delete();
    }

    public function clearCart(int $userId): void
    {
        Cart::where('user_id', $userId)->delete();
    }

    public function getCartSummary(Collection $cartItems): array
    {
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $totalItems = $cartItems->sum('quantity');

        return [
            'total_items' => $totalItems,
            'total_price' => $totalPrice,
            'items_count' => $cartItems->count(),
        ];
    }

    public function belongsToUser(Cart $cart, int $userId): bool
    {
        return $cart->user_id === $userId;
    }
}
