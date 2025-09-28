<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->cart->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Количество обязательно для заполнения',
            'quantity.integer' => 'Количество должно быть целым числом',
            'quantity.min' => 'Минимальное количество: 1',
            'quantity.max' => 'Максимальное количество: 10',
        ];
    }
}
