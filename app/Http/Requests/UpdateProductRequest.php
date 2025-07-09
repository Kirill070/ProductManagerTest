<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:10|max:255',
            'status' => 'required|in:available,unavailable',
            'data' => 'nullable|array',
        ];

        // Только админ может редактировать артикул
        if (config('products.role') === 'admin') {
            $rules['article'] = 'required|string|regex:/^[a-zA-Z0-9]+$/|unique:products,article,' . $this->route('product')->id;
        }

        return $rules;
    }
}
