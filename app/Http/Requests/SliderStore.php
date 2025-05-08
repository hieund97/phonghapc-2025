<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('sliders.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string',
            'info'        => 'nullable|string',
            'thumbnail'   => 'string',
            'link'        => 'string|nullable',
            'model'       => 'nullable|string',
            'model_id'    => 'nullable|integer',
            'target'      => 'nullable|string',
            'rel'         => 'nullable|string',
            'sort'        => 'nullable|integer',
            'status'      => 'nullable|integer',
            'description' => 'string',
            'picture'     => 'required|string',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (empty($this->model_id)) {
            $this->merge([
                'model_id' => 0,
            ]);
        }
    }
}
