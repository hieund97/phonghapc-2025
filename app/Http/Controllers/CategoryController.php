<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryStore;
use App\Http\Requests\CategoryUpdate;
use Illuminate\Http\RedirectResponse;
use Str;
use Cache;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $this->authorize('categories.index');
        $currentCategory = null;
        $categories = Category::search($request->get('q'))
            ->with(implode('.', array_fill(0, 10, 'children')))
            ->whereNull('parent_id')
            ->paginate();

        if ($request->has('id')) {
            $currentCategory = Category::findOrFail($request->get('id'));
        }
        return view('categories.index', compact('categories', 'currentCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryStore  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryStore $request): RedirectResponse
    {
        $data = $request->validated();
        $category = Category::create($data);
        $this->storeExtraData($category, $data);

        Cache::pull('category_options');
        return redirect()
            ->back()
            ->with('success', __('Created category: :name', ['name' => $data['title']]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryUpdate  $request
     * @param  \App\Models\Category               $category
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryUpdate $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        $category->update($data);

        $this->storeExtraData($category, $data);

        Cache::pull('category_options');
        return redirect()
            ->back()
            ->with('success', __('Updated category: :name', ['name' => $data['title']]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     *
     * @return void
     */
    public function destroy(Category $category): void
    {
        $this->authorize('categories.destroy');
        Cache::pull('category_options');
        $category->delete();
    }

    /**
     * Store product extra data
     *
     * @param \App\Models\Category $post
     * @param array            $data
     *
     * @return void
     */
    public function storeExtraData(Category $category, array $data): void
    {
        // SEO
        if (!empty($category->seo)) {
            $category->seo()->update($data['seo']);
        } else {
            
            $category->seo()->create($data['seo']);
        
        }
    }
}
