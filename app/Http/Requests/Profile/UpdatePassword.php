<?php

namespace App\Http\Requests\Profile;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
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
            'old_password' => ['required', 'string', 'max:255', new MatchOldPassword],
            'password' => 'required|string|min:6|max:255|confirmed',
        ];
    }
}
