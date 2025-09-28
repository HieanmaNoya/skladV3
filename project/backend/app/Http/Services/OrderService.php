<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private CartService $cartService)
    {
    }

    public function createOrderFromCart(int $userId, array $orderData): Order
    {
        return DB::transaction(function () use ($userId, $orderData) {
            $cartItems = Cart::with('product')
                ->where('user_id', $userId)
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Корзина пуста');
            }

            $totalAmount = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            $items = $cartItems->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                    'total_price' => $item->quantity * $item->product->price,
                ];
            })->toArray();

            // Создаем заказ
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => Order::generateOrderNumber(),
                'items' => $items,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'customer_name' => $orderData['customer_name'],
                'customer_email' => $orderData['customer_email'],
                'shipping_address' => $orderData['shipping_address'],
                'phone' => $orderData['phone'] ?? null,
                'notes' => $orderData['notes'] ?? null,
            ]);

            // Очищаем корзину
            Cart::where('user_id', $userId)->delete();

            return $order;
        });
    }

    public function getUserOrders(int $userId)
    {
        return Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getUserOrder(int $userId, int $orderId): ?Order
    {
        return Order::where('user_id', $userId)
            ->where('id', $orderId)
            ->first();
    }
}
