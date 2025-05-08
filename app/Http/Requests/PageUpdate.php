<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageUpdate extends FormRequest
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
            'title' => 'required|string|max:100|unique:pages,title,' . $this->page->id,
            'content' => 'required|string',
            'slug' => 'required|alpha_dash|max:100|unique:pages,slug,' . $this->page->id,
            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string|max:100',
            'seo.keyword' => 'nullable|string|max:255',
            'seo.canonical' => 'nullable|string|max:255',
            'seo.description' => 'nullable|string',
            'seo.image' => 'nullable|string',
            'seo.robots' => 'nullable|string',
            'seo.schema' => 'nullable|string',
            'seo.index' => 'nullable|boolean',
            'seo.nofollow' => 'nullable|boolean',
            'seo.noimageindex' => 'nullable|boolean',
            'seo.noindex' => 'nullable|boolean',
            'seo.noarchive' => 'nullable|boolean',
            'seo.nosnippet' => 'nullable|boolean',
            'seo.follow' => 'nullable|boolean',
        ];
    }
}
