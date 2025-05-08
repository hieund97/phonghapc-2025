<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ContactReceiverStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('contacts_receiver.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:contact_receivers',
            'description' => 'required|string',
            'status' => 'required|numeric',
            'user_created' => 'numeric',
            'user_updated' => 'numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_created' => auth()->user()->id,
        ]);
    }
}
