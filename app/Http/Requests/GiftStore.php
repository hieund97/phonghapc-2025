<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('product_categories.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|string',
            'content'               => 'required|string',
            'status'                => 'required|integer',
            'product_category_id.*' => 'required|exists:product_categories,id',
        ];
    }
}
