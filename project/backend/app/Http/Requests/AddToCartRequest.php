<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Авторизация через middleware
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'ID товара обязательно для заполнения',
            'product_id.exists' => 'Указанный товар не существует',
            'quantity.required' => 'Количество обязательно для заполнения',
            'quantity.integer' => 'Количество должно быть целым числом',
            'quantity.min' => 'Минимальное количество: 1',
            'quantity.max' => 'Максимальное количество за раз: 10',
        ];
    }
}
