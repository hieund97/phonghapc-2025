<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NavigationStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('navigations.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:navigations,name',
            'link' => 'required|string|unique:navigations,link',
            'group' => 'required|string',
            'order' => 'integer|numeric',
            'display_in'=>'required|string',
        ];
    }
}
