<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactReceiverUpdate extends FormRequest
{
    /**
     * @var mixed
     */

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('contacts_receiver.udate');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|unique:contact_receivers,title,'.$this->route('receiver'),
            'description' => 'required|string',
            'status' => 'required|string',
            'user_created' => 'string',
            'user_updated' => 'string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_updated' => auth()->user()->name,
        ]);
    }
}
