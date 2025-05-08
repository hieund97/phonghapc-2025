<?php

namespace App\Http\Requests;

use App\Models\AlepayBank;
use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Cart;


class Checkout extends FormRequest
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
            'customer_id'                 => 'nullable|integer|exists:users,id',
            'customer_name'               => 'required|string|min:3|max:30',
            'customer_email'              => 'required|email:rfc,dns,filter',
            'customer_mobile'             => 'required|phone:VN',
            'customer_id_card'            => 'nullable|string',
            'customer_id_card_image'      => 'nullable|string',
            'customer_amount_installment' => 'nullable|integer',
            'customer_note'               => 'nullable|string',
            'products'                    => 'required|array',
            'products.*.id'               => 'required|integer|exists:products,id',
            'products.*.quantity'         => 'required|integer|min:1|max:9999',
            'address'                     => 'required|array',
            'address.phone_number'        => 'nullable|phone:VN',
            'address.address'             => 'required|string',
            'address.street'              => 'nullable|string|max:60',
            'address.ward'                => 'nullable|string|max:60',
            'address.district'            => 'required|string|max:30',
            'address.province'            => 'required|string|max:30',
            'address.country'             => 'required|string|max:30',
            'payment_method'              => 'nullable|string||in:' . implode(',',
                    array_keys(config('admin.payment_method'))),
            'month'                       => 'nullable|integer',
            'bank_code'                   => [
                'required_with:month',
                'string',
                'in:' . ($alepay = AlepayBank::all(['code', 'payment_methods']))->pluck('code')->implode(','),
            ],
            'installment_type'            => [
                'required_with:month',
                'string',
                function ($attribute, $value, $fail) use ($alepay) {
                    $bank = $alepay->where('code', $this->bank_code)->first();

                    if (!in_array($value, $bank->payment_methods ?? [])) {
                        $fail($attribute . ' is invalid.');
                    }
                },
            ],
            'coupon_code'                 => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Coupon::where('code', $value)->where('expires_at', '>=', now()->format('Y-m-d'))->exists()) {
                        $fail(__(':attribute is invalid.', ['attribute' => $attribute]));
                    }
                },
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $cartCollection = Cart::getContent();

        $products = [];

        foreach ($cartCollection as $item) {
            $products[] = [
                "id"         => $item->id,
                "quantity"   => $item->quantity,
                'price'      => $item->price,
                'name'       => $item->name,
                'config_img' => $item->config_img,
            ];
        }
        $this->merge(['products' => $products]);
    }
}
