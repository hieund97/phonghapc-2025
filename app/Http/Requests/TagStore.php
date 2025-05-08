<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TagStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('tags.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:tags',
            'slug' => 'nullable|string|max:100|unique:tags',
            'type' => 'required|string',
            'order_column' => 'numeric',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->slug ?: Str::slug($this->name),
        ]);
    }
}
