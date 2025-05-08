<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandFilterStore;
use App\Http\Requests\BrandFilterUpdate;
use App\Models\ProductCategoryBrand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BrandFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('brand_filters.index', [
            'productCategoryBrands' => ProductCategoryBrand::filter($request->all())
                ->with(['productCategory', 'brand'])
                ->orderByDesc('id')
                ->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('brand_filters.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\BrandFilterStore $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BrandFilterStore $request): RedirectResponse
    {
        ProductCategoryBrand::create($request->validated());

        return redirect()->route('brand_filters.index')->with('success', __('Success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('brand_filters.form', [
            'brandFilter' => ProductCategoryBrand::whereId($id)->firstOrFail(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\BrandFilterUpdate $request
     * @param int                                  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BrandFilterUpdate $request, $id): RedirectResponse
    {
        $model = ProductCategoryBrand::whereId($id)->firstOrFail();
        $model->update($request->validated());

        return redirect()->route('brand_filters.index')->with('success', __('Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     * @throws \Exception
     */
    public function destroy($id): void
    {
        ProductCategoryBrand::whereId($id)->delete();
    }
}
