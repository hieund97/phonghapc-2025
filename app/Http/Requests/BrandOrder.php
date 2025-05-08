<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'order' => 'required|array',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'order' => !is_array($this->order) ? json_decode($this->order, true) : $this->order,
        ]);
    }
}
