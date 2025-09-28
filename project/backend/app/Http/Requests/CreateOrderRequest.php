<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'shipping_address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Имя обязательно для заполнения',
            'customer_email.required' => 'Email обязателен для заполнения',
            'customer_email.email' => 'Введите корректный email',
            'shipping_address.required' => 'Адрес доставки обязателен',
        ];
    }
}
