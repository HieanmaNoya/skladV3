<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Http\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function index(): JsonResponse
    {
        $cartItems = $this->cartService->getUserCart(auth()->id());
        $summary = $this->cartService->getCartSummary($cartItems);

        $formattedItems = $cartItems->map(function ($item) {
            return $this->formatCartItem($item);
        });

        return response()->json([
            'items' => $formattedItems,
            'summary' => $summary
        ]);
    }

    public function add(AddToCartRequest $request): JsonResponse
    {
        $cartItem = $this->cartService->addToCart(
            $request->user()->id,
            $request->product_id,
            $request->quantity
        );

        return response()->json([
            'message' => 'Товар добавлен в корзину',
            'data' => $this->formatCartItem($cartItem)
        ], 201);
    }

    public function update(UpdateCartRequest $request, Cart $cart): JsonResponse
    {
        $updatedCart = $this->cartService->updateQuantity($cart, $request->quantity);

        return response()->json([
            'message' => 'Количество товара обновлено',
            'data' => $this->formatCartItem($updatedCart)
        ]);
    }

    public function remove(Cart $cart): JsonResponse
    {
        if (!$this->cartService->belongsToUser($cart, auth()->id())) {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        $this->cartService->removeFromCart($cart);

        return response()->json([
            'message' => 'Товар удален из корзины'
        ]);
    }

    public function clear(): JsonResponse
    {
        $this->cartService->clearCart(auth()->id());

        return response()->json([
            'message' => 'Корзина очищена'
        ]);
    }

    private function formatCartItem(Cart $cartItem): array
    {
        return [
            'id' => $cartItem->id,
            'product_id' => $cartItem->product_id,
            'product_name' => $cartItem->product->name,
            'product_price' => $cartItem->product->price,
            'quantity' => $cartItem->quantity,
            'total' => $cartItem->quantity * $cartItem->product->price,
            'added_at' => $cartItem->created_at->format('d.m.Y H:i'),
        ];
    }
}
