<?php

namespace App\Http\Requests;

use App\Rules\ArrayPrimary;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->can('posts.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'               => 'required|string',
            'categories'          => 'required|array',
            'content'             => 'required|string',
            'excerpt'             => 'required|string',
            'slug'                => 'required|string|max:255|unique:posts,slug,' . $this->post->id,
            'author'              => 'nullable',
            'product_category_id' => 'nullable|integer',
            'status'              => 'required|string',
            'thumbnail'           => 'required|string',
            'products'            => 'nullable|array',
            'products.*'          => 'required|integer|exists:products,id',
            'post_tags'           => ['nullable', 'array', new ArrayPrimary('post_tags')],
            'seo'                 => 'nullable|array',
            'seo.title'           => 'nullable|string|max:100',
            'seo.keyword'         => 'nullable|string|max:255',
            'seo.canonical'       => 'nullable|string|max:255',
            'seo.description'     => 'nullable|string',
            'seo.image'           => 'nullable|string',
            'seo.robots'          => 'nullable|string',
            'seo.schema'          => 'nullable|string',
            'seo.index'           => 'nullable|boolean',
            'seo.nofollow'        => 'nullable|boolean',
            'seo.noimageindex'    => 'nullable|boolean',
            'seo.noindex'         => 'nullable|boolean',
            'seo.noarchive'       => 'nullable|boolean',
            'seo.nosnippet'       => 'nullable|boolean',
            'seo.follow'          => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'tags'        => array_filter(array_map('trim', explode(',', $this->tags))),
            'is_featured' => $this->is_featured ?? false,
            'is_video'    => $this->is_video ?? false,
            'slug'        => $this->slug ?: Str::slug(str_replace('/', '-', $this->title)),
        ]);
        if (empty($this->published_at)) {
            $this->merge([
                'published_at' => Carbon::now()->toDateTimeString(),
            ]);
        }
    }
}
