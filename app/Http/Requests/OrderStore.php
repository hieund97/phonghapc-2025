<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('orders.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|int',
            'customer_name' => 'required|string',
            'customer_mobile' => 'required|string',
            'customer_address' => 'required|string',
            'customer_note' => 'nullable|string',
            'note' => 'nullable|string',
            'total_price' => 'required|int',
            'extra_name' => 'nullable|string',
            'extra_price' => 'nullable|int',
            'total_payment_price' => 'required|int',
            'thumbnail' => 'nullable|string',
            'status' => 'required|int',
            'coupon_code' => 'nullable|string',
        ];
    }
}
