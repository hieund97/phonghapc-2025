<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TextLinkUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('text_links.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'model' => 'required|string',
            'model_id' => 'nullable|integer',
            'text' => 'nullable|string',
            'link' => 'nullable|string',
            'rel' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'sort' => 'nullable|integer',
            'type' => 'required|integer',
            'is_home' => 'required|boolean',
            'status' => 'required|boolean',
            'list_id' => 'nullable|string',
            'index' => 'nullable|string',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_home' => !empty($this->is_home),
            'status' => !empty($this->status),
        ]);
    }
}
