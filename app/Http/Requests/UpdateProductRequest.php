<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'name'    => ['sometimes', 'required', 'string', 'min:10', 'max:255'],
            'status'  => ['sometimes', 'required', Rule::in(['available','unavailable'])],
            'data'    => ['nullable', 'array'],

            'article' => [
                Rule::prohibitedIf(config('products.role') !== 'admin'),
                Rule::when(config('products.role') === 'admin', [
                    'required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9]+$/',
                    Rule::unique('products', 'article')->ignore($product?->id),
                ]),
            ],
        ];
    }
}
