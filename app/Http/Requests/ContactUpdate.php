<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('contacts.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname'            => 'required|string',
            'email'               => 'required|string|unique:contacts,email,' . $this->route('contact'),
            'status'              => 'required|numeric',
            'contact_receiver_id' => 'required|numeric',
            'address'             => 'string',
            'note'                => 'string|nullable',
            'phone_number'        => 'string',
            'is_important'        => 'numeric|required',
            'user_created'        => 'numeric',
            'user_updated'        => 'numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_updated' => auth()->user()->id,
        ]);
    }
}
