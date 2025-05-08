<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AttributeUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('attribute.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'            => 'required|string|max:100|unique:categories,title,' . $this->route('attribute')->id,
            'description'      => 'nullable|string',
            'slug'             => 'required|string|max:100|unique:categories,slug,' . $this->route('attribute')->id,
            'status'           => 'required|string',
            'seo'              => 'nullable|array',
            'seo.title'        => 'nullable|string|max:100',
            'seo.keyword'      => 'nullable|string|max:255',
            'seo.canonical'    => 'nullable|string|max:255',
            'seo.description'  => 'nullable|string',
            'seo.image'        => 'nullable|string',
            'seo.robots'       => 'nullable|string',
            'seo.schema'       => 'nullable|string',
            'seo.index'        => 'nullable|boolean',
            'seo.nofollow'     => 'nullable|boolean',
            'seo.noimageindex' => 'nullable|boolean',
            'seo.noindex'      => 'nullable|boolean',
            'seo.noarchive'    => 'nullable|boolean',
            'seo.nosnippet'    => 'nullable|boolean',
            'seo.follow'       => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->slug ?: Str::slug($this->title),
        ]);
    }
}
