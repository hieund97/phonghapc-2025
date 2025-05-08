<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Str;

class ProductCategoryStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('product_categories.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'             => 'required|string|max:100',
            'description'       => 'nullable|string',
            'thumbnail'         => 'nullable|string',
            'icon'              => 'nullable|string',
            'slug'              => 'nullable|string|max:100|unique:product_categories',
            'parent_id'         => 'nullable|exists:product_categories,id',
            'ordering'          => 'nullable|int',
            'is_menu_top'       => 'nullable|boolean',
            'is_menu_home'      => 'nullable|boolean',
            'is_menu_bottom'    => 'nullable|boolean',
            'show_on_mobile'    => 'nullable|boolean',
            'show_on_promotion' => 'nullable|boolean',
            'is_build'          => 'nullable|int',
            'is_feature'        => 'nullable|int',
            'attribute.*.*'     => 'nullable|string',
            'level'             => 'nullable|int',
            'status'            => 'nullable|int',
            'posts'             => 'nullable',
            'seo'               => 'nullable|array',
            'seo.title'         => 'nullable|string|max:100',
            'seo.keyword'       => 'nullable|string|max:255',
            'seo.canonical'     => 'nullable|string|max:255',
            'seo.description'   => 'nullable|string',
            'seo.image'         => 'nullable|string',
            'seo.robots'        => 'nullable|string',
            'seo.schema'        => 'nullable|string',
            'seo.index'         => 'nullable|boolean',
            'seo.nofollow'      => 'nullable|boolean',
            'seo.noimageindex'  => 'nullable|boolean',
            'seo.noindex'       => 'nullable|boolean',
            'seo.noarchive'     => 'nullable|boolean',
            'seo.nosnippet'     => 'nullable|boolean',
            'seo.follow'        => 'nullable|boolean',
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
                'slug' => Str::slug($this->title),
            ]);
        }
    }
}
