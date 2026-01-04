<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:10', 'max:255'],
            'article' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9]+$/', 'unique:products,article'],
            'status'  => ['required', 'in:available,unavailable'],
            'data'    => ['nullable', 'array'],
            'data.*.key' => ['nullable', 'string', 'max:255'],
            'data.*.value' => ['nullable', 'string', 'max:255'],
        ];
    }
}
