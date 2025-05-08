<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('roles.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'guard_name' => 'required|string|in:'.implode(',', array_keys(config('auth.guards'))),
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:'.config('permission.table_names.permissions').',name',
        ];
    }
}
