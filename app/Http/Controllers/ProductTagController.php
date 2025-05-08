<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use Illuminate\Http\Request;
use App\Http\Requests\ProductTagStore;
use App\Http\Requests\ProductTagUpdate;
use Illuminate\Http\RedirectResponse;
use Str;
use Cache;

class ProductTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $this->authorize('product_tags.index');
        $currentProductTag = null;
        $productTags = ProductTag::search($request->get('q'))
            ->paginate();

        if ($request->has('id')) {
            $currentProductTag = ProductTag::findOrFail($request->get('id'));
        }
        return view('product_tags.index', compact('productTags', 'currentProductTag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductTagStore  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductTagStore $request): RedirectResponse
    {
        $data = $request->validated();
        $productTag = ProductTag::create($data);
        $this->storeExtraData($productTag, $data);
        if (!empty($data['posts'])) {
            $productTag->posts()->attach($data['posts']);
        }

        Cache::pull('product_tag_options');
        return redirect()
            ->back()
            ->with('success', __('Created productTag: :name', ['name' => $data['title']]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductTagUpdate  $request
     * @param  \App\Models\ProductTag               $productTag
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductTagUpdate $request, ProductTag $productTag): RedirectResponse
    {
        $data = $request->validated();
        if($productTag->update($data)){
            $this->storeExtraData($productTag, $data);
            $productTag->posts()->sync($data['posts'] ?? []);
        }
        Cache::pull('product_tag_options');
        return redirect()
            ->back()
            ->with('success', __('Updated productTag: :name', ['name' => $data['title']]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductTag  $productTag
     *
     * @return void
     */
    public function destroy(ProductTag $productTag): void
    {
        $this->authorize('product_tags.destroy');
        $productTag->delete();
    }

    /**
     * Store product extra data
     *
     * @param \App\Models\ProductTag $post
     * @param array            $data
     *
     * @return void
     */
    public function storeExtraData(ProductTag $productTag, array $data): void
    {
        // SEO
        if (!empty($productTag->seo)) {
            $productTag->seo()->update($data['seo']);
        } else {
            $productTag->seo()->create($data['seo']);

        }
    }
}
