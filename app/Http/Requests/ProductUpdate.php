<?php

namespace App\Http\Requests;

use App\Rules\ArrayPrimary;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Str;

class ProductUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('products.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'                    => 'required|string|max:255|unique:products,name,' . $this->product,
            'suffix'                  => 'nullable|string|max:50',
            'price'                   => 'required|integer|min:0|max:9999999999',
            'hide_price_label'        => 'nullable|string|max:50',
            'sale_price'              => 'nullable|required_with:sale_from,sale_to|integer|min:0|max:9999999999',
            'sale_from'               => 'nullable|required_with:sale_to|date_format:Y-m-d H:i:s',
            'sale_to'                 => 'nullable|required_with:sale_from|date_format:Y-m-d H:i:s',
            'author'                  => 'nullable|string',
            'hide_sale_time'          => 'required|boolean',
            'published_at'            => 'required|date_format:Y-m-d H:i:s',
            'serial'                  => 'nullable|string|max:255|unique:products,serial,' . $this->product,
            'brand_id'                => 'nullable|integer|exists:brands,id',
            'technical_specification' => 'nullable|string',
            'description'             => 'required|string',
            'picture'                 => 'required|string',
            'real_images'             => 'nullable|string',
            'real_images.*'           => 'required|string',
            'show_on_top'             => 'required|boolean',
            'banner'                  => 'nullable|string',
            'pin_to_top'              => 'required|boolean',
            'include_in_box'          => 'nullable|array',
            'slug'                    => 'required|string|max:255|unique:products,slug,' . $this->product,
            'status_note'             => 'nullable|string',
            'attr'                    => 'nullable',
            'config'                  => 'nullable|array',
            'attr.*.*'                => 'nullable|integer',
            'outstanding_features'    => 'nullable|string',
            'gift_product'            => 'nullable|string',
            'view_count'              => 'nullable|numeric',
            'status_note_color'       => [
                'nullable',
                'string',
                'regex:/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3}),#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/',
            ],
            'warranty'                => 'nullable|string',
            'feature_img'             => 'required|string',
            'border_image'            => 'nullable|string',
            'is_border'               => 'nullable|boolean',
            'status'                  => 'required|integer|in:' . implode(',',
                    array_keys(config('admin.product_status'))),
            'product_category_id.*'   => 'required|integer|exists:product_categories,id',
            'videos'                  => 'nullable|array',
            'videos.*.title'          => 'required|string',
            'videos.*.url'            => 'required|string',
            'relates'                 => 'nullable|array',
            'relates.*'               => 'required|integer',
            'similars'                => 'nullable|array',
            'similars.*'              => 'required|integer',
            'skus'                    => 'nullable|string',
            'product_tags'            => ['nullable', 'array', new ArrayPrimary('product_tags')],
            'posts'                   => 'nullable',
            'seo'                     => 'nullable|array',
            'seo.title'               => 'nullable|string|max:500',
            'seo.keyword'             => 'nullable|string|max:500',
            'seo.canonical'           => 'nullable|string|max:500',
            'seo.description'         => 'nullable|string',
            'seo.image'               => 'nullable|string',
            'seo.robots'              => 'nullable|string',
            'seo.schema'              => 'nullable|string',
            'seo.index'               => 'nullable|boolean',
            'seo.nofollow'            => 'nullable|boolean',
            'seo.noimageindex'        => 'nullable|boolean',
            'seo.noindex'             => 'nullable|boolean',
            'seo.noarchive'           => 'nullable|boolean',
            'seo.nosnippet'           => 'nullable|boolean',
            'seo.follow'              => 'nullable|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (empty($this->slug)) {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        }

        if (empty($this->published_at)) {
            $this->merge([
                'published_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

        $aryConfig = [];

        if (
            !empty($this->config_name)
        ) {
            foreach ($this->config_name as $index => $name) {
                $aryConfig[$index] = [
                    'name'               => $name ?? null,
                    'price'              => number_input($this->config_price[$index]) ?? 0,
                    'sale_price'         => number_input($this->config_sale_price[$index]) ?? 0,
                    'config_description' => $this->config_description[$index] ?? null,
                    'config_img'         => $this->config_img[$index] ?? null,
                ];
            }
        }

        $this->merge([
            'config' => $aryConfig
        ]);

        $saleTime = array_filter(explode(' - ', $this->sale_time));

        if (count($saleTime) !== 2) {
            $saleTime = [null, null];
        }

        $this->merge([
            'price'      => number_input($this->price),
            'sale_price' => number_input($this->sale_price) ?: null,
            'sale_from'  => $saleTime[0],
            'sale_to'    => $saleTime[1],
        ]);

        $this->merge([
            'hide_sale_time' => !empty($this->hide_sale_time),
            'show_on_top'    => !empty($this->show_on_top),
            'is_border'      => !empty($this->is_border),
            'pin_to_top'     => !empty($this->pin_to_top),
            'videos'         => !empty($this->videos) && is_array($this->videos) ? array_values($this->videos) : null,
            'tags'           => array_filter(array_map('trim', explode(',', $this->tags))),
        ]);
    }
}
