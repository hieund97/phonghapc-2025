<?php

namespace App\Http\Requests;

use App\Models\Banner;
use Illuminate\Foundation\Http\FormRequest;

class BannerStore extends FormRequest
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
            'status' => 'required|boolean',
            'show_on_list' => 'required|boolean',
            'title' => 'required|string',
            'type' => 'required|string|in:' . implode(',', Banner::TYPE),
            'link' => 'required|string',
            'thumbnail' => 'required|string',
            'model' => 'required|string',
            'model_id' => 'required|string',
            'target' => 'nullable|string',
            'rel' => 'nullable|string',
            'id' => 'nullable|integer|exists:banners',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status ?? false,
            'show_on_list' => $this->show_on_list ?? false,
        ]);
    }
}
