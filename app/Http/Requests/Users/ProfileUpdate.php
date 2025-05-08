<?php

namespace App\Http\Requests\Users;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            //'email' => 'required|email|max:255|unique:users',
            'current_password' => ['required_with:password', 'string', 'max:255', new MatchOldPassword],
            'password' => 'nullable|string|max:255|confirmed',
            'mobile' => 'required|string|min:10|max:11',
            'address' => 'nullable|array',
            'address.phone_number' => 'nullable|integer|size:10',
            'address.address' => 'required_with:address|string',
            'address.street' => 'nullable|string|max:60',
            'address.ward' => 'nullable|string|max:60',
            'address.district' => 'required_with:address|string|max:30',
            'address.province' => 'required_with:address|string|max:30',
            'address.country' => 'required_with:address|string|max:30',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        get_addresses($this);
    }
}
