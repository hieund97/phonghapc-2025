<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandOrder;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use App\Http\Requests\BrandStore;
use App\Http\Requests\BrandUpdate;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('brands.index');

        $productCategories =  ProductCategory::where('parent_id', '=', null)->get();
        $brands = Brand::search($request->get('q'))->with('productCategory')->orderBy('id', 'DESC')->paginate();
        return view('brands.index', compact('brands', 'productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('brands.store');

        $productCategories =  ProductCategory::where('parent_id', '=', null)->get();
        return view('brands.form', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\\BrandStore  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandStore $request)
    {
        $brand = Brand::create($request->validated());

        return redirect()->route('brands.index')->with('success', __('Created brand: :title', ['title' => $brand->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand        $brand
     *
     * @return mixed
     */
    public function edit(Request $request, Brand $brand)
    {
        $this->authorize('brands.update');

        $productCategories =  ProductCategory::where('parent_id', '=', null)->get();
        return view('brands.form', compact('brand', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BrandUpdate  $request
     * @param  \App\Models\Brand               $brand
     *
     * @return mixed
     */
    public function update(BrandUpdate $request, Brand $brand)
    {
        $brand->update($request->validated());

        return redirect()->route('brands.index')->with('success', __('Updated brand: :title', ['title' => $brand->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \App\Models\Brand             $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Brand $brand)
    {
        $this->authorize('brands.destroy');

        $brand->delete();
    }

    public function destroyOrder($order)
    {
        $order = \App\Models\BrandOrder::findOrFail($order);
        $order->delete();
    }

    public function brands(Request $request)
    {
        $productCategory = ProductCategory::with(['descendants:id,parent_id,_lft,_rgt'])->findOrFail($request->get('id'));

        $products = Product::ignoreGlobalEagerLoading()
            ->with('brand:id,title')
            ->where('brand_id', '>', 0)
            ->whereIn('product_category_id', array_merge($productCategory->descendants->pluck('id')->toArray(), [$productCategory->id]))
            ->get(['id', 'brand_id', 'product_category_id']);

        $products->each->setAppends([]);

        return $products->pluck('brand')->unique()->values();
    }

    public function brandOrder(BrandOrder $request)
    {
        $brandOrder = \App\Models\BrandOrder::whereProductCategoryId($category = $request->get('product_category_id'))->first();

        if (empty($brandOrder)) {
            $brandOrder = new \App\Models\BrandOrder;
            $brandOrder->product_category_id = $category;
        }

        $brandOrder->order = $request->get('order');
        $brandOrder->save();
    }
}
