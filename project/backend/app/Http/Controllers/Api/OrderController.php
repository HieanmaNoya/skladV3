<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Http\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrderFromCart(
                $request->user()->id,
                $request->validated()
            );

            return response()->json([
                'message' => 'Заказ успешно оформлен',
                'order_number' => $order->order_number,
                'order' => $order
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при оформлении заказа: ' . $e->getMessage()
            ], 422);
        }
    }

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getUserOrders(auth()->id());

        return response()->json([
            'orders' => $orders
        ]);
    }

    public function show(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        return response()->json([
            'order' => $order
        ]);
    }
}
