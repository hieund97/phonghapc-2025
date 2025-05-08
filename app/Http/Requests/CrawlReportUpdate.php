<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrawlReportUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('crawl_report.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'              => 'required|numeric',
            'url'               => 'required|string|url',
            'product_new_price' => 'required',
            'product_new_name'  => 'required|string',
            'product_new_image' => 'required|string',
            'product_id'        => 'required|numeric',
            'status'            => 'required|numeric',
            'follow'            => 'required|numeric',
        ];
    }
}
