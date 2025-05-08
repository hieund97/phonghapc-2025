<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating'     => 'required|numeric|required_with:1,2,3,4,5',
            'product_id' => 'required|exists:products,id',
            'body'       => 'required|min:10',
            'full_name'  => 'required',
            'email'      => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'rating.required'    => 'Bạn chưa đánh giá điểm sao, vui lòng đánh giá.',
            'full_name.required' => 'Vui lòng nhập họ tên',
            'email.required'     => 'Vui lòng nhập Email.',
            'body.required'      => 'Vui lòng nhập nội dung đánh giá về sản phẩm.',
            'body.min'           => 'Nội dung đánh giá quá ít. Vui lòng nhập thêm nội dung đánh giá về sản phẩm.',
        ];
    }
}
