<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class SortProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('product_categories.index');

        $cateHome = ProductCategory::with('products')->where('is_menu_home', true)->orderBy('ordering_menu_home')->get([
            'id',
            'title',
            'ordering_menu_home'
        ]);
        //$cateHome = $cateHomePreparation->pluck('id');
        $cateFeature = ProductCategory::with('products')->where('is_feature', true)->orderBy('ordering_menu_top')->get([
            'id',
            'title',
            'ordering_menu_top'
        ]);
        $cateBuildPC = ProductCategory::with('products')->where('is_build', true)->orderBy('ordering_menu_build')->get([
            'id',
            'title',
            'ordering_menu_build'
        ]);

        return view('sort_product_category.index', compact('cateHome', 'cateFeature', 'cateBuildPC'));
    }

    public function quickUpdate(Request $request)
    {
        $this->authorize('product_categories.update');
        $type       = $request['ordering'];
        $value      = $request['value'];
        $id         = $request['id'];
        $dataUpdate = [$type => $value];
        $result     = ProductCategory::where('id', $id)
                                     ->update($dataUpdate)
        ;
        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function quickUpdateProduct(Request $request)
    {
        $this->authorize('products.update');
        $type       = $request['type'];
        $value      = $request['value'];
        $id         = $request['id'];
        $dataUpdate = [$type => $value];
        $result     = Product::where('id', $id)->update($dataUpdate);

        if ($result) {
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function getProductByCateId(Request $request)
    {
        $isShowMore  = true;
        $aryProducts = Product::where('product_category_id', $request['id'])->where('show_on_top',
            1)->orderBy('ordering_in_cate')->paginate(10);
        $lastPage    = $aryProducts->lastPage();
        if ($request->page == $lastPage) {
            $isShowMore = false;
        }

        $view = view('sort_product_category.partials.product_of_category',
            compact('aryProducts', 'lastPage'))->render();

        return response()->json(['isShowMore' => $isShowMore, 'htmlView' => $view], 200);
    }
}
