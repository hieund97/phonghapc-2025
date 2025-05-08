<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NavigationUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('navigations.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:navigations,name,' .$this->navigation->id,
            'link' => 'required|string|max:100|unique:navigations,link,' .$this->navigation->id,
            'group' => 'required|string',
            'order' => 'integer|numeric',
            'display_in'=>'required|string',
        ];
    }
}
