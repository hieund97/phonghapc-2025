<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductSort extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'type' => 'required|string|in:category,home',
            'orders' => 'required|array',
            'orders.*' => 'required|integer',
        ];
    }
}
