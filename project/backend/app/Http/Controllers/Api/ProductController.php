<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $products = Product::paginate($perPage);

        return response()->json([
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'data' => $product
        ]);
    }

    public function test(): JsonResponse
    {
        return response()->json(['message' => 'ProductController работает!']);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        // Проверка прав через политику
        $this->authorize('create', Product::class);

        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Товар успешно создан',
            'data' => $product
        ], 201);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        // Проверка прав через политику
        $this->authorize('update', $product);

        $product->update($request->validated());

        return response()->json([
            'message' => 'Товар успешно обновлен',
            'data' => $product
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return response()->json([
            'message' => 'Товар успешно удален'
        ]);
    }
}
