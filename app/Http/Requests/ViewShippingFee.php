<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViewShippingFee extends FormRequest
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
            'address' => 'required|array',
            'address.address' => 'nullable|string',
            'address.street' => 'nullable|string|max:60',
            'address.ward' => 'nullable|string|max:60',
            'address.district' => 'required|string|max:30',
            'address.province' => 'required|string|max:30',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        get_addresses($this);
    }
}
