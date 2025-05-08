<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOrder;

use DB;

use Illuminate\Http\Request;

use Kalnoy\Nestedset\AncestorsRelation;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {   
        $products = Product::filter($request->all());
        
        $products->search($request->get('q'))->with([
            'productCategory',
        ]);

        $products->orderByDesc('id','desc');

        $result = $products->paginate($request->get('per_page', 30));

        
        return $result;


    }

    public static function sortProducts($products)
    {
        static::baseSortProducts($products);
    }

    /**
     * Sort list of the resource.
     *
     * @param Product|mixed $products
     */
    public static function baseSortProducts($products): void
    {
        // Sort products.
        $sortType = request('sort_type');
        $sortDirection = request('sort_direction', 'desc');

        // Get real price.
        $rawSql = '(
            CASE
                WHEN `flashsale_from` <= NOW() AND `flashsale_to` >= now() THEN `flashsale_price`
                WHEN `sale_price` IS NOT NULL AND `sale_price` != 0 AND ((`sale_from` IS NULL AND `sale_to` IS NULL) OR (`sale_from` <= NOW() AND `sale_to` >= NOW())) THEN `sale_price`
                ELSE `price`
            END
        )';

        $realPriceColumn = DB::raw($rawSql);
        $realPriceColumnAs = DB::raw('*, ' . $rawSql . ' AS `real_price`');

        switch ($sortType) {
            case 'price':
                $products->select($realPriceColumnAs)->orderBy('real_price', $sortDirection);
                break;
            case 'price_asc':
                $products->orderBy($realPriceColumn, 'asc');
                break;
            case 'price_desc':
                $products->orderBy($realPriceColumn, 'desc');
                break;
            case 'newest':
                $products->orderBy('updated_at', $sortDirection);
                break;
            case 'latest':
                $products->orderBy('created_at', $sortDirection);
                break;
            case 'top_rated':
                $products->orderBy('rate_count', $sortDirection)->orderBy('rate_star', $sortDirection);
                break;
            default:
                $order = [];
                $productCategory = array_filter(explode(',', request('product_categories')))[0] ?? [];

                if (!empty($productCategory)) {
                    $category = ProductCategory::with([
                        'ancestors' => function (AncestorsRelation $query) {
                            $query->select(['id', '_lft', '_rgt'])->orderByDesc('_lft');
                        },
                    ])->findOrFail($productCategory, ['id', '_lft', '_rgt']);

                    $ids = $category->ancestors->pluck('id')->prepend($category->id);

                    $order = ProductOrder::whereIn('product_category_id', $ids)
                        ->where('type', 'category')
                        ->orderBy(DB::raw('FIELD(`product_category_id`, ' . $ids->implode(', ') . ')'))
                        ->first();
                }

                if (!empty($order)) {
                    $products->orderByDesc(DB::raw('FIELD(`id`, ' . implode(',', array_reverse(explode(',', $order->orders))) . ')'));
                } else {
                    $products->orderBy('pin_to_top', $sortDirection)
                        ->orderBy(DB::raw('price - sale_price'), $sortDirection);
                }
                break;
        }
    }

}
