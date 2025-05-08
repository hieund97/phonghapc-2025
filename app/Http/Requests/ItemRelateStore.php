<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRelateStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->can('item_relates.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'image' => 'required|string',
            'link' => 'required|string',
            'model' => 'nullable|string',
            'model_id' => 'nullable|integer',
            'target' => 'nullable|string',
            'rel' => 'nullable|string',
            'sort' => 'nullable|integer',

        ];
    }
}
